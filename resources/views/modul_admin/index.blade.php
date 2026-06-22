@extends('layouts.backend')
@section('title','Dashboard Admin')

@section('content')
@php
    $hour      = (int) date('H');
    $greeting  = $hour < 11 ? 'Selamat Pagi'
                : ($hour < 15 ? 'Selamat Siang'
                : ($hour < 18 ? 'Selamat Sore' : 'Selamat Malam'));
    $deltaIncomeM = ($incomeM ?? 0) - ($incomeDOld ?? 0); // hanya untuk indikator visual
    $totalBayar   = ($sudahbayar ?? 0) + ($belumbayar ?? 0);
    $persenBayar  = $totalBayar > 0 ? round(($sudahbayar / $totalBayar) * 100) : 0;
@endphp

{{-- ============= HEADER GREETING & QUICK ACTIONS ============= --}}
<div class="row mb-1">
    <div class="col-md-7 col-12">
        <h2 class="text-bold-700 mb-25">{{ $greeting }}, {{ explode(' ', Auth::user()->name)[0] }} 👋</h2>
        <p class="text-muted mb-0">
            Selamat datang kembali. Berikut ringkasan operasional laundry kamu hari ini,
            <span class="text-bold-600">{{ date('l, d F Y') }}</span>.
        </p>
    </div>
    <div class="col-md-5 col-12 text-md-right mt-1 mt-md-0">
        <a href="{{ route('transaksi.create') }}" class="btn btn-primary mr-50 mb-50">
            <i class="feather icon-plus mr-25"></i> Transaksi Baru
        </a>
        <a href="{{ route('karyawan.create') }}" class="btn btn-outline-primary mr-50 mb-50">
            <i class="feather icon-user-plus mr-25"></i> Karyawan
        </a>
        <a href="{{ route('customer.create') }}" class="btn btn-outline-primary mb-50">
            <i class="feather icon-users mr-25"></i> Customer
        </a>
    </div>
</div>

{{-- ============= STAT CARDS ============= --}}
<div class="row">
    <div class="col-xl-3 col-lg-6 col-sm-6 col-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-bold-700 mb-0">{{ $customer->count() }}</h2>
                    <p class="mb-0 text-muted">Total Customer</p>
                    <small class="text-success"><i class="feather icon-trending-up"></i> Aktif terdaftar</small>
                </div>
                <div class="avatar bg-rgba-primary p-50 m-0">
                    <div class="avatar-content">
                        <i class="feather icon-users text-primary font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-sm-6 col-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-bold-700 mb-0">{{ $masuk }}</h2>
                    <p class="mb-0 text-muted">Laundry Masuk</p>
                    <small class="text-info"><i class="feather icon-package"></i> Dalam proses</small>
                </div>
                <div class="avatar bg-rgba-success p-50 m-0">
                    <div class="avatar-content">
                        <i class="feather icon-box text-success font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-sm-6 col-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-bold-700 mb-0">{{ $selesai }}</h2>
                    <p class="mb-0 text-muted">Laundry Selesai</p>
                    <small class="text-success"><i class="feather icon-check-circle"></i> Siap diambil</small>
                </div>
                <div class="avatar bg-rgba-danger p-50 m-0">
                    <div class="avatar-content">
                        <i class="feather icon-check text-danger font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-sm-6 col-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-bold-700 mb-0">{{ $diambil }}</h2>
                    <p class="mb-0 text-muted">Sudah Diambil</p>
                    <small class="text-warning"><i class="feather icon-check-square"></i> Terkirim</small>
                </div>
                <div class="avatar bg-rgba-warning p-50 m-0">
                    <div class="avatar-content">
                        <i class="feather icon-check-square text-warning font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============= REVENUE SUMMARY ============= --}}
<div class="row">
    <div class="col-12">
        <div class="card card-statistics">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="card-title mb-0">Ringkasan Pendapatan</h4>
                    <p class="card-text font-small-2 mr-25 mb-0 text-muted">
                        Performa keuangan harian, bulanan & tahunan
                    </p>
                </div>
                <a href="{{ route('finance.index') }}" class="btn btn-flat-primary btn-sm">
                    Detail Finance <i class="feather icon-chevron-right"></i>
                </a>
            </div>
            <div class="card-body statistics-body">
                <div class="row">
                    <div class="col-xl col-md-6 col-12 mb-2 mb-xl-0">
                        <div class="media">
                            <div class="avatar bg-rgba-success mr-2">
                                <div class="avatar-content">
                                    <i class="feather icon-sun text-success"></i>
                                </div>
                            </div>
                            <div class="media-body my-auto">
                                <h5 class="font-weight-bolder mb-0">{{ Rupiah::getRupiah($incomeD) }}</h5>
                                <p class="card-text font-small-2 mb-0 text-muted">Hari ini · {{ date('l') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl col-md-6 col-12 mb-2 mb-xl-0">
                        <div class="media">
                            <div class="avatar bg-rgba-warning mr-2">
                                <div class="avatar-content">
                                    <i class="feather icon-clock text-warning"></i>
                                </div>
                            </div>
                            <div class="media-body my-auto">
                                <h5 class="font-weight-bolder mb-0">{{ Rupiah::getRupiah($incomeDOld) }}</h5>
                                <p class="card-text font-small-2 mb-0 text-muted">Kemarin · {{ date("l", strtotime("-1 day")) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl col-md-6 col-12 mb-2 mb-xl-0">
                        <div class="media">
                            <div class="avatar bg-rgba-info mr-2">
                                <div class="avatar-content">
                                    <i class="feather icon-calendar text-info"></i>
                                </div>
                            </div>
                            <div class="media-body my-auto">
                                <h5 class="font-weight-bolder mb-0">{{ Rupiah::getRupiah($incomeM) }}</h5>
                                <p class="card-text font-small-2 mb-0 text-muted">Bulan ini · {{ date('F') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl col-md-6 col-12 mb-2 mb-xl-0">
                        <div class="media">
                            <div class="avatar bg-rgba-primary mr-2">
                                <div class="avatar-content">
                                    <i class="feather icon-trending-up text-primary"></i>
                                </div>
                            </div>
                            <div class="media-body my-auto">
                                <h5 class="font-weight-bolder mb-0">{{ Rupiah::getRupiah($incomeY) }}</h5>
                                <p class="card-text font-small-2 mb-0 text-muted">Tahun ini · {{ date('Y') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl col-md-6 col-12 mb-2 mb-sm-0">
                        <div class="media">
                            <div class="avatar bg-rgba-danger mr-2">
                                <div class="avatar-content">
                                    <i class="feather icon-archive text-danger"></i>
                                </div>
                            </div>
                            <div class="media-body my-auto">
                                <h5 class="font-weight-bolder mb-0">{{ Rupiah::getRupiah($incomeYOld) }}</h5>
                                <p class="card-text font-small-2 mb-0 text-muted">Tahun lalu · {{ date("Y", strtotime("-1 year")) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============= CHARTS ============= --}}
<div class="row">
    <div class="col-lg-8 col-xl-8 col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="card-title mb-0">Laundry Masuk · Harian</h4>
                    <p class="card-text font-small-2 mb-0 text-muted">Bulan {{ date('F Y') }}</p>
                </div>
                <span class="badge badge-light-primary">{{ array_sum(explode(',', $_nilai)) }} order</span>
            </div>
            <div class="card-content">
                <div class="card-body pb-0">
                    <div id="data-hari"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-xl-4 col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="card-title mb-0">Status Pembayaran</h4>
                    <p class="card-text font-small-2 mb-0 text-muted">Lunas vs Belum dibayar</p>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-50">
                    <span class="text-success">
                        <i class="feather icon-check-circle"></i> Sudah dibayar
                    </span>
                    <span class="text-bold-600">{{ $sudahbayar }}</span>
                </div>
                <div class="progress progress-bar-success mb-1" style="height:6px">
                    <div class="progress-bar" role="progressbar" style="width: {{ $persenBayar }}%"></div>
                </div>
                <div class="d-flex justify-content-between mb-50">
                    <span class="text-danger">
                        <i class="feather icon-alert-circle"></i> Belum dibayar
                    </span>
                    <span class="text-bold-600">{{ $belumbayar }}</span>
                </div>
                <div class="progress progress-bar-danger mb-2" style="height:6px">
                    <div class="progress-bar" role="progressbar" style="width: {{ 100 - $persenBayar }}%"></div>
                </div>
                <div class="text-center pt-1 border-top">
                    <h3 class="text-bold-700 mb-0">{{ $persenBayar }}%</h3>
                    <small class="text-muted">Tingkat pembayaran sukses</small>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============= MONTHLY CHART + RECENT TRANSAKSI ============= --}}
<div class="row">
    <div class="col-lg-5 col-xl-5 col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="card-title mb-0">Laundry Masuk · Bulanan</h4>
                    <p class="card-text font-small-2 mb-0 text-muted">Tahun {{ date('Y') }}</p>
                </div>
                <span class="badge badge-light-success">{{ array_sum(explode(',', $_nilaiB)) }} order</span>
            </div>
            <div class="card-content">
                <div class="card-body pb-0">
                    <div id="data-bulan"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-7 col-xl-7 col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="card-title mb-0">Transaksi Terbaru</h4>
                    <p class="card-text font-small-2 mb-0 text-muted">8 transaksi terakhir</p>
                </div>
                <a href="{{ route('transaksi.index') }}" class="btn btn-flat-primary btn-sm">
                    Lihat Semua <i class="feather icon-chevron-right"></i>
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Invoice</th>
                            <th>Customer</th>
                            <th>Status</th>
                            <th>Bayar</th>
                            <th class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recent as $trx)
                            <tr>
                                <td>
                                    <a href="{{ route('transaksi.show', $trx->id) }}" class="text-bold-600">
                                        {{ $trx->no_invoice ?? '#'.$trx->id }}
                                    </a>
                                    <br><small class="text-muted">{{ \Carbon\Carbon::parse($trx->created_at)->diffForHumans() }}</small>
                                </td>
                                <td>
                                    {{ optional(\App\Models\User::find($trx->customer_id))->name ?? 'Walk-in' }}
                                </td>
                                <td>
                                    @php
                                        $st = $trx->status_order ?? 'Process';
                                        $cls = match($st) {
                                            'Done'     => 'badge-light-success',
                                            'Delivery' => 'badge-light-warning',
                                            'Process'  => 'badge-light-info',
                                            default    => 'badge-light-secondary',
                                        };
                                    @endphp
                                    <span class="badge {{ $cls }}">{{ $st }}</span>
                                </td>
                                <td>
                                    @if(($trx->status_payment ?? '') === 'Success')
                                        <span class="badge badge-light-success">Lunas</span>
                                    @else
                                        <span class="badge badge-light-danger">Pending</span>
                                    @endif
                                </td>
                                <td class="text-right text-bold-600">
                                    {{ Rupiah::getRupiah($trx->harga_akhir ?? 0) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-3 text-muted">
                                    <i class="feather icon-inbox font-medium-3 d-block mb-50"></i>
                                    Belum ada transaksi
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
// Theme-aware chart color
var $isDark      = document.body.classList.contains('dark-layout');
var $primary     = '#7367F0';
var $purple      = '#df87f2';
var $label_color = $isDark ? '#3b4253' : '#e7eef7';
var $strok_color = $isDark ? '#b4b7bd' : '#b9c3cd';

var MONTHS = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

// ===== Chart Bulanan =====
var monthlyChart = new ApexCharts(document.querySelector("#data-bulan"), {
    chart: { height: 270, toolbar: { show:false }, type:'area',
        dropShadow:{ enabled:true, top:8, left:2, blur:6, opacity:0.15 } },
    stroke: { curve:'smooth', width:3 },
    grid:   { borderColor:$label_color, strokeDashArray:5 },
    legend: { show:false },
    colors: [$purple],
    fill: { type:'gradient', gradient:{
        shade:'dark', inverseColors:false, gradientToColors:[$primary],
        shadeIntensity:1, type:'horizontal', opacityFrom:0.9, opacityTo:0.6,
        stops:[0,100,100,100]
    }},
    markers: { size:0, hover:{ size:5 } },
    xaxis:   { labels:{ style:{ colors:$strok_color }}, axisTicks:{ show:false },
               categories:MONTHS, axisBorder:{ show:false }, tickPlacement:'on' },
    yaxis:   { tickAmount:5, labels:{ style:{ color:$strok_color },
               formatter:function(v){ return v>999?(v/1000).toFixed(1)+'k':v; }}},
    tooltip: { x:{ show:false }, theme: $isDark ? 'dark' : 'light' },
    series: [{ name:"Laundry Masuk", data:[{{ $_nilaiB }}] }],
});
monthlyChart.render();

// ===== Chart Harian =====
var dailyChart = new ApexCharts(document.querySelector("#data-hari"), {
    chart: { height: 270, toolbar:{ show:false }, type:'area',
        dropShadow:{ enabled:true, top:8, left:2, blur:6, opacity:0.15 } },
    stroke: { curve:'smooth', width:3 },
    grid:   { borderColor:$label_color, strokeDashArray:5 },
    legend: { show:false },
    colors: [$primary],
    fill: { type:'gradient', gradient:{
        shade:'dark', inverseColors:false, gradientToColors:[$purple],
        shadeIntensity:1, type:'horizontal', opacityFrom:0.9, opacityTo:0.6,
        stops:[0,100,100,100]
    }},
    markers: { size:0, hover:{ size:5 } },
    xaxis:   { labels:{ style:{ colors:$strok_color }}, axisTicks:{ show:false },
               categories:[{{ $_tanggal }}], axisBorder:{ show:false }, tickPlacement:'on' },
    yaxis:   { tickAmount:5, labels:{ style:{ color:$strok_color },
               formatter:function(v){ return v>999?(v/1000).toFixed(1)+'k':v; }}},
    tooltip: { x:{ show:false }, theme: $isDark ? 'dark' : 'light' },
    series: [{ name:"Laundry Masuk", data:[{{ $_nilai }}] }],
});
dailyChart.render();
</script>
@endsection
