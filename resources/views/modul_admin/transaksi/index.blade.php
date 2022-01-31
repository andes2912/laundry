@extends('layouts.backend')
@section('title','Admin - Data Transaksi')
@section('content')
<div class="row">
  <div class="col-lg-12">
      <div class="card">
          <div class="card-body">
              <h4 class="card-title"> Data Transaksi
                <div class="row">
                      <div class="col-4">
                          <select name="user_id" id="user_id" class="form-control">
                              <option value="all">--Semua Transaksi--</option>
                                  @foreach ($filter as $item)
                                      <option value="{{$item->id}}">Karyawan {{$item->name}}</option>
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
                          @foreach ($transaksi as $key => $item)
                          <tr>
                              <td>{{$key+1}}</td>
                              <td>{{carbon\carbon::parse($item->tgl_transaksi)->format('d-m-y')}}</td>
                              <td>{{$item->customer}}</td>
                              <td>
                                  @if ($item->status_order == 'Done')
                                      <span class="label label-success">Selesai</span>
                                  @elseif($item->status_order == 'Delivery')
                                      <span class="label label-info">Sudah Diambil</span>
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
                                <p>{{Rupiah::getRupiah($item->harga_akhir)}}</p>
                              </td>
                              <td align="center">
                                <a href="{{url('invoice-customer', $item->invoice)}}" class="btn btn-sm btn-success" style="color:white">Invoice</a>
                              </td>
                          </tr>
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
    });
});

$("#filter").click(function(){
    var user_id  = $("#user_id").val();
    $.get('filter-transaksi',{'_token': $('meta[name=csrf-token]').attr('content'),user_id:user_id}, function(resp){
    $("#refresh_body").html(resp);
    });
});
</script>
@endsection