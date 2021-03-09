@extends('layouts.app')

@section('content-title', ucwords(__('products.plural')))

@section('content')
    <products-edit
        :institution-id="{{ request()->cookie('institution_id') }}"
        :origin-product="{{ $product }}"
    ></products-edit>
@endsection

@include('models.edit', [
  'panel_title' => ucwords(__('products.singular')),
  'resource_route' => 'products',
  'model_variable' => 'product',
  'model' => $product
])
