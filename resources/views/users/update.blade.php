@extends('layouts.new')
@section('title','تعديل المستخدم')
@section('content')
<div class="container-fluid">
    <div class="container">
        <h1 class="text-center">تعديل المستخدم</h1>
    </div>
    <div class="container shadow" style="margin-top: 15px;padding-top:15px">
        <form method="POST" action="{{route('users.update',$user->id)}}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            @if(session()->has('success'))
                    <div class="form-group text-center">
                        <label class="alert alert-success">{{ session()->get('success')}}</label>
                    </div>
                @endif
            @if(session()->has('error'))
                <div class="form-group text-center mt-1">
                    <label class="alert alert-warning">{{ session()->get('error')}}</label>
                </div>
            @endif
            @if(count($errors)>0)
                <div class="form-group text-center mt-1">
                    <label class="alert alert-warning">{{ $errors->first()}}</label>
                </div>
            @endif

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">صورة البروفايل</label>
                        <input  type="file" class="form-control" name="avatar">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                    <label class="control-label">الاسم الكامل</label>
                    <input required type="text" class="form-control" name="name" value="{{$user->name}}">
                    @error('name')
                        <p style="color: red;">{{$message}}</p>
                    @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                    <label class="control-label">البريد الالكتروني</label>
                    <input required type="text" class="form-control" name="email" value="{{$user->email}}">
                    @error('email')
                        <p style="color: red;">{{$message}}</p>
                    @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">الصلاحيات</label>
                        <select class="form-control" name="role_id" required>
                            @foreach($roles as $role)
                                <option value="{{$role->name}}" @role($role->name) selected @endrole>{{$role->name}}</option>
                            @endforeach
                        </select>
                        @error('role_id')
                            <p style="color: red;">{{$message}}</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-md-6">

                    <div class="form-group">
                        @role('admin')
                        <label class="control-label">كلمة مرور جديدة</label>
                            <input  type="text" class="form-control" name="new_password" >
                        @error('password')
                            <p style="color: red;">{{$message}}</p>
                        @enderror
                        @endrole
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary-big">حفظ التعديلات</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection