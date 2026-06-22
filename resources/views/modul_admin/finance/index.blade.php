@extends('layouts.backend')
@section('title','Admin - Finance')
@section('header','Finance')
@section('content')

@php
    $diff = $incomeD - $incomeDOld;
    $diffPct = $incomeDOld > 0 ? round((($incomeD - $incomeDOld) / $incomeDOld) * 100, 1) : 0;
    $diffY = $incomeY - $incomeYOld;
    $progDay   = $target?->target_day   ? min(100, ($kgDay   / $target->target_day)   * 100) : 0;
    $progMonth = $target?->target_month ? min(100, ($kgMonth / $target->target_month) * 100) : 0;
    $progYear  = $target?->target_year  ? min(100, ($kgYear  / $target->target_year)  * 100) : 0;
@endphp

{{-- ============ HEADER ============ --}}
<div class="row mb-1">
    <div class="col-12">
        <h2 class="text-bold-700 mb-25">Finance Overview</h2>
        <p class="text-muted mb-0">Rekap pendapatan, target laundry, dan performa cabang.</p>
    </div>
</div>

{{-- ============ STAT CARDS PENDAPATAN ============ --}}
<div class="row">
    <div class="col-xl-3 col-md-6 col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-1">
                    <div style="display:inline-flex; align-items:center; justify-content:center; width:42px; height:42px; border-radius:50%; background:rgba(40,199,111,.15);">
                        <i class="feather icon-dollar-sign text-success"></i>
                    </div>
                    @if ($diff != 0)
                        <span class="badge {{ $diff > 0 ? 'badge-light-success' : 'badge-light-danger' }}" style="font-size:.7rem;">
                            <i class="feather icon-{{ $diff > 0 ? 'trending-up' : 'trending-down' }}"></i>
                            {{ $diffPct }}%
                        </span>
                    @endif
                </div>
                <h4 class="text-bold-700 mb-25">{{ Rupiah::getRupiah($incomeD) }}</h4>
                <p class="mb-0 text-muted">Pendapatan Hari Ini</p>
                <small class="text-muted">vs kemarin: {{ Rupiah::getRupiah($incomeDOld) }}</small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-1">
                    <div style="display:inline-flex; align-items:center; justify-content:center; width:42px; height:42px; border-radius:50%; background:rgba(0,207,232,.15);">
                        <i class="feather icon-calendar text-info"></i>
                    </div>
                </div>
                <h4 class="text-bold-700 mb-25">{{ Rupiah::getRupiah($incomeM) }}</h4>
                <p class="mb-0 text-muted">Bulan {{ date('F') }}</p>
                <small class="text-muted">{{ $kgMonth }} kg total laundry</small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-1">
                    <div style="display:inline-flex; align-items:center; justify-content:center; width:42px; height:42px; border-radius:50%; background:rgba(115,103,240,.15);">
                        <i class="feather icon-bar-chart-2 text-primary"></i>
                    </div>
                </div>
                <h4 class="text-bold-700 mb-25">{{ Rupiah::getRupiah($incomeY) }}</h4>
                <p class="mb-0 text-muted">Tahun {{ date('Y') }}</p>
                <small class="text-muted">Tahun lalu: {{ Rupiah::getRupiah($incomeYOld) }}</small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-1">
                    <div style="display:inline-flex; align-items:center; justify-content:center; width:42px; height:42px; border-radius:50%; background:rgba(255,159,67,.15);">
                        <i class="feather icon-award text-warning"></i>
                    </div>
                </div>
                <h4 class="text-bold-700 mb-25">{{ Rupiah::getRupiah($incomeAll) }}</h4>
                <p class="mb-0 text-muted">Total Keseluruhan</p>
                @php
                    $p = new NumberFormatter("id", NumberFormatter::SPELLOUT);
                    $result = preg_replace("/\..+/", "", $incomeAll);
                @endphp
                <small class="text-muted" style="font-size:.7rem;">{{ ucwords($p->format($result)) }} Rupiah</small>
            </div>
        </div>
    </div>
</div>

{{-- ============ TARGETS ============ --}}
<div class="card">
    <div class="card-header border-bottom">
        <h4 class="card-title mb-0">
            <i class="feather icon-target mr-50 text-primary"></i> Target Laundry
        </h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 col-12 mb-2 mb-md-0">
                <div class="d-flex justify-content-between mb-50">
                    <div>
                        <small class="text-muted text-uppercase">Per Hari</small>
                        <h5 class="text-bold-600 mb-0">{{ $kgDay }} <small class="text-muted">/ {{ $target->target_day ?? 0 }} kg</small></h5>
                    </div>
                    @if ($kgDay >= ($target->target_day ?? PHP_INT_MAX))
                        <span class="badge badge-success"><i class="feather icon-check-circle"></i> Tercapai</span>
                    @else
                        <span class="badge badge-light-warning">{{ number_format($progDay, 0) }}%</span>
                    @endif
                </div>
                <div class="progress" style="height:8px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width:{{ $progDay }}%"></div>
                </div>
            </div>
            <div class="col-md-4 col-12 mb-2 mb-md-0">
                <div class="d-flex justify-content-between mb-50">
                    <div>
                        <small class="text-muted text-uppercase">Per Bulan</small>
                        <h5 class="text-bold-600 mb-0">{{ $kgMonth }} <small class="text-muted">/ {{ $target->target_month ?? 0 }} kg</small></h5>
                    </div>
                    @if ($kgMonth >= ($target->target_month ?? PHP_INT_MAX))
                        <span class="badge badge-success"><i class="feather icon-check-circle"></i> Tercapai</span>
                    @else
                        <span class="badge badge-light-info">{{ number_format($progMonth, 0) }}%</span>
                    @endif
                </div>
                <div class="progress" style="height:8px;">
                    <div class="progress-bar bg-info" role="progressbar" style="width:{{ $progMonth }}%"></div>
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="d-flex justify-content-between mb-50">
                    <div>
                        <small class="text-muted text-uppercase">Per Tahun</small>
                        <h5 class="text-bold-600 mb-0">{{ $kgYear }} <small class="text-muted">/ {{ $target->target_year ?? 0 }} kg</small></h5>
                    </div>
                    @if ($kgYear >= ($target->target_year ?? PHP_INT_MAX))
                        <span class="badge badge-success"><i class="feather icon-check-circle"></i> Tercapai</span>
                    @else
                        <span class="badge badge-light-primary">{{ number_format($progYear, 0) }}%</span>
                    @endif
                </div>
                <div class="progress" style="height:8px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width:{{ $progYear }}%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============ CHART + CABANG ============ --}}
<div class="row">
    <div class="col-lg-8 col-12">
        <div class="card">
            <div class="card-header border-bottom">
                <div>
                    <h4 class="card-title mb-25">
                        <i class="feather icon-trending-up mr-50 text-primary"></i> Pendapatan Bulanan
                    </h4>
                    <small class="text-muted">{{ date('Y') }} · update real-time</small>
                </div>
            </div>
            <div class="card-body pb-0" style="min-height: 350px">
                <div id="month-chart"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-12">
        <div class="card h-100">
            <div class="card-header border-bottom">
                <h4 class="card-title mb-0">
                    <i class="feather icon-home mr-50 text-info"></i> Pendapatan per Cabang
                </h4>
            </div>
            <div class="card-body p-0">
                @forelse ($getCabang as $cabang)
                    @php
                        $cabangIncome = $cabang->transaksi()->sum('harga_akhir');
                    @endphp
                    <div class="d-flex justify-content-between align-items-center p-1 border-bottom">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset($cabang->foto == null ? 'backend/images/profile/user.jpg' : 'storage/images/foto_profile/'.$cabang->foto) }}"
                                 class="rounded mr-1" width="36" height="36" alt="Avatar"
                                 style="object-fit:cover;">
                            <div>
                                <h6 class="mb-0 text-bold-600" style="font-size:.85rem;">{{ $cabang->nama_cabang }}</h6>
                                <small class="text-muted">{{ $cabang->name }}</small>
                            </div>
                        </div>
                        <span class="text-bold-600 text-success" style="font-size:.85rem;">
                            {{ Rupiah::getRupiah($cabangIncome) }}
                        </span>
                    </div>
                @empty
                    <div class="p-2 text-center text-muted">
                        <i class="feather icon-inbox font-medium-3 d-block mb-50"></i>
                        Belum ada cabang aktif bulan ini.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script type="text/javascript">
  var $primary = '#7367F0';
  var $label_color = '#e7eef7';
  var $purple = '#df87f2';
  var $strok_color = '#b9c3cd';

  var salesavgChartoptions = {
      chart: {
        height: 320,
        toolbar: { show: false },
        type: 'line',
        dropShadow: { enabled: true, top: 20, left: 2, blur: 6, opacity: 0.20 },
      },
      stroke: { curve: 'smooth', width: 4 },
      grid: { borderColor: $label_color },
      legend: { show: false },
      colors: [$purple],
      fill: {
          type: 'gradient',
          gradient: {
              shade: 'dark',
              inverseColors: false,
              gradientToColors: [$primary],
              shadeIntensity: 1,
              type: 'horizontal',
              opacityFrom: 1,
              opacityTo: 1,
              stops: [0, 100, 100, 100]
          },
      },
      markers: { size: 0, hover: { size: 5 } },
      xaxis: {
          labels: { style: { colors: $strok_color } },
          axisTicks: { show: false },
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
          axisBorder: { show: false },
          tickPlacement: 'on'
      },
      yaxis: {
          tickAmount: 5,
          labels: {
              style: { color: $strok_color },
              formatter: function(val) { return 'Rp ' + Number(val).toLocaleString('id-ID'); }
          }
      },
      tooltip: { x: { show: false }, y: { formatter: function(v) { return 'Rp ' + Number(v).toLocaleString('id-ID'); } } },
      series: [{ name: "Pendapatan", data: [{{ $chartMonth }}] }],
    };

   var salesavgChart = new ApexCharts(document.querySelector("#month-chart"), salesavgChartoptions);
   salesavgChart.render();
</script>
@endsection
