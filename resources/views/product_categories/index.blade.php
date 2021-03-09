@extends('layouts.app')

@section('content-title', ucwords(__('product_categories.plural')))

@include('models.index', [
  'col_class' => 'col-md-8 col-md-offset-2 offset-md-2',
  'panel_title' => ucwords(__('product_categories.plural')),
  'resource_route' => 'product_categories',
  'model_variable' => 'product_category',
  'model_class' => \App\ProductCategory::class,
  'models' => $product_categories,
  'action_buttons_view' => 'generator::components.models.index.action_buttons',
])
