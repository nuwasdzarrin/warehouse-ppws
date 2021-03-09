<?php

namespace App\Http\Controllers;

use App\TransactionStatus;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * TransactionStatusController
 */
class TransactionStatusController extends Controller
{
    /**
     * Relations
     * @param  \Illuminate\Http\Request|null $request
     * @param TransactionStatus $transaction_status
     * @return array
     */
    public static function relations(Request $request = null, TransactionStatus $transaction_status = null)
    {
        return [
            'transaction_status' => [
                'belongsToMany' => [], // also for morphToMany
                'hasMany' => [
                    //[ 'name' => 'children', 'label' => ucwords(__('transaction_statuses.children')) ],
                ], // also for morphMany, hasManyThrough
                'hasOne' => [
                    //[ 'name' => 'child', 'label' => ucwords(__('transaction_statuses.child')) ],
                ], // also for morphOne
            ]
        ];
    }

    /**
     * Visibles
     * @param  \Illuminate\Http\Request|null $request
     * @param TransactionStatus $transaction_status
     * @return array
     */
    public static function visibles(Request $request = null, TransactionStatus $transaction_status = null)
    {
        return [
            'index' => [
                'transaction_status' => [
                    //[ 'name' => 'parent', 'label' => ucwords(__('transaction_statuses.parent')), 'column' => 'name' ], // Only support belongsTo, hasOne
                    [ 'name' => 'name', 'label' => ucwords(__('transaction_statuses.name')) ],
                    [ 'name' => 'transaction_type', 'label' => ucwords(__('transaction_statuses.type')) ],
                ]
            ],
            'show' => [
                'transaction_status' => [
                    //[ 'name' => 'parent', 'label' => ucwords(__('transaction_statuses.parent')), 'column' => 'name' ], // Only support belongsTo, hasOne
                    [ 'name' => 'name', 'label' => ucwords(__('transaction_statuses.name')) ],
                    [ 'name' => 'transaction_type', 'label' => ucwords(__('transaction_statuses.type')) ],
                ]
            ]
        ];
    }

    /**
     * Fields
     * @param  \Illuminate\Http\Request|null $request
     * @param TransactionStatus $transaction_status
     * @return array
     */
    public static function fields(Request $request = null, TransactionStatus $transaction_status = null)
    {
        return [
            'create' => [
                'transaction_status' => [
                    //[ 'field' => 'select', 'name' => 'parent_id', 'label' => ucwords(__('transaction_statuses.parent')), 'required' => true, 'options' => \App\Parent::filter()->get()->map(function ($parent) {
                    //    return [ 'value' => $parent->id, 'text' => $parent->name ];
                    //})->prepend([ 'value' => '', 'text' => '-' ])->toArray() ],
                    [ 'field' => 'input', 'type' => 'text', 'name' => 'name', 'label' => ucwords(__('transaction_statuses.name')), 'required' => true ],
                    [ 'field' => 'select', 'type' => 'select', 'name' => 'type', 'label' => ucwords(__('transaction_statuses.type')), 'options' => collect([
                        [
                            'value' => 'in',
                            'text' => ucwords(__('transactions.singular')),
                        ],
                        [
                            'value' => 'out',
                            'text' => ucwords(__('transaction_outs.singular')),
                        ],
                    ]), 'required' => true ],
                ]
            ],
            'edit' => [
                'transaction_status' => [
                    //[ 'field' => 'select', 'name' => 'parent_id', 'label' => ucwords(__('transaction_statuses.parent')), 'options' => \App\Parent::filter()->get()->map(function ($parent) {
                    //    return [ 'value' => $parent->id, 'text' => $parent->name ];
                    //})->prepend([ 'value' => '', 'text' => '-' ])->toArray() ],
                    [ 'field' => 'input', 'type' => 'text', 'name' => 'name', 'label' => ucwords(__('transaction_statuses.name')) ],
                    [ 'field' => 'select', 'type' => 'select', 'name' => 'type', 'label' => ucwords(__('transaction_statuses.type')), 'options' => collect([
                        [
                            'value' => 'in',
                            'text' => ucwords(__('transactions.singular')),
                        ],
                        [
                            'value' => 'out',
                            'text' => ucwords(__('transaction_outs.singular')),
                        ],
                    ]) ],
                ]
            ]
        ];
    }

    /**
     * Rules
     * @param  \Illuminate\Http\Request|null $request
     * @param TransactionStatus $transaction_status
     * @return array
     */
    public static function rules(Request $request = null, TransactionStatus $transaction_status = null)
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
                'name' => 'required|string|max:255',
                'type' => 'required|string|max:255',
            ],
            'update' => [
                //'parent_id' => 'exists:parents,id',
                'name' => 'string|max:255',
                'type' => 'string|max:255',
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
        $transaction_statuses = TransactionStatus::filter()
            ->paginate()->appends(request()->query());
        $this->authorize('index', 'App\TransactionStatus');

        return response()->view('transaction_statuses.index', [
            'transaction_statuses' => $transaction_statuses,
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
        $this->authorize('create', 'App\TransactionStatus');

        return response()->view('transaction_statuses.create', [
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
        $this->authorize('create', 'App\TransactionStatus');
        $request->validate(self::rules($request)['store']);
        foreach (self::rules($request)['hasMany'] as $key => $rule)
            $request->validate(array_merge([ $key => 'array' ], $rule));
        foreach (self::rules($request)['hasOne'] as $key => $rule)
            $request->validate(array_merge([ $key => 'array' ], $rule));

        $transaction_status = new TransactionStatus;
        foreach (self::rules($request)['store'] as $key => $value) {
            if (Str::contains($value, [ 'file', 'image', 'mimetypes', 'mimes' ])) {
                if ($request->hasFile($key)) {
                    $transaction_status->{$key} = $request->file($key)->store('transaction_statuses');
                } elseif ($request->exists($key)) {
                    $transaction_status->{$key} = $request->{$key};
                }
            } elseif ($request->exists($key)) {
                $transaction_status->{$key} = $request->{$key};
            }
        }

        $deletedModels = [];
        $hasMany = [];
        foreach (self::rules($request)['hasMany'] as $key => $rule) {
            $hasMany[$key] = [];
            if ($request->exists($key)) {
                /** @var Model $model */
                $model = $transaction_status->{$key}()->getRelated();
                /** @var Collection $models */
                $models = $model->newQuery()->findMany(collect($request->all()[$key] ?? [])->map(function ($data) use($model) {
                    return $data[$model->getKeyName()] ?? null;
                })->filter());
                foreach ($request->all()[$key] ?? [] as $index => $data) {
                    /** @var Model $model */
                    $model = $transaction_status->{$key}()->getRelated();
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
                $model = $transaction_status->{$key}()->getRelated();
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
            $transaction_status->save();
            foreach (self::rules($request)['hasMany'] as $key => $rule) {
                if (!$request->exists($key)) continue;
                $models = $transaction_status->{$key}()->saveMany($hasMany[$key]);
                $transaction_status->setRelation($key, new Collection($models));
            }
            foreach (self::rules($request)['hasOne'] as $key => $rule) {
                if (!$request->exists($key) || empty($hasOne[$key])) continue;
                $model = $transaction_status->{$key}()->save($hasOne[$key]);
                $transaction_status->setRelation($key, $model);
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
            $response = response()->redirectToRoute('transaction_statuses.show', $transaction_status->getKey());

        return $response->withInput([ $transaction_status->getForeignKey() => $transaction_status->getKey() ])
            ->with('status', __('Success'));
    }

    /**
     * Display the specified resource.
     *
     * @param TransactionStatus $transaction_status
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(TransactionStatus $transaction_status)
    {
        $this->authorize('view', $transaction_status);

        return response()->view('transaction_statuses.show', [
            'transaction_status' => $transaction_status,
            'relations' => self::relations(request(), $transaction_status),
            'visibles' => self::visibles(request(), $transaction_status)['show'],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TransactionStatus $transaction_status
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(TransactionStatus $transaction_status)
    {
        $this->authorize('update', $transaction_status);

        return response()->view('transaction_statuses.edit', [
            'transaction_status' => $transaction_status,
            'fields' => self::fields(request(), $transaction_status)['edit']
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param TransactionStatus $transaction_status
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, TransactionStatus $transaction_status)
    {
        $this->authorize('update', $transaction_status);
        $request->validate(self::rules($request, $transaction_status)['update']);
        foreach (self::rules($request, $transaction_status)['hasMany'] as $key => $rule)
            $request->validate(array_merge([ $key => 'array' ], $rule));
        foreach (self::rules($request, $transaction_status)['hasOne'] as $key => $rule)
            $request->validate(array_merge([ $key => 'array' ], $rule));

        foreach (self::rules($request, $transaction_status)['update'] as $key => $value) {
            if (Str::contains($value, [ 'file', 'image', 'mimetypes', 'mimes' ])) {
                if ($request->hasFile($key)) {
                    $transaction_status->{$key} = $request->file($key)->store('transaction_statuses');
                } elseif ($request->exists($key)) {
                    $transaction_status->{$key} = $request->{$key};
                }
            } elseif ($request->exists($key)) {
                $transaction_status->{$key} = $request->{$key};
            }
        }

        $deletedModels = [];
        $hasMany = [];
        foreach (self::rules($request, $transaction_status)['hasMany'] as $key => $rule) {
            $hasMany[$key] = [];
            if ($request->exists($key)) {
                /** @var Model $model */
                $model = $transaction_status->{$key}()->getRelated();
                /** @var Collection $models */
                $models = $model->newQuery()->findMany(collect($request->all()[$key] ?? [])->map(function ($data) use($model) {
                    return $data[$model->getKeyName()] ?? null;
                })->filter());
                foreach ($request->all()[$key] ?? [] as $index => $data) {
                    /** @var Model $model */
                    $model = $transaction_status->{$key}()->getRelated();
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
        foreach (self::rules($request, $transaction_status)['hasOne'] as $key => $rule) {
            if ($request->exists($key)) {
                /** @var Model $model */
                $model = $transaction_status->{$key}()->getRelated();
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
            $transaction_status->save();
            foreach (self::rules($request, $transaction_status)['hasMany'] as $key => $rule) {
                if (!$request->exists($key)) continue;
                $models = $transaction_status->{$key}()->saveMany($hasMany[$key]);
                $transaction_status->setRelation($key, new Collection($models));
            }
            foreach (self::rules($request, $transaction_status)['hasOne'] as $key => $rule) {
                if (!$request->exists($key) || empty($hasOne[$key])) continue;
                $model = $transaction_status->{$key}()->save($hasOne[$key]);
                $transaction_status->setRelation($key, $model);
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
            $response = response()->redirectToRoute('transaction_statuses.show', $transaction_status->getKey());

        return $response->withInput([ $transaction_status->getForeignKey() => $transaction_status->getKey() ])
            ->with('status', __('Success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TransactionStatus $transaction_status
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(TransactionStatus $transaction_status)
    {
        $this->authorize('delete', $transaction_status);
        $transaction_status->delete();

        if (request()->filled('redirect') && starts_with(request()->redirect, request()->root()) && !Str::contains(request()->redirect, '/transaction_statuses/'.$transaction_status->getKey()))
            $response = response()->redirectTo(request()->redirect);
        else
            $response = response()->redirectToRoute('transaction_statuses.index');

        return $response->with('status', __('Success'));
    }
}
