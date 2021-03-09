@extends('layouts.app')

@section('content-title', ucwords(__('transactions.plural')))

@include('models.show', [
  'panel_title' => ucwords(__('transactions.singular')),
  'resource_route' => 'transaction_ins',
  'model_variable' => 'transaction',
  'model' => $transaction
])
