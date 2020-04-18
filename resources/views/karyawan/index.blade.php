@extends('layouts.backend')
@section('title','Dashboard Karyawan')
@section('content')
    {{-- <!-- Column -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <!-- Row -->
                <div class="row">
                    <div class="col-8"><h2>{{$customer->count()}} <i class=" font-14 text-danger"></i></h2>
                        <h6>Jumlah Customer</h6></div>
                    <div class="col-4 align-self-center text-right  p-l-0">
                        <div id="sparklinedash3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <!-- Row -->
                <div class="row">
                    <div class="col-8"><h2 class="">{{$masuk}} <i class=" font-14 text-success"></i></h2>
                        <h6>Laundry Masuk</h6></div>
                    <div class="col-4 align-self-center text-right p-l-0">
                        <div id="sparklinedash"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <!-- Row -->
                <div class="row">
                    <div class="col-8"><h2>{{$selesai}} <i class=" font-14 text-success"></i></h2>
                        <h6>Laundry Selesai</h6></div>
                    <div class="col-4 align-self-center text-right p-l-0">
                        <div id="sparklinedash2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <!-- Row -->
                <div class="row">
                    <div class="col-8"><h2>{{$diambil}} <i class=" font-14 text-danger"></i></h2>
                        <h6>Laundry Diambil</h6></div>
                    <div class="col-4 align-self-center text-right p-l-0">
                        <div id="sparklinedash4"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <!-- LINE CHART -->
        <div class="card">
            <div class="card-body">
            <h4 class="card-title m-b-0">Grafik Jumlah Laundry Masuk</h4>
        </div>
            <div class="card-body">
            <div class="amp-pxl m-t-90" style="height: 390px;" id="linechart"></div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <div class="col-md-5">
        <!-- Column -->
        <div class="card card-default">
            <div class="card-header">
                <div class="card-actions">
                    <a class="" data-action="collapse"><i class="ti-minus"></i></a>
                    <a class="btn-minimize" data-action="expand"><i class="mdi mdi-arrow-expand"></i></a>
                    <a class="btn-close" data-action="close"><i class="ti-close"></i></a>
                </div>
                <h4 class="card-title m-b-0">Payment Stats</h4>
            </div>
            <div class="card-body collapse show">
            <div id="morris-donut-chart" class="ecomm-donute" style="height: 317px;"></div>
                <ul class="list-inline m-t-20 text-center">
                <li >
                    <h6 class="text-muted"><i class="fa fa-circle text-info"></i> Masuk</h6>
                    <h4 class="m-b-0">{{$masuk}}</h4>
                </li>
                <li>
                    <h6 class="text-muted"><i class="fa fa-circle text-success"></i> Sudah Bayar</h6>
                    <h4 class="m-b-0">{{$sudahbayar}}</h4>
                </li>
                <li>
                    <h6 class="text-muted"> <i class="fa fa-circle text-danger"></i> Belum Bayar</h6>
                    <h4 class="m-b-0">{{$belumbayar}}</h4>
                </li>
            </ul>
            </div>
        </div>
    </div> --}}
    <div class="row">
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2 class="text-bold-700 mb-0">{{$customer->count()}}</h2>
                        <p>Jumlah Customer</p>
                    </div>
                    <div class="avatar bg-rgba-primary p-50 m-0">
                        <div class="avatar-content">
                            <i class="feather icon-cpu text-primary font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2 class="text-bold-700 mb-0">{{$masuk}}</h2>
                        <p>Laundry Masuk</p>
                    </div>
                    <div class="avatar bg-rgba-success p-50 m-0">
                        <div class="avatar-content">
                            <i class="feather icon-server text-success font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2 class="text-bold-700 mb-0">{{$selesai}}</h2>
                        <p>Laundry Selesai</p>
                    </div>
                    <div class="avatar bg-rgba-danger p-50 m-0">
                        <div class="avatar-content">
                            <i class="feather icon-activity text-danger font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2 class="text-bold-700 mb-0">{{$diambil}}</h2>
                        <p>Laundry Diambil</p>
                    </div>
                    <div class="avatar bg-rgba-warning p-50 m-0">
                        <div class="avatar-content">
                            <i class="feather icon-alert-octagon text-warning font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-xl-6 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title">Data Per-bulan</h4>
                </div>
                <div class="card-content">
                    <div class="card-body pb-0">
                        <div id="data-bulan"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-xl-6 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title">Data Per-hari</h4>
                </div>
                <div class="card-content">
                    <div class="card-body pb-0">
                        <div id="data-hari"></div>
                    </div>
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

// Bar Data Bulan
var salesavgChartoptions = {
      chart: {
        height: 270,
        toolbar: { show: false },
        type: 'line',
        dropShadow: {
            enabled: true,
            top: 20,
            left: 2,
            blur: 6,
            opacity: 0.20
        },
      },
      stroke: {
          curve: 'smooth',
          width: 4,
      },
      grid: {
          borderColor: $label_color,
      },
      legend: {
          show: false,
      },
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
      markers: {
          size: 0,
          hover: {
              size: 5
          }
      },
      xaxis: {
          labels: {
              style: {
                  colors: $strok_color,
              }
          },
          axisTicks: {
              show: false,
          },
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Juni', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
          axisBorder: {
              show: false,
          },
          tickPlacement: 'on'
      },
      yaxis: {
          tickAmount: 5,
          labels: {
              style: {
                  color: $strok_color,
              },
              formatter: function(val) {
                  return val > 999 ? (val / 1000).toFixed(1) + 'k' : val;
              }
          }
      },
      tooltip: {
          x: { show: false }
      },
      series: [{
            name: "Bulan",
            data: [{{$jan}}, {{$feb}}, {{$mar}}, {{$apr}}, {{$mey}}, {{$juni}}, {{$july}}, {{$aug}}, {{$sep}}, {{$oct}}, {{$nov}}, {{$dec}}]
        }],

    }

   var salesavgChart = new ApexCharts(
        document.querySelector("#data-bulan"),
        salesavgChartoptions
    );

    salesavgChart.render();
// End Bar Data Bulan

// Bar Data Hari
// Bar
var salesavgChartoptions = {
      chart: {
        height: 270,
        toolbar: { show: false },
        type: 'line',
        dropShadow: {
            enabled: true,
            top: 20,
            left: 2,
            blur: 6,
            opacity: 0.20
        },
      },
      stroke: {
          curve: 'smooth',
          width: 2,
      },
      grid: {
          borderColor: $label_color,
      },
      legend: {
          show: false,
      },
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
      markers: {
          size: 0,
          hover: {
              size: 5
          }
      },
      xaxis: {
          labels: {
              style: {
                  colors: $strok_color,
              }
          },
          axisTicks: {
              show: false,
          },
          categories: [{{$_tanggal}}],
          axisBorder: {
              show: false,
          },
          tickPlacement: 'on'
      },
      yaxis: {
          tickAmount: 5,
          labels: {
              style: {
                  color: $strok_color,
              },
              formatter: function(val) {
                  return val > 999 ? (val / 1000).toFixed(1) + 'k' : val;
              }
          }
      },
      tooltip: {
          x: { show: false }
      },
      series: [{
            name: "Tanggal",
            data: [{{$_nilai}}]
        }],

    }

   var salesavgChart = new ApexCharts(
        document.querySelector("#data-hari"),
        salesavgChartoptions
    );

    salesavgChart.render();
// End Bar Data Hari
</script>
@endsection