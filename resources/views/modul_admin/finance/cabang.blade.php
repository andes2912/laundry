@extends('layouts.admin_template')
@section('title','Admin - Data Finance')
@section('header','Data Finance')
@section('content')
@foreach ($cabang as $item)
<div class="col-lg-4 col-xl-4 col-md-4">
    <div class="card">
        <img class="card-img img-responsive" src="{{asset('asset/images/big/img1.jpg')}}" alt="Card image">
        <div class="card-img-overlay card-inverse social-profile-first bg-over">
            <img src="{{asset('asset/images/users/1.jpg')}}" class="img-circle" width="100" />
            <h4 class="card-title">John doe</h4>
        </div>
        <div class="card-body text-center">
            <div class="row">
                <div class="col">
                    <h3 class="m-b-0">{{$hitung->sum('kg')}}</h3>
                    <h5 class="font-light">Followers</h5></div>
                <div class="col">
                    <h3 class="m-b-0">420</h3>
                    <h5 class="font-light">Following</h5></div>
                <div class="col">
                    <h3 class="m-b-0">128</h3>
                    <h5 class="font-light">Tweets</h5></div>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
@section('script')
@endsection