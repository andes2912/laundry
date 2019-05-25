@extends('layouts.karyawan_template')
@section('title','Dashboard Karyawan')
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
@endsection