@extends('layouts.new')
@section('title','معاينة المستخدم')
@section('content')
<div class="contaienr-fluid">
    <div class="container col-md-4">
        <h1 class="text-center">معاينة المستخدم</h1>
        @if(session()->has('success'))
            <div class="form-group text-center">
                <label class="alert alert-success">{{ session()->get('success')}}</label>
            </div>
        @endif
    </div>

    <div class="container col-md-5 shadow" style="margin-top: 15px;padding-top:15px;padding-bottom:15px">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <img src="{{url($user->avatar)}}" class="img-thumbnail profile-img" style="width:100%;height:auto"/>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12 text-center">
            <h3 class="text-center">{{$user->name}}</h3>
            </div>
        </div>
        <hr>
        <div class="container">
            <p><i class="fa fa-envelope"></i> {{$user->email}}</p>
            <p><i class="fa fa-bank"></i>
            @if($user->bank_id != null)
                {{$user->bank->ar_name}}
            @else
                لايوجد
            @endif
            </p>
            <p><i class="fa fa-bank"></i>
            @if($user->branch_id != null)
                {{$user->branch->name}}
            @else
                لايوجد
            @endif
            </p>
            <p><i class="fa fa-user"></i>
                {{$user->role->display_name}}
            </p>
            @if(auth()->user()->pass_updated==0)
                <h3 class="text-center">تغيير كلمة المرور</h3>



                @if(session()->has('error'))
                    <div class="form-group text-center">
                        <label class="alert alert-danger">{{ session()->get('error')}}</label>
                    </div>
                @endif

        </div>
        <form method="POST" action="{{url('/user/chang_pass')}}">
            @csrf
            @error('error')
            <div class="alert alert-danger">
                <strong>{{ $message}}</strong>
            </div>
            @endif
            <div class="form-group">
                <label class="control-label">كلمة المرور القديمة</label>
                <input type="password" required name="password" class="form-control" style="border-radius: 35px;">
                @error('password')
                <p style="color: red;">{{ $message }}</p>
                @endif
            </div>
            <div class="form-group">
                <label class="control-label" for="password"> كلمة المرورالجديدة</label>
                <input type="password" id="password" required class="form-control" name="new_password" style="border-radius: 35px;">
                @error('new_password')
                <p style="color: red;">{{ $message }}</p>
                @endif
            </div><div class="form-group text-center">
                <button type="submit" class="btn btn-primary-big">
                    تحديث
                </button>
            </div>
        </form>
        @endif
        </div>
    </div>
</div>
@endsection