@extends('layouts.print')
@section('title',' ')
<style>
    svg{
        max-height: 100px !important;
    }
    td{
        text-align: center;
        vertical-align: middle;
        align-items: center;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
@section('content')
<div class="container" style="margin-right: 100px;margin-right: 100px;padding-left: 100px">

@php
$number=1;
@endphp
    <div class="row">
        <div class="col-md-12">
            <h6 class="text-center">اسماء المرشحين</h6>
            <h6>بموجب احكام الفقرة 4 من المادة 12 للنظام الاساسي للبنك ممثلو مجلس الادارة عن  {{ $manage->first()->person_type }} </h6>
            <table class="table table-bordered">
                <tbody>
                @foreach($manage as $item )
                    @if(!in_array($item->person_type,['مساهم','مستقل']))
                <tr style="font-weight: bold;margin-bottom: 8px">
                    <td class="row">
                        <span style="direction: rtl" type="checkbox" class="ml-1 col-6">{{$number.'- '.$item->name}}- ({{$item->postion}})</span>
                        @if($item->type==1)
                            <input type="checkbox" class="ml-1"> نعم
                        <svg style="max-height:100px"class="barcode  col-2"

                                jsbarcode-value="{{$item->id.','.$item->gathering_id.','.$stock}}"
                                jsbarcode-textmargin="0"
                             jsbarcode-fontoptions="bold" >

                        </svg>
                            <input type="checkbox" class="ml-1 mr-5" style="margin-right:7% !important">لا
                        <svg style="max-height:100px"class="barcode  col-32

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
                            
                            <span style="direction: rtl" type="checkbox" class="ml-1 col-6">{{$number.'- '.$item->name.' ( '.$item->person_type.' )'}}</span>
                            @if($item->type==1)
                                <input type="checkbox" class="ml-2">نعم
                                <svg style="max-height:100px"class="barcode col-2"

                                     jsbarcode-value="{{$item->id.','.$item->gathering_id.','.$stock}}"
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
                            <span style="direction: rtl" type="checkbox" class="ml-1 col-6">{{$number.'- '.$item->name.' ( '.$item->person_type.' )'}}</span>
                            @if($item->type==1)
                                <input type="checkbox" class="ml-2">نعم
                                <svg style="max-height:100px"class="barcode col-2"

                                     jsbarcode-value="{{$item->id.','.$item->gathering_id.','.$stock}}"
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
                            <span style="direction: rtl" type="checkbox" class="ml-1 col-6">{{$number.'- '.$item->name}}</span>
                            @if($item->type==1)
                                <input type="checkbox" class="ml-2">نعم
                                <svg style="max-height:100px"class="barcode col-2"

                                     jsbarcode-value="{{$item->id.','.$item->gathering_id.','.$stock}}"
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
            @php
                $number=1   ;
            @endphp
            <h6>المرشحون لانتخاب مدقق حسابات </h6>
            <table class="table table-bordered">
                <tbody>
                @foreach($accounts as $item )
                    <tr style="font-weight: bold;margin-bottom: 8px">
                        <td class="row" >
                            <span style="direction: rtl" type="checkbox" class="ml-1 col-6">{{$number.'- '.$item->name}}</span>
                            @if($item->type==1)
                                <input type="checkbox" class="ml-2">نعم
                                <svg style="max-height:100px"class="barcode col-2"

                                     jsbarcode-value="{{$item->id.','.$item->gathering_id.','.$stock}}"
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
    })
</script>
@endsection
