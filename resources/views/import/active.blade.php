@extends('layouts.new')
@section('title','تفعيل لاكثر من مساهم')
@section('content')
    <link href="{{asset('select2.min.css')}}" rel="stylesheet" />
    <script src="{{asset('select2.min.js')}}"></script>
    <style>
        svg{
            width: 3% !important;
            direction: none !important;
        }
    </style>
    @php
        $stocks=App\Models\Stock::select('id','full_name','last_name','p_number','stock_number')
        ->where('enter','!=',1)->get();
    @endphp
    <div class="container-fluid" style="padding-top: 25px; text-align:center">
        <div class="container justify-content-center" style="text-align: center;">
            <h2 style="text-align: center;">تفعيل لاكثر من مساهم</h2><Br>
        </div>
        @if(session()->has('error'))
            <div class="form-group text-center mt-1">
                <label class="alert alert-warning">{{ session()->get('error')}}</label>
            </div>
        @endif
        @if(session()->has('success'))
            <div class="form-group text-center mt-1">
                <label class="alert alert-success">{{ session()->get('success')}}</label>
            </div>
        @endif
        <div class="container shadow p-3" style="margin-top: 15px;max-width: 1400px">
            <div class="row">
                <div class="text-center p-3" >
                    @if($type==1)
                        <form action="{{route('agent.store',1)}}" method="post" enctype="multipart/form-data" class=" row" id="from-active2">
                            @csrf
                            <h2 class="col-md-12  mb-2">  التفعيل بالوكالة(وكيل مساهم)</h2>
                            <div class="col-md-4 ">
                                <div class="form-group">

                                    <label class="control-label" for="name">ملف</label>
                                    <input id="file1"  type="file" class="form-control" name="file" >

                                    @error('file')
                                    <p style="color: red;">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 ">
                                <div class="form-group">

                                    <label class="control-label" for="name">الرقم الوطني او الاسم للمفوض المساهم</label>
                                    <select id="agent1" class="form-control select22 select2" name="p_number" multiple required>
                                        @foreach($stocks as $stock)
                                            <option value="{{$stock->p_number}}">{{$stock->full_name.'-('.$stock->stock_number.')'.'-('.$stock->p_number.')'}}</option>
                                        @endforeach
                                    </select>

                                    @error('p_number')
                                    <p style="color: red;">{{$message}}</p>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-md-12 ">
                                <div class="form-group">

                                    <label class="control-label" for="name">الارقام الوطنية او الاسم الثلاثي للمساهمين</label>
                                    <select id="agent2" class="form-control select2" name="agents[]" multiple required>
                                        @foreach($stocks as $stock)
                                            <option id="{{$stock->p_number}}" value="{{$stock->p_number}}">{{$stock->full_name.'-('.$stock->stock_number.')'.'-('.$stock->p_number.')'}}</option>
                                        @endforeach
                                    </select>
                                    @error('agent')
                                    <p style="color: red;">{{$message}}</p>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-md-4 mt-4 pt-1">
                                <button type="submit" class="btn btn-success " name="print"  value="2" hidden>تثبيت بالوكالة(وكيل مساهم)</button>
                            </div>
                            <div class="col-md-4 mt-4 pt-1">
                                <button type="submit" class="btn btn-success " name="print" value="1">تثبيت بالوكالة(وكيل مساهم)وطباعة بطاقة الحضور</button>
                            </div>
                        </form>
                    @else
                        <form action="{{route('agent.store',2)}}" method="post" enctype="multipart/form-data" class=" row" id="form-active3">
                            @csrf
                            <h2 class="col-md-12  mt-2"> التفعيل بالوكالة(وكيل غير مساهم)</h2>
                            <div class="row p-3">
                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label class="control-label" for="name">الاسم والكنية</label>
                                        <input  id="name1" required type="text" class="form-control" name="full_name"
                                                {{--placeholder="الاسم والكنية"--}}
                                        >
                                        @error('full_name')
                                        <p style="color: red;">{{$message}}</p>
                                        @endif

                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label class="control-label" for="name">اسم الاب</label>
                                        <input  required type="text" class="form-control" name="father"
                                        >
                                        @error('father')
                                        <p style="color: red;">{{$message}}</p>
                                        @endif

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label class="control-label" for="name">اسم الام</label>
                                        <input   type="text" class="form-control" name="mother"
                                        >
                                        @error('mother')
                                        <p style="color: red;">{{$message}}</p>
                                        @endif

                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label class="control-label" for="name">الجنسية</label>
                                        <input   type="text" class="form-control" name="nation"
                                        >

                                        @error('nation')
                                        <p style="color: red;">{{$message}}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="name">تاريخ  الولادة</label>
                                        <input   type="date" class="form-control" name="birthday"
                                        >

                                        @error('birthday')
                                        <p style="color: red;">{{$message}}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label class="control-label" for="name">الجنس</label>
                                        <select   class="form-control" name="gender" >
                                            <option value="ذكر">ذكر</option>
                                            <option value="انثى">انثى</option>
                                        </select>

                                        @error('gender')
                                        <p style="color: red;">{{$message}}</p>
                                        @endif
                                    </div>
                                </div>




                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label class="control-label" for="name">هاتف</label>
                                        <input   style="direction: ltr" type="number" class="form-control" name="phone"
                                        >

                                        @error('phone')
                                        <p style="color: red;">{{$message}}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label class="control-label" for="name">موبايل</label>
                                        <input  style="direction: ltr"  type="number" class="form-control" name="mobile"
                                        >

                                        @error('mobile')
                                        <p style="color: red;">{{$message}}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4 ">
                                    <div class="form-group">

                                        <label class="control-label" for="name">الرقم الوطني</label>
                                        <input  type="number" class="form-control" name="p_number"
                                                {{--placeholder="0231244324"--}}
                                                minlength="11" maxlength="11" >

                                        @error('p_number')
                                        <p style="color: red;">{{$message}}</p>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-md-4 ">
                                    <div class="form-group">

                                        <label class="control-label" for="name">ملف</label>
                                        <input  type="file" class="form-control" name="file" >

                                        @error('file')
                                        <p style="color: red;">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12 ">
                                    <div class="form-group">

                                        <label class="control-label" for="name">الارقام الوطنية او الاسم الثلاثي للمساهمين</label>
                                        <select id="agent3" class="form-control select2" name="agents[]" multiple required >
                                            @foreach($stocks as $stock)
                                                <option value="{{$stock->p_number}}">{{$stock->full_name.'-('.$stock->stock_number.')'.'-('.$stock->p_number.')'}}</option>
                                            @endforeach
                                        </select>

                                        @error('agent')
                                        <p style="color: red;">{{$message}}</p>
                                        @enderror
                                    </div>

                                </div>

                            </div>


                            <div class="col-md-6 mt-4 pt-1 mb-3" hidden>
                                <button type="submit" class="btn btn-success text-center" name="print" value="2">تثبيت بالوكالة(وكيل غير مساهم)</button>

                            </div>
                            <div class="col-md-6 mt-4 pt-1 mb-3">
                                <button type="submit" class="btn btn-success text-center" name="print" value="1">تثبيت بالوكالة(وكيل غير مساهم)وطباعة بطاقة  الحضور</button>

                            </div>
                        </form>

                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>

        $(document).ready(function () {
            $('.select2').select2();
            $('.select22').select2({
                maximumSelectionLength: 1
            });
        });
        @if($type==1)
        $('#file1').focus();
        @else
        $('#name1').focus();
        @endif
        @if(session()->has('print'))
            window.open("{{session()->get('print')}}", '_blank').focus();
        @endif
        var old=0;
        $('#agent1').on('change',function () {
            console.log(this.value);
            if(this.value!=''){
            $("#"+this.value).attr("disabled","disabled");
            if(old!=0){
                $("#"+old).attr("disabled","false");
            }
            old=this.value;
//            $('.select2').select2();
            }else{
                if(old!=0&&old!=''){
                    console.log(old);
                    $("#"+old).removeAttr("disabled");
                    old=this.value;
//                    $('.select2').select2();
                }

            }
        })
    </script>
@endsection