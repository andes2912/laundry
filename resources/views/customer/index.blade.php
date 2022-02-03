@extends('layouts.backend')
@section('title','Dashboard Customer')
@section('content')
 <div class="row match-height">
      <div class="col-xl-4 col-md-6 col-12">
          <div class="card card-congratulation-medal">
              <div class="card-body">
                  <h5>Welcome 🎉 {{Auth::user()->name}}!</h5>
                  <p class="card-text font-small-2">Semoga harimu menyenangkan.</p> <br>
                  {{date('l, d F Y')}}, {{date('H:i:s')}}
              </div>
          </div>
      </div>
      <!--/ Medal Card -->

      <div class="col-xl-8 col-md-6 col-12">
          <div class="card card-statistics">
              <div class="card-header">
                  <h4 class="card-title">Statistics</h4>
                  <div class="d-flex align-items-center">
                      <p class="card-text font-small-2 mr-25 mb-0">Updated 1 month ago</p>
                  </div>
              </div>
              <div class="card-body statistics-body">
                  <div class="row">
                      <div class="col-xl-4 col-sm-6 col-12 mb-2 mb-xl-0">
                          <div class="media">
                              <div class="avatar bg-light-primary mr-2">
                                  <div class="avatar-content">
                                      <i class="feather icon-check text-primary font-medium-5"></i>
                                  </div>
                              </div>
                              <div class="media-body my-auto">
                                  <h4 class="font-weight-bolder mb-0">{{$totalLaundry}} Total</h4>
                                  <p class="card-text font-small-1 mb-0">Jumlah Laundry</p>
                              </div>
                          </div>
                      </div>
                      <div class="col-xl-4 col-sm-6 col-12 mb-2 mb-xl-0">
                          <div class="media">
                              <div class="avatar bg-light-info mr-2">
                                  <div class="avatar-content">
                                      <i class="feather icon-box text-success font-medium-5"></i>
                                  </div>
                              </div>
                              <div class="media-body my-auto">
                                  <h4 class="font-weight-bolder mb-0">{{$totalLaundryKg}} Kg</h4>
                                  <p class="card-text font-small-1 mb-0">Jumlah Laundry</p>
                              </div>
                          </div>
                      </div>
                      <div class="col-xl-4 col-sm-6 col-12 mb-2 mb-sm-0">
                          <div class="media">
                              <div class="avatar bg-light-danger mr-2">
                                  <div class="avatar-content">
                                      <i class="feather icon-star text-danger font-medium-5"></i>
                                  </div>
                              </div>
                              <div class="media-body my-auto">
                                  <h4 class="font-weight-bolder mb-0"> {{Auth::user()->point}} </h4>
                                  <p class="card-text font-small-1 mb-0">Point</p>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>

      <div class="col-xl-12 col-md-12 col-12">
        {{-- Table --}}
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">
              Data Transaksi Kamu
            </h4>
            <div class="table-responsive m-t-0">
              <table id="myTable" class="table display table-bordered table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>No Resi</th>
                    <th>TGL Transaksi</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th>Jenis</th>
                    <th>Total</th>
                    {{-- <th>Action</th> --}}
                  </tr>
                </thead>
                <tbody>
                  @foreach ($transaksi as $key => $transaksis)
                    <tr>
                      <td> {{$key+1}} </td>
                      <td> {{$transaksis->invoice}} </td>
                      <td> {{$transaksis->tgl_transaksi}} </td>
                      <td> {{$transaksis->status_order}} </td>
                      <td> {{$transaksis->status_payment}} </td>
                      <td> {{$transaksis->price->jenis}} </td>
                      <td> {{$transaksis->harga_akhir}} </td>
                      {{-- <td>
                        <a href="" class="btn btn-sm btn-info">Detail</a>
                      </td> --}}
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