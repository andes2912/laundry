@extends('layouts.karyawan_template')
@section('title','Karyawan - Invoice Customer')
@section('header','Invoice Customer')
@section('content')
<div class="col-md-12">
    <div class="card card-body printableArea">
        <h3><b>INVOICE</b> <span class="pull-right">{{$data->invoice}}</span></h3>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="pull-left">
                    <address>
                        <h3> &nbsp;<b class="text-danger">{{$data->nama_cabang}}</b></h3>
                        <p class="text-muted m-l-5"> Diterima Oleh <span style="margin-left:20px"> </span>: {{$data->name}}
                            <br/> Alamat <span style="margin-left:70px"> </span>: {{$data->alamat_cabang}},
                            <br/> No. Telp <span style="margin-left:68px"> </span>: {{$data->no_telpc}},
                            </p>
                    </address>
                </div>
                <div class="pull-right text-right">
                    <address>
                        <h3>Detail Order Customer :</h3>
                        <p class="text-muted m-l-30">
                            {{$data->nama}}
                            <br/> {{$data->alamat}}
                            <br/> {{$data->no_telp}}</p>
                        <p class="m-t-30"><b>Tanggal Masuk :</b> <i class="fa fa-calendar"></i> {{$data->tgl_transaksi}}</p>
                        <p><b>Tanggal Diambil :</b> <i class="fa fa-calendar"></i> 
                            @if ($data->tgl_ambil == "")
                                Belum Diambil
                            @else
                            {{$data->tgl_ambil}}
                            @endif
                        </p>
                    </address>
                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive m-t-20" style="clear: both;">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Jenis Pakaian</th>
                                <th class="text-right">Berat</th>
                                <th class="text-right">Harga</th>
                                <th class="text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoice as $item)
                                <tr>
                                    <td class="text-center">1</td>
                                    <td>{{$item->jenis}}</td>
                                    <td class="text-right">{{$item->kg}} Kg</td>
                                    <td class="text-right">{{Rupiah::getRupiah($item->harga)}} /Kg</td>
                                    <td class="text-right">
                                        <input type="hidden" value="{{$hitung = $item->kg * $item->harga}}">
                                        <p style="color:black">{{Rupiah::getRupiah($hitung)}}</p>
                                    </td>
                                </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12">
                <div class="pull-left m-t-10">
                    <h6 class="text-right" style="font-weight:bold">Dengan Menandatangani/Menerima Nota Ini, Berarti Anda Setuju :</h6>
                    <p>
                        1. Isi Deskripsi <br>
                        2. Isi Deskripsi
                    </p>
                </div>
                <div class="pull-right m-t-10 text-right">
                    <p>Total : {{Rupiah::getRupiah($hitung)}}</p>
                    {{-- <input type="hiddene" value="{{$discon = ((15000 * 100) / 15)}}"> --}}
                    <p>Disc @if ($item->disc == "")
                        (0 %)
                    @else
                        ({{$item->disc}} %)
                    @endif :  <input type="hidden" value="{{$disc = ($hitung * $item->disc ) / 100}}"> {{Rupiah::getRupiah($disc)}} </p>
                    <hr>
                    <h3><b>Total Bayar :</b> {{Rupiah::getRupiah($hitung - $disc)}}</h3>
                </div>
                @endforeach
                <div class="clearfix"></div>
                <hr>
                <div class="text-right">
                    <a href="{{url('pelayanan')}}" class="btn btn-outline btn-danger" style="color:white">Back</a>
                    <a href="{{url('cetak-invoice/'.$item->id. '/print')}}" target="_blank" class="btn btn-success"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection