<!-- Modals add menu -->
<div id="modal-form-add-kpi{{ $contract->employee->id ?? '' }}" class="modal fade" tabindex="-1"
  aria-labelledby="modal-form-add-kpi{{ $contract->employee->id ?? '' }}-label" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('employeeKpi.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-add-kpi-label">Tambah Data PK</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>

        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-12"> <!-- Make form smaller with col-md-6 and center it -->
              <input type="hidden" name="contract_id" value="{{ $contract->id ?? $employee->id }}">
              <input type="hidden" name="employee_id" value="{{ $contract->employee->id ?? $employee->id }}">
              <input type="hidden" name="name" value="{{ $contract->employee->name ?? $employee->name }}">

              <div class="col-12 mb-2">
                <label class="form-label" for="name">NIK</label>
                <input type="text" id="name" value="{{ $contract->employee->nik ?? $employee->nik }}"
                  class="form-control @error('name') is-invalid @enderror"
                  @if (!$contract->employee->name ?? !$employee->name) hidden @endif readonly>
                @error('name')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="col-12 mb-2">
                <label class="form-label" for="name">Nama Karyawan</label>
                <input type="text" id="name" value="{{ $contract->employee->name ?? $employee->name }}"
                  class="form-control @error('name') is-invalid @enderror"
                  @if (!$contract->employee->name ?? !$employee->name) hidden @endif readonly>
                @error('name')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="col-12 mb-2">
                <label class="form-label" for="kpi_date">Tanggal PK <code>*</code></label>
                <input type="date" id="kpi_date" name="kpi_date" maxlength="4" value="{{ old('kpi_date') }}"
                  class="form-control @error('kpi_date') is-invalid @enderror">
                @error('kpi_date')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label class="form-label" for="grade">Nilai <code>*</code></label>
                <input id="grade" name="grade" value="{{ old('grade') }}"
                  class="form-control @error('grade') is-invalid @enderror" required>
                @error('grade')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label class="form-label" for="contract_recommendation">Rekomendasi Kontrak <code>*</code></label>
                <select id="contract_recommendation" name="contract_recommendation"
                  value="{{ old('contract_recommendation') }}"
                  class="form-control @error('contract_recommendation') is-invalid @enderror">
                  <option value="" disabled selected>Choose</option>
                  <option value="1">Kontrak Kerja Di Perpanjang</option>
                  <option value="0">Kontrak Kerja Tidak Di Lanjutkan</option>
                </select>
                @error('contract_recommendation')
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
