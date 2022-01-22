@extends('layouts.backend')
@section('title','Dashboard Karyawan')
@section('content')
  <div class="row match-height">
      <div class="col-xl-4 col-md-6 col-12">
          <div class="card card-congratulation-medal">
              <div class="card-body">
                  <h5>Welcome 🎉 {{Auth::user()->name}}!</h5>
                  <p class="card-text font-small-2">Semoga harimu menyenangkan.</p> <br>
                  {{date('l, d F Y')}}, {{date('H:i:s')}}
              </div>
          </div>
      </div>
      <!--/ Medal Card -->

      <!-- Statistics Card -->
      <div class="col-xl-8 col-md-6 col-12">
          <div class="card card-statistics">
              <div class="card-header">
                  <h4 class="card-title">Statistics</h4>
                  <div class="d-flex align-items-center">
                      <p class="card-text font-small-2 mr-25 mb-0">Updated 1 month ago</p>
                  </div>
              </div>
              <div class="card-body statistics-body">
                  <div class="row">
                      <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                          <div class="media">
                              <div class="avatar bg-light-primary mr-2">
                                  <div class="avatar-content">
                                      <i class="feather icon-users text-primary font-medium-5"></i>
                                  </div>
                              </div>
                              <div class="media-body my-auto">
                                  <h4 class="font-weight-bolder mb-0">{{$customer->count()}}</h4>
                                  <p class="card-text font-small-1 mb-0">Customers</p>
                              </div>
                          </div>
                      </div>
                      <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                          <div class="media">
                              <div class="avatar bg-light-info mr-2">
                                  <div class="avatar-content">
                                      <i class="feather icon-box text-success font-medium-5"></i>
                                  </div>
                              </div>
                              <div class="media-body my-auto">
                                  <h4 class="font-weight-bolder mb-0">{{$masuk}}</h4>
                                  <p class="card-text font-small-1 mb-0">Laundry Masuk</p>
                              </div>
                          </div>
                      </div>
                      <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-sm-0">
                          <div class="media">
                              <div class="avatar bg-light-danger mr-2">
                                  <div class="avatar-content">
                                      <i class="feather icon-check text-danger font-medium-5"></i>
                                  </div>
                              </div>
                              <div class="media-body my-auto">
                                  <h4 class="font-weight-bolder mb-0"> {{$selesai}} </h4>
                                  <p class="card-text font-small-1 mb-0">Laundry Selesai</p>
                              </div>
                          </div>
                      </div>
                      <div class="col-xl-3 col-sm-6 col-12">
                          <div class="media">
                              <div class="avatar bg-light-success mr-2">
                                  <div class="avatar-content">
                                      <i class="feather icon-check-square text-warning font-medium-5"></i>
                                  </div>
                              </div>
                              <div class="media-body my-auto">
                                  <h4 class="font-weight-bolder mb-0">{{$diambil}}</h4>
                                  <p class="card-text font-small-1 mb-0">Laundry Diambil</p>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <!--/ Statistics Card -->
  </div>

  <div class="row match-height">
    <div class="col-lg-4 col-12">
        <div class="row match-height">
            <!-- Bar Chart - Orders -->
            <div class="col-lg-6 col-md-3 col-6">
                <div class="card">
                    <div class="card-body pb-50">
                        <h4>Hari ini</h4>
                        <h6 class="font-weight-bolder mb-1">{{$kgToday}} <span style="font-style: italic; font-size:9px">Kg</span> </h6>
                        <span style="font-size:10px">Kilogram</span>
                    </div>
                </div>
            </div>
            <!--/ Bar Chart - Orders -->

            <!-- Line Chart - Profit -->
            <div class="col-lg-6 col-md-3 col-6">
                <div class="card card-tiny-line-stats">
                    <div class="card-body pb-50">
                        <h4>Kemarin</h4>
                        <h6 class="font-weight-bolder mb-1">{{$kgTodayOld}} <span style="font-style: italic; font-size:9px">Kg</span></h6>
                        <span style="font-size:10px">Kilogram</span>
                    </div>
                </div>
            </div>
            <!--/ Line Chart - Profit -->

            <!-- Earnings Card -->
            <div class="col-lg-12 col-md-6 col-12">
                <div class="card earnings-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="card-title mb-1">Pendapatan</h4>
                                <div class="font-small-2">Bulan Ini</div>
                                <h5 class="mb-1">{{Rupiah::getRupiah($incomeM)}}</h5>
                                <p class="card-text text-muted font-small-2">
                                  <span> Pendapatan {{$incomeM >= $incomeMOld ? 'naik' : 'turun'}} </span> <span class="font-weight-bolder">{{$persen}}%</span> <span> dari bulan kemarin.</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Earnings Card -->
        </div>
    </div>

    <div class="col-lg-8 col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title">Data Laundry Masuk Per-bulan</h4>
            </div>
            <div class="card-content">
                <div class="card-body pb-0">
                    <div id="data-bulan"></div>
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
var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
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
          categories: MONTHS,
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
            name: "Laundry Masuk",
            data: [{{$_nilaiB}}]
        }],

    }

   var salesavgChart = new ApexCharts(
        document.querySelector("#data-bulan"),
        salesavgChartoptions
    );

    salesavgChart.render();
// End Bar Data Bulan
</script>
@endsection