@extends('layouts.new')
@section('title','البنود')
@section('content')
    <style>
        svg{
            width: 3% !important;
            direction: none !important;
        }
    </style>
    <div class="container-fluid" style="padding-top: 25px; text-align:center">
        <div class="container justify-content-center" style="text-align: center;">
            <h2 style="text-align: center;">البنود</h2><Br>
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
                <select class="option-control col-md-12" name="type" style="height: 50%" id="branch_id"  onchange="window.location.href='{{url('/records')}}/'+'?search='+'{{$search}}'+'&gathering='+this.value">

                        @foreach(\App\Models\Gathering::all() as $gath)
                            <option @if($gathering==$gath->id) selected @endif value="{{$gath->id}}">{{$gath->g_number.'-'.\App\Models\Gathering::$g_type[$gath->type].'-'.$gath->g_date}}</option>
                        @endforeach

                </select>
            </div>
                <div class="container col-md-3 mt-4 pb-2 pt-1" style="height:100%;">
                    <div style="display: inline-block;width:100%;text-align:center">

                        <label>بحث</label>
                        <form style="display: inline-block;" method="GET" action="{{url('records')}}">
                            <input type="text" class="option-control pt-2 pb-2" name="search" value="{{request('search')}}">
                            <button type="submit" class="btn btn-secondary option-control mb-1">ابحث</button>
                        </form>
                    </div>
                </div>
                <div class="container col-md-3 mt-4 pb-2 pt-1" style="height:100%;">
                    <div style="display: inline-block;width:100%;text-align:center">
                        <a class="btn btn-success" href="{{route('records.create')}}">اضافة بند</a>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>البند</th>
                        <th>نوع البند</th>
                        <th>رقم الجمعية</th>
                        <th>تاريخ الادخال</th>
                        <th>الاجراءات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($records as $record)
                        <tr>
                            <td style="width: 30%">{{$record->text}}</td>
                            <td >@if($record->type==1) غير قابل للتصويت @elseif($record->type==2) قابل للتصويت @else مرشحين @endif</td>
                            <td >{{$record->gathering->g_number}}</td>
                            <td>{{$record->created_at}}</td>
                            <td class="row">
                                @if($record->gathering->status==1)
                                <a class="btn btn-warning col-3" href="{{route('records.edit',$record->id)}}">تعديل</a>
                                <form action="{{route('records.destroy',$record->id)}}" method="post" class=" col-3">
                                    @csrf
                                    @method('DELETE')

                                <button type="submit" class="btn btn-danger" style="border-radius:5% !important;">حذف</button>
                                </form>
                                    @endif
                            </td>


                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="container col-md-12" style="padding-bottom: 25px">
                    <nav>
                        {{$records->links()}}
                    </nav>
                </div>
            </div>

        </div>
    </div>

@endsection