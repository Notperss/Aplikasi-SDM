<!-- Modals add menu -->
<div id="modal-form-add-duty" class="modal fade" tabindex="-1" aria-labelledby="modal-form-add-duty-label"
  aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('employeeDuty.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-add-duty-label">Tambah Data Dinas/Tugas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>

        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-12"> <!-- Make form smaller with col-md-6 and center it -->
              <input type="hidden" name="employee_id" value="{{ $employee->id }}">
              <input type="hidden" name="name" value="{{ $employee->name }}">

              <div class="mb-2">
                <label class="form-label" for="name_duty">Dinas/Tugas <code>*</code></label>
                <input id="name_duty" name="name_duty" value="{{ old('name_duty') }}"
                  class="form-control @error('name_duty') is-invalid @enderror">
                @error('name_duty')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="row mb-2">
                <div class="col-md-6">
                  <label class="form-label" for="start_date">Tanggal Mulai <code>*</code></label>
                  <input id="start_date" type="date" name="start_date" value="{{ old('start_date') }}"
                    class="form-control @error('start_date') is-invalid @enderror">
                  @error('start_date')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="end_date">Tanggal Selesai <code>*</code></label>
                  <input id="end_date" type="date" name="end_date" value="{{ old('end_date') }}"
                    class="form-control @error('end_date') is-invalid @enderror">
                  @error('end_date')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>
              </div>

              <div class="mb-2">
                <label class="form-label" for="location">Lokasi <code>*</code></label>
                <input id="location" name="location" value="{{ old('location') }}"
                  class="form-control @error('location') is-invalid @enderror" required>
                @error('location')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label class="form-label" for="description">Keterangan</label>
                <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }} </textarea>
                @error('description')
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
                {{-- <div class="text-center my-3" style="height: 30px;">
                  <a href="{{ Storage::url($educationalHistory->file) }}" target="_blank">
                    {{ pathinfo($educationalHistory->file, PATHINFO_FILENAME) }}
                  </a>
                </div> --}}

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
