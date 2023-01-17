@extends('layouts.new')
@section('title','تحميل جدول المساهمين')
@section('content')
<div class="container-fluid">
    <div class="container col-md-5">
        <h1 class="text-center">تحميل جدول المساهمين</h1>
    </div>

    <div class="container shadow" style="margin-top: 15px;padding-top:15px;padding-bottom:15px">
        <form method="POST" action="{{route('import.store')}}" enctype="multipart/form-data">
            @csrf
            @if(session()->has('success'))
                    <div class="form-group text-center">
                        <label class="alert alert-success">{{ session()->get('success')}}</label>
                    </div>
                @endif
            <div class="row">
                <div class="col-md-6">
                    <label class="control-label">الملف</label>
                    <input type="file" class="form-control" name="file">
                    @error('name')
                        <p style="color: red;">{{$message}}</p>
                    @endif
                </div>
                <div class="col-md-6">
                    <div class="form-group">

                        <label class="control-label" for="name">الجمعية</label>
                        <select required class="form-control" name="gathering" >
                            @foreach($gatherings as $gath)
                                <option value="{{$gath->id}}">{{$gath->g_number.'-'.\App\Models\Gathering::$g_type[$gath->type].'-'.$gath->g_date}}</option>
                                @endforeach
                        </select>

                        @error('gathering')
                        <p style="color: red;">{{$message}}</p>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12 mt-4">
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary-big">استيراد</button>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection