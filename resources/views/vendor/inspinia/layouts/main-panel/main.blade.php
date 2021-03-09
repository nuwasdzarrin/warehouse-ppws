@php
    $institution_id = request()->cookie('institution_id');
    $product_limit = \App\Product::query()->when(auth()->user()->hasRole(['superadmin']), function (\Illuminate\Database\Eloquent\Builder $query) use ($institution_id) {
        return $query->where('institution_id', $institution_id);
    })->where('stock','<=','5')->orderByDesc('updated_at')->get();
@endphp
<div id="page-wrapper" class="gray-bg">
  <div class="row border-bottom">
    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
      <div class="navbar-header">
        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
      </div>
      <ul class="nav navbar-top-links navbar-right" style="float: right;">
        <li class="dropdown">
          <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
           <i class="fa fa-bell"></i>  <span class="label label-primary">{{ $product_limit->count() }}</span>
          </a>
          <ul class="dropdown-menu dropdown-alerts">
              @foreach($product_limit as $key => $p)
                  @if($key<5)
                      <li>
                          <a href="{{ route('products.show', [$p]) }}">
                              <div>
                                  <i class="fa fa-bell fa-fw"></i> {{ $p->name }}
                              </div>
                          </a>
                      </li>
                      <li class="divider"></li>
                  @endif
              @endforeach
              <li>
                  <div class="text-center link-block">
                      <a href="{{ route('notification') }}">
                          <strong>Lihat semua notifikasi</strong>
                          <i class="fa fa-angle-right"></i>
                      </a>
                  </div>
              </li>
          </ul>
        </li>
        <li>
         <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
           {{ csrf_field() }}
         </form>
         <a href="" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            <i class="fa fa-sign-out"></i>Logout
         </a>
        </li>
      </ul>
    </nav>
      @stack('navbar-bottom')
  </div>
  <div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-xs-6 col-lg-8">
      <h2>@yield('content-title', 'Title')</h2>
      @section('breadcrumbs')
      <ol class="breadcrumb">
        <li>
          <a href="#">Home</a>
        </li>
        <li class="active">
          <strong>Breadcrumb</strong>
        </li>
      </ol>
      @show
    </div>
{{--      {{ request()->cookie('institution_id') }}--}}
      @if(request()->routeIs(['product_categories.index','products.index','transaction_ins.index','transaction_outs.index','stock_report','transaction_report']))
      <div class="col-xs-6 col-lg-4">
          <div class="m-t-lg" style="display: flex; justify-content: flex-end">
              <form id="search-institution" method="POST" action="{{ route('institutions.cookie', [ 'redirect' => url()->full() ]) }}" class="form">
                  @csrf
                  <div class="form-group">
                      <div class="input-group rounded-select">
                          <span class="input-group-addon hidden-xs" style="text-transform: capitalize; font-weight: 400; font-size: 14px; padding-left: 20px; padding-right: 20px; border: none; color: rgb(112, 112, 112);">Lembaga: </span>
                          <select2-ajax
                              class="form-control"
                              name="institution_id"
                              form="search-institution"
                              onchange="this.form.submit()"
                              url="/api/institutions"
                              text-property="name"
                              value="{{ request()->cookie('institution_id') }}"
                              allow-clear="0"
                          >
                          </select2-ajax>
                      </div>
                  </div>
              </form>
          </div>
      </div>
      @endif
    {{-- <div class="col-sm-8">
      <div class="title-action">
        <a href="" class="btn btn-primary">This is action area</a>
      </div>
    </div> --}}
  </div>

  <div class="wrapper wrapper-content">
    @yield('content')
  </div>
  @include('inspinia::layouts.main-panel.footer.main')
</div>
