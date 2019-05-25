@extends('layouts.admin_template')
@section('title','Dashboard Admin')
@section('content')
    <!-- Column -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <!-- Row -->
                <div class="row">
                    <div class="col-8"><h2>2376 <i class="ti-angle-down font-14 text-danger"></i></h2>
                        <h6>Order Received</h6></div>
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
                    <div class="col-8"><h2 class="">3670 <i class="ti-angle-up font-14 text-success"></i></h2>
                        <h6>Tax Deduction</h6></div>
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
                    <div class="col-8"><h2>1562 <i class="ti-angle-up font-14 text-success"></i></h2>
                        <h6>Revenue Stats</h6></div>
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
                    <div class="col-8"><h2>35% <i class="ti-angle-down font-14 text-danger"></i></h2>
                        <h6>Yearly Sales</h6></div>
                    <div class="col-4 align-self-center text-right p-l-0">
                        <div id="sparklinedash4"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-wrap">
                    <div>
                        <h4 class="card-title">Statistik Bulanan</h4>
                    </div>
                    <div class="ml-auto">
                        <ul class="list-inline">
                            <li>
                                <h6 class="text-muted text-success"><i class="fa fa-circle font-10 m-r-10 "></i>Masuk</h6> 
                            </li>                               
                        </ul>
                    </div>
                </div>
                <div id="morris-area-chart2" style="height: 405px;"></div>
            </div>
        </div>
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
                <h4 class="card-title m-b-0">Order Stats</h4>
            </div>
            <div class="card-body collapse show">
            <div id="morris-donut-chart" class="ecomm-donute" style="height: 317px;"></div>
                <ul class="list-inline m-t-20 text-center">
                <li >
                    <h6 class="text-muted"><i class="fa fa-circle text-info"></i> Masuk</h6>
                    <h4 class="m-b-0">{{$masuk}}</h4>
                </li>
                <li>
                    <h6 class="text-muted"><i class="fa fa-circle text-danger"></i> Selesai</h6>
                    <h4 class="m-b-0">{{$selesai}}</h4>
                </li>
                <li>
                    <h6 class="text-muted"> <i class="fa fa-circle text-success"></i> Diambil</h6>
                    <h4 class="m-b-0">{{$diambil}}</h4>
                </li>
            </ul>
            </div>
        </div>
    </div>

@endsection
@section('script')
<script type="text/javascript">
/*
Template Name: Admin Press Admin
Author: Themedesigner
Email: niravjoshi87@gmail.com
File: js
*/
$(function () {
    "use strict";
    // ============================================================== 
    // Product chart
    // ============================================================== 
    Morris.Area({
        element: 'morris-area-chart2',
        data: [{
            period: '2010',
            Masuk: 0,
            
        }, {
            period: '2011',
            Masuk: 130,
            
        }, {
            period: '2012',
            Masuk: 30,
            
        }, {
            period: '2013',
            Masuk: {{$data}},
            
        }, {
            period: '2014',
            Masuk: 200,
            
        }, {
            period: '2015',
            Masuk: 105,
            
        },
         {
            period: '2016',
            Masuk: 250,
           
        }],
        xkey: 'period',
        ykeys: ['Masuk'],
        labels: ['Masuk'],
        pointSize: 0,
        fillOpacity: 0.4,
        pointStrokeColors:[ '#01c0c8'],
        behaveLikeLine: true,
        gridLineColor: '#e0e0e0',
        lineWidth: 0,
        smooth: true,
        hideHover: 'auto',
        lineColors: [ '#01c0c8'],
        resize: true
        
    });
   // ============================================================== 
   // Morris donut chart
   // ==============================================================       
    Morris.Donut({
        element: 'morris-donut-chart',
        data: [{
            label: "Diambil",
            value: [{{$diambil}}],

        }, {
            label: "Masuk",
            value: [{{$masuk}}],
        }, {
            label: "Selesai",
            value: [{{$selesai}}]
        }],
        resize: true,
        colors:['#26c6da', '#1976d2', '#ef5350']
    });
    // ============================================================== 
    // sales difference
    // ==============================================================
    
    // ============================================================== 
    // sparkline chart
    // ==============================================================
    var sparklineLogin = function() { 
       $('#sparklinedash').sparkline([ 0, 5, 6, 10, 9, 12, 4, 9], {
            type: 'bar',
            height: '50',
            barWidth: '2',
            resize: true,
            barSpacing: '5',
            barColor: '#26c6da'
        });
         $('#sparklinedash2').sparkline([ 0, 5, 6, 10, 9, 12, 4, 9], {
            type: 'bar',
            height: '50',
            barWidth: '2',
            resize: true,
            barSpacing: '5',
            barColor: '#7460ee'
        });
          $('#sparklinedash3').sparkline([ 0, 5, 6, 10, 9, 12, 4, 9], {
            type: 'bar',
            height: '50',
            barWidth: '2',
            resize: true,
            barSpacing: '5',
            barColor: '#03a9f3'
        });
           $('#sparklinedash4').sparkline([ 0, 5, 6, 10, 9, 12, 4, 9], {
            type: 'bar',
            height: '50',
            barWidth: '2',
            resize: true,
            barSpacing: '5',
            barColor: '#f62d51'
        });
       
   }
    var sparkResize;
 
        $(window).resize(function(e) {
            clearTimeout(sparkResize);
            sparkResize = setTimeout(sparklineLogin, 500);
        });
        sparklineLogin();
});


</script>
@endsection