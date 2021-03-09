@extends('layouts.app')

@section('content-title', ucwords(__('transaction_outs.plural')))

@section('content')
    <transaction-outs-edit
        user-name="{{ auth()->user()->name }}"
        :institution-id="{{ request()->cookie('institution_id') }}"
        :origin-transaction="{{ $transaction_out }}"
    ></transaction-outs-edit>
@endsection

@include('models.edit', [
  'panel_title' => ucwords(__('transaction_outs.singular')),
  'resource_route' => 'transaction_outs',
  'model_variable' => 'transaction_out',
  'model' => $transaction_out
])
