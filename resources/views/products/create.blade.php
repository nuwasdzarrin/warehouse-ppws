@extends('layouts.app')

@section('content-title', ucwords(__('products.plural')))

@section('content')
    <products-create
        :institution-id="{{ request()->cookie('institution_id') }}"
    ></products-create>
@endsection

@include('models.create', [
  'panel_title' => ucwords(__('products.singular')),
  'resource_route' => 'products',
  'model_variable' => 'product',
  'model_class' => \App\Product::class,
])
