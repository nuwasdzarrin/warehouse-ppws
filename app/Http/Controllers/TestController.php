<?php

namespace App\Http\Controllers;

use App\Test;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * TestController
 */
class TestController extends Controller
{
    /**
     * Relations
     * @param  \Illuminate\Http\Request|null $request
     * @param Test $test
     * @return array
     */
    public static function relations(Request $request = null, Test $test = null)
    {
        return [
            'test' => [
                'belongsToMany' => [], // also for morphToMany
                'hasMany' => [
                    //[ 'name' => 'children', 'label' => ucwords(__('tests.children')) ],
                ], // also for morphMany, hasManyThrough
                'hasOne' => [
                    //[ 'name' => 'child', 'label' => ucwords(__('tests.child')) ],
                ], // also for morphOne
            ]
        ];
    }

    /**
     * Visibles
     * @param  \Illuminate\Http\Request|null $request
     * @param Test $test
     * @return array
     */
    public static function visibles(Request $request = null, Test $test = null)
    {
        return [
            'index' => [
                'test' => [
                    //[ 'name' => 'parent', 'label' => ucwords(__('tests.parent')), 'column' => 'name' ], // Only support belongsTo, hasOne
                    [ 'name' => 'name', 'label' => ucwords(__('tests.name')) ],
                ]
            ],
            'show' => [
                'test' => [
                    //[ 'name' => 'parent', 'label' => ucwords(__('tests.parent')), 'column' => 'name' ], // Only support belongsTo, hasOne
                    [ 'name' => 'name', 'label' => ucwords(__('tests.name')) ],
                ]
            ]
        ];
    }

    /**
     * Fields
     * @param  \Illuminate\Http\Request|null $request
     * @param Test $test
     * @return array
     */
    public static function fields(Request $request = null, Test $test = null)
    {
        return [
            'create' => [
                'test' => [
                    //[ 'field' => 'select', 'name' => 'parent_id', 'label' => ucwords(__('tests.parent')), 'required' => true, 'options' => \App\Parent::filter()->get()->map(function ($parent) {
                    //    return [ 'value' => $parent->id, 'text' => $parent->name ];
                    //})->prepend([ 'value' => '', 'text' => '-' ])->toArray() ],
                    [ 'field' => 'input', 'type' => 'text', 'name' => 'name', 'label' => ucwords(__('tests.name')), 'required' => true ],
                ]
            ],
            'edit' => [
                'test' => [
                    //[ 'field' => 'select', 'name' => 'parent_id', 'label' => ucwords(__('tests.parent')), 'options' => \App\Parent::filter()->get()->map(function ($parent) {
                    //    return [ 'value' => $parent->id, 'text' => $parent->name ];
                    //})->prepend([ 'value' => '', 'text' => '-' ])->toArray() ],
                    [ 'field' => 'input', 'type' => 'text', 'name' => 'name', 'label' => ucwords(__('tests.name')) ],
                ]
            ]
        ];
    }

    /**
     * Rules
     * @param  \Illuminate\Http\Request|null $request
     * @param Test $test
     * @return array
     */
    public static function rules(Request $request = null, Test $test = null)
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
            ],
            'update' => [
                //'parent_id' => 'exists:parents,id',
                'name' => 'string|max:255',
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
        $tests = Test::filter()
            ->paginate()->appends(request()->query());
        $this->authorize('index', 'App\Test');

        return response()->view('tests.index', [
            'tests' => $tests,
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
        $this->authorize('create', 'App\Test');

        return response()->view('tests.create', [
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
        $this->authorize('create', 'App\Test');
        $request->validate(self::rules($request)['store']);
        foreach (self::rules($request)['hasMany'] as $key => $rule)
            $request->validate(array_merge([ $key => 'array' ], $rule));
        foreach (self::rules($request)['hasOne'] as $key => $rule)
            $request->validate(array_merge([ $key => 'array' ], $rule));

        $test = new Test;
        foreach (self::rules($request)['store'] as $key => $value) {
            if (Str::contains($value, [ 'file', 'image', 'mimetypes', 'mimes' ])) {
                if ($request->hasFile($key)) {
                    $test->{$key} = $request->file($key)->store('tests');
                } elseif ($request->exists($key)) {
                    $test->{$key} = $request->{$key};
                }
            } elseif ($request->exists($key)) {
                $test->{$key} = $request->{$key};
            }
        }

        $deletedModels = [];
        $hasMany = [];
        foreach (self::rules($request)['hasMany'] as $key => $rule) {
            $hasMany[$key] = [];
            if ($request->exists($key)) {
                /** @var Model $model */
                $model = $test->{$key}()->getRelated();
                /** @var Collection $models */
                $models = $model->newQuery()->findMany(collect($request->all()[$key] ?? [])->map(function ($data) use($model) {
                    return $data[$model->getKeyName()] ?? null;
                })->filter());
                foreach ($request->all()[$key] ?? [] as $index => $data) {
                    /** @var Model $model */
                    $model = $test->{$key}()->getRelated();
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
                $model = $test->{$key}()->getRelated();
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
            $test->save();
            foreach (self::rules($request)['hasMany'] as $key => $rule) {
                if (!$request->exists($key)) continue;
                $models = $test->{$key}()->saveMany($hasMany[$key]);
                $test->setRelation($key, new Collection($models));
            }
            foreach (self::rules($request)['hasOne'] as $key => $rule) {
                if (!$request->exists($key) || empty($hasOne[$key])) continue;
                $model = $test->{$key}()->save($hasOne[$key]);
                $test->setRelation($key, $model);
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
            $response = response()->redirectToRoute('tests.show', $test->getKey());

        return $response->withInput([ $test->getForeignKey() => $test->getKey() ])
            ->with('status', __('Success'));
    }

    /**
     * Display the specified resource.
     *
     * @param Test $test
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Test $test)
    {
        $this->authorize('view', $test);

        return response()->view('tests.show', [
            'test' => $test,
            'relations' => self::relations(request(), $test),
            'visibles' => self::visibles(request(), $test)['show'],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Test $test
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Test $test)
    {
        $this->authorize('update', $test);

        return response()->view('tests.edit', [
            'test' => $test,
            'fields' => self::fields(request(), $test)['edit']
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Test $test
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Test $test)
    {
        $this->authorize('update', $test);
        $request->validate(self::rules($request, $test)['update']);
        foreach (self::rules($request, $test)['hasMany'] as $key => $rule)
            $request->validate(array_merge([ $key => 'array' ], $rule));
        foreach (self::rules($request, $test)['hasOne'] as $key => $rule)
            $request->validate(array_merge([ $key => 'array' ], $rule));

        foreach (self::rules($request, $test)['update'] as $key => $value) {
            if (Str::contains($value, [ 'file', 'image', 'mimetypes', 'mimes' ])) {
                if ($request->hasFile($key)) {
                    $test->{$key} = $request->file($key)->store('tests');
                } elseif ($request->exists($key)) {
                    $test->{$key} = $request->{$key};
                }
            } elseif ($request->exists($key)) {
                $test->{$key} = $request->{$key};
            }
        }

        $deletedModels = [];
        $hasMany = [];
        foreach (self::rules($request, $test)['hasMany'] as $key => $rule) {
            $hasMany[$key] = [];
            if ($request->exists($key)) {
                /** @var Model $model */
                $model = $test->{$key}()->getRelated();
                /** @var Collection $models */
                $models = $model->newQuery()->findMany(collect($request->all()[$key] ?? [])->map(function ($data) use($model) {
                    return $data[$model->getKeyName()] ?? null;
                })->filter());
                foreach ($request->all()[$key] ?? [] as $index => $data) {
                    /** @var Model $model */
                    $model = $test->{$key}()->getRelated();
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
        foreach (self::rules($request, $test)['hasOne'] as $key => $rule) {
            if ($request->exists($key)) {
                /** @var Model $model */
                $model = $test->{$key}()->getRelated();
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
            $test->save();
            foreach (self::rules($request, $test)['hasMany'] as $key => $rule) {
                if (!$request->exists($key)) continue;
                $models = $test->{$key}()->saveMany($hasMany[$key]);
                $test->setRelation($key, new Collection($models));
            }
            foreach (self::rules($request, $test)['hasOne'] as $key => $rule) {
                if (!$request->exists($key) || empty($hasOne[$key])) continue;
                $model = $test->{$key}()->save($hasOne[$key]);
                $test->setRelation($key, $model);
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
            $response = response()->redirectToRoute('tests.show', $test->getKey());

        return $response->withInput([ $test->getForeignKey() => $test->getKey() ])
            ->with('status', __('Success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Test $test
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(Test $test)
    {
        $this->authorize('delete', $test);
        $test->delete();

        if (request()->filled('redirect') && starts_with(request()->redirect, request()->root()) && !Str::contains(request()->redirect, '/tests/'.$test->getKey()))
            $response = response()->redirectTo(request()->redirect);
        else
            $response = response()->redirectToRoute('tests.index');

        return $response->with('status', __('Success'));
    }
}
