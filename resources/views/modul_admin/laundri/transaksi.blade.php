@extends('layouts.admin_template')
@section('title','Admin - Data Transaksi')
@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
               <div class="row">
                    <div class="col-4">
                        <select name="id_karyawan" id="id_karyawan" class="form-control">
                            <option value="0">--Filter--</option>
                                @foreach ($filter as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                        </select>
                </div>
                <div class="cl-3">
                    <button class="btn btn-primary" id="filter">Filter</button>
                </div>
               </div>
            </h4>
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
                    <tbody id="refresh_body">
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
                                    <p style="color:black">{{Rupiah::getRupiah($item->harga_akhir)}}</p>    
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

$("#filter").click(function(){
    var id_karyawan  = $("#id_karyawan").val();
    $.get('filter-transaksi',{'_token': $('meta[name=csrf-token]').attr('content'),id_karyawan:id_karyawan}, function(resp){
    $("#refresh_body").html(resp); 
    });
});
</script>
@endsection