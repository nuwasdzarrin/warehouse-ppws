<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\Resource;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * UserController
 * @extends Controller
 */
class UserController extends Controller
{
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
        $users = User::filter()
            ->paginate()->appends(request()->query());
//        $this->authorize('index', 'App\User');

        return Resource::collection($users);
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
            throw new HttpException(500, $exception->getMessage(), $exception);
        }

        return (new Resource($user))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);

        return new Resource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param User $user
     * @return Resource
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
            throw new HttpException(500, $exception->getMessage(), $exception);
        }

        return new Resource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();

        return new Resource($user);
    }
}
