<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<title>@yield('title')</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
  <meta name="description" content="E-Laundy aplikasi laundry berbasis website">
  <meta name="keywords" content="E-Laundry,Laundry">
  <meta name="author" content="Andri Desmana">

	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
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
    @yield('header')
    <!-- end #header -->

    <!-- begin search-banner -->
    <div class="search-banner has-bg">
       @yield('banner')
    </div>
    <!-- end search-banner -->

    <!-- begin content -->
    <div class="content">
        <!-- begin container -->
        <div class="container-fluid">
          <div id="app">
            @yield('content')
          </div>
        </div>
        <!-- end container -->
    </div>
    <!-- end content -->

    <!-- begin #footer -->
    @yield('footer')
    <!-- end #footer -->

    <!-- begin #footer-copyright -->
    <div class="footer-copyright">
        <div class="container">
            &copy; <?php echo date("Y") ?> Build With <i class="fa fa-heart" style="color:red"></i> - <a href="https://www.andridesmana.space" target="_blank" style="text-decoration:none">Andri Desmana</a>
        </div>
    </div>
    <!-- end #footer-copyright -->
	<!-- ================== BEGIN BASE JS ================== -->
  <script src="{{ asset('js/app.js') }}" ></script>
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
