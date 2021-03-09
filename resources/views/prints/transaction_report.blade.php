<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="content-type">
    <script src="https://d3js.org/d3.v4.min.js"></script>
{{--    <script src="https://d3js.org/d3-scale-chromatic.v1.min.js"></script>--}}
    <style type="text/css">
        @import url('https://themes.googleusercontent.com/fonts/css?kit=uTXSPZwEp3TWQFaTM2vlS3s421DlrhI9eSNlJenMRKM_aAifJoacbFX6HU9PyTi6');
        @import url('https://fonts.googleapis.com/css?family=Roboto+Mono:400,500&display=swap');
        * {
            box-sizing: content-box;
        }

        html {
            margin: 0;
            padding: 0;
            background-color: #FFFFFF;
        }

        body {
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            padding: 10px 10px 0 10px;
        }

        .page {
            position: relative;
            height: 1927px;
            margin: 0;
            padding: 10px 0 0;
        }

        .page:first-child {
            padding: 0;
        }

        .last-page {
            position: relative;
            height: 1827px;
            margin: 0;
            padding: 10px 0 0;
        }

        .wrapper {
            position: relative;
            padding: 0 90px;
        }

        .header {
            position: relative;
            box-sizing: border-box;
            width: 100%;
            height: 45px;
            background-color: #004492;
            border-radius: 5px 5px 0 0;
            text-align: right;
            padding: 15px 35px;
        }

        .title-container {
            padding-top: 60px;
        }

        .title-container .title {
            text-align: center;
            font: 700 35px/47px Open Sans;
            letter-spacing: 0;
            color: #000000;
            text-transform: uppercase;
            opacity: 1;
            margin: 0;
        }

        .title-container .subtitle {
            text-align: center;
            font: 600 20px/27px Open Sans;
            letter-spacing: 0;
            color: #004492;
            text-transform: uppercase;
            opacity: 1;
            margin: 0;
        }

        .pond .title-container .title {
            text-align: left;
        }

        .pond .title-container .subtitle {
            text-align: left;
        }

        .finance-general, .pond-general {
            margin-top: 30px;
        }

        .finance-summary {
            margin-top: 55px;
        }

        .finance-summary .hpp-title {
            margin-bottom: -10px;
            font: 600 25px/34px Open Sans;
        }

        .finance-summary .caption-hpp-title {
            font: normal 12px/17px Open Sans;
            letter-spacing: 0;
            color: #000000;
            opacity: 1;
        }

        .finance-summary .content-hpp {
            font: normal 16px/22px Open Sans;
            letter-spacing: 0;
            color: #000000;
            opacity: 1;
        }

        .finance-summary .result-hpp {
            font: Bold 20px/27px Open Sans;
            letter-spacing: 0;
            color: #000000;
            opacity: 1;
        }

        .key-value {
            margin-bottom: 10px;
        }

        .key-value .key {
            display: inline-block;
            vertical-align: middle;
            width: 220px;
        }

        .key-value .separator {
            display: inline-block;
            vertical-align: middle;
            margin: 0 10px;
        }

        .key-value .value {
            display: inline-block;
            vertical-align: middle;
            margin: 0 10px;
            width: 500px;
        }

        .finance-summary .left-item {
            width: 575px;
            float: left;
            text-align: left;
            padding: 10px 10px;
            display: inline-block;
            vertical-align: top;
        }

        .finance-summary .vertical-line {
            margin-top: 30px;
            text-align: center;
            border: 1px solid #3C8AE3;
            height: 1400px;
            display: inline-block;
            vertical-align: top;
        }

        .finance-summary .right-item {
            width: 575px;
            float: right;
            text-align: left;
            padding: 10px 10px;
            display: inline-block;
            vertical-align: top;
        }

        .summary-spending {
            height: 450px;
        }

        .left-legend {
            width: 250px;
            float: left;
            text-align: left;
            padding: 10px 10px;
            display: inline-block;
            vertical-align: top;
        }

        .right-legend {
            width: 250px;
            float: left;
            text-align: left;
            padding: 10px 10px;
            display: inline-block;
            vertical-align: top;
        }

        .finance-summary .analisis-hpp-left {
            width: 180px;
            float: left;
            text-align: left;
            padding: 10px 5px;
            display: inline-block;
            vertical-align: top;
        }

        .finance-summary .analisis-hpp-right {
            width: 350px;
            float: left;
            text-align: left;
            padding: 10px 5px;
            display: inline-block;
            vertical-align: top;
        }

        .finance-summary .sama-dengan {
            max-width: 10px;
            float: left;
            padding: 22px 5px;
        }

        .sama-dengan .sama-dengan-list {
            margin-top: 5px;
            margin-bottom: 15px;
        }

        .section-title {
            text-align: left;
            font: 700 18px/24px Open Sans;
            letter-spacing: 0;
            color: #3B8AE3;
            text-transform: uppercase;
            opacity: 1;
            margin-bottom: 0;
        }

        .title-underline {
            left: 0;
            width: 239px;
            height: 4px;
            background: #3C8AE3 0 0 no-repeat padding-box;
            border-radius: 5px;
            opacity: 1;
            margin-top: 2px;
        }

        .summary-item {
            width: 292px;
            text-align: center;
            padding: 30px 45px;
            display: inline-block;
            vertical-align: top;
        }

        .summary-item img {
            margin-bottom: 20px;
        }

        .summary-item h4 {
            margin: 0;
            text-align: center;
            font: 700 18px/22px Open Sans;
            letter-spacing: 0;
            color: #000000;
        }

        .description {
            text-align: center;
            font: 400 16px/22px Open Sans;
            letter-spacing: 0;
            color: #000000;
        }

        .legend {
            margin-top: 35px;
        }

        .legend-item {
            padding-right: 35px;
            display: inline-block;
            vertical-align: middle;
        }

        .color-box {
            display: inline-block;
            vertical-align: middle;
            border-radius: 7px;
            margin-right: 12px;
            width: 45px;
            height: 20px;
        }

        .color-box.box-default {
            background: #FFFFFF 0 0 no-repeat padding-box;
            border: 1px solid #707070;
            opacity: 1;
        }

        .color-box.box-success {
            background: #62B275 0 0 no-repeat padding-box;
            border: 1px solid #62B275;
            opacity: 1;
        }

        .color-box.box-orange {
            background: #F5B468 0 0 no-repeat padding-box;
            border: 1px solid #F5B468;
            opacity: 1;
        }

        .color-box.box-danger {
            background: #B74D4D 0 0 no-repeat padding-box;
            border: 1px solid #B74D4D;
            opacity: 1;
        }

        .legend-label {
            display: inline-block;
            vertical-align: middle;
            font: 400 16px/22px Open Sans;
            letter-spacing: 0;
            color: #434343;
            width: 192px;
        }

        .column-number {
            text-align: right!important;
        }

        .column-date {
            text-align: center!important;
        }

        .report-table {
            margin-top: 25px;
        }

        .report-table table {
            width: 100%;
            border-spacing: 0;
        }

        .report-table table thead tr {
            background: #E5E5E5 0 0 no-repeat padding-box;
            opacity: 1;
        }

        .report-table table thead tr th {
            color: #1B77DF;
            padding: 10px;
            text-align: left;
        }

        .report-table table td {
            border-bottom: 2px solid #D3D3D3;
        }

        .bottom-white {
            border-top: 1px solid #ffffff!important;
            border-bottom: none!important;
            color: #ffffff!important;
        }

        .border-date {
            border-left: 1px solid #979797;
            border-right: 1px solid #979797;
        }

        .report-table table thead tr th:nth-child(1) {
            padding-left: 20px;
        }

        .report-table table tbody tr.row-success {
            background: #1FA543 0 0 no-repeat padding-box;
            opacity: 1;
        }

        .report-table table tbody tr.row-blue {
            background: #71A1D2 0% 0% no-repeat padding-box;
            opacity: 1;
            color: #ffffff;
        }

        .report-table table tbody tr.row-old-grey {
            background: #C4C4C4 0% 0% no-repeat padding-box;
            opacity: 1;
        }

        .report-table table tfoot tr {
            background: #6EA3D9 0% 0% no-repeat padding-box;
            opacity: 1;
        }

        .report-table table tfoot tr.row-danger {
            background: #B74D4D 0 0 no-repeat padding-box;
            opacity: 1;
        }

        .report-table table tbody td.row-danger {
            background: #B74D4D 0 0 no-repeat padding-box;
            opacity: 1;
        }

        .report-table table tbody tr.row-success {
            background: #62B275 0% 0% no-repeat padding-box;
            opacity: 1;
        }

        .report-table table tbody td.row-success {
            background: #62B275 0% 0% no-repeat padding-box;
            opacity: 1;
        }

        .report-table table tbody td.row-orange {
            background: #FFDCA3 0% 0% no-repeat padding-box;
            opacity: 1;
        }

        .report-table table tbody tr.row-success td,
        .report-table table tbody tr.row-danger td {
            color: #FFFFFF;
        }

        .report-table table tbody tr td {
            padding: 10px;
            text-align: left;
            font: 400 16px/22px Open Sans;
            letter-spacing: 0;
            color: #707070;
            opacity: 1;
        }

        .report-table table tbody tr td:nth-child(1) {
            padding-left: 20px;
        }

        .report-table table tbody tr td:last-child {
            padding-right: 20px;
        }

        .report-table table tfoot tr th {
            color: #ffffff;
            padding: 10px;
            text-align: left;
        }

        thead { display: table-header-group; }
        tfoot { display: table-row-group; }
        tr { page-break-inside: avoid; }

        /*repot table 1*/
        .report-table1 {
            margin-top: 25px;
        }

        .report-table1 table {
            width: 100%;
            border-spacing: 0;
        }

        .report-table1 table thead tr {
            background: #E5E5E5 0 0 no-repeat padding-box;
            opacity: 1;
        }

        .report-table1 table thead tr th {
            color: #1B77DF;
            padding: 10px;
            text-align: left;
        }

        .report-table1 table td {
            border-bottom: 1px solid #979797;
        }

        .report-table1 table thead tr th:nth-child(1) {
            padding-left: 20px;
        }

        .report-table1 table tbody tr.row-success {
            background: #1FA543 0 0 no-repeat padding-box;
            opacity: 1;
        }

        .report-table1 table tbody tr.row-blue {
            background: rgb(121, 159, 202) no-repeat padding-box;
            opacity: 1;
            color: #ffffff;
        }

        .report-table1 table tbody tr.row-old-grey {
            background: #979797 0 0 no-repeat padding-box;
            opacity: 1;
        }

        .report-table1 table tfoot tr {
            background: rgb(121, 159, 202) no-repeat padding-box;
            opacity: 1;
        }

        .report-table1 table tfoot tr.row-danger {
            background: #B74D4D 0 0 no-repeat padding-box;
            opacity: 1;
        }

        .report-table1 table tbody tr.row-success td,
        .report-table1 table tbody tr.row-danger td {
            color: #FFFFFF;
        }

        .report-table1 table tbody tr td {
            padding: 10px;
            text-align: left;
            font: 400 16px/22px Open Sans;
            letter-spacing: 0;
            color: #707070;
            opacity: 1;
        }

        .report-table1 table tbody tr td:last-child {
            padding-right: 20px;
        }

        .report-table1 table tfoot tr th {
            color: #ffffff;
            padding: 10px;
            text-align: left;
        }

        .text-white{
            color: #ffffff;
        }

        .text-old-grey{
            color: #676662;
        }

        .recap-note-title {
            text-align: left;
            font: 600 16px/22px Open Sans;
            letter-spacing: 0;
            color: #000000;
            opacity: 1;
        }

        .recap-note {
            margin-top: 20px;
        }

        .recap-note-list {
            padding-left: 25px;
        }

        .recap-note-list li {
            text-align: left;
            font: 400 16px/22px Open Sans;
            letter-spacing: 0;
            color: #000000;
            opacity: 1;
        }

        .sticker {
            position: absolute;
            top: 55px;
            right: 90px;
            width: 160px;
            padding: 20px 15px 15px;
            background: #E5E5E5 0 0 no-repeat padding-box;
            border-radius: 10px;
            opacity: 1;
        }

        .sticker-title {
            text-align: left;
            font: 700 38px/52px Open Sans;
            letter-spacing: 0;
            color: #707070;
            opacity: 1;
        }

        .sticker-note {
            margin-top: 5px;
            text-align: left;
            font: 400 13px/18px Open Sans;
            letter-spacing: 0;
            color: #707070;
            opacity: 1;
        }

        .pond-data {
            width: 911px;
            padding: 25px 32px;
            margin-top: 25px;
            background: #E5E5E5 0 0 no-repeat padding-box;
            border-radius: 10px;
            opacity: 1;
        }

        .col {
            max-width: 280px;
            margin-right: 7px;
            float: left;
        }

        .pond-data .key-value .key,
        .pond-data .key-value .separator,
        .pond-data .key-value .value {
            font-weight: 700;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        .pond-data .key-value .key {
            width: 188px;
        }

        .pond-data .key-value .separator {
            width: auto;
        }

        .pond-data .key-value .value {
            width: 200px;
        }

        .pond-summary {
            margin-top: 30px;
        }

        .pond-summary .recap-note {
            margin-top: 0;
        }

        .pond-sampling {
            margin-top: 40px;
        }

        .pond-sampling .description-wrapper {
            margin-top: 15px;
        }

        .pond-sampling .report-table table {
            width: auto;
        }

        .grid {
            margin-top: 22px;
        }

        .grid-item {
            display: inline-block;
            width: 365px;
            margin-bottom: 25px;
        }

        .grid-item img {
            display: inline-block;
            vertical-align: top;
            margin-right: 5px
        }

        .grid-item .description {
            display: inline-block;
            vertical-align: top;
            text-align: left;
            width: 280px;
        }

        .chart-container {
            margin-top: 32px;
        }

        .chart-details-container {
            padding: 5px 10px;
        }

        .chart-details-container .details {
            height: 160px;
            width: 260px;
            margin-top: 10px;
            background: #D8E3EF 0% 0% no-repeat padding-box;
            border-radius: 10px;
            opacity: 1;
            text-align: center;
        }

        .summary-span {
            border-radius: 17px;
            width: 180px!important;
            padding-bottom: 5px!important;
            padding-left: 0!important;
            padding-right: 25px!important;
            color: #ffffff!important;
            margin-bottom: 10px;
        }

        .span-red {
            background: #B74D4D 0% 0% no-repeat padding-box;
            opacity: 1;
        }

        .span-blue {
            background: #6EA3D9 0% 0% no-repeat padding-box;
            opacity: 1;
        }

        .span-light-blue {
            background-color: #64b3bb;
        }

        .span-green {
            background: #62B275 0% 0% no-repeat padding-box;
            opacity: 1;
        }

        .chart-details-container .details img,
        .chart-details-container .details span,
        .chart-details-container .details strong {
            display: inline-block;
            vertical-align: middle;
        }

        .chart-details-container.plain .details span {
            min-width: 125px;
        }

        .chart-details-container.plain .details span,
        .chart-details-container.plain .details strong {
            padding: 0 10px;
        }

        .chart-details-container.stacked .details img {
            vertical-align: top;
        }

        .chart-details-container.stacked .details-text {
            display: inline-block;
        }

        .chart-details-container.stacked .details span {
            color: #707070;
        }

        .chart-details-container.stacked .details span,
        .chart-details-container.stacked .details strong {
            width: 100%;
            padding: 0 10px;
        }

        .text-success {
            color: #1FA543;
        }

        .text-warning {
            color: #FF9D00;
        }

        .text-danger {
            color: #B74D4D;
        }

        .spacer {
            padding-top: 45px;
        }
        .line-in {
            fill: none;
            stroke: rgba(26,179,148,0.7);
            stroke-width: 3px;
        }
        .line-out {
            fill: none;
            stroke: rgb(165,54,54);
            stroke-width: 3px;
        }
        .line-stock {
            fill: none;
            stroke: rgba(155,201,196,0.7);
            stroke-width: 3px;
        }
    </style>
</head>
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
<body>

{{--page 2 arus pemasukan perbulan--}}
<div class="page">
{{--    <div class="header">--}}
{{--        <img src="{!! public_path('fonts/Jala.svg') !!}" alt="" style="height: 15px; float:right">--}}
{{--    </div>--}}
    <div class="wrapper">
        <div class="pond">
            <div class="ponds-recap">
                <h3 class="section-title">Detail Transaksi</h3>
                <hr class="title-underline" align="left">
                <span class="recap-note-title">Ini adalah detail dari transaksi keluar masuk</span>
                <div>
                    <div id="my_dataviz"></div>
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
                            .attr("class", "line-out")
                            .attr("d", valueline);

                        //dataset2
                        svg.append("path")
                            .datum(data1)
                            .attr("class", "line-in")
                            .attr("d", valueline);

                        if (data2) {
                            //dataset3
                            svg.append("path")
                                .datum(data2)
                                .attr("class", "line-stock")
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
                <div class="report-table">
                    <table>
                        <thead>
                        <tr>
                            <th width="1px" class="text-center">No</th>
                            <th class="text-center">Tanggal Transaksi</th>
                            <th class="text-center">Produk</th>
                            <th class="text-center" style="width: 85px;">Tipe</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">User</th>
                            <th class="text-center">Petugas Lapangan</th>
                            <th class="column-number">Jumlah</th>
                            <th class="text-center">Keterangan</th>
                        </tr>
                        </thead>
                        <tbody>
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
            </div>
        </div>
    </div>
</div>

</body>
</html>
