@extends('layouts.app')

@section('content-title', ucwords(__('products.plural')))

@php
    extract([
        'resource_route' => 'products',
        'model_variable' => 'product',
        'model_class' => \App\Product::class,
        'models' => $products,
        'action_buttons_view' => 'products.index.action_buttons',
    ])
@endphp

@section('panel-tools')
    @if (Route::has($resource_route.'.import'))
        @if ((auth()->check() && auth()->user()->can('import', $model_class ?? 'App\Model')) || auth()->guest())
            <a href="{{ route($resource_route.'.import', [ 'redirect' => request()->fullUrlWithQuery([ 'search' => null ]) ]) }}"
               class="btn btn-outline btn-success btn-sm btn-xs"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;{{ __('Import') }}</a>
        @endif
    @endif
    @if (Route::has($resource_route.'.create'))
        @if ((auth()->check() && auth()->user()->can('create', $model_class ?? 'App\Model')) || auth()->guest())
            <a href="{{ route($resource_route.'.create', [ 'redirect' => request()->fullUrlWithQuery([ 'search' => null ]) ]) }}"
               class="btn btn-primary btn-secondary btn-sm btn-xs">{{ __('Create') }}</a>
        @endif
    @endif
@endsection

@include('models.index', [
  'col_class' => 'col-md-12',
  'panel_title' => ucwords(__('products.plural')),
  'resource_route' => 'products',
  'model_variable' => 'product',
  'model_class' => \App\Product::class,
  'models' => $products,
  'action_buttons_view' => 'products.index.action_buttons',
])
