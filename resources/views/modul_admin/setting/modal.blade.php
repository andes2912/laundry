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