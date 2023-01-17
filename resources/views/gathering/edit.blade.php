@extends('layouts.new')
@section('title','تعديل الجمعية')
@section('content')

    <div class="container-fluid">
        <div class="container col-md-5">
            <h1 class="text-center">تعديل الجمعية</h1>
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
            <form method="POST" action="{{route('gatherings.update',$gathering->id)}}">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label class="control-label">تاريخ  انعقاد الجمعية</label>
                        <input type="date" class="form-control" name="g_date" value="{{$gathering->g_date}}">
                        @error('date')
                        <p style="color: red;">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">ساعة انعقاد الجمعية</label>
                        <input type="time" class="form-control" name="g_time" value="{{$gathering->g_time}}">
                        @error('date')
                        <p style="color: red;">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">طبيعة الجمعية</label>
                        <select id="type" class="form-control" name="type">
                            <option value="1" @if($gathering->type==1) selected @endif >عادية</option>
                            <option value="2"  @if($gathering->type==2) selected @endif>غير عادية</option>
                            <option value="3" @if($gathering->type==3) selected @endif >تأسيسية</option>
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
                                <option value="{{$item->text}}" @if($gathering->reason==$item->text) selected @endif>{{$item->text}}</option>
                            @endforeach
                        </select>
                        @error('reason')
                        <p style="color: red;">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label class="control-label">مكان انعقاد الجمعية</label>
                        <input type="text" class="form-control" name="place" value="{{$gathering->place}}">
                        @error('place')
                        <p style="color: red;">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label class="control-label">تفاصيل</label>
                        <textarea type="text" class="form-control" name="description" rows="5">{{$gathering->description}}</textarea>
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
        $('#reason').hide();
        $('#type').on('change',function(){
            if(this.value==2){
                $('#reason').show();
            }else{
                $('#reason').hide();
                $('#type').val('لايوجد')
            }
        })
        var num={{count($gathering->records)}}+1;
        $('#type').val('{{$gathering->type}}');
        if($('#type').val()==2){

                $('#reason').show();

        }else {

            $('#reason').hide();
            $('#reason').val('لايوجد')

        }
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
                '</div> '+
                '</div>';
            $('#record').append(input2);
            num=num+1;

        })
        $('#rec_delete').on('click',function () {
            $('#record').html('');
            num=1;

        })
    </script>
@endsection