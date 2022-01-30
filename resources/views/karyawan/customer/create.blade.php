@extends('layouts.backend')
@section('title','Tambah Customer')
@section('header','Tambah Data Customer')
@section('content')
<div class="col-lg-12">
    <div class="card card-outline-info">
        <div class="card-header">
            <h4 class="card-title">Form Tambah Data Customer</h4>
        </div>
        <div class="card-body">
            <form action="{{url('customers-store')}}" method="POST">
                @csrf
                <div class="form-body">
                    <div class="row p-t-20">
                        <div class="col-md-4">
                            <div class="form-group has-success">
                                <label class="control-label">Nama</label>
                                <input type="text" class="form-control form-control-danger @error('nama') is-invalid @enderror" name="nama" value="{{old('nama')}}" placeholder="Nama Customer" autocomplete="off">
                                @error('nama')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-4">
                            <div class="form-group has-success">
                                <label class="control-label">Email</label>
                                <input type="email" class="form-control form-control-danger @error('email_customer') is-invalid @enderror" name="email_customer" value="{{old('email_customer')}}" placeholder="Alamat Email" autocomplete="off">
                                @error('email_customer')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group has-success">
                                <label class="control-label">No. WhatsApp</label>
                                <input type="number" class="form-control form-control-danger @error('no_telp') is-invalid @enderror" name="no_telp" placeholder="Nomor WhatsApp" value="{{old('no_telp')}}" autocomplete="off">
                                @error('no_telp')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group has-success">
                                <label class="control-label">Alamat</label>
                                <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3" placeholder="Alamat Customer"> {{old('alamat')}} </textarea>
                                @error('alamat')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group has-success">
                                <label class="control-label">Gender</label>
                                <select class="form-control custom-select @error('kelamin') is-invalid @enderror" name="kelamin">
                                    <option value="">-- Jenis Gender --</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                                @error('kelamin')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!--/row-->
                </div>
                <input type="hidden" name="auth" value="Admin">
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary mr-1 mb-1">Tambah</button>
                    <a href=" {{url('customers')}}"  class="btn btn-outline-warning mr-1 mb-1">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection