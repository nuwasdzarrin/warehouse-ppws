@extends('inspinia::layouts.main')

@push('head')
    <link href="{{ asset('/css/custom.css') }}" rel="stylesheet">
    <link rel="icon" sizes="192x192" type="png/ico" href="{{ asset('images/logo-small.png') }}">
@endpush

@if (auth()->check())
@section('user-avatar', 'https://www.gravatar.com/avatar/' . md5(auth()->user()->email) . '?d=mm')
@section('user-name', auth()->user()->name)
@section('user-text', ucwords(auth()->user()->role ? auth()->user()->role->display_name: 'staff'))
@endif

@section('breadcrumbs', Breadcrumbs::render())

@push('navbar-bottom')
    <nav class="navbar bg-primary navbar-fixed-bottom bottom-nav-custom hidden-md hidden-lg">
        <div class="navbar-nav nav-justified list-bottom-nav-custom">
            <a href="{{ route('transaction_ins.create') }}" class="navbar-btn text-white text-center {{request()->is('transaction_ins/create')? 'bottom-active': ''}}"><i class="fa fa-plus-square"></i></a>
            <a href="{{ route('transaction_outs.create') }}" class="navbar-btn text-white text-center {{request()->is('transaction_outs/create')? 'bottom-active': ''}}"><i class="fa fa-minus-square"></i></a>
            <a href="{{ route('products.index') }}" class="navbar-btn text-white text-center {{request()->is('products*')? 'bottom-active': ''}}"><i class="fa fa-th"></i></a>
            <a href="{{ route('transaction_ins.index') }}" class="navbar-btn text-white text-center {{request()->is('transaction_ins')? 'bottom-active': ''}}"><i class="fa fa-download"></i></a>
            <a href="{{ route('transaction_outs.index') }}" class="navbar-btn text-white text-center {{request()->is('transaction_outs')? 'bottom-active': ''}}"><i class="fa fa-upload"></i></a>
        </div>
    </nav>
@endpush

@section('sidebar-menu')
  <ul class="nav metismenu" id="side-menu" style="padding-left:0px;">
    @if(auth()->user()->hasRole('staff'))
      <li class="{{request()->is('transaction_ins/create')? 'active': ''}}">
          <a href="{{ route('transaction_ins.create') }}"><i class="fa fa-plus-square"></i> <span class="nav-label">{{ ucwords('buat trx masuk') }}</span></a>
      </li>
      <li class="{{request()->is('transaction_outs/create')? 'active': ''}}">
          <a href="{{ route('transaction_outs.create') }}"><i class="fa fa-minus-square"></i> <span class="nav-label">{{ ucwords('buat trx keluar') }}</span></a>
      </li>
      <li class="{{request()->is('products*')? 'active': ''}}">
          <a href="{{ route('products.index') }}"><i class="fa fa-th"></i> <span class="nav-label">{{ ucwords(__('products.plural')) }}</span></a>
      </li>
      <li class="{{request()->is('transaction_ins')? 'active': ''}}">
          <a href="{{ route('transaction_ins.index') }}"><i class="fa fa-download"></i> <span class="nav-label">{{ ucwords('trx masuk') }}</span></a>
      </li>
      <li class="{{request()->is('transaction_outs')? 'active': ''}}">
          <a href="{{ route('transaction_outs.index') }}"><i class="fa fa-upload"></i> <span class="nav-label">{{ ucwords('trx keluar') }}</span></a>
      </li>
    @else
    <li class="{{request()->is('product_categories*')? 'active': ''}}">
      <a href="{{ route('product_categories.index') }}"><i class="fa fa-th-list"></i> <span class="nav-label">{{ ucwords(__('product_categories.plural')) }}</span></a>
    </li>
    <li class="{{request()->is('products*')? 'active': ''}}">
      <a href="{{ route('products.index') }}"><i class="fa fa-th"></i> <span class="nav-label">{{ ucwords(__('products.plural')) }}</span></a>
    </li>
    <li class="{{request()->is('transaction_ins*')||request()->is('transaction_outs*')? 'active': ''}}">
      <a href="#"><i class="fa fa-exchange"></i> <span class="nav-label">Transaksi</span><span class="fa arrow"></span></a>
      <ul class="nav nav-second-level {{request()->is('transaction_ins*')||request()->is('transaction_outs*')? 'mm-show': ''}}">
          <li class="{{request()->is('transaction_ins*')? 'active': ''}}">
              <a href="{{ route('transaction_ins.index') }}"><i class="fa fa-download"></i> <span class="nav-label">Trx Masuk</span></a>
          </li>
          <li class="{{request()->is('transaction_outs*')? 'active': ''}}">
              <a href="{{ route('transaction_outs.index') }}"><i class="fa fa-upload"></i> <span class="nav-label">Trx Keluar</span></a>
          </li>
      </ul>
    </li>
    <li class="{{request()->is('stock_report*')||request()->is('transaction_report*')? 'active': ''}}">
      <a href="#"><i class="fa fa-address-book"></i> <span class="nav-label">Laporan</span><span class="fa arrow"></span></a>
      <ul class="nav nav-second-level {{request()->is('stock_report*')||request()->is('transaction_report*')? 'mm-show': ''}}">
          <li class="{{request()->is('stock_report*')? 'active': ''}}">
              <a href="{{ route('stock_report') }}"><i class="fa fa-book"></i> <span class="nav-label">Laporan Stok</span></a>
          </li>
          <li class="{{request()->is('transaction_report*')? 'active': ''}}">
              <a href="{{ route('transaction_report') }}"><i class="fa fa-file"></i> <span class="nav-label">Laporan Transaksi</span></a>
          </li>
      </ul>
    </li>
    <li class="{{request()->is('users*')? 'active': ''}}">
      <a href="{{ route('users.index') }}"><i class="fa fa-users"></i> <span class="nav-label">Pengguna</span></a>
    </li>
      @if(auth()->user()->hasRole('superadmin'))
      <li class="{{request()->is('roles*')||request()->is('institutions*')||request()->is('transaction_statuses*')? 'active': ''}}">
          <a href="#"><i class="fa fa-user-secret"></i> <span class="nav-label">Super Admin</span><span class="fa arrow"></span></a>
          <ul class="nav nav-second-level {{request()->is('roles*')||request()->is('institutions*')||request()->is('transaction_statuses*')? 'mm-show': ''}}">
              <li class="{{request()->is('roles*')? 'active': ''}}">
                  <a href="{{ route('roles.index') }}"><i class="fa fa-list-alt"></i> <span class="nav-label">Role</span></a>
              </li>
              <li class="{{request()->is('institutions*')? 'active': ''}}">
                  <a href="{{ route('institutions.index') }}"><i class="fa fa-institution"></i> <span class="nav-label">{{ ucwords(__('institutions.plural')) }}</span></a>
              </li>
              <li>
                  <a href="{{ route('transaction_statuses.index') }}"><i class="fa fa-list-ul"></i> <span class="nav-label">Trx Status</span></a>
              </li>
          </ul>
      </li>
      @endif
      @endif
  </ul>
@endsection

@section('scripts')
    <script src="{{ mix('/js/manifest.js') }}" charset="utf-8"></script>
    <script src="{{ mix('/js/vendor.js') }}" charset="utf-8"></script>
    <script src="{{ mix('/js/app.js') }}" charset="utf-8"></script>
    <script>
{{--        double click to full screen--}}
        function getFullscreenElement() {
            return document.fullscreenElement
                || document.mozFullScreenElement
                || document.webkitFullscreenElement
                || document.msFullscreenElement;
        }
        function toggleFullscreen() {
            if (getFullscreenElement()) document.exitFullscreen();
            else document.documentElement.requestFullscreen().catch(console.log)
        }
        document.addEventListener('dblclick', () => {
            toggleFullscreen();
        });
    </script>
@endsection
