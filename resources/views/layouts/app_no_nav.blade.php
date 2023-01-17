<!doctype html >
<html style="height: 100%" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <link rel="stylesheet" href="{{asset('css/pannellum.css')}}"/>
    <script type="text/javascript" src="{{asset('js/pannellum.js')}}"></script>
    <script type="application/javascript" src="{{ asset('js/jquery.min.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">


    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
          integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
          crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
            integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
            crossorigin=""></script>


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

        .l_blow_dark:hover{
            background-color: #57585a !important;
        }


        .l_green_dark{
            background-color: #25575a;
        }

        .l_green_dark:hover{
            background-color: #57585a;
        }


        .d_green_dark{
            background-color: #2fa0a6;
        }



        .d_green_dark:hover{
            background-color: #2fa0a6;
        }

        li.breadcrumb-item a{
            color: #fff !important;
        }

        ol.breadcrumb li.active{
            color: #b5d6d8 !important;
            cursor: default;
        }

        .date_status{
            position: absolute;
            bottom: 2px;
            right: 2px;
            padding: 5px;
            border-radius: 50%;
        }

        .date_status_red{
            background-color: #760000;
            box-shadow: 0 0 5px 1px #8e0909;
        }

        .date_status_green{
            background-color: #049c09;
            box-shadow: 0 0 5px 1px #1ce619;
        }

        .date_status_yellow{
            background-color: #dcc91e;
            box-shadow: 0 0 5px 1px #ffe600;
        }

        .reserved_dates{
            BOX-SHADOW: 0 0 5px 2px #ff0000;
            background-color: rgb(118, 0, 0) !important;
        }


        @media only screen and (max-width: 600px) {
            .gg{
                display: block;
                margin-left: auto;
                margin-right: auto;
                margin-top: calc(50%);
            }
        }

    </style>
    <style>
        #myVideo {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
        }

        /* Add some content at the bottom of the video/page */
        .content {
            position: fixed;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            color: #f1f1f1;
            width: 100%;
            padding: 20px;
        }
        .float{
            position:fixed;
            font-size: 150%;
            padding-left: 5%;
            padding-right: 5%;
            border-radius: 10%;
            bottom:3%;
            right: 10%;
            color: white;
            background: orange;
            text-align:center;
        }
        body{
            padding-top: 10px;
            height: 100vh;
            width: 100%;
            margin: 0;
            background-size: contain;
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

            @yield('content')
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
