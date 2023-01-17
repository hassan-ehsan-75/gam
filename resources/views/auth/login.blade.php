<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/fonts/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/rtl.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/Sidebar-Menu-1.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/Sidebar-Menu.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/styles.css')}}">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="shortcut icon" href="{{asset('/favicon.ico')}}" type="image">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
      
        </style>
        <title>
        تسجيل الدخول
        </title>
</head>
<body>
<div class="container-fluid" style="padding-top: 50px;">
    
    <div class="container col-md-4 shadow" style="margin-top: 20px;padding-top:15px;padding-bottom:15px;background-color:#fff;border-radius:10px">
    <div class="container">
        <div class="container text-center">
        <img src="{{asset('/images/app_images/logoo.png')}}" style="    height: 90px;width: 190px;margin-right: 3%;"/>
        </div>
        <h1 class="text-center">تسجيل الدخول</h1>
    </div>    
    <form method="POST" action="{{url('/login')}}">
        @csrf
        @error('error')
                                    <div class="alert alert-danger">
                                        <strong>{{ $message}}</strong>
                                    </div>
        @endif
            <div class="form-group">
                <label class="control-label">الإيميل</label>
                <input type="email" required name="email" class="form-control" style="border-radius: 35px;">
            </div>
            <div class="form-group">
                <label class="control-label" for="password">كلمة المرور</label>
                <input type="password" id="password" required class="form-control" name="password" style="border-radius: 35px;">
            </div><div class="form-group text-center">
                                <button type="submit" class="btn btn-primary-big">
                                    تسجيل الدخول
                                </button>
                        </div>
        </form>
        <h5 class="text-center" id="span" style="color: rgba(105,105,105,0.66)"><strong>Powerd by <span >Q</span>tech Group</strong></h5>
    </div>
    </div>
</div>
</body>
</html>
