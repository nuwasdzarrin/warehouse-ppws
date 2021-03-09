<?php

namespace App\Http\Controllers;

use App\Fields\Select2Ajax;
use App\Product;
use App\TransactionIn ;
use App\TransactionStatus;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * TransactionInController
 */
class TransactionInController extends Controller
{
    /**
     * Relations
     * @param  \Illuminate\Http\Request|null $request
     * @param TransactionIn $transaction_in
     * @return array
     */
    public static function relations(Request $request = null, TransactionIn $transaction_in = null)
    {
        return [
            'transaction' => [
                'belongsToMany' => [], // also for morphToMany
                'hasMany' => [
                    //[ 'name' => 'children', 'label' => ucwords(__('transactions.children')) ],
                ], // also for morphMany, hasManyThrough
                'hasOne' => [
                    //[ 'name' => 'child', 'label' => ucwords(__('transactions.child')) ],
                ], // also for morphOne
            ]
        ];
    }

    /**
     * Visibles
     * @param  \Illuminate\Http\Request|null $request
     * @param TransactionIn $transaction_in
     * @return array
     */
    public static function visibles(Request $request = null, TransactionIn $transaction_in = null)
    {
        return [
            'index' => [
                'transaction' => [
                    //[ 'name' => 'parent', 'label' => ucwords(__('transactions.parent')), 'column' => 'name' ], // Only support belongsTo, hasOne
                    [ 'name' => 'created_at_for_human', 'label' => ucwords(__('transactions.created_at')) ],
                    [ 'name' => 'product', 'label' => ucwords(__('products.singular')), 'column' => 'name' ],
                    [ 'name' => 'transaction_status', 'label' => ucwords(__('transaction_statuses.singular')), 'column' => 'name' ],
                    [ 'name' => 'user', 'label' => ucwords(__('users.singular')), 'column' => 'name' ],
                    [ 'name' => 'officer', 'label' => ucwords(__('transactions.officer')) ],
                    [ 'name' => 'amount', 'label' => ucwords(__('transactions.amount')) ],
                    [ 'name' => 'noted', 'label' => ucwords(__('transactions.noted')) ],
                ]
            ],
            'show' => [
                'transaction' => [
                    //[ 'name' => 'parent', 'label' => ucwords(__('transactions.parent')), 'column' => 'name' ], // Only support belongsTo, hasOne
                    [ 'name' => 'created_at_for_human', 'label' => ucwords(__('transactions.created_at')) ],
                    [ 'name' => 'product', 'label' => ucwords(__('products.singular')), 'column' => 'name' ],
                    [ 'name' => 'transaction_status', 'label' => ucwords(__('transaction_statuses.singular')), 'column' => 'name' ],
                    [ 'name' => 'user', 'label' => ucwords(__('users.singular')), 'column' => 'name' ],
                    [ 'name' => 'officer', 'label' => ucwords(__('transactions.officer')) ],
                    [ 'name' => 'amount', 'label' => ucwords(__('transactions.amount')) ],
                    [ 'name' => 'noted', 'label' => ucwords(__('transactions.noted')) ],
                    [ 'name' => 'picture_html', 'label' => ucwords(__('transactions.picture')) ],
                ]
            ]
        ];
    }

    /**
     * Fields
     * @param  \Illuminate\Http\Request|null $request
     * @param TransactionIn $transaction_in
     * @return array
     */
    public static function fields(Request $request = null, TransactionIn $transaction_in = null)
    {
        return [
            'create' => [
                'transaction' => [
                    //[ 'field' => 'select', 'name' => 'parent_id', 'label' => ucwords(__('transactions.parent')), 'required' => true, 'options' => \App\Parent::filter()->get()->map(function ($parent) {
                    //    return [ 'value' => $parent->id, 'text' => $parent->name ];
                    //})->prepend([ 'value' => '', 'text' => '-' ])->toArray() ],
//                    'product' => (new Select2Ajax(Product::class))
//                        ->setTextProperty('name')
//                        ->setDelayAjax(750)
//                        ->setParams(['institution_id' => $request->cookie('institution_id')])
//                        ->setValueFromModel($transaction_in)->toArray(),
//                    'transaction_status' => (new Select2Ajax(TransactionStatus::class))
//                        ->setTextProperty('name')
//                        ->setDelayAjax(750)
//                        ->setParams(['type' => 'in'])
//                        ->setValueFromModel($transaction_in)->toArray(),
//                    [ 'field' => 'input', 'type' => 'text', 'name' => 'user_id', 'label' => ucwords(__('transactions.user')), 'placeholder'=>auth()->user()->name, 'disabled' => true],
//                    [ 'field' => 'input', 'type' => 'text', 'name' => 'officer', 'label' => ucwords(__('transactions.officer')), 'required' => true ],
//                    [ 'field' => 'input', 'type' => 'text', 'name' => 'amount', 'label' => ucwords(__('transactions.amount')), 'required' => true ],
//                    [ 'field' => 'textarea', 'type' => 'text', 'name' => 'noted', 'label' => ucwords(__('transactions.noted')) ],
//                    [ 'field' => 'input', 'type' => 'file', 'name' => 'picture', 'label' => ucwords(__('transactions.picture')) ],
                ]
            ],
            'edit' => [
                'transaction' => [
                    //[ 'field' => 'select', 'name' => 'parent_id', 'label' => ucwords(__('transactions.parent')), 'options' => \App\Parent::filter()->get()->map(function ($parent) {
                    //    return [ 'value' => $parent->id, 'text' => $parent->name ];
                    //})->prepend([ 'value' => '', 'text' => '-' ])->toArray() ],
//                    'product' => (new Select2Ajax(Product::class))
//                        ->setTextProperty('name')
//                        ->setDelayAjax(750)
//                        ->setParams(['institution_id' => $request->cookie('institution_id')])
//                        ->setValueFromModel($transaction_in)->toArray(),
//                    'transaction_status' => (new Select2Ajax(TransactionStatus::class))
//                        ->setTextProperty('name')
//                        ->setDelayAjax(750)
//                        ->setValueFromModel($transaction_in)
//                        ->toArray(),
//                    'user' => (new Select2Ajax(User::class))
//                        ->setTextProperty('name')
//                        ->setDelayAjax(750)
//                        ->setValueFromModel($transaction_in)
//                        ->setDisabled(true)
//                        ->toArray(),
//                    [ 'field' => 'input', 'type' => 'text', 'name' => 'officer', 'label' => ucwords(__('transactions.officer')) ],
//                    [ 'field' => 'input', 'type' => 'text', 'name' => 'amount', 'label' => ucwords(__('transactions.amount')) ],
//                    [ 'field' => 'textarea', 'type' => 'text', 'name' => 'noted', 'label' => ucwords(__('transactions.noted')) ],
//                    [ 'field' => 'input', 'type' => 'file', 'name' => 'picture', 'label' => ucwords(__('transactions.picture')) ],
                ]
            ]
        ];
    }

    /**
     * Rules
     * @param  \Illuminate\Http\Request|null $request
     * @param TransactionIn $transaction_in
     * @return array
     */
    public static function rules(Request $request = null, TransactionIn $transaction_in = null)
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
                'transaction_status_id' => 'required|exists:transaction_statuses,id',
                'officer' => 'required|string|max:255',
                'amount' => 'required|numeric|min:1',
                'noted' => 'string|max:255|nullable',
                'picture' => 'mimes:jpeg,jpg,png,bmp,gif,svg|max:2048|nullable',
            ],
            'update' => [
                //'parent_id' => 'exists:parents,id',
                'product_id' => 'exists:products,id',
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
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $institution_id = request()->cookie('institution_id');

        $transactions = TransactionIn::query()->when(auth()->user()->hasRole(['superadmin']), function (Builder $query) use ($institution_id) {
            return $query->where($query->qualifyColumn('institution_id'), $institution_id);
        })->filter()->paginate()->appends(request()->query());
        $this->authorize('index', 'App\TransactionIn ');

        return response()->view('transaction_ins.index', [
            'transactions' => $transactions,
            'relations' => self::relations(request()),
            'visibles' => self::visibles(request())['index']
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', 'App\TransactionIn ');

        return response()->view('transaction_ins.create', [
            'fields' => self::fields(request())['create']
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('create', 'App\TransactionIn ');
        $request->validate(self::rules($request)['store']);
        foreach (self::rules($request)['hasMany'] as $key => $rule)
            $request->validate(array_merge([ $key => 'array' ], $rule));
        foreach (self::rules($request)['hasOne'] as $key => $rule)
            $request->validate(array_merge([ $key => 'array' ], $rule));

//        check stock condition
        $product = Product::query()->findOrFail($request->product_id);
        if ($product) {
            $product->stock = $product->stock +  $request->amount;
            $product->save();
        } else throw new HttpException(403, ucfirst('Barang tidak diketemukan di master data'));

        $transaction_in = new TransactionIn ;
        foreach (self::rules($request)['store'] as $key => $value) {
            if (Str::contains($value, [ 'file', 'image', 'mimetypes', 'mimes' ])) {
                if ($request->hasFile($key)) {
                    $transaction_in->{$key} = $request->file($key)->store('transactions');
                } elseif ($request->exists($key)) {
                    $transaction_in->{$key} = $request->{$key};
                }
            } elseif ($request->exists($key)) {
                $transaction_in->{$key} = $request->{$key};
            }
        }
        $transaction_in->in_out = 'in';
        $transaction_in->user_id = auth()->user()->getKey();
        $transaction_in->institution_id = $request->cookie('institution_id');

        $deletedModels = [];
        $hasMany = [];
        foreach (self::rules($request)['hasMany'] as $key => $rule) {
            $hasMany[$key] = [];
            if ($request->exists($key)) {
                /** @var Model $model */
                $model = $transaction_in->{$key}()->getRelated();
                /** @var Collection $models */
                $models = $model->newQuery()->findMany(collect($request->all()[$key] ?? [])->map(function ($data) use($model) {
                    return $data[$model->getKeyName()] ?? null;
                })->filter());
                foreach ($request->all()[$key] ?? [] as $index => $data) {
                    /** @var Model $model */
                    $model = $transaction_in->{$key}()->getRelated();
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
                $model = $transaction_in->{$key}()->getRelated();
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
            $transaction_in->save();
            foreach (self::rules($request)['hasMany'] as $key => $rule) {
                if (!$request->exists($key)) continue;
                $models = $transaction_in->{$key}()->saveMany($hasMany[$key]);
                $transaction_in->setRelation($key, new Collection($models));
            }
            foreach (self::rules($request)['hasOne'] as $key => $rule) {
                if (!$request->exists($key) || empty($hasOne[$key])) continue;
                $model = $transaction_in->{$key}()->save($hasOne[$key]);
                $transaction_in->setRelation($key, $model);
            }
            foreach ($deletedModels as $model) $model->delete();
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            return back()->withInput()->with('status', $exception->getMessage())->with('status-type', 'danger');
        }

        if (request()->filled('redirect') && starts_with(request()->redirect, request()->root()))
            $response = response()->redirectTo(request()->redirect);
        else
            $response = response()->redirectToRoute('transaction_ins.show', $transaction_in->getKey());

        return $response->withInput([ $transaction_in->getForeignKey() => $transaction_in->getKey() ])
            ->with('status', __('Success'));
    }

    /**
     * Display the specified resource.
     *
     * @param TransactionIn $transaction_in
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(TransactionIn $transaction_in)
    {
        $this->authorize('view', $transaction_in);

        return response()->view('transaction_ins.show', [
            'transaction' => $transaction_in,
            'relations' => self::relations(request(), $transaction_in),
            'visibles' => self::visibles(request(), $transaction_in)['show'],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TransactionIn $transaction_in
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(TransactionIn $transaction_in)
    {
        $this->authorize('update', $transaction_in);

        return response()->view('transaction_ins.edit', [
            'transaction' => $transaction_in,
            'fields' => self::fields(request(), $transaction_in)['edit']
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param TransactionIn $transaction_in
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, TransactionIn $transaction_in)
    {
        $this->authorize('update', $transaction_in);
        $request->validate(self::rules($request, $transaction_in)['update']);
        foreach (self::rules($request, $transaction_in)['hasMany'] as $key => $rule)
            $request->validate(array_merge([ $key => 'array' ], $rule));
        foreach (self::rules($request, $transaction_in)['hasOne'] as $key => $rule)
            $request->validate(array_merge([ $key => 'array' ], $rule));

        foreach (self::rules($request, $transaction_in)['update'] as $key => $value) {
            if (Str::contains($value, [ 'file', 'image', 'mimetypes', 'mimes' ])) {
                if ($request->hasFile($key)) {
                    $transaction_in->{$key} = $request->file($key)->store('transactions');
                } elseif ($request->exists($key)) {
                    $transaction_in->{$key} = $request->{$key};
                }
            } elseif ($request->exists($key)) {
                $transaction_in->{$key} = $request->{$key};
            }
        }

        $deletedModels = [];
        $hasMany = [];
        foreach (self::rules($request, $transaction_in)['hasMany'] as $key => $rule) {
            $hasMany[$key] = [];
            if ($request->exists($key)) {
                /** @var Model $model */
                $model = $transaction_in->{$key}()->getRelated();
                /** @var Collection $models */
                $models = $model->newQuery()->findMany(collect($request->all()[$key] ?? [])->map(function ($data) use($model) {
                    return $data[$model->getKeyName()] ?? null;
                })->filter());
                foreach ($request->all()[$key] ?? [] as $index => $data) {
                    /** @var Model $model */
                    $model = $transaction_in->{$key}()->getRelated();
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
        foreach (self::rules($request, $transaction_in)['hasOne'] as $key => $rule) {
            if ($request->exists($key)) {
                /** @var Model $model */
                $model = $transaction_in->{$key}()->getRelated();
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
            $transaction_in->save();
            foreach (self::rules($request, $transaction_in)['hasMany'] as $key => $rule) {
                if (!$request->exists($key)) continue;
                $models = $transaction_in->{$key}()->saveMany($hasMany[$key]);
                $transaction_in->setRelation($key, new Collection($models));
            }
            foreach (self::rules($request, $transaction_in)['hasOne'] as $key => $rule) {
                if (!$request->exists($key) || empty($hasOne[$key])) continue;
                $model = $transaction_in->{$key}()->save($hasOne[$key]);
                $transaction_in->setRelation($key, $model);
            }
            foreach ($deletedModels as $model) $model->delete();
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            return back()->withInput()->with('status', $exception->getMessage())->with('status-type', 'danger');
        }

        if (request()->filled('redirect') && starts_with(request()->redirect, request()->root()))
            $response = response()->redirectTo(request()->redirect);
        else
            $response = response()->redirectToRoute('transaction_ins.show', $transaction_in->getKey());

        return $response->withInput([ $transaction_in->getForeignKey() => $transaction_in->getKey() ])
            ->with('status', __('Success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TransactionIn $transaction_in
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(TransactionIn $transaction_in)
    {
        $this->authorize('delete', $transaction_in);

        //        check stock condition
        $product = Product::query()->findOrFail($transaction_in->product_id);
        if ($product) {
            if ($product->stock < $transaction_in->amount)
                throw new HttpException(403, ucfirst('Stok Untuk '.$product->name.' tidak mencukupi'));
            else {
                $product->stock = $product->stock -  $transaction_in->amount;
                $product->save();
            }

        } else throw new HttpException(403, ucfirst('Barang tidak diketemukan di master data'));

        $transaction_in->delete();

        if (request()->filled('redirect') && starts_with(request()->redirect, request()->root()) && !Str::contains(request()->redirect, '/transaction_ins/'.$transaction_in->getKey()))
            $response = response()->redirectTo(request()->redirect);
        else
            $response = response()->redirectToRoute('transaction_ins.index');

        return $response->with('status', __('Success'));
    }
}
