@extends('layouts.new')
@section('title','المستخدمين')
@section('content')
    <style>
        svg{
            width: 10%;
        }
    </style>
    <div class="container-fluid" style="padding-top: 25px; text-align:center">
        <div class="container justify-content-center" style="text-align: center;">
            <h2 style="text-align: center;">المستخدمين</h2><Br>
            <div class="row justify-content-center">
                @can('users.create')
                    <div class="col-md-2">
                        <a type="button" href="{{url('users/create')}}" class="btn btn-default-big"><i
                                    class="fa fa-plus-circle"></i> إضافة جديد</a>
                    </div>
                @endcan
            </div>
        </div>
        <div class="container shadow p-3" style="margin-top: 15px;">
            <div class="container col-md-5">
                <div style="display: inline-block;width:100%;text-align:center">

                    <label>بحث</label>
                    <form style="display: inline-block;" method="GET" action="{{url('/users')}}">
                        <input type="text" class="option-control" name="search" value="{{request('search')}}">
                        <button type="submit" class="btn btn-secondary option-control mb-1">ابحث</button>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>الاسم</th>
                        <th>البريد الالكتروني</th>
                        <th>تاريخ الانشاء</th>
                        <th>الدور</th>
                        <th>الاجراءات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->created_at}}</td>
                            <td>
                                @foreach($user->roles as $role)
                                {{$role->name}}|
                                    @endforeach
                            </td>

                            <td>
                                <div class="dropdown">
                                    <a type="button" class="dropdown-toggle" data-toggle="dropdown">
                                        الإجراءات
                                    </a>
                                    <div class="dropdown-menu" style="text-align: right;">
                                        @can('users.show')
                                            <a class="dropdown-item" href="{{url('/users',$user->id)}}"
                                               class="btn btn-default" style="margin:5px"><i class="fa fa-eye"></i>
                                                معاينة</a>
                                        @endcan
                                            @can('users.update')
                                            <a class="dropdown-item" href="{{route('users.edit',$user->id)}}"
                                               class="btn btn-primary" style="margin:5px"><i class="fa fa-edit"></i>
                                                تعديل</a>
                                        @endcan
                                            @can('users.destroy')
                                            <form action="{{route('users.destroy',$user->id)}}" method="post">
                                                @csrf
                                                {{method_field('DELETE')}}
                                                <BUTTON type="submit" class="dropdown-item" style="margin:5px"><i
                                                            class="fa fa-trash"></i> حذف
                                                </BUTTON>
                                            </form>
                                        @endcan
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="container col-md-4" style="padding-bottom: 25px;">
                <nav>
                    {{$users->links()}}
                </nav>
            </div>
        </div>
    </div>
@endsection