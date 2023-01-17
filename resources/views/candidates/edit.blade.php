@extends('layouts.new')
@section('title','تعديل مرشح')
@section('content')
    <div class="container-fluid">
        <div class="container col-md-5">
            <h1 class="text-center">تعديل مرشح</h1>
            @if(session()->has('success'))
                <div class="form-group text-center">
                    <label class="alert alert-success">{{ session()->get('success')}}</label>
                </div>
            @endif
        </div>

        <div class="container shadow" style="margin-top: 15px;padding-top:15px;padding-bottom:15px">
            <form method="POST" action="{{route('candidates.update',$candidate->id)}}">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <label class="control-label">الاسم الكامل</label>
                        <input type="text" class="form-control" name="name" value="{{$candidate->name}}">
                        @error('name')
                        <p style="color: red;">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="control-label">المنصب</label>
                        <select type="text" class="form-control" name="postion">
                            <option @if($candidate->postion=='مجلس ادارة') selected @endif value="مجلس ادارة">مجلس ادارة</option>
                            <option @if($candidate->postion=='هيئة شرعية') selected @endif value="هيئة شرعية">هيئة شرعية</option>
                            <option @if($candidate->postion=='مدقق حسابات') selected @endif value="مدقق حسابات">مدقق حسابات</option>
                        </select>
                        @error('postion')
                        <p style="color: red;">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">

                            <label class="control-label" for="name">الجمعية</label>
                            <select required class="form-control" name="gathering_id" >
                                @foreach($gatherings as $gath)
                                    <option value="{{$gath->id}}" @if($candidate->gathering_id==$gath->id) selected @endif>{{$gath->g_number.'-'.\App\Models\Gathering::$g_type[$gath->type].'-'.$gath->g_date}}</option>
                                @endforeach
                            </select>

                            @error('gathering_id')
                            <p style="color: red;">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">

                            <label class="control-label" for="name">قابلية التصويت</label>
                            <select required class="form-control" name="type" >
                                    <option value="0" @if($candidate->type==0) selected @endif>غير قابل للتصويت</option>
                                    <option value="1" @if($candidate->type==1) selected @endif> قابل للتصويت</option>
                            </select>

                            @error('type')
                            <p style="color: red;">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6" style="    padding-top: 3.5%;">
                        <div class="form-group row">
                            <div class="form-group col-6">
                                <label class="control-label col-6 " for="name" style="max-width: 45%">شخص</label>
                                <input value="1" id="per1" type="radio" required class=" col-6" name="person" style="max-width: 45%;display: inline"
                                @if(in_array($candidate->person_type,['مساهم','مستقل']))
                                checked
                                @endif
                                />
                            </div>
                            <div class="form-group col-6">
                                <label class="control-label col-6" for="name" style="max-width: 45%">شركة</label>
                                <input id="per2" value="2" type="radio" required class=" col-6" name="person" style="max-width: 45%;display: inline"
                                       @if(!in_array($candidate->person_type,['مساهم','مستقل']))
                                       checked
                                        @endif
                                />
                            </div>

                            @error('person')
                            <p style="color: red;">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6" id="person1">
                        <div class="form-group ">
                            <label class="control-label  " for="name">النوع</label>
                            <select class="form-control " name="person_type_per" id="per_type">
                                <option @if($candidate->person_type=='مساهم') selected @endif value="مساهم">مساهم</option>
                                <option @if($candidate->person_type=='مستقل') selected @endif value="مستقل">مستقل</option>
                            </select>
                            @error('person')
                            <p style="color: red;">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6" id="person2">
                        <div class="form-group ">
                            <label class="control-label  " for="name" >اعتباري عن شركة</label>
                            <input id="per_type_inp" type="text" class="form-control " name="person_type_com" value="@if(!in_array($candidate->person_type,['مساهم','مستقل'])) {{$candidate->person_type}} @endif">
                            @error('person')
                            <p style="color: red;">{{$message}}</p>
                            @enderror
                        </div>
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
            @if(!in_array($candidate->person_type,['مساهم','مستقل']))
$('#person1').hide();
@else
        $('#person2').hide();
        @endif
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
        $('#per1').on('change',function () {
            console.log(this.checked)
            if (this.checked){
                $('#person1').show();
                $('#person2').hide();
                $('#per_type').val('مساهم');
                console.log($('#per_type').val());
            }
        });
        $('#per2').on('change',function () {
            console.log(this.checked)
            if (this.checked){
                $('#person1').hide();
                $('#person2').show();
                $('#per_type').val('');
            }
        })
    </script>
@endsection