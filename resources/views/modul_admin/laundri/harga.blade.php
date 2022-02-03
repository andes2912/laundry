@extends('layouts.backend')
@section('title','Admin - Data Harga Laundri')
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
  @if ($getBank > 0)
    <div class="row">
      {{-- Data Harga Laundry Per-Cabang --}}
      <div class="col-lg-8">
          <div class="card">
              <div class="card-body">
                  <h4 class="card-title"> Data Harga Laundry Per-Cabang
                      <a class="btn btn-primary" style="color:white">Tambah</a>
                  </h4>
                  <div class="table-responsive m-t-0">
                      <table id="myTable" class="table display table-bordered table-striped">
                          <thead>
                              <tr>
                                  <th>#</th>
                                  <th>Jenis</th>
                                  <th>Lama</th>
                                  <th>Kg</th>
                                  <th>Harga</th>
                                  <th>Status</th>
                                  <th>Cabang</th>
                                  <th>Action</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php $no=1; ?>
                              @foreach ($harga as $item)
                              <tr>
                                  <td>{{$no}}</td>
                                  <td>{{$item->jenis}}</td>
                                  <td>{{$item->hari}} Hari</td>
                                  <td>{{$item->kg}} Kg</td>
                                  <td>{{Rupiah::getRupiah($item->harga)}}</td>
                                  <td>
                                      @if ($item->status == "1")
                                          <span class="label label-primary">Aktif</span>
                                      @else
                                      <span class="label label-warning">Tidak Aktif</span>
                                      @endif
                                  </td>
                                  <td>{{$item->harga_user->nama_cabang}}</td>
                                  <td>
                                      <a class="btn btn-sm btn-success" data-toggle="modal" data-id="{{$item->id}}" data-id-jenis="{{$item->jenis}}" data-id-kg="{{$item->kg}}" data-id-harga="{{$item->harga}}" data-id-hari="{{$item->hari}}" data-id-status="{{$item->status}}" id="click_harga" data-target="#edit_harga" style="color:white">Edit</a>
                                  </td>
                              </tr>
                              <?php $no++; ?>
                              @endforeach
                          </tbody>
                      </table>
                  </div>
                  @include('modul_admin.laundri.editharga')
              </div>
          </div>
      </div>

      {{-- Form Tambah Data Harga --}}
      <div class="col-lg-4">
          <div class="card card-outline-info">
              <div class="card-header">
                  <h4 class="m-b-0 text-black">Form Tambah Data Harga</h4>
              </div>
              <div class="card-body">
                  <form action="{{url('harga-store')}}" method="POST">
                      @csrf
                      <div class="form-body">
                          @if ($karyawan == !null)
                          <div class="row p-t-20">

                              <div class="col-lg-12 col-xl-12">
                                  <div class="form-group has-success">
                                      <label class="control-label">Cabang</label>
                                      <select name="user_id" class="form-control @error('user_id') is-invalid @enderror">
                                          <option value="">-- Pilih Cabang --</option>
                                          @foreach ($getcabang as $item)
                                              <option value="{{$item->id}}">{{$item->nama_cabang}} - {{$item->name}}</option>
                                          @endforeach
                                      </select>
                                      @error('user_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                  </div>
                              </div>
                              <div class="col-lg-12 col-xl-12">
                                  <div class="form-group has-success">
                                      <label class="control-label">Jenis Pakaian</label>
                                      <input type="text" name="jenis" value="{{ old('jenis') }}" class="form-control @error('jenis') is-invalid @enderror" placeholder="Tambahkan Jenis Pakaian" autocomplete="off">
                                      <small class="form-control-feedback "> Pisahkan Dengan format '+' Jika Jenis Lebih Dari Satu </small>
                                      @error('jenis')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                  </div>
                              </div>
                              <!--/span-->
                              <div class="col-lg-12 col-xl-12">
                                  <div class="form-group has-success">
                                      <label class="control-label">Berat Per-Kg</label>
                                      <input type="text" class="form-control form-control-danger" value="1000 gram" placeholder="Berat" readonly autocomplete="off">
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <!--/span-->
                              <div class="col-lg-12 col-xl-12">
                                  <div class="form-group has-success">
                                      <label class="control-label">Harga Per-Kg</label>
                                      <input type="text" class="form-control form-control-danger @error('harga') is-invalid @enderror format_harga" name="harga" value="{{ old('harga') }}"placeholder="Harga Per-Kg" autocomplete="off">
                                      <small class="form-control-feedback "> Tuliskan Tanpa tanda ',' dan '.' </small>
                                      @error('harga')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                  </div>
                              </div>
                              <div class="col-lg-12 col-xl-12">
                                  <div class="form-group has-success">
                                      <label class="control-label">Lama Hari</label>
                                      <input type="number" name="hari" value="{{ old('hari') }}" class="form-control @error('hari') is-invalid @enderror" placeholder="Lama Hari" autocomplete="off">
                                      @error('hari')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                  </div>
                              </div>
                          </div>
                          <!--/row-->

                      </div>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                          <button type="reset" class="btn btn-danger">Cancel</button>
                      </div>
                      @else
                          <h5 class="text-danger">Upsss, data karyawan/cabang masih kosong nih !!!</h5> <br>
                          <a href="{{url('karyawan')}}" class="btn btn-success btn-block">Tambah Karyawan</a>
                      @endif
                  </form>
              </div>
          </div>
      </div>
    </div>
  @else
    <div class="card">
      <div class="col text-center">
        <img src="{{asset('backend/images/pages/empty.svg')}}" style="height:500px; width:100%; margin-top:10px">
        <h2 class="mt-1">Data Bank Kosong / Tidak Aktif !</h2>
        <h4>Mohon untuk melakukan penginputan Data Bank terlebih dahulu :)</h4>
        <h6><a href="{{url('settings')}}">Input Data Bank</a></h6>
      </div>
    </div>
  @endif
@endsection
@section('scripts')
<script type="text/javascript">

// Format Harga Value
$(".format_harga").autoNumeric('init', {
    aSep: '.',
    aDec: ',',
    aForm: true,
    vMax: '999999999',
    vMin: '-999999999'
});

// Tampilkan Modal Edit Harga
$(document).on('click','#click_harga', function(){
    var id = $(this).attr('data-id');
    var jenis = $(this).attr('data-id-jenis');
    var kg = $(this).attr('data-id-kg');
    var hari = $(this).attr('data-id-hari');
    var harga = $(this).attr('data-id-harga');
    var status = $(this).attr('data-id-status');
    $("#id_harga").val(id)
    $("#jenis").val(jenis)
    $("#kg").val(kg)
    $("#hari").val(hari)
    $("#harga").val(harga)
    $("#status").val(status)

});
// Proses Edit harga
$(document).on('click','#simpan_harga', function(){
    var id_harga = $("#id_harga").val();
    var jenis = $("#jenis").val();
    var kg = $("#kg").val();
    var hari = $("#hari").val();
    var harga = $("#harga").val();
    var status = $("#status").val();

    $.get('{{Url("edit-harga")}}',{'_token': $('meta[name=csrf-token]').attr('content'),id_harga:id_harga,hari:hari,jenis:jenis,kg:kg,harga:harga,status:status}, function(resp){

    $("#id_harga").val('');
    $("#jenis").val('');
    $("#kg").val('');
    $("#hari").val('');
    $("#harga").val('');
    $("#status").val('');
    location.reload();
    });
 });


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