@extends('layouts.backend')
@section('title','Karyawan - Invoice Customer')
@section('header','Invoice Customer')
@section('content')

@php
    $grandTotal = 0;
    foreach ($data->items as $it) {
        $grandTotal += (int) ($it->subtotal ?: round($it->kg * $it->harga));
    }
    $discPct = (float) ($data->disc ?: 0);
    $discAmt = (int) round($grandTotal * $discPct / 100);
    $totalKg = $data->items->sum('kg');
@endphp

<div class="row mb-1">
    <div class="col-12">
        <nav aria-label="breadcrumb" class="mb-50">
            <ol class="breadcrumb" style="background: transparent; padding: 0; font-size:.85rem;">
                <li class="breadcrumb-item"><a href="{{ url('pelayanan') }}" class="text-muted">Order</a></li>
                <li class="breadcrumb-item active">Invoice {{ $data->invoice }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 col-12">
        <div class="card printableArea">
            {{-- Header --}}
            <div class="card-body border-bottom">
                <div class="d-flex justify-content-between align-items-start flex-wrap">
                    <div>
                        <h2 class="text-bold-700 mb-25">INVOICE</h2>
                        <h5 class="text-muted mb-0">{{ $data->invoice }}</h5>
                    </div>
                    <div class="text-right">
                        @if ($data->status_payment == 'Success')
                            <span class="badge badge-light-success mb-50" style="font-size:.85rem; padding:.5rem 1rem;">
                                <i class="feather icon-check-circle mr-25"></i> LUNAS
                            </span>
                        @else
                            <span class="badge badge-light-danger mb-50" style="font-size:.85rem; padding:.5rem 1rem;">
                                <i class="feather icon-clock mr-25"></i> BELUM DIBAYAR
                            </span>
                        @endif
                        <br>
                        <small class="text-muted">Dibuat {{ $data->created_at?->format('d M Y, H:i') }}</small>
                    </div>
                </div>
            </div>

            {{-- Pihak --}}
            <div class="card-body border-bottom">
                <div class="row">
                    <div class="col-md-6 col-12 mb-1">
                        <small class="text-muted text-uppercase">Dari</small>
                        <h5 class="text-bold-600 mb-25">{{ $data->user->nama_cabang }}</h5>
                        <p class="mb-0 small">
                            Diterima: <b>{{ $data->user->name }}</b><br>
                            {{ $data->user->alamat_cabang }}<br>
                            <i class="feather icon-phone mr-25"></i>{{ $data->user->no_telp ?: '-' }}
                        </p>
                    </div>
                    <div class="col-md-6 col-12">
                        <small class="text-muted text-uppercase">Customer</small>
                        <h5 class="text-bold-600 mb-25">{{ optional($data->customers)->name ?? $data->customer }}</h5>
                        <p class="mb-0 small">
                            {{ optional($data->customers)->alamat }}<br>
                            <i class="feather icon-phone mr-25"></i>{{ optional($data->customers)->no_telp ?: '-' }}
                        </p>
                    </div>
                </div>
                <hr class="my-1">
                <div class="row">
                    <div class="col-md-6 col-6">
                        <small class="text-muted">Tanggal Masuk</small><br>
                        <b><i class="feather icon-calendar mr-25"></i>{{ carbon\carbon::parse($data->tgl_transaksi)->format('d M Y') }}</b>
                    </div>
                    <div class="col-md-6 col-6">
                        <small class="text-muted">Tanggal Diambil</small><br>
                        <b><i class="feather icon-calendar mr-25"></i>
                            {{ $data->tgl_ambil ? carbon\carbon::parse($data->tgl_ambil)->format('d M Y') : 'Belum Diambil' }}
                        </b>
                    </div>
                </div>
            </div>

            {{-- Items --}}
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
                        @foreach ($data->items as $i => $it)
                            @php $sub = (int) ($it->subtotal ?: round($it->kg * $it->harga)); @endphp
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    <b>{{ $it->jenis ?: optional($it->harga()->first())->jenis }}</b>
                                    @if ($it->hari)
                                        <br><small class="text-muted">{{ $it->hari }} hari pengerjaan</small>
                                    @endif
                                </td>
                                <td class="text-right">{{ $it->kg }} kg</td>
                                <td class="text-right">{{ Rupiah::getRupiah($it->harga) }}</td>
                                <td class="text-right text-bold-600">{{ Rupiah::getRupiah($sub) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Summary --}}
            <div class="card-body border-top">
                <div class="row">
                    <div class="col-md-7 col-12">
                        <h6 class="text-bold-600 mb-50">Metode Pembayaran</h6>
                        <p class="mb-50 small">
                            Jenis: <span class="badge badge-light-info">{{ $data->jenis_pembayaran ?: 'Belum Diketahui' }}</span>
                        </p>
                        @if ($bank->count())
                            <ol class="pl-2 mb-0 small">
                                @foreach ($bank as $banks)
                                    <li>{{ $banks->nama_bank }} — {{ $banks->no_rekening }} a/n {{ $banks->nama_pemilik }}</li>
                                @endforeach
                            </ol>
                        @endif
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
                            <h3 class="text-bold-700 mb-0 text-success">{{ Rupiah::getRupiah($data->harga_akhir) }}</h3>
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
                <a href="{{ url('cetak-invoice/'.$data->id.'/print') }}" target="_blank" class="btn btn-primary btn-block mb-50">
                    <i class="feather icon-printer mr-25"></i> Cetak / Download PDF
                </a>
                <a href="{{ url('pelayanan') }}" class="btn btn-outline-secondary btn-block">
                    <i class="feather icon-arrow-left mr-25"></i> Kembali ke Order
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
