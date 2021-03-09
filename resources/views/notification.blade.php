@extends('layouts.app')

@section('content-title', ucwords(__('notification.plural')))

@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">
    @component(config('generator.view_component').'components.panel')
      @slot('title')
        Semua Notifikasi
      @endslot

      @if (session('status'))
      <div class="alert alert-success">
        {{ session('status') }}
      </div>
      @endif
      <div class="table-responsive">
          <table id="products" class="table table-striped table-hover table-condensed table-sm">
              <thead class="text-nowrap">
              <tr>
                  <th width="1px" class="text-center">No</th>
                  <th class="text-center">Kategori</th>
                  <th class="text-center">Nama</th>
                  <th class="text-center">Stok</th>
                  <th class="text-center">Keterangan</th>
                  <th></th>
              </tr>
              </thead>
              <tbody>
              @foreach($products as $key => $product)
                  <tr>
                      <td class="text-right">{{ $key+1 }}</td>
                      <td>{{ $product->product_category->name }}</td>
                      <td>{{ $product->name }}</td>
                      <td>{{ $product->stock }}</td>
                      <td>{{ $product->noted }}</td>
                      <td class="action text-nowrap text-right">
                          <a href="{{ route('products.show', [$product]) }}" class="btn btn-success btn-sm btn-xs">Detail</a>
                      </td>
                  </tr>
              @endforeach
              </tbody>
          </table>
      </div>
    @endcomponent
  </div>
</div>
@endsection
