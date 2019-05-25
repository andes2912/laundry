@extends('layouts.admin_template')
@section('title','Admin - Data Customer')
@section('header','Data Customer')
@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{url('customer-add')}}" class="btn btn-sm btn-primary">Tambah</a>
            </h4>
            
            <div class="table-responsive full-color-table full-inverse-table hover-table">
                <table class="table color-table info-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>No Telpon</th>
                            <th>Kelamin</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; ?>
                        @foreach ($customer as $item)
                        <tr>
                            <td>{{$no}}</td>
                            <td>{{$item->nama}}</td>
                            <td>{{$item->alamat}}</td>
                            <td>{{$item->no_telp}}</td>
                            <td>
                                @if ($item->kelamin == 'L')
                                    <span class="label label-success">Laki-laki</span>
                                @else
                                    <span class="label label-info">Perempuan</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{url('customer-delete', $item->id_customer)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    {{-- <a href="" class="btn btn-sm btn-primary">Add Order</a> --}}
                                    <a href="{{url('customer-edit', $item->id_customer)}}" class="btn btn-sm btn-info">Edit</a>
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