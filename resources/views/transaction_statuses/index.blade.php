@extends('layouts.app')

@section('content-title', ucwords(__('transaction_statuses.plural')))

@include('models.index', [
  'col_class' => 'col-md-8 col-md-offset-2 offset-md-2',
  'panel_title' => ucwords(__('transaction_statuses.plural')),
  'resource_route' => 'transaction_statuses',
  'model_variable' => 'transaction_status',
  'model_class' => \App\TransactionStatus::class,
  'models' => $transaction_statuses,
  'action_buttons_view' => 'generator::components.models.index.action_buttons',
])
