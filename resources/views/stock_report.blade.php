@extends('layouts.app')

@section('content-title', ucwords(__('stock_report.plural')))

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Grafik Stok Barang</h5>
                </div>
                <div class="ibox-content">
                    @if($products->count())
                    <div>
                        <canvas id="barChart" height="90"></canvas>
                    </div>
                    <div class="row m-t-sm">
                        <div class="col-md-8 col-md-offset-2">
                            <h5>Keterangan:</h5>
                            <table class="table table-borderless">
                                @foreach($products as $key => $product)
                                    @if($key%2==0)
                                        <tr>
                                            <td>{{ $product->abbreviation_name }}</td>
                                            <td>:</td>
                                            <td>{{ $product->name }}</td>
                                    @else
                                            <td class="text-right">{{ $product->abbreviation_name }}</td>
                                            <td>:</td>
                                            <td>{{ $product->name }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                                @if(($products->count())%2==1)
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        @component(config('generator.view_component').'components.panel')
          @slot('title')
            {{ ucwords(__('stock_report.plural')) }}
          @endslot
          @slot('tools')
              <div class="ibox-tools">
                  <a href="{{ route('stock_report', ['pdf']) }}" class="btn btn-primary btn-sm">
                      <i class="fa fa-print"></i> Cetak Laporan
                  </a>
              </div>
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
                      <th class="text-center">
                          Nama
                          <a href="http://instock.test/products?sort=name%2Cdesc">
                              <i class="fa fa-sort text-muted"></i>
                          </a>
                      </th>
                      <th class="text-center">Stok</th>
                      <th class="text-center">Keterangan</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                      <td></td>
                      <td></td>
                      <td>
                          <input name="name" value="" placeholder="Semua" form="search" class="form-control">
                      </td>
                      <td></td>
                      <td></td>
                  </tr>
                  @foreach($products as $key => $product)
                  <tr>
                      <td class="text-right">{{ $key+1 }}</td>
                      <td>
                          <a href="http://instock.test/product_categories/2?redirect=http%3A%2F%2Finstock.test%2Fproducts">
                              {{ $product->product_category->name }}
                          </a>
                      </td>
                      <td>{{ $product->name }}</td>
                      <td>{{ $product->stock }}</td>
                      <td>{{ $product->noted }}</td>
                  </tr>
                  @endforeach
                  </tbody>
              </table>
          </div>
        @endcomponent
      </div>
    </div>
@endsection
@push('body')
    <!-- ChartJS-->
    <script src="/js/plugins/chartJs/Chart.min.js"></script>
    @if($products->count())
        @php
            /** @var \App\Product $products */
            $labels = $products->map(function ($product) {
                return $product->abbreviation_name;
            });
            $labels_name = $products->map(function ($product) {
                return $product->name;
            });
            $value = $products->map(function ($product) {
                return $product->stock;
            });
        @endphp
        <script>
            $(function () {
                console.log(@json($labels));
                console.log(@json($labels_name));
                console.log(@json($value));
                let barData = {
                    labels: @json($labels),
                    labels_name: @json($labels_name),
                    datasets: [
                        {
                            label: "Barang",
                            backgroundColor: 'rgba(26,179,148,0.5)',
                            borderColor: "rgba(26,179,148,0.7)",
                            pointBackgroundColor: "rgba(26,179,148,1)",
                            pointBorderColor: "#fff",
                            data: @json($value),
                        }
                    ]
                };

                let barOptions = {
                    responsive: true,
                    tooltips: {
                        callbacks: {
                            title: function (tooltipItem, data) {
                                return data.labels_name[tooltipItem[0].index];
                            },
                            label: function (tooltipItem, data) {
                                return 'Tersisa: '+Math.round(data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index]);
                            }
                        }
                    }
                };

                var ctx2 = document.getElementById("barChart").getContext("2d");
                new Chart(ctx2, {type: 'horizontalBar', data: barData, options:barOptions});
            });
        </script>
    @endif
@endpush
