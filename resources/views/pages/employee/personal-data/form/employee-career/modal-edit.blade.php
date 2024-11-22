<!-- Modals add menu -->
<div id="modal-form-edit-career-{{ $employeeCareer->id }}" class="modal fade" tabindex="-1"
  aria-labelledby="modal-form-edit-career-{{ $employeeCareer->id }}-label" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('employeeCareer.update', $employeeCareer) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-edit-career-{{ $employeeCareer->id }}-label">
            Edit Data Pengalaman Kerja
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>

        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-12"> <!-- Make form smaller with col-md-6 and center it -->
              <input type="hidden" name="employee_id" value="{{ $employee->id }}">

              <div class="row ">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label" for="start_date">Tanggal Mulai <code>*</code></label>
                    <input id="start_date" type="date" name="start_date"
                      value="{{ old('start_date', $employeeCareer->start_date) }}"
                      class="form-control @error('start_date') is-invalid @enderror" required>
                    @error('start_date')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>

                  {{-- <div class="form-group">
                    <label class="form-label" for="end_date">Tanggal Akhir</label>
                    <input id="end_date" type="date" name="end_date"
                      value="{{ old('end_date', $employeeCareer->end_date) }}"
                      class="form-control @error('end_date') is-invalid @enderror">
                    @error('end_date')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div> --}}

                  <div class="form-group">
                    <label class="form-label" for="placement">Penempatan <code>*</code></label>
                    <input id="placement" name="placement" value="{{ old('placement', $employeeCareer->placement) }}"
                      class="form-control @error('placement') is-invalid @enderror" required>
                    @error('placement')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>
                </div>

                <div class="col-md-6">

                  <div class="form-group">
                    <label class="form-label" class="form-label" for="type">Tipe Karir <code>*</code></label>
                    <select id="type" name="type" value="{{ old('type') }}"
                      class="form-control @error('type') is-invalid @enderror" required>
                      <option value="" selected disabled>Choose</option>
                      <option value="PROMOSI" {{ old('type', $employeeCareer->type) == 'PROMOSI' ? 'selected' : '' }}>
                        PROMOSI</option>
                      <option value="DEMOSI" {{ old('type', $employeeCareer->type) == 'DEMOSI' ? 'selected' : '' }}>
                        DEMOSI</option>
                      <option value="ROTASI" {{ old('type', $employeeCareer->type) == 'ROTASI' ? 'selected' : '' }}>
                        ROTASI</option>
                      <option value="MUTASI" {{ old('type', $employeeCareer->type) == 'MUTASI' ? 'selected' : '' }}>
                        MUTASI</option>
                      <option value="NON-AKTIF"
                        {{ old('type', $employeeCareer->type) == 'NON-AKTIF' ? 'selected' : '' }}>
                        NON-AKTIF</option>
                      <option value="RESIGN" {{ old('type', $employeeCareer->type) == 'RESIGN' ? 'selected' : '' }}>
                        RESIGN</option>
                      <option value="PENSIUN" {{ old('type', $employeeCareer->type) == 'PENSIUN' ? 'selected' : '' }}>
                        PENSIUN</option>
                    </select>
                    @error('type')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label class="form-label" for="position_id">Jabatan </label>
                    <select name="position_id" id="position_id"
                      class="form-control @error('position_id') is-invalid @enderror">
                      <option value="" disabled selected>Choose</option>
                      @foreach ($positions as $position)
                        <option value="{{ $position->id }}"
                          {{ old('position_id', $employeeCareer->position_id) == $position->id ? 'selected' : '' }}>
                          {{ $position->name }}</option>
                      @endforeach
                      {{-- @foreach ($positions as $position)
                        <option value="{{ $position->id }}"
                          {{ old('position_id', $employee->position_id) == $position->id ? 'selected' : '' }}>
                          {{ $position->name }}</option>
                      @endforeach --}}
                    </select>
                    @error('position_id')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>

                </div>
              </div>

              <div class="row">
                <div class="form-group">
                  <label for="file_career" class="form-label">File</label>
                  <input class="form-control @error('file_career') is-invalid @enderror" accept=".pdf" type="file"
                    id="file_career" name="file_career">
                  @error('file_career')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror

                  @if ($employeeCareer->file_career)
                    <a href="{{ Storage::url($employeeCareer->file_career) }}" target="_blank"
                      class="btn btn-sm btn-primary mt-2">Lihat</a>
                  @endif
                </div>

                <div class="form-group">
                  <label class="form-label" for="description">Deskripsi</label>
                  <textarea id="description" type="date" name="description"
                    class="form-control @error('description') is-invalid @enderror" rows="5">{{ old('description', $employeeCareer->description) }}</textarea>
                  @error('description')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
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
