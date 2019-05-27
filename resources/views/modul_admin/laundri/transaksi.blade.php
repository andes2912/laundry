@extends('layouts.admin_template')
@section('title','Admin - Data Transaksi')
@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{url('customer-add')}}" class="btn btn-sm btn-primary">Tambah</a>
            </h4>
            
            <div class="table-responsive full-color-table full-inverse-table hover-table">
                <table class="table color-table info-table">
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
                    <tbody>
                        <?php $no=1; ?>
                        @foreach ($transaksi as $item)
                        <tr>
                            <td>{{$no}}</td>
                            <td>{{$item->tgl_transaksi}}</td>
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
                                    <input type="hidden" value="{{$hitung = $item->kg_transaksi * $item->harga}}">
                                    <p style="color:black">{{Rupiah::getRupiah($hitung)}}</p>    
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