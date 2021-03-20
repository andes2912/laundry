<div class="modal fade" id="ubah_status_pay" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel1">UBah Status Pembayaran</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" name="id_bayar" id="id_bayar">
                        <div class="form-group">
                            <label for="message-text" class="control-label">Nama Customer :</label>
                            <input type="text" name="customer_pay" id="customer_pay" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="id_status" id="id_status">
                            <label for="recipient-name" class="control-label">Status Pembayaran :</label>
                            <select class="form-control custom-select" name="status_payment" id="status_payment" required>
                                <option value="">-- Pilih Status Payment --</option>
                                <option value="Pending">Belum Dibayar</option>
                                <option value="Success">Sudah Dibayar</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="simpan_status">Save</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>