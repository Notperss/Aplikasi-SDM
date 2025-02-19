<!-- Modals add menu -->
<div id="modal-form-edit-educational-history-{{ $employeeEducationalHistory->id }}" class="modal fade" tabindex="-1"
  aria-labelledby="modal-form-edit-educational-history-{{ $employeeEducationalHistory->id }}-label" aria-hidden="true"
  style="display: none;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('employeeEducationalHistory.update', $employeeEducationalHistory) }}" method="post"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-edit-educational-history-{{ $employeeEducationalHistory->id }}-label">
            Edit Data Pengalaman Kerja
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>

        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-12"> <!-- Make form smaller with col-md-6 and center it -->
              <input type="hidden" name="employee_id" value="{{ $employee->id }}">
              <input type="hidden" name="name" value="{{ $employee->name }}">

              <div class="mb-2">
                <label class="form-label" for="school_level">Jenjang <code>*</code></label>
                <select type="text" id="school_level" name="school_level"
                  class="form-control choices @error('school_level') is-invalid @enderror" required>
                  <option value="" disabled selected>Choose</option>
                  <option value="S-3"{{ $employeeEducationalHistory->school_level == 'S-3' ? 'selected' : '' }}>
                    S-3
                  </option>
                  <option value="S-2"{{ $employeeEducationalHistory->school_level == 'S-2' ? 'selected' : '' }}>
                    S-2
                  </option>
                  <option value="S-1"{{ $employeeEducationalHistory->school_level == 'S-1' ? 'selected' : '' }}>
                    S-1
                  </option>
                  <option value="D-4"{{ $employeeEducationalHistory->school_level == 'D-4' ? 'selected' : '' }}>
                    D-4
                  </option>
                  <option value="D-3"{{ $employeeEducationalHistory->school_level == 'D-3' ? 'selected' : '' }}>
                    D-3
                  </option>
                  <option value="D-2"{{ $employeeEducationalHistory->school_level == 'D-2' ? 'selected' : '' }}>
                    D-2
                  </option>
                  <option value="D-1"{{ $employeeEducationalHistory->school_level == 'D-1' ? 'selected' : '' }}>
                    D-1
                  </option>
                  <option value="MA"{{ $employeeEducationalHistory->school_level == 'MA' ? 'selected' : '' }}>
                    MA
                  </option>
                  <option value="SMK"{{ $employeeEducationalHistory->school_level == 'SMK' ? 'selected' : '' }}>
                    SMK
                  </option>
                  <option value="SMA"{{ $employeeEducationalHistory->school_level == 'SMA' ? 'selected' : '' }}>
                    SMA
                  </option>
                  <option value="MTS"{{ $employeeEducationalHistory->school_level == 'MTS' ? 'selected' : '' }}>
                    MTS
                  </option>
                  <option value="SMP"{{ $employeeEducationalHistory->school_level == 'SMP' ? 'selected' : '' }}>
                    SMP
                  </option>
                  <option value="SD"{{ $employeeEducationalHistory->school_level == 'SD' ? 'selected' : '' }}>
                    SD
                  </option>
                </select>
                @error('school_level')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label class="form-label" for="school_name">Institusi/Nama Sekolah <code>*</code></label>
                <input id="school_name" name="school_name" value="{{ $employeeEducationalHistory->school_name }}"
                  class="form-control @error('school_name') is-invalid @enderror" required>
                @error('school_name')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label class="form-label" for="study">Jurusan</label>
                <input type="text" id="study" name="study" value="{{ $employeeEducationalHistory->study }}"
                  class="form-control @error('study') is-invalid @enderror" />
                @error('study')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label class="form-label" for="city">Tempat/Kota</label>
                <input type="text" id="city" name="city" value="{{ $employeeEducationalHistory->city }}"
                  class="form-control @error('city') is-invalid @enderror" />
                @error('city')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="row">
                <div class="col-md-6 mb-2">
                  <label class="form-label" for="graduate">Lulus/Tidak Lulus</label>
                  <select type="text" id="graduate" name="graduate"
                    class="form-control @error('graduate') is-invalid @enderror" required>
                    <option value="" disabled selected>Choose</option>
                    <option value="LULUS"
                      {{ old('graduate', $employeeEducationalHistory->graduate) == 'LULUS' ? 'selected' : '' }}> LULUS
                    </option>
                    <option value="TIDAK LULUS"
                      {{ old('graduate', $employeeEducationalHistory->graduate) == 'TIDAK LULUS' ? 'selected' : '' }}>
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
                  <input type="text" value="{{ $employeeEducationalHistory->gpa }}" inputmode="numeric"
                    oninput="this.value = this.value.replace(/[^0-9.]/g, '')" id="gpa" name="gpa"
                    class="form-control @error('gpa') is-invalid @enderror" />
                  @error('gpa')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-2">
                  <label for="year_from">Tahun Masuk <code>*</code></label>
                  <input type="text" value="{{ $employeeEducationalHistory->year_from }}"
                    oninput="this.value = this.value.replace(/\D+/g, '')" maxlength="4" id="year"
                    name="year_from" value="{{ old('year_from') }}"
                    class="form-control  @error('year_from') is-invalid @enderror" required />
                  @error('year_from')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>

                <div class="col-md-6 mb-2">
                  <label class="form-label" for="year_to">Tahun Keluar</label>
                  <input type="text" value="{{ $employeeEducationalHistory->year_to }}"
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
                    <a href="{{ Storage::url($employeeEducationalHistory->file_ijazah) }}" target="_blank">
                      {{ pathinfo($employeeEducationalHistory->file_ijazah, PATHINFO_FILENAME) }}
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
