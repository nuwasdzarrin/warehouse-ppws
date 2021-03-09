@extends('layouts.app')

@section('content-title', ucwords(__('transaction_outs.plural')))

@include('models.show', [
  'panel_title' => ucwords(__('transaction_outs.singular')),
  'resource_route' => 'transaction_outs',
  'model_variable' => 'transaction_out',
  'model' => $transaction_out
])
