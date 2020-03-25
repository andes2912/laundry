@extends('layouts.backend')
@section('title','Form Edit Data Administrator')
@section('header','Edit Administrator')
@section('content')
<div class="col-lg-12">
    <div class="card card-outline-info">
        <div class="card-header">
            <h4 class="card-title">Form Edit Data Administrator</h4>
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
                                <input type="text" class="form-control form-control-danger" name="name" value="{{$edit->name}}" placeholder="Nama Administrator" autocomplete="off">
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
                                    <option value="1"@if($edit->status=='1') selected='selected' @endif >Aktif</option>
                                    <option value="0"@if($edit->status=='0') selected='selected' @endif >Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!--/row-->                  
                </div>
                <input type="hidden" name="auth" value="Admin">
                <div class="form-actions">
                    <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                    <a href="{{url('adm')}}" class="btn btn-danger">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection