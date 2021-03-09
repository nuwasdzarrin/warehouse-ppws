@extends('layouts.app')

@section('content-title', ucwords(__('product_categories.plural')))

@include('models.show', [
  'panel_title' => ucwords(__('product_categories.singular')),
  'resource_route' => 'product_categories',
  'model_variable' => 'product_category',
  'model' => $product_category
])
