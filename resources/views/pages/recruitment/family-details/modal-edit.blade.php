<!-- Modals add menu -->
<div id="modal-form-edit-family-details-{{ $familyDetail->id }}" class="modal fade" tabindex="-1"
  aria-labelledby="modal-form-edit-family-details-{{ $familyDetail->id }}-label" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('familyDetails.update', $familyDetail) }}" method="post">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-edit-family-details-{{ $familyDetail->id }}-label">
            Edit Data Keluarga
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>
        <div class="card-body">
          <div class="row">

            <div class="row">
              <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">

              <div class="col-6 mb-1">
                <label class="form-label" for="relation">Hubungan Keluarga</label>
                <select type="text" id="relation" name="relation"
                  class="form-control @error('relation') is-invalid @enderror" required>
                  <option value="" disabled selected>Choose</option>
                  <option value="BAPAK"{{ $familyDetail->relation == 'BAPAK' ? 'selected' : '' }}>
                    Bapak
                  </option>
                  <option value="IBU"{{ $familyDetail->relation == 'IBU' ? 'selected' : '' }}>
                    Ibu
                  </option>
                  <option value="SUAMI"{{ $familyDetail->relation == 'SUAMI' ? 'selected' : '' }}>
                    Suami
                  </option>
                  <option value="ISTRI"{{ $familyDetail->relation == 'ISTRI' ? 'selected' : '' }}>
                    Istri
                  </option>
                  <option value="ANAK"{{ $familyDetail->relation == 'ANAK' ? 'selected' : '' }}>
                    Anak
                  </option>
                  <option value="SAUDARA KANDUNG"{{ $familyDetail->relation == 'SAUDARA KANDUNG' ? 'selected' : '' }}>
                    Saudara Kandung
                  </option>
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
                <label class="form-label" for="gender">Jenis kelamin</label>
                <select type="text" id="gender" name="gender"
                  class="form-control @error('gender') is-invalid @enderror" required>
                  <option value="" disabled selected>Choose</option>
                  <option value="LAKI-LAKI" {{ $familyDetail->gender == 'LAKI-LAKI' ? 'selected' : '' }}>
                    Laki-laki
                  </option>
                  <option value="PEREMPUAN" {{ $familyDetail->gender == 'PEREMPUAN' ? 'selected' : '' }}>
                    Perempuan
                  </option>
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
              <input type="text" id="name" name="name" value="{{ $familyDetail->name }}"
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
              <input type="date" id="dob" name="dob" value="{{ old('dob', $familyDetail->dob) }}"
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
              <input type="text" id="phone_number" value="{{ old('phone_number', $familyDetail->phone_number) }}"
                maxlength="13" oninput="this.value = this.value.replace(/\D+/g, '')"
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
              <input type="text" id="job" name="job" value="{{ $familyDetail->job }}"
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
                <option value="S-3"{{ $familyDetail->education == 'S-3' ? 'selected' : '' }}>
                  S-3
                </option>
                <option value="S-2"{{ $familyDetail->education == 'S-2' ? 'selected' : '' }}>
                  S-2
                </option>
                <option value="S-1"{{ $familyDetail->education == 'S-1' ? 'selected' : '' }}>
                  S-1
                </option>
                <option value="D-4"{{ $familyDetail->education == 'D-4' ? 'selected' : '' }}>
                  D-4
                </option>
                <option value="D-3"{{ $familyDetail->education == 'D-3' ? 'selected' : '' }}>
                  D-3
                </option>
                <option value="D-2"{{ $familyDetail->education == 'D-2' ? 'selected' : '' }}>
                  D-2
                </option>
                <option value="D-1"{{ $familyDetail->education == 'D-1' ? 'selected' : '' }}>
                  D-1
                </option>
                <option value="MA"{{ $familyDetail->education == 'MA' ? 'selected' : '' }}>
                  MA
                </option>
                <option value="SMK"{{ $familyDetail->education == 'SMK' ? 'selected' : '' }}>
                  SMK
                </option>
                <option value="SMA"{{ $familyDetail->education == 'SMA' ? 'selected' : '' }}>
                  SMA
                </option>
                <option value="MTS"{{ $familyDetail->education == 'MTS' ? 'selected' : '' }}>
                  MTS
                </option>
                <option value="SMP"{{ $familyDetail->education == 'SMP' ? 'selected' : '' }}>
                  SMP
                </option>
                <option value="SD"{{ $familyDetail->education == 'SD' ? 'selected' : '' }}>
                  SD
                </option>
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
                rows="3" required> {{ $familyDetail->address }}</textarea>
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
