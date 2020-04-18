<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>@yield('title')</title>
    <link rel="apple-touch-icon" href="{{asset('backend/images/ico/apple-icon-120.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('backend/images/ico/favicon.ico')}}">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('backend/vendors/css/vendors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/vendors/css/extensions/tether.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/vendors/css/extensions/shepherd-theme-default.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/vendors/css/tables/datatable/datatables.min.css')}}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('backend/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/css/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/css/colors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/css/components.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/css/themes/dark-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/css/themes/semi-dark-layout.css')}}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('backend/css/core/menu/menu-types/vertical-menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/css/core/colors/palette-gradient.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/css/pages/dashboard-analytics.css')}}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('backend/css/style.css')}}">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern 2-columns  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">

    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar-expand-lg navbar navbar-with-menu floating-nav navbar-light navbar-shadow">
        <div class="navbar-wrapper">
            <div class="navbar-container content">
                <div class="navbar-collapse" id="navbar-mobile">
                    <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                        <ul class="nav navbar-nav">
                            <li class="nav-item mobile-menu d-xl-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ficon feather icon-menu"></i></a></li>
                        </ul>
                    </div>
                    <ul class="nav navbar-nav float-right">
                        {{-- Notification --}}
                        <?php
                            if (auth::user()->auth == 'Karyawan') {
                                $notif = App\transaksi::Where('notif',0)
                                ->Where('id_karyawan', Auth::user()->id)
                                ->orderBy('id','DESC')
                                ->get();
                            }elseif(auth::user()->auth == "Admin"){
                                $notif = App\transaksi::where('notif_admin', 0)
                                ->orderBy('id','DESC')
                                ->get();
                            }

                            
                        ?>
                        <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon feather icon-bell"></i><span class="badge badge-pill badge-primary badge-up">{{$notif->count()}}</span></a>
                            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                                <li class="dropdown-menu-header">
                                    <div class="dropdown-header m-0 p-2">
                                        <h3 class="white">{{$notif->count()}}</h3><span class="notification-title">App Notifications</span>
                                    </div>
                                </li>
                                <li class="scrollable-container media-list">
                                    @foreach ($notif as $item)
                                        <a class="d-flex justify-content-between" id="notif" data-id="{{$item->id}}">
                                            <div class="media d-flex align-items-start">
                                                <div class="media-left">
                                                    <i class="feather icon-plus-square font-medium-5 primary"></i>
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="primary media-heading">Laundry Baru Masuk</h6>
                                                    <small class="notification-text"> {{$item->customer}} | {{$item->kg}} kg | {{Rupiah::getRupiah($item->harga_akhir)}}</small>
                                                </div>
                                                <small>
                                                    <time class="media-meta">{{Carbon\carbon::parse($item->updated_at)->diffForHumans()}}</time>
                                                </small>
                                            </div>
                                        </a>
                                    @endforeach
                                </li>
                                {{-- <li class="dropdown-menu-footer">
                                    <a class="dropdown-item p-1 text-center" href="javascript:void(0)">Read all notifications</a>
                                </li> --}}
                            </ul>
                        </li>
                        <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                <div class="user-nav d-sm-flex d-none"><span class="user-name text-bold-600">{{auth::user()->name}}</span><span class="user-status">{{auth::user()->auth}}</span></div><span><img class="round" src="{{asset('backend/images/portrait/small/avatar-s-11.jpg')}}" alt="avatar" height="40" width="40"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                @if (auth::user()->auth == 'Admin')
                                    
                                @else
                                <a class="dropdown-item" href="{{url('profile-karyawan', auth::user()->id )}}"><i class="feather icon-user"></i>Profile
                                </a>
                                @endif
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('logout') }}" class="dropdown-item"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();" data-toggle="tooltip" title="Logout">
                                    <i class="feather icon-power"></i>
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto"><a class="navbar-brand" href="{{url('home')}}">
                        <div class="brand-logo"></div>
                        <h2 class="brand-text mb-0">Laundry</h2>
                    </a></li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary" data-ticon="icon-disc"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class="nav-item"><a href="{{url('home')}}"><i class="feather icon-home"></i><span class="menu-title" data-i18n="Dashboard">Dashboard</span></a>
                </li>
               
                {{-- Menu Admin --}}
                    @if (auth::user()->auth == "Admin")
                        <li class=" nav-item"><a href="#"><i class="feather icon-user"></i><span class="menu-title" data-i18n="User">Data Pengguna</span></a>
                            <ul class="menu-content">
                                <li><a href="{{url('adm')}}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="List">Administrator</span></a>
                                </li>
                                <li><a href="{{url('kry')}}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="View">Karyawan</span></a>
                                </li>
                            </ul>
                        </li>

                        <li class=" nav-item"><a href="#"><i class="feather icon-users"></i><span class="menu-title" data-i18n="User">Data Customer</span></a>
                            <ul class="menu-content">
                                <li><a href="{{url('customer')}}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="List">Customer</span></a>
                                </li>
                            </ul>
                        </li>

                        <li class=" nav-item"><a href="#"><i class="feather icon-layers"></i><span class="menu-title" data-i18n="User">Data Laundry</span></a>
                            <ul class="menu-content">
                                <li><a href="{{url('data-transaksi')}}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="List">Transaksi</span></a>
                                </li>
                                <li><a href="{{url('data-harga')}}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="List">Harga Laundry</span></a>
                                </li>
                            </ul>
                        </li>

                        <li class=" nav-item"><a href="#"><i class="feather icon-credit-card"></i><span class="menu-title" data-i18n="User">Data Finance</span></a>
                            <ul class="menu-content">
                                <li><a href="{{url('data-finance')}}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="List">Finance</span></a>
                                </li>
                            </ul>
                        </li>
                    {{-- End Menu Admin --}}

                    {{-- Menu Karyawan --}}
                    @elseif(auth::user()->auth == "Karyawan")
                        <li class=" nav-item"><a href="#"><i class="feather icon-layers"></i><span class="menu-title" data-i18n="User">Data Transaksi</span></a>
                            <ul class="menu-content">
                                <li><a href="{{route('pelayanan.index')}}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="List">Order Masuk</span></a>
                                </li>
                                <li><a href="{{url('add-order')}}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="List">Tambah Order</span></a>
                                </li>
                                <li><a href="{{url('list-customer')}}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="List">Data Customer</span></a>
                                </li>
                            </ul>
                        </li>
                    @endif
                {{--End  --}}
            
            </ul>
        </div>
    </div>
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                @yield('content')
                @include('sweetalert::alert')
            </div>
            
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light">
        <p class="clearfix blue-grey lighten-2 mb-0"><span class="float-md-left d-block d-md-inline-block mt-25">COPYRIGHT &copy; 2020<a class="text-bold-800 grey darken-2" href="https://www.instagram.com/andridesmana/" target="_blank">Andri Desmana,</a>All rights Reserved</span><span class="float-md-right d-none d-md-block">Build With <i class="feather icon-heart pink"></i></span>
            <button class="btn btn-primary btn-icon scroll-top" type="button"><i class="feather icon-arrow-up"></i></button>
        </p>
    </footer>
    <!-- END: Footer-->


    <!-- BEGIN: Vendor JS-->
    <script src="{{asset('backend/vendors/js/vendors.min.js')}}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{asset('backend/vendors/js/charts/apexcharts.min.js')}}"></script>
    <script src="{{asset('backend/vendors/js/extensions/tether.min.js')}}"></script>
    <script src="{{asset('backend/vendors/js/extensions/shepherd.min.js')}}"></script>
    <script src="{{asset('backend/vendors/js/tables/datatable/pdfmake.min.js')}}"></script>
    <script src="{{asset('backend/vendors/js/tables/datatable/vfs_fonts.js')}}"></script>
    <script src="{{asset('backend/vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('backend/vendors/js/tables/datatable/datatables.buttons.min.js')}}"></script>
    <script src="{{asset('backend/vendors/js/tables/datatable/buttons.html5.min.js')}}"></script>
    <script src="{{asset('backend/vendors/js/tables/datatable/buttons.print.min.js')}}"></script>
    <script src="{{asset('backend/vendors/js/tables/datatable/buttons.bootstrap.min.js')}}"></script>
    <script src="{{asset('backend/vendors/js/tables/datatable/datatables.bootstrap4.min.js')}}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{asset('backend/js/core/app-menu.js')}}"></script>
    <script src="{{asset('backend/js/core/app.js')}}"></script>
    <script src="{{asset('backend/js/scripts/components.js')}}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{asset('backend/js/scripts/datatables/datatable.js')}}"></script>
    <!-- END: Page JS-->

    {{-- Notification --}}
    @if (auth::user()->auth == "Admin")
    <script type="text/javascript">
        var data =  <?= Auth::user()->auth == 'Admin' ?>;
         $(document).on('click','#notif', function () {
                var id = $(this).attr('data-id');
                $.get(' {{Url("read-notification")}}', {'_token' : $('meta[name=csrf-token]').attr('content'),id:id}, function(resp){
                    // location.reload();
                    if (data) {
                        window.location = '/data-transaksi';
                    } 
                });
            });
    </script>
    @else
    <script type="text/javascript">
        var data =  <?= Auth::user()->auth == 'Karyawan' ?>;
         $(document).on('click','#notif', function () {
                var id = $(this).attr('data-id');
                $.get(' {{Url("read-notification")}}', {'_token' : $('meta[name=csrf-token]').attr('content'),id:id}, function(resp){
                    // location.reload();
                    if (data) {
                        window.location = '/pelayanan';
                    }
                });
            });
    </script>
    @endif
    @yield('script')
</body>
<!-- END: Body-->

</html>