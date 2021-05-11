@extends('layouts.backend')
@section('title','Profile')
@section('content')
<div class="row">
    <div class="col-lg-4 col-xlg-3 col-md-5">
        <div class="card">
            <div class="card-body">
                <div class="col text-center">
                    <div class="m-t-30"> <img src="{{asset('backend/images/profile/user.jpg')}}" class="rounded" width="230" />
                        <h4 class="card-title m-t-10">{{$user->name}}
                        </h4>
                        <h6 class="card-subtitle">Karyawan</h6>
                    </div>
                </div>
            </div>
            <div>
              <hr>
            </div>

            <div class="card-body"> <small class="text-muted">Email address </small>
                <h6>{{$user->email}}</h6> <small class="text-muted p-t-30 db">Phone</small>
                <h6>{{$user->no_telp}}</h6> <small class="text-muted p-t-30 db">Address</small>
                <h6>{{$user->alamat}}</h6>
                <small class="text-muted p-t-30 db">Social Profile</small>
                <br/>
                <button class="btn btn-circle btn-secondary"><i class="fa fa-facebook"></i></button>
                <button class="btn btn-circle btn-secondary"><i class="fa fa-twitter"></i></button>
                <button class="btn btn-circle btn-secondary"><i class="fa fa-youtube"></i></button>

                <div class="d-flex justify-content-between">
              <a href="{{url('profile-karyawan/edit', Auth::user()->id)}}" class="btn btn-primary mt-2">Edit</a>
              <a href="" id="reset_password" data-id="{{$user->id}}" class="btn btn-warning mt-2">Reset Password</a>
            </div>
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
</div>
@endsection
@section('scripts')
    <script>
        $(document).on('click','#reset_password', function () {
            var id = $(this).attr('data-id');
            $.get(' {{Url("reset-password")}}', {'_token' : $('meta[name=csrf-token]').attr('content'),id:id}, function(resp){
                location.reload();
            });
        });
    </script>
@endsection