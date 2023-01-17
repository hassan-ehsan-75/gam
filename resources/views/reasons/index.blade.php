@extends('layouts.new')
@section('title','اسباب اجتماع')
@section('content')
    <style>
        svg{
            width: 3% !important;
            direction: none !important;
        }
    </style>
    <div class="container-fluid" style="padding-top: 25px; text-align:center">
        <div class="container justify-content-center" style="text-align: center;">
            <h2 style="text-align: center;">اسباب اجتماع</h2><Br>
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
                <div class="container col-md-3 mt-4 pb-2 pt-1" style="height:100%;">
                    <div style="display: inline-block;width:100%;text-align:center">
                        <a class="btn btn-success" href="{{route('reasons.create')}}">اضافة سبب اجتماع</a>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>سبب الاجتماع</th>
                        <th>الاجراءات</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($reasons as $record)
                        <tr>
                            <td style="width: 30%">{{$record->text}}</td>
                            <td class="row">
                                <a class="btn btn-warning col-2" href="{{route('reasons.edit',$record->id)}}">تعديل</a>
                                <form action="{{route('reasons.destroy',$record->id)}}" method="post" class=" col-3">
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
                        {{$reasons->links()}}
                    </nav>
                </div>
            </div>

        </div>
    </div>

@endsection