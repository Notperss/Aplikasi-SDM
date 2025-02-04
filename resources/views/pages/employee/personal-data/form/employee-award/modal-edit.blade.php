<!-- Modals add menu -->
<div id="modal-form-edit-award-{{ $employeeAward->id }}" class="modal fade" tabindex="-1"
  aria-labelledby="modal-form-edit-award-{{ $employeeAward->id }}-label" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('employeeAward.update', $employeeAward) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-edit-award-{{ $employeeAward->id }}-label">
            Edit Data Penghargaan
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>

        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-12"> <!-- Make form smaller with col-md-6 and center it -->
              <input type="hidden" name="employee_id" value="{{ $employee->id }}">
              <input type="hidden" name="name" value="{{ $employee->name }}">

              <div class="col-12 mb-2">
                <label class="form-label" for="name_award">Nama Penghargaan <code>*</code></label>
                <input id="name_award" type="text" name="name_award"
                  value="{{ old('name_award', $employeeAward->name_award) }}"
                  class="form-control @error('name_award') is-invalid @enderror">
                @error('name_award')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="col-12 mb-2">
                <label class="form-label" for="date_award">Tanggal Penghargaan <code>*</code></label>
                <input id="date_award" type="date" name="date_award"
                  value="{{ old('date_award', $employeeAward->date_award) }}"
                  class="form-control @error('date_award') is-invalid @enderror">
                @error('date_award')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label for="file_award" class="form-label">File</label>
                <input class="form-control" accept=".pdf" type="file" id="file_award"
                  @error('file_award') is-invalid @enderror name="file_award">
                @error('file_award')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
                <div class="text-center my-3" style="height: 30px;">
                  <a href="{{ Storage::url($employeeAward->file_award) }}" target="_blank">
                    {{ pathinfo($employeeAward->file_award, PATHINFO_FILENAME) }}
                  </a>
                </div>

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
