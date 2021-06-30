@extends('layouts.app')

@section('content-title', ucwords(__('products.plural')))

@php
    extract([
  'panel_title' => ucwords(__('products.singular')),
  'resource_route' => 'products',
  'model_variable' => 'product',
  'model_class' => \App\Product::class,
])
@endphp

@section('panel-content')
    @foreach ($fields[$model_variable] as $key => $field)
        @component(config('generator.view_component').'components.fields.'.$field['field'], compact('field'))
        @endcomponent
    @endforeach
@endsection

@section('panel-footer')
    <div class="pull-right float-right">
        <button type="submit" name="redirect"
                value="{{ route($resource_route.'.index', [ 'redirect' => request()->filled('redirect') ? url(request()->redirect) : null ]) }}"
                class="btn btn-success">
            <i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;{{ __('Import') }}
        </button>
    </div>
    @if (Route::has($resource_route.'.index'))
        <a href="{{ route($resource_route.'.index', [ 'redirect' => request()->filled('redirect') ? url(request()->redirect) : null ]) }}"
           class="btn btn-default btn-secondary">{{ __('List') }}</a>
    @endif
@endsection

@section('content')
    @yield('content-alert')
    <div class="row">
        <div class="col-md-8 col-md-offset-2 offset-md-2">
            <form class="form"
                  action="{{ route('product_import_excel.import') }}"
                  method="POST"
                  @if (array_first($fields[$model_variable], function ($field) { return isset($field['type']) && $field['type'] == 'file'; } ))
                  enctype="multipart/form-data"
                @endif
            >
                {{ csrf_field() }}
                @component(config('generator.view_component').'components.panel')
                    @slot('title')
                        {{ __('Create') }} {{ !empty($panel_title) ? $panel_title : ucwords(__($resource_route.'.singular')) }}
                    @endslot

                    @yield('panel-content')

                    @slot('footer')
                        @yield('panel-footer')
                    @endslot
                @endcomponent
            </form>
        </div>
    </div>
@endsection

@include('models.create', [
  'panel_title' => ucwords(__('products.singular')),
  'resource_route' => 'products',
  'model_variable' => 'product',
  'model_class' => \App\Product::class,
])
