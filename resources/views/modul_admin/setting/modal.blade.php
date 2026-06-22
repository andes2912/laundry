{{-- Modal Edit Profile (dipakai di halaman lain) --}}
<div class="modal fade" id="edit_profile" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="feather icon-edit mr-50 text-primary"></i> Edit Profile
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" name="id_profile" id="id_profile">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="update_profile">
                    <i class="feather icon-save mr-25"></i> Update
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ============ MODAL: TAMBAH REKENING BANK ============ --}}
<div class="modal fade" id="addpayment" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="feather icon-credit-card mr-50 text-success"></i> Tambah Rekening Bank / E-Wallet
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
            </div>
            <form action="{{ route('setting.bank') }}" method="POST">
                @csrf
                <div class="modal-body">
                    {{-- Preview kartu --}}
                    <div class="mb-2 p-2" id="bank-preview"
                         style="background:linear-gradient(135deg,#7367f0,#9e95f5); color:#fff; border-radius:10px;">
                        <div class="d-flex justify-content-between align-items-start">
                            <h6 class="text-white mb-0" id="prev-bank">Nama Bank</h6>
                            <i class="feather icon-credit-card text-white" style="opacity:.6;"></i>
                        </div>
                        <h4 class="text-white text-bold-700 my-1" style="letter-spacing:2px; font-family:monospace;" id="prev-rek">
                            •••• •••• •••• ••••
                        </h4>
                        <small class="text-white" style="opacity:.85;" id="prev-nama">a/n Pemilik Rekening</small>
                    </div>

                    @php $bankList = App\Models\Bank::get(); @endphp

                    {{-- Nama Bank --}}
                    <div class="form-group">
                        <label class="text-bold-600">
                            <i class="feather icon-credit-card mr-25 text-muted"></i> Nama Bank / E-Wallet
                            <span class="text-danger">*</span>
                        </label>
                        <select name="nama_bank" id="bp-nama-bank"
                                class="form-control @error('nama_bank') is-invalid @enderror" required>
                            <option value="">— Pilih Bank / E-Wallet —</option>
                            @foreach ($bankList as $b)
                                <option value="{{ $b->nama_bank }}" {{ old('nama_bank') == $b->nama_bank ? 'selected' : '' }}>
                                    {{ $b->nama_bank }}
                                </option>
                            @endforeach
                        </select>
                        @error('nama_bank')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Nomor Rekening --}}
                    <div class="form-group">
                        <label class="text-bold-600">
                            <i class="feather icon-hash mr-25 text-muted"></i> Nomor Rekening / Nomor HP
                            <span class="text-danger">*</span>
                        </label>
                        <input type="number" name="no_rekening" id="bp-no-rek"
                               class="form-control @error('no_rekening') is-invalid @enderror"
                               placeholder="Contoh: 1234567890" value="{{ old('no_rekening') }}" required>
                        <small class="text-muted">Untuk e-wallet, isi dengan nomor HP terdaftar.</small>
                        @error('no_rekening')
                            <small class="text-danger d-block">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Nama Pemilik --}}
                    <div class="form-group mb-0">
                        <label class="text-bold-600">
                            <i class="feather icon-user mr-25 text-muted"></i> Nama Pemilik Rekening
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama_pemilik" id="bp-nama-pem"
                               class="form-control @error('nama_pemilik') is-invalid @enderror"
                               placeholder="Sesuai buku tabungan" value="{{ old('nama_pemilik') }}" required>
                        @error('nama_pemilik')
                            <small class="text-danger d-block">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                        <i class="feather icon-x mr-25"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="feather icon-save mr-25"></i> Simpan Rekening
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Live preview kartu rekening saat user mengetik
(function () {
    function maskNumber(n) {
        if (!n) return '•••• •••• •••• ••••';
        var s = String(n);
        return s.replace(/(.{4})/g, '$1 ').trim();
    }
    $(document).on('input change', '#bp-nama-bank, #bp-no-rek, #bp-nama-pem', function () {
        $('#prev-bank').text($('#bp-nama-bank').val() || 'Nama Bank');
        $('#prev-rek').text(maskNumber($('#bp-no-rek').val()));
        $('#prev-nama').text('a/n ' + ($('#bp-nama-pem').val() || 'Pemilik Rekening'));
    });
})();
</script>
