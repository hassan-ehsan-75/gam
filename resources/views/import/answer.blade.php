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
    @php
        $gathering=\App\Models\Gathering::where('status',1)->first()->id;
    @endphp
    <div class="container-fluid text-center">
        @if(isset($gathering))
            <h2 class="text-center">امسح رمز التصويت</h2>
            <h3 id="wait" class="alert alert-primary col-md-6 text-center" style="margin-right: 26%">الرجاء الانتظار</h3>
            <h3 id="success" class="alert alert-success col-md-6 text-center" style="margin-right: 26%"></h3>
            <h3 id="error" class="alert alert-danger col-md-6 text-center" style="margin-right: 26%"></h3>

            <div class="row" style="margin-top: 8%">
                @foreach(\App\Models\Record::where('gathering_id',$gathering)->where('type',2)->get() as $cand)
                    <h3 class="alert alert-primary col-md-4 text-center " style="width: 50%"> {{$cand->text}}  </h3>
                    <h3 class="alert alert-success col-md-4 text-center " style="width: 50%"> نعم : <span id="can{{$cand->id}}"></span></h3>
                    <h3 class="alert alert-danger col-md-4 text-center " style="width: 50%"> لا : <span id="canot{{$cand->id}}"></span></h3>
                @endforeach

            </div>
            @else

            {{--<div style="display: inline-block;width:100%;margin-right: 1%" class="col-2 row ml-1">--}}
                {{--<label for="type" class="col-md-12">اختر الجمعية</label>--}}
                {{--<select class="option-control col-md-12" name="type" style="height: 50%" id="branch_id"  onchange="window.location.href='{{url('/stocks/answer')}}/'+'?gathering='+this.value">--}}
                    {{--<option value="0">اختر الجمعية</option>--}}
                    {{--@foreach(\App\Models\Gathering::where('status',1)->get() as $gath)--}}
                        {{--<option value="{{$gath->id}}">{{$gath->g_number.'-'.\App\Models\Gathering::$g_type[$gath->type].'-'.$gath->g_date}}</option>--}}
                    {{--@endforeach--}}

                {{--</select>--}}
            {{--</div>--}}
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

        function handleBarcode(scanned_barcode) {
            $('#wait').show();
            $('#success').hide();
            $('#error').hide();
            console.log(scanned_barcode);
                $.post("{{route('stock.answer')}}", {data: scanned_barcode}, function(result){
                    $('#wait').hide();
                    if(result.status==-1){
                        $('#error').html(result.message);
                        $('#error').show();
                    }else{
                        $('#success').html(result.message);
                        $('#success').show();
                        $('#can'+result.data.id).html(result.data.count);
                        $('#canot'+result.data.id).html(result.data.countnot);
                    }

                });

        }
    </script>
@endsection