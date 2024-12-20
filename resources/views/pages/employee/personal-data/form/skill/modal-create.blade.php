<!-- Modals add menu -->
<div id="modal-form-add-skill" class="modal fade" tabindex="-1" aria-labelledby="modal-form-add-skill-label"
  aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('employeeSkill.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-add-skill-label">Tambah Data Bahasa Asing</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>

        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-12"> <!-- Make form smaller with col-md-6 and center it -->
              <input type="hidden" name="employee_id" value="{{ $employee->id }}">

              <div class="mb-2">
                <label class="form-label" for="name">Nama Keterampilan/Kompeten</label>
                <input id="name" name="name" class="form-control @error('name') is-invalid @enderror" required>
                @error('name')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label class="form-label" for="mastery">Kemahiran</label>
                <select id="mastery" name="mastery" class="form-control @error('mastery') is-invalid @enderror"
                  required>
                  <option value="" disabled selected>Choose</option>
                  <option value="Cukup">Cukup</option>
                  <option value="Baik">Baik</option>
                  <option value="Sangat Baik">Sangat Baik</option>
                </select>
                @error('mastery')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
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
