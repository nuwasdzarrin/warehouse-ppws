@extends('layouts.app')

@section('content-title', ucwords(__('transaction_statuses.plural')))

@include('models.edit', [
  'panel_title' => ucwords(__('transaction_statuses.singular')),
  'resource_route' => 'transaction_statuses',
  'model_variable' => 'transaction_status',
  'model' => $transaction_status
])
