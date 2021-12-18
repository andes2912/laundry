{{-- Modal Edit Profile --}}
<div class="modal fade" id="edit_profile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title" id="exampleModalLabel1">Edit Profile </h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <form>
              <input type="hidden" name="id_profile" id="id_profile">
              <div class="form-group">
                  <label for="name" class="control-label">Name :</label>
                  <input type="text" name="name" id="name" class="form-control">
              </div>

              <div class="form-group">
                  <label for="email" class="control-label">Email :</label>
                  <input type="email" name="email" id="email" class="form-control">
              </div>

            </form>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-success" id="update_profile">Update</button>
              <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
          </div>
      </div>
  </div>
</div>

<div class="modal fade text-left" id="addpayment" tabindex="-1" role="dialog" aria-labelledby="addpayment" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title" id="addpayment">Tambah Data Payment </h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <form action="{{route('setting.bank')}}" method="POST">
            @csrf
            <div class="modal-body">
                <label for="Nama Bank">Nama Bank/E-Wallet</label>
                @php
                    $bank = App\Models\Bank::get();
                @endphp
                <div class="form-group">
                  {{-- <input type="text" name="nama_bank" class="form-control @error('nama_bank') is-invalid @enderror" placeholder="Nama Bank"> --}}
                  <select name="nama_bank" class="form-control @error('nama_bank') is-invalid @enderror">
                    @foreach ($bank as $item)
                      <option value="{{$item->nama_bank}}"> {{$item->nama_bank}} </option>
                    @endforeach
                  </select>
                  @error('nama_bank')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>

                <label>Nomor Rekening/Telp: </label>
                <div class="form-group">
                    <input type="number" name="no_rekening" placeholder="Nomor Rekening" class="form-control @error('no_rekening') is-invalid @enderror">
                    @error('no_rekening')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>

                <label>Nama Pemilik: </label>
                <div class="form-group">
                    <input type="text" name="nama_pemilik" placeholder="Nama Pemilik" class="form-control @error('nama_pemilik') is-invalid @enderror">
                    @error('nama_pemilik')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
              <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
            </div>
          </form>
      </div>
  </div>
</div>