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
            padding: 50px;
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

        .report-table table thead tr th {
            color: #1B77DF;
            background: #e7eaec;
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

        .recap-note-list li {
            text-align: left;
            font: 400 16px/22px Open Sans;
            letter-spacing: 0;
            color: #000000;
            opacity: 1;
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
    /** @var \App\Product $products */
$dataset = $products->map(function ($p) {
    return collect([
        'Key' => $p->abbreviation_name,
        'Value' => $p->stock
    ]);
})
@endphp
<body>
{{--page 2 arus pemasukan perbulan--}}
    <div class="page">
        <div class="ponds-recap">
            <h3 class="section-title">Laporan Stok</h3>
            <hr>
            <span class="recap-note-title">Data Laporan Stok Brang Lembaga A</span>
            <script>
                var styleRules = [];
                var requiredSheets = [...]; // list of required CSS files
                for (var sheet of document.styleSheet)) {
                    if (sheet.href) {
                        var sheetName = sheet.href.split('/').pop();
                        if (requiredSheets.indexOf(sheetName) != -1) {
                            var rules = Array.from(sheet.cssRules).map(rule => rule.cssText);
                            styleRules = styleRules.concat(rules);
                        }
                    }
                }
                var styleText = styleRules.join(' ');
                var styleNode = document.createCDATASection(styleRules);

                var svg = d3.select("svg"),
                    img = new Image(),
                    serializer = new XMLSerializer(),

// prepend style to svg
                    svg.insert('defs',":first-child")
                var styleEl = d3.select("svg defs")
                    .append('style')
                    .attr('type','text/css');

                styleEl.node().appendChild(styleNode);

                var svgStr = serializer.serializeToString(svg.node());
                img.src = 'data:image/svg+xml;base64,'+window.btoa(unescape(encodeURIComponent(svgStr)));

                var bbox = svg.getBoundingClientRect();

                var canvas = document.createElement("canvas");

                canvas.width = bbox.width;
                canvas.height = bbox.height;
                canvas.getContext("2d").drawImage(img,0,0,bbox.width,bbox.width);

                canvas.parentNode.replaceChild(canvas, svg);
            </script>
{{--            <img id="myImg">--}}
{{--            <div>--}}
{{--                <div id="my_dataviz"></div>--}}
{{--            </div>--}}
{{--            <script>--}}
{{--                let margin = {top: 20, right: 30, bottom: 40, left: 90},--}}
{{--                    width = 600 - margin.left - margin.right,--}}
{{--                    height = 400 - margin.top - margin.bottom;--}}

{{--                // append the svg object to the body of the page--}}
{{--                let svg = d3.select("#my_dataviz")--}}
{{--                    .append("svg")--}}
{{--                    .attr("width", width + margin.left + margin.right)--}}
{{--                    .attr("height", height + margin.top + margin.bottom)--}}
{{--                    .append("g")--}}
{{--                    .attr("transform",--}}
{{--                        "translate(" + margin.left + "," + margin.top + ")");--}}

{{--                data = @json($dataset);--}}

{{--                // Add X axis--}}
{{--                let x = d3.scaleLinear()--}}
{{--                    .domain([0, d3.max(data, function(d) {--}}
{{--                        return d.Value;--}}
{{--                    })])--}}
{{--                    .range([ 0, width]);--}}
{{--                svg.append("g")--}}
{{--                    .attr("transform", "translate(0," + height + ")")--}}
{{--                    .call(d3.axisBottom(x))--}}
{{--                    .selectAll("text")--}}
{{--                    .attr("transform", "translate(-10,0)rotate(-45)")--}}
{{--                    .style("text-anchor", "end");--}}

{{--                // Y axis--}}
{{--                let y = d3.scaleBand()--}}
{{--                    .range([ 0, height ])--}}
{{--                    .domain(data.map(function(d) { return d.Key; }))--}}
{{--                    .padding(.1);--}}
{{--                svg.append("g")--}}
{{--                    .call(d3.axisLeft(y))--}}
{{--                    .selectAll("text")--}}
{{--                    .attr("transform", "translate(-10,0)rotate(-45)")--}}
{{--                    .style("text-anchor", "end");--}}

{{--                //Bars--}}
{{--                svg.selectAll("myRect")--}}
{{--                    .data(data)--}}
{{--                    .enter()--}}
{{--                    .append("rect")--}}
{{--                    .attr("x", x(0) )--}}
{{--                    .attr("y", function(d) { return y(d.Key); })--}}
{{--                    .attr("width", function(d) { return x(d.Value); })--}}
{{--                    .attr("height", y.bandwidth() )--}}
{{--                    .attr("fill", "#69b3a2");--}}

{{--                var SVGDomElement = document.getElementById("my_dataviz").firstChild;--}}
{{--                var serializedSVG = new XMLSerializer().serializeToString(SVGDomElement);--}}
{{--                var base64Data = "data:image/svg+xml;base64," + window.btoa(serializedSVG);--}}
{{--                // document.getElementById("myImg").src = base64Data;--}}
{{--                document.getElementById("myImg").src = "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2MDAiIGhlaWdodD0iNDAwIj48ZyB0cmFuc2Zvcm09InRyYW5zbGF0ZSg5MCwyMCkiPjxnIHRyYW5zZm9ybT0idHJhbnNsYXRlKDAsMzQwKSIgZmlsbD0ibm9uZSIgZm9udC1zaXplPSIxMCIgZm9udC1mYW1pbHk9InNhbnMtc2VyaWYiIHRleHQtYW5jaG9yPSJtaWRkbGUiPjxwYXRoIGNsYXNzPSJkb21haW4iIHN0cm9rZT0iIzAwMCIgZD0iTTAuNSw2VjAuNUg0ODAuNVY2Ii8+PGcgY2xhc3M9InRpY2siIG9wYWNpdHk9IjEiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDAuNSwwKSI+PGxpbmUgc3Ryb2tlPSIjMDAwIiB5Mj0iNiIvPjx0ZXh0IGZpbGw9IiMwMDAiIHk9IjkiIGR5PSIwLjcxZW0iIHRyYW5zZm9ybT0idHJhbnNsYXRlKC0xMCwwKXJvdGF0ZSgtNDUpIiBzdHlsZT0idGV4dC1hbmNob3I6IGVuZDsiPjAuMDwvdGV4dD48L2c+PGcgY2xhc3M9InRpY2siIG9wYWNpdHk9IjEiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDQ4LjUsMCkiPjxsaW5lIHN0cm9rZT0iIzAwMCIgeTI9IjYiLz48dGV4dCBmaWxsPSIjMDAwIiB5PSI5IiBkeT0iMC43MWVtIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgtMTAsMClyb3RhdGUoLTQ1KSIgc3R5bGU9InRleHQtYW5jaG9yOiBlbmQ7Ij4wLjU8L3RleHQ+PC9nPjxnIGNsYXNzPSJ0aWNrIiBvcGFjaXR5PSIxIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSg5Ni41LDApIj48bGluZSBzdHJva2U9IiMwMDAiIHkyPSI2Ii8+PHRleHQgZmlsbD0iIzAwMCIgeT0iOSIgZHk9IjAuNzFlbSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTEwLDApcm90YXRlKC00NSkiIHN0eWxlPSJ0ZXh0LWFuY2hvcjogZW5kOyI+MS4wPC90ZXh0PjwvZz48ZyBjbGFzcz0idGljayIgb3BhY2l0eT0iMSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMTQ0LjUsMCkiPjxsaW5lIHN0cm9rZT0iIzAwMCIgeTI9IjYiLz48dGV4dCBmaWxsPSIjMDAwIiB5PSI5IiBkeT0iMC43MWVtIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgtMTAsMClyb3RhdGUoLTQ1KSIgc3R5bGU9InRleHQtYW5jaG9yOiBlbmQ7Ij4xLjU8L3RleHQ+PC9nPjxnIGNsYXNzPSJ0aWNrIiBvcGFjaXR5PSIxIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgxOTIuNSwwKSI+PGxpbmUgc3Ryb2tlPSIjMDAwIiB5Mj0iNiIvPjx0ZXh0IGZpbGw9IiMwMDAiIHk9IjkiIGR5PSIwLjcxZW0iIHRyYW5zZm9ybT0idHJhbnNsYXRlKC0xMCwwKXJvdGF0ZSgtNDUpIiBzdHlsZT0idGV4dC1hbmNob3I6IGVuZDsiPjIuMDwvdGV4dD48L2c+PGcgY2xhc3M9InRpY2siIG9wYWNpdHk9IjEiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDI0MC41LDApIj48bGluZSBzdHJva2U9IiMwMDAiIHkyPSI2Ii8+PHRleHQgZmlsbD0iIzAwMCIgeT0iOSIgZHk9IjAuNzFlbSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTEwLDApcm90YXRlKC00NSkiIHN0eWxlPSJ0ZXh0LWFuY2hvcjogZW5kOyI+Mi41PC90ZXh0PjwvZz48ZyBjbGFzcz0idGljayIgb3BhY2l0eT0iMSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMjg4LjUsMCkiPjxsaW5lIHN0cm9rZT0iIzAwMCIgeTI9IjYiLz48dGV4dCBmaWxsPSIjMDAwIiB5PSI5IiBkeT0iMC43MWVtIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgtMTAsMClyb3RhdGUoLTQ1KSIgc3R5bGU9InRleHQtYW5jaG9yOiBlbmQ7Ij4zLjA8L3RleHQ+PC9nPjxnIGNsYXNzPSJ0aWNrIiBvcGFjaXR5PSIxIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgzMzYuNSwwKSI+PGxpbmUgc3Ryb2tlPSIjMDAwIiB5Mj0iNiIvPjx0ZXh0IGZpbGw9IiMwMDAiIHk9IjkiIGR5PSIwLjcxZW0iIHRyYW5zZm9ybT0idHJhbnNsYXRlKC0xMCwwKXJvdGF0ZSgtNDUpIiBzdHlsZT0idGV4dC1hbmNob3I6IGVuZDsiPjMuNTwvdGV4dD48L2c+PGcgY2xhc3M9InRpY2siIG9wYWNpdHk9IjEiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDM4NC41LDApIj48bGluZSBzdHJva2U9IiMwMDAiIHkyPSI2Ii8+PHRleHQgZmlsbD0iIzAwMCIgeT0iOSIgZHk9IjAuNzFlbSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTEwLDApcm90YXRlKC00NSkiIHN0eWxlPSJ0ZXh0LWFuY2hvcjogZW5kOyI+NC4wPC90ZXh0PjwvZz48ZyBjbGFzcz0idGljayIgb3BhY2l0eT0iMSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoNDMyLjUsMCkiPjxsaW5lIHN0cm9rZT0iIzAwMCIgeTI9IjYiLz48dGV4dCBmaWxsPSIjMDAwIiB5PSI5IiBkeT0iMC43MWVtIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgtMTAsMClyb3RhdGUoLTQ1KSIgc3R5bGU9InRleHQtYW5jaG9yOiBlbmQ7Ij40LjU8L3RleHQ+PC9nPjxnIGNsYXNzPSJ0aWNrIiBvcGFjaXR5PSIxIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSg0ODAuNSwwKSI+PGxpbmUgc3Ryb2tlPSIjMDAwIiB5Mj0iNiIvPjx0ZXh0IGZpbGw9IiMwMDAiIHk9IjkiIGR5PSIwLjcxZW0iIHRyYW5zZm9ybT0idHJhbnNsYXRlKC0xMCwwKXJvdGF0ZSgtNDUpIiBzdHlsZT0idGV4dC1hbmNob3I6IGVuZDsiPjUuMDwvdGV4dD48L2c+PC9nPjxnIGZpbGw9Im5vbmUiIGZvbnQtc2l6ZT0iMTAiIGZvbnQtZmFtaWx5PSJzYW5zLXNlcmlmIiB0ZXh0LWFuY2hvcj0iZW5kIj48cGF0aCBjbGFzcz0iZG9tYWluIiBzdHJva2U9IiMwMDAiIGQ9Ik0tNiwwLjVIMC41VjM0MC41SC02Ii8+PGcgY2xhc3M9InRpY2siIG9wYWNpdHk9IjEiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDAsNDUuNjA5NzU2MDk3NTYwOTcpIj48bGluZSBzdHJva2U9IiMwMDAiIHgyPSItNiIvPjx0ZXh0IGZpbGw9IiMwMDAiIHg9Ii05IiBkeT0iMC4zMmVtIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgtMTAsMClyb3RhdGUoLTQ1KSIgc3R5bGU9InRleHQtYW5jaG9yOiBlbmQ7Ij5NZWphIEw8L3RleHQ+PC9nPjxnIGNsYXNzPSJ0aWNrIiBvcGFjaXR5PSIxIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgwLDEyOC41MzY1ODUzNjU4NTM2NSkiPjxsaW5lIHN0cm9rZT0iIzAwMCIgeDI9Ii02Ii8+PHRleHQgZmlsbD0iIzAwMCIgeD0iLTkiIGR5PSIwLjMyZW0iIHRyYW5zZm9ybT0idHJhbnNsYXRlKC0xMCwwKXJvdGF0ZSgtNDUpIiBzdHlsZT0idGV4dC1hbmNob3I6IGVuZDsiPk1lamEgVDwvdGV4dD48L2c+PGcgY2xhc3M9InRpY2siIG9wYWNpdHk9IjEiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDAsMjExLjQ2MzQxNDYzNDE0NjM1KSI+PGxpbmUgc3Ryb2tlPSIjMDAwIiB4Mj0iLTYiLz48dGV4dCBmaWxsPSIjMDAwIiB4PSItOSIgZHk9IjAuMzJlbSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTEwLDApcm90YXRlKC00NSkiIHN0eWxlPSJ0ZXh0LWFuY2hvcjogZW5kOyI+TWVqYSBEPC90ZXh0PjwvZz48ZyBjbGFzcz0idGljayIgb3BhY2l0eT0iMSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMCwyOTQuMzkwMjQzOTAyNDM5MDcpIj48bGluZSBzdHJva2U9IiMwMDAiIHgyPSItNiIvPjx0ZXh0IGZpbGw9IiMwMDAiIHg9Ii05IiBkeT0iMC4zMmVtIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgtMTAsMClyb3RhdGUoLTQ1KSIgc3R5bGU9InRleHQtYW5jaG9yOiBlbmQ7Ij5NZWphIEs8L3RleHQ+PC9nPjwvZz48cmVjdCB4PSIwIiB5PSI4LjI5MjY4MjkyNjgyOTI1OCIgd2lkdGg9IjQ4MCIgaGVpZ2h0PSI3NC42MzQxNDYzNDE0NjM0MiIgZmlsbD0iIzY5YjNhMiIvPjxyZWN0IHg9IjAiIHk9IjkxLjIxOTUxMjE5NTEyMTk1IiB3aWR0aD0iMCIgaGVpZ2h0PSI3NC42MzQxNDYzNDE0NjM0MiIgZmlsbD0iIzY5YjNhMiIvPjxyZWN0IHg9IjAiIHk9IjE3NC4xNDYzNDE0NjM0MTQ2NCIgd2lkdGg9IjAiIGhlaWdodD0iNzQuNjM0MTQ2MzQxNDYzNDIiIGZpbGw9IiM2OWIzYTIiLz48cmVjdCB4PSIwIiB5PSIyNTcuMDczMTcwNzMxNzA3MzYiIHdpZHRoPSIwIiBoZWlnaHQ9Ijc0LjYzNDE0NjM0MTQ2MzQyIiBmaWxsPSIjNjliM2EyIi8+PC9nPjwvc3ZnPg==";--}}
{{--            </script>--}}

            <div class="report-table">
                <table>
                    <thead>
                    <tr>
                        <th width="1px" class="text-center">No</th>
                        <th class="text-center">Kategori</th>
                        <th class="text-center">Nama</th>
                        <th class="column-number">Stok</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $key => $product)
                        <tr>
                            <td class="text-right">{{ $key+1 }}</td>
                            <td>{{ $product->product_category->name }}</td>
                            <td>{{ $product->name }}</td>
                            <td class="column-number">{{ $product->stock }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>
