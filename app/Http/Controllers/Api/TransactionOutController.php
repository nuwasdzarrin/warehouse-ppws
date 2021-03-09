<?php

namespace App\Http\Controllers\Api;

use App\Product;
use App\TransactionOut;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\Resource;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * TransactionOutController
 * @extends Controller
 */
class TransactionOutController extends Controller
{
    /**
     * Rules
     * @param  \Illuminate\Http\Request|null $request
     * @param TransactionOut $transaction_out
     * @return array
     */
    public static function rules(Request $request = null, TransactionOut $transaction_out = null)
    {
        return [
            'hasMany' => [
                //'relations' => [
                //    'relations.*.name' => 'required_without:relations.*.id|string|max:255'
                //]
            ],
            'hasOne' => [
                //'relation' => [
                //    'relation.name' => 'required_without:relation.id|string|max:255'
                //]
            ],
            'store' => [
                //'parent_id' => 'required|exists:parents,id',
                'product_id' => 'required|exists:products,id',
                'institution_id' => 'required|exists:institutions,id',
                'transaction_status_id' => 'required|exists:transaction_statuses,id',
                'officer' => 'required|string|max:255',
                'amount' => 'required|numeric|min:1',
                'noted' => 'string|max:255|nullable',
                'picture' => 'mimes:jpeg,jpg,png,bmp,gif,svg|max:2048|nullable',
            ],
            'update' => [
                //'parent_id' => 'exists:parents,id',
                'product_id' => 'exists:products,id',
                'institution_id' => 'exists:institutions,id',
                'transaction_status_id' => 'exists:product_categories,id',
                'officer' => 'string|max:255',
                'amount' => 'numeric|min:1',
                'noted' => 'string|max:255|nullable',
                'picture' => 'mimes:jpeg,jpg,png,bmp,gif,svg|max:2048|nullable',
            ]
        ];
    }

    /**
    * Instantiate a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $institution_id = request()->filled('institution_id')?\request()->institution_id:null;

        $transaction_outs = TransactionOut::query()->when($institution_id, function (Builder $query) use ($institution_id) {
            return $query->where('institution_id', $institution_id);
        })->filter()->paginate()->appends(request()->query());
//        $this->authorize('index', 'App\TransactionOut');

        return Resource::collection($transaction_outs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('create', 'App\TransactionOut');
        $request->validate(self::rules($request)['store']);
        foreach (self::rules($request)['hasMany'] as $key => $rule)
            $request->validate(array_merge([ $key => 'array' ], $rule));
        foreach (self::rules($request)['hasOne'] as $key => $rule)
            $request->validate(array_merge([ $key => 'array' ], $rule));

//        check stock condition
        $product = Product::query()->findOrFail($request->product_id);
        if ($product) {
            if ($product->stock < $request->amount)
                throw new HttpException(403, ucfirst('Stok Untuk '.$product->name.' tidak mencukupi'));
            else {
                $product->stock = $product->stock -  $request->amount;
                $product->save();
            }

        } else throw new HttpException(403, ucfirst('Barang tidak diketemukan di master data'));

        $transaction_out = new TransactionOut;
        foreach (self::rules($request)['store'] as $key => $value) {
            if (Str::contains($value, [ 'file', 'image', 'mimetypes', 'mimes' ])) {
                if ($request->hasFile($key)) {
                    $transaction_out->{$key} = $request->file($key)->store('transaction_outs');
                } elseif ($request->exists($key)) {
                    $transaction_out->{$key} = $request->{$key};
                }
            } elseif ($request->exists($key)) {
                $transaction_out->{$key} = $request->{$key};
            }
        }
        $transaction_out->in_out = 'out';
        $transaction_out->user_id = auth()->user()->getKey();

        $deletedModels = [];
        $hasMany = [];
        foreach (self::rules($request)['hasMany'] as $key => $rule) {
            $hasMany[$key] = [];
            if ($request->exists($key)) {
                /** @var Model $model */
                $model = $transaction_out->{$key}()->getRelated();
                /** @var Collection $models */
                $models = $model->newQuery()->findMany(collect($request->all()[$key] ?? [])->map(function ($data) use($model) {
                    return $data[$model->getKeyName()] ?? null;
                })->filter());
                foreach ($request->all()[$key] ?? [] as $index => $data) {
                    /** @var Model $model */
                    $model = $transaction_out->{$key}()->getRelated();
                    if (isset($data[$model->getKeyName()])) $model = $models->find($data[$model->getKeyName()]) ?: $model;
                    if (isset($data['_action']) && in_array($data['_action'], [ 'delete', 'destroy' ])) {
                        if ($model->exists) $deletedModels[] = $model;
                        continue;
                    }
                    foreach ($rule as $k => $value) {
                        $attribute = last(explode('.*.', $k));
                        $k = str_replace('*', $index, $k);
                        if (Str::contains($value, ['file', 'image', 'mimetypes', 'mimes'])) {
                            if ($request->hasFile($k)) {
                                $model->{$attribute} = $request->file($k)->store($key);
                            } elseif ($request->exists($k)) {
                                $model->{$attribute} = $request->input($k);
                            }
                        } elseif ($request->exists($k)) {
                            $model->{$attribute} = $request->input($k);
                        }
                    }
                    $hasMany[$key][] = $model;
                }
            }
        }
        $hasOne = [];
        foreach (self::rules($request)['hasOne'] as $key => $rule) {
            if ($request->exists($key)) {
                /** @var Model $model */
                $model = $transaction_out->{$key}()->getRelated();
                $data = $request->all()[$key];
                if (isset($data[$model->getKeyName()]))
                    $model = $model->newQuery()->find(($request->all()[$key] ?? [])[$model->getKeyName()] ?? null) ?: $model;
                if (isset($data['_action']) && in_array($data['_action'], [ 'delete', 'destroy' ])) {
                    if ($model->exists) $deletedModels[] = $model;
                    continue;
                }
                foreach ($rule as $k => $value) {
                    $attribute = last(explode('.', $k));
                    if (Str::contains($value, ['file', 'image', 'mimetypes', 'mimes'])) {
                        if ($request->hasFile($k)) {
                            $model->{$attribute} = $request->file($k)->store($key);
                        } elseif ($request->exists($k)) {
                            $model->{$attribute} = $request->input($k);
                        }
                    } elseif ($request->exists($k)) {
                        $model->{$attribute} = $request->input($k);
                    }
                }
                $hasOne[$key] = $model;
            }
        }

        try {
            DB::beginTransaction();
            $transaction_out->save();
            foreach (self::rules($request)['hasMany'] as $key => $rule) {
                if (!$request->exists($key)) continue;
                $models = $transaction_out->{$key}()->saveMany($hasMany[$key]);
                $transaction_out->setRelation($key, new Collection($models));
            }
            foreach (self::rules($request)['hasOne'] as $key => $rule) {
                if (!$request->exists($key) || empty($hasOne[$key])) continue;
                $model = $transaction_out->{$key}()->save($hasOne[$key]);
                $transaction_out->setRelation($key, $model);
            }
            foreach ($deletedModels as $model) $model->delete();
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw new HttpException(500, $exception->getMessage(), $exception);
        }

        return (new Resource($transaction_out))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param TransactionOut $transaction_out
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(TransactionOut $transaction_out)
    {
        $this->authorize('view', $transaction_out);

        return new Resource($transaction_out);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param TransactionOut $transaction_out
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, TransactionOut $transaction_out)
    {
        $this->authorize('update', $transaction_out);
        $request->validate(self::rules($request, $transaction_out)['update']);
        foreach (self::rules($request, $transaction_out)['hasMany'] as $key => $rule)
            $request->validate(array_merge([ $key => 'array' ], $rule));
        foreach (self::rules($request, $transaction_out)['hasOne'] as $key => $rule)
            $request->validate(array_merge([ $key => 'array' ], $rule));

//        check stock condition
        $product = Product::query()->findOrFail($request->product_id);
        if ($product) {
            if ($request->amount) {
                if (($product->stock + $request->amount_before) < $request->amount)
                    throw new HttpException(403, ucfirst('Stok Untuk '.$product->name.' tidak mencukupi'));
                else {
                    $product->stock = ($product->stock + $request->amount_before) -  $request->amount;
                    $product->save();
                }
            }
        } else throw new HttpException(403, ucfirst('Barang tidak diketemukan di master data'));

        foreach (self::rules($request, $transaction_out)['update'] as $key => $value) {
            if (Str::contains($value, [ 'file', 'image', 'mimetypes', 'mimes' ])) {
                if ($request->hasFile($key)) {
                    $transaction_out->{$key} = $request->file($key)->store('transaction_outs');
                } elseif ($request->exists($key)) {
                    $transaction_out->{$key} = $request->{$key};
                }
            } elseif ($request->exists($key)) {
                $transaction_out->{$key} = $request->{$key};
            }
        }

        $deletedModels = [];
        $hasMany = [];
        foreach (self::rules($request, $transaction_out)['hasMany'] as $key => $rule) {
            $hasMany[$key] = [];
            if ($request->exists($key)) {
                /** @var Model $model */
                $model = $transaction_out->{$key}()->getRelated();
                /** @var Collection $models */
                $models = $model->newQuery()->findMany(collect($request->all()[$key] ?? [])->map(function ($data) use($model) {
                    return $data[$model->getKeyName()] ?? null;
                })->filter());
                foreach ($request->all()[$key] ?? [] as $index => $data) {
                    /** @var Model $model */
                    $model = $transaction_out->{$key}()->getRelated();
                    if (isset($data[$model->getKeyName()])) $model = $models->find($data[$model->getKeyName()]) ?: $model;
                    if (isset($data['_action']) && in_array($data['_action'], [ 'delete', 'destroy' ])) {
                        if ($model->exists) $deletedModels[] = $model;
                        continue;
                    }
                    foreach ($rule as $k => $value) {
                        $attribute = last(explode('.*.', $k));
                        $k = str_replace('*', $index, $k);
                        if (Str::contains($value, ['file', 'image', 'mimetypes', 'mimes'])) {
                            if ($request->hasFile($k)) {
                                $model->{$attribute} = $request->file($k)->store($key);
                            } elseif ($request->exists($k)) {
                                $model->{$attribute} = $request->input($k);
                            }
                        } elseif ($request->exists($k)) {
                            $model->{$attribute} = $request->input($k);
                        }
                    }
                    $hasMany[$key][] = $model;
                }
            }
        }
        $hasOne = [];
        foreach (self::rules($request, $transaction_out)['hasOne'] as $key => $rule) {
            if ($request->exists($key)) {
                /** @var Model $model */
                $model = $transaction_out->{$key}()->getRelated();
                $data = $request->all()[$key];
                if (isset($data[$model->getKeyName()]))
                    $model = $model->newQuery()->find(($request->all()[$key] ?? [])[$model->getKeyName()] ?? null) ?: $model;
                if (isset($data['_action']) && in_array($data['_action'], [ 'delete', 'destroy' ])) {
                    if ($model->exists) $deletedModels[] = $model;
                    continue;
                }
                foreach ($rule as $k => $value) {
                    $attribute = last(explode('.', $k));
                    if (Str::contains($value, ['file', 'image', 'mimetypes', 'mimes'])) {
                        if ($request->hasFile($k)) {
                            $model->{$attribute} = $request->file($k)->store($key);
                        } elseif ($request->exists($k)) {
                            $model->{$attribute} = $request->input($k);
                        }
                    } elseif ($request->exists($k)) {
                        $model->{$attribute} = $request->input($k);
                    }
                }
                $hasOne[$key] = $model;
            }
        }

        try {
            DB::beginTransaction();
            $transaction_out->save();
            foreach (self::rules($request, $transaction_out)['hasMany'] as $key => $rule) {
                if (!$request->exists($key)) continue;
                $models = $transaction_out->{$key}()->saveMany($hasMany[$key]);
                $transaction_out->setRelation($key, new Collection($models));
            }
            foreach (self::rules($request, $transaction_out)['hasOne'] as $key => $rule) {
                if (!$request->exists($key) || empty($hasOne[$key])) continue;
                $model = $transaction_out->{$key}()->save($hasOne[$key]);
                $transaction_out->setRelation($key, $model);
            }
            foreach ($deletedModels as $model) $model->delete();
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw new HttpException(500, $exception->getMessage(), $exception);
        }

        return new Resource($transaction_out);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TransactionOut $transaction_out
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(TransactionOut $transaction_out)
    {
        $this->authorize('delete', $transaction_out);
        $transaction_out->delete();

        return new Resource($transaction_out);
    }
}
