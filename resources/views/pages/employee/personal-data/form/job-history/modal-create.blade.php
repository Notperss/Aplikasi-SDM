<!-- Modals add menu -->
<div id="modal-form-add-job-history" class="modal fade" tabindex="-1" aria-labelledby="modal-form-add-job-history-label"
  aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('employeeJobHistory.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-add-job-history-label">Tambah Data Pengalaman Kerja</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>

        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-12"> <!-- Make form smaller with col-md-6 and center it -->
              <input type="hidden" name="employee_id" value="{{ $employee->id }}">
              <input type="hidden" name="name" value="{{ $employee->name }}">

              <div class="mb-2">
                <label class="form-label" for="company_name">Nama Perusahaan <code>*</code></label>
                <input id="company_name" name="company_name"
                  class="form-control @error('company_name') is-invalid @enderror" required>
                @error('company_name')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label class="form-label" for="position">Posisi / Jabatan <code>*</code></label>
                <input id="position" name="position" class="form-control @error('position') is-invalid @enderror"
                  required>
                @error('position')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>



              {{-- <div class="mb-2">
                <label class="form-label" for="company_type">Jenis Perusahaan</label>
                <input type="text" id="company_type" name="company_type"
                  class="form-control @error('company_type') is-invalid @enderror" required />
                @error('company_type')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div> --}}

              <div class="mb-2">
                <label class="form-label" for="city">Kota</label>
                <input type="text" id="city" name="city"
                  class="form-control @error('city') is-invalid @enderror" />
                @error('city')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label for="period">Periode <code>*</code></label>

                <input type="text" id="period" name="period"
                  class="form-control @error('period') is-invalid @enderror" required />
                {{-- <input type="text" oninput="this.value = this.value.replace(/\D+/g, '')" maxlength="4"
                    id="year" name="period" value="{{ old('period') }}"
                    class="form-control  @error('period') is-invalid @enderror" required /> --}}
                @error('period')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label class="form-label" for="year_out">Tahun Keluar</label>
                <input type="text" id="year_out" name="year_out"
                  class="form-control @error('year_out') is-invalid @enderror" />
                {{-- <input type="text" oninput="this.value = this.value.replace(/\D+/g, '')" maxlength="4"
                    id="year_out" name="year_out" value="{{ old('year_out') }}"
                    class="form-control  @error('year_out') is-invalid @enderror" /> --}}
                @error('year_out')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>




              <div class="mb-2">
                <label for="salary">Gaji Terakhir</label>
                <div class="input-group mb-3">
                  <span class="input-group-text" id="salary">Rp. </span>
                  <input type="text" id="salary" value="{{ old('salary') }}"
                    oninput="this.value = this.value.replace(/\D+/g, '')"
                    class="form-control @error('salary') is-invalid @enderror" name="salary">
                </div>
                @error('salary')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label class="form-label" for="reason">Keterangan Tambahan</label>
                <textarea id="reason" name="reason" class="form-control @error('reason') is-invalid @enderror" rows="2"></textarea>
                @error('reason')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label for="file" class="form-label">File</label>
                <input class="form-control" accept=".pdf" type="file" id="file" name="file">
              </div>
              {{-- <div class="mb-2">
                <label class="form-label" for="job_description">Deskripsi Pekerjaan / Tanggung Jawab</label>
                <textarea id="job_description" name="job_description"
                  class="form-control @error('job_description') is-invalid @enderror" rows="3" required></textarea>
                @error('job_description')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div> --}}
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
