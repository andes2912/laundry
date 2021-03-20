<div class="modal fade" id="ubah_status" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel1">UBah Status Order</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="message-text" class="control-label">Nama Customer :</label>
                            <input type="text" name="customer" id="customer" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="id_status" id="id_status">
                            <label for="recipient-name" class="control-label">Status Order :</label>
                            <select class="form-control custom-select" name="status_order" id="status_order" required>
                                <option value="">-- Pilih Status Order --</option>
                                <option value="Done">Selesai</option>
                                <option value="Delivery">Diambil</option>
                                <option value="Process">Proses</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="save_status">Save</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>