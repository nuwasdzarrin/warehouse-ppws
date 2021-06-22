<?php

namespace App\Http\Controllers;

use App\Fields\Select2Ajax;
use App\Institution;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Role;

/**
 * UserController
 */
class UserController extends Controller
{
    /**
     * Relations
     * @param  \Illuminate\Http\Request|null $request
     * @param User $user
     * @return array
     */
    public static function relations(Request $request = null, User $user = null)
    {
        return [
            'user' => [
                'belongsToMany' => [], // also for morphToMany
                'hasMany' => [
                    //[ 'name' => 'children', 'label' => ucwords(__('users.children')) ],
                ], // also for morphMany, hasManyThrough
                'hasOne' => [
                    //[ 'name' => 'child', 'label' => ucwords(__('users.child')) ],
                ], // also for morphOne
            ]
        ];
    }

    /**
     * Visibles
     * @param  \Illuminate\Http\Request|null $request
     * @param User $user
     * @return array
     */
    public static function visibles(Request $request = null, User $user = null)
    {
        return [
            'index' => [
                'user' => [
                    //[ 'name' => 'parent', 'label' => ucwords(__('users.parent')), 'column' => 'name' ], // Only support belongsTo, hasOne
                    [ 'name' => 'name', 'label' => ucwords(__('users.name')) ],
                    [ 'name' => 'institution', 'label' => ucwords(__('institutions.singular')), 'column' => 'name'],
                    [ 'name' => 'role', 'label' => ucwords(__('roles.singular')), 'column' => 'display_name'],
                    [ 'name' => 'email', 'label' => ucwords(__('users.email')) ],
                    [ 'name' => 'phone', 'label' => ucwords(__('users.phone')) ],
                    [ 'name' => 'address', 'label' => ucwords(__('users.address')) ],
                ]
            ],
            'show' => [
                'user' => [
                    //[ 'name' => 'parent', 'label' => ucwords(__('users.parent')), 'column' => 'name' ], // Only support belongsTo, hasOne
                    [ 'name' => 'name', 'label' => ucwords(__('users.name')) ],
                    [ 'name' => 'institution', 'label' => ucwords(__('institutions.singular')), 'column' => 'name'],
                    [ 'name' => 'role', 'label' => ucwords(__('roles.singular')), 'column' => 'display_name'],
                    [ 'name' => 'email', 'label' => ucwords(__('users.email')) ],
                    [ 'name' => 'phone', 'label' => ucwords(__('users.phone')) ],
                    [ 'name' => 'address', 'label' => ucwords(__('users.address')) ],
                    [ 'name' => 'avatar_html', 'label' => ucwords(__('users.avatar')) ],
                ]
            ]
        ];
    }

    /**
     * Fields
     * @param  \Illuminate\Http\Request|null $request
     * @param User $user
     * @return array
     */
    public static function fields(Request $request = null, User $user = null)
    {
        return [
            'create' => [
                'user' => [
                    //[ 'field' => 'select', 'name' => 'parent_id', 'label' => ucwords(__('users.parent')), 'required' => true, 'options' => \App\Parent::filter()->get()->map(function ($parent) {
                    //    return [ 'value' => $parent->id, 'text' => $parent->name ];
                    //})->prepend([ 'value' => '', 'text' => '-' ])->toArray() ],
                    [ 'field' => 'input', 'type' => 'text', 'name' => 'name', 'label' => ucwords(__('users.name')), 'required' => true ],
                    [ 'field' => 'input', 'type' => 'email', 'name' => 'email', 'label' => ucwords(__('users.email')), 'required' => true ],
                    ['field' => 'input', 'type' => 'password', 'name' => 'password', 'label' => ucwords(__('users.password')), 'required' => true],
                    ['field' => 'input', 'type' => 'password', 'name' => 'password_confirmation', 'label' => ucwords(__('users.password_confirmation')), 'required' => true],
                    ['field' => 'input', 'type' => 'text', 'name' => 'address', 'label' => ucwords(__('users.address')) ],
                    ['field' => 'input', 'type' => 'text', 'name' => 'phone', 'label' => ucwords(__('users.phone')) ],
                    ['field' => 'input', 'type' => 'file', 'name' => 'avatar', 'label' => ucwords(__('users.avatar')) ],
                    'institution' => (new Select2Ajax(Institution::class))
                        ->setTextProperty('name')
                        ->setPlaceholder((auth()->user()->hasRole('superadmin'))?Institution::query()->findOrFail($request->cookie('institution_id'))->name:auth()->user()->institution->name)
                        ->setDelayAjax(750)
                        ->setDisabled(!($request->user()->hasRole([ 'superadmin' ])))
                        ->setRequired(true)
                        ->setValueFromModel($user)->toArray(),
                    'role' => (new Select2Ajax(Role::class))
                        ->setTextProperty('display_name')
                        ->setPlaceholder('Staff')
                        ->setDelayAjax(750)
                        ->setDisabled(!($request->user()->hasRole([ 'superadmin' ])))
                        ->setValueFromModel($user)->toArray(),
                ]
            ],
            'edit' => [
                'user' => [
                    //[ 'field' => 'select', 'name' => 'parent_id', 'label' => ucwords(__('users.parent')), 'options' => \App\Parent::filter()->get()->map(function ($parent) {
                    //    return [ 'value' => $parent->id, 'text' => $parent->name ];
                    //})->prepend([ 'value' => '', 'text' => '-' ])->toArray() ],
                    [ 'field' => 'input', 'type' => 'text', 'name' => 'name', 'label' => ucwords(__('users.name')) ],
                    [ 'field' => 'input', 'type' => 'text', 'name' => 'email', 'label' => ucwords(__('users.email')) ],
                    ['field' => 'input', 'type' => 'password', 'name' => 'password', 'label' => ucwords(__('users.password'))],
                    ['field' => 'input', 'type' => 'password', 'name' => 'password_confirmation', 'label' => ucwords(__('users.password_confirmation'))],
                    ['field' => 'input', 'type' => 'text', 'name' => 'address', 'label' => ucwords(__('users.address')) ],
                    ['field' => 'input', 'type' => 'text', 'name' => 'phone', 'label' => ucwords(__('users.phone')) ],
                    ['field' => 'input', 'type' => 'file', 'name' => 'avatar', 'label' => ucwords(__('users.avatar')) ],
                    'institution' => (new Select2Ajax(Institution::class))
                        ->setTextProperty('name')
                        ->setDelayAjax(750)
                        ->setDisabled(!($request->user()->hasRole([ 'superadmin' ])))
                        ->setValueFromModel($user)->toArray(),
                    'role' => (new Select2Ajax(Role::class))
                        ->setTextProperty('display_name')
                        ->setDelayAjax(750)
                        ->setDisabled(!($request->user()->hasRole([ 'superadmin' ])))
                        ->setValueFromModel($user)->toArray(),
                ]
            ]
        ];
    }

    /**
     * Rules
     * @param  \Illuminate\Http\Request|null $request
     * @param User $user
     * @return array
     */
    public static function rules(Request $request = null, User $user = null)
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
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6|confirmed',
                'address' => 'string|max:255|nullable',
                'phone' => 'string|max:255|nullable',
                'avatar' => 'mimes:jpeg,jpg,png,bmp,gif,svg|max:2048|nullable',
                'institution_id' => 'exists:institutions,id|nullable',
                'role_id' => 'exists:roles,id|nullable',
            ],
            'update' => [
                //'parent_id' => 'exists:parents,id',
                'name' => 'string|max:255',
                'email' => 'email|unique:users,email,' . ($user ? $user->getKey() : 'NULL') . ',id|nullable',
                'password' => 'min:6|confirmed|nullable',
                'address' => 'string|max:255|nullable',
                'phone' => 'string|max:255|nullable',
                'avatar' => 'mimes:jpeg,jpg,png,bmp,gif,svg|max:2048|nullable',
                'institution_id' => 'exists:institutions,id|nullable',
                'role_id' => 'exists:roles,id|nullable',
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
        $users = User::byUser()->filter()
            ->paginate()->appends(request()->query());
        $this->authorize('index', 'App\User');

        return response()->view('users.index', [
            'users' => $users,
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
        $this->authorize('create', 'App\User');

        return response()->view('users.create', [
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
        $this->authorize('create', 'App\User');
        $request->validate(self::rules($request)['store']);
        foreach (self::rules($request)['hasMany'] as $key => $rule)
            $request->validate(array_merge([ $key => 'array' ], $rule));
        foreach (self::rules($request)['hasOne'] as $key => $rule)
            $request->validate(array_merge([ $key => 'array' ], $rule));

        $user = new User;
        foreach (self::rules($request)['store'] as $key => $value) {
            if (Str::contains($value, [ 'file', 'image', 'mimetypes', 'mimes' ])) {
                if ($request->hasFile($key)) {
                    $user->{$key} = $request->file($key)->store('users');
                } elseif ($request->exists($key)) {
                    $user->{$key} = $request->{$key};
                }
            } elseif ($request->exists($key)) {
                $user->{$key} = $request->{$key};
            }
        }
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        if (!$request->filled('role_id')) {
            $user->role_id = Role::query()->where('name','staff')->first()->getKey();
        }
        if (!$request->filled('institution_id')) {
            $user->institution_id = $request->cookie('institution_id');
        }

        $deletedModels = [];
        $hasMany = [];
        foreach (self::rules($request)['hasMany'] as $key => $rule) {
            $hasMany[$key] = [];
            if ($request->exists($key)) {
                /** @var Model $model */
                $model = $user->{$key}()->getRelated();
                /** @var Collection $models */
                $models = $model->newQuery()->findMany(collect($request->all()[$key] ?? [])->map(function ($data) use($model) {
                    return $data[$model->getKeyName()] ?? null;
                })->filter());
                foreach ($request->all()[$key] ?? [] as $index => $data) {
                    /** @var Model $model */
                    $model = $user->{$key}()->getRelated();
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
                $model = $user->{$key}()->getRelated();
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
            $user->save();
            foreach (self::rules($request)['hasMany'] as $key => $rule) {
                if (!$request->exists($key)) continue;
                $models = $user->{$key}()->saveMany($hasMany[$key]);
                $user->setRelation($key, new Collection($models));
            }
            foreach (self::rules($request)['hasOne'] as $key => $rule) {
                if (!$request->exists($key) || empty($hasOne[$key])) continue;
                $model = $user->{$key}()->save($hasOne[$key]);
                $user->setRelation($key, $model);
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
            $response = response()->redirectToRoute('users.show', $user->getKey());

        return $response->withInput([ $user->getForeignKey() => $user->getKey() ])
            ->with('status', __('Success'));
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);

        return response()->view('users.show', [
            'user' => $user,
            'relations' => self::relations(request(), $user),
            'visibles' => self::visibles(request(), $user)['show'],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        if ($user->getAttribute('password')) $user->password =null;

        return response()->view('users.edit', [
            'user' => $user,
            'fields' => self::fields(request(), $user)['edit']
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);
        $request->validate(self::rules($request, $user)['update']);
        foreach (self::rules($request, $user)['hasMany'] as $key => $rule)
            $request->validate(array_merge([ $key => 'array' ], $rule));
        foreach (self::rules($request, $user)['hasOne'] as $key => $rule)
            $request->validate(array_merge([ $key => 'array' ], $rule));

        foreach (self::rules($request, $user)['update'] as $key => $value) {
            if (Str::contains($value, [ 'file', 'image', 'mimetypes', 'mimes' ])) {
                if ($request->hasFile($key)) {
                    $user->{$key} = $request->file($key)->store('users');
                } elseif ($request->exists($key)) {
                    $user->{$key} = $request->{$key};
                }
            } elseif ($request->exists($key)) {
                $user->{$key} = $request->{$key};
            }
        }
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        } else {
            $user->offsetUnset('password');
        }

        $deletedModels = [];
        $hasMany = [];
        foreach (self::rules($request, $user)['hasMany'] as $key => $rule) {
            $hasMany[$key] = [];
            if ($request->exists($key)) {
                /** @var Model $model */
                $model = $user->{$key}()->getRelated();
                /** @var Collection $models */
                $models = $model->newQuery()->findMany(collect($request->all()[$key] ?? [])->map(function ($data) use($model) {
                    return $data[$model->getKeyName()] ?? null;
                })->filter());
                foreach ($request->all()[$key] ?? [] as $index => $data) {
                    /** @var Model $model */
                    $model = $user->{$key}()->getRelated();
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
        foreach (self::rules($request, $user)['hasOne'] as $key => $rule) {
            if ($request->exists($key)) {
                /** @var Model $model */
                $model = $user->{$key}()->getRelated();
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
            $user->save();
            foreach (self::rules($request, $user)['hasMany'] as $key => $rule) {
                if (!$request->exists($key)) continue;
                $models = $user->{$key}()->saveMany($hasMany[$key]);
                $user->setRelation($key, new Collection($models));
            }
            foreach (self::rules($request, $user)['hasOne'] as $key => $rule) {
                if (!$request->exists($key) || empty($hasOne[$key])) continue;
                $model = $user->{$key}()->save($hasOne[$key]);
                $user->setRelation($key, $model);
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
            $response = response()->redirectToRoute('users.show', $user->getKey());

        return $response->withInput([ $user->getForeignKey() => $user->getKey() ])
            ->with('status', __('Success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();

        if (request()->filled('redirect') && starts_with(request()->redirect, request()->root()) && !Str::contains(request()->redirect, '/users/'.$user->getKey()))
            $response = response()->redirectTo(request()->redirect);
        else
            $response = response()->redirectToRoute('users.index');

        return $response->with('status', __('Success'));
    }
}
