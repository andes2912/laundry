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
              <a class="nav-link d-flex py-75" id="pill-notifications" data-toggle="pill" href="#vertical-notifications" aria-expanded="false">
                  <i class="feather icon-message-circle mr-50 font-medium-3"></i>
                  Notifications
              </a>
          </li>

          <li class="nav-item">
              <a class="nav-link d-flex py-75" id="pill-theme" data-toggle="pill" href="#vertical-theme" aria-expanded="false">
                  <i class="feather icon-feather mr-50 font-medium-3"></i>
                  Theme & Email Notification
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

                <div class="tab-pane fade" id="vertical-notifications" role="tabpanel" aria-labelledby="pill-notifications" aria-expanded="false">
                    <div class="row">
                        <h6 class="m-1">Activity</h6>
                        <div class="col-12 mb-1">
                            <div class="custom-control custom-switch custom-control-inline">
                                <input type="checkbox" class="custom-control-input" checked id="accountSwitch1">
                                <label class="custom-control-label mr-1" for="accountSwitch1"></label>
                                <span class="switch-label w-100">Email me when someone comments
                                    onmy
                                    article</span>
                            </div>
                        </div>
                        <div class="col-12 mb-1">
                            <div class="custom-control custom-switch custom-control-inline">
                                <input type="checkbox" class="custom-control-input" checked id="accountSwitch2">
                                <label class="custom-control-label mr-1" for="accountSwitch2"></label>
                                <span class="switch-label w-100">Email me when someone answers on
                                    my
                                    form</span>
                            </div>
                        </div>
                        <div class="col-12 mb-1">
                            <div class="custom-control custom-switch custom-control-inline">
                                <input type="checkbox" class="custom-control-input" id="accountSwitch3">
                                <label class="custom-control-label mr-1" for="accountSwitch3"></label>
                                <span class="switch-label w-100">Email me hen someone follows
                                    me</span>
                            </div>
                        </div>
                        <h6 class="m-1">Application</h6>
                        <div class="col-12 mb-1">
                            <div class="custom-control custom-switch custom-control-inline">
                                <input type="checkbox" class="custom-control-input" checked id="accountSwitch4">
                                <label class="custom-control-label mr-1" for="accountSwitch4"></label>
                                <span class="switch-label w-100">News and announcements</span>
                            </div>
                        </div>
                        <div class="col-12 mb-1">
                            <div class="custom-control custom-switch custom-control-inline">
                                <input type="checkbox" class="custom-control-input" id="accountSwitch5">
                                <label class="custom-control-label mr-1" for="accountSwitch5"></label>
                                <span class="switch-label w-100">Weekly product updates</span>
                            </div>
                        </div>
                        <div class="col-12 mb-1">
                            <div class="custom-control custom-switch custom-control-inline">
                                <input type="checkbox" class="custom-control-input" checked id="accountSwitch6">
                                <label class="custom-control-label mr-1" for="accountSwitch6"></label>
                                <span class="switch-label w-100">Weekly blog digest</span>
                            </div>
                        </div>
                        <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                            <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save
                                changes</button>
                            <button type="reset" class="btn btn-outline-warning">Cancel</button>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="vertical-theme" role="tabpanel" aria-labelledby="pill-theme" aria-expanded="false">
                  <form action="{{route('setting-theme-email.update', auth::id())}}" method="post">
                    @csrf
                    @method('PUT')
                      <div class="row">
                        <h5 class="m-1">Theme Dark <i class=" {{auth::user()->theme == 1 ? 'fa fa-check' : ''}} " style="color: chartreuse"></i> </h5>
                        <div class="col-12 mb-1">
                            <div class="custom-control custom-switch custom-control-inline">
                                <input type="checkbox" class="custom-control-input" name="theme" {{auth::user()->theme == 1 ? 'checked' : ''}} value="1" id="theme">
                                <label class="custom-control-label mr-1" for="theme"></label>
                                <span class="switch-label w-100">Aktifkan Jika Ingin Menggunakan Theme Dark</span>
                            </div>
                        </div>

                        <h5 class="m-1">Email Notification</h5>
                        <div class="col-12 mb-1">
                            <div class="custom-control custom-switch custom-control-inline">
                                <input type="checkbox" class="custom-control-input" name="email_set" {{auth::user()->email_set == 1 ? 'checked' : ''}} value="1" id="email_set">
                                <label class="custom-control-label mr-1" for="email_set"></label>
                                <span class="switch-label w-100">Aktifkan Jika Ingin Menggunakan Email Notifications</span>
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

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection