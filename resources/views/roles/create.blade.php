@extends('layouts.new')
@section('title','إضافة صلاحيات')
@section('content')
<div class="container-fluid">
    <div class="container col-md-5">
        <h1 class="text-center">إضافة صلاحيات</h1>
    </div>

    <div class="container shadow" style="margin-top: 15px;padding-top:15px;padding-bottom:15px">
        <form method="POST" action="{{route('roles.store')}}">
            @csrf
            @if(session()->has('success'))
                    <div class="form-group text-center">
                        <label class="alert alert-success">{{ session()->get('success')}}</label>
                    </div>
                @endif
            <div class="row">
                <div class="col-md-6">
                    <label class="control-label">الاسم</label>
                    <input type="text" class="form-control" name="name">
                    @error('name')
                        <p style="color: red;">{{$message}}</p>
                    @endif
                </div>
            </div>
            <div class="row">
                <h3 class="col-md-12 p-2 text-center">الصلاحيات</h3>

            @foreach($permissions as $item)
                <div class="col-md-4" style="font-size: large">
                            <input type="checkbox" name="roles[]" value="{{$item->name}}"> {{$item->display_name}}

                </div>
            @endforeach
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary-big">حفظ</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection