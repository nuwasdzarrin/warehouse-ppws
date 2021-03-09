@extends('layouts.app')

@section('content-title', ucwords(__('transactions.plural')))

@include('models.index', [
  'col_class' => 'col-md-12',
  'panel_title' => ucwords(__('transactions.plural')),
  'resource_route' => 'transaction_ins',
  'model_variable' => 'transaction',
  'model_class' => \App\Transaction::class,
  'models' => $transactions,
  'action_buttons_view' => 'generator::components.models.index.action_buttons',
])
