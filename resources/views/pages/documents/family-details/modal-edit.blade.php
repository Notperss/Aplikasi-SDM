<!-- Modals add menu -->
<div id="modal-form-edit-family-details-{{ $candidateFamilyDetail->id }}" class="modal fade" tabindex="-1"
  aria-labelledby="modal-form-edit-family-details-{{ $candidateFamilyDetail->id }}-label" aria-hidden="true"
  style="display: none;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('candidateFamilyDetail.update', $candidateFamilyDetail) }}" method="post">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-edit-family-details-{{ $candidateFamilyDetail->id }}-label">
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
                  <option value="BAPAK"{{ $candidateFamilyDetail->relation == 'BAPAK' ? 'selected' : '' }}>
                    Bapak
                  </option>
                  <option value="IBU"{{ $candidateFamilyDetail->relation == 'IBU' ? 'selected' : '' }}>
                    Ibu
                  </option>
                  <option value="SUAMI"{{ $candidateFamilyDetail->relation == 'SUAMI' ? 'selected' : '' }}>
                    Suami
                  </option>
                  <option value="ISTRI"{{ $candidateFamilyDetail->relation == 'ISTRI' ? 'selected' : '' }}>
                    Istri
                  </option>
                  <option value="ANAK"{{ $candidateFamilyDetail->relation == 'ANAK' ? 'selected' : '' }}>
                    Anak
                  </option>
                  <option
                    value="SAUDARA KANDUNG"{{ $candidateFamilyDetail->relation == 'SAUDARA KANDUNG' ? 'selected' : '' }}>
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
                  <option value="LAKI-LAKI" {{ $candidateFamilyDetail->gender == 'LAKI-LAKI' ? 'selected' : '' }}>
                    Laki-laki
                  </option>
                  <option value="PEREMPUAN" {{ $candidateFamilyDetail->gender == 'PEREMPUAN' ? 'selected' : '' }}>
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
              <input type="text" id="name" name="name" value="{{ $candidateFamilyDetail->name }}"
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
              <label class="form-label" for="dob_family">Tanggal Lahir</label>
              <input type="date" id="dob_family" name="dob_family"
                value="{{ old('dob_family', $candidateFamilyDetail->dob_family) }}"
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
              <input type="text" id="phone_number"
                value="{{ old('phone_number', $candidateFamilyDetail->phone_number) }}" maxlength="13"
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
              <input type="text" id="job" name="job" value="{{ $candidateFamilyDetail->job }}"
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
                <option value="S-3"{{ $candidateFamilyDetail->education == 'S-3' ? 'selected' : '' }}>
                  S-3
                </option>
                <option value="S-2"{{ $candidateFamilyDetail->education == 'S-2' ? 'selected' : '' }}>
                  S-2
                </option>
                <option value="S-1"{{ $candidateFamilyDetail->education == 'S-1' ? 'selected' : '' }}>
                  S-1
                </option>
                <option value="D-4"{{ $candidateFamilyDetail->education == 'D-4' ? 'selected' : '' }}>
                  D-4
                </option>
                <option value="D-3"{{ $candidateFamilyDetail->education == 'D-3' ? 'selected' : '' }}>
                  D-3
                </option>
                <option value="D-2"{{ $candidateFamilyDetail->education == 'D-2' ? 'selected' : '' }}>
                  D-2
                </option>
                <option value="D-1"{{ $candidateFamilyDetail->education == 'D-1' ? 'selected' : '' }}>
                  D-1
                </option>
                <option value="MA"{{ $candidateFamilyDetail->education == 'MA' ? 'selected' : '' }}>
                  MA
                </option>
                <option value="SMK"{{ $candidateFamilyDetail->education == 'SMK' ? 'selected' : '' }}>
                  SMK
                </option>
                <option value="SMA"{{ $candidateFamilyDetail->education == 'SMA' ? 'selected' : '' }}>
                  SMA
                </option>
                <option value="MTS"{{ $candidateFamilyDetail->education == 'MTS' ? 'selected' : '' }}>
                  MTS
                </option>
                <option value="SMP"{{ $candidateFamilyDetail->education == 'SMP' ? 'selected' : '' }}>
                  SMP
                </option>
                <option value="SD"{{ $candidateFamilyDetail->education == 'SD' ? 'selected' : '' }}>
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
                rows="3" required> {{ $candidateFamilyDetail->address }}</textarea>
              @error('address')
                <a style="color: red">
                  <small>
                    {{ $message }}
                  </small>
                </a>
              @enderror
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-8">
              <label for="is_in_kk_edit">Masuk Ke dalam Kartu Keluarga</label>
            </div>
            <div class="col-4">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="is_in_kk_edit" id="is_in_kk1" value="1"
                  @checked($candidateFamilyDetail->is_in_kk == 1)>
                <label class="form-check-label" for="is_in_kk1">
                  Ya
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="is_in_kk_edit" id="is_in_kk2" value="0"
                  @checked($candidateFamilyDetail->is_in_kk == 0)>
                <label class="form-check-label" for="is_in_kk2">
                  Tidak
                </label>
              </div>
            </div>
          </div>

          @if ($candidateFamilyDetail->is_in_kk == 1)
            <div class="row mt-2">
              <div class="col-8">
                <label for="is_bpjs">BPJS</label>
              </div>
              <div class="col-4">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="is_bpjs" id="is_bpjs1" value="1"
                    @checked($candidateFamilyDetail->is_bpjs == 1)>
                  <label class="form-check-label" for="is_bpjs1">
                    Ya
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="is_bpjs" id="is_bpjs2" value="0"
                    @checked($candidateFamilyDetail->is_bpjs == 0)>
                  <label class="form-check-label" for="is_bpjs2">
                    Tidak
                  </label>
                </div>
              </div>
            </div>
          @endif
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary ">Save</button>
        </div>
      </form>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
