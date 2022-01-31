@extends('layouts.backend')
@section('title','Admin - Data Customer')
@section('header','Data Customer')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"> Data Customer
                    {{-- <a href="{{url('customer-add')}}" class="btn btn-primary">Tambah</a> --}}
                </h4>

                <div class="table-responsive m-t-0">
                    <table id="myTable" class="table display table-bordered table-striped">
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
                                <td>{{$item->name}}</td>
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
                                  <a href="{{route('customer.show', $item->id)}}" class="btn btn-info btn-sm">Info</a>
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
@section('scripts')

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
            // Order by the grouping
            $('#example tbody').on('click', 'tr.group', function() {
                var currentOrder = table.order()[0];
                if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                    table.order([2, 'desc']).draw();
                } else {
                    table.order([2, 'asc']).draw();
                }
            });
        });
    });
    $('#example23').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
</script>
@endsection