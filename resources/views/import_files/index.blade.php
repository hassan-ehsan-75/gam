@extends('layouts.new')
@section('title','ملفات جدول المساهمين')
@section('content')
    <style>
        svg{
            width: 3% !important;
            direction: none !important;
        }
    </style>
    <div class="container-fluid" style="padding-top: 25px; text-align:center">
        <div class="container justify-content-center" style="text-align: center;">
            <h2 style="text-align: center;">ملفات جدول المساهمين </h2><Br>
            <div class="row justify-content-center">
                @can('users.create')
                    <div class="col-md-2">
                        <a type="button" href="{{route('import.create')}}" class="btn btn-default-big"><i
                            ></i> تحميل جدول المساهمين</a>
                    </div>
                @endcan
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
               <div style="display: inline-block;width:100%;margin-right: 1%" class="col-2 row ml-1">
                <label for="type" class="col-md-12">الفرز حسب الجمعية</label>
                <select class="option-control col-md-12" name="type" style="height: 50%" id="branch_id"  onchange="window.location.href='{{url('/importt')}}/'+this.value+'?search='+'{{$search}}'">

                        @foreach(\App\Models\Gathering::all() as $gath)
                            <option @if($gathering==$gath->id) selected @endif value="{{$gath->id}}">{{$gath->g_number.'-'.\App\Models\Gathering::$g_type[$gath->type].'-'.$gath->g_date}}</option>
                        @endforeach

                </select>
            </div>
                <div class="container col-md-3 mt-4 pb-2 pt-1" style="height:100%;">
                    <div style="display: inline-block;width:100%;text-align:center">

                        <label>بحث</label>
                        <form style="display: inline-block;" method="GET" action="{{route('import.home',$gathering)}}">
                            <input type="text" class="option-control pt-2 pb-2" name="search" value="{{request('search')}}">
                            <button type="submit" class="btn btn-secondary option-control mb-1">ابحث</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>الملف</th>
                        <th>رقم الجمعية</th>
                        <th>تاريخ الاستيراد</th>
                        <th>الاجراءات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($files as $file)
                        <tr>
                            <td>{{$file->file}}</td>
                            <td >{{$file->gathering->g_number}}</td>
                            <td>{{$file->created_at}}</td>
                            <td>
                                <a href="{{asset('storage/'.$file->file)}}">تحميل</a>
                            </td>


                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="container col-md-12" style="padding-bottom: 25px">
                    <nav>
                        {{$files->links()}}
                    </nav>
                </div>
            </div>

        </div>
    </div>

@endsection