@extends('layouts.admin_template')
@section('title','Admin - Data Karyawan')
@section('header','Data Karyawan')
@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{url('kry-add')}}" class="btn btn-sm btn-primary">Tambah</a>
            </h4>
            
            <div class="table-responsive full-color-table full-inverse-table hover-table">
                <table class="table color-table info-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>E-mail</th>
                            <th>Alamat</th>
                            <th>Cabang</th>
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
                            <td>{{$item->alamat}}</td>
                            <td>{{$item->nama_cabang}}</td>
                            <td>{{$item->no_telp}}</td>
                            <td>
                                @if ($item->status == 1)
                                    <span class="label label-success">Aktif</span>
                                @else
                                    <span class="label label-danger">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('admin.destroy',$item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{route('admin.edit', $item->id)}}" class="btn btn-sm btn-info">Edit</a>
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
@endsection