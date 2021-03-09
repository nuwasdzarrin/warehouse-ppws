@extends('layouts.app')

@section('content-title', ucwords(__('institutions.plural')))

@include('models.index', [
  'col_class' => 'col-md-8 col-md-offset-2 offset-md-2',
  'panel_title' => ucwords(__('institutions.plural')),
  'resource_route' => 'institutions',
  'model_variable' => 'institution',
  'model_class' => \App\Institution::class,
  'models' => $institutions,
  'action_buttons_view' => 'generator::components.models.index.action_buttons',
])
