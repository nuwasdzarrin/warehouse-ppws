@extends('layouts.app')

@section('content-title', ucwords(__('users.plural')))

@include('models.index', [
  'col_class' => 'col-md-12',
  'panel_title' => ucwords(__('users.plural')),
  'resource_route' => 'users',
  'model_variable' => 'user',
  'model_class' => \App\User::class,
  'models' => $users,
  'action_buttons_view' => 'generator::components.models.index.action_buttons',
])
