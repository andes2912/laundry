@extends('layouts.backend')
@section('title','Admin - Invoice Customer')
@section('header','Invoice Customer')
@section('content')

@php
    $grandTotal = 0;
    foreach ($dataInvoice->items as $it) {
        $grandTotal += (int) ($it->subtotal ?: round($it->kg * $it->harga));
    }
    $discPct = (float) ($dataInvoice->disc ?: 0);
    $discAmt = (int) round($grandTotal * $discPct / 100);
    $totalKg = $dataInvoice->items->sum('kg');
@endphp

<div class="row mb-1">
    <div class="col-12">
        <nav aria-label="breadcrumb" class="mb-50">
            <ol class="breadcrumb" style="background: transparent; padding: 0; font-size:.85rem;">
                <li class="breadcrumb-item"><a href="{{ route('transaksi.index') }}" class="text-muted">Transaksi</a></li>
                <li class="breadcrumb-item active">Invoice {{ $dataInvoice->invoice }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 col-12">
        <div class="card printableArea">
            <div class="card-body border-bottom">
                <div class="d-flex justify-content-between align-items-start flex-wrap">
                    <div>
                        <h2 class="text-bold-700 mb-25">INVOICE</h2>
                        <h5 class="text-muted mb-0">{{ $dataInvoice->invoice }}</h5>
                    </div>
                    <div class="text-right">
                        @if ($dataInvoice->status_payment == 'Success')
                            <span class="badge badge-light-success mb-50" style="font-size:.85rem; padding:.5rem 1rem;">
                                <i class="feather icon-check-circle mr-25"></i> LUNAS
                            </span>
                        @else
                            <span class="badge badge-light-danger mb-50" style="font-size:.85rem; padding:.5rem 1rem;">
                                <i class="feather icon-clock mr-25"></i> BELUM DIBAYAR
                            </span>
                        @endif
                        <br>
                        <small class="text-muted">{{ $dataInvoice->created_at?->format('d M Y, H:i') }}</small>
                    </div>
                </div>
            </div>

            <div class="card-body border-bottom">
                <div class="row">
                    <div class="col-md-6 col-12 mb-1">
                        <small class="text-muted text-uppercase">Cabang</small>
                        <h5 class="text-bold-600 mb-25">{{ $dataInvoice->user->nama_cabang }}</h5>
                        <p class="mb-0 small">
                            Diterima: <b>{{ $dataInvoice->user->name }}</b><br>
                            {{ $dataInvoice->user->alamat_cabang }}<br>
                            <i class="feather icon-phone mr-25"></i>{{ $dataInvoice->user->no_telp ?: '-' }}
                        </p>
                    </div>
                    <div class="col-md-6 col-12">
                        <small class="text-muted text-uppercase">Customer</small>
                        <h5 class="text-bold-600 mb-25">{{ $dataInvoice->customers->name }}</h5>
                        <p class="mb-0 small">
                            {{ $dataInvoice->customers->alamat }}<br>
                            <i class="feather icon-phone mr-25"></i>{{ $dataInvoice->customers->no_telp ?: '-' }}
                        </p>
                    </div>
                </div>
                <hr class="my-1">
                <div class="row">
                    <div class="col-md-4 col-6">
                        <small class="text-muted">Tanggal Masuk</small><br>
                        <b>{{ carbon\carbon::parse($dataInvoice->tgl_transaksi)->format('d M Y') }}</b>
                    </div>
                    <div class="col-md-4 col-6">
                        <small class="text-muted">Tanggal Diambil</small><br>
                        <b>{{ $dataInvoice->tgl_ambil ? carbon\carbon::parse($dataInvoice->tgl_ambil)->format('d M Y') : 'Belum Diambil' }}</b>
                    </div>
                    <div class="col-md-4 col-12 mt-1 mt-md-0">
                        <small class="text-muted">Jenis Pembayaran</small><br>
                        <span class="badge badge-light-info">{{ $dataInvoice->jenis_pembayaran ?: 'Belum Diketahui' }}</span>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th style="width:40px">#</th>
                            <th>Jenis Pakaian</th>
                            <th class="text-right">Berat</th>
                            <th class="text-right">Harga / kg</th>
                            <th class="text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataInvoice->items as $i => $it)
                            @php $sub = (int) ($it->subtotal ?: round($it->kg * $it->harga)); @endphp
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    <b>{{ $it->jenis ?: optional($it->harga()->first())->jenis }}</b>
                                    @if ($it->hari)<br><small class="text-muted">{{ $it->hari }} hari pengerjaan</small>@endif
                                </td>
                                <td class="text-right">{{ $it->kg }} Kg</td>
                                <td class="text-right">{{ Rupiah::getRupiah($it->harga) }}</td>
                                <td class="text-right text-bold-600">{{ Rupiah::getRupiah($sub) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-body border-top">
                <div class="row">
                    <div class="col-md-7 col-12">
                        <h6 class="text-bold-600 mb-50">Catatan</h6>
                        <p class="small text-muted mb-0">
                            Dengan menerima nota ini, customer setuju dengan ketentuan layanan laundry yang berlaku.
                        </p>
                    </div>
                    <div class="col-md-5 col-12 mt-2 mt-md-0">
                        <div class="d-flex justify-content-between mb-25">
                            <span class="text-muted">Total Berat</span>
                            <span>{{ $totalKg }} kg</span>
                        </div>
                        <div class="d-flex justify-content-between mb-25">
                            <span class="text-muted">Subtotal</span>
                            <span>{{ Rupiah::getRupiah($grandTotal) }}</span>
                        </div>
                        @if ($discPct > 0)
                            <div class="d-flex justify-content-between mb-25">
                                <span class="text-muted">Diskon ({{ $discPct }}%)</span>
                                <span class="text-danger">- {{ Rupiah::getRupiah($discAmt) }}</span>
                            </div>
                        @endif
                        <hr class="my-50">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-bold-700">TOTAL BAYAR</span>
                            <h3 class="text-bold-700 mb-0 text-success">{{ Rupiah::getRupiah($dataInvoice->harga_akhir) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-12">
        <div class="card" style="position: sticky; top: 90px;">
            <div class="card-body">
                <h5 class="card-title">Aksi</h5>
                <a href="{{ route('transaksi.index') }}" class="btn btn-outline-secondary btn-block">
                    <i class="feather icon-arrow-left mr-25"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
