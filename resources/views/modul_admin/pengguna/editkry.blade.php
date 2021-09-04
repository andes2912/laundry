@extends('layouts.backend')
@section('title','Form Edit Data Karyawan')
@section('header','Edit Karyawan')
@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card card-outline-info">
        <div class="card-header">
            <h4 class="card-title">Form Edit Data Karyawan</h4>
        </div>
        <div class="card-body">
            <form action="{{route('karyawan.update', $edit->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-body">
                  <div class="row">
                    <div class="col-lg-4 col-xl-4 col-12">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <div class="position-relative">
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nama" value="{{$edit->name}}" disabled>
                                @error('name')
                                  <span class="invalid-feedback" role="alert">
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
                                <input type="email" name="email" id="email-id-icon" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{$edit->email}}" disabled>
                                @error('email')
                                  <span class="invalid-feedback" role="alert">
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
                                <input type="text" name="nama_cabang" id="nama-cabang" class="form-control  @error('nama_cabang') is-invalid @enderror" placeholder="Nama Cabang" value="{{$edit->nama_cabang}}" disabled>
                                @error('nama_cabang')
                                  <span class="invalid-feedback" role="alert">
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
                                <input type="number" name="no_telp" id="no-telp-cabang" class="form-control @error('no_telp') is-invalid @enderror" value="{{$edit->no_telp}}" disabled>
                                @error('no_telp')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xl-4 col-12">
                        <div class="form-group">
                            <label for="no-telp-cabang">Status Karyawan</label>
                            <div class="position-relative">
                                <select name="status" class="form-control">
                                  <option value="">Pilih Status</option>
                                  <option value="Active" {{$edit->status == 'Active' ? 'selected' :''}} >Aktif</option>
                                  <option value="Not Active" {{$edit->status == 'Not Active' ? 'selected' :''}}>Tidak Aktif</option>
                                </select>
                                @error('no_telp')
                                  <span class="invalid-feedback" role="alert">
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
                                <textarea type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror" id="alamat-karyawan" rows="3" disabled> {{$edit->alamat}} </textarea>
                                @error('alamat')
                                  <span class="invalid-feedback" role="alert">
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
                                <textarea type="text" name="alamat_cabang" class="form-control @error('alamat_cabang') is-invalid @enderror" id="alamat-laundry" rows="3" disabled> {{$edit->alamat_cabang}} </textarea>
                                @error('alamat_cabang')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                  </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-success"> Update</button>
                    <a href="{{route('karyawan.index')}}" class="btn btn-danger">Cancel</a>
                </div>
            </form>
        </div>
    </div>
  </div>
</div>
@endsection