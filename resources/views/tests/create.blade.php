@extends('layouts.app')

@section('content-title', ucwords(__('tests.plural')))

@include('models.create', [
  'panel_title' => ucwords(__('tests.singular')),
  'resource_route' => 'tests',
  'model_variable' => 'test',
  'model_class' => \App\Test::class,
])
