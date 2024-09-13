<!-- Modals add menu -->
<div id="modal-form-add-family-details" class="modal fade" tabindex="-1"
  aria-labelledby="modal-form-add-family-details-label" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('familyDetails.store') }}" method="post">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-add-family-details-label">Tambah Data Keluarga</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>
        <div class="card-body">
          <div class="row">

            <div class="row">
              <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">

              <div class="col-6 mb-1">
                <label class="form-label" for="relationship">Hubungan Keluarga</label>
                <select type="text" id="relationship" name="relationship"
                  class="form-control @error('relationship') is-invalid @enderror" required>
                  <option value="" disabled selected>Choose</option>
                  <option value="BAPAK">Bapak</option>
                  <option value="IBU">Ibu</option>
                  <option value="SUAMI">Suami</option>
                  <option value="ISTRI">Istri</option>
                  <option value="ANAK">Anak</option>
                  <option value="SAUDARA KANDUNG">Saudara Kandung</option>
                </select>
                @error('relationship')
                  <a style="color: red">
                    <small>
                      {{ $message }}
                    </small>
                  </a>
                @enderror
              </div>

              <div class="col-6 mb-1">
                <label class="form-label" for="gender">Jenis kelamin</label>
                <select type="text" id="gender" name="gender"
                  class="form-control @error('gender') is-invalid @enderror" required>
                  <option value="" disabled selected>Choose</option>
                  <option value="LAKI-LAKI">Laki-laki</option>
                  <option value="PEREMPUAN">Perempuan</option>
                </select>
                @error('gender')
                  <a style="color: red">
                    <small>
                      {{ $message }}
                    </small>
                  </a>
                @enderror
              </div>
            </div>

            <div class="col-12 mb-1">
              <label class="form-label" for="name">Nama</label>
              <input type="text" id="name" name="name"
                class="form-control @error('name') is-invalid @enderror" required />
              @error('name')
                <a style="color: red">
                  <small>
                    {{ $message }}
                  </small>
                </a>
              @enderror
            </div>

            <div class="col-12 mb-1">
              <label class="form-label" for="dob">Tanggal Lahir</label>
              <input type="date" id="dob" name="dob" value="{{ old('dob') }}"
                class="form-control flatpickr-no-config @error('dob') is-invalid @enderror" placeholder="Select date..">
              @error('dob')
                <a style="color: red">
                  <small>
                    {{ $message }}
                  </small>
                </a>
              @enderror
            </div>

            <div class="col-12 mb-1">
              <label for="phone_number">No. Telpon</label>
              <input type="text" id="phone_number" value="{{ old('phone_number') }}" maxlength="13"
                oninput="this.value = this.value.replace(/\D+/g, '')"
                class="form-control @error('phone_number') is-invalid @enderror" name="phone_number">
              @error('phone_number')
                <a style="color: red">
                  <small>
                    {{ $message }}
                  </small>
                </a>
              @enderror
            </div>

            <div class="col-12 mb-1">
              <label class="form-label" for="job">Pekerjaan Terakhir</label>
              <input type="text" id="job" name="job"
                class="form-control @error('job') is-invalid @enderror" required />
              @error('job')
                <a style="color: red">
                  <small>
                    {{ $message }}
                  </small>
                </a>
              @enderror
            </div>

            <div class="col-12 mb-1">
              <label class="form-label" for="education">Pendidikan Terakhir</label>
              <select type="text" id="education" name="education"
                class="form-control choices @error('education') is-invalid @enderror" required>
                <option value="" disabled selected>Choose</option>
                <option value="S-3"> S-3 </option>
                <option value="S-2"> S-2 </option>
                <option value="S-1"> S-1 </option>
                <option value="D-4"> D-4 </option>
                <option value="D-3"> D-3 </option>
                <option value="D-2"> D-2 </option>
                <option value="D-1"> D-1 </option>
                <option value="MA"> MA </option>
                <option value="SMK"> SMK </option>
                <option value="SMA"> SMA </option>
                <option value="MTS"> MTS </option>
                <option value="SMP"> SMP </option>
                <option value="SD"> SD </option>
              </select>
              @error('education')
                <a style="color: red">
                  <small>
                    {{ $message }}
                  </small>
                </a>
              @enderror
            </div>

            <div class="col-12 mb-1">
              <label class="form-label" for="address">Alamat</label>
              <textarea type="text" id="address" name="address" class="form-control @error('address') is-invalid @enderror"
                rows="3" required></textarea>
              @error('address')
                <a style="color: red">
                  <small>
                    {{ $message }}
                  </small>
                </a>
              @enderror
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
