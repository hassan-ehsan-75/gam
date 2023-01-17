@extends('layouts.new')
@section('title','إضافة جمعية')
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
        <form method="POST" action="{{route('records.store')}}">
            @csrf

            <div class="row">
                <div class="col-md-12">
                    <label class="control-label">عنوان البند</label>
                    <input type="text" class="form-control" name="text" required />
                    @error('text')
                        <p style="color: red;">{{$message}}</p>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label class="control-label">وصف البند</label>
                    <textarea type="text" class="form-control" name="description" required></textarea>
                    @error('description')
                        <p style="color: red;">{{$message}}</p>
                    @enderror
                </div>

                <div class="col-md-6">
                    <div class="form-group">

                        <label class="control-label" for="name">الجمعية</label>
                        <select required class="form-control" name="gathering_id" >
                            @foreach($gatherings as $gath)
                                <option value="{{$gath->id}}">{{$gath->g_number.'-'.\App\Models\Gathering::$g_type[$gath->type].'-'.$gath->g_date}}</option>
                            @endforeach
                        </select>

                        @error('gathering_id')
                        <p style="color: red;">{{$message}}</p>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">

                        <label class="control-label" for="name">الرقم التسلسلي</label>
                        <input class="form-control"  value="{{$sort}}" disabled />
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="control-label">نوع البند</label>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="radio" id="html" name="type" value="1"  >
                            <label for="html">غير قابل للتصويت</label><br>
                        </div>
                        <div class="col-md-6">
                            <input type="radio" id="css" name="type" value="2" >
                            <label for="css">قابل للتصويت</label><br>
                        </div>
                        <div class="col-md-6">
                            <input type="radio" id="css" name="type" value="3" >
                            <label for="css">مرشحين</label><br>
                        </div>
                    </div>
                    @error('type')
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