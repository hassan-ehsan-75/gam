<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="{{asset('favicon.ico')}}" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{--<link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}">--}}
    <link rel="stylesheet" href="{{asset('boots/bootstrap.min.css')}}" >
    <link rel="stylesheet" href="{{asset('assets/fonts/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/rtl.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/Sidebar-Menu-1.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/Sidebar-Menu.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/styles.css')}}">
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/popper.min.js')}}"></script>
    {{--<script src="{{asset('js/bootstrap.min.js')}}"></script>--}}
    <script src="{{asset('boots/bootstrap.min.js')}}" ></script>

    <style>
        body{
            zoom: 85% !important ;
        }
        span.relative.inline-flex.items-center.px-4.py-2.text-sm.font-medium.text-gray-500.bg-white.border.border-gray-300.cursor-default.leading-5.rounded-md{

            display: none !important;
        }
        a.relative.inline-flex.items-center.px-4.py-2.ml-3.text-sm.font-medium.text-gray-700.bg-white.border.border-gray-300.leading-5.rounded-md.transition.ease-in-out.duration-150{

           display: none !important;
        }
        a.relative.inline-flex.items-center.px-4.py-2.text-sm.font-medium.text-gray-700.bg-white.border.border-gray-300.leading-5.rounded-md.transition.ease-in-out.duration-150{

           display: none !important;
        }
    </style>

    <title>
        @yield("title")
    </title>
    @yield('css')
</head>
<body>
<section id="loading" class="loading">
    <div id="loading-content" class="loading-content"></div>
</section>
<div id="wrapper">
    <div id="sidebar-wrapper">
        <div class="wrapper-image">
            <img src="{{asset('images/app_images/logoo.png')}}">
        </div>
        <ul class="sidebar-nav">
            <li><a href="{{route('home')}}">الصفحة الرئيسية</a></li>
            @role('admin')
            <li><a href="{{route('roles.index')}}">الصلاحيات</a></li>
            <li><a href="{{route('users.index')}}">المستخدمين</a></li>
            @endrole

            @can('gathering.show')
            <li><a href="{{route('gatherings.index')}}">الجمعيات</a></li>
            @endcan
            @can('records')
            <li><a href="{{route('records.index')}}">البنود</a></li>
            @endcan

            @can('impor xsl')
                <li><a href="{{route('import.home')}}">تحميل جدول المساهمين</a></li>
            @endcan
            @can('stocks.show')
            <li><a href="{{route('import.index',[0,0])}}">المساهمين</a></li>
            @endcan
            {{--@can('stocks.enter')--}}
            {{--<li><a href="{{route('stock.enterForm')}}">الدخول الى الجلسة</a></li>--}}
            {{--@endcan--}}
            @can('stocks.answer')
            <li><a href="{{route('stock.answerForm')}}">فحص تصويت البنود</a></li>
            @endcan
            @can('candidate')
            <li><a href="{{route('candidates.index')}}">المرشحين</a></li>
            @endcan
            @can('candidate-answer')
            <li><a href="{{route('candidates.votes')}}">فحص تصويت المرشحين</a></li>
            @endcan
            @can('setting.update')
            <li><a href="{{route('settings.index')}}">الاعدادات</a></li>
            @endcan

            <h5 class="text-center" style="margin-top: 8px;bottom: 0;position: relative;color: rgba(105,105,105,0.66)" ><strong>Powerd by Qtech Group</strong></h5>
        </ul>
    </div>
    <div class="page-content-wrapper">

        <div class="container-fluid"><a class="btn btn-link" role="button" id="menu-toggle" href="#menu-toggle"><i class="fa fa-bars"></i></a>
            <div class="row" style="margin-bottom: 15px;">

                <div class="col-md-12" style="border-bottom: 1px solid #cab46b;">
                    <div style="display: inline-block;">
                        <p><?php echo date('Y/m/d D'); ?></p>
                    </div>
                    <div style="display: inline-block;float: left;">
                        <span class="top-option" id="span"></span>
                        @auth
                        <span class="top-option">
        <div class="dropdown">
  <!-- <a type="button" class="dropdown-toggle" data-backdrop="false" data-toggle="modal" data-target="#myModal2"> -->
        <!-- <img src="" class="profile-img"> <span class="caret"> -->

      {{--</span>--}}
                        {{--</a>--}}
                    {{--</div>--}}
                        <div class="row" style="margin-bottom: 2px">

                            <a class="dropdown-item" style="width:75% !important" href="{{url('/user/profile')}}">الصفحة الشخصية</a>

                            <a class=" btn btn-danger text-center" href="{{url('/logout')}}"><i class="fa fa-power-off"></i></a>
                        </div>
                    </div>
                    </span>
                    @endauth
                </div><br>
            </div>
        </div>
        @yield('content')

    </div>


</div>
</div>
<div id="myModal2" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">

            </div>
        </div>

    </div>

</div>
@yield('js')
<script>

    function showLoading() {
        document.querySelector('#loading').classList.add('loading');
        document.querySelector('#loading-content').classList.add('loading-content');
    }

    function hideLoading() {
        document.querySelector('#loading').classList.remove('loading');
        document.querySelector('#loading-content').classList.remove('loading-content');
    }

    document.onreadystatechange = function() {
        if (document.readyState !== "complete") {
            setTimeout(hideLoading,500);
        }
    };
    // When the user clicks on <div>, open the popup
    var span = document.getElementById('span');

    function time() {
        var d = new Date();
        var s = d.getSeconds();
        var m = d.getMinutes();
        var h = d.getHours();
        span.textContent =
            ("0" + h).substr(-2) + ":" + ("0" + m).substr(-2) + ":" + ("0" + s).substr(-2);
    }
    //$(document).ready(function() {
    //    $('.table').DataTable({
    //        language: {'url': '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Arabic.json'},
    //        "bPaginate": false,
    //    });
    //} );
    setInterval(time, 1000);
</script>


</body>
</html>