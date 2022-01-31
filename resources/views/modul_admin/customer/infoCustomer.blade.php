@extends('layouts.backend')
@section('title','Admin - Detail Data Customer')
@section('header','Detail Data Customer')
@section('content')
<div class="row">
  <div class="col-sm-12 col-md-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Detail Data Customer</h4>
        </div>
        <div class="card-content">
            <div class="row">
              <div class="card-body">
                <div class="card-text">
                    <dl class="row">
                        <dt class="col-sm-4">Nama Customer</dt>
                        <dd class="col-sm-4">: {{$customer->name}}</dd>
                    </dl>

                    <dl class="row">
                        <dt class="col-sm-4">Email Customer</dt>
                        <dd class="col-sm-4">: {{$customer->email}}</dd>
                    </dl>

                    <dl class="row">
                        <dt class="col-sm-4">No. Telepon</dt>
                        <dd class="col-sm-4">: {{$customer->no_telp == 0 ? 'Belum Input' : $customer->no_telp}}</dd>
                    </dl>

                    <dl class="row">
                        <dt class="col-sm-4">Alamat Customer</dt>
                        <dd class="col-sm-4">: {{$customer->alamat}}</dd>
                    </dl>

                    <dl class="row">
                        <dt class="col-sm-4">Kelamin Customer</dt>
                        <dd class="col-sm-4">: {{$customer->kelamin == 'L' ? 'Laki-laki' : 'Perempuan'}}</dd>
                    </dl>

                </div>
            </div>
            <div class="card-body">
                <div class="card-text">
                    <dl class="row">
                        <dt class="col-sm-4">Total Kg</dt>
                        <dd class="col-sm-4">: {{$customer->transaksiCustomer()->sum('kg') ?? ''}} Kg</dd>
                    </dl>

                    <dl class="row">
                        <dt class="col-sm-4">Total Rupiah</dt>
                        <dd class="col-sm-4">: {{Rupiah::getRupiah($customer->transaksiCustomer()->sum('harga_akhir')) ?? ''}}</dd>
                    </dl>

                    <dl class="row">
                        <dt class="col-sm-4">Total Laundry</dt>
                        <dd class="col-sm-4">: {{$customer->transaksiCustomer()->count() ?? ''}} Kali</dd>
                    </dl>

                    <dl class="row">
                        <dt class="col-sm-4">Laundry Terakhir</dt>
                        <dd class="col-sm-4">: {{$customer->transaksiCustomer[0]['created_at'] ?? '-'}}</dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-sm-4">Pendaftaran Akun</dt>
                        <dd class="col-sm-4">: {{$customer->created_at}}</dd>
                    </dl>
                </div>
            </div>
            </div>
        </div>
    </div>
  </div>

  <div class="col-sm-12 col-md-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Detail Transaksi Customer</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <div class="table-responsive m-t-0">
                    <table id="myTable" class="table display table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Invoice</th>
                                <th>Tgl Transaksi</th>
                                <th>Tgl Diambil</th>
                                <th>Jumlah KG</th>
                                <th>Jenis Pembayaran</th>
                                <th>Status Transaksi</th>
                                <th>Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach ($customer->transaksiCustomer as $key => $item)
                          <tr>
                              <td>{{$key+1}}</td>
                              <td>{{$item->invoice}}</td>
                              <td>{{$item->tgl_transaksi}}</td>
                              <td>{{$item->tgl_ambil ?? 'Belum Diambil'}}</td>
                              <td>{{$item->kg}} kg</td>
                              <td>{{$item->jenis_pembayaran}}</td>
                              <td>{{$item->status_order}}</td>
                              <td>{{Rupiah::getRupiah($item->harga_akhir)}}</td>

                          </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
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