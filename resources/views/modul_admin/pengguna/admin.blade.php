@extends('layouts.backend')
@section('title','Admin - Data Administrator')
@section('header','Data Administrator')
@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                Data Administrator
            </h4>
            <div class="table-responsive">
                <table class="table zero-configuration">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>E-mail</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; ?>
                        @foreach ($adm as $item)
                        <tr>
                            <td>{{$no}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->email}}</td>
                            <td>
                                @if ($item->status == 'Aktif')
                                    <span class="label label-success">Aktif</span>
                                @else
                                    <span class="label label-danger">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                                {{-- <form action="{{ route('admin.destroy',$item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE') --}}
                                    <a href="{{route('admin.edit', $item->id)}}" class="btn btn-sm btn-info">Edit</a>
                                    {{-- <button type="submit" class="btn btn-danger btn-sm">Hapus</button> --}}
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
@endsection