@extends('layouts.backend')
@section('title','Dashboard Karyawan')
@section('content')
@if ($message = Session::get('success'))
  <div class="alert alert-success alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
  </div>
@elseif ($message = Session::get('error'))
  <div class="alert alert-danger alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
  </div>
@endif
<div class="card">
    <div class="card-body">
        <h4 class="card-title">
            <a href="{{url('add-order')}}" class="btn btn-primary">Tambah</a>
        </h4>
        <h6>Info : <code> Untuk Mengubah Status Order & Pembayaran Klik Pada Bagian 'Action' Masing-masing.</code></h6>
        <div class="table-responsive m-t-0">
            <table id="myTable" class="table display table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>No Resi</th>
                        <th>TGL Transaksi</th>
                        <th>Customer</th>
                        <th>Status Laundry</th>
                        <th>Payment</th>
                        <th>Jenis</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  {{-- {{dd($order)}} --}}
                    <?php $no=1; ?>
                    @foreach ($order as $item)
                    <tr>
                        <td>{{$no}}</td>
                        <td style="font-weight:bold; font-color:black">{{$item->invoice}}</td>
                        <td>{{carbon\carbon::parse($item->tgl_transaksi)->format('d-m-y')}}</td>
                        <td>{{$item->customer}}</td>
                        <td>
                            @if ($item->status_order == 'Done')
                                <span class="label label-success">Selesai</span>
                            @elseif($item->status_order == 'Delivery')
                                <span class="label label-primary">Diambil</span>
                            @elseif($item->status_order == 'Process')
                                <span class="label label-info">Diproses</span>
                            @endif
                        </td>
                        <td>
                            @if ($item->status_payment == 'Success')
                                <span class="label label-success">Lunas</span>
                            @elseif($item->status_payment == 'Pending')
                                <span class="label label-info">Pending</span>
                            @endif
                        </td>
                        <td>{{$item->price->jenis}}</td>
                        <td>
                            {{Rupiah::getRupiah($item->harga_akhir)}}
                        </td>
                        <td>
                            @if ($item->status_payment == 'Pending')
                            <a class="btn btn-sm btn-danger" style="color:white" data-id-update="{{$item->id}}" id="updateStatus">Bayar</a>
                            <a href="{{url('invoice-kar', $item->id)}}" class="btn btn-sm btn-warning" style="color:white">Invoice</a>
                            @elseif($item->status_payment == 'Success')
                              @if ($item->status_order == 'Process')
                                <a class="btn btn-sm btn-info" style="color:white" data-id-update="{{$item->id}}" id="updateStatus">Selesai</a>
                                <a href="{{url('invoice-kar', $item->id)}}" class="btn btn-sm btn-warning" style="color:white">Invoice</a>
                              @elseif($item->status_order == 'Done')
                                <a class="btn btn-sm btn-info" style="color:white" data-id-update="{{$item->id}}" id="updateStatus">Diambil</a>
                                <a href="{{url('invoice-kar', $item->id)}}" class="btn btn-sm btn-warning" style="color:white">Invoice</a>
                              @elseif($item->status_order == 'Delivery')
                                <a href="{{url('invoice-kar', $item->id)}}" class="btn btn-sm btn-warning" style="color:white">Invoice</a>
                              @endif
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
@endsection
@section('scripts')
<script type="text/javascript">

// Update Status Laundry
$(document).on('click', '#updateStatus', function () {
  var id = $(this).attr('data-id-update');
  $.get('update-status-laundry', {'_token' : $('meta[name=csrf-token]').attr('content'),id:id}, function(_resp){
    location.reload()
  });
});

// DATATABLE
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