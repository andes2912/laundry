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
	<link href="{{asset('frontend/css/forum/style.min.css')}}" rel="stylesheet" />
	<link href="{{asset('frontend/css/forum/style-responsive.min.css')}}" rel="stylesheet" />
	<link href="{{asset('frontend/css/forum/theme/default.css')}}" id="theme" rel="stylesheet" />
	<!-- ================== END BASE CSS STYLE ================== -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="{{asset('frontend/plugins/pace/pace.min.js')}}"></script>
	<!-- ================== END BASE JS ================== -->
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
                <a href="index.html" class="navbar-brand">
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
                    <li><a href="javascript:;">Masuk</a></li>
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
        <div class="container">
            <!-- begin row -->
            <div class="row">
                <!-- begin col-4 -->
                <div class="col-md-4">
                    <!-- begin section-container -->
                    <div class="section-container">
                        <h4>About Color Admin</h4>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce ultrices ipsum in elementum porttitor. 
                            Cras porttitor fermentum nisl non elementum. Nulla in placerat libero. Nulla pharetra purus eget diam dictum 
                            ullamcorper nec et eros. Suspendisse consectetur nulla ut volutpat aliquam.
                        </p>
                    </div>
                    <!-- end section-container -->
                </div>
                <!-- end col-4 -->
                <!-- begin col-4 -->
                <div class="col-md-4">
                    <!-- begin section-container -->
                    <div class="section-container">
                        <h4>Latest Post</h4>
                        <ul class="latest-post">
                            <li>
                                <h4 class="title"><a href="#">Consectetur adipiscing elit ultrices</a></h4>
                                <p class="time">yesterday 10:42am</p>
                            </li>
                            <li>
                                <h4 class="title"><a href="#">Fusce ultrices ipsum porttitor</a></h4>
                                <p class="time">10/04/2015</p>
                            </li>
                            <li>
                                <h4 class="title"><a href="#">Cras porttitor fermentum adipiscing</a></h4>
                                <p class="time">02/04/2015</p>
                            </li>
                        </ul>
                    </div>
                    <!-- end section-container -->
                </div>
                <!-- end col-4 -->
                <!-- begin col-4 -->
                <div class="col-md-4">
                    <!-- begin section-container -->
                    <div class="section-container">
                        <h4>New Users</h4>
                        <ul class="new-user">
                            <li><a href="#"><img src="../assets/img/user/user-1.jpg" alt="" /></a></li>
                            <li><a href="#"><img src="../assets/img/user/user-2.jpg" alt="" /></a></li>
                            <li><a href="#"><img src="../assets/img/user/user-3.jpg" alt="" /></a></li>
                            <li><a href="#"><img src="../assets/img/user/user-4.jpg" alt="" /></a></li>
                            <li><a href="#"><img src="../assets/img/user/user-5.jpg" alt="" /></a></li>
                            <li><a href="#"><img src="../assets/img/user/user-6.jpg" alt="" /></a></li>
                            <li><a href="#"><img src="../assets/img/user/user-7.jpg" alt="" /></a></li>
                            <li><a href="#"><img src="../assets/img/user/user-8.jpg" alt="" /></a></li>
                            <li><a href="#"><img src="../assets/img/user/user-9.jpg" alt="" /></a></li>
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
    <div id="footer-copyright" class="footer-copyright">
        <div class="container">
            &copy; 2020 Dibangun Dengan Cinta - Andri Desmana
            <a href="#">Contact Us</a> 
            <a href="#">Knowledge Base</a>
        </div>
    </div>
    <!-- end #footer-copyright -->	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="{{asset('frontend/plugins/jquery/jquery-3.2.1.min.js')}}"></script>
	<script src="{{asset('frontend/plugins/bootstrap3/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('frontend/plugins/js-cookie/js.cookie.js')}}"></script>
	<script src="{{asset('frontend/js/forum/apps.min.js')}}"></script>
	<!-- ================== END BASE JS ================== -->
	
	<script>    
	    $(document).ready(function() {
	        App.init();
	    });
    </script>
    @yield('script')
</body>
</html>
