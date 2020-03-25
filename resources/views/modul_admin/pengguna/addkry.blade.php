@extends('layouts.backend')
@section('title','Form Tambah Data Karyawan')
@section('header','Tambah Karyawan')
@section('content')
<div class="col-md-12 col-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Form Tambah Data Karyawan</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                @error('errors')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <form action="{{route('admin.store')}}" method="POST" class="form form-vertical">
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-lg-4 col-xl-4 col-12">
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <div class="position-relative has-icon-left">
                                        <input type="text" name="name" id="nama" class="form-control" name="fname-icon" placeholder="Nama" value="{{old('name')}}">
                                        <div class="form-control-position">
                                            <i class="feather icon-user"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-4 col-12">
                                <div class="form-group">
                                    <label for="email-id-icon">Email</label>
                                    <div class="position-relative has-icon-left">
                                        <input type="email" name="email" id="email-id-icon" class="form-control" name="email-id-icon" placeholder="Email" value="{{old('email')}}">
                                        <div class="form-control-position">
                                            <i class="feather icon-mail"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-4 col-12">
                                <div class="form-group">
                                    <label for="nama-cabang">Nama Cabang</label>
                                    <div class="position-relative has-icon-left">
                                        <input type="text" name="nama_cabang" id="nama-cabang" class="form-control" name="contact-icon" placeholder="Nama Cabang" value="{{old('nama_cabang')}}">
                                        <div class="form-control-position">
                                            <i class="feather icon-smartphone"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-4 col-12">
                                <div class="form-group">
                                    <label for="alamat-karyawan">Alamat Karyawan</label>
                                    <div class="position-relative has-icon-left">
                                       <textarea type="text" name="alamat" class="form-control" id="alamat-karyawan" rows="3" value="{{old('alamat')}}"></textarea>
                                        <div class="form-control-position">
                                            <i class="feather icon-user"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-4 col-12">
                                <div class="form-group">
                                    <label for="alamat-laundry">Alamat Laundry</label>
                                    <div class="position-relative has-icon-left">
                                        <textarea type="text" name="alamat_cabang" class="form-control" id="alamat-laundry" rows="3" value="{{old('alamat_cabang')}}"></textarea>
                                        <div class="form-control-position">
                                            <i class="feather icon-mail"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-4 col-12">
                                <div class="form-group">
                                    <label for="no-telp-cabang">No. Telp Cabang</label>
                                    <div class="position-relative has-icon-left">
                                        <input type="number" name="no_telp" id="no-telp-cabang" class="form-control" name="contact-icon" placeholder="No. Telp Cabang" value="{{old('no_telp')}}">
                                        <div class="form-control-position">
                                            <i class="feather icon-smartphone"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="auth" value="Karyawan">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                                <button type="reset" class="btn btn-outline-warning mr-1 mb-1">Reset</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection