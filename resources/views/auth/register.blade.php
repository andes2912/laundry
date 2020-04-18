@extends('layouts.auth')
@section('title','Mendaftar')
@section('content')
<section class="row flexbox-container">
    <div class="col-xl-8 col-11 d-flex justify-content-center">
        <div class="card bg-authentication rounded-0 mb-0">
            <div class="row m-0">
                <div class="col-lg-6 d-lg-block d-none text-center align-self-center px-1 py-0">
                    <img src="{{asset('backend/images/pages/login.png')}}" alt="branding logo">
                </div>
                <div class="col-lg-6 col-12 p-0">
                    <div class="card rounded-0 mb-0 px-2">
                        <div class="card-header pb-1">
                            <div class="card-title">
                                <h4 class="mb-0">Mendaftar</h4>
                            </div>
                        </div>
                        <p class="px-2">Selamat Datang, Daftar Untuk Menggunakan Layanan Laundry.</p>
                        <div class="card-content">
                            <div class="card-body pt-1">
                                <form action="{{route('login')}}" method="POST">
                                    @csrf
                                    <fieldset class="form-label-group form-group position-relative has-icon-left">
                                        <input type="email" name="email" class="form-control" id="email" placeholder="E-Mail" required>
                                        <div class="form-control-position">
                                            <i class="feather icon-user"></i>
                                        </div>
                                        <label for="email">E-Mail</label>
                                    </fieldset>

                                    <fieldset class="form-label-group position-relative has-icon-left">
                                        <input type="password" name="password" class="form-control" id="user-password" placeholder="Password" required>
                                        <div class="form-control-position">
                                            <i class="feather icon-lock"></i>
                                        </div>
                                        <label for="user-password">Password</label>
                                    </fieldset>
                                    <button type="submit" class="btn btn-primary float-right btn-inline btn-block">Login</button>
                                </form>
                            </div>
                        </div>
                        <div class="login-footer">
                            <div class="divider">
                                <div class="divider-text">NOTE</div>
                            </div>
                            <p style="font-size:10px">Jika ingin mendaftar silahkan hubungi nomor ini : 0822-4888-5062</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection