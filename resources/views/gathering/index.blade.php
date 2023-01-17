@extends('layouts.new')
@section('title','الجمعيات')
@section('content')
<div class="container-fluid" style="padding-top: 25px; text-align:center">
<div class="container col-md-4" style="text-align: center;">
<div class="row justify-content-center">

</div>
</div>
<div class="container shadow" style="margin-top: 15px;padding-top:15px;padding-bottom:15px;max-width: 1250px">
<div class="container col-md-5">
    {{--<div style="display: inline-block;width:50%">--}}
    {{--<p>--}}
    {{--<label><strong>عرض</strong></label>--}}
    {{--<select class="form-control" style="width:50%;display:inline-block">--}}
        {{--<option>10</option>--}}
    {{--</select>--}}
    {{--<label><strong>عنصر</strong></label>--}}
    {{--</p>--}}
{{--</div>--}}
    {{--<div  style="display: inline-block;width:100%;text-align:center">--}}

        {{--<label>بحث</label>--}}
        {{--<form style="display: inline-block;" method="GET" action="{{url('/roles')}}">--}}
            {{--<input type="text" class="option-control" name="search" value="{{request('search')}}">--}}
            {{--<button type="submit" class="btn btn-secondary option-control mb-1">ابحث</button>--}}
        {{--</form>--}}
    {{--</div>--}}
</div>

<div class="table-responsive">
    @if(session()->has('success'))
        <div class="form-group text-center">
            <label class="alert alert-success">{{ session()->get('success')}}</label>
        </div>
    @endif
        @if(session()->has('error'))
        <div class="form-group text-center">
            <label class="alert alert-danger">{{ session()->get('error')}}</label>
        </div>
    @endif
    <h2 style="text-align: center;">الجمعيات</h2>
    @can('gathering.create')
        <div class="col-md-12 text-center">
            <a type="button" href="{{route('gatherings.create')}}" class="btn btn-default-big"><i class="fa fa-plus-circle"></i> إضافة جديد</a>
        </div>
    @endcan
    <Br>
        <table class="table">
            <thead>
                <tr>
                    <th>الرقم</th>
                    <th>تاريخ الانعقاد</th>
                    <th>وقت الانعقاد</th>
                    <th>طبيعة الاجتماع</th>
                    <th>مكان الاجتماع</th>
                    <th>سبب الاجتماع</th>
                    <th>نسبة النصاب</th>
                    <th>تاريخ الادخال</th>
                    <th>الحالة</th>
                    <th>ملف محضر الاجتماع</th>
                    <th>الاجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($gatherings as $gathering)
                <tr>
                    <td>{{ $gathering->g_number }}</td>
                    <td>{{ $gathering->g_date }}</td>
                    <td>{{ $gathering->g_time }}</td>
                    <td>{{ \App\Models\Gathering::$g_type[$gathering->type] }}</td>
                    <td>{{ $gathering->place }}</td>
                    <td>{{ $gathering->reason }}</td>
                    <td>{{ $gathering->stocks_percentage }}</td>

                    <td>{{ $gathering->created_at }}</td>
                    <td><p class="btn btn-info">{{ $gathering->status==0?'مغلقه':'جارية' }}</p></td>

                    <td>@if($gathering->close_file!=null)<a href="{{asset('storage/'.$gathering->close_file)}}" download>تحميل</a> @endif</td>

                    <td>
                        @if($gathering->status==1)
                    @can('gathering.delete')
                        <form action="{{route('gatherings.destroy',$gathering->id)}}" method="post" style="display: inline-block;">
                            @csrf
                            {{method_field('DELETE')}}
                            <BUTTON type="submit"  class="btn btn-danger" style="margin:5px;border-radius: 5px;"><i class="fa fa-trash"></i> حذف</BUTTON>
                        </form>
                        @endcan
                    @can('gathering.update')
                        <a type="button" class="btn btn-warning" href="{{route('gatherings.edit',$gathering->id)}}"><i class="fa fa-edit"></i> تعديل</a>
                        @if($gathering->status==1)
                                <button type="button" class="btn btn-info " data-toggle="modal" data-target="#myModal" data-backdrop="false" data-id="{{$gathering->id}}">اغلاق الجسلة</button>
                            @endif
                        @endcan
                    @endif
                    {{--@can('gathering.show')--}}
                        {{--<a type="button" class="btn btn-primary" href="{{route('gatherings.show',$gathering->id)}}"><i class="fa fa-edit"></i> معاينه</a>--}}
                        {{--@endcan--}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="container col-md-4" style="padding-bottom: 25px;">
    <nav>
    
</nav>
    </div>
</div>
</div>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog" style="margin-left: 50%">

        <!-- Modal content-->
        <div class="modal-content" style="width: 210%;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">اغلاق الجلسة</h4>
            </div>
            <div class="modal-body" style="padding: 2rem">
                <form id="docsForm" action="" method="post" enctype="multipart/form-data" class="row">
                    @csrf

                        <div class="col-md-6 ">
                            <div class="form-group">

                                <label class="control-label" for="name">ملف</label>
                                <input  type="file" class="form-control" name="file" required>

                                @error('file')
                                <p style="color: red;">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mt-4 pt-1">
                            <button type="submit" class="btn btn-success text-center mod-open" value="1">اغلاق الجلسة</button>

                        </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
            </div>
        </div>

    </div>
</div>
@endsection
@section('js')
    <script>
        $('#myModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id= button.data('id'); // Extract info from data-* attributes

            var modal = $(this);
            $("#docsForm").attr("action", "{{route('gathering.close')}}"+"/" + id);
        })
    </script>
    @endsection