@extends('layouts.app')

@section('content-title', ucwords(__('transactions.plural')))

@section('content')
    <transaction-ins-edit
        user-name="{{ auth()->user()->name }}"
        :institution-id="{{ request()->cookie('institution_id') }}"
        :origin-transaction="{{ $transaction }}"
    ></transaction-ins-edit>
@endsection

@include('models.edit', [
  'panel_title' => ucwords(__('transactions.singular')),
  'resource_route' => 'transaction_ins',
  'model_variable' => 'transaction',
  'model' => $transaction
])
