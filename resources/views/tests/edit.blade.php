@extends('layouts.app')

@section('content-title', ucwords(__('tests.plural')))

@include('models.edit', [
  'panel_title' => ucwords(__('tests.singular')),
  'resource_route' => 'tests',
  'model_variable' => 'test',
  'model' => $test
])
