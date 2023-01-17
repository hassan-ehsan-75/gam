@extends('layouts.new')
@section('title','المرشحين')
@section('content')
    <style>
        svg{
            width: 3% !important;
            direction: none !important;
        }
    </style>
    <div class="container-fluid" style="padding-top: 25px; text-align:center">
        <div class="container justify-content-center" style="text-align: center;">
            <h2 style="text-align: center;">المرشحين</h2><Br>
            <div class="row justify-content-center">
                <div class="col-md-2">
                    {{--<a type="button" href="{{route('candidates.show',$gathering).'?gathering='.$gathering}}" class="btn btn-default-big" target="_blank"><i--}}
                        {{--></i>طباعة اسماء المرشحين</a>--}}
                </div>
            </div>
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
        <div class="container shadow p-3" style="margin-top: 15px;max-width: 1250px">
            <div class="row">
               <div style="display: inline-block;width:100%;margin-right: 1%" class="col-3 row ml-1">
                <label for="type" class="col-md-12">الفرز حسب الجمعية</label>
                <select class="option-control col-md-12" name="type" style="height: 50%" id="branch_id"  onchange="window.location.href='{{url('/candidates')}}/'+'?search='+'{{$search}}'+'&gathering='+this.value">
                    <option value="0">اختر</option>
                        @foreach(\App\Models\Gathering::all() as $gath)
                            <option @if($gathering==$gath->id) selected @endif value="{{$gath->id}}">{{$gath->g_number.'-'.\App\Models\Gathering::$g_type[$gath->type].'-'.$gath->g_date}}</option>
                        @endforeach

                </select>
            </div>
                <div class="container col-md-3 mt-4 pb-2 pt-1" style="height:100%;">
                    <div style="display: inline-block;width:100%;text-align:center">

                        <label>بحث</label>
                        <form style="display: inline-block;" method="GET" action="{{url('candidates')}}">
                            <input type="text" class="option-control pt-2 pb-2" name="search" value="{{request('search')}}">
                            <button type="submit" class="btn btn-secondary option-control mb-1">ابحث</button>
                        </form>
                    </div>
                </div>
                <div class="container col-md-3 mt-4 pb-2 pt-1" style="height:100%;">
                    <div style="display: inline-block;width:100%;text-align:center">
                        <a class="btn btn-success" href="{{route('candidates.create')}}">اضافة مرشح</a>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>الاسم الكامل</th>
                        <th>المنصب</th>
                        <th>رقم الجمعية</th>
                        <th>قابلية التصويت</th>
                        <th>تاريخ الادخال</th>
                        <th>الاجراءات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($candidates as $candidate)
                        <tr>
                            <td style="width: 25%">{{$candidate->name}}</td>
                            <td style="width: 10%">{{$candidate->postion}}</td>
                            <td style="width: 10%">@if($candidate->gathering!=null) {{$candidate->gathering->g_number}} @endif</td>
                            <td style="width: 10%">{{$candidate->type==0?'غير قابل للتصويت':'قابل للتصويت'}}</td>
                            <td>{{$candidate->created_at}}</td>
                            <td class="row">
                                <a class="btn btn-warning col-3" href="{{route('candidates.edit',$candidate->id)}}">تعديل</a>
                                <form action="{{route('candidates.destroy',$candidate->id)}}" method="post" class=" col-3">
                                    @csrf
                                    @method('DELETE')

                                <button type="submit" class="btn btn-danger" style="border-radius:5% !important;">حذف</button>
                                </form>
                            </td>


                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="container col-md-12" style="padding-bottom: 25px">
                    <nav>
                        {{$candidates->links()}}
                    </nav>
                </div>
            </div>

        </div>
    </div>

@endsection