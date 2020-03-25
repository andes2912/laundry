@extends('layouts.backend')
@section('title','Form Tambah Data Administrator')
@section('header','Tambah Administrator')
@section('content')
<div class="col-lg-12">
    <div class="card card-outline-info">
        <div class="card-header">
            <h4 class="card-title">Form Tambah Data Administrator</h4>
        </div>
        <div class="card-body">
            <form action="{{route('admin.store')}}" method="POST">
                @csrf
                <div class="form-body">
                    <div class="row">
                        <div class="col-lg-4 col-xl-4 col-12">
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <div class="position-relative has-icon-left">
                                    <input type="text" name="name" id="nama" class="form-control" name="fname-icon" placeholder="Nama Administrator" value="{{old('name')}}" autocomplete="off">
                                    <div class="form-control-position">
                                        <i class="feather icon-user"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-xl-4 col-12">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <div class="position-relative has-icon-left">
                                    <input type="text" name="name" id="email" class="form-control" name="fname-icon" placeholder="Email Administrator" value="{{old('email')}}" autocomplete="off">
                                    <div class="form-control-position">
                                        <i class="feather icon-mail"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-xl-4 col-12">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <div class="position-relative has-icon-left">
                                    <select class="form-control custom-select" name="status">
                                        <option value="">--Pilih Status--</option>
                                        <option value="Aktif">Aktif</option>
                                        <option value="Tidak Aktif">Tidak Aktif</option>
                                    </select>
                                    <div class="form-control-position">
                                        <i class="feather icon-status"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                      
                    <input type="hidden" name="auth" value="Admin">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                        <button type="reset" class="btn btn-outline-warning mr-1 mb-1">Reset</button>
                    </div> 
                </div>
                <!--/row-->               
                </div>
            </form>
        </div>
    </div>
</div>
@endsection