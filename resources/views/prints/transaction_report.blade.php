<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="content-type">
    <style type="text/css">
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

        .legend {
            margin-top: 35px;
        }

        .legend-item {
            padding-right: 35px;
            display: inline-block;
            vertical-align: middle;
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

        .recap-note-title {
            text-align: left;
            font: 600 16px/22px Open Sans;
            letter-spacing: 0;
            color: #000000;
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

        .pond-summary .recap-note {
            margin-top: 0;
        }

        .pond-sampling .description-wrapper {
            margin-top: 15px;
        }

        .pond-sampling .report-table table {
            width: auto;
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

        .chart-details-container .details {
            height: 160px;
            width: 260px;
            margin-top: 10px;
            background: #D8E3EF 0% 0% no-repeat padding-box;
            border-radius: 10px;
            opacity: 1;
            text-align: center;
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
    </style>
</head>
@php
    $now = \Carbon\Carbon::now()->format('d M Y H:i');
@endphp
<body>

<div class="page">
    <div class="wrapper">
        <div class="pond">
            <div class="ponds-recap">
                <h3 class="section-title">Laporan Transaksi</h3>
                <hr class="title-underline" align="left">
                <span class="recap-note-title">Laporan Transaksi {{ $now }}</span>
                <div>
                    <img src="{{ $chartImg }}" alt="chart-img-transaction">
                </div>

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
