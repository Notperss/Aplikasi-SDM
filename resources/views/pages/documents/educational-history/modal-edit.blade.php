<!-- Modals add menu -->
<div id="modal-form-edit-educational-history-{{ $candidateEducationalHistory->id }}" class="modal fade" tabindex="-1"
  aria-labelledby="modal-form-edit-educational-history-{{ $candidateEducationalHistory->id }}-label" aria-hidden="true"
  style="display: none;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('candidateEducationalHistory.update', $candidateEducationalHistory) }}" method="post"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-edit-educational-history-{{ $candidateEducationalHistory->id }}-label">
            Edit Data Pengalaman Kerja
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>

        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-12"> <!-- Make form smaller with col-md-6 and center it -->
              <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">
              <input type="hidden" name="name" value="{{ $candidate->name }}">

              <div class="mb-2">
                <label class="form-label" for="school_level">Jenjang</label>
                <select type="text" id="school_level" name="school_level"
                  class="form-control choices @error('school_level') is-invalid @enderror" required>
                  <option value="" disabled selected>Choose</option>
                  <option value="S-3"{{ $candidateEducationalHistory->school_level == 'S-3' ? 'selected' : '' }}>
                    S-3
                  </option>
                  <option value="S-2"{{ $candidateEducationalHistory->school_level == 'S-2' ? 'selected' : '' }}>
                    S-2
                  </option>
                  <option value="S-1"{{ $candidateEducationalHistory->school_level == 'S-1' ? 'selected' : '' }}>
                    S-1
                  </option>
                  <option value="D-4"{{ $candidateEducationalHistory->school_level == 'D-4' ? 'selected' : '' }}>
                    D-4
                  </option>
                  <option value="D-3"{{ $candidateEducationalHistory->school_level == 'D-3' ? 'selected' : '' }}>
                    D-3
                  </option>
                  <option value="D-2"{{ $candidateEducationalHistory->school_level == 'D-2' ? 'selected' : '' }}>
                    D-2
                  </option>
                  <option value="D-1"{{ $candidateEducationalHistory->school_level == 'D-1' ? 'selected' : '' }}>
                    D-1
                  </option>
                  <option value="MA"{{ $candidateEducationalHistory->school_level == 'MA' ? 'selected' : '' }}>
                    MA
                  </option>
                  <option value="SMK"{{ $candidateEducationalHistory->school_level == 'SMK' ? 'selected' : '' }}>
                    SMK
                  </option>
                  <option value="SMA"{{ $candidateEducationalHistory->school_level == 'SMA' ? 'selected' : '' }}>
                    SMA
                  </option>
                  <option value="MTS"{{ $candidateEducationalHistory->school_level == 'MTS' ? 'selected' : '' }}>
                    MTS
                  </option>
                  <option value="SMP"{{ $candidateEducationalHistory->school_level == 'SMP' ? 'selected' : '' }}>
                    SMP
                  </option>
                  <option value="SD"{{ $candidateEducationalHistory->school_level == 'SD' ? 'selected' : '' }}>
                    SD
                  </option>
                </select>
                @error('school_level')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label class="form-label" for="school_name">Institusi</label>
                <input id="school_name" name="school_name" value="{{ $candidateEducationalHistory->school_name }}"
                  class="form-control @error('school_name') is-invalid @enderror" required>
                @error('school_name')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label class="form-label" for="study">Jurusan</label>
                <input type="text" id="study" name="study" value="{{ $candidateEducationalHistory->study }}"
                  class="form-control @error('study') is-invalid @enderror" required />
                @error('study')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="row">
                <div class="col-md-6 mb-2">
                  <label class="form-label" for="graduate">Lulus/Tidak</label>
                  <select type="text" id="graduate" name="graduate"
                    class="form-control @error('graduate') is-invalid @enderror" required>
                    <option value="" disabled selected>Choose</option>
                    <option value="LULUS"
                      {{ old('graduate', $candidateEducationalHistory->graduate) == 'LULUS' ? 'selected' : '' }}> LULUS
                    </option>
                    <option value="TIDAK LULUS"
                      {{ old('graduate', $candidateEducationalHistory->graduate) == 'TIDAK LULUS' ? 'selected' : '' }}>
                      TIDAK
                      LULUS
                    </option>
                  </select>
                  @error('graduate')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>

                <div class="col-md-6 mb-2">
                  <label class="form-label" for="gpa">GPA / NEM</label>
                  <input type="text" value="{{ $candidateEducationalHistory->gpa }}" inputmode="numeric"
                    oninput="this.value = this.value.replace(/[^0-9.]/g, '')" id="gpa" name="gpa"
                    class="form-control @error('gpa') is-invalid @enderror" />
                  @error('gpa')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-2">
                  <label for="year_from">Tahun Masuk</label>
                  <input type="text" value="{{ $candidateEducationalHistory->year_from }}"
                    oninput="this.value = this.value.replace(/\D+/g, '')" maxlength="4" id="year" name="year_from"
                    value="{{ old('year_from') }}" class="form-control  @error('year_from') is-invalid @enderror" />
                  @error('year_from')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>

                <div class="col-md-6 mb-2">
                  <label class="form-label" for="year_to">Tahun Keluar</label>
                  <input type="text" value="{{ $candidateEducationalHistory->year_to }}"
                    oninput="this.value = this.value.replace(/\D+/g, '')" maxlength="4" id="year_to"
                    name="year_to" value="{{ old('year_to') }}"
                    class="form-control  @error('year_to') is-invalid @enderror" />
                  @error('year_to')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>

                <div class="mb-2">
                  <label for="file_ijazah" class="form-label">File Ijazah</label>
                  <input class="form-control" accept=".pdf" type="file" id="file_ijazah" name="file_ijazah">

                  <div class="text-center my-3" style="height: 30px;">
                    <a href="{{ Storage::url($candidateEducationalHistory->file_ijazah) }}" target="_blank">
                      {{ pathinfo($candidateEducationalHistory->file_ijazah, PATHINFO_FILENAME) }}
                    </a>
                  </div>

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
