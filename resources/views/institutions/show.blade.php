@extends('layouts.app')

@section('content-title', ucwords(__('institutions.plural')))

@include('models.show', [
  'panel_title' => ucwords(__('institutions.singular')),
  'resource_route' => 'institutions',
  'model_variable' => 'institution',
  'model' => $institution
])
