<!-- Modals add menu -->
<div id="modal-form-edit-contract-{{ $contract->id }}" class="modal fade" tabindex="-1"
  aria-labelledby="modal-form-edit-contract-{{ $contract->id }}-label" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <form action="{{ route('contract.update', $contract) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-edit-contract-{{ $contract->id }}-label">
            Edit Data Kategori karyawan
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>

        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-11"> <!-- Make form smaller with col-md-6 and center it -->

              <div class="row">
                <div class="my-2">
                  <label class="form-label" for="contract_number">No. Kontrak <code>*</code></label>
                  <input id="contract_number" name="contract_number" value="{{ $contract->contract_number }}"
                    class="form-control @error('contract_number') is-invalid @enderror" required>
                  @error('contract_number')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="my-2">
                    <label class="form-label" for="nik_employee">NIK Karyawan</label>
                    <input id="nik_employee" name="nik_employee" value="{{ $contract->nik_employee }}"
                      class="form-control @error('nik_employee') is-invalid @enderror" readonly>
                    @error('nik_employee')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>

                  <div class="my-2">
                    <label class="form-label" for="start_date">Tanggal Awal <code>*</code></label>
                    <input type="date" id="start_date" name="start_date" value="{{ $contract->start_date }}"
                      class="form-control @error('start_date') is-invalid @enderror" required>
                    @error('start_date')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>

                  <div class="my-2">
                    <label class="form-label" for="end_date">Tanggal Akhir <code>*</code></label>
                    <input type="date" id="end_date" name="end_date" value="{{ $contract->end_date }}"
                      class="form-control @error('end_date') is-invalid @enderror" required>
                    @error('end_date')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="my-2">
                    <label class="form-label" for="duration">Durasi</label>
                    <input type="number" id="duration" name="duration" value="{{ $contract->duration }}"
                      class="form-control @error('duration') is-invalid @enderror">
                    @error('duration')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>

                  <div class="my-2">
                    <label class="form-label" for="contract_sequence_number">Kontrak Ke- <code>*</code></label>
                    <input type="number" id="contract_sequence_number" name="contract_sequence_number"
                      value="{{ $contract->contract_sequence_number }}"
                      class="form-control @error('contract_sequence_number') is-invalid @enderror" required>
                    @error('contract_sequence_number')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>

                  <div class="my-2">
                    <label for="file" class="form-label">File</label>
                    <input class="form-control @error('file') is-invalid @enderror" accept=".pdf" type="file"
                      id="file" name="file">
                    @error('file')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror

                    @if ($contract->file)
                      <a href="{{ Storage::url($contract->file) }}" target="_blank"
                        class="btn btn-sm btn-primary mt-2">Lihat</a>
                    @endif
                  </div>
                </div>
              </div>

              <div class="col-12">
                <div class="my-2">
                  <label class="form-label" for="description">Keterangan</label>
                  <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror"
                    rows="3">{{ $contract->description }}</textarea>
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
