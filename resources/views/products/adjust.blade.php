@extends('layouts.app')

@section('content-title', ucwords(__('products.plural')))

@section('content')
    <products-adjust
        :origin-product="{{ $product }}"
    ></products-adjust>
@endsection
