@extends('layouts.new')
@section('title','إنشاء مستخدم جديد')
@section('content')
<div class="container-fluid">
    <div class="container col-md-5">
        <h1 class="text-center">
            إنشاء مستخدم جديد 
        </h1>
    </div>
    <div class="container col-md-5 shadow" style="margin-top: 15px;padding-top:15px;padding-bottom:15px">
        <form method="POST" action="{{route('users.store')}}">

        @csrf
        @error('error')
            <div class="form-group text-center">
                <div class="alert alert-danger">
                    {{$message}}
                </div>
            </div>
        @endif
        @if(session()->has('success'))
                    <div class="form-group text-center">
                        <label class="alert alert-success">{{ session()->get('success')}}</label>
                    </div>
        @endif
        
            <div class="form-group">
                <label class="control-label">الاسم الكامل</label>
                <input type="text" class="form-control" name="name">
                @error('name')
                 <p style="color: red;">{{ $message }}</p>
                @endif
            </div>
            <div class="form-group">
                <label class="control-label">الايميل</label>
                <input type="email" class="form-control" name="email">
                @error('email')
                 <p style="color: red;">{{ $message }}</p>
                @endif
            </div>
            <div class="form-group">
                <label class="control-label">كلمة المرور</label>
                <input type="password" class="form-control" name="password">
                @error('password')
                 <p style="color: red;">{{ $message }}</p>
                @endif
            </div>
            <div class="form-group">
                <label class="control-label">نوع الحساب</label>
                <select class="form-control" name="role_id">
                    @foreach ($roles as $role)
                        <option value="{{$role->name}}">{{ $role->name }}</option>
                    @endforeach
                </select>
                @error('role_id')
                 <p style="color: red;">{{ $message }}</p>
                @endif
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary">إنشاء الحساب</button>
            </div>
        </form>
    </div>
</div>
@endsection
