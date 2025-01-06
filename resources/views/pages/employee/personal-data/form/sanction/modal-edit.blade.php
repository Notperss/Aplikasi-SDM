<!-- Modals add menu -->
<div id="modal-form-edit-sanction-{{ $sanction->id }}" class="modal fade"
  aria-labelledby="modal-form-edit-sanction-{{ $sanction->id }}-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('employeeSanction.update', $sanction) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-edit-sanction-{{ $sanction->id }}-label">
            Edit Data Sertifikasi
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>

        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-12"> <!-- Make form smaller with col-md-6 and center it -->
              {{-- <input type="hidden" name="employee_id" value="{{ $employee->id }}"> --}}
              <input type="hidden" name="name" value="{{ $employee->name }}">
              {{-- <input type="hidden" name="is_certificated" value="1"> --}}

              <div class="mb-2">
                <label class="form-label" for="sanction_name">Nama Sanksi</label>
                <input id="sanction_name" name="sanction_name"
                  value="{{ old('sanction_name', $sanction->sanction_name) }}"
                  class="form-control @error('sanction_name') is-invalid @enderror" required>
                @error('sanction_name')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label class="form-label" for="sanction_category">Kategori Sanksi</label>
                <select id="sanction_category" name="sanction_category" value="{{ old('sanction_category') }}"
                  class="form-control @error('sanction_category') is-invalid @enderror" required>
                  <option value="" disabled selected>Choose</option>
                  <option value="TEGURAN LISAN"
                    {{ old('sanction_category', $sanction->sanction_category) == 'TEGURAN LISAN' ? 'selected' : '' }}>
                    TEGURAN LISAN</option>
                  <option value="TEGURAN TERTULIS"
                    {{ old('sanction_category', $sanction->sanction_category) == 'TEGURAN TERTULIS' ? 'selected' : '' }}>
                    TEGURAN TERTULIS</option>
                  <option value="SP1"
                    {{ old('sanction_category', $sanction->sanction_category) == 'SP1' ? 'selected' : '' }}>
                    SP1</option>
                  <option value="SP2"
                    {{ old('sanction_category', $sanction->sanction_category) == 'SP2' ? 'selected' : '' }}>
                    SP2</option>
                  <option value="SP3"
                    {{ old('sanction_category', $sanction->sanction_category) == 'SP3' ? 'selected' : '' }}>
                    SP3</option>
                </select>
                @error('sanction_category')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="row">
                <div class="col-6 mb-2">
                  <label class="form-label" for="start_date">Tanggal Mulai</label>
                  <input type="date" id="start_date" name="start_date" maxlength="4"
                    value="{{ old('start_date', $sanction->start_date) }}"
                    class="form-control @error('start_date') is-invalid @enderror">
                  @error('start_date')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>
                <div class="col-6 mb-2">
                  <label class="form-label" for="end_date">Tanggal Akhir</label>
                  <input type="date" id="end_date" name="end_date" maxlength="4"
                    value="{{ old('end_date', $sanction->end_date) }}"
                    class="form-control @error('end_date') is-invalid @enderror">
                  @error('end_date')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>
              </div>

              <div class="mb-2">
                <label for="file_sanction" class="form-label">File</label>
                <input class="form-control" accept=".pdf" type="file" id="file_sanction"
                  @error('file_sanction') is-invalid @enderror name="file_sanction">
                @error('file_sanction')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
                <div class="text-center my-3" style="height: 30px;">
                  <a href="{{ Storage::url($sanction->file_sanction) }}" target="_blank">
                    {{ pathinfo($sanction->file_sanction, PATHINFO_FILENAME) }}
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
