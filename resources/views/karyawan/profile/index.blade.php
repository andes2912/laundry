@extends('layouts.karyawan_template')
@section('content')
<div class="col-lg-4 col-xlg-3 col-md-5">
    <div class="card">
        <div class="card-body">
            <center class="m-t-30"> <img src="{{asset('asset/images/users/profile.png')}}" class="img-circle" width="150" />
                <h4 class="card-title m-t-10">{{$user->name}}
                <a href="{{url('profile-karyawan/edit', auth::user()->id)}}" class="btn btn-primary btn-sm">Edit</a>
                </h4>
                <h6 class="card-subtitle">Karyawan</h6>
            </center>
        </div>
        <div>
            <hr> </div>
        <div class="card-body"> <small class="text-muted">Email address </small>
            <h6>{{$user->email}}</h6> <small class="text-muted p-t-30 db">Phone</small>
            <h6>{{$user->no_telp}}</h6> <small class="text-muted p-t-30 db">Address</small>
            <h6>{{$user->alamat}}</h6>
            {{-- <div class="map-box">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d470029.1604841957!2d72.29955005258641!3d23.019996818380896!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e848aba5bd449%3A0x4fcedd11614f6516!2sAhmedabad%2C+Gujarat!5e0!3m2!1sen!2sin!4v1493204785508" width="100%" height="150" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>  --}}
            <small class="text-muted p-t-30 db">Social Profile</small>
            <br/>
            <button class="btn btn-circle btn-secondary"><i class="fa fa-facebook"></i></button>
            <button class="btn btn-circle btn-secondary"><i class="fa fa-twitter"></i></button>
            <button class="btn btn-circle btn-secondary"><i class="fa fa-youtube"></i></button>
        </div>
    </div>
</div>

<div class="col-lg-8 col-xlg-9 col-md-7">
    <div class="card">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs profile-tab" role="tablist">
            <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home" role="tab">Coming Soon</a> </li>
            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile" role="tab">Coming Soon</a> </li>
            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#settings" role="tab">Coming Soon</a> </li>
        </ul>

        <div class="card-body">
            <h5>COMING SOON !!!</h5>
        </div>
    </div>
</div>
@endsection