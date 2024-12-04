<!-- Modals add menu -->
<div id="modal-form-add-employee-photo" class="modal fade" tabindex="-1"
  aria-labelledby="modal-form-add-employee-photo-label" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('employeePhoto.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-add-employee-photo-label">Tambah Photo</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>

        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-12"> <!-- Make form smaller with col-md-6 and center it -->
              <input type="hidden" name="employee_id" value="{{ $employee->id }}">
              <input type="hidden" name="name" value="{{ $employee->name }}">

              <div class="mb-2">
                <label for="file_path" class="form-label">Upload Photo</label>
                <input class="form-control" accept=".jpg, .jpeg, .png" type="file" id="file_path" name="file_path">
              </div>

              <div class="form-check mb-3">
                <input type="checkbox" name="main_photo" id="main_photo" value="1" class="form-check-input">
                <label for="main_photo" class="form-check-label">Set as Main Photo</label>
              </div>

            </div>
          </div>
        </div>


        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary ">Save</button>
        </div>
      </form>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
