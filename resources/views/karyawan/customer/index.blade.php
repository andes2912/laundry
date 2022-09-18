@extends('layouts.backend')
@section('title','Karyawan - Data Customer')
@section('header','Data Customer')
@section('content')
@if ($message = Session::get('success'))
  <div class="alert alert-success alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
  </div>
@elseif($message = Session::get('error'))
  <div class="alert alert-danger alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
  </div>
@endif
<div class="card">
    <div class="card-body">
        <div class="table-responsive m-t-5">
                <a href="{{url('customers-create')}}" class="btn btn-primary">Tambah Customer</a>
            <table id="myTable" class="table table-bordered table-striped">
                <thead>
                    <tr align="center" style="color:black; font-weight:bold">
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th>No Telpon</th>
                        <th>Membership</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; ?>
                    @foreach ($customer as $item)
                    <tr align="center" style="color:black;">
                        <td>{{$no}}</td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->email}}</td>
                        <td>{{$item->alamat}}</td>
                        <td>{{$item->no_telp}}</td>
                        <td>{{$item->membership->name ?? 'Not a Membership'}}</td>
                        <td>
                          <a href=" {{url('customers', $item->id)}} " class="btn btn-sm btn-primary" style="color:white">Detail</a>
                          @if ($item->is_membership == 1)
                            <a class="btn btn-warning btn-sm" data-id-deactive="{{$item->id}}" id="deactiveMembership" style="color: black">Deactivate Membership</a>
                          @else
                            <a class="btn btn-info btn-sm" data-id="{{$item->id}}" data-name="{{$item->name}}" id="add_membership" data-toggle="modal" data-target="#add_member" style="color: black">Add Membership</a>
                          @endif
                        </td>
                    </tr>
                    <?php $no++; ?>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @include('karyawan.customer.modal_membership')
</div>
@endsection
@section('scripts')
<script type="text/javascript">

// Deaactive Membership
$(document).on('click', '#deactiveMembership', function () {
  var id = $(this).attr('data-id-deactive');
  $.get('deactive-membership', {'_token' : $('meta[name=csrf-token]').attr('content'),id:id}, function(_resp){
    location.reload()
  });
});

// Add Membership
$(document).on('click','#add_membership', function(){
    var id = $(this).attr('data-id');
    var name = $(this).attr('data-name');
    $("#user_id").val(id)
    $("#name").val(name)

});

// Proses Add Membership
$(document).on('click','#simpan_membership', function(){
    var id = $("#user_id").val();
    var membership_id = $("#membership_id").val();

    $.get('{{Url("add-membership")}}',{'_token': $('meta[name=csrf-token]').attr('content'),id:id,membership_id:membership_id}, function(resp){

    $("#id").val('');
    $("#membership_id").val('');
    location.reload();
    });
 });


// DataTable
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
