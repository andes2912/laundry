@extends('layouts.backend')
@section('title','Admin - Settings')
@section('header','Settings')
@section('content')
@if ($message = Session::get('success'))
  <div class="alert alert-success alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
  </div>
@elseif($message = Session::get('error'))
  <div class="alert alert-danger alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
  </div>
@endif
<div class="content-body">
  <section>
    <div class="row">
      <!-- left menu section -->
      <div class="col-md-3 mb-2 mb-md-0">
        <ul class="nav nav-pills flex-column mt-md-0 mt-1">
          <li class="nav-item">
              <a class="nav-link d-flex py-75 active" id="pill-general" data-toggle="pill" href="#vertical-general" aria-expanded="true">
                  <i class="feather icon-globe mr-50 font-medium-3"></i>
                  General
              </a>
          </li>

          <li class="nav-item">
              <a class="nav-link d-flex py-75" id="pill-target" data-toggle="pill" href="#vertical-target" aria-expanded="false">
                  <i class="feather icon-message-circle mr-50 font-medium-3"></i>
                  Target Laundry
              </a>
          </li>

          <li class="nav-item">
              <a class="nav-link d-flex py-75" id="pill-theme" data-toggle="pill" href="#vertical-theme" aria-expanded="false">
                  <i class="feather icon-feather mr-50 font-medium-3"></i>
                  Theme
              </a>
          </li>

          <li class="nav-item">
              <a class="nav-link d-flex py-75" id="pill-bank" data-toggle="pill" href="#vertical-bank" aria-expanded="false">
                  <i class="feather icon-credit-card mr-50 font-medium-3"></i>
                  Data Bank
              </a>
          </li>

          <li class="nav-item">
              <a class="nav-link d-flex py-75" id="pill-notif" data-toggle="pill" href="#vertical-notif" aria-expanded="false">
                  <i class="feather icon-bell mr-50 font-medium-3"></i>
                  Notifications
              </a>
          </li>

        </ul>
      </div>
      <!-- right content section -->
      <div class="col-md-9">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <div class="tab-content">
                {{-- Panel General --}}
                <div role="tabpanel" class="tab-pane active" id="vertical-general" aria-labelledby="pill-general" aria-expanded="true">
                  <form action="{{route('seting-page.update', $setpage->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                      <div class="col-12">
                        <div class="form-group">
                          <div class="controls">
                            <label for="judul">Judul Website</label>
                            <input type="text" class="form-control" name="judul" value="{{$setpage->judul}}" placeholder="Judul Website" required>
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-group">
                          <div class="controls">
                            <label for="tentang">Tentang</label>
                            <textarea name="tentang" class="form-control" rows="3" placeholder="Tentang Website"> {{$setpage->tentang}} </textarea>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="controls">
                            <label for="intagram">Instagram</label>
                            <input type="text" name="instagram" class="form-control" value="{{$setpage->instagram}}" placeholder="Username Instagram">
                          </div>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="controls">
                            <label for="facebook">Facebook</label>
                            <input type="text" name="facebook" class="form-control" value="{{$setpage->facebook}}" placeholder="Username Facebook">
                          </div>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="controls">
                            <label for="twitter">Twitter</label>
                            <input type="text" name="twitter" class="form-control" value="{{$setpage->twitter}}" placeholder="Username Twitter">
                          </div>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="controls">
                            <label for="WhatsApp">WhatsApp</label>
                            <input type="text" name="whatsapp" class="form-control" value="{{$setpage->whatsapp}}" placeholder="Nomor WhatsApp">
                          </div>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="controls">
                            <label for="No Telp">No Telp</label>
                            <input type="number" name="no_telp" class="form-control" value="{{$setpage->no_telp}}" placeholder="Nomor Telp">
                          </div>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="controls">
                            <label for="Email">Email</label>
                            <input type="email" name="email" class="form-control"value="{{$setpage->email}}" placeholder="Email">
                          </div>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="controls">
                            <label for="Image Hero">Image Hero</label>
                            <input type="file" name="img_hero" class="form-control" placeholder="Username No Telp">
                            <small class="text-warning">Recomendes Image size 1200p x 400p</small>
                          </div>
                        </div>
                      </div>

                      <div class="col-12 d-flex flex-sm-row flex-column justify-content-start">
                        <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save changes</button>
                        <button type="reset" class="btn btn-outline-warning">Cancel</button>
                      </div>
                    </div>
                  </form>
                </div>

                {{-- Panel Target --}}
                <div class="tab-pane fade" id="vertical-target" role="tabpanel" aria-labelledby="pill-target" aria-expanded="false">
                  <form action="{{route('set-target.update', Auth::user()->id)}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="controls">
                            <label for="Target Hari">Target per-hari</label>
                            <input type="number" class="form-control" name="target_day" value="{{$settarget->target_day}}" placeholder="Target Hari" required>
                          </div>
                        </div>
                      </div>

                       <div class="col-md-4">
                        <div class="form-group">
                          <div class="controls">
                            <label for="Target Bulan">Target per-bulan</label>
                            <input type="number" class="form-control" name="target_month" value="{{$settarget->target_month}}" placeholder="Target Bulan" required>
                          </div>
                        </div>
                      </div>

                       <div class="col-md-4">
                        <div class="form-group">
                          <div class="controls">
                            <label for="Target Tahun">Target per-tahun</label>
                            <input type="number" class="form-control" name="target_year" value="{{$settarget->target_year}}" placeholder="Target Tahun" required>
                          </div>
                        </div>
                      </div>

                      <div class="col-12 d-flex flex-sm-row flex-column justify-content-start">
                        <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save changes</button>
                        <button type="reset" class="btn btn-outline-warning">Cancel</button>
                      </div>
                    </div>
                  </form>
                </div>

                {{-- Panel Theme --}}
                <div class="tab-pane fade" id="vertical-theme" role="tabpanel" aria-labelledby="pill-theme" aria-expanded="false">
                  <form action="{{route('setting-theme.update', Auth::id())}}" method="post">
                    @csrf
                    @method('PUT')
                      <div class="row">
                        <h5 class="m-1">Theme Dark <i class=" {{Auth::user()->theme == 1 ? 'fa fa-check' : ''}} " style="color: chartreuse"></i> </h5>
                        <div class="col-12 mb-1">
                            <div class="custom-control custom-switch custom-control-inline">
                                <input type="checkbox" class="custom-control-input" name="theme" {{Auth::user()->theme == 1 ? 'checked' : ''}} value="1" id="theme">
                                <label class="custom-control-label mr-1" for="theme"></label>
                                <span class="switch-label w-100">Aktifkan Jika Ingin Menggunakan Theme Dark</span>
                            </div>
                        </div>

                        <div class="col-12 d-flex flex-sm-row flex-column justify-content-start">
                          <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save
                              changes</button>
                          <button type="reset" class="btn btn-outline-warning">Cancel</button>
                        </div>
                      </div>
                  </form>
                </div>

                {{-- Panel Bank --}}
                <div class="tab-pane fade" id="vertical-bank" role="tabpanel" aria-labelledby="pill-bank" aria-expanded="false">
                  <form action="" method="post">
                  @csrf
                    <div class="row">
                      @if (Auth::User()->bank == NULL)
                        <div class="col-md-4">
                          <a data-toggle="modal" data-target="#addpayment">
                            <div class="card bg-primary">
                              <div class="card-body">
                                <div class="card-title text-white">
                                  Tambah Akun Bank
                                </div>
                                <div class="text-center text-white">
                                  <i class="feather icon-plus"></i>
                                </div> <br>
                              </div>
                            </div>
                          </a>
                        </div>
                      @else
                        @foreach ($databank as $bank)
                          <div class="col-md-4">
                            <a data-toggle="modal" data-target="#editpayment">
                              <div class="card bg-danger">
                                <div class="card-body text-center">
                                  <div class="card-title text-white">
                                    {{$bank->nama_bank}}
                                  </div>
                                  <span class="text-white">{{$bank->no_rekening}}</span> <br>
                                  <small class="text-white">{{$bank->nama_pemilik}}</small>
                                </div>
                              </div>
                            </a>
                          </div>
                        @endforeach

                        <div class="col-md-4">
                          <a data-toggle="modal" data-target="#addpayment">
                            <div class="card bg-primary">
                              <div class="card-body">
                                <div class="card-title text-white">
                                  Tambah Akun Bank
                                </div>
                                <div class="text-center text-white">
                                  <i class="feather icon-plus"></i>
                                </div> <br>
                              </div>
                            </div>
                          </a>
                        </div>
                      @endif

                    </div>
                  </form>
                </div>

                {{-- Panel Notifications --}}
                <div class="tab-pane fade" id="vertical-notif" role="tabpanel" aria-labelledby="pill-notif" aria-expanded="false">
                  <div class="alert alert-danger">Baca Dokumentasi untuk mempermudah integrasi dan penggunaan Notifikasi pada halaman <b>Dokumentasi.</b></div>
                  <form action="{{route('set-notif.update', Auth::id())}}" method="post">
                    @csrf
                    @method('PUT')
                      <div class="row">
                        <h5 class="m-1">Email</h5>
                        <div class="col-12 mb-1">
                          <div class="custom-control custom-switch custom-control-inline">
                              <input type="checkbox" class="custom-control-input" name="email" {{$setnotif->email == 1 ? 'checked' : '0'}} value="1" id="email">
                              <label class="custom-control-label mr-1" for="email"></label>
                              <span class="switch-label w-100">Aktifkan Jika Ingin Menggunakan Email Notification</span>
                          </div>
                        </div>

                        <h5 class="m-1">Telegram Order Masuk</h5>
                        <div class="col-12 mb-1">
                          <div class="custom-control custom-switch custom-control-inline">
                              <input type="checkbox" class="custom-control-input" name="telegram_order_masuk" {{$setnotif->telegram_order_masuk == 1 ? 'checked' : '0'}} value="1" id="telegram_order_masuk">
                              <label class="custom-control-label mr-1" for="telegram_order_masuk"></label>
                              <span class="switch-label w-100">Aktifkan Jika Ingin Mendapatkan Notifikasi Setiap Order Masuk</span>
                          </div>

                        </div>

                        <h5 class="m-1">Telegram Order Keluar</h5>
                        <div class="col-12 mb-1">
                          <div class="custom-control custom-switch custom-control-inline">
                              <input type="checkbox" class="custom-control-input" name="telegram_order_selesai" {{$setnotif->telegram_order_selesai == 1 ? 'checked' : '0'}} value="1" id="telegram_order_selesai">
                              <label class="custom-control-label mr-1" for="telegram_order_selesai"></label>
                              <span class="switch-label w-100">Aktifkan Jika Ingin Mendapatkan Notifikasi Setiap Order Selesai</span>
                          </div>
                        </div>

                        <h5 class="m-1">Channel Telegram</h5>
                        <div class="col-md-12 mb-1">
                           <div class="form-group">
                              <input type="text" name="telegram_channel_masuk" class="form-control" placeholder="Masukan Nama Channel Telegram" value=" {{$setnotif->telegram_channel_masuk}} ">
                              @if ($setnotif->telegram_order_selesai == 1 || $setnotif->telegram_order_masuk == 1)
                                @if ($setnotif->telegram_channel_masuk == '')
                                  <small class="text-danger">Channel telegram wajib diisi.</small>
                                @endif
                               @endif
                          </div>
                        </div>

                        <h5 class="m-1">WhatsApp Order Selesai</h5>
                        <div class="col-12 mb-1">
                          <div class="custom-control custom-switch custom-control-inline">
                              <input type="checkbox" class="custom-control-input" name="wa_order_selesai" {{$setnotif->wa_order_selesai == 1 ? 'checked' : '0'}} value="1" id="wa_order_selesai">
                              <label class="custom-control-label mr-1" for="wa_order_selesai"></label>
                              <span class="switch-label w-100">Aktifkan Jika Ingin Mengirimkan Notifikasi Setiap Order Selesai Kepada Customer</span>
                          </div>
                        </div>

                        <h5 class="m-1">Token WhatsApp API</h5>
                        <div class="col-md-12 mb-1">
                           <div class="form-group">
                              <input type="text" name="wa_token" class="form-control" placeholder="Masukan Token API" value="{{$setnotif->wa_token}}">
                              @if ($setnotif->wa_order_selesai == 1)
                                @if ($setnotif->wa_token == '')
                                  <small class="text-danger">Token WhatsApp wajib diisi.</small>
                                @endif
                               @endif
                          </div>
                        </div>

                        <div class="col-12 d-flex flex-sm-row flex-column justify-content-start">
                          <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save changes</button>
                          <button type="reset" class="btn btn-outline-warning">Cancel</button>
                        </div>
                      </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  @include('modul_admin.setting.modal')
</div>
@endsection
@section('scripts')
<script>
  @if (count($errors) > 0)
    $(function() {
      $('#addpayment').modal('show');
    });
  @endif
</script>
@endsection