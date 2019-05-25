@extends('layouts.karyawan_template')
@section('title','Tambah Customer')
@section('header','Tambah Data Customer')
@section('content')
<div class="col-lg-12">
    <div class="card card-outline-info">
        <div class="card-header">
            <h4 class="m-b-0 text-white">Form Tambah Data Customer</h4>
        </div>
        <div class="card-body">
            <form action="{{url('list-costomer-store')}}" method="POST">
                @csrf
                <div class="form-body">
                    <div class="row p-t-20">
                        <div class="col-md-6">
                            <div class="form-group has-success">
                                <label class="control-label">Nama</label>
                                <input type="text" class="form-control form-control-danger" name="nama" placeholder="Nama Customer" autocomplete="off">
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group has-success">
                                <label class="control-label">Alamat</label>
                                <input type="text" class="form-control form-control-danger" name="alamat" placeholder="Alamat" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group has-success">
                                <label class="control-label">No. Telp</label>
                                <input type="number" class="form-control form-control-danger" name="no_telp" placeholder="Nomor Telpon" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-success">
                                <label class="control-label">Gender</label>
                                <select class="form-control custom-select" name="kelamin">
                                    <option value="">-- Jenis Gender --</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!--/row-->                  
                </div>
                <input type="hidden" name="auth" value="Admin">
                <div class="form-actions">
                    <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                    <a href="{{url('list-customer')}}" class="btn btn-danger">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection