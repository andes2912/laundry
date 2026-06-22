{{-- Modal Edit Harga --}}
<div class="modal fade" id="edit_harga" tabindex="-1" role="dialog" aria-labelledby="editHargaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h4 class="modal-title" id="editHargaLabel">
                    <i class="feather icon-edit-2 mr-50 text-primary"></i> Edit Harga Laundry
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body py-2">
                <input type="hidden" id="id_harga">

                <div class="form-group">
                    <label for="jenis">Jenis Pakaian</label>
                    <div class="input-group input-group-merge">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="feather icon-tag"></i></span>
                        </div>
                        <input type="text" id="jenis" class="form-control" placeholder="Misal: Baju + Celana">
                    </div>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" class="form-control">
                        <option value="1">Aktif — tersedia di form order</option>
                        <option value="0">Nonaktif — disembunyikan dari form order</option>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="hari">Lama (hari)</label>
                            <div class="input-group input-group-merge">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="feather icon-clock"></i></span>
                                </div>
                                <input type="number" min="1" id="hari" class="form-control" placeholder="2">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="kg">Berat per-Kg (gram)</label>
                            <div class="input-group input-group-merge">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="feather icon-package"></i></span>
                                </div>
                                <input type="number" min="1" id="kg" class="form-control" placeholder="1000">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="harga">Harga (Rp)</label>
                            <div class="input-group input-group-merge">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" min="0" id="harga" class="form-control" placeholder="7000">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                    <i class="feather icon-x mr-25"></i> Batal
                </button>
                <button type="button" class="btn btn-primary" id="simpan_harga">
                    <i class="feather icon-check mr-25"></i> Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</div>
