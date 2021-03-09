@extends('layouts.app')

@section('content-title', ucwords(__('transaction_outs.plural')))

@include('models.index', [
  'col_class' => 'col-md-12',
  'panel_title' => ucwords(__('transaction_outs.plural')),
  'resource_route' => 'transaction_outs',
  'model_variable' => 'transaction_out',
  'model_class' => \App\TransactionOut::class,
  'models' => $transaction_outs,
  'action_buttons_view' => 'generator::components.models.index.action_buttons',
])
