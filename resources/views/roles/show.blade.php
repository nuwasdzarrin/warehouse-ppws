@extends('layouts.app')

@section('content-title', ucwords(__('roles.plural')))

@include('models.show', [
  'panel_title' => ucwords(__('roles.singular')),
  'resource_route' => 'roles',
  'model_variable' => 'role',
  'model' => $role
])
