@extends('layouts.app')

@section('content-title', ucwords(__('tests.plural')))

@include('models.index', [
  'col_class' => 'col-md-8 col-md-offset-2 offset-md-2',
  'panel_title' => ucwords(__('tests.plural')),
  'resource_route' => 'tests',
  'model_variable' => 'test',
  'model_class' => \App\Test::class,
  'models' => $tests,
  'action_buttons_view' => 'generator::components.models.index.action_buttons',
])
