@extends('layouts.app')

@section('content-title', ucwords(__('transaction_outs.plural')))

@section('content')
    <transaction-outs-create
        user-name="{{ auth()->user()->name }}"
        :institution-id="{{ request()->cookie('institution_id') }}"
    ></transaction-outs-create>
@endsection

@include('models.create', [
  'panel_title' => ucwords(__('transaction_outs.singular')),
  'resource_route' => 'transaction_outs',
  'model_variable' => 'transaction_out',
  'model_class' => \App\TransactionOut::class,
])
