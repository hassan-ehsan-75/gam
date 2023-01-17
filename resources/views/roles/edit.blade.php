@extends('layouts.new')
@section('title','تعديل الصلاحيات')
@section('content')

    <div class="container-fluid">
        <div class="container col-md-5">
            <h1 class="text-center">تعديل الصلاحيات</h1>
        </div>
        @if(session()->has('success'))
            <div class="form-group text-center">
                <label class="alert alert-success">{{ session()->get('success')}}</label>
            </div>
        @endif

        @if(count($errors)>0)
            <div class="form-group text-center">
                <label class="alert alert-danger">{{ $errors->first()}}</label>
            </div>
        @endif
        <div class="container shadow" style="margin-top: 15px;padding-top:15px;padding-bottom:15px">
            <form method="POST" action="{{route('roles.update',$role->id)}}">
                @method('PUT')
                @csrf
                <div class="row">
                    @foreach($permissions as $item)
                        <div class="col-md-4" style="font-size: large">

                                    <input  type="checkbox" name="roles[]"
                                           @if($role->hasPermissionTo($item->name)) checked="checked" @endif
                                            value="{{$item->name}}"> {{$item->display_name}}

                        </div>
                    @endforeach
                </div>
                <br>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary-big">حفظ</button>
                </div>
            </form>
        </div>
    </div>
@endsection