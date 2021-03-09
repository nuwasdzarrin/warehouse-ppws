@extends('layouts.app')

@section('content-title', ucwords(__('transactions.plural')))

@section('content')
    <transaction-ins-create
        user-name="{{ auth()->user()->name }}"
        :institution-id="{{ request()->cookie('institution_id') }}"
    ></transaction-ins-create>
@endsection

@include('models.create', [
  'panel_title' => ucwords(__('transactions.singular')),
  'resource_route' => 'transaction_ins',
  'model_variable' => 'transaction',
  'model_class' => \App\Transaction::class,
])
