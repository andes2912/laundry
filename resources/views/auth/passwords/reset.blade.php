<!DOCTYPE html>
<html class="loading dark-layout" lang="en" data-layout="dark-layout" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="E-Laundy aplikasi laundry berbasis website">
    <meta name="keywords" content="E-Laundry,Laundry">
    <meta name="author" content="Andri Desmana">
    <title>Reset Password</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('backend/vendors/css/vendors.min.css')}}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('backend/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/css/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/css/colors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/css/components.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/css/themes/dark-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/css/themes/semi-dark-layout.css')}}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('backend/css/core/menu/menu-types/horizontal-menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/css/pages/page-auth.css')}}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="horizontal-layout horizontal-menu blank-page navbar-floating footer-static  " data-open="hover" data-menu="horizontal-menu" data-col="blank-page">
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="auth-wrapper auth-v1 px-2">
                    <div class="auth-inner py-2">
                        <!-- Reset Password v1 -->
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="javascript:void(0);" class="brand-logo">
                                    <h2 class="brand-text text-primary ml-1">E-Laundry</h2>
                                </a>

                                <h4 class="card-title mb-1">Reset Password 🔒</h4>
                                <p class="card-text mb-2">Kata sandi baru Anda harus berbeda dari kata sandi yang digunakan sebelumnya</p>

                                <form class="auth-reset-password-form mt-2" action="{{route('password.update')}}" method="POST">
                                  @csrf
                                  <input type="hidden" name="token" value="{{ $token }}">
                                    <div class="form-group">
                                        <div class="d-flex justify-content-between">
                                            <label for="password">Email</label>
                                        </div>
                                        <div class="input-group input-group-merge">
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" value=" {{ $email ?? old('email') }} " id="email" name="email"/>

                                            <div class="input-group-append">
                                                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                            </div>
                                             @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="d-flex justify-content-between">
                                            <label for="password">Password Baru</label>
                                        </div>
                                        <div class="input-group input-group-merge">
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"/>

                                            <div class="input-group-append">
                                                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                            </div>
                                             @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="d-flex justify-content-between">
                                            <label for="reset-password-confirm">Konfirmasi Password Baru</label>
                                        </div>
                                        <div class="input-group input-group-merge">
                                            <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" />
                                            <div class="input-group-append">
                                                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                            </div>
                                            @error('password_confirmation')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block" >Buat Password Baru</button>
                                </form>

                                <p class="text-center mt-2">
                                    <a href="/login"> <i data-feather="chevron-left"></i> Kembali ke login </a>
                                </p>
                            </div>
                        </div>
                        <!-- /Reset Password v1 -->
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- END: Content-->


    <!-- BEGIN: Vendor JS-->
    <script src="{{asset('backend/vendors/js/vendors.js')}}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{asset('backend/vendors/js/ui/jquery.sticky.js')}}"></script>
    <script src="{{asset('backend/vendors/js/forms/validation/jquery.validate.min.js')}}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{asset('backend/js/core/app-menu.js')}}"></script>
    <script src="{{asset('backend/js/core/app.js')}}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{asset('backend/js/scripts/pages/page-auth-reset-password.js')}}"></script>
    <!-- END: Page JS-->

    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
    </script>
</body>
<!-- END: Body-->

</html>