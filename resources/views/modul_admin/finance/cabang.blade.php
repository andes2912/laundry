@extends('layouts.admin_template')
@section('title','Admin - Data Finance')
@section('header','Data Finance')
@section('content')
<div class="col-lg-12">
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
</div>
<div class="col-lg-6">
    <div class="card ">
        <div class="card-body bg-info">
            <h4 class="card-title m-b-0 text-white" style="font-size:25px">Finance Status</h4>
        </div>
        <div id="morris-donut-chart"></div>
        <ul class="list-inline m-t-20 text-center" >
            <li >
                <h6 class="text-dark"><i class="fa fa-circle" style="color:#2f3d4a"></i> Bulan ini</h6>
                <h4 class="m-b-0 text-dark">
                    {{Rupiah::getRupiah($bulan)}}

                </h4>
            </li>
            <li >
                <h6 class="text-dark"><i class="fa fa-circle" style="color:#55ce63"></i> Tahun ini</h6>
                <h4 class="m-b-0 text-dark">
                    {{Rupiah::getRupiah($tahun)}}
                </h4>
            </li>
            <li >
                <h6 class="text-dark"><i class="fa fa-circle" style="color:#009efb"></i> Keseluruhan</h6>
                <h4 class="m-b-0 text-dark">
                    {{Rupiah::getRupiah($all)}}
                </h4>
            </li>
        </ul>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
Morris.Donut({
        element: 'morris-donut-chart',
        data: [{
            label: "Keseluruhan",
            value: [{{$all}}],

        }, {
            label: "Tahun Ini",
            value: [{{$tahun}}],
        }, {
            label: "Bulan Ini",
            value: [{{$bulan}}],
        }],
        resize: true,
        colors:['#009efb', '#55ce63', '#2f3d4a']
    });
</script>
@endsection