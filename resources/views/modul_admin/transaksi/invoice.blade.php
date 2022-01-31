@extends('layouts.backend')
@section('title','Admin - Invoice Customer')
@section('header','Invoice Customer')
@section('content')
<div class="col-md-12">
    <div class="card card-body printableArea">
        <h3><b>INVOICE</b> <span class="pull-right">{{$dataInvoice->invoice}}</span></h3>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="pull-left">
                    <address>
                        <h3><b class="text-danger">{{$dataInvoice->user->nama_cabang}}</b></h3>
                        <p class="text-muted m-l-5">
                          Diterima Oleh <span style="margin-left:20px"> </span>: {{$dataInvoice->user->name}} <br/>
                          Alamat <span style="margin-left:68px"> </span>: {{$dataInvoice->user->alamat_cabang}} <br/>
                          No. Telp <span style="margin-left:63px"> </span>: {{$dataInvoice->user->no_telp == 0 ? '-' : $dataInvoice->user->no_telp}}
                    </address>
                </div>
                <div class="pull-right text-right">
                    <address>
                        <h3>Detail Order Customer :</h3>
                        <p class="text-muted m-l-30">
                          {{$dataInvoice->customers->name}}<br/>
                          {{$dataInvoice->customers->alamat}}<br/>
                          {{$dataInvoice->customers->no_telp == 0 ? '-' : $dataInvoice->customers->no_telp}}
                        </p>
                        <p class="m-t-30">
                          <b>Tanggal Masuk :</b>
                          <i class="fa fa-calendar"></i>
                          {{carbon\carbon::parse($dataInvoice->customers->tgl_transaksi)->format('d F Y')}}
                        </p>
                        <p>
                          <b>Tanggal Diambil :</b>
                          <i class="fa fa-calendar"></i>
                            @if ($dataInvoice->customers->tgl_ambil == "")
                                Belum Diambil
                            @else
                            {{carbon\carbon::parse($dataInvoice->tgl_ambil)->format('d F Y')}}
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
                                <th class="text-right">Sub Total</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach ($invoice as $key => $item)
                            <tr>
                                <td class="text-center">{{$key+1}}</td>
                                <td>{{$item->price->jenis}}</td>
                                <td class="text-right">{{$item->kg}} Kg</td>
                                <td class="text-right">{{Rupiah::getRupiah($item->harga)}} /Kg</td>
                                <td class="text-right">
                                    <input type="hidden" value="{{$hitung = $item->kg * $item->harga}}">
                                    <p style="color:white">{{Rupiah::getRupiah($hitung)}}</p>
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
                    <p>Disc @if ($item->disc == "")
                        (0 %)
                    @else
                        ({{$item->disc}} %)
                    @endif :  <input type="hidden" value="{{$disc = ($hitung * $item->disc   ) / 100}}"> {{Rupiah::getRupiah($disc)}} </p>
                    <hr>
                    <h3><b>Total Bayar :</b> {{Rupiah::getRupiah($hitung - $disc)}}</h3>
                </div>
                @endforeach
                <div class="clearfix"></div>
                <hr>
                <div class="text-right">
                  <a href="{{route('transaksi.index')}}" class="btn btn-outline btn-info" style="color:white">Kembali</a>
                  {{-- <button id="print" class="btn btn-primary btn-outline" type="button"> <span style="color:white"><i class="fa fa-print"></i> Print</span> </button> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection