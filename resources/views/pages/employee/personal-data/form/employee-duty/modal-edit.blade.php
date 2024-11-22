<!-- Modals add menu -->
<div id="modal-form-edit-duty-{{ $employeeDuty->id }}" class="modal fade" tabindex="-1"
  aria-labelledby="modal-form-edit-duty-{{ $employeeDuty->id }}-label" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('employeeDuty.update', $employeeDuty) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-edit-duty-{{ $employeeDuty->id }}-label">
            Edit Data Dinas/Tugas
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>

        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-12"> <!-- Make form smaller with col-md-6 and center it -->
              <input type="hidden" name="employee_id" value="{{ $employee->id }}">
              <input type="hidden" name="name" value="{{ $employee->name }}">

              <div class="mb-2">
                <label class="form-label" for="name_duty">Dinas/Tugas <code>*</code></label>
                <input id="name_duty" name="name_duty" value="{{ old('name_duty', $employeeDuty->name_duty) }}"
                  class="form-control @error('name_duty') is-invalid @enderror">
                @error('name_duty')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label class="form-label" for="date_duty">Tanggal <code>*</code></label>
                <input id="date_duty" type="date" name="date_duty"
                  value="{{ old('date_duty', $employeeDuty->date_duty) }}"
                  class="form-control @error('date_duty') is-invalid @enderror">
                @error('date_duty')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label class="form-label" for="location">Lokasi <code>*</code></label>
                <input id="location" name="location" value="{{ old('location', $employeeDuty->location) }}"
                  class="form-control @error('location') is-invalid @enderror" required>
                @error('location')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label for="file" class="form-label">File</label>
                <input class="form-control" accept=".pdf" type="file" id="file"
                  @error('file') is-invalid @enderror name="file">
                @error('file')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
                <div class="text-center my-3" style="height: 30px;">
                  <a href="{{ Storage::url($employeeDuty->file) }}" target="_blank">
                    {{ pathinfo($employeeDuty->file, PATHINFO_FILENAME) }}
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
