@extends('layouts.app_no_nav')

@section('content')

    <!--Login-Section-->
    <section >
        <div class="container customerpage text-center" >
        <!--   <video width="100%" height="100%" playsinline autoplay muted loop  id="myVideo">
                <source src="{{asset('vid.mp4')}}" type="video/mp4">
                Your browser does not support the video tag.
            </video> -->
            <h2>Tutorial will be here</h2>
        </div>
        <a href="{{route('home')}}" class="float">
            Skip
        </a>
    </section>
    <!--/Login-Section-->

    <script>
        document.getElementById('myVideo').play();
    </script>
@endsection
