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
                        <th>Status Order</th>
                        <th>Status Payment</th>
                        <th>Jenis Laundri</th>
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
                                <span class="label label-primary">Sudah Diambil</span>
                            @elseif($item->status_order == 'Process')
                                <span class="label label-info">Sedang Proses</span>
                            @endif
                        </td>
                        <td>
                            @if ($item->status_payment == 'Success')
                                <span class="label label-success">Sudah Dibayar</span>
                            @elseif($item->status_payment == 'Pending')
                                <span class="label label-info">Belum Dibayar</span>
                            @endif
                        </td>
                        <td>{{$item->price->jenis}}</td>
                        <td>
                            {{Rupiah::getRupiah($item->harga_akhir)}}
                        </td>
                        <td>
                            @if ($item->status_payment == "Pending")
                                <a class="btn btn-sm btn-danger" data-toggle="modal" data-id-pay="{{$item->id}}" data-id-name="{{$item->customer}}" data-id-bayar="{{$item->status_payment}}" id="klick" data-target="#ubah_status_pay" style="color:white">Bayar</a>
                                <a href="{{url('invoice-kar', $item->id)}}" class="btn btn-sm btn-primary">Invoice</a>
                            @elseif($item->status_payment == "Success")
                                @if ($item->status_order == "Done")
                                <a class="btn btn-sm btn-success" data-id-ambil="{{$item->id}}" id="ambil" style="color:white">Ambil</a>
                                @elseif($item->status_order == "Process")
                                    <a class="btn btn-sm btn-info" data-toggle="modal" data-id="{{$item->id}}" data-id-nama="{{$item->customer}}" data-id-order="{{$item->status_order}}" id="klikmodal" data-target="#ubah_status" style="color:white">Selesai</a>
                                    <a href="{{url('invoice-kar', $item->id)}}"  class="btn btn-sm btn-primary">Invoice</a>
                                @elseif($item->status_order == "Delivery")
                                    <a href="" class="btn btn-sm btn-warning">Detail</a>
                                    <a href="{{url('invoice-kar', $item->id)}}" class="btn btn-sm btn-primary">Invoice</a>
                                @endif
                            @endif
                        </td>
                    </tr>
                    <?php $no++; ?>
                    @endforeach
                </tbody>
            </table>
        </div>
        @include('karyawan.transaksi.statusorder')
        @include('karyawan.transaksi.statusbayar')
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">

// Tampilkan Modal Ubah Status Order
$(document).on('click','#klikmodal', function(){
    var id = $(this).attr('data-id');
    var customer = $(this).attr('data-id-nama');
    var status_order = $(this).attr('data-id-order');
    $("#id").val(id)
    $("#customer").val(customer)
    $("#status_order").val(status_order)
});

// Proses Ubah Status Order
$(document).on('click','#save_status', function(){
    var id = $("#id").val();
    var customer = $("#customer").val();
    var status_order = $("#status_order").val();

    $.get('{{Url("ubah-status-order")}}',{'_token': $('meta[name=csrf-token]').attr('content'),id:id,customer:customer,status_order:status_order}, function(resp){
      $("#id").val('');
      $("#customer").val('');
      $("#status_order").val('');

      location.reload();
    });
});


// Tampilkan Modal Ubah Status Pembayaran
$(document).on('click','#klick', function(){
    var id = $(this).attr('data-id-pay');
    var customer = $(this).attr('data-id-name');
    var status_payment = $(this).attr('data-id-bayar');
    $("#id_bayar").val(id)
    $("#customer_pay").val(customer)
    $("#status_payment").val(status_payment)
});

// Proses Ubah Status Pembayaran
$(document).on('click','#simpan_status', function(){
    var id = $("#id_bayar").val();
    var customer = $("#customer_pay").val();
    var status_payment = $("#status_payment").val();

    $.get('{{Url("ubah-status-bayar")}}',{'_token': $('meta[name=csrf-token]').attr('content'),id:id,customer:customer,status_payment:status_payment}, function(resp){
      $("#id_bayar").val('');
      $("#customer_pay").val('');
      $("#status_payment").val('');
			location.reload();
    });
});

// Ubah Status Menjadi Diambil
$(document).on('click','#ambil', function () {
  var id = $(this).attr('data-id-ambil');
  $.get(' {{Url("ubah-status-ambil")}}', {'_token' : $('meta[name=csrf-token]').attr('content'),id:id}, function(resp){
    location.reload();
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