<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png')}}" sizes="16x16" href="{{asset('asset/images/favicon.png')}}">
    <title>@yield('title')</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{asset('asset/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script> --}}
    <link href="{{asset('asset/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('asset/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{asset('asset/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('asset/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- You can change the theme colors from here -->
    <link href="{{asset('asset/css/colors/blue.css')}}" rel="stylesheet">
    <!-- Morries chart CSS -->
    <link href="{{asset('asset/plugins/morrisjs/morris.css')}}" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="fix-header card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="{{url('/home')}}">
                        <!-- Logo icon --><b>
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            {{-- <img src="{{asset('asset/images/logo-icon.png')}}" alt="homepage" class="dark-logo" /> --}}
                            <h2>Laundry</h2>
                            <!-- Light Logo icon -->
                            {{-- <img src="{{asset('asset/images/logo-light-icon.png')}}" alt="homepage" class="light-logo" /> --}}
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text --><span>
                         <!-- dark Logo text -->
                         {{-- <img src="{{asset('asset/images/logo-text.png')}}" alt="homepage" class="dark-logo" /> --}}
                         <!-- Light Logo text -->    
                         <img src="{{asset('asset/images/logo-light-text.png')}}" class="light-logo" alt="homepage" /></span> </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                        <li class="nav-item m-l-10"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        <!-- ============================================================== -->
                        <!-- Comment -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-cart"></i>                               
                                <div class="notify"> 
                                    <?php
                                        $notif = App\transaksi::orderby('id','DESC')->first();
                                    ?>
                                    @if (@$notif->notif == 0)
                                        <span class="heartbit"></span> <span class="point"></span>
                                    @endif
                                </div>
                            </a>
                            <div class="dropdown-menu mailbox slideInUp">
                                <ul>
                                    <li>
                                        <div class="drop-title">Order Masuk</div>
                                    </li>
                                    <li>
                                        <div class="message-center">
                                            <!-- Message -->
                                            
                                            <?php 
                                                $aktif = App\transaksi::selectRaw('transaksis.id,transaksis.id_customer,transaksis.tgl_transaksi,transaksis.customer,transaksis.status_order,transaksis.status_payment,transaksis.id_jenis,transaksis.kg,transaksis.hari,transaksis.harga,a.jenis')
                                                ->where('notif',0)
                                                ->leftJoin('hargas as a' , 'a.id' , '=' ,'transaksis.id_jenis')
                                                ->get();
                                            ?>
                                                @foreach ($aktif as $item)
                                                <a href="{{url('data-transaksi')}}" data-id="{{$item->id}}" id="klik">
                                                    <div class="mail-contnet">
                                                        <h5>{{$item->customer}}</h5> 
                                                        <span class="mail-desc">{{$item->jenis}}</span> 
                                                        <span class="time">{{$item->tgl_transaksi}}</span> 
                                                    </div>
                                                    <div class="btn btn-success btn-circle"><i class="fa fa-check"></i></div>
                                                </a>
                                                @endforeach
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- End Comment -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- Messages -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- End Messages -->
                        <!-- ============================================================== -->
                    </ul>
                    <!-- ============================================================== -->
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- User profile -->
                <div class="user-profile">
                    <!-- User profile image -->
                    <div class="profile-img"> <img src="{{asset('asset/images/users/profile.png')}}" alt="user" /> 
                             <!-- this is blinking heartbit-->
                            <div class="notify setpos"> <span class="heartbit"></span> <span class="point"></span> </div>
                    </div>
                    <!-- User profile text-->
                    <div class="profile-text"> 
                            <h5>{{Auth::user()->name}}</h5>
                            {{-- <a href="pages-login.html" class="" data-toggle="tooltip" title="Logout"><i class="mdi mdi-power"></i></a> --}}
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();" data-toggle="tooltip" title="Logout">
                                <i class="mdi mdi-power"></i>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                            </form>
                    </div>
                </div>
                <!-- End User profile text-->
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                         <li class="nav-devider"></li>
                        <li class="nav-small-cap">PERSONAL</li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="{{url('/home')}}" aria-expanded="false"><i class="mdi mdi-home"></i><span class="hide-menu">Dashboard</span></a>
                        </li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-account"></i><span class="hide-menu">Data Pengguna</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{url('adm')}}">Administrator</a></li>
                                <li><a href="{{url('kry')}}">Karyawan</a></li>
                            </ul>
                        </li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-account-multiple"></i><span class="hide-menu">Data Customer</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{url('customer')}}">Customer</a></li>
                                {{-- <li><a href="{{url('jml-transaksi')}}">Transaksi Customer</a></li> --}}
                            </ul>
                        </li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-cart"></i><span class="hide-menu">Data Laundri</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{url('data-transaksi')}}">Transaksi</a></li>
                                <li><a href="{{url('data-harga')}}">Harga Laundri</a></li>
                            </ul>
                        </li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-currency-usd"></i><span class="hide-menu">Data Finance</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{url('data-finance-cabang')}}">Cabang</a></li>
                                {{-- <li><a href="{{url('data-harga')}}"></a></li> --}}
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                @yield('header')
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    @yield('content')
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer">
                <p style="color:black">© 2020 Aplikasi E-Lundry with <img class="icon-hati" src="{{asset('asset/images/icon/love.gif')}}" > </p>
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->

    <script src="{{asset('asset/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{asset('asset/plugins/bootstrap/js/popper.min.js')}}"></script>

    <script src="{{asset('asset/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{asset('asset/js/jquery.slimscroll.js')}}"></script>
    <!--Wave Effects -->
    <script src="{{asset('asset/js/waves.js')}}"></script>
    <!--Menu sidebar -->
    <script src="{{asset('asset/js/sidebarmenu.js')}}"></script>
    <!--stickey kit -->
    <script src="{{asset('asset/plugins/sticky-kit-master/dist/sticky-kit.min.js')}}"></script>
    <script src="{{asset('asset/plugins/sparkline/jquery.sparkline.min.js')}}"></script>
    <!--Custom JavaScript -->
    <script src="{{asset('asset/js/custom.min.js')}}"></script>
    <!--morris JavaScript -->
    <script src="{{asset('asset/plugins/raphael/raphael-min.js')}}"></script>
    <script src="{{asset('asset/plugins/morrisjs/morris.min.js')}}"></script>
    <!-- ChartJS -->
    <script src="{{asset('/highchart/js/highcharts.js')}}"></script>
    <script src="{{asset('/highchart/js/modules/exporting.js')}}"></script>
    <script src="{{asset('asset/plugins/sweetalert/sweetalert.min.js')}}"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="{{asset('asset/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('asset/plugins/styleswitcher/jQuery.style.switcher.js')}}"></script>

    {{-- Select2 --}}
    <script src="{{asset('asset/plugins/select2/dist/js/select2.full.min.js')}}" type="text/javascript"></script>
     {{-- Notifikasi --}}
     <script type="text/javascript">
        // Proses Mengubah Notifikasi Menjadi Null
        $(document).on('click','#klik', function () {
        var id = $(this).attr('data-id');
        $.get(' {{Url("notif")}}', {'_token' : $('meta[name=csrf-token]').attr('content'),id:id}, function(resp){
            swal({
                html : "Berhasil Ubah Status",
                showConfirmButton : false,
                type : "success",
                timer : 1000
            });
            location.reload();
        });
        });

        $(".select2").select2();
    </script>
 
    @yield('script')
    
</body>

</html>
