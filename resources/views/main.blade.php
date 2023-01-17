@extends('layouts.main')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body" style="width:115%;margin-left: 125px!important;">
                <!-- Revenue, Hit Rate & Deals -->
                <nav class="header-navbar navbar-expand-sm navbar navbar-with-menu navbar-light navbar-shadow border-grey border-lighten-2" style="width: 74%;margin-left: 3px;margin-bottom: 1%;">
                    <div class="navbar-wrapper justify-content-center">

                        <div class="navbar-container content justify-content-center JustifyCenter">
                            <div id="navbar-mobile2" class="collapse navbar-collapse justify-content-center">
                                <ul class="nav navbar-nav  lng-nav justify-content-center JustifyFull" dir="rtl">
                                    <li class="nav-item">
                                        <a id="nav1" href="#" class="nav-link  active" data-lng="en" STYLE="font-weight: bold;font-size: 1.6rem"> النصاب القانوني للجلسة</a>
                                    </li>
                                    <li  class="nav-item"><a id="nav2" href="#" class="nav-link" data-lng="es" STYLE="font-weight: bold;font-size: 1.6rem">التصويت على بنود جدول الاعمال</a></li>
                                    {{--<li class="nav-item"><a id="nav3" href="#" class="nav-link" data-lng="pt" STYLE="font-weight: bold;font-size: 1.6rem"> عرض المرشحين</a></li>--}}
                                    <li class="nav-item"><a id="nav4" href="#" class="nav-link" data-lng="fr" STYLE="font-weight: bold;font-size: 1.6rem">التصويت على اختيار الاعضاء</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
                @php
                    $gathering_id=\App\Models\Gathering::orderBy('id','desc')->first()->id;

                    $setting=\App\Models\Setting::first()->stocks_count;
                    $stockCount=\App\Models\Stock::where('gathering_id',$gathering_id)->where('enter',1)->sum('stock_number');
                   if ($stockCount==0){
                    $stockCount=1;
                   }
                    $stock=\App\Models\Stock::where('gathering_id',$gathering_id)->where('enter',1)->get();
                    $stock1=\App\Models\Stock::where('gathering_id',$gathering_id)->where('agency1',0)->where('agency2',0)->where('enter',1)->orWhere([['enter','=',1],['id','=',4720]])->sum('stock_number');
        $stock2=\App\Models\Stock::where('gathering_id',$gathering_id)->where('agency1','!=',0)->OrWhere('agency2','!=',0)->where('id','!=',4720)->where('enter',1)->sum('stock_number');
                    $res=($stockCount/$setting)*100;
                @endphp
                <div class="row">
                    <div class="col-xl-12 col-12">
                        <div class="row">
                            <div class="col-lg-8 col-12" hidden>
                                <div class="card pull-up">
                                    <div class="card-header bg-hexagons">
                                        <h4 class="card-title">Hit Rate
                                            <span class="danger">-12%</span>
                                        </h4>
                                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                        <div class="heading-elements">
                                            <ul class="list-inline mb-0">
                                                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-content collapse show bg-hexagons">
                                        <div class="card-body pt-0">
                                            <div class="chartjs">
                                                <canvas id="hit-rate-doughnut" height="315"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-3" id="nav-i112">
                                <div class="card pull-up" style="margin-top: 33%">
                                    <div class="card-content collapse show bg-gradient-directional-primary ">
                                        <div class="card-body " >
                                            <h2 style="font-weight: bold;font-size: 1.6rem;text-align:center" class="card-title white">عدد الاسهم الكلية</h2>
                                            <h1 id="" style="font-weight: bold;font-size: 1.6rem;text-align:center" class="card-title white">{{number_format($setting,0)}}</h1>

                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="col-lg-3 col-3" id="nav-i1">
                                <div class="card pull-up">
                                    <div  id="cha" class="card-content collapse show bg-gradient-directional-danger " style="padding: 14px">
                                        <div id="cha2" class="card-body bg-hexagons-danger" >
                                            <h4 style="font-weight: bold;font-size: 1.6rem;direction: rtl" class="card-title white">النصاب القانوني للجلسة

                                                <span class="white" id="res">{{round($res,3)}}%</span>
                                                <span class="float-right">

                        </span>
                                            </h4>
                                            <div class="chartjs">
                                                <canvas id="deals-doughnut" height="275"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-3" id="nav-i111">

                                <div class="card pull-up" style="background-color: transparent">
                                    <div class="card-content collapse show bg-gradient-directional-success " style="margin: 1%">
                                        <div class="card-body " >
                                            <h2 style="font-weight: bold;font-size: 1.6rem;text-align:center" class="card-title white" ><b>عدد الاسهم الحاضرة</b></h2>
                                            <h1 id="stockPres" style="font-weight: bold;font-size: 1.6rem;text-align:center" class="card-title white">{{number_format($stockCount,0)}}</h1>

                                        </div>
                                    </div>
                                    <div class="card-content collapse show bg-gradient-directional-success " style="margin: 1%">
                                        <div class="card-body " >
                                            <h2 style="font-weight: bold;font-size: 1.6rem;text-align:center" class="card-title white">عدد الاسهم الحاضرة بالاصالة</h2>
                                            <h1 id="stockPres1" style="font-weight: bold;font-size: 1.6rem;text-align:center" class="card-title white">{{number_format($stock1,0)}}</h1>

                                        </div>
                                    </div>
                                    <div class="card-content collapse show bg-gradient-directional-success " style="margin: 1%">
                                        <div class="card-body " >
                                            <h2 style="font-weight: bold;font-size: 1.6rem;text-align:center" class="card-title white">عدد الاسهم الحاضرة بالوكالة</h2>
                                            <h1 id="stockPres2" style="font-weight: bold;font-size: 1.6rem;text-align:center" class="card-title white">{{number_format($stock2,0)}}</h1>

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-12 col-lg-9" id="nav-i4">
                                <nav class="header-navbar navbar-expand-sm navbar navbar-with-menu navbar-light navbar-shadow border-grey border-lighten-2" style="width: 100%;margin-left: 3px;margin-bottom: 1%;">
                                    <div class="navbar-wrapper justify-content-center">

                                        <div class="navbar-container content justify-content-center JustifyCenter">
                                            <div id="navbar-mobile2" class="collapse navbar-collapse justify-content-center">
                                                <ul class="nav navbar-nav  lng-nav justify-content-center JustifyFull" dir="rtl">
                                                    <li class="nav-item">
                                                        <a id="nav11" href="#" class="nav-link  active" data-lng="en" STYLE="font-weight: bold;font-size: 1.6rem">المرشحون لانتخاب اعضاء مجلس الادارة</a>
                                                    </li>
                                                    <li  class="nav-item"><a id="nav22" href="#" class="nav-link" data-lng="es" STYLE="font-weight: bold;font-size: 1.6rem">2</a></li>
                                                    {{--<li class="nav-item"><a id="nav3" href="#" class="nav-link" data-lng="pt" STYLE="font-weight: bold;font-size: 1.6rem"> عرض المرشحين</a></li>--}}
                                                    <li class="nav-item"><a id="nav44" href="#" class="nav-link" data-lng="fr" STYLE="font-weight: bold;font-size: 1.6rem">3</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </nav>
                                <div class="card">
                                    <div class="card-header text-center" >

                                    </div>
                                    <div class="card-content collapse show">
                                        <div class="card-body pt-0" id="nav-i11">
                                            @foreach(\App\Models\Candidate::where('gathering_id',$gathering_id)->where('postion','مجلس ادارة')->where('shows',1)->orderBy('stock_type','desc')->get() as $candidate)
                                                <p class="pt-1"><span class="text-bold-600" id="canc{{$candidate->id}}">
                                                        {{$candidate->votes!=null?number_format($candidate->votes->votes,0):0}}</span>/{{number_format($stockCount,0)}} <span id="canper{{$candidate->id}}" >({{$candidate->votes!=null?round(($candidate->votes->votes/$stockCount)*100,3):0}}%)</span>
                                                    <span class="float-right">
                      {{$candidate->name}} ({{$candidate->person_type}}) </span>
                                                </p>
                                                <div class="progress progress-sm mt-1 mb-0 box-shadow-1" >
                                                    <div id="can{{$candidate->id}}" class="progress-bar bg-gradient-x-success" role="progressbar" style="width: {{$candidate->votes!=null?($candidate->votes->votes/$stockCount)*100:0}}%"
                                                         aria-valuenow="20" aria-valuemin="0" aria-valuemax="{{$stockCount}}"></div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="card-body pt-0" id="nav-i22">
                                            @foreach(\App\Models\Candidate::where('gathering_id',$gathering_id)->where('postion','هيئة شرعية')->where('shows',1)->get() as $candidate)
                                                <p class="pt-1"><span class="text-bold-600" id="canc{{$candidate->id}}">{{$candidate->votes!=null?number_format($candidate->votes->votes,0):0}}</span>/{{number_format($stockCount,0)}} ({{$candidate->votes!=null?round(($candidate->votes->votes/$stockCount)*100,3):0}}%)
                                                    <span class="float-right">
                      {{$candidate->name}} </span>
                                                </p>
                                                <div class="progress progress-sm mt-1 mb-0 box-shadow-1" >
                                                    <div id="can{{$candidate->id}}" class="progress-bar bg-gradient-x-success" role="progressbar" style="width: {{$candidate->votes!=null?($candidate->votes->votes/$stockCount)*100:0}}%"
                                                         aria-valuenow="20" aria-valuemin="0" aria-valuemax="{{$stockCount}}"></div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="card-body pt-0" id="nav-i44">
                                            @foreach(\App\Models\Candidate::where('gathering_id',$gathering_id)->where('postion','مدقق حسابات')->where('shows',1)->get() as $candidate)
                                                <p class="pt-1"><span class="text-bold-600" id="canc{{$candidate->id}}">{{$candidate->votes!=null?number_format($candidate->votes->votes,0):0}}</span>/{{number_format($stockCount,0)}} ({{$candidate->votes!=null?round(($candidate->votes->votes/$stockCount)*100,3):0}}%)
                                                    <span class="float-right">
                      {{$candidate->name}} </span>
                                                </p>
                                                <div class="progress progress-sm mt-1 mb-0 box-shadow-1" >
                                                    <div id="can{{$candidate->id}}" class="progress-bar bg-gradient-x-success" role="progressbar" style="width: {{$candidate->votes!=null?($candidate->votes->votes/$stockCount)*100:0}}%"
                                                         aria-valuenow="20" aria-valuemin="0" aria-valuemax="{{$stockCount}}"></div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-9" id="nav-i2">
                                <h4 style="font-weight: bold;font-size: 150%" class="card-title text-center"> التصويت على بنود جدول الاعمال</h4>

                                @foreach(\App\Models\Record::where('gathering_id',$gathering_id)->where('type',2)->get()  as $record)
                                    <div class="col-12 col-lg-12">
                                        <div class="card">
                                            <div class="card-header text-center">
                                                <h4 style="font-weight: bold;font-size: 150%" class="card-title text-center"> البند رقم {{$record->sort}}</h4>
                                                <h4 style="font-weight: bold;font-size: 150%" class="card-title text-center">{{$record->text}}</h4>
                                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                                <div class="heading-elements">
                                                    <ul class="list-inline mb-0">

                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="card-content collapse show">
                                                <div class="card-body pt-0">

                                                    <p class="pt-1"><span class="text-bold-600" id="yess{{$record->id}}">{{number_format($record->yesAnswerStock($record->id),0)}}</span>/{{number_format($stockCount,0)}} <span id="recYes{{$record->id}}">({{round(($record->YesAnswerStock($record->id)/$stockCount)*100,3)}}%)</span>
                                                        <span class="float-right">
                      نعم</span>
                                                    </p>
                                                    <div class="progress progress-sm mt-1 mb-0 box-shadow-1">
                                                        <div id="yes{{$record->id}}" class="progress-bar bg-gradient-x-success" role="progressbar" style="width:{{($record->yesAnswerStock($record->id)/$stockCount)*100}}%"
                                                             aria-valuenow="{{($record->NoAnswerStock($record->id)/$stockCount)*100}}" aria-valuemin="0" aria-valuemax="{{$stockCount}}"></div>
                                                    </div>
                                                    <p class="pt-1"><span class="text-bold-600" id="noo{{$record->id}}">{{number_format($record->NoAnswerStock($record->id),0)}}</span>/{{number_format($stockCount,0)}}  <span id="recNo{{$record->id}}">({{round(($record->NoAnswerStock($record->id)/$stockCount)*100,3)}}%)</span>
                                                        <span class="float-right">
                      لا</span>
                                                    </p>
                                                    <div class="progress progress-sm mt-1 mb-0 box-shadow-1" >
                                                        <div id="no{{$record->id}}" class="progress-bar bg-gradient-x-danger" role="progressbar" style="width: {{($record->NoAnswerStock($record->id)/$stockCount)*100}}%"
                                                             aria-valuenow="{{($record->NoAnswerStock($record->id)/$stockCount)*100}}" aria-valuemin="0" aria-valuemax="{{$stockCount}}"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 0px;
    bottom: 30px;
    position: relative;
    color: rgba(105,105,105,0.66);
    left: 30px;">
            <img class="col-12" src="{{asset('qlogo.png')}}" style="max-width: 10% !important;">
        <h5 class="col-12" style="font-size: 1.8rem;color: rgba(105,105,105,0.66);" ><strong>Powerd by Qtech Group</strong></h5>
    </div>
    </div>
@endsection