@extends('layouts.app')

@section('content-title', ucwords(__('products.plural')))

@include('models.index', [
  'col_class' => 'col-md-12',
  'panel_title' => ucwords(__('products.plural')),
  'resource_route' => 'products',
  'model_variable' => 'product',
  'model_class' => \App\Product::class,
  'models' => $products,
  'action_buttons_view' => 'products.index.action_buttons',
])
