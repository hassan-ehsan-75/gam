@extends('layouts.new')
@section('title','إضافة جمعية')
@section('content')
<div class="container-fluid">
    <div class="container col-md-5">
        <h1 class="text-center">إضافة جمعية</h1>
    </div>

    <div class="container shadow" style="margin-top: 15px;padding-top:15px;padding-bottom:15px">
        <form method="POST" action="{{route('gatherings.store')}}">
            @csrf
            @if(session()->has('success'))
                    <div class="form-group text-center">
                        <label class="alert alert-success">{{ session()->get('success')}}</label>
                    </div>
                @endif
            <div class="row">
                <div class="col-md-6">
                    <label class="control-label">تاريخ  انعقاد الجمعية</label>
                    <input type="date" class="form-control" name="g_date">
                    @error('date')
                        <p style="color: red;">{{$message}}</p>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="control-label">ساعة انعقاد الجمعية</label>
                    <input type="time" class="form-control" name="g_time">
                    @error('date')
                        <p style="color: red;">{{$message}}</p>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="control-label">طبيعة الجمعية</label>
                    <select  class="form-control" name="type" id="typee">
                        <option value="1" >عادية</option>
                        <option value="2" >غير عادية</option>
                        <option value="3" >تأسيسية</option>
                    </select>
                    @error('type')
                        <p style="color: red;">{{$message}}</p>
                    @enderror
                </div>

                <div class="col-md-12" id="reason">
                    <label class="control-label">سبب انعقاد الجمعية</label>
                    <select type="text" class="form-control" name="reason">
                        <option value="لايوجد">لايوجد</option>
                        @foreach(\App\Models\Reason::all() as $item)
                            <option value="{{$item->text}}">{{$item->text}}</option>
                            @endforeach
                    </select>
                    @error('reason')
                    <p style="color: red;">{{$message}}</p>
                    @enderror
                </div>

                <div class="col-md-12">
                    <label class="control-label">مكان انعقاد الجمعية</label>
                    <input type="text" class="form-control" name="place">
                    @error('place')
                    <p style="color: red;">{{$message}}</p>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label class="control-label">تفاصيل</label>
                    <textarea type="text" class="form-control" name="description" rows="5"></textarea>
                    @error('description')
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
        $('#reason').hide();
        $('#typee').on('change',function(){
            if(this.value==2){
                $('#reason').show();
            }else{
                $('#reason').hide();
                $('#reason').val('لايوجد')
            }
        });
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