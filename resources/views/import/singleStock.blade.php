@extends('layouts.print')
@section('title',' ')
<style>
    svg{
        max-height: 100px !important;
    }
    @media print {
        .container { page-break-after: always; }
    }
</style>
    @section('s_id')
{{--{{dd($stock)}}--}}

         @if($stock->p_number!=null)
             | رقم الطلب:{{$stock->id}}
         <svg style="max-height:75px" class="barcode"
              jsbarcode-value="{{$stock->id.','.$stock->gathering_id.','.$type}}"
              jsbarcode-textmargin="0"
              jsbarcode-fontoptions="bold">
         </svg>
        @endif
        @endsection
<script src="{{asset('JsBarcode.all.min.js')}}"></script>
@section('content')
<div class="container" style="">
    
        <div class="row">
        
        <div class="col-md-12">
            <h5>1-المعلومات الاساسية:</h5>
            <table class="table table-bordered">
            <thead>
                <th>الاسم الاول</th>
                <th>اسم الأب</th>
                <th>اسم الأم</th>
                <th>تاريخ و مكان الولادة</th>
            </thead>
            <tbody>
                <tr>

                    <td>{{$stock->full_name}}</td>
                    <td>{{$stock->father}}</td>
                    <td>{{$stock->mother}}</td>
                    <td>{{$stock->birthday}}</td>
                        {{--@else--}}
                        {{--<td>{{$stock->full_name}}</td>--}}
                        {{--<td>{{$stock->father}}</td>--}}
                        {{--<td>{{$stock->mother}}</td>--}}
                        {{--<td>{{$stock->birthday}}</td>--}}

                </tr>
            </tbody>
        </table>
        </div>
        </div>

    <div class="row" hidden>

        <div class="col-md-12">
            @if($type==1)
            <h5>-مفوض عن :</h5>

            @foreach($stock->agents1 as $stockk)
            <table class="table table-bordered">
            <thead>
                <th>الاسم الاول</th>
                <th>اسم الأب</th>
                <th>اسم الأم</th>
                <th>تاريخ و مكان الولادة</th>
            </thead>
            <tbody>
                <tr>

                            <td>{{$stockk->full_name}}</td>
                            <td>{{$stockk->father}}</td>
                            <td>{{$stockk->mother}}</td>
                            <td>{{$stockk->birthday}}</td>

                </tr>
            </tbody>
        </table>
                @endforeach

            @endif
                @if($type==2)
                    <h5>-مفوض عن :</h5>
            @foreach(\App\Models\Stock::where('agency2',$stock->id)->get() as $stockk)
            <table class="table table-bordered">
            <thead>
                <th>الاسم الاول</th>
                <th>اسم الأب</th>
                <th>اسم الأم</th>
                <th>تاريخ و مكان الولادة</th>
            </thead>
            <tbody>
                <tr>

                            <td>{{$stockk->full_name}}</td>
                            <td>{{$stockk->father}}</td>
                            <td>{{$stockk->mother}}</td>
                            <td>{{$stockk->birthday}}</td>

                </tr>
            </tbody>
        </table>
                @endforeach
                    @endif
        </div>
        </div>



        <div class="row">
        <div class="col-md-12">
            <h5>2-معلومات عن الاسهم المملوكة:</h5>
            <table class="table table-bordered">
                <thead>
                    <th>عدد الأسهم بالاصالة </th>
                    <th>عدد الاسهم بالوكالة</th>
                    <th>مجموع الأسهم </th>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            
                        @if($type!=2)
                                @if($stock->agents1->count()==0 )

                                    {{$stock->stock_number}}
                                    @elseif($stock->agents1->count()>0)
                                    @if($stock->agents1->first()->user_id!=2)
                                    {{$stock->stock_number}}
                                    @else
                                    {{$stock->stock_number+$stock->agents1Sum()}}
                                    @endif
                                @endif
                                @else
                                @if($stock->stock->user_id==2)
                                        {{$stock->stocksSum()}}
                                        @endif
                                @endif
                            

                        </td>
                    <td>

                    
                            @if($type==2 )
                                    @if($stock->stock->user_id!=2)
                                        {{$stock->stocksSum()}}
                                        @endif
                            @elseif($stock->agents1->count()>0)
                            @if($stock->agents1->first()->user_id!=2)
                            {{$stock->agents1Sum()}}
                            @endif
                        @endif
                    
                    </td>

                        <td>
                        
                            @if($type!=2)
                            
                                {{$stock->stock_number+$stock->agents1Sum()}}
                                @else
                                {{$stock->stocksSum()}}
                            @endif
                            
                            
                            

                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        </div>

    <div class="row">
        <div class="col-md-12">
            <h5>3-بنود جدول الاعمال:</h5>
            <table class="table table-bordered">
                <tbody>
                @foreach(\App\Models\Record::where('gathering_id',$stock->gathering_id)->get() as $item )
                <tr style="font-weight: bold;margin-bottom: 8px">
                    <td>{!! $item->sort.' - '.$item->description !!}<br>
                    @if($item->type==2)
                        <input type="checkbox" class="ml-1"> نعم
                            @if($stock->p_number!=null)
                            <svg style="max-height:75px" class="barcode"

                                    jsbarcode-value="{{$item->id}},1,{{$stock->id}},{{$type}}"
                                    jsbarcode-textmargin="0"
                                    jsbarcode-fontoptions="bold">
                            </svg>
                            @endif
                            <input type="checkbox" class="ml-1 " style="margin-right:25%">لا
                            @if($stock->p_number!=null)
                            <svg style="max-height:75px" class="barcode"

                                   jsbarcode-value="{{$item->id}},0,{{$stock->id}},{{$type}}"
                                   jsbarcode-textmargin="0"
                                   jsbarcode-fontoptions="bold">
                            </svg>
                                @endif

                    @endif
                        </td>
                </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    
</div>
@php
$gath=\App\Models\Gathering::where('status',1)->first()->id;
    $manage=\App\Models\Candidate::where('gathering_id',$gath)->where('postion','مجلس ادارة')->get();
           $staffs=\App\Models\Candidate::where('gathering_id',$gath)->where('postion','هيئة شرعية')->get();
           $accounts=\App\Models\Candidate::where('gathering_id',$gath)->where('postion','مدقق حسابات')->get();
@endphp
<div class="container c2" style="margin-right: 100px;padding-top: 10px;padding-left: 100px">

    @php
        $number=1;
    @endphp
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                <th>الاسم الاول</th>
                <th>اسم الأب</th>
                <th>اسم الأم</th>
                <th>تاريخ و مكان الولادة</th>
                </thead>
                <tbody>
                <tr>

                    <td>{{$stock->full_name}}</td>
                    <td>{{$stock->father}}</td>
                    <td>{{$stock->mother}}</td>
                    <td>{{$stock->birthday}}</td>
                    {{--@else--}}
                    {{--<td>{{$stock->full_name}}</td>--}}
                    {{--<td>{{$stock->father}}</td>--}}
                    {{--<td>{{$stock->mother}}</td>--}}
                    {{--<td>{{$stock->birthday}}</td>--}}

                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-12">
            {{--<h6 class="text-center">اسماء المرشحين--}}
                @if($stock->p_number!=null)
                    <span class="pull-left">
                    | رقم الطلب:{{$stock->id}}
                    </span>
                @endif
            </h6>
            <h6>بموجب احكام الفقرة 4 من المادة 12 للنظام الاساسي للبنك ممثلو مجلس الادارة عن  {{ $manage->first()->person_type }} </h6>
            <table class="table table-bordered">
                <tbody>
                @foreach($manage as $item )
                    @if(!in_array($item->person_type,['مساهم','مستقل']))
                        <tr style="font-weight: bold;margin-bottom: 8px">
                            <td class="row">
                                <span style="direction: rtl" type="checkbox" class="ml-1 col-6">{{$number.'- '.$item->name}}- ({{$item->postion}})</span>
                                @if($item->type==1&&$stock->p_number!='_')
                                    <input type="checkbox" class="ml-1"> نعم
                                    <svg style="max-height:100px"class="barcode  col-2"

                                         jsbarcode-value="{{$item->id.','.$item->gathering_id.','.$stock->id.','.$type}}"
                                         jsbarcode-textmargin="0"
                                         jsbarcode-fontoptions="bold" >

                                    </svg>
                                    <input type="checkbox" class="ml-1 mr-5" style="margin-right:7% !important">لا
                                    <svg style="max-height:100px"class="barcode  col-32"
                                    jsbarcode-value="NO"
                                    jsbarcode-textmargin="0"
                                    jsbarcode-fontoptions="bold" ></svg>
                                @endif
                            </td>

                        </tr>
                        @php
                            $number++;
                        @endphp
                    @endif
                @endforeach
                </tbody>
            </table>
            @php
                $number=1;
            @endphp
            <h6>المرشحون المساهمين  </h6>
            <table class="table table-bordered">
                <tbody>
                @foreach($manage as $item )
                    @if($item->person_type=='مساهم')
                        <tr style="font-weight: bold;margin-bottom: 8px" >
                            <td class="row">

                                <span style="direction: rtl" type="checkbox" class="ml-1 col-5">{{$number.'- '.$item->name.' ( '.$item->person_type.' )'}}</span>
                                @if($item->type==1&&$stock->p_number!='_')
                                    <input type="checkbox" class="ml-2">نعم
                                    <svg style="max-height:100px" class="barcode col-3"

                                         jsbarcode-value="{{$item->id.','.$item->gathering_id.','.$stock->id.','.$type}}"
                                         jsbarcode-textmargin="0"
                                         jsbarcode-fontoptions="bold" ></svg>
                                    <input type="checkbox" class="ml-1 mr-5" style="margin-right:7% !important">لا
                                    <svg style="max-height:100px" class="barcode  col-2"

                                         jsbarcode-value="NO"
                                         jsbarcode-textmargin="0"
                                         jsbarcode-fontoptions="bold" ></svg>
                                @endif
                            </td>

                        </tr>
                        @php
                            $number++;
                        @endphp
                    @endif
                @endforeach
                </tbody>
            </table>
            @php
                $number=1;
            @endphp
            <h6>المرشحون المستقلين </h6>
            <table class="table table-bordered">
                <tbody>
                @foreach($manage as $item )
                    @if($item->person_type=='مستقل')
                        <tr style="font-weight: bold;margin-bottom: 8px">
                            <td class="row">
                                <span style="direction: rtl" type="checkbox" class="ml-1 col-5">{{$number.'- '.$item->name.' ( '.$item->person_type.' )'}}</span>
                                @if($item->type==1&&$stock->p_number!='_')
                                    <input type="checkbox" class="ml-2">نعم
                                    <svg style="max-height:100px" class="barcode col-3"

                                         jsbarcode-value="{{$item->id.','.$item->gathering_id.','.$stock->id.','.$type}}"
                                         jsbarcode-textmargin="0"
                                         jsbarcode-fontoptions="bold" ></svg>
                                    <input type="checkbox" class="ml-1 mr-5" style="margin-right:7% !important">لا
                                    <svg style="max-height:100px" class="barcode  col-2"

                                         jsbarcode-value="NO"
                                         jsbarcode-textmargin="0"
                                         jsbarcode-fontoptions="bold" ></svg>
                                @endif
                            </td>

                        </tr>
                        @php
                            $number++;
                        @endphp
                    @endif
                @endforeach
                </tbody>
            </table>
            @php
                $number=1;
            @endphp
            <h6>المرشحون لانتخاب اعضاء هيئة شرعية</h6>
            <table class="table table-bordered">
                <tbody>
                @foreach($staffs as $item )
                    <tr style="font-weight: bold;margin-bottom: 8px">
                        <td class="row">
                            <span style="direction: rtl" type="checkbox" class="ml-1 col-5">{{$number.'- '.$item->name}}</span>
                            @if($item->type==1)
                                <input type="checkbox" class="ml-2">نعم
                                <svg style="max-height:100px" class="barcode col-3"

                                     jsbarcode-value="{{$item->id.','.$item->gathering_id.','.$stock->id.','.$type}}"
                                     jsbarcode-textmargin="0"
                                     jsbarcode-fontoptions="bold" ></svg>
                                <input type="checkbox" class="ml-1 mr-5" style="margin-right:7% !important">لا
                                <svg style="max-height:100px" class="barcode  col-2"

                                     jsbarcode-value="NO"
                                     jsbarcode-textmargin="0"
                                     jsbarcode-fontoptions="bold" ></svg>
                            @endif
                        </td>

                    </tr>
                    @php
                        $number++;
                    @endphp
                @endforeach
                </tbody>
            </table>
            @php
                $number=1   ;
            @endphp
            <h6>المرشحون لانتخاب مدقق حسابات </h6>
            <table class="table table-bordered">
                <tbody>
                @foreach($accounts as $item )
                    <tr style="font-weight: bold;margin-bottom: 8px">
                        <td class="row" >
                            <span style="direction: rtl" type="checkbox" class="ml-1 col-5">{{$number.'- '.$item->name}}</span>
                            @if($item->type==1)
                                <input type="checkbox" class="ml-2">نعم
                                <svg style="max-height:100px" class="barcode col-3"

                                     jsbarcode-value="{{$item->id.','.$item->gathering_id.','.$stock->id.','.$type}}"
                                     jsbarcode-textmargin="0"
                                     jsbarcode-fontoptions="bold" ></svg>
                                <input type="checkbox" class="ml-1 mr-5" style="margin-right:7% !important">لا
                                <svg style="max-height:100px"class="barcode  col-2"

                                     jsbarcode-value="NO"
                                     jsbarcode-textmargin="0"
                                     jsbarcode-fontoptions="bold" ></svg>
                            @endif
                        </td>

                    </tr>
                    @php
                        $number++;
                    @endphp
                @endforeach
                </tbody>
            </table>

        </div>
    </div>


</div>
<script>
    $(document).ready(function () {
        JsBarcode(".barcode").init();
        window.print()
        @php
         $gathering=\App\Models\Gathering::where('status',1)->first()->id;
        @endphp
        {{--window.open("{{route('candidates.show',$gathering).'?gathering='.$gathering.'&stock='.$stock->id}}", '_blank');--}}

    })
</script>
@endsection
