@extends('layouts.new')
@section('title','عرض المفوضين غير المساهمين')
@section('content')
    <style>
        svg{
            width: 3% !important;
            direction: none !important;
        }
    </style>
    @php $stock=new \App\Models\Stock() @endphp
    <div class="container-fluid" style="padding-top: 25px; text-align:center">
        <div class="container justify-content-center" style="text-align: center;">
            <h2 style="text-align: center;">المفوضين عن المساهمين</h2><Br>
        </div>
        @if(session()->has('error'))
            <div class="form-group text-center mt-1">
                <label class="alert alert-warning">{{ session()->get('error')}}</label>
            </div>
        @endif
        @if(session()->has('success'))
            <div class="form-group text-center mt-1">
                <label class="alert alert-success">{{ session()->get('success')}}</label>
            </div>
        @endif
        <div class="container shadow p-3" style="margin-top: 15px;max-width: 1400px">
            <div class="row">
               <div style="display: inline-block;width:100%;margin-right: 1%" class="col-3 row ml-1">
                <label for="type" class="col-md-12">الفرز حسب الجمعية</label>
                <select class="option-control col-md-12" name="type" style="height: 50%" id="branch_id"  onchange="window.location.href='{{url('/agentss')}}/'+this.value">

                        @foreach(\App\Models\Gathering::all() as $gath)
                            <option @if($gathering==$gath->id) selected @endif value="{{$gath->id}}">{{$gath->g_number.'-'.\App\Models\Gathering::$g_type[$gath->type].'-'.$gath->g_date}}</option>
                        @endforeach

                </select>
            </div>
                <div class="container col-md-3 mt-4 pb-2 pt-1" style="height:100%;">
                    <div style="display: inline-block;width:100%;text-align:center">

                        <label>بحث</label>
                        <form style="display: inline-block;" method="GET" action="{{route('agent.index',0)}}">
                            <input type="text" class="option-control pt-2 pb-2" name="search" value="{{request('search')}}">
                            <button type="submit" class="btn btn-secondary option-control mb-1">ابحث</button>
                        </form>
                    </div>
                </div>
                <div class="container col-md-5 mt-4 pb-2 pt-1" style="height:100%;">
                    <div style="width:100%;text-align:center">

                        <label>ادخال باركود الهوية</label>
                        <form style="display: inline-block;" method="GET" action="{{route('agent.index',0)}}">
                            <input id="barc" type="text" class="option-control pt-2 pb-2" name="search" value="{{request('search')}}" autofocus>
                            <button type="submit" class="btn btn-secondary option-control mb-1">ابحث</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th >الاسم الكامل</th>
                        <th>موبايل</th>
                        <th>الجنسية</th>
                        {{--<th>القيمة المالية</th>--}}
                        {{--<th>عدد الاسهم المملوكة</th>--}}
                        <th>الاجراءات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($stocks as $stock)
                        <tr>
                            <td style="width: 25%">{{$stock->full_name.' '.$stock->last_name}}</td>
                            <td dir="ltr" style="direction: ltr">{{$stock->mobile}}</td>
                            <td >{{$stock->nation}}</td>
{{--                            <td>{{$stock->stock->total}}</td>--}}
{{--                            <td>{{$stock->stock->stock_number}}</td>--}}
                            <td>

                                @can('stocks.show')
                                    @can('stocks.print')
                                                    <a class="btn btn-success mt-1" href="{{route('stock.print',[$stock->id,2])}}" target="_blank">  اصدار بطاقة حضور</a>
                                    @endcan
                                @endcan
                            </td>


                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="container col-md-12" style="padding-bottom: 25px">
                    <nav>
                        {{$stocks->links()}}
                    </nav>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function () {
            @if(request()->type)
                $('#type').val("{{request()->type}}");
            @endif
            console.log('asd');
            $('#active-btn').on('click',function () {
                console.log($(this).data('id'));
                var id=$(this).data('id');
                console.log(id);
                $('#form-active').attr('action',"{{route('stock.present-status')}}"+"/"+id+"/1")
                $('#from-active2').attr('action',"{{route('stock.present-status')}}"+"/"+id+"/2")
                $('#form-active3').attr('action',"{{route('stock.present-status')}}"+"/"+id+"/3")
                $('#un-present').attr('action',"{{route('stock.present-status')}}"+"/"+id+"/1")
            })
            $('#myModal').on('shown.bs.modal', function (e) {
                var id=$(e.relatedTarget).data('id');
                console.log(id);
                $('#form-active').attr('action',"{{route('stock.present-status')}}"+"/"+id+"/1")
                $('#from-active2').attr('action',"{{route('stock.present-status')}}"+"/"+id+"/2")
                $('#form-active3').attr('action',"{{route('stock.present-status')}}"+"/"+id+"/3")
                $('#un-present').attr('action',"{{route('stock.present-status')}}"+"/"+id+"/1")
            })
        });

        $('#type').on('change', function () {
            var url = window.location.href;
            if (url.includes('&type=')) {
                url = url.substr(0, url.indexOf('&type='));
                url = url + '&type=' + $('#type').val();

            } else if (url.includes('?type=')) {


                url = url.substr(0, url.indexOf('?type='));
                url = url + '?type=' + $('#type').val();
            } else {
                if (url.includes('?')) {
                    url = url + '&type=' + $('#type').val();
                } else {
                    url = url + '?type=' + $('#type').val();
                }


            }
//           console.log(url);
            window.location.href = url;

        });
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
            console.log(scanned_barcode);
            $('#barc').val(scanned_barcode);
            window.location.href="{{route('agent.index',0)}}"+"?search="+scanned_barcode;

            }

    </script>
    @endsection