@extends('layouts.app')

@section('content-title', ucwords(__('roles.plural')))

@include('models.index', [
  'col_class' => 'col-md-8 col-md-offset-2 offset-md-2',
  'panel_title' => ucwords(__('roles.plural')),
  'resource_route' => 'roles',
  'model_variable' => 'role',
  'model_class' => \App\Role::class,
  'models' => $roles,
  'action_buttons_view' => 'generator::components.models.index.action_buttons',
])
