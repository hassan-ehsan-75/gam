<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" href="{{asset('app-assets/images/ico/apple-icon-120.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('favicon.ico')}}">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Quicksand:300,400,500,700"
          rel="stylesheet">
    <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css"
          rel="stylesheet">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/vendors.css')}}">
    <!-- END VENDOR CSS-->
    <!-- BEGIN MODERN CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/app.css')}}">
    <!-- END MODERN CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/core/menu/menu-types/vertical-content-menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/core/colors/palette-gradient.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/charts/jquery-jvectormap-2.0.3.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/charts/morris.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/fonts/simple-line-icons/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/core/colors/palette-gradient.css')}}">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/style.css')}}">
    <style type="text/css">
        *{

  font-family: 'Tunisia';
}

@font-face {
  font-family: "Tunisia";
  src: url("{{asset('assets/fonts/tunisia.ttf')}}") format("truetype"),
  }
  @font-face {
    font-family: 'Tunisia';
    font-style: normal;
    font-weight: normal;
    src: local('Tunisia'), local('Tunisia'), url("{{asset('assets/fonts/tunisia.ttf')}}");
  }
  body{
      font-family: "Tunisia" !important;
      zoom: 90%;
  }
  h3{
      font-family: "Tunisia" !important;
  }
  h4{
      font-family: "Tunisia" !important;
      font-weight: bold;
      font-size: 1.6rem
  }
  h2{
      font-family: "Tunisia" !important;
      font-weight: bold;
      font-size: 1.6rem
  }
  p{
      font-family: "Tunisia" !important;
      font-weight: bold;
      font-size: 1.6rem
  }
    </style>
</head>
@php
    $gathering_id=\App\Models\Gathering::orderBy('id','desc')->first()->id;
    $stockCount=\App\Models\Stock::where('gathering_id',$gathering_id)->where('enter',1)->sum('stock_number');

@endphp
<body class="vertical-layout vertical-content-menu"
      data-open="click" data-menu="vertical-content-menu" style="zoom: 90%;height: 90%">
@php

    $gathering=\App\Models\Gathering::orderBy('id','desc')->first();


@endphp

<nav class="header-navbar  navbar  navbar-brand-center" style="margin-bottom: 60px;margin-top: -35px">
    <div class="navbar-wrapper">
        <div class="navbar-header" style="width: 60%">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
                <li class="nav-item row">
                    <a class="navbar-brand col-md-9" href="{{route('home')}}">
                        <h3 class="brand-logo" style="width:175px;margin-left: 120%;margin-top: 20%;font-weight: bold">{{'رقم الجمعية: '.$gathering->g_number.' \ '.\App\Models\Gathering::$g_type[$gathering->type].' \ '.$gathering->g_date}}</h3>
                    </a>
                    <a class="navbar-brand pull-right col-md-3" href="{{route('home')}}">
                        <img class="brand-logo" alt="modern admin logo" src="{{asset('images/app_images/logoo.png')}}" width="175" style="width:175px;margin-left: 600%">
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
@yield('content')
<script src="{{asset('app-assets/vendors/js/vendors.min.js')}}" type="text/javascript"></script>
<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->
<script src="{{asset('app-assets/vendors/js/ui/headroom.min.js')}}" type="text/javascript"></script>
<script src="{{asset('app-assets/vendors/js/charts/chart.min.js')}}" type="text/javascript"></script>
<script src="{{asset('app-assets/vendors/js/charts/raphael-min.js')}}" type="text/javascript"></script>
{{--<script src="{{asset('app-assets/vendors/js/charts/morris.min.js')}}" type="text/javascript"></script>--}}
<script src="{{asset('app-assets/vendors/js/charts/jvector/jquery-jvectormap-2.0.3.min.js')}}"
        type="text/javascript"></script>
<script src="{{asset('app-assets/vendors/js/charts/jvector/jquery-jvectormap-world-mill.js')}}"
        type="text/javascript"></script>
<script src="{{asset('app-assets/data/jvector/visitor-data.js')}}" type="text/javascript"></script>
<!-- END PAGE VENDOR JS-->
<!-- BEGIN MODERN JS-->
<script src="{{asset('app-assets/js/core/app-menu.js')}}" type="text/javascript"></script>
<script src="{{asset('app-assets/js/core/app.js')}}" type="text/javascript"></script>
{{--<script src="{{asset('app-assets/js/scripts/customizer.js')}}" type="text/javascript"></script>--}}
<!-- END MODERN JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script src="{{asset('app-assets/js/scripts/pages/dashboard-sales.js')}}" type="text/javascript"></script>
<script>
    var totalStock="{{$setting}}";
    $(window).on('load', function() {

        Chart.defaults.dealsDoughnut = Chart.defaults.doughnut;
        var draw = Chart.controllers.doughnut.prototype.draw;
        var customDealDoughnut = Chart.controllers.doughnut.extend({
            draw: function () {
                draw.apply(this, arguments);
                var ctx = this.chart.chart.ctx;
                var ctxx = this.chart.ctx;
                var _fill = ctx.fill;
                var width = this.chart.width,
                    height = this.chart.height;

                var fontSize = (height / 114).toFixed(2);
                this.chart.ctx.font = fontSize + "em Verdana";
                this.chart.ctx.textBaseline = "middle";

                var text = "{{round($res,3)}}%",
                    textX = Math.round((width - this.chart.ctx.measureText(text).width) / 2),
                    textY = height / 2;

                this.chart.ctx.fillText(text, textX, textY);

                ctx.fill = function () {
                    ctx.save();
                    ctx.shadowColor = '#FF4961';
                    ctx.shadowBlur = 30;
                    ctx.shadowOffsetX = 0;
                    ctx.shadowOffsetY = 12;
                    _fill.apply(this, arguments)
                    ctx.restore();
                }

            }
        });
        Chart.controllers.dealsDoughnut = customDealDoughnut;
        var ctx = document.getElementById("deals-doughnut");
        var myDoughnutChart = new Chart(ctx, {
            type: 'dealsDoughnut',
            data: {
                labels: ["Remain", "Completed"],
                datasets: [{
                    label: "Favourite",
                    borderWidth: 0,
                    backgroundColor: ["#ff7b8c", "#FFF"],
                    data: [{{round(100-$res,3)}}, {{round($res,3)}}],
                }]
            },
            options: {
                responsive: true,
                title: {
                    display: false
                },
                legend: {
                    display: false
                },
                layout: {
                    padding: {
                        left: 16,
                        right: 16,
                        top: 16,
                        bottom: 16
                    }
                },
                cutoutPercentage: 94,
                animation: {
                    animateScale: false,
                    duration: 5000
                }
            }
        });


        $(document).ready(function () {
            setInterval(function () {
                $.get("{{route('stock.getState')}}", function(data, status){
                    var customDealDoughnut = Chart.controllers.doughnut.extend({
                        draw: function () {
                            draw.apply(this, arguments);
                            var ctx = this.chart.chart.ctx;
                            var ctxx = this.chart.ctx;
                            var _fill = ctx.fill;
                            var width = this.chart.width,
                                height = this.chart.height;

                            var fontSize = (height / 114).toFixed(2);
                            this.chart.ctx.font = fontSize + "em Verdana";
                            this.chart.ctx.textBaseline = "middle";

                            var text = parseFloat((data.data.stock/totalStock)*100).toFixed(3)+"%",
                                textX = Math.round((width - this.chart.ctx.measureText(text).width) / 2),
                                textY = height / 2;

                            this.chart.ctx.fillText(text, textX, textY);
                            $('#stockPres').html((data.data.stock).toLocaleString(undefined, {minimumFractionDigits: 0, maximumFractionDigits: 0}));
                            $('#stockPres1').html(data.data.stock1.toLocaleString(undefined, {minimumFractionDigits: 0, maximumFractionDigits: 0}));
                            $('#stockPres2').html(data.data.stock2.toLocaleString(undefined, {minimumFractionDigits: 0, maximumFractionDigits: 0}));
                            ctx.fill = function () {
                                ctx.save();
                                if(((data.data.stock/totalStock)*100)>=51) {
                                    ctx.shadowColor = '#1ec928';
                                    $('#cha').removeClass(' bg-gradient-directional-danger');
                                    $('#cha2').removeClass(' bg-hexagons-danger');
                                    $('#cha').addClass(' bg-gradient-directional-success');
                                    $('#cha2').addClass(' bg-hexagons-success');
                                }else {
                                    ctx.shadowColor = '#FF4961';
                                    $('#cha').addClass(' bg-gradient-directional-danger');
                                    $('#cha2').addClass(' bg-hexagons-danger');
                                    $('#cha').removeClass(' bg-gradient-directional-success');
                                    $('#cha2').removeClass(' bg-hexagons-success');
                                }

                                ctx.shadowBlur = 30;
                                ctx.shadowOffsetX = 0;
                                ctx.shadowOffsetY = 12;
                                _fill.apply(this, arguments)
                                ctx.restore();
                            }
                            $('#res').html(text);
                        }
                    });
                    Chart.controllers.dealsDoughnut = customDealDoughnut;
                    var ctx = document.getElementById("deals-doughnut");
                    var myDoughnutChart = new Chart(ctx, {
                        type: 'dealsDoughnut',
                        data: {
                            labels: ["Remain", "Completed"],
                            datasets: [{
                                label: "Favourite",
                                borderWidth: 0,
                                backgroundColor: ["#ff7b8c", "#FFF"],
                                data: [parseFloat(100-((data.data.stock/totalStock)*100)).toFixed(3), parseFloat(((data.data.stock/totalStock)*100)).toFixed(3)],
                            }]
                        },
                        options: {
                            responsive: true,
                            title: {
                                display: false
                            },
                            legend: {
                                display: false
                            },
                            layout: {
                                padding: {
                                    left: 16,
                                    right: 16,
                                    top: 16,
                                    bottom: 16
                                }
                            },
                            cutoutPercentage: 94,
                            animation: {
                                animateScale: false,
                                duration: 5000
                            }
                        }
                    });
                    for(var i=0;i<data.data.candidates.length;i++){
                        if(data.data.candidates[i].votes!=null) {
                            $('#canc' + data.data.candidates[i].id).html(data.data.candidates[i].votes.votes.toLocaleString(undefined, {minimumFractionDigits: 0, maximumFractionDigits: 0}));
                            $('#canper' + data.data.candidates[i].id).html("("+((data.data.candidates[i].votes.votes/{{$stockCount}})*100).toFixed(3)+"%"+")");
                            $('#can' + data.data.candidates[i].id).width(((data.data.candidates[i].votes.votes/{{$stockCount}})*100)+"%");
                        }
                    }
                    for(var i=0;i<data.data.records.length;i++){
                            $('#yess' + data.data.records[i].id).html(data.data.records[i].YesCount.toLocaleString(undefined, {minimumFractionDigits: 0, maximumFractionDigits: 0}));
                            $('#recYes' + data.data.records[i].id).html("("+((data.data.records[i].YesCount/{{$stockCount}})*100).toFixed(3)+"%"+")");
                            $('#yes' + data.data.records[i].id).width(((data.data.records[i].YesCount/{{$stockCount}})*100)+"%");

                            $('#noo' + data.data.records[i].id).html(data.data.records[i].NoCount.toLocaleString(undefined, {minimumFractionDigits: 0, maximumFractionDigits: 0}));
                        $('#recNo' + data.data.records[i].id).html("("+((data.data.records[i].NoCount/{{$stockCount}})*100).toFixed(3)+"%"+")");
                            $('#no' + data.data.records[i].id).width(((data.data.records[i].NoCount/{{$stockCount}})*100)+"%");

                    }
                });
            },5000);
        });
        $('#nav-i1').show();
        $('#nav-i2').hide();
        $('#nav-i4').hide();
        $('#nav-i11').show();
        $('#nav-i22').hide();
        $('#nav-i44').hide();
        $('#nav1').on('click',function () {
            $('#nav-i1').show();
            $('#nav-i111').show();
            $('#nav-i112').show();
            $('#nav1').addClass('active');
            $('#nav-i2').hide();
            $('#nav2').removeClass('active');
            $('#nav-i4').hide();
            $('#nav4').removeClass('active');
        });
        $('#nav2').on('click',function () {
            $('#nav-i2').show();
            $('#nav2').addClass('active');
            $('#nav-i1').hide();
            $('#nav-i111').hide();
            $('#nav-i112').hide();
            $('#nav1').removeClass('active');
            $('#nav-i4').hide();
            $('#nav4').removeClass('active');
        });
        $('#nav4').on('click',function () {
            $('#nav-i4').show();
            $('#nav4').addClass('active');
            $('#nav-i1').hide();
            $('#nav-i111').hide();
            $('#nav-i112').hide();
            $('#nav1').removeClass('active');
            $('#nav-i2').hide();
            $('#nav2').removeClass('active');
        });
        $('#nav11').on('click',function () {
            $('#nav-i11').show();
            $('#nav11').addClass('active');
            $('#nav11').html('المرشحون لانتخاب اعضاء مجلس الادارة');
            $('#nav-i22').hide();
            $('#nav22').removeClass('active');
            $('#nav22').html('2');
            $('#nav-i44').hide();
            $('#nav44').removeClass('active');
            $('#nav44').html('3');
        });
        $('#nav22').on('click',function () {
            $('#nav-i22').show();
            $('#nav22').addClass('active');
            $('#nav22').html('المرشحون لانتخاب اعضاء هيئة شرعية');
            $('#nav-i11').hide();
            $('#nav11').removeClass('active');
            $('#nav11').html('1');
            $('#nav-i44').hide();
            $('#nav44').removeClass('active');
            $('#nav44').html('3');
        });
        $('#nav44').on('click',function () {
            $('#nav-i44').show();
            $('#nav44').addClass('active');
            $('#nav44').html('المرشحون لانتخاب مدقق حسابات ');
            $('#nav-i11').hide();
            $('#nav11').removeClass('active');
            $('#nav11').html('1');
            $('#nav-i22').hide();
            $('#nav22').removeClass('active');
            $('#nav22').html('2');
        });

    });
    function formatMoney(number, decPlaces, decSep, thouSep) {
        decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
            decSep = typeof decSep === "undefined" ? "." : decSep;
        thouSep = typeof thouSep === "undefined" ? "," : thouSep;
        var sign = number < 0 ? "-" : "";
        var i = String(parseInt(number = Math.abs(Number(number) || 0).toFixed(decPlaces)));
        var j = (j = i.length) > 3 ? j % 3 : 0;

        return sign +
            (j ? i.substr(0, j) + thouSep : "") +
            i.substr(j).replace(/(\decSep{3})(?=\decSep)/g, "$1" + thouSep) +
            (decPlaces ? decSep + Math.abs(number - i).toFixed(decPlaces).slice(2) : "");
    }

</script>

</body>
</html>