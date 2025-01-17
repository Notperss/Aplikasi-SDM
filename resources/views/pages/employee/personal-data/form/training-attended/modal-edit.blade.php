<!-- Modals add menu -->
<div id="modal-form-edit-training-attended-{{ $employeeTrainingAttended->id }}" class="modal fade"
  aria-labelledby="modal-form-edit-training-attended-{{ $employeeTrainingAttended->id }}-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('employeeTrainingAttended.update', $employeeTrainingAttended) }}" method="post"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-edit-training-attended-{{ $employeeTrainingAttended->id }}-label">
            Edit Data Seminar/Pelatihan
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>

        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-12"> <!-- Make form smaller with col-md-6 and center it -->
              {{-- <input type="hidden" name="employee_id" value="{{ $employee->id }}">
              <input type="hidden" name="name" value="{{ $employee->name }}"> --}}

              <div class="mb-2">
                <label class="form-label" for="training_name">Nama Seminar/Pelatihan</label>
                <input id="training_name" name="training_name"
                  value="{{ old('training_name', $employeeTrainingAttended->training_name) }}"
                  class="form-control @error('training_name') is-invalid @enderror" required>
                @error('training_name')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label class="form-label" for="organizer_name">Penyelenggara</label>
                <input id="organizer_name" name="organizer_name"
                  value="{{ old('organizer_name', $employeeTrainingAttended->organizer_name) }}"
                  class="form-control @error('organizer_name') is-invalid @enderror" required>
                @error('organizer_name')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label class="form-label" for="city">Tempat/Kota</label>
                <input id="city" value="{{ old('city', $employeeTrainingAttended->city) }}" name="city"
                  class="form-control @error('city') is-invalid @enderror">
                @error('city')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="row">
                <div class="col-6 mb-2">
                  <label class="form-label" for="start_date">Tanggal Mulai</label>
                  <input type="date" id="start_date" name="start_date" maxlength="4"
                    value="{{ old('start_date', $employeeTrainingAttended->start_date) }}"
                    class="form-control @error('start_date') is-invalid @enderror">
                  @error('start_date')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>
                <div class="col-6 mb-2">
                  <label class="form-label" for="end_date">Tanggal Akhir</label>
                  <input type="date" id="end_date" name="end_date" maxlength="4"
                    value="{{ old('end_date', $employeeTrainingAttended->end_date) }}"
                    class="form-control @error('end_date') is-invalid @enderror">
                  @error('end_date')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>
              </div>

              <div class="mb-2">
                <label for="file_sertifikat" class="form-label">File Pelatihan</label>
                <input class="form-control" accept=".pdf" type="file" id="file_sertifikat"
                  @error('file_sertifikat') is-invalid @enderror name="file_sertifikat">
                @error('file_sertifikat')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror

                <div class="text-center my-3" style="height: 30px;">
                  @if ($employeeTrainingAttended->file_sertifikat)
                    <a href="{{ Storage::url($employeeTrainingAttended->file_sertifikat) }}" target="_blank">
                      {{ pathinfo($employeeTrainingAttended->file_sertifikat, PATHINFO_FILENAME) }}
                    </a>
                  @else
                    <span>-</span>
                  @endif
                </div>

                <div class="mb-3" style="font-size: 130%">
                  <div class="form-check form-switch form-switch-right form-switch-md">
                    <label for="status" class="form-label">Print</label>
                    <input class="form-check-input code-switcher" type="checkbox" id="tables-small-showcode"
                      name="is_printable" value="1" @checked($employeeTrainingAttended->is_printable)>
                  </div>
                  {{-- <x-form.validation.error name="status" /> --}}
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
