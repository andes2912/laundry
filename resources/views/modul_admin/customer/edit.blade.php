@extends('layouts.backend')
@section('title','Form Edit Data Customer')
@section('header','Edit Customer')
@section('content')
<div class="col-lg-12">
    <div class="card card-outline-info">
        <div class="card-header">
            <h4 class="m-b-0 text-white">Form Edit Data Customer</h4>
        </div>
        <div class="card-body">
            <form action="{{url('customer-update', $edit->id_customer)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-body">
                    <div class="row p-t-20">
                        <div class="col-md-6">
                            <div class="form-group has-success">
                                <label class="control-label">Nama</label>
                                <input type="text" class="form-control form-control-danger" name="nama" placeholder="Nama Customer" value="{{$edit->nama}}" autocomplete="off">
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group has-success">
                                <label class="control-label">Alamat</label>
                                <input type="text" class="form-control form-control-danger" name="alamat" placeholder="Alamat" value="{{$edit->alamat}}" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group has-success">
                                <label class="control-label">No. Telp</label>
                                <input type="number" class="form-control form-control-danger" name="no_telp" placeholder="Nomor Telpon" value="{{$edit->no_telp}}" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-success">
                                <label class="control-label">Gender</label>
                                <select class="form-control custom-select" name="kelamin">
                                    <option value="L"@if($edit->kelamin=='L') selected='selected' @endif >Laki-laki</option>
                                    <option value="P"@if($edit->kelamin=='P') selected='selected' @endif >Perempuan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!--/row-->                  
                </div>
                <input type="hidden" name="auth" value="Admin">
                <div class="form-actions">
                    <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                    <a href="{{url('customer')}}" class="btn btn-danger">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection