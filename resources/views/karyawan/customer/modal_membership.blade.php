<div class="modal fade" id="add_member" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">Tambah Membership </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <input type="text" name="user_id" id="user_id" hidden>
                        <label for="recipient-name" class="control-label">Customer :</label>
                        <input type="text" name="name" id="name" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Membership :</label>
                        <select name="membership_price_id" id="membership_price_id" class="form-control">
                            <option value="">-- PILIH --</option>
                            @foreach ($membership as $item)
                                <option value="{{$item->id}}">{{$item->name}} - {{$item->kg}} Kg</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="simpan_membership">Save</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
