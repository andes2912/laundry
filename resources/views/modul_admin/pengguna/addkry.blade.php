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
                <form action="{{route('karyawan.store')}}" method="POST" class="form form-vertical">
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-lg-4 col-xl-4 col-12">
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <div class="position-relative">
                                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nama" value="{{old('name')}}">
                                        @error('name')
                                          <span class="invalid-feedback text-danger" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-4 col-12">
                                <div class="form-group">
                                    <label for="email-id-icon">Email</label>
                                    <div class="position-relative">
                                        <input type="email" name="email" id="email-id-icon" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{old('email')}}">
                                        @error('email')
                                          <span class="invalid-feedback text-danger" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-4 col-12">
                                <div class="form-group">
                                    <label for="nama-cabang">Nama Cabang</label>
                                    <div class="position-relative">
                                        <input type="text" name="nama_cabang" id="nama-cabang" class="form-control  @error('nama_cabang') is-invalid @enderror" placeholder="Nama Cabang" value="{{old('nama_cabang')}}">
                                        @error('nama_cabang')
                                          <span class="invalid-feedback text-danger" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-xl-4 col-12">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <div class="position-relative">
                                        <input type="password" name="password" id="password" class="form-control  @error('password') is-invalid @enderror" placeholder="Password">
                                        @error('password')
                                          <span class="invalid-feedback text-danger text-danger" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-xl-4 col-12">
                                <div class="form-group">
                                    <label for="confirm-password">Konfirmasi Password</label>
                                    <div class="position-relative">
                                        <input type="password" name="password_confirmation" id="confirm-password" class="form-control  @error('password_confirmation') is-invalid @enderror" placeholder="Konfirmasi Password">
                                        @error('password_confirmation')
                                          <span class="invalid-feedback text-danger" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-xl-4 col-12">
                                <div class="form-group">
                                    <label for="no-telp-cabang">No. Telp Cabang</label>
                                    <div class="position-relative">
                                        <input type="number" name="no_telp" id="no-telp-cabang" class="form-control @error('no_telp') is-invalid @enderror" placeholder="No. Telp Cabang" value="{{old('no_telp')}}">
                                        @error('no_telp')
                                          <span class="invalid-feedback text-danger" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-xl-6 col-12">
                                <div class="form-group">
                                    <label for="alamat-karyawan">Alamat Karyawan</label>
                                    <div class="position-relative">
                                       <textarea type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror" id="alamat-karyawan" rows="3"> {{old('alamat')}} </textarea>
                                       @error('alamat')
                                          <span class="invalid-feedback text-danger" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-6 col-12">
                                <div class="form-group">
                                    <label for="alamat-laundry">Alamat Laundry</label>
                                    <div class="position-relative">
                                        <textarea type="text" name="alamat_cabang" class="form-control @error('alamat_cabang') is-invalid @enderror" id="alamat-laundry" rows="3">{{old('alamat_cabang')}}</textarea>
                                        @error('alamat_cabang')
                                          <span class="invalid-feedback text-danger" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                              <button type="submit" class="btn btn-primary mr-1 mb-1">Tambah</button>
                              <a href=" {{route('karyawan.index')}} " class="btn btn-outline-warning mr-1 mb-1">Batal</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection