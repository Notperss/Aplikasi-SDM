<!-- Modals add menu -->
<div id="modal-form-add-contract" class="modal fade" tabindex="-1" aria-labelledby="modal-form-add-contract-label"
  aria-hidden="true" style="display: none;">
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

              <input type="hidden" name="employee_id" value="{{ $employee->id }}">

              <div class="row">
                <div class="col-md-6">
                  <div class="my-2">
                    <label class="form-label" for="nik_employee">NIK Karyawan</label>
                    <input id="nik_employee" name="nik_employee"
                      class="form-control @error('nik_employee') is-invalid @enderror" required>
                    @error('nik_employee')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>

                  <div class="my-2">
                    <label class="form-label" for="start_date">Tanggal Awal</label>
                    <input type="date" id="start_date" name="start_date"
                      class="form-control @error('start_date') is-invalid @enderror" required>
                    @error('start_date')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>

                  <div class="my-2">
                    <label class="form-label" for="end_date">Tanggal Akhir</label>
                    <input type="date" id="end_date" name="end_date"
                      class="form-control @error('end_date') is-invalid @enderror" required>
                    @error('end_date')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>

                </div>

                <div class="col-md-6">
                  <div class="my-2">
                    <label class="form-label" for="duration">Durasi</label>
                    <input type="number" id="duration" name="duration"
                      class="form-control @error('duration') is-invalid @enderror" required>
                    @error('duration')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>

                  <div class="my-2">
                    <label class="form-label" for="contract_number">Kontrak Ke-</label>
                    <input type="number" id="contract_number" name="contract_number"
                      class="form-control @error('contract_number') is-invalid @enderror" required>
                    @error('contract_number')
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