@extends('layouts.admin_template')
@section('title','Admin - Data Transaksi')
@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive m-t-0">
                <table id="myTable" class="table display table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>TGL Transaksi</th>
                            <th>Customer</th>
                            <th>Status Order</th>
                            <th>Status Pembayaran</th>
                            <th>Jenis Laundri</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; ?>
                        @foreach ($transaksi as $item)
                        <tr>
                            <td>{{$no}}</td>
                            <td>{{carbon\carbon::parse($item->tgl_transaksi)->format('d-m-y')}}</td>
                            <td>{{$item->customer}}</td>
                            <td>
                                @if ($item->status_order == 'Selesai')
                                    <span class="label label-success">Selesai</span>
                                @elseif($item->status_order == 'Diambil')
                                    <span class="label label-info">Sudah Diambil</span>
                                @elseif($item->status_order == 'Proses')
                                    <span class="label label-info">Sedang Proses</span>
                                @endif
                            </td>
                            <td>
                                @if ($item->status_payment == 'Lunas')
                                    <span class="label label-success">Sudah Dibayar</span>
                                @elseif($item->status_payment == 'Belum')
                                    <span class="label label-info">Belum Dibayar</span>
                                @endif
                            </td>
                            <td>{{$item->jenis}}</td>
                            <td>
                                    <input type="hidden" value="{{$hitung = $item->kg * $item->harga}}">
                                    <p style="color:black">{{Rupiah::getRupiah($hitung)}}</p>    
                            </td>
                            <td align="center">
                                @if ($item->status_order == "Diambil")
                                    <a href="{{url('invoice-customer', $item->id)}}" class="btn btn-sm btn-success" style="color:white">Invoice</a>
                                    <a class="btn btn-sm btn-info" style="color:white">Detail</a>
                                @elseif($item->status_order == "Selesai")
                                    <a href="{{url('invoice-customer', $item->id)}}" class="btn btn-sm btn-success" style="color:white">Invoice</a>
                                    <a class="btn btn-sm btn-info" style="color:white">Detail</a>
                                @elseif($item->status_order == "Proses")
                                    <a href="{{url('invoice-customer', $item->id)}}" class="btn btn-sm btn-success" style="color:white">Invoice</a>
                                    <a class="btn btn-sm btn-info" style="color:white">Detail</a>    
                                @endif
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