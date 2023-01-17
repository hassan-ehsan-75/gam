@extends('layouts.new')
@section('title','الدخول الى الجلسة')
@section('css')

    <style>
        .req{
            color: red;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid text-center">
@if(isset($gathering))
            <h2 class="text-center">امسح رمز المساهم</h2>
            <div class="row text-center">
                <h3 id="wait" class="alert alert-primary col-md-6 text-center" style="margin-right: 26%">الرجاء الانتظار</h3>
                <h3 id="success" class="alert alert-success col-md-6 text-center" style="margin-right: 26%"></h3>
                <h3 id="error" class="alert alert-danger col-md-6 text-center" style="margin-right: 26%"></h3>
            </div>
            <div class="row" style="margin-top: 12%">
                <h3 id="stock_count" class="alert alert-primary col-md-5 text-center ml-5 mr-5">العدد الكلي للاسهم  : {{\App\Models\Setting::first()->stocks_count}}</h3>
                <h3 id="stock_cur" class="alert alert-primary col-md-5  text-center  mr-5">النصاب الحالي : <span id="stock_cur">{{\App\Models\Stock::where('enter',1)->sum('stock_number')}}</span></h3>

            </div>
    @else
            <div style="display: inline-block;width:100%;margin-right: 1%" class="col-2 row ml-1">
                <label for="type" class="col-md-12">اختر الجمعية</label>
                <select class="option-control col-md-12" name="type" style="height: 50%" id="branch_id"  onchange="window.location.href='{{url('/stocks/enter')}}/'+'?gathering='+this.value">
                    <option value="0">اختر الجمعية</option>
                    @foreach(\App\Models\Gathering::where('status',1)->get() as $gath)
                        <option value="{{$gath->id}}">{{$gath->g_number.'-'.\App\Models\Gathering::$g_type[$gath->type].'-'.$gath->g_date}}</option>
                    @endforeach

                </select>
            </div>
    @endif


    </div>
@endsection
@section('js')
    
    <script>
        $('#wait').hide();
        $('#success').hide();
        $('#error').hide();
        var barcode = '';
        var interval;
        document.addEventListener('keydown', function(evt) {
            if (interval)
                clearInterval(interval);
            if (evt.code == 'Enter') {
                if (barcode)
                    handleBarcode(barcode);
                barcode = '';
                return;
            }
            if (evt.key != 'Shift')
                barcode += evt.key;
            interval = setInterval(() => barcode = '', 20);
        });
var stock_current={{\App\Models\Stock::where('enter',1)->sum('stock_number')}};
        function handleBarcode(scanned_barcode) {
            $('#wait').show();
            $('#success').hide();
            $('#error').hide();
            console.log(scanned_barcode);
                $.post("{{route('stock.enter')}}", {data: scanned_barcode}, function(result){
                    $('#wait').hide();
                    console.log(result.data+" done");
                    if(result.status==-1){
                        $('#error').html(result.message);
                        $('#error').show();
                    }else{
                        $('#success').html(result.message);
                        $('#success').show();
                        console.log('PreCur '+stock_current);
                        stock_current=stock_current+parseInt(result.data);
                        console.log('res '+result.data);
                        console.log('cur '+stock_current);
                        $('#stock_cur').html(stock_current);
                    }

                });

        }
    </script>
@endsection