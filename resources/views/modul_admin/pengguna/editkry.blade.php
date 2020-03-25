@extends('layouts.backend')
@section('title','Form Edit Data Karyawan')
@section('header','Edit Karyawan')
@section('content')
<div class="col-lg-12">
    <div class="card card-outline-info">
        <div class="card-header">
            <h4 class="card-title">Form Edit Data Karyawan</h4>
        </div>
        <div class="card-body">
            <form action="{{route('admin.update', $edit->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-body">
                    <div class="row p-t-20">
                        <div class="col-md-4">
                            <div class="form-group has-success">
                                <label class="control-label">Nama</label>
                                <input type="text" class="form-control form-control-danger" name="name" value="{{$edit->name}}" placeholder="Nama Karyawan" autocomplete="off">
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-4">
                            <div class="form-group has-success">
                                <label class="control-label">E-mail</label>
                                <input type="email" class="form-control form-control-danger" name="email" value="{{$edit->email}}" placeholder="E-mail" autocomplete="off">
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-4">
                            <div class="form-group has-success">
                                <label class="control-label">Status</label>
                                <select class="form-control custom-select" name="status">
                                    <option value="Aktif"@if($edit->status=='Aktif') selected='selected' @endif >Aktif</option>
                                    <option value="Tidak Aktif"@if($edit->status=='Tidak Aktif') selected='selected' @endif >Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row p-t-20">
                        <div class="col-md-4">
                            <div class="form-group has-success">
                                <label class="control-label">Nama Cabang :</label>
                                <input type="text" class="form-control form-control-danger" name="nama_cabang" value="{{$edit->nama_cabang}}" placeholder="Nama Cabang" autocomplete="off">
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-4">
                            <div class="form-group has-success">
                                <label class="control-label">Alamat Cabang</label>
                                <input type="text" class="form-control form-control-danger" name="alamat_cabang" value="{{$edit->alamat}}" placeholder="Alamat" autocomplete="off">
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-4">
                            <div class="form-group has-success">
                                <label class="control-label">No. Telp</label>
                                <input type="number" class="form-control form-control-danger" name="no_telp" value="{{$edit->no_telp}}" placeholder="Nomor Telpon" autocomplete="off">
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