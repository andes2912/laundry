@extends('layouts.backend')
@section('title','Admin - Data Finance')
@section('header','Data Finance')
@section('content')
{{-- <div class="col-lg-12">
    <div class="row">
        <div class="col-md-6 col-lg-4 col-xlg-2">
            <div class="card card-inverse card-info">
                <div class="box bg-info text-center">
                    <h1 class="font-light text-white">{{$kg}}</h1>
                    <h6 class="text-white">KG</h6>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-4 col-xlg-2">
            <div class="card card-primary card-inverse">
                <div class="box text-center">
                    <h1 class="font-light text-white">{{$transaksi->count()}}</h1>
                    <h6 class="text-white">Transaksi</h6>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-4 col-xlg-2">
            <div class="card card-inverse card-success">
                <div class="box text-center">
                    <h1 class="font-light text-white">{{$user->count()}}</h1>
                    <h6 class="text-white">Customer</h6>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<div class="row">
    <div class="col-lg-4 col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title">Data Finance</h4>

            </div>
            <div class="card-content">
                <div class="card-body pt-50">
                    <div id="product-order-chart" class="mb-2"></div>
                    <div class="chart-info d-flex justify-content-between mb-1">
                        <div class="series-info d-flex align-items-center">
                            <i class="fa fa-circle-o text-bold-700 text-primary"></i>
                            <span class="text-bold-600 ml-50">Bulan Ini</span>
                        </div>
                        <div class="product-result">
                            <span>{{Rupiah::getRupiah($bulan)}}</span>
                        </div>
                    </div>
                    <div class="chart-info d-flex justify-content-between mb-1">
                        <div class="series-info d-flex align-items-center">
                            <i class="fa fa-circle-o text-bold-700 text-warning"></i>
                            <span class="text-bold-600 ml-50">Tahun Ini</span>
                        </div>
                        <div class="product-result">
                            <span>{{Rupiah::getRupiah($tahun)}}</span>
                        </div>
                    </div>
                    <div class="chart-info d-flex justify-content-between mb-25">
                        <div class="series-info d-flex align-items-center">
                            <i class="fa fa-circle-o text-bold-700 text-danger"></i>
                            <span class="text-bold-600 ml-50">Total</span>
                        </div>
                        <div class="product-result">
                            <span>{{Rupiah::getRupiah($all)}}</span>
                        </div>
                    </div>
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
                // enabled: true,
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
                        fontSize: '18px',
                    },
                    value: {
                        fontSize: '16px',
                    },
                    total: {
                        show: true,
                        label: 'Total',

                        formatter: function (w) {
                            // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
                            return [{{$al->count() / 100 * 2}}, '%']
                        }
                    }
                }
            }
        },
        series: [{{($bln->count() / 100 * 2 )}} , {{$thn->count() / 100 * 2}}, {{$al->count() / 100 * 2}}],
        labels: ['Bulan Ini', 'Tahun Ini', 'Total'],

    }

   var orderChart = new ApexCharts(
        document.querySelector("#product-order-chart"),
        orderChartoptions
    );

    orderChart.render();
// End Data Finance


</script>
@endsection