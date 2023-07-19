@extends('layouts.auth')
@section('title','Masuk')
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
                            @if($message = Session::get('error'))
                              <div class="alert alert-danger alert-block">
                                <strong>{{ $message }}</strong>
                              </div>
                            @endif
                            <div class="card-title">
                                <h4 class="mb-0">Masuk</h4>
                            </div>
                        </div>
                        <p class="px-2">Selamat Datang, Masuk Menggunakan Akun Kamu.</p>
                        <div class="card-content">
                            <div class="card-body pt-1">
                                <form action="{{route('login')}}" method="POST">
                                    @csrf
                                    <fieldset class="form-label-group form-group position-relative has-icon-left">
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="E-Mail" value="{{ old('email') }}">
                                        @error('email')
                                          <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                          </span>
                                        @enderror
                                        <div class="form-control-position">
                                            <i class="feather icon-user"></i>
                                        </div>
                                        <label for="email">E-Mail</label>
                                    </fieldset>

                                    <fieldset class="form-label-group position-relative has-icon-left">
                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="user-password" placeholder="Password">
                                        @error('password')
                                          <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                          </span>
                                        @enderror
                                        <div class="form-control-position">
                                            <i class="feather icon-lock"></i>
                                        </div>
                                        <label for="user-password">Password</label>
                                    </fieldset>
                                    <button type="submit" class="btn btn-primary float-right btn-inline btn-block">Login</button>
                                </form>
                            </div>
                        </div>
                        <span class="mt-1 ml-2" style="text-align: left"><a href=" {{route('password.request')}} ">Lupa Password ?</a></span>
                        <div class="login-footer">
                            <div class="divider">
                                <div class="divider-text"><a href="/">E-Laundry</a></div>
                            </div>
                            <p style="font-size:10px;text-align:center">Build With <i class="feather icon-heart text-danger"></i> by <a href="https://andridesmana.space" target="_blank">Andri Desmana</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
