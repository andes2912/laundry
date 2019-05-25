@extends('layouts.karyawan_template')
@section('title','Tambah Data Order')
@section('content')
<div class="col-lg-12">
    <div class="card card-outline-info">
        <div class="card-header">
            <h4 class="m-b-0 text-white">Form Tambah Data Order</h4>
        </div>
        <div class="card-body">
            <form action="{{route('pelayanan.store', $addorder->id_customer)}}" method="POST">
                @csrf
                <div class="form-body">
                    <div class="row p-t-20">
                        <div class="col-md-5">
                            <div class="form-group has-success">
                                <label class="control-label">Nama</label>
                                <input type="text" class="form-control form-control-danger" name="customer" value="{{$addorder->nama}}" placeholder="Nama Customer" readonly>
                            </div>
                        </div>
                        <input type="hidden" name="id_customer" value="{{$addorder->id_customer}}">
                        <!--/span-->
                        <div class="col-md-3">
                            <div class="form-group has-success">
                                <label class="control-label">TGL Transaksi</label>
                                <input type="date" class="form-control form-control-danger" name="tgl_transaksi" placeholder="TGL Transaksi" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group has-success">
                                <label class="control-label">Berat Pakaian</label>
                                <input type="text" class="form-control form-control-danger" name="kg_transaksi" placeholder="Berat Pakaian" autocomplete="off" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="orm-group has-success">
                                <label class="control-label">Pilih Pakaian</label>
                                <select id="id" name="id_jenis" class="form-control" required>
                                    <option value="#">-- Jenis Pakaian --</option>
                                    <?php
                                    $jenis = App\Harga::select('id','jenis')->get();
                                    ?>
                                    @foreach($jenis as $jenis)
                                    <option value="{{$jenis->id}}">{{$jenis->jenis}}</option>
                                    @endforeach									
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <span id="select-hari"></span>
                        </div>
                        <div class="col-md-3">
                            <span id="select-harga"></span>
                        </div>
                    </div>

                    <div class="row">
                        <!--/span-->
                        <div class="col-md-5">
                            <div class="form-group has-success">
                                <label class="control-label">Status Order</label>
                                <select class="form-control custom-select" name="status_order" required>
                                    <option value="">-- Pilih Status Order --</option>
                                    <option value="Selesai">Selesai</option>
                                    <option value="Diambil">Diambil</option>
                                    <option value="Proses">Proses</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group has-success">
                                <label class="control-label">Status Payment</label>
                                <select class="form-control custom-select" name="status_payment" required>
                                    <option value="">-- Pilih Status Payment --</option>
                                    <option value="Belum">Belum Dibayar</option>
                                    <option value="Lunas">Sudah Dibayar</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!--/row-->                  
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                    <a href="{{url('list-customer')}}" class="btn btn-danger">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function() {
       var id = $("#id").val();
    //    var jenis = $("#jenis").val();
            $.get('{{ Url("listhari") }}',{'_token': $('meta[name=csrf-token]').attr('content'),id:id}, function(resp){  
            $("#select-hari").html(resp);
            $.get('{{ Url("listharga") }}',{'_token': $('meta[name=csrf-token]').attr('content'),id:id,jenis:jenis}, function(resp){  
            $("#select-harga").html(resp);
        });
        });
    });
    $(document).on('change', '#id', function (e) { 
      var id = $(this).val();
      $.get('{{ Url("listhari") }}',{'_token': $('meta[name=csrf-token]').attr('content'),id:id}, function(resp){  
        $("#select-hari").html(resp);
      });
    });

    $(document).on('change', '#id', function (e) { 
        var id = $(this).val();
        // var id = $(this).val();
        $.get('{{ Url("listharga") }}',{'_token': $('meta[name=csrf-token]').attr('content'),id:id}, function(resp){  
            $("#select-harga").html(resp);
        });
    });
</script>
@endsection