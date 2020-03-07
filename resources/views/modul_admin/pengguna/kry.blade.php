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
            
            <div class="table-responsive m-t-0">
                <table id="myTable" class="table display table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Karyawan</th>
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
                            <td>{{$item->alamat_cabang}}</td>
                            <td>{{$item->nama_cabang}}</td>
                            <td>{{$item->no_telp}}</td>
                            <td>
                                @if ($item->status == 'Aktif')
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
@section('script')
<script type="text/javascript">
$(document).ready(function() {
    $('#myTable').DataTable();
    $(document).ready(function() {
        var table = $('#example').DataTable({
            "columnDefs": [{
                "visible": false,
                "targets": 2
            }],
            "order": [
                [2, 'asc']
            ],
            "displayLength": 25,
            "drawCallback": function(settings) {
                var api = this.api();
                var rows = api.rows({
                    page: 'current'
                }).nodes();
                var last = null;
                api.column(2, {
                    page: 'current'
                }).data().each(function(group, i) {
                    if (last !== group) {
                        $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                        last = group;
                    }
                });
            }
        });
    });
});
</script>
@endsection