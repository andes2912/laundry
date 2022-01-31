@extends('layouts.backend')
@section('title','Dashboard Customer')
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
                      <div class="col-xl-4 col-sm-6 col-12 mb-2 mb-xl-0">
                          <div class="media">
                              <div class="avatar bg-light-primary mr-2">
                                  <div class="avatar-content">
                                      <i class="feather icon-box text-primary font-medium-5"></i>
                                  </div>
                              </div>
                              <div class="media-body my-auto">
                                  <h4 class="font-weight-bolder mb-0">{{$totalLaundry}}</h4>
                                  <p class="card-text font-small-1 mb-0">Jumlah Laundry Masuk</p>
                              </div>
                          </div>
                      </div>
                      <div class="col-xl-4 col-sm-6 col-12 mb-2 mb-xl-0">
                          <div class="media">
                              <div class="avatar bg-light-info mr-2">
                                  <div class="avatar-content">
                                      <i class="feather icon-box text-success font-medium-5"></i>
                                  </div>
                              </div>
                              <div class="media-body my-auto">
                                  <h4 class="font-weight-bolder mb-0">{{$totalLaundryKg}}</h4>
                                  <p class="card-text font-small-1 mb-0">Jumlah Laundry Kg</p>
                              </div>
                          </div>
                      </div>
                      <div class="col-xl-4 col-sm-6 col-12 mb-2 mb-sm-0">
                          <div class="media">
                              <div class="avatar bg-light-danger mr-2">
                                  <div class="avatar-content">
                                      <i class="feather icon-check text-danger font-medium-5"></i>
                                  </div>
                              </div>
                              <div class="media-body my-auto">
                                  <h4 class="font-weight-bolder mb-0"> 0 </h4>
                                  <p class="card-text font-small-1 mb-0">Point</p>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
 </div>
@endsection