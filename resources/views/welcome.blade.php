@extends('layouts.new')
@section('title','الرئيسية')
@section('content')
    <div class="row" style="padding-left:25px;padding-right:25px">

        <div class="col-md-12" style="margin-bottom: 25px;margin-top:20px">
            <h2>الجمعيةالحالية</h2>
        </div>

        <div class="col-md-4">

            <div class="card">
                <div class="row">
                    <div class="col-md-4">
                        <div class="rounded">

                            <img src="images/pointer2.png" width="50px" height="50px"/>
                        </div>

                    </div>
                    <div class="col-md-8">
                        @php $gathering=\App\Models\Gathering::orderBy('id','desc')->where('status',1)->first(); @endphp
                        <p><strong>رقم الجمعية: {{$gathering->g_number}} </strong></p>

                        <p class="info-green">طبيعة الجمعية: {{ \App\Models\Gathering::$g_type[$gathering->type] }} </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">

            <div class="card">
                <div class="row">
                    <div class="col-md-4">
                        <div class="rounded"><img src="images/group.png" width="50px" height="50px"/></div>

                    </div>
                    <div class="col-md-8">
                        <p><strong>عدد المساهمين</strong></p>
                        <p class="info-green">{{\App\Models\Stock::where('gathering_id',$gathering->id)->count()}} مساهم </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">

            <div class="card">
                <div class="row">
                    <div class="col-md-4">
                        <div class="rounded">
                            <img src="images/calendar.png" width="50px" height="50px"/>
                        </div>

                    </div>
                    <div class="col-md-8">
                        <p><strong>تاريخ انعقاد الجمعية</strong></p>
                        <p class="info-green">{{$gathering->g_date.' '.$gathering->g_time}} </p>
                    </div>
                </div>
            </div>
        </div> <div class="col-md-4 mt-5 " style="visibility:hidden" >

            <div class="card">
                <div class="row">
                    <div class="col-md-4">
                        <div class="rounded">
                            <img src="images/calendar.png" width="50px" height="50px"/>
                        </div>

                    </div>
                    <div class="col-md-8">
                        <p><strong>شرح الجمعية</strong></p>
                        <p class="info-green">{{$gathering->description}} </p>
                    </div>
                </div>
            </div>
        </div>
        @can('main.view')
            @if(\App\Models\Stock::where('gathering_id',\App\Models\Gathering::orderBy('id','desc')->where('status',1)->first()->id)->count()>0)
        <div class="col-md-4 mt-5"  onclick="window.location.href={{route('main')}}" style="cursor:pointer;">

            <div class="card" style="" >
                <div class="row"  onclick="window.location.href='{{route('main')}}'" >
                    <div class="col-md-4">
                        <div class="rounded">
                            <img src="images/bar-chart.png" width="50px" height="50px"/>
                        </div>

                    </div>
                    <div class="col-md-8" style="font-size: 140%;margin-top: 5%;">
                        <p><strong>اظهار الشاشه الرئيسية</strong></p>
                    </div>
                </div>
            </div>
        </div>
            @endif
            @endcan
    </div>
@endsection