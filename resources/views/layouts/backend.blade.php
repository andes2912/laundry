<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="E-Laundy aplikasi laundry berbasis website">
    <meta name="keywords" content="E-Laundry,Laundry">
    <meta name="author" content="Andri Desmana">
    <title>@yield('title')</title>
    <link rel="apple-touch-icon" href="{{asset('backend/images/ico/apple-icon-120.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('backend/images/ico/favicon.ico')}}">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('backend/vendors/css/vendors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/vendors/css/extensions/tether.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/vendors/css/extensions/shepherd-theme-default.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/vendors/css/charts/apexcharts.css')}}">
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
    <link rel="stylesheet" type="text/css" href="{{asset('backend/css/pages/page-knowledge-base.css')}}">


    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern  {{Auth::user()->theme == 1 ? 'dark-layout' : ''}} content-left-sidebar chat-application navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="content-left-sidebar" data-layout="dark-layout">

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
                        <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon feather icon-bell"></i><span class="badge badge-pill badge-primary badge-up">{{count(getNotifikasi(Auth::id()))}}</span></a>
                            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                                <li class="dropdown-menu-header">
                                    <div class="dropdown-header m-0 p-2">
                                        <h3 class="white"></h3><span class="notification-title">Notifications</span>
                                    </div>
                                </li>
                                <li class="scrollable-container media-list">
                                    @forelse (getNotifikasi(Auth::id()) as $notifikasis)
                                        <a data-id-notif="{{$notifikasis->id}}" id="readNotif">
                                            <div class="media d-flex align-items-start">
                                                <div class="media-body">
                                                    <p class="media-heading"><span class="font-weight-bolder">{{$notifikasis->title}} 🎉</span></p><small class="notification-text"> {{$notifikasis->body}}.</small>
                                                </div>
                                            </div>
                                        </a>
                                    @empty
                                        <div class="media d-flex align-items-start">
                                            <div class="media-body">
                                                <p class="media-heading"><span class="font-weight-bolder">Belum ada Notifikasi disini.</span></p>
                                                <small class="notification-text"> Notifikasi akan muncul disini ketika sudah tersedia.</small>
                                            </div>
                                        </div>
                                    @endforelse
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-user nav-item">
                          <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                            <div class="user-nav d-sm-flex d-none">
                              <span class="user-name text-bold-600">{{auth::user()->name}}</span>
                              <span class="user-status">{{auth::user()->auth}}</span>
                            </div>
                            <span>
                              <img class="round" src="{{asset(Auth::user()->foto == null ? 'backend/images/profile/user.jpg' : 'storage/images/foto_profile/'. Auth::user()->foto )}}" alt="avatar" height="40" width="40">
                            </span>
                          </a>
                          <div class="dropdown-menu dropdown-menu-right">
                            @if (auth::user()->auth == 'Admin')
                              <a class="dropdown-item" href="{{url('profile-admin', auth::user()->id )}}"><i class="feather icon-user"></i>Profile
                              </a>
                            @elseif(auth::user()->auth == 'Karyawan')
                              <a class="dropdown-item" href="{{url('profile-karyawan', auth::user()->id )}}"><i class="feather icon-user"></i>Profile
                              </a>
                              <a class="dropdown-item" href="{{url('karyawan-setting' )}}"><i class="feather icon-settings"></i>Settings
                              </a>
                            @elseif(auth::user()->auth == 'Customer')
                              <a class="dropdown-item" href=" {{url('me')}} "><i class="feather icon-user"></i>Profile
                              </a>
                              <a class="dropdown-item" href="{{Route('customer.setting')}}"><i class="feather icon-settings"></i>Settings
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
                <li class="nav-item {{ (request()->is('home')) ? 'active' : '' }}"><a href="{{url('home')}}"><i class="feather icon-home"></i><span class="menu-title" data-i18n="Dashboard">Dashboard</span></a>
                </li>

                {{-- Menu Admin --}}
                    @if (auth::user()->auth == "Admin")
                        <li class=" nav-item"><a href="#"><i class="feather icon-users"></i><span class="menu-title" data-i18n="User">Data User</span></a>
                            <ul class="menu-content">
                              <li class="nav-item {{ (request()->is('karyawan')) ? 'active' : '' }}">
                                <a href="{{route('karyawan.index')}}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="View">Karyawan</span></a>
                              </li>
                              <li class="nav-item {{ (request()->is('customer')) ? 'active' : '' }}">
                                <a href="{{url('customer')}}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="List">Customer</span></a>
                              </li>
                            </ul>
                        </li>

                        <li class="nav-item {{ (request()->is('transaksi')) ? 'active' : '' }}">
                          <a href="{{route('transaksi.index')}}"><i class="feather icon-shopping-cart"></i><span class="menu-item" data-i18n="List">Transaksi</span></a>
                        </li>


                        <li class=" nav-item"><a href="#"><i class="feather icon-credit-card"></i><span class="menu-title" data-i18n="User">Data Finance</span></a>
                          <ul class="menu-content">
                            <li class="nav-item {{ (request()->is('finance')) ? 'active' : '' }}">
                              <a href="{{route('finance.index')}}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="List">Finance</span></a>
                            </li>
                            <li class="nav-item {{ (request()->is('data-harga')) ? 'active' : '' }}">
                              <a href="{{url('data-harga')}}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="List">Harga Laundry</span></a>
                            </li>
                          </ul>
                        </li>

                        <li class=" nav-item"><a href="#"><i class="feather icon-settings"></i><span class="menu-title" data-i18n="User">Other</span></a>
                          <ul class="menu-content">
                            <li class="nav-item {{ (request()->is('settings')) ? 'active' : '' }}">
                              <a href="{{url('settings')}}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="List">Setting</span></a>
                            </li>
                          </ul>
                        </li>

                        <li class="nav-item {{ (request()->is('dokumentasi')) ? 'active' : '' }}">
                          <a href="{{url('dokumentasi')}}"><i class="feather icon-folder"></i><span class="menu-item" data-i18n="List">Dokumentasi</span></a>
                        </li>
                    {{-- End Menu Admin --}}

                    {{-- Menu Karyawan --}}
                    @elseif(auth::user()->auth == "Karyawan")
                      <li class=" nav-item"><a href="#"><i class="feather icon-layers"></i><span class="menu-title" data-i18n="User">Data Transaksi</span></a>
                          <ul class="menu-content">
                              <li class="nav-item {{ (request()->is('pelayanan')) ? 'active' : '' }}">
                                <a href="{{route('pelayanan.index')}}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="List">Order Masuk</span></a>
                              </li>
                              <li class="nav-item {{ (request()->is('add-order')) ? 'active' : '' }}">
                                <a href="{{url('add-order')}}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="List">Tambah Order</span></a>
                              </li>
                              <li class="nav-item {{ (request()->is('customers')) ? 'active' : '' }}">
                                <a href="{{url('customers')}}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="List">Data Customer</span></a>
                              </li>
                          </ul>
                      </li>
                      <li class="nav-item"><a href="{{url('/laporan')}}"><i class="feather icon-file-text"></i><span class="menu-title" data-i18n="Dashboard">Laporan</span></a>
                      </li>
                      <li class="nav-item"><a href="{{url('/')}}" target="_blank"><i class="feather icon-square"></i><span class="menu-title" data-i18n="Dashboard">Frontend</span></a>
                      </li>

                    {{-- Menu Customer --}}
                    @elseif(Auth::user()->auth == 'Customer')

                      <li class="nav-item"><a href="{{url('/')}}" target="_blank"><i class="feather icon-square"></i><span class="menu-title" data-i18n="Dashboard">Frontend</span></a>
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
        <p class="clearfix blue-grey lighten-2 mb-0"><span class="float-md-left d-block d-md-inline-block mt-25">COPYRIGHT &copy; 2020 - {{date('Y')}}<a class="text-bold-800 grey darken-2" href="https://andridesmana.space" target="_blank">Andri Desmana,</a>All rights Reserved</span><span class="float-md-right d-none d-md-block">Build With <i class="feather icon-heart pink"></i></span>
            <button class="btn btn-primary btn-icon scroll-top" type="button"><i class="feather icon-arrow-up"></i></button>
        </p>
    </footer>
    <!-- END: Footer-->


    <!-- BEGIN: Vendor JS-->
    <script src="{{asset('backend/vendors/js/vendors.js')}}"></script>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/1.9.46/autoNumeric.js"></script>
    <script src="{{asset('backend/js/scripts/pages/page-knowledge-base.js')}}"></script>
    <!-- END: Page JS-->

    <script type="text/javascript">
        // Read Notifikasi
        $(document).on('click', '#readNotif', function () {
            var id = $(this).attr('data-id-notif');
            $.get('read-notifikasi', {'_token' : $('meta[name=csrf-token]').attr('content'),id:id}, function(_resp){
                location.reload()
            });
        });
    </script>
    @yield('scripts')
</body>
<!-- END: Body-->

</html>
