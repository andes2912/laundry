@extends('layouts.backend')
@section('title','Admin - Data Finance')
@section('header','Data Finance')
@section('content')
<div class="row">
    <div class="col-lg-4 col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title">Data Finance</h4>
                <h4 class="card-title">
                  <span>{{Rupiah::getRupiah($all)}}</span>
                </h4>
            </div>
            <div class="card-content">
                <div class="card-body pt-50">
                    <div id="product-order-chart" class="mb-2"></div>
                    <div class="chart-info d-flex justify-content-between mb-1">
                        <div class="series-info d-flex align-items-center">
                            <i class="fa fa-circle-o text-bold-700 text-primary"></i>
                            <span class="text-bold-600 ml-50">Tahun Ini</span>
                        </div>
                        <div class="product-result">
                            <span>{{Rupiah::getRupiah($tahun)}}</span>
                        </div>
                    </div>

                    <div class="chart-info d-flex justify-content-between mb-1">
                        <div class="series-info d-flex align-items-center">
                            <i class="fa fa-circle-o text-bold-700 text-warning"></i>
                            <span class="text-bold-600 ml-50">Bulan Ini</span>
                        </div>
                        <div class="product-result">
                            <span>{{Rupiah::getRupiah($bulan)}}</span>
                        </div>
                    </div>

                    <div class="chart-info d-flex justify-content-between mb-25">
                        <div class="series-info d-flex align-items-center">
                            <i class="fa fa-circle-o text-bold-700 text-info"></i>
                            <span class="text-bold-600 ml-50">Hari Ini</span>
                        </div>
                        <div class="product-result">
                            <span>{{Rupiah::getRupiah($hari)}}</span>
                        </div>
                    </div>

                    {{-- <div class="chart-info d-flex justify-content-between mb-25">
                        <div class="series-info d-flex align-items-center">
                            <i class="fa fa-circle-o text-bold-700 text-danger"></i>
                            <span class="text-bold-600 ml-50">Sampai Saat Ini</span>
                        </div>
                        <div class="product-result">
                            <span>{{Rupiah::getRupiah($all)}}</span>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script type="text/javascript">

var $primary = '#7367F0';
var $danger = '#EA5455';
var $warning = '#FF9F43';
var $primary_light = '#9c8cfc';
var $warning_light = '#FFC085';
var $danger_light = '#f29292';

// Data Finance
var orderChartoptions = {
        chart: {
            height: 325,
            type: 'radialBar',
        },
        colors: [$primary, $warning, $danger],
        fill: {
          type: 'gradient',
          gradient: {
            enabled: true,
            shade: 'dark',
            type: 'vertical',
            shadeIntensity: 0.5,
            gradientToColors: [$primary_light, $warning_light, $danger_light],
            inverseColors: false,
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 100]
          },
        },
        stroke: {
            lineCap: 'round'
        },
        plotOptions: {
          radialBar: {
            size: 150,
              hollow: {
                  size: '20%'
              },
              track: {
                  strokeWidth: '100%',
                  margin: 15,
              },
              dataLabels: {
                  name: {
                      fontSize: '12px',
                  },
                  value: {
                      fontSize: '16px',
                  },
                  total: {
                      show: true,
                      label: 'Total Transaksi',

                      formatter: function (w) {
                          return [{{$transaksi->count()}}]
                      }
                  }
              }
          }
        },
        series: [{{$ny}}, {{$nm}} , {{$nd}} ],
        labels: ['Tahun Ini', 'Bulan Ini',  'Hari Ini'],
    }

   var orderChart = new ApexCharts(
        document.querySelector("#product-order-chart"),
        orderChartoptions
    );

    orderChart.render();
// End Data Finance


</script>
@endsection