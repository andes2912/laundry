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
                        <input type="hidden" name="tgl_transaksi" id="">
                        <div class="col-md-4">
                            <div class="form-group has-success">
                                <label class="control-label">Berat Pakaian</label>
                                <input type="text" class="form-control form-control-danger" name="kg_transaksi" placeholder="Berat Pakaian" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group has-success">
                                <label class="control-label">Status Order</label>
                                <input type="text" name="status_order" value="Proses" readonly class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                    <div class="col-md-3">
                            <div class="form-group has-success">
                                <label class="control-label">Status Payment</label>
                                <select class="form-control custom-select" name="status_payment" required>
                                    <option value="">-- Pilih Status Payment --</option>
                                    <option value="Belum">Belum Dibayar</option>
                                    <option value="Lunas">Sudah Dibayar</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="orm-group has-success">
                                <label class="control-label">Pilih Pakaian</label>
                                <select id="id" name="id_jenis" class="form-control" required>
                                    <option value="#">-- Jenis Pakaian --</option>
                                    <?php
                                    $jenis = App\harga::select('id','jenis')->where('status','1')->get();
                                    ?>
                                    @foreach($jenis as $jenis)
                                    <option value="{{$jenis->id}}">{{$jenis->jenis}}</option>
                                    @endforeach									
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <span id="select-hari"></span>
                        </div>
                        <div class="col-md-2">
                            <span id="select-harga"></span>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group has-success">
                                <label class="control-label">Disc</label>
                                <input type="number" name="disc" placeholder="Tulis Disc" class="form-control">
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="tgl">
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