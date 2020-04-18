<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<title>@yield('title')</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	
	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
	<link href="{{asset('frontend/plugins/bootstrap3/css/bootstrap.min.css')}}" rel="stylesheet" />
	<link href="{{asset('frontend/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" />
	<link href="{{asset('frontend/plugins/animate/animate.min.css')}}" rel="stylesheet" />
	<link href="{{asset('frontend/css/forum/style.css')}}" rel="stylesheet" />
	<link href="{{asset('frontend/css/forum/style-responsive.min.css')}}" rel="stylesheet" />
	<link href="{{asset('frontend/css/forum/theme/default.css')}}" id="theme" rel="stylesheet" />
	<!-- ================== END BASE CSS STYLE ================== -->
	
	<!-- ================== BEGIN BASE JS ================== -->
    <script src="{{asset('frontend/plugins/pace/pace.min.js')}}"></script>
    
    <!-- ================== END BASE JS ================== -->
    <style type="text/css">
        body {
            overflow-x: hidden;
        }
    </style>
</head>
<body>
    <!-- begin #header -->
    <div id="header" class="header navbar navbar-default navbar-fixed-top">
        <!-- begin container -->
        <div class="container">
            <!-- begin navbar-header -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#header-navbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="{{url('/')}}" class="navbar-brand">
                    <span class="navbar-logo"></span>
                    <span class="brand-text">
                        E-Laundry
                    </span>
                </a>
            </div>
            <!-- end navbar-header -->
            <!-- begin #header-navbar -->
            <div class="collapse navbar-collapse" id="header-navbar">
                <ul class="nav navbar-nav navbar-right">
                    @auth
                    <li> <a href="{{url('/home')}}">Welcome, {{auth::user()->name}}</a> </li>
                    @else
                    <li><a href="{{route('login')}}">Masuk</a></li>
                    @endauth
                </ul>
            </div>
            <!-- end #header-navbar -->
        </div>
        <!-- end container -->
    </div>
    <!-- end #header -->
    
    <!-- begin search-banner -->
    <div class="search-banner has-bg">
       @yield('header')
    </div>
    <!-- end search-banner -->
    
    <!-- begin content -->
    <div class="content">
        <!-- begin container -->
        @yield('content')
        <!-- end container -->
    </div>
    <!-- end content -->
    
    <!-- begin #footer -->
    <div id="footer" class="footer">
        <!-- begin container -->
        <div class="container-fluid">
            <!-- begin row -->
            <div class="row">
                <!-- begin col-4 -->
                <div class="col-xl-4 col-lg-4 col-12">
                    <!-- begin section-container -->
                    <div class="section-container">
                        <h4>Tentang E-Laundry</h4>
                        <p>
                           
                        </p>
                    </div>
                    <!-- end section-container -->
                </div>
                <!-- end col-4 -->
                <!-- begin col-4 -->
                <div class="col-xl-4 col-lg-4 col-12">
                    <!-- begin section-container -->
                    <div class="section-container">
                        <h4>Ketentuan</h4>
                        <ul class="latest-post">
                            
                        </ul>
                    </div>
                    <!-- end section-container -->
                </div>
                <!-- end col-4 -->
                <!-- begin col-4 -->
                <div class="col-xl-4 col-lg-4 col-12">
                    <!-- begin section-container -->
                    <div class="section-container">
                        <h4>Hubungi Kami</h4>
                        <ul class="new-user">
                           
                        </ul>
                    </div>
                    <!-- end section-container -->
                </div>
                <!-- end col-4 -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end #footer -->
    <!-- begin #footer-copyright -->
    <div class="footer-copyright">
        <div class="container-fluid">
            &copy; 2020 Build With <i class="fa fa-heart" style="color:red"></i> - <a href="https://www.instagram.com/andridesmana/" target="_blank" style="text-decoration:none">Andri Desmana</a>
        </div>
    </div>
    <!-- end #footer-copyright -->	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="{{asset('frontend/plugins/jquery/jquery-3.2.1.min.js')}}"></script>
	<script src="{{asset('frontend/plugins/bootstrap3/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('frontend/plugins/js-cookie/js.cookie.js')}}"></script>
    <script src="{{asset('frontend/js/forum/apps.min.js')}}"></script>
    <script src="{{asset('frontend/js/swal/sweetalert2.all.min.js')}}"></script>
	<!-- ================== END BASE JS ================== -->
	
	<script>    
	    $(document).ready(function() {
	        App.init();
	    });
    </script>
    @yield('scripts')
</body>
</html>
