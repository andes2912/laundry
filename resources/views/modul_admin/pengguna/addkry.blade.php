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
            <form action="{{route('admin.store')}}" method="POST">
                @csrf
                <div class="form-body">
                    <div class="row p-t-20">
                        <div class="col-md-4">
                            <div class="form-group has-success">
                                <label class="control-label">Nama</label>
                                <input type="text" class="form-control form-control-danger" name="name" placeholder="Nama Karyawan" autocomplete="off">
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-4">
                            <div class="form-group has-success">
                                <label class="control-label">E-mail</label>
                                <input type="email" class="form-control form-control-danger" name="email" placeholder="E-mail" autocomplete="off">
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-4">
                            <div class="form-group has-success">
                                <label class="control-label">Status</label>
                                <select class="form-control custom-select" name="status">
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
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