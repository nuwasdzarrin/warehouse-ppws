<?php

namespace App\Http\Controllers;

use App\Fields\Select2Ajax;
use App\Institution;
use App\Product;
use App\ProductCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * ProductController
 */
class ProductController extends Controller
{
    /**
     * Relations
     * @param  \Illuminate\Http\Request|null $request
     * @param Product $product
     * @return array
     */
    public static function relations(Request $request = null, Product $product = null)
    {
        return [
            'product' => [
                'belongsToMany' => [], // also for morphToMany
                'hasMany' => [
                    //[ 'name' => 'children', 'label' => ucwords(__('products.children')) ],
                ], // also for morphMany, hasManyThrough
                'hasOne' => [
                    //[ 'name' => 'child', 'label' => ucwords(__('products.child')) ],
                ], // also for morphOne
            ]
        ];
    }

    /**
     * Visibles
     * @param  \Illuminate\Http\Request|null $request
     * @param Product $product
     * @return array
     */
    public static function visibles(Request $request = null, Product $product = null)
    {
        return [
            'index' => [
                'product' => [
                    //[ 'name' => 'parent', 'label' => ucwords(__('products.parent')), 'column' => 'name' ], // Only support belongsTo, hasOne
                    [ 'name' => 'product_category', 'label' => ucwords(__('product_categories.singular')), 'column' => 'name' ],
                    [ 'name' => 'name', 'label' => ucwords(__('products.name')) ],
                    [ 'name' => 'stock', 'label' => ucwords(__('products.stock')) ],
                    [ 'name' => 'noted', 'label' => ucwords(__('products.noted')) ],
                ]
            ],
            'show' => [
                'product' => [
                    //[ 'name' => 'parent', 'label' => ucwords(__('products.parent')), 'column' => 'name' ], // Only support belongsTo, hasOne
                    [ 'name' => 'product_category', 'label' => ucwords(__('product_categories.singular')), 'column' => 'name' ],
                    [ 'name' => 'name', 'label' => ucwords(__('products.name')) ],
                    [ 'name' => 'stock', 'label' => ucwords(__('products.stock')) ],
                    [ 'name' => 'noted', 'label' => ucwords(__('products.noted')) ],
                    [ 'name' => 'picture_html', 'label' => ucwords(__('products.picture')) ],
                ]
            ]
        ];
    }

    /**
     * Fields
     * @param  \Illuminate\Http\Request|null $request
     * @param Product $product
     * @return array
     */
    public static function fields(Request $request = null, Product $product = null)
    {
        return [
            'create' => [
                'product' => [
                    //[ 'field' => 'select', 'name' => 'parent_id', 'label' => ucwords(__('products.parent')), 'required' => true, 'options' => \App\Parent::filter()->get()->map(function ($parent) {
                    //    return [ 'value' => $parent->id, 'text' => $parent->name ];
                    //})->prepend([ 'value' => '', 'text' => '-' ])->toArray() ],
//                    'product_category' => (new Select2Ajax(ProductCategory::class))
//                        ->setTextProperty('name')
//                        ->setParams(['institution_id' => $request->cookie('institution_id')])
//                        ->setDelayAjax(750)
//                        ->setValueFromModel($product)->toArray(),
//                    [ 'field' => 'input', 'type' => 'text', 'name' => 'name', 'label' => ucwords(__('products.name')), 'required' => true ],
//                    [ 'field' => 'input', 'type' => 'text', 'name' => 'stock', 'label' => ucwords(__('products.stock')) ],
//                    [ 'field' => 'textarea', 'type' => 'text', 'name' => 'noted', 'label' => ucwords(__('products.noted')), 'required' => true ],
                ]
            ],
            'edit' => [
                'product' => [
                    //[ 'field' => 'select', 'name' => 'parent_id', 'label' => ucwords(__('products.parent')), 'options' => \App\Parent::filter()->get()->map(function ($parent) {
                    //    return [ 'value' => $parent->id, 'text' => $parent->name ];
                    //})->prepend([ 'value' => '', 'text' => '-' ])->toArray() ],
                    'product_category' => (new Select2Ajax(ProductCategory::class))
                        ->setTextProperty('name')
                        ->setParams(['institution_id' => $request->cookie('institution_id')])
                        ->setDelayAjax(750)
                        ->setValueFromModel($product)->toArray(),
                    [ 'field' => 'input', 'type' => 'text', 'name' => 'name', 'label' => ucwords(__('products.name')) ],
                    [ 'field' => 'input', 'type' => 'text', 'name' => 'stock', 'label' => ucwords(__('products.stock')) ],
                    [ 'field' => 'textarea', 'type' => 'text', 'name' => 'noted', 'label' => ucwords(__('products.noted')) ],
                ]
            ]
        ];
    }

    /**
     * Rules
     * @param  \Illuminate\Http\Request|null $request
     * @param Product $product
     * @return array
     */
    public static function rules(Request $request = null, Product $product = null)
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
                'product_category_id' => 'required|exists:product_categories,id',
                'name' => 'required|string|max:255',
                'stock' => 'numeric|nullable',
                'noted' => 'string|max:255|nullable',
            ],
            'update' => [
                //'parent_id' => 'exists:parents,id',
                'product_category_id' => 'exists:product_categories,id',
                'name' => 'string|max:255',
                'stock' => 'numeric|max:255',
                'noted' => 'string|max:255',
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
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        /** @var Institution $institution */
        $institution = Institution::byUser(auth()->user())->find(request()->cookie('institution_id')) ? : Institution::byUser(auth()->user())->first();
        if (!request()->cookie('institution_id')) {
            $url = request()->fullUrl();
            return response()->redirectTo($url)->cookie('institution_id', $institution->id, 43200);
        }

        $products = Product::query()->when(auth()->user()->hasRole(['superadmin']), function (Builder $query) use ($institution) {
            return $query->where($query->qualifyColumn('institution_id'), $institution->id);
        })->filter()->paginate()->appends(request()->query());
        $this->authorize('index', 'App\Product');

        return response()->view('products.index', [
            'products' => $products,
            'relations' => self::relations(request()),
            'visibles' => self::visibles(request())['index']
        ])->cookie('institution_id', $institution->id, 43200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', 'App\Product');

        return response()->view('products.create', [
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
        $this->authorize('create', 'App\Product');
        $request->validate(self::rules($request)['store']);
        foreach (self::rules($request)['hasMany'] as $key => $rule)
            $request->validate(array_merge([ $key => 'array' ], $rule));
        foreach (self::rules($request)['hasOne'] as $key => $rule)
            $request->validate(array_merge([ $key => 'array' ], $rule));

        $product = new Product;
        foreach (self::rules($request)['store'] as $key => $value) {
            if (Str::contains($value, [ 'file', 'image', 'mimetypes', 'mimes' ])) {
                if ($request->hasFile($key)) {
                    $product->{$key} = $request->file($key)->store('products');
                } elseif ($request->exists($key)) {
                    $product->{$key} = $request->{$key};
                }
            } elseif ($request->exists($key)) {
                $product->{$key} = $request->{$key};
            }
        }
        if (!$request->stock) {
            $product->stock = 0;
        }
        $product->institution_id = $request->cookie('institution_id') ?? null;

        $deletedModels = [];
        $hasMany = [];
        foreach (self::rules($request)['hasMany'] as $key => $rule) {
            $hasMany[$key] = [];
            if ($request->exists($key)) {
                /** @var Model $model */
                $model = $product->{$key}()->getRelated();
                /** @var Collection $models */
                $models = $model->newQuery()->findMany(collect($request->all()[$key] ?? [])->map(function ($data) use($model) {
                    return $data[$model->getKeyName()] ?? null;
                })->filter());
                foreach ($request->all()[$key] ?? [] as $index => $data) {
                    /** @var Model $model */
                    $model = $product->{$key}()->getRelated();
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
                $model = $product->{$key}()->getRelated();
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
            $product->save();
            foreach (self::rules($request)['hasMany'] as $key => $rule) {
                if (!$request->exists($key)) continue;
                $models = $product->{$key}()->saveMany($hasMany[$key]);
                $product->setRelation($key, new Collection($models));
            }
            foreach (self::rules($request)['hasOne'] as $key => $rule) {
                if (!$request->exists($key) || empty($hasOne[$key])) continue;
                $model = $product->{$key}()->save($hasOne[$key]);
                $product->setRelation($key, $model);
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
            $response = response()->redirectToRoute('products.show', $product->getKey());

        return $response->withInput([ $product->getForeignKey() => $product->getKey() ])
            ->with('status', __('Success'));
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Product $product)
    {
        $this->authorize('view', $product);

        return response()->view('products.show', [
            'product' => $product,
            'relations' => self::relations(request(), $product),
            'visibles' => self::visibles(request(), $product)['show'],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Product $product)
    {
        $this->authorize('update', $product);

        return response()->view('products.edit', [
            'product' => $product,
            'fields' => self::fields(request(), $product)['edit']
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Product $product
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);
        $request->validate(self::rules($request, $product)['update']);
        foreach (self::rules($request, $product)['hasMany'] as $key => $rule)
            $request->validate(array_merge([ $key => 'array' ], $rule));
        foreach (self::rules($request, $product)['hasOne'] as $key => $rule)
            $request->validate(array_merge([ $key => 'array' ], $rule));

        foreach (self::rules($request, $product)['update'] as $key => $value) {
            if (Str::contains($value, [ 'file', 'image', 'mimetypes', 'mimes' ])) {
                if ($request->hasFile($key)) {
                    $product->{$key} = $request->file($key)->store('products');
                } elseif ($request->exists($key)) {
                    $product->{$key} = $request->{$key};
                }
            } elseif ($request->exists($key)) {
                $product->{$key} = $request->{$key};
            }
        }

        $deletedModels = [];
        $hasMany = [];
        foreach (self::rules($request, $product)['hasMany'] as $key => $rule) {
            $hasMany[$key] = [];
            if ($request->exists($key)) {
                /** @var Model $model */
                $model = $product->{$key}()->getRelated();
                /** @var Collection $models */
                $models = $model->newQuery()->findMany(collect($request->all()[$key] ?? [])->map(function ($data) use($model) {
                    return $data[$model->getKeyName()] ?? null;
                })->filter());
                foreach ($request->all()[$key] ?? [] as $index => $data) {
                    /** @var Model $model */
                    $model = $product->{$key}()->getRelated();
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
        foreach (self::rules($request, $product)['hasOne'] as $key => $rule) {
            if ($request->exists($key)) {
                /** @var Model $model */
                $model = $product->{$key}()->getRelated();
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
            $product->save();
            foreach (self::rules($request, $product)['hasMany'] as $key => $rule) {
                if (!$request->exists($key)) continue;
                $models = $product->{$key}()->saveMany($hasMany[$key]);
                $product->setRelation($key, new Collection($models));
            }
            foreach (self::rules($request, $product)['hasOne'] as $key => $rule) {
                if (!$request->exists($key) || empty($hasOne[$key])) continue;
                $model = $product->{$key}()->save($hasOne[$key]);
                $product->setRelation($key, $model);
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
            $response = response()->redirectToRoute('products.show', $product->getKey());

        return $response->withInput([ $product->getForeignKey() => $product->getKey() ])
            ->with('status', __('Success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        $product->delete();

        if (request()->filled('redirect') && starts_with(request()->redirect, request()->root()) && !Str::contains(request()->redirect, '/products/'.$product->getKey()))
            $response = response()->redirectTo(request()->redirect);
        else
            $response = response()->redirectToRoute('products.index');

        return $response->with('status', __('Success'));
    }

    public function adjust(Product $product)
    {
        $this->authorize('adjust', $product);

        return response()->view('products.adjust', [
            'product' => $product
        ]);
    }
}
