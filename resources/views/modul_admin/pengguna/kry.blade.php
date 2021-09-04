@extends('layouts.backend')
@section('title','Admin - Data Karyawan')
@section('header','Data Karyawan')
@section('content')
@if ($message = Session::get('success'))
  <div class="alert alert-success alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
  </div>
@elseif($message = Session::get('error'))
  <div class="alert alert-danger alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
  </div>
@endif
<div class="row">
  <div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title"> Data Karyawan / Cabang
                <a href="{{route('karyawan.create')}}" class="btn btn-primary">Tambah</a>
            </h4>

            <div class="table-responsive">
                <table class="table zero-configuration">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Karyawan</th>
                            <th>Email</th>
                            <th>Alamat Cabang</th>
                            <th>Nama Cabang</th>
                            <th>No Telp</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; ?>
                        @foreach ($kry as $item)
                        <tr>
                            <td>{{$no}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->email}}</td>
                            <td>{{$item->alamat_cabang}}</td>
                            <td>{{$item->nama_cabang}}</td>
                            <td>{{$item->no_telp}}</td>
                            <td>
                                @if ($item->status == 'Active')
                                    <span class="label label-success">Aktif</span>
                                @else
                                    <span class="label label-danger">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                              <form action="{{ route('karyawan.destroy',$item->id) }}" method="POST">
                                  @csrf
                                  @method('DELETE')
                                  <a href="{{route('karyawan.edit', $item->id)}}" class="btn btn-sm btn-info">Edit</a>
                                  <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                              </form>
                            </td>
                        </tr>
                        <?php $no++; ?>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  </div>
</div>
@endsection