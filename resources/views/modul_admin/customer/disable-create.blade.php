@extends('layouts.backend')
@section('title','Form Tambah Data Customer')
@section('header','Tambah Customer')
@section('content')
<div class="col-lg-12">
    <div class="card card-outline-info">
        <div class="card-header">
            <h4 class="card-title">Form Tambah Data Customer</h4>
        </div>
        <div class="card-body">
            <form action="{{url('customer-store')}}" method="POST">
                @csrf
                <div class="form-body">
                    <div class="row p-t-20">
                        <div class="col-lg-6 col-xl-6 col-12">
                            <div class="form-group has-success">
                                <label class="control-label">Nama</label>
                                <input type="text" class="form-control form-control-danger" name="nama" placeholder="Nama Customer" autocomplete="off">
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-lg-6 col-xl-6 col-12">
                            <div class="form-group has-success">
                                <label class="control-label">Alamat</label>
                                <input type="text" class="form-control form-control-danger" name="alamat" placeholder="Alamat" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!--/span-->
                        <div class="col-lg-6 col-xl-6 col-12">
                            <div class="form-group has-success">
                                <label class="control-label">No. Telp</label>
                                <input type="number" class="form-control form-control-danger" name="no_telp" placeholder="Nomor Telpon" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-6 col-12">
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
                    <input type="hidden" name="auth" value="Admin">
                    <div class="row">
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