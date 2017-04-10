@extends('layouts.app')

@section('content')
    <div class="coinPageContainer">
        <div class="topBar">
            <div class="container coinSummaryBar">
                <div class="row">
                    <div class="nameContainer col-md-5">
                        <span class="coinName">{{ $coin->name }}</span>
                        <span class="coinSymbol">( {{ $coin->symbol  }} )</span>
                    </div>
                    <div class="marketInfoContainer col-md-7">
                        <div class="coinMarketInfoPrice">
                            <span class="coinPrice"> $ {{number_format($coinDetails->usdPrice,8)}} </span>
                            <span class="coinPercentage">({{$coinDetails->cap24hrChange}}%)</span>
                        </div>
                        <div class="table-responsive">
                        <table class="coinMarketInfoTable" style="border-collapse: collapse;">
                            <tbody>
                                <tr class="titleInfo">
                                    <th>Market Cap</th>
                                    <th>24 hour Vol.</th>
                                    <th>Available Supp.</th>
                                </tr>
                                <tr class="valueInfo">
                                    <td>${{number_format($coinDetails->mktcap)}}</td>
                                    <td>${{number_format($coinDetails->volume)}}</td>
                                    <td>{{number_format($coinDetails->supply)}}</td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>

            <div id="chartdiv">

            </div>
            <h2 class="title"> {{$coinDetails->short}} Price Summary</h2>

            <div class="marginClass container">
                <div class="table-responsive">
                <table class="table table-fixed coinTable">
                    <thead>
                        <tr>
                            <th class="col-xs-2">Sr. No</th>
                            <th class="col-xs-2">Year</th>
                            <th class="col-xs-2">Month</th>
                            <th class="col-xs-2">Date</th>
                            <th class="col-xs-2">Time</th>
                            <th class="col-xs-2">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($price_data as $key=>$item)
                        <tr>
                            <td class="col-xs-2">{{++$key}}</td>
                            <td class="col-xs-2">{{date("Y",strtotime($item['x']))}}</td>
                            <td class="col-xs-2">{{date("M",strtotime($item['x']))}}</td>
                            <td class="col-xs-2">{{date("d",strtotime($item['x']))}}</td>
                            <td class="col-xs-2">{{date("H:i",strtotime($item['x']))}}</td>
                            <td class="col-xs-2">{{$item['y']}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>

            <div class="footer">
                <h5>Thank you for visit</h5>
            </div>
        </div>

    </div>
@endsection
@section('js')
    <script src="{{asset("js/amcharts.js")}}"></script>
    <script src="https://www.amcharts.com/lib/3/serial.js"></script>
    <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
    <script src="amcharts/plugins/dataloader/dataloader.min.js" type="text/javascript"></script>

    <script>
        window.setTimeout(function(){
            if ( $('table.body_scroll').length ) {
                var $table_body_scroll=$('table.body_scroll'),
                        header_table=$( '<table aria-hidden="true" class="header_table"><thead><tr><td></td></tr></thead></table>' ),
                        scroll_div='<div class="body_scroll"></div>';

                //inject table that will hold stationary row header; inject the div that will get scrolled
                $table_body_scroll.before( header_table ).before( scroll_div );

                $table_body_scroll.each(function (index) {
                    //to minimize FUOC, I like to set the relevant variables before manipulating the DOM
                    var columnWidths = [];
                    var $targetDataTable=$(this);
                    var $targetHeaderTable=$("table.header_table").eq(index);
                    // Get column widths
                    $($targetDataTable).find('thead tr th').each(function (index) {
                        columnWidths[index] = $(this).width();
                    });

                    //place target table inside of relevant scrollable div (using jQuery eq() and index)
                    $('div.body_scroll').eq(index).prepend( $targetDataTable ).width( $($targetDataTable).width()+25 );

                    // hide original caption, header, and footer from sighted users
                    $($targetDataTable).children('caption, thead, tfoot').hide();

                    // insert header data into static table
                    $($targetHeaderTable).find('thead').replaceWith( $( $targetDataTable ).children('caption, thead').clone().show() );

                    // modify column width for header
                    $($targetHeaderTable).find('thead tr th').each(function (index) {
                        $(this).css('width', columnWidths[index]);
                    });

                    // make sure table data still lines up correctly
                    $($targetDataTable).find('tbody tr:first td').each(function (index) {
                        $(this).css('width', columnWidths[index]);
                    });

                    //if our target table has a footer, create a visual copy of it after the scrollable div
                });
            }
        }, 500);
    </script>

    <script>

        setTimeout(function(){
        var chartData = generateChartData();
        var chart = AmCharts.makeChart("chartdiv", {
            "type": "serial",
            "theme": "light",
            "marginRight": 80,
            "autoMarginOffset": 20,
            "marginTop": 7,
            "dataDateFormat": "YYYY-MM-DD HH:NN",
            "dataProvider": chartData,
            "valueAxes": [{
                "axisAlpha": 0.2,
                "dashLength": 1,
                "position": "left"
            }],
            "mouseWheelZoomEnabled": true,
            "graphs": [{
                "id": "g1",
                "bullet": "triangleUp",
                "lineColor": "#555555",
                "bulletBorderAlpha": 1,
                "hideBulletsCount": 200,
                "valueField": "price",
                "balloon":{
                    "drop":true
                }
            }],
            "chartScrollbar": {
                "autoGridCount": true,
                "graph": "g1",
                "scrollbarHeight": 50,
                "dragIconHeight": 60,
                "dragIconWidth": 60
            },
            "chartCursor": {
                "limitToGraph":"g1",
                "cursorColor": "#555555",
                "cursorPosition": "mouse",
                "categoryBalloonDateFormat": "YYYY-MM-DD JJ:NN"
            },
            "categoryField": "time",
            "titles":[ {
                "text": "{{ $coinDetails->short }} Price Chart",
                "size": 30
            }],
            "categoryAxis": {
                "axisColor": "#959595",
                "minPeriod": "mm",
                "parseDates":true,
                "centerLabelOnFullPeriod":true,
                "dashLength": 1,
                "minorGridEnabled": true,
                "autoRotateAngle": 50,
                "autoRotateCount": 0,
                "autoWrap": true
            }
        });

        chart.addListener("rendered", zoomChart);
        zoomChart();

        // this method is called when chart is first inited as we listen for "rendered" event
        function zoomChart() {
            // different zoom methods can be used - zoomToIndexes, zoomToDates, zoomToCategoryValues
            chart.zoomToIndexes(chartData.length - 20, chartData.length - 1);
        }


        // generate some random data, quite different range
        function generateChartData() {
            var chartData = [];
            var result = JSON.parse('{!! json_encode($price_data) !!}');

            for (var i = 0; i < result.length; i++) {
                // we create date objects here. In your data, you can have date strings
                // and then set format of your dates using chart.dataDateFormat property,
                // however when possible, use date objects, as this will speed up chart rendering.

                chartData.push({
                    time: result[i].x,
                    price: result[i].y
                });
            }
            return chartData;
        }
        }, 1000);
    </script>

    <script>
        // Change the selector if needed
        var $table = $('table.scroll'),
                $bodyCells = $table.find('tbody tr:first').children(),
                colWidth;

        // Adjust the width of thead cells when window resizes
        $(window).resize(function() {
            // Get the tbody columns width array
            colWidth = $bodyCells.map(function() {
                return $(this).width();
            }).get();

            // Set the width of thead columns
            $table.find('thead tr').children().each(function(i, v) {
                $(v).width(colWidth[i]);
            });
        }).resize(); // Trigger resize handler
    </script>

@endsection

@section('css')
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
   @endsection