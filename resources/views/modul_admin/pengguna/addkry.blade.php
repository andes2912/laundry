@extends('layouts.admin_template')
@section('title','Form Tambah Data Karyawan')
@section('header','Tambah Karyawan')
@section('content')
<div class="col-lg-12">
    <div class="card card-outline-info">
        <div class="card-header">
            <h4 class="m-b-0 text-white">Form Tambah Data Karyawan</h4>
        </div>
        <div class="card-body">
            @error('errors')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <form action="{{route('admin.store')}}" method="POST">
                @csrf
                <div class="form-body">
                    <div class="row p-t-20">
                        <div class="col-md-4">
                            <div class="form-group has-success">
                                <label class="control-label">Nama</label>
                                <input type="text" class="form-control form-control-danger" name="name" value="{{old('name')}}" placeholder="Nama Karyawan" autocomplete="off">
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-4">
                            <div class="form-group has-success">
                                <label class="control-label">E-mail</label>
                                <input type="email" class="form-control form-control-danger" name="email" value="{{old('email')}}" placeholder="E-mail" autocomplete="off">
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-4">
                            <div class="form-group has-success">
                                <label class="control-label">Nama Cabang :</label>
                                <input type="text" class="form-control form-control-danger" name="nama_cabang" value="{{old('nama_cabang')}}" placeholder="Nama Cabang" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="row p-t-20">
                        
                        <!--/span-->
                        <div class="col-md-4">
                            <div class="form-group has-success">
                                <label class="control-label">Alamat Karyawan</label>
                                <textarea name="alamat" value="{{old('alamat')}}" class="form-control" rows="3" placeholder="Tulis Alamat Karyawan"></textarea>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group has-success">
                                <label class="control-label">Alamat Laundry</label>
                                <textarea name="alamat_cabang" value="{{old('alamat_cabang')}}" class="form-control" rows="3" placeholder="Tulis Alamat Laundry"></textarea>
                            </div>
                        </div>

                        <!--/span-->
                        <div class="col-md-4">
                            <div class="form-group has-success">
                                <label class="control-label">No. Telp Cabang</label>
                                <input type="number" class="form-control form-control-danger" name="no_telp" value="{{old('no_telp')}}" placeholder="Nomor Telpon" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <!--/row-->                  
                </div>
                <input type="hidden" name="auth" value="Karyawan">
                <div class="form-actions">
                    <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                    <a href="{{url('kry')}}" class="btn btn-danger">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection