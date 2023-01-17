@extends('layouts.new')
@section('title','إضافة سبب اجتماع')
@section('content')
<div class="container-fluid">
    <div class="container col-md-5">
        <h1 class="text-center">إضافة بند</h1>
        @if(session()->has('success'))
            <div class="form-group text-center">
                <label class="alert alert-success">{{ session()->get('success')}}</label>
            </div>
        @endif
    </div>

    <div class="container shadow" style="margin-top: 15px;padding-top:15px;padding-bottom:15px">
        <form method="POST" action="{{route('reasons.store')}}">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <label class="control-label">السبب</label>
                    <input type="text" class="form-control" name="text" required />
                    @error('text')
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
    </div>
</div>
@endsection
@section('js')
    <script>
        var num=1;

        $('#add_rec').on('click',function () {
            var input='<div class="col-md-12 mt-2"><div > ' +
                '<label class="control-label">بند '+ num+' ( غير قابل للتصويت) </label>'+
                '<textarea class="form-control" name="records[rec]['+num+']" type="text"></textarea>'+
                '</div>'+
                '</div>';
            $('#record').append(input);
            num=num+1;
        })
        $('#add_rec_vot').on('click',function () {

            var input2='<div class="col-md-12 mt-2"><div > ' +
                '<label class="control-label"> بند '+ num+' (قابل للتصويت) </label>'+
                '<textarea class="form-control" name="records[vot_rec]['+num+']" type="text"></textarea>'+
                '</div>'+
                '</div>';
            $('#record').append(input2);
            num=num+1;
        })
    </script>
@endsection