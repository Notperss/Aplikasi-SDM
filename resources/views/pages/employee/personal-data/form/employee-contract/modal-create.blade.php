<!-- Modals add menu -->
<div id="modal-form-add-contract{{ $contract->employee->id ?? '' }}" class="modal fade" tabindex="-1"
  aria-labelledby="modal-form-add-contract{{ $contract->employee->id ?? '' }}-label" aria-hidden="true"
  style="display: none;">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <form action="{{ route('contract.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-add-contract-label">Tambah Kategori Karyawan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>

        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-11"> <!-- Make form smaller with col-md-6 and center it -->

              <input type="hidden" name="employee_id" value="{{ $employee->id ?? $contract->employee->id }}">
              <input type="hidden" value="{{ $employee->name ?? $contract->employee->name }}">

              <div class="row">
                <div class="col-3 mb-2">
                  <label class="form-label" for="name">NIK</label>
                  <input type="text" id="name" value="{{ $contract->employee->nik ?? $employee->nik }}"
                    class="form-control @error('name') is-invalid @enderror" readonly>
                  @error('name')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>

                <div class="col-9 mb-2">
                  <label class="form-label" for="name">Nama Karyawan</label>
                  <input type="text" id="name" value="{{ $contract->employee->name ?? $employee->name }}"
                    class="form-control @error('name') is-invalid @enderror" readonly>
                  @error('name')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>
              </div>

              <div class="row">
                <div class="my-2">
                  <label class="form-label" for="contract_number">No. Kontrak <code>*</code></label>
                  <input id="contract_number" name="contract_number"
                    class="form-control @error('contract_number') is-invalid @enderror" required>
                  @error('contract_number')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">

                  <div class="my-2">
                    <label class="form-label" for="nik_employee">NIK Karyawan <code>*</code></label>
                    <input id="nik_employee" name="nik_employee"
                      value="{{ $employee->nik ?? $contract->employee->nik }}"
                      class="form-control @error('nik_employee') is-invalid @enderror" readonly>
                    @error('nik_employee')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>

                  <div class="my-2">
                    <label class="form-label" for="start_date">Tanggal Awal <code>*</code></label>
                    <input type="date" id="start_date" name="start_date"
                      class="form-control @error('start_date') is-invalid @enderror" required>
                    @error('start_date')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>

                  <div class="my-2">
                    <label class="form-label" for="end_date">Tanggal Akhir <code>*</code></label>
                    <input type="date" id="end_date" name="end_date"
                      class="form-control @error('end_date') is-invalid @enderror" required>
                    @error('end_date')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="my-2">
                    <label class="form-label" for="duration">Durasi <code>*</code></label>
                    <input type="number" id="duration" name="duration"
                      class="form-control @error('duration') is-invalid @enderror">
                    @error('duration')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>

                  <div class="my-2">
                    <label class="form-label" for="contract_sequence_number">Kontrak Ke- <code>*</code></label>
                    <input type="number" id="contract_sequence_number" name="contract_sequence_number"
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
                  </div>
                </div>
              </div>

              <div class="col-12">
                <div class="my-2">
                  <label class="form-label" for="description">Keterangan</label>
                  <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror"
                    rows="3"> </textarea>
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
