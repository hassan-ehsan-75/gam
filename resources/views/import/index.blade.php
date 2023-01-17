@extends('layouts.new')
@section('title','المساهمين')
@section('content')
{{--    <link rel="stylesheet" href="{{asset('magicsuggest.css')}}">--}}
    {{--<script  src="{{asset('magicsuggest.js')}}"></script>--}}
<link href="{{asset('select2.min.css')}}" rel="stylesheet" />
<script src="{{asset('select2.min.js')}}"></script>
    <style>
        svg{
            width: 3% !important;
            direction: none !important;
        }
        .select2-search__field{
            width: 59.75em !important;
        }
    </style>
    @php $stock=new \App\Models\Stock() @endphp
    <div class="container-fluid" style="padding-top: 25px; text-align:center">
        <div class="container justify-content-center" style="text-align: center;">
            <h2 style="text-align: center;">المساهمين</h2><Br>
        </div>
        <div class="form-group text-center mt-1">
            <a class="btn btn-success" href="{{route('agent.index',0)}}">عرض المفوضين غير المساهمين</a>
            <a class="btn btn-success" href="{{route('agent.create',1)}}">تفعيل لاكثر من مساهم(تفويض مساهم)</a>
            <a class="btn btn-success" href="{{route('agent.create',2)}}">تفعيل لاكثر من مساهم(تفويض غير مساهم)</a>
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
                <select class="option-control col-md-12" name="type" style="height: 50%" id="branch_id"  onchange="window.location.href='{{url('/stockss')}}/'+this.value+'/'+0">

                        @foreach(\App\Models\Gathering::all() as $gath)
                            <option @if($gathering==$gath->id) selected @endif value="{{$gath->id}}">{{$gath->g_number.'-'.\App\Models\Gathering::$g_type[$gath->type].'-'.$gath->g_date}}</option>
                        @endforeach

                </select>
            </div>
                <div class="container col-md-3 mt-4 pb-2 pt-1" style="height:100%;">
                    <div style="display: inline-block;width:100%;text-align:center">

                        <label>بحث</label>
                        <form style="display: inline-block;" method="GET" action="{{route('import.index',[$bank,$branch])}}">
                            <input type="text" class="option-control pt-2 pb-2" name="search" value="">
                            <button type="submit" class="btn btn-secondary option-control mb-1">ابحث</button>
                        </form>
                    </div>
                </div>
                <div class="container col-md-5 mt-4 pb-2 pt-1" style="height:100%;">
                    <div style="width:100%;text-align:center">

                        <label>ادخال باركود الهوية</label>
                        <form style="display: inline-block;" method="GET" action="{{route('import.index',[$bank,$branch])}}">
                            <input id="barc" type="text" class="option-control pt-2 pb-2" name="search"  autofocus>
                            <button type="submit" class="btn btn-secondary option-control mb-1">ابحث</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>رقم الطلب</th>
                        <th >الاسم الكامل</th>
                        <th>موبايل</th>
                        <th>الجنسية</th>
                        <th>القيمة المالية</th>
                        <th>عدد الاسهم المملوكة</th>
                        <th>الحالة  </th>
                        <th>الاجراءات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($stocks as $stock)
                        <tr>
                            <td>@if(!in_array($stock->p_number,['-','_'])){{$stock->id}}@endif</td>
                            <td style="width: 25%">{{$stock->full_name.' '.$stock->last_name}}</td>
                            <td dir="ltr" style="direction: ltr">{{$stock->mobile}}</td>
                            <td >{{$stock->nation}}</td>
                            <td>{{$stock->total}}</td>
                            <td>{{$stock->stock_number}}</td>
{{--                            <td>@if($stock->bank!=null){{$stock->bank['ar_name']}}@endif</td>--}}
{{--                            <td>@if($stock->user!=null)@if($stock->user->branch!=null){{$stock->user->branch['name']}} @endif @endif</td>--}}
                            {{--<td>{{$stock->created_at}}</td>--}}
                            <td>{!! $stock->present==0?'<span class="btn btn-warning">غير مفعل</span>':'<span class="btn btn-success"> مفعل</span>'!!}

                            </td>
                            <td>

                                @can('stocks.show')
                                    @can('stocks.edit')
                                        <a class="btn btn-warning" href="{{route('stock.edit',$stock->id)}}">تعديل</a>
                                    @endcan

                                    @can('stocks.print')
                                        @if($stock->present==1)
                                            @if($stock->agency1==0&&$stock->agency2==0)
                                                @if(!\App\Models\Stock::where('agency1',$stock->id)->first())
                                            <a class="btn btn-success mt-1" href="{{route('stock.print',$stock->id)}}" target="_blank"> اصدار بطاقة حضور</a>
                                                    @else
                                                    <a class="btn btn-success mt-1" href="{{route('stock.print',[$stock->id,1])}}" target="_blank"> اصدار بطاقة حضور</a>
                                                    @endif
                                                @else
                                                @if($stock->agency1!=0)
                                                    <a class="btn btn-success mt-1" href="{{route('stock.print',[$stock->agent1->id,1])}}" target="_blank">مفوض عنه {{$stock->agent1->full_name}}<br>  اصدار بطاقة حضور</a>
                                                    @elseif($stock->agency2!=0)
                                                    <a class="btn btn-success mt-1" href="{{route('stock.print',[$stock->agency2,2])}}" target="_blank">مفوض عنه {{$stock->agent2->full_name}}<br>  اصدار بطاقة حضور</a>
                                                    @endif
                                                @endif
                                                {{--<a class="btn btn-success mt-1" href="{{route('candidates.show',$gathering).'?gathering='.$gathering.'&stock='.$stock->id}}" target="_blank">طباعة اسماء المرشحين</a>--}}
                                        @endif
                                    @endcan
                                @if($stock->present!=1)
                                    <button type="button" id="active-btn" class="btn btn-info " data-toggle="modal" data-id="{{$stock->id}}" data-target="#myModal" data-backdrop="false">تفعيل</button>
                                    @endif
                                @endcan
                            </td>


                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="container col-md-12" style="padding-bottom: 25px">
                    <nav>
                        @if(!request()->search)
                        {{$stocks->links()}}
                            @else
                            {{ $stocks->appends(['search'=>request()->search])->links() }}
                        @endif
                    </nav>
                </div>
            </div>

        </div>
    </div>

    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog" style="margin-left: 50%">

            <!-- Modal content-->
            <div class="modal-content" style="width: 210%;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">تفعيل</h4>
                </div>
                <div class="modal-body" style="padding: 2rem">
                    <div class="text-center">
                        <h3 class="">التفعيل</h3>
                        @can('stocks.present')
                            <form action="" method="post" enctype="multipart/form-data" class="row" id="form-active">
                                @csrf

                                    <div class="col-md-6 ">
                                        <div class="form-group">

                                            <label class="control-label" for="name">ملف</label>
                                            <input  type="file" class="form-control" name="file" >

                                            @error('file')
                                            <p style="color: red;">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4 pt-1">
                                        <button type="submit" class="btn btn-success text-center" value="1">تثبيت بالاصالة وطباعة بطاقة الحضور </button>

                                    </div>
                            </form>


                        @endcan
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">اغلاق</button>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('js')
    <script>

        $(document).ready(function () {
            $('.select2').select2({
                maximumSelectionLength: 1
            });
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
            window.location.href="{{route('import.index',[0,0])}}"+"?search="+scanned_barcode;

            }

        @if(session()->has('print'))
            window.open('{{route('stock.print',[session()->get('print'),1])}}', '_blank').focus();
        @endif


    </script>
    @endsection