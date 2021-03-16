@extends('layouts.app')

@section('content-title', ucwords(__('stock_report.plural')))

@section('content')
    @php
            /** @var \App\Product $products */
        $dataset = $products->map(function ($p) {
            return collect([
                'Key' => $p->abbreviation_name,
                'Value' => $p->stock
            ]);
        });
    @endphp
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
{{--    grafik 2 display none for pdf--}}
    <div>
        <div id="my_dataviz" style="display: none"></div>
    </div>
    <script>
        let margin = {top: 20, right: 30, bottom: 40, left: 90},
            width = 600 - margin.left - margin.right,
            height = 400 - margin.top - margin.bottom;

        // append the svg object to the body of the page
        let svg = d3.select("#my_dataviz")
            .append("svg")
            .attr("width", width + margin.left + margin.right)
            .attr("height", height + margin.top + margin.bottom)
            .append("g")
            .attr("transform",
                "translate(" + margin.left + "," + margin.top + ")");

        data = @json($dataset);

        // Add X axis
        let x = d3.scaleLinear()
            .domain([0, d3.max(data, function(d) {
                return d.Value;
            })])
            .range([ 0, width]);
        svg.append("g")
            .attr("transform", "translate(0," + height + ")")
            .call(d3.axisBottom(x))
            .selectAll("text")
            .attr("transform", "translate(-10,0)rotate(-45)")
            .style("text-anchor", "end");

        // Y axis
        let y = d3.scaleBand()
            .range([ 0, height ])
            .domain(data.map(function(d) { return d.Key; }))
            .padding(.1);
        svg.append("g")
            .call(d3.axisLeft(y))
            .selectAll("text")
            .attr("transform", "translate(-10,0)rotate(-45)")
            .style("text-anchor", "end");

        //Bars
        svg.selectAll("myRect")
            .data(data)
            .enter()
            .append("rect")
            .attr("x", x(0) )
            .attr("y", function(d) { return y(d.Key); })
            .attr("width", function(d) { return x(d.Value); })
            .attr("height", y.bandwidth() )
            .attr("fill", "#69b3a2");
    </script>
{{--    end of grafik 2 display none--}}

    <div class="row">
      <div class="col-md-12">
        @component(config('generator.view_component').'components.panel')
          @slot('title')
            {{ ucwords(__('stock_report.plural')) }}
          @endslot
          @slot('tools')
              <div class="ibox-tools">
                  <form action="{{ route('stock_report.print') }}" method="POST">
                      @csrf
                      <div class="form-group">
                          <input type="hidden" name="pdf" value="true">
                          <input type="hidden" name="chartImg" id="chartImg">
                          <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-print"></i> Cetak Laporan</button>
                      </div>
                  </form>
                  <script type="text/javascript">
                      var s = new XMLSerializer().serializeToString(document.getElementById("my_dataviz").firstChild);
                      var encodedData = 'data:image/svg+xml;base64,' + window.btoa(s);
                      document.getElementById("chartImg").value = encodedData;
                  </script>
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
@push('head')
    <script src="https://d3js.org/d3.v4.min.js"></script>
@endpush
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
