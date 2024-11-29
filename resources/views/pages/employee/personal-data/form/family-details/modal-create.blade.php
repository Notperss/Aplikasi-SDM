<!-- Modals add menu -->
<div id="modal-form-add-family-details" class="modal fade" tabindex="-1"
  aria-labelledby="modal-form-add-family-details-label" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('employeeFamilyDetail.store') }}" method="post">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-add-family-details-label">Tambah Data Keluarga</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>
        <div class="card-body">
          <div class="row">

            <div class="row">
              <input type="hidden" name="employee_id" value="{{ $employee->id }}">

              <div class="col-6 mb-1">
                <label class="form-label" for="relation">Hubungan Keluarga <code>*</code></label>
                <select type="text" id="relation" name="relation"
                  class="form-control @error('relation') is-invalid @enderror" required>
                  <option value="" disabled selected>Choose</option>
                  <option value="BAPAK">Bapak</option>
                  <option value="IBU">Ibu</option>
                  <option value="SUAMI">Suami</option>
                  <option value="ISTRI">Istri</option>
                  <option value="ANAK">Anak</option>
                  <option value="SAUDARA KANDUNG">Saudara Kandung</option>
                </select>
                @error('relation')
                  <a style="color: red">
                    <small>
                      {{ $message }}
                    </small>
                  </a>
                @enderror
              </div>

              <div class="col-6 mb-1">
                <label class="form-label" for="gender">Jenis kelamin <code>*</code></label>
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
              <label class="form-label" for="name">Nama <code>*</code></label>
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
              <label class="form-label" for="dob_family">Tanggal Lahir <code>*</code></label>
              <input type="date" id="dob_family" name="dob_family" value="{{ old('dob_family') }}"
                class="form-control flatpickr-no-config @error('dob_family') is-invalid @enderror"
                placeholder="Select date..">
              @error('dob_family')
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
                class="form-control @error('job') is-invalid @enderror" />
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
                class="form-control choices @error('education') is-invalid @enderror">
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
              <label class="form-label" for="address">Alamat <code>*</code></label>
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

            <div class="row mt-2">
              <div class="col-8">
                <label for="is_in_kk">Masuk Ke dalam Kartu Keluarga</label>
              </div>
              <div class="col-4">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="is_in_kk" id="is_in_kk1" value="1">
                  <label class="form-check-label" for="is_in_kk1">
                    Ya
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="is_in_kk" id="is_in_kk2" value="0"
                    checked>
                  <label class="form-check-label" for="is_in_kk2">
                    Tidak
                  </label>
                </div>
              </div>
            </div>

            {{-- <div class="row mt-2" id="bpjs-field">
              <div class="col-8">
                <label for="is_bpjs">BPJS</label>
              </div>
              <div class="col-4">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="is_bpjs" id="is_bpjs1" value="1">
                  <label class="form-check-label" for="is_bpjs1">
                    Ya
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="is_bpjs" id="is_bpjs2" value="0"
                    checked>
                  <label class="form-check-label" for="is_bpjs2">
                    Tidak
                  </label>
                </div>
              </div>
            </div> --}}

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

{{-- <script>
  $(document).ready(function() {
    // Initially hide the BPJS field
    $('#bpjs-field').hide();

    // Show/hide BPJS based on the selected "Masuk Ke dalam Kartu Keluarga"
    $('input[name="is_in_kk"]').change(function() {
      var selectedValue = $('input[name="is_in_kk"]:checked').val();
      // Show the BPJS field if "Ya" is selected (value is 1)
      if (selectedValue === '1') {
        $('#bpjs-field').show();
      } else {
        // Hide the BPJS field and reset its value
        $('#bpjs-field').hide();
        $('input[name="is_bpjs"]').prop('checked', '0'); // Reset BPJS options
      }
    });

    // Trigger the change event on page load to handle any pre-selected value
    $('input[name="is_in_kk"]:checked').trigger('change');
  });
</script> --}}
