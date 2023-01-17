<!doctype html >
<html style="height: 100%" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} | Admin</title>
    <link rel="stylesheet" href="{{asset('css/pannellum.css')}}"/>
    <script type="text/javascript" src="{{asset('js/pannellum.js')}}"></script>
    <script type="application/javascript" src="{{ asset('js/jquery.min.js') }}"></script>

    <!-- Scripts -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">



    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
          integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
          crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
            integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
            crossorigin=""></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">



    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .h_red:hover{
            background-color: rgb(118, 0, 0) !important;
        }
        .d_blow{
            background-color: #007f86;
        }


        .l_blow{
            background-color: #2fa0a6;
        }


        li.breadcrumb-item a{
            color: rgb(47, 160, 166) !important;
        }

        ol.breadcrumb li.active{
            color: #b5d6d8 !important;
            cursor: default;
        }

        .table-hover tbody tr:hover {
            background: #b5d6d8;
            cursor: pointer;
        }

        .custom-control-input:checked~.custom-control-label:before {
            border-color: #2fa0a6 !important;
            background-color: #2fa0a6 !important;
        }

        label.custom-control-label:hover{
            cursor: pointer;
        }

        input.custom-file-input:hover{
            cursor: pointer;
        }

        .page-item.active .page-link{
            background-color: #2fa0a6 !important;
            border-color: #2fa0a6 !important;
        }

        .page-link{
            border-color: #2fa0a6 !important;
            color: #2fa0a6;
        }

        .btn-edit{
            padding: 7px;
            background: #2fa0a6;
            padding-right: 9px;
            padding-bottom: 0px;
            padding-top: 0px;
            border-radius: 5px;
            color: #ffffff;
            font-weight: bold;
            box-shadow: 0 0 3px 1px #14787e;
        }


        .custom-table-responsive{}
        @media only screen and (max-width: 600px) {
            .custom-table-responsive{
                display: block;
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            .gg{
                display: block;
                margin-left: auto;
                margin-right: auto;
                margin-top: calc(50%);
            }
        }


        #print_div{
            display: none;
        }

        #screen_dev{
            display: block;
        }

        @media print {

            body {
                margin: 0;
                color: #000;
                background-color: #fff;
            }

            #screen_dev{
                display: none !important;
            }

            #print_div{
                display: block !important;
            }
        }

    </style>

    <script>
        function co(id){
            var target = $('#'+id);
            var photo = target[0].dataset['image'];
            photo = photo.replace('public/','');
            var image_link = "{{asset('public/')}}";
            image_link = image_link.replace('/public','');
            image_link = image_link + '/storage/';

            var image = image_link + photo;
            pannellum.viewer(id, {
                "type": "equirectangular",
                "panorama": image,
                "autoLoad":true
            });
        }
    </script>

    @stack('scripts_head')
</head>
<body  style="background-color: #2fa0a6;height: 100%">
<div id="app" style="height: 100%;padding: 0">
    <main class="py-4" style="height: 100%;padding: 0 !important;">
        <div class="container-fluid" style="height: 100%;">
            <div class="row"  style="height: 100%;padding: 0">
                <div class="col-sm-2" style="min-height: 100%;">
                    <div class="card" style="max-width: 13rem;background: none;border: none;margin: 0 auto">

                        <img src="{{asset('images/app_images/ella_logo.png')}}" class="card-img-top" style="width: 100%;margin: 0 auto;margin-top: 50px;">
                        <div class="card-body text-center" style="color: white;padding-right: 5px;padding-left: 5px;margin-bottom: 20px">
                            <h4 class="card-title text-uppercase" style="font-weight: 900;font-size: 1.1rem;">WELCOME </h4>
                        </div>
                        <ul class="list-group text-center">

                            <li onclick="window.location.href = ''" class="list-group-item text-uppercase mb-2 h_red d_blow" style="cursor:pointer;color: white;font-weight: bold;padding: 6px">Governorates</li>

                            <li onclick="window.location.href = ''" class="list-group-item text-uppercase mb-2 h_red d_blow" style="cursor:pointer;color: white;font-weight: bold;padding: 6px">Dates</li>

                            <li onclick="window.location.href = ''" class="list-group-item text-uppercase mb-2 h_red d_blow" style="cursor:pointer;color: white;font-weight: bold;padding: 6px">Networks</li>

                            <li onclick="window.location.href = ''" class="list-group-item text-uppercase mb-2 h_red d_blow" style="cursor:pointer;color: white;font-weight: bold;padding: 6px">Offers</li>

                            <li onclick="window.location.href = ''" class="list-group-item text-uppercase mb-2 h_red d_blow" style="cursor:pointer;color: white;font-weight: bold;padding: 6px">Reservations</li>

                            <li onclick="window.location.href = ''" class="list-group-item text-uppercase mb-2 h_red d_blow" style="cursor:pointer;color: white;font-weight: bold;padding: 6px">Users</li>

                            <li onclick="window.location.href = ''" class="list-group-item text-uppercase mb-2 h_red d_blow" style="cursor:pointer;color: white;font-weight: bold;padding: 6px">Visits</li>

                            <li onclick="window.location.href = ''" class="list-group-item text-uppercase mb-2 h_red d_blow" style="cursor:pointer;color: white;font-weight: bold;padding: 6px">Export Data</li>

                            <li onclick="window.location.href = ''" class="list-group-item text-uppercase mb-2 h_red d_blow" style="cursor:pointer;color: white;font-weight: bold;padding: 6px">Setting</li>

                            <li onclick="$('#logout').submit();" class="list-group-item text-uppercase mb-2 h_red d_blow" style="cursor:pointer;color: white;font-weight: bold;padding: 6px">Logout</li>

                        </ul>
                        <form id="logout" action="" method="post">@csrf</form>
                    </div>
                </div>

                <div class="col-md-10" style="background-color:#007f86;min-height: 100% !important;padding: 15px">
                    <div class="container" style="background-color: white;
                                              padding: 10px;
                                              border-radius: 10px;
                                              box-shadow: 0 0 16px 11px #5f5f5f;min-height: 100% !important;
                                              min-width: 100% !important;  ">
                        <div class="row" style="padding: 15px">
                            <div class="col-12">

                                @if(!empty(session('success')))
                                    <div role="alert" aria-live="assertive"   aria-atomic="true" style="position: relative;">
                                        <div class="toast" id="element1"  data-delay="5000"   style="position: absolute; top: 0; right: 0;min-width: 250px">
                                            <div class="toast-header" style="background-color: #2fa0a6; color: white;">
                                                <strong class="mr-auto">Ella Billboard Program</strong>
                                                <small>now</small>
                                                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="toast-body" style="background-color: aliceblue;">
                                                {{session('success')}}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if(!empty(session('error')))
                                    <div role="alert" aria-live="assertive"   aria-atomic="true" style="position: relative;">
                                        <div class="toast" id="element1"  data-delay="5000"   style="position: absolute; top: 0; right: 0;min-width: 250px">
                                            <div class="toast-header" style="background-color: #2fa0a6; color: white;">
                                                <strong class="mr-auto">Ella Billboard Program</strong>
                                                <small>now</small>
                                                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="toast-body" style="background-color: #ab002b;color: white;">
                                                {{session('error')}}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @yield('nav_content')

                                <hr>
                            </div>
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

</div>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
@if(!empty(session('success')) || !empty(session('error')))
    <script>$('#element1').toast('show')</script>
@endif
@stack('scripts')

</body>
</html>
