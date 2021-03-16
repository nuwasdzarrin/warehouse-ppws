@extends('layouts.app')

@section('content-title', ucwords(__('transaction_report.plural')))

@section('content')
    @php
        /** @var \App\Transaction $transactions */
        $transaction_in = $transactions->map(function ($transaction) {
            return collect([
                'key' => $transaction->created_at->format('d M, h:s'),
                'value' => $transaction->in_out=='in'?((int)$transaction->amount):0
                ]);
        });
        $transaction_out = $transactions->map(function ($transaction) {
            return collect([
                'key' => $transaction->created_at->format('d M, h:s'),
                'value' => $transaction->in_out=='out'?$transaction->amount:0
                ]);
        });
        $stock= [];
        if (request()->product_id) {
            $temp = 0;
            foreach ($transactions as $key => $transaction) {
                if ($transaction->in_out=='in') {
                    $temp += $transaction->amount;
                } else {
                    $temp -= $transaction->amount;
                }
                array_push($stock, collect([
                    'key' => $transaction->created_at->format('d M, h:s'),
                    'value' => $temp
                ]));
            }
        }
    @endphp
    <div class="row">
        <div class="col-md-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Grafik Transaksi</h5>
                </div>
                <div class="ibox-content">
                    <div>
                        <canvas id="lineChart" height="80"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{--    chart display none for chartImg--}}
    <div>
        <div id="my_dataviz" style="display: none"></div>
    </div>
    <script>
        let dataset = @json($transaction_out);
        let dataset_in = @json($transaction_in);
        let dataset_stock = @json($stock);
        // set the dimensions and margins of the graph
        let margin = {
                top: 20,
                right: 20,
                bottom: 120,
                left: 50
            },
            width = 600 - margin.left - margin.right,
            height = 400 - margin.top - margin.bottom;

        // set the ranges
        let x = d3.scalePoint().range([0, width]);
        let y = d3.scaleLinear().range([height, 0]);

        // define the line
        let valueline = d3.line()
            .x(function(d) {
                return x(d.key);
            })
            .y(function(d) {
                return y(d.value);
            });
        // append the svg obgect to the body of the page
        // appends a 'group' element to 'svg'
        // moves the 'group' element to the top left margin
        let svg = d3.select("#my_dataviz")
            .append("svg")
            .attr("width", width + margin.left + margin.right)
            .attr("height", height + margin.top + margin.bottom)
            .append("g")
            .attr("transform",
                "translate(" + margin.left + "," + margin.top + ")");

        function maxValue(arr) {
            let max = arr[0];
            for (let val of arr) {
                if (val > max) {
                    max = val;
                }
            }
            return max;
        }

        function findMaxYAxis(data, data1, data2) {
            let maxY = [];
            maxY[0] = d3.max(data, function(d) {
                return d.value;
            });
            maxY[1] = d3.max(data1, function(d) {
                return d.value;
            });
            maxY[2] = d3.max(data2, function(d) {
                return d.value;
            });
            return maxValue(maxY);
        }

        function draw(data, data1, data2) {

            data.forEach(function(d) {
                d.value = +d.value;
            });

            // Scale the range of the data
            x.domain(data.map(function(d) {
                return d.key;
            }));
            y.domain([0, findMaxYAxis(data, data1, data2)]);

            // Add the valueline path.
            svg.append("path")
                .datum(data)
                // .attr("class", "line-out")
                .attr("fill", "none")
                .attr("stroke", "rgb(165,54,54)")
                .attr("stroke-width", 3)
                .attr("d", valueline);

            //dataset2
            svg.append("path")
                .datum(data1)
                // .attr("class", "line-in")
                .attr("fill", "none")
                .attr("stroke", "rgba(26,179,148,0.7)")
                .attr("stroke-width", 3)
                .attr("d", valueline);

            if (data2) {
                //dataset3
                svg.append("path")
                    .datum(data2)
                    // .attr("class", "line-stock")
                    .attr("fill", "none")
                    .attr("stroke", "rgba(155,201,196,0.7)")
                    .attr("stroke-width", 3)
                    .attr("d", valueline);
            }

            svg.append("g")
                .attr("transform", "translate(0," + height + ")")
                .call(d3.axisBottom(x))
                .selectAll("text")
                .attr("transform", "translate(-10,10)rotate(-45)")
                .style("text-anchor", "end");

            // Add the Y Axis
            svg.append("g")
                .call(d3.axisLeft(y));
        }
        draw(dataset, dataset_in, dataset_stock);
    </script>
{{--    end of chart display none for chartImg--}}

    <div class="row">
      <div class="col-md-12">
        @component(config('generator.view_component').'components.panel')
          @slot('title')
            {{ ucwords(__('transaction_report.plural')) }}
          @endslot
          @slot('tools')
              <div class="ibox-tools">
                  <form action="{{ route('transaction_report.print') }}" method="POST">
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
              <form id="search" method="GET" class="form">
                  <div class="row" style="margin-bottom: 15px;">
                      <div class="col-xs-6 col-6 col-md-4">
                          <div class="input-group">
                              <span class="input-group-btn input-group-prepend">
                                  <button type="submit" class="btn btn-default btn-secondary btn-sm">&nbsp;<i class="fa fa-search"></i>&nbsp;</button>
                              </span>
                              <input type="text" name="search" placeholder="Cari" value="" autofocus="autofocus" class="input-sm form-control form-control-sm">
                          </div>
                      </div>
                      <div class="col-xs-6 col-6 col-md-8">
                          <div class="text-right">
                              <span>1 - 2 dari 2</span>&nbsp;
                              <div style="display: inline-block;">
                                  <select name="per_page" id="per_page" onchange="this.form.submit()" title="per page" class="form-control form-control-sm input-sm">
                                      <option value="15">15</option>
                                      <option value="50">50</option>
                                      <option value="100">100</option>
                                      <option value="250">250</option>
                                  </select>
                              </div>
                          </div>
                      </div>
                  </div>
              </form>
              <div class="table-responsive">
                  <table id="transactions" class="table table-striped table-hover table-condensed table-sm">
                      <thead class="text-nowrap">
                      <tr>
                          <th width="1px" class="text-center">No</th>
                          <th class="text-center">Tanggal Transaksi</th>
                          <th class="text-center">Produk</th>
                          <th class="text-center" style="width: 85px;">Tipe</th>
                          <th class="text-center">Status</th>
                          <th class="text-center">User</th>
                          <th class="text-center">Petugas Lapangan</th>
                          <th class="text-center">Jumlah</th>
                          <th class="text-center">Keterangan</th>
                      </tr>
                      </thead>
                      <tbody>
                      <tr>
                          <td></td>
                          <td></td>
                          <td>
                              <select2-ajax
                                  class="form-control"
                                  name="product_id"
                                  form="search"
                                  onchange="this.form.submit()"
                                  url="/api/products"
                                  :params="{institution_id: {{request()->cookie('institution_id')}} }"
                                  text-property="name"
                                  value="{{ request()->query('product_id') }}"
                                  placeholder="{{ __('All') }}"
                              >
                              </select2-ajax>
                          </td>
                          <td>
                              <select name="in_out" id="in_out" form="search" onchange="this.form.submit()" title="type" class="form-control">
                                  <option value="">All</option>
                                  <option value="in" {{request()->in_out=='in'?'selected':''}}>Masuk</option>
                                  <option value="out" {{request()->in_out=='out'?'selected':''}}>Keluar</option>
                              </select>
                          </td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                      </tr>
                      @foreach($transactions as $key => $transaction)
                      <tr>
                          <td class="text-right">{{$key+1}}</td>
                          <td>{{ $transaction->created_at_for_human }}</td>
                          <td>{{ $transaction->product->name }}</td>
                          <td>
                              @if($transaction->in_out=='in')
                                  <span class="bg-info" style="padding: 2px 5px; border-radius: 3px"><i class="fa fa-download"></i> Masuk</span>
                              @else
                                  <span class="bg-danger" style="padding: 2px 5px; border-radius: 3px"><i class="fa fa-upload"></i> Keluar</span>
                              @endif
                          </td>
                          <td>{{ $transaction->transaction_status->name }}</td>
                          <td>{{ $transaction->user->name }}</td>
                          <td>{{ $transaction->officer }}</td>
                          <td>{{ $transaction->amount }}</td>
                          <td>{{ $transaction->noted }}</td>
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
    <script src="js/plugins/chartJs/Chart.min.js"></script>
{{--    <script src="js/demo/chartjs-demo.js"></script>--}}
    @php
        $indo_month = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        /** @var \App\Transaction $transactions */
        $labels = $transactions->map(function ($transaction) use ($indo_month) {
            return $transaction->created_at->format('j').' '.$indo_month[$transaction->created_at->format('n')-1];
        });
        $transaction_in = $transactions->map(function ($transaction) {
            return $transaction->in_out=='in'?$transaction->amount:'0';
        });
        $transaction_out = $transactions->map(function ($transaction) {
            return $transaction->in_out=='out'?$transaction->amount:'0';
        });
        $stock= [];
        if (request()->product_id) {
            $temp = 0;
            foreach ($transactions as $key => $transaction) {
                if ($transaction->in_out=='in') {
                    $temp += $transaction->amount;
                } else {
                    $temp -= $transaction->amount;
                }
                array_push($stock, $temp);
            }
        }
    @endphp
    <script>
        $(function () {
            let lineData = {
                labels: @json($labels),
                datasets: [
                    {
                        label: "Stok",
                        backgroundColor: 'transparent',
                        borderColor: "rgba(155,201,196,0.7)",
                        pointBackgroundColor: "rgb(145,173,170)",
                        pointBorderColor: "#fff",
                        data: @json($stock)
                    },
                    {
                        label: "Trx Masuk",
                        backgroundColor: 'transparent',
                        borderColor: "rgba(26,179,148,0.7)",
                        pointBackgroundColor: "rgba(26,179,148,1)",
                        pointBorderColor: "#fff",
                        data: @json($transaction_in)
                    },
                    {
                        label: "Trx Keluar",
                        backgroundColor: 'transparent',
                        borderColor: "rgb(165,54,54)",
                        pointBackgroundColor: "rgb(179,26,26)",
                        pointBorderColor: "#fff",
                        data: @json($transaction_out)
                    },
                ]
            }
            let lineOptions = {
                responsive: true
            };
            let ctx = document.getElementById("lineChart").getContext("2d");
            new Chart(ctx, {type: 'line', data: lineData, options:lineOptions});
        });
    </script>
@endpush
