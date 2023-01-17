@extends('layouts.new')
@section('title','تعديل مساهم')
@section('css')

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

    <!-- (Optional) Latest compiled and minified JavaScript translation files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>

    <!-- (Optional) Latest compiled and minified JavaScript translation files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode@2.0.9/dist/html5-qrcode.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
        .req{
            color: red;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="container">
            <h1 class="text-center">
                {{--<?php if($stock->type == 1):?>--}}
                {{--تعديل جديد طبيعي--}}
                {{--<?php elseif($stock->type == 2):?>--}}
                {{--تعديل جديد إعتباري--}}
                {{--<?php endif;?>--}}
                معلومات المساهم
            </h1>
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
        @if(session()->has('error'))
            <div class="form-group text-center">
                <label class="alert alert-danger">{{ session()->get('error')}}</label>
            </div>
        @endif
        <div class="container">
            <form method="POST" action="{{url('/stocks/update',$stock->id)}}" enctype="multipart/form-data">
                @csrf


                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">

                            <label class="control-label" for="name">الاسم الكامل</label>
                            <input disabled required="" type="text" class="form-control" name="full_name"
                                   value="{{$stock->full_name}}">
                            @error('full_name')
                            <p style="color: red;">{{$message}}</p>
                            @endif

                        </div>
                    </div>

                        <div class="col-md-4">
                            <div class="form-group">

                                <label class="control-label" for="name">اسم الاب</label>
                                <input disabled required type="text" class="form-control" name="father"
                                       value="{{$stock->father}}">
                                @error('father')
                                <p style="color: red;">{{$message}}</p>
                                @endif

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">

                                <label class="control-label" for="name">اسم الام</label>
                                <input disabled required type="text" class="form-control" name="mother"
                                       value="{{$stock->mother}}">
                                @error('mother')
                                <p style="color: red;">{{$message}}</p>
                                @endif

                            </div>
                        </div>



                        {{--<div class="col-md-4">--}}
                            {{--<div class="form-group">--}}

                                {{--<label class="control-label" for="name">اسم العائلة</label>--}}
                                {{--<input disabled required type="text" class="form-control" name="last_name"--}}
                                       {{--value="{{$stock->last_name}}">--}}

                                {{--@error('last_name')--}}
                                {{--<p style="color: red;">{{$message}}</p>--}}
                                {{--@endif--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <div class="col-md-4">
                            <div class="form-group">

                                <label class="control-label" for="name">الجنسية</label>
                                <input disabled required type="text" class="form-control" name="nation"
                                       value="{{$stock->nation}}">

                                @error('nation')
                                <p style="color: red;">{{$message}}</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="name">تاريخ  الولادة</label>
                                <input disabled required type="text" class="form-control" name="birthday"
                                     value="{{$stock->birthday}}">

                                @error('birthday')
                                <p style="color: red;">{{$message}}</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">

                                <label class="control-label" for="name">الجنس</label>
                                <select disabled required class="form-control" name="gender" value="{{$stock->gender}}">
                                    <option value="ذكر">ذكر</option>
                                    <option value="انثى">انثى</option>
                                </select>

                                @error('gender')
                                <p style="color: red;">{{$message}}</p>
                                @endif
                            </div>
                        </div>


                    
                        <div class="col-md-12">
                            <h5>بطاقة التعريف</h5>
                            
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="control-label">نوع الوثيقة</label>
                                        <select disabled name="id_type" class="form-control" id="id_type">
                                            <option value="بطاقة شخصية">بطاقة شخصية</option>
                                            <option value="جواز سفر">جواز سفر</option>
                                            <option  value="اخرى">اخرى</option>
                                        </select>
                                        @error('id_other')
                                        <p style="color: red;">{{$message}}</p>
                                        @endif
                                    </div>
                                    <div class="col-md-4" id="other">
                                        <label class="control-label">نوع الوثيقة(اخرى)</label>
                                        <input disabled  type="text" class="form-control" name="id_other" value="{{$stock->id_other}}"
                                             >
                                        @error('id_type')
                                        <p style="color: red;">{{$message}}</p>
                                        @endif
                                    </div>

                                </div>

                        </div>
                    
                        <div class="col-md-4">
                            <div class="form-group">

                                <label class="control-label" for="name">تاريخ منح (الهويه|جواز السفر)</label>
                                <input disabled required type="date" class="form-control" name="id_date"
                                       {{--placeholder="تاريخ منح (الهويه|جواز السفر)" --}}
                                       value="{{$stock->id_date}}">
                                @error('id_date')
                                <p style="color: red;">{{$message}}</p>
                                @endif
                            </div>
                        </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">الرقم الوطني</label>
                                    <input disabled required type="text" class="form-control" name="p_number"
                                           {{--placeholder="الرقم "--}}
                                           value="{{$stock->p_number}}">

                                    @error('p_number')
                                    <p style="color: red;">{{$message}}</p>
                                    @endif
                                </div>
                            </div>

                        {{--<div class="col-md-4">--}}
                            {{--<div class="form-group  col-md-12 ">--}}

                                {{--<label class="control-label" for="name">جهه الاصدار (الهويه|جواز السفر)</label>--}}
                                {{--<input disabled required type="text" class="form-control" name="id_from"--}}
                                       {{--placeholder="جهه الاصدار (الهويه|جواز السفر)" value="{{$stock->id_from}}">--}}
                                {{--@error('id_from')--}}
                                {{--<p style="color: red;">{{$message}}</p>--}}
                                {{--@endif--}}

                            {{--</div>--}}
                        {{--</div>--}}

                    
                    <div class="col-md-4">
                        <div class="form-group">

                            <label class="control-label" for="name">هاتف</label>
                            <input disabled  style="direction: ltr" type="text" class="form-control" name="phone"
                                   value="{{$stock->phone}}">

                            @error('phone')
                            <p style="color: red;">{{$message}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">

                            <label class="control-label" for="name">موبايل</label>
                            <input disabled style="direction: ltr" required type="text" class="form-control" name="mobile"
                                   value="{{$stock->mobile}}">

                            @error('mobile')
                            <p style="color: red;">{{$message}}</p>
                            @endif
                        </div>
                    </div>

                </div>


                <div class="row">

                    

                    <div class="col-md-4">
                        <div class="form-group">

                            <label class="control-label" for="name">المدينة</label>
                            <input disabled required type="text" class="form-control" name="city"
                                   value="{{$stock->city}}">
                            @error('city')
                            <p style="color: red;">{{$message}}</p>
                            @endif

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">

                            <label class="control-label" for="name">عنوان</label>
                            <input disabled required type="text" class="form-control" name="address"
                                   value="{{$stock->address}}">
                            @error('address')
                            <p style="color: red;">{{$message}}</p>
                            @endif

                        </div>
                    </div>
                </div>

               
                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">

                            <label class="control-label" for="name">عدد الاسهم المملوكة</label>
                            <input disabled required type="number" class="form-control" name="stock_number" step="any" id="stock_number"
                                 value="{{$stock->stock_number}}">

                            {{--@error('stock_number')--}}
                            {{--<p style="color: red;">{{$message}}</p>--}}
                            {{--@endif--}}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">

                            <label class="control-label" for="name">القيمه الماليه</label>
                            <input disabled required  type="number" class="form-control disabledd" name="total" id="total"
                                  value="{{$stock->total}}">
                            @error('total')
                            <p style="color: red;">{{$message}}</p>
                            @endif

                        </div>
                    </div>
                   
                </div>
            </form>
                <div class="text-center">
                @can('stocks.present')
                    <h3 class="">التفعيل</h3>
                        <form action="{{route('stock.present-status',[$stock->id,1])}}" method="post" enctype="multipart/form-data" class=" row">
                            @csrf
                    @if($stock->present==0)
                                <div class="col-md-6 ">
                                    <div class="form-group">

                                        <label class="control-label" for="name">ملف</label>
                                        <input  type="file" class="form-control" name="file" >

                                        @error('file')
                                        <p style="color: red;">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-4 pt-1">
                        <button type="submit" class="btn btn-success text-center" value="1">تثبيت بالاصالة</button>

                                </div>
                        </form>
                        <form action="{{route('stock.present-status',[$stock->id,2])}}" method="post" enctype="multipart/form-data" class=" row">
                            @csrf
                            <h2 class="col-md-12  mb-2"> او التفعيل بالوكالة(وكيل مساهم)</h2>
                            <div class="col-md-4 ">
                                <div class="form-group">

                                    <label class="control-label" for="name">ملف</label>
                                    <input  type="file" class="form-control" name="file" >

                                    @error('file')
                                    <p style="color: red;">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                                <div class="col-md-4 ">
                                    <div class="form-group">

                                        <label class="control-label" for="agent1">الرقم الوطني او الاسم للوكيل المساهم</label>
                                        <select id="agent1" class="form-control select2" name="agent" multiple>
                                            @foreach(\App\Models\Stock::select('id','full_name','last_name','p_number','stock_number')->where('enter','!=',1)->get() as $stock)
                                                <option value="{{$stock->p_number}}">{{$stock->full_name.'-('.$stock->stock_number.')'.'-('.$stock->p_number.')'}}</option>
                                            @endforeach
                                        </select>

                                        @error('agent')
                                        <p style="color: red;">{{$message}}</p>
                                        @enderror
                                    </div>

                                </div>
                            <div class="col-md-4 mt-4 pt-1">
                            <button type="submit" class="btn btn-success "  value="2">تثبيت بالوكالة(وكيل مساهم)</button>
                </div>
                        </form>
                    @csrf
                        <form action="{{route('stock.present-status',[$stock->id,3])}}" method="post" enctype="multipart/form-data" class=" row">
                            @csrf

                            <input hidden name="gathering_id" value="{{$stock->gathering_id}}">
                            <h2 class="col-md-12  mt-2"> او التفعيل بالوكالة(وكيل غير مساهم)</h2>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label class="control-label" for="name">الاسم والكنية</label>
                                        <input  required="" type="text" class="form-control" name="full_name"
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
                                        <input  required type="date" class="form-control" name="birthday"
                                               >

                                        @error('birthday')
                                        <p style="color: red;">{{$message}}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label class="control-label" for="name">الجنس</label>
                                        <select   class="form-control" name="gender" value="{{$stock->gender}}" >
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
                                        <input   style="direction: ltr" type="number" class="form-control" name="phone" >

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
                                        <input id="agent1" class="form-control " name="p_number"  />

                                        @error('p_number')
                                        <p style="color: red;">{{$message}}</p>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-md-4 ">
                                    <div class="form-group">

                                        <label class="control-label" for="name">ملف</label>
                                        <input  type="file" class="form-control" name="file">

                                        @error('file')
                                        <p style="color: red;">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>

                            </div>


                            <div class="col-md-6 mt-4 pt-1 mb-3">
                            <button type="submit" class="btn btn-success text-center" value="2">تثبيت بالوكالة(وكيل غير مساهم)</button>

                        </div>
                        </form>
                    @else
                    @if($stock->stock_file!=null)
                                @if(strpos($stock->stock_file, '.pdf') !== false)
                                    <a  href="{{asset('storage/'.$stock->stock_file)}}" target="_blank"> معاينة</a>
                                    @else
                                    <img  src="{{asset('storage/'.$stock->stock_file)}}" style="width: 100%;margin-bottom: 10px"/>
                                    @endif
                        @endif
                    @if($stock->agency1||$stock->agency2)
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">

                                                <label class="control-label" for="name">الاسم الكامل</label>
                                                <input disabled required="" type="text" class="form-control" name="full_name"
                                                value="{{$stock2->full_name}}">

                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">

                                                <label class="control-label" for="name">اسم الاب</label>
                                                <input disabled required type="text" class="form-control" name="father"
                                                        value="{{$stock2->father}}">
                                                @error('father')
                                                <p style="color: red;">{{$message}}</p>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">

                                                <label class="control-label" for="name">اسم الام</label>
                                                <input disabled required type="text" class="form-control" name="mother"
                                                        value="{{$stock2->mother}}">
                                                @error('mother')
                                                <p style="color: red;">{{$message}}</p>
                                                @endif

                                            </div>
                                        </div>


                                        <div class="col-md-4">
                                            <div class="form-group">

                                                <label class="control-label" for="name">الجنسية</label>
                                                <input disabled required type="text" class="form-control" name="nation"
                                                        value="{{$stock2->nation}}">

                                                @error('nation')
                                                <p style="color: red;">{{$message}}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label" for="name">تاريخ  الولادة</label>
                                                <input disabled required type="text" class="form-control" name="birthday"
                                                        value="{{$stock2->birthday}}">

                                                @error('birthday')
                                                <p style="color: red;">{{$message}}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">

                                                <label class="control-label" for="name">الجنس</label>
                                                <select disabled   required class="form-control" name="gender" >
                                                    <option @if($stock2->gender=='ذكر') selected @endif value="ذكر">ذكر</option>
                                                    <option @if($stock2->gender=='انثى') selected @endif value="انثى">انثى</option>
                                                </select>

                                                @error('gender')
                                                <p style="color: red;">{{$message}}</p>
                                                @endif
                                            </div>
                                        </div>




                                        <div class="col-md-4">
                                            <div class="form-group">

                                                <label class="control-label" for="name">هاتف</label>
                                                <input disabled  style="direction: ltr" type="text" class="form-control" name="phone"
                                                         value="{{$stock2->phone}}">

                                                @error('phone')
                                                <p style="color: red;">{{$message}}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">

                                                <label class="control-label" for="name">موبايل</label>
                                                <input disabled style="direction: ltr" required type="text" class="form-control" name="mobile"
                                                        value="{{$stock2->mobile}}">

                                                @error('mobile')
                                                <p style="color: red;">{{$message}}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4 ">
                                            <div class="form-group">

                                                <label class="control-label" for="name">ملف</label>
                                                <input disabled type="file" class="form-control" name="file">

                                                @error('file')
                                                <p style="color: red;">{{$message}}</p>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
@endif
                                    <form action="{{route('stock.present-status',[$stock->id,1])}}" method="post">
                                        @csrf


                        <button  type="submit" class="btn btn-warning text-center" href="{{route('stock.present-status',[$stock->id,1])}}">الغاء التثبيت</button>
                    </form>
                    @endif

                @endcan
                    @can('stocks.print')
                        @if($stock->present==1)
                        <h2 class="col-md-12  mb-2">الحضور</h2>
                        <a class="btn btn-success pull-right mb-2 pb-2" href="{{route('stock.print',$stock->id)}}">اصدار بطاقة حضور</a>
                        @endif
                        @endcan
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group text-center">
                            {{--<button type="submit" class="btn btn-primary-big">حفظ</button>--}}
                        </div>
                    </div>
                </div>

        </div>
    </div>
@endsection

@section('js')
    <script>

        $(document).ready(function () {
            $('.select2').select2({
                maximumSelectionLength: 1
            });
        });
        </script>
@endsection