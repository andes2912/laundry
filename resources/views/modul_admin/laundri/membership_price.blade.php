@extends('layouts.backend')
@section('title','Admin - Harga Membership')
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

  <div class="row">
      {{-- Data Harga Membership Laundry--}}
      <div class="col-lg-8">
          <div class="card">
              <div class="card-body">
                  <h4 class="card-title"> Data Harga Membership
                      <a class="btn btn-primary" style="color:white">Tambah</a>
                  </h4>
                  <div class="table-responsive m-t-0">
                      <table id="myTable" class="table display table-bordered table-striped">
                          <thead>
                              <tr>
                                  <th>#</th>
                                  <th>Nama</th>
                                  <th>Kg</th>
                                  <th>Harga</th>
                                  <th>Status</th>
                                  <th>Action</th>
                              </tr>
                          </thead>
                          <tbody>
                            @foreach ($membership as $key => $memberships)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$memberships->name}}</td>
                                    <td>{{$memberships->kg}} Kg</td>
                                    <td>Rp {{number_format($memberships->price)}}</td>
                                    <td>{{$memberships->is_active == 1 ? 'Aktif' : 'Tidak Aktif' }}</td>
                                    <td></td>
                                </tr>
                            @endforeach
                          </tbody>
                      </table>
                  </div>
                  @include('modul_admin.laundri.editharga')
              </div>
          </div>
      </div>

      {{-- Form Tambah Data Harga Membership--}}
      <div class="col-lg-4">
          <div class="card card-outline-info">
              <div class="card-header">
                  <h4 class="m-b-0 text-black">Form Tambah Data Harga Membership</h4>
              </div>
              <div class="card-body">
                  <form action="{{route('membership-price.store')}}" method="POST">
                      @csrf
                      <div class="form-body">
                          <div class="row p-t-20">
                              <div class="col-lg-12 col-xl-12">
                                  <div class="form-group has-success">
                                      <label class="control-label">Nama</label>
                                      <input type="text" class="form-control form-control-danger @error('name') is-invalid @enderror" name="name" placeholder="Nama" autocomplete="off">
                                      @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                  </div>
                              </div>

                              <div class="col-lg-12 col-xl-12">
                                  <div class="form-group has-success">
                                      <label class="control-label">Berat Kg</label>
                                      <input type="number" class="form-control form-control-danger @error('kg') is-invalid @enderror" name="kg" placeholder="Berat Kg" autocomplete="off">
                                      @error('kg')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                  </div>
                              </div>

                              <div class="col-lg-12 col-xl-12">
                                  <div class="form-group has-success">
                                      <label class="control-label">Harga Per-Kg</label>
                                      <input type="number" class="form-control form-control-danger @error('price') is-invalid @enderror format_harga" name="price" value="{{ old('price') }}"placeholder="Harga Per-Kg" autocomplete="off">
                                      <small class="form-control-feedback "> Tuliskan Tanpa tanda ',' dan '.' </small>
                                      @error('price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                  </div>
                              </div>
                          </div>

                      </div>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                          <button type="reset" class="btn btn-danger">Cancel</button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
    </div>
@endsection
