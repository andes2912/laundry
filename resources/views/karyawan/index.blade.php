@extends('layouts.backend')
@section('title','Dashboard Karyawan')

@section('content')
@php
    $hour     = (int) date('H');
    $greeting = $hour < 11 ? 'Selamat Pagi'
                : ($hour < 15 ? 'Selamat Siang'
                : ($hour < 18 ? 'Selamat Sore' : 'Selamat Malam'));
    $persenAbs = round(abs($persen ?? 0), 1);
    $naik      = ($incomeM ?? 0) >= ($incomeMOld ?? 0);
    $cabang    = Auth::user()->cabang;
@endphp

{{-- ============ GREETING + QUICK ACTIONS ============ --}}
<div class="row mb-1">
    <div class="col-md-7 col-12">
        <h2 class="text-bold-700 mb-25">{{ $greeting }}, {{ explode(' ', Auth::user()->name)[0] }} 👋</h2>
        <p class="text-muted mb-0">
            @if($cabang)
                Cabang <strong>{{ $cabang->nama }}</strong>
                @if($cabang->alamat) · <span class="text-muted">{{ Str::limit($cabang->alamat, 50) }}</span> @endif
                · {{ date('l, d F Y') }}
            @else
                {{ date('l, d F Y') }}
            @endif
        </p>
    </div>
    <div class="col-md-5 col-12 text-md-right mt-1 mt-md-0">
        <a href="{{ url('pelayanan/create') }}" class="btn btn-primary mr-50 mb-50">
            <i class="feather icon-plus mr-25"></i> Order Baru
        </a>
        <a href="{{ url('customers-create') }}" class="btn btn-outline-primary mr-50 mb-50">
            <i class="feather icon-user-plus mr-25"></i> Customer
        </a>
        <a href="{{ url('laporan') }}" class="btn btn-outline-primary mb-50">
            <i class="feather icon-file-text mr-25"></i> Laporan
        </a>
    </div>
</div>

{{-- ============ STAT CARDS ============ --}}
<div class="row">
    <div class="col-xl-3 col-lg-6 col-sm-6 col-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-bold-700 mb-0">{{ $customer->count() }}</h2>
                    <p class="mb-0 text-muted">Customer Saya</p>
                    <small class="text-info"><i class="feather icon-users"></i> Aktif terdaftar</small>
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
                    <p class="mb-0 text-muted">Order Masuk</p>
                    <small class="text-info"><i class="feather icon-package"></i> Sedang diproses</small>
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
                    <p class="mb-0 text-muted">Selesai</p>
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

{{-- ============ PENDAPATAN + KG ============ --}}
<div class="row">
    <div class="col-lg-4 col-md-6 col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-1">
                    <div>
                        <h6 class="text-muted mb-25">Pendapatan Bulan Ini</h6>
                        <h3 class="text-bold-700 mb-0">{{ Rupiah::getRupiah($incomeM) }}</h3>
                    </div>
                    <div class="avatar bg-rgba-success p-50 m-0">
                        <div class="avatar-content">
                            <i class="feather icon-dollar-sign text-success"></i>
                        </div>
                    </div>
                </div>
                <p class="card-text font-small-2 mb-0">
                    @if(($incomeM ?? 0) == 0 && ($incomeMOld ?? 0) == 0)
                        <span class="text-muted">Belum ada data perbandingan</span>
                    @else
                        <span class="badge badge-light-{{ $naik ? 'success' : 'danger' }} mr-25">
                            <i class="feather icon-trending-{{ $naik ? 'up' : 'down' }}"></i> {{ $persenAbs }}%
                        </span>
                        {{ $naik ? 'naik' : 'turun' }} dari bulan lalu
                    @endif
                </p>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-1">
                    <div>
                        <h6 class="text-muted mb-25">Hari Ini</h6>
                        <h3 class="text-bold-700 mb-0">
                            {{ $kgToday ?: 0 }}
                            <small class="text-muted" style="font-size:.85rem">kg</small>
                        </h3>
                    </div>
                    <div class="avatar bg-rgba-info p-50 m-0">
                        <div class="avatar-content">
                            <i class="feather icon-sun text-info"></i>
                        </div>
                    </div>
                </div>
                <p class="card-text font-small-2 mb-0 text-muted">
                    Total berat laundry diproses {{ date('l') }}
                </p>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-12 col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-1">
                    <div>
                        <h6 class="text-muted mb-25">Kemarin</h6>
                        <h3 class="text-bold-700 mb-0">
                            {{ $kgTodayOld ?: 0 }}
                            <small class="text-muted" style="font-size:.85rem">kg</small>
                        </h3>
                    </div>
                    <div class="avatar bg-rgba-warning p-50 m-0">
                        <div class="avatar-content">
                            <i class="feather icon-clock text-warning"></i>
                        </div>
                    </div>
                </div>
                <p class="card-text font-small-2 mb-0 text-muted">
                    Total {{ date("l", strtotime("-1 day")) }} kemarin
                </p>
            </div>
        </div>
    </div>
</div>

{{-- ============ CHART + RECENT ORDERS ============ --}}
<div class="row">
    <div class="col-lg-7 col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="card-title mb-0">Order Masuk · Bulanan</h4>
                    <p class="card-text font-small-2 mb-0 text-muted">
                        Performa cabang tahun {{ date('Y') }}
                    </p>
                </div>
                <span class="badge badge-light-primary">{{ array_sum(explode(',', $_nilaiB)) }} order</span>
            </div>
            <div class="card-content">
                <div class="card-body pb-0">
                    <div id="data-bulan"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-5 col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="card-title mb-0">Order Terbaru</h4>
                    <p class="card-text font-small-2 mb-0 text-muted">6 transaksi terakhir kamu</p>
                </div>
                <a href="{{ url('pelayanan') }}" class="btn btn-flat-primary btn-sm">
                    Semua <i class="feather icon-chevron-right"></i>
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Invoice</th>
                            <th>Status</th>
                            <th class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recent as $trx)
                            <tr>
                                <td>
                                    <a href="{{ url('invoice-kar', $trx->id) }}" class="text-bold-600">
                                        {{ $trx->invoice ?? '#'.$trx->id }}
                                    </a>
                                    <br><small class="text-muted">{{ \Carbon\Carbon::parse($trx->created_at)->diffForHumans() }}</small>
                                </td>
                                <td>
                                    @php
                                        $st  = $trx->status_order ?? 'Process';
                                        $cls = match($st) {
                                            'Done'     => 'badge-light-success',
                                            'Delivery' => 'badge-light-warning',
                                            'Process'  => 'badge-light-info',
                                            default    => 'badge-light-secondary',
                                        };
                                    @endphp
                                    <span class="badge {{ $cls }}">{{ $st }}</span>
                                </td>
                                <td class="text-right text-bold-600">
                                    {{ Rupiah::getRupiah($trx->harga_akhir ?? 0) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-3 text-muted">
                                    <i class="feather icon-inbox font-medium-3 d-block mb-50"></i>
                                    Belum ada order
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
// ===== Chart Bulanan (theme-aware) =====
var $isDark      = document.body.classList.contains('dark-layout');
var $primary     = '#7367F0';
var $purple      = '#df87f2';
var $label_color = $isDark ? '#3b4253' : '#e7eef7';
var $strok_color = $isDark ? '#b4b7bd' : '#b9c3cd';

var MONTHS = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

var salesavgChart = new ApexCharts(document.querySelector("#data-bulan"), {
    chart: { height: 280, toolbar: { show:false }, type:'area',
        dropShadow:{ enabled:true, top:8, left:2, blur:6, opacity:0.15 } },
    stroke:{ curve:'smooth', width:3 },
    grid:  { borderColor:$label_color, strokeDashArray:5 },
    legend:{ show:false },
    colors:[$purple],
    fill:  { type:'gradient', gradient:{
        shade:'dark', inverseColors:false, gradientToColors:[$primary],
        shadeIntensity:1, type:'horizontal', opacityFrom:0.9, opacityTo:0.6,
        stops:[0,100,100,100]
    }},
    markers:{ size:0, hover:{ size:5 } },
    xaxis: { labels:{ style:{ colors:$strok_color }}, axisTicks:{ show:false },
             categories:MONTHS, axisBorder:{ show:false }, tickPlacement:'on' },
    yaxis: { tickAmount:5, labels:{ style:{ color:$strok_color },
             formatter:function(v){ return v>999?(v/1000).toFixed(1)+'k':v; }}},
    tooltip:{ x:{ show:false }, theme: $isDark ? 'dark' : 'light' },
    series:[{ name:"Order Masuk", data:[{{ $_nilaiB }}] }],
});
salesavgChart.render();
</script>
@endsection
