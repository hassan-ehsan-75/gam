@extends('layouts.new')
@section('title','تعديل الاعدادات')
@section('content')

    <div class="container-fluid">
        <div class="container col-md-5">
            <h1 class="text-center">تعديل الاعدادات</h1>
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
            <form method="POST" action="{{route('settings.update',$setting->id)}}">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label class="control-label">نسبة الحد الاعلى للوكلاء</label>
                        <input type="text" class="form-control" name="agency_percentage" value="{{$setting->agency_percentage}}">
                        @error('agency_percentage')
                        <p style="color: red;">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">عدد الاسهم الاجمالي</label>
                        <input type="number" class="form-control" name="stocks_count" value="{{$setting->stocks_count}}">
                        @error('stocks_count')
                        <p style="color: red;">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">تأسيسية (الاضافه اي نسبة النصاب عند التفعيل)</label>
                        <select type="number" class="form-control" name="first_gathering">
                            <option value="0" @if($setting->first_gathering==0) selected @endif > تأسيسية</option>
                            <option value="1" @if($setting->first_gathering==1) selected @endif > غير تأسيسية</option>
                        </select>
                        @error('first_gathering')
                        <p style="color: red;">{{$message}}</p>
                        @enderror
                    </div>

                </div>

                <div class="row mt-2">
                    <div class="col-md-12">
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary-big">حفظ</button>
                        </div>
                    </div>
                </div>
            </form>
            @can('reasons')
            <div class="col-md-12">
                <div class="form-group text-center">
                    <a href="{{route('reasons.index')}}" type="submit" class="btn btn-primary-big">عرض اسباب الجمعيه</a>
                </div>
            </div>
                @endcan
        </div>
    </div>
@endsection
