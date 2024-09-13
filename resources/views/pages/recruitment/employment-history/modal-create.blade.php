<!-- Modals add menu -->
<div id="modal-form-add-employment-history" class="modal fade" tabindex="-1"
  aria-labelledby="modal-form-add-employment-history-label" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('employmentHistory.store') }}" method="post">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-add-employment-history-label">Tambah Data Pengalaman Kerja</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>

        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-12"> <!-- Make form smaller with col-md-6 and center it -->
              <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">

              <div class="mb-2">
                <label class="form-label" for="position">Posisi / Jabatan</label>
                <input id="position" name="position" class="form-control @error('position') is-invalid @enderror"
                  required>
                @error('position')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label class="form-label" for="company_name">Nama Perusahaan</label>
                <input id="company_name" name="company_name"
                  class="form-control @error('company_name') is-invalid @enderror" required>
                @error('company_name')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label class="form-label" for="company_type">Jenis Perusahaan</label>
                <input type="text" id="company_type" name="company_type"
                  class="form-control @error('company_type') is-invalid @enderror" required />
                @error('company_type')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label class="form-label" for="direct_supervisor">Nama Atasan Langsung</label>
                <input type="text" id="direct_supervisor" name="direct_supervisor"
                  class="form-control @error('direct_supervisor') is-invalid @enderror" required />
                @error('direct_supervisor')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>
              <div class="row">
                <div class="col-md-6 mb-2">
                  <label for="year_from">Tahun Masuk</label>
                  <input type="text" oninput="this.value = this.value.replace(/\D+/g, '')" maxlength="4"
                    id="year" name="year_from" value="{{ old('year_from') }}"
                    class="form-control  @error('year_from') is-invalid @enderror" />
                  @error('year_from')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>

                <div class="col-md-6 mb-2">
                  <label class="form-label" for="year_to">Tahun Keluar</label>
                  <input type="text" oninput="this.value = this.value.replace(/\D+/g, '')" maxlength="4"
                    id="year_to" name="year_to" value="{{ old('year_to') }}"
                    class="form-control  @error('year_to') is-invalid @enderror" />
                  @error('year_to')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>
              </div>


              <div class="mb-2">
                <label class="form-label" for="reason">Alasan Keluar/Resign</label>
                <textarea id="reason" name="reason" class="form-control @error('reason') is-invalid @enderror" rows="2"
                  required></textarea>
                @error('reason')
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
                <label class="form-label" for="job_description">Deskripsi Pekerjaan / Tanggung Jawab</label>
                <textarea id="job_description" name="job_description"
                  class="form-control @error('job_description') is-invalid @enderror" rows="3" required></textarea>
                @error('job_description')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
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
