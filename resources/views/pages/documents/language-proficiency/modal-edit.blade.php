<!-- Modals add menu -->
<div id="modal-form-edit-language-proficiency-{{ $candidateLanguageProficiency->id }}" class="modal fade" tabindex="-1"
  aria-labelledby="modal-form-edit-language-proficiency-{{ $candidateLanguageProficiency->id }}-label" aria-hidden="true"
  style="display: none;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('candidateLanguageProficiency.update', $candidateLanguageProficiency) }}" method="post">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title"
            id="modal-form-edit-language-proficiency-{{ $candidateLanguageProficiency->id }}-label">
            Edit Data Pengalaman Kerja
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>

        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-12"> <!-- Make form smaller with col-md-6 and center it -->
              {{-- <input type="hidden" name="candidate_id" value="{{ $candidate->id }}"> --}}

              <div class="mb-2">
                <label class="form-label" for="language">Bahasa Asing</label>
                <input id="language" name="language" value="{{ $candidateLanguageProficiency->language }}"
                  class="form-control @error('language') is-invalid @enderror" required>
                @error('language')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label class="form-label" for="speaking">Lisan</label>
                <select id="speaking" name="speaking" class="form-control @error('speaking') is-invalid @enderror"
                  required>
                  <option value="" disabled selected>Choose</option>
                  <option value="Cukup"{{ $candidateLanguageProficiency->speaking == 'Cukup' ? 'selected' : '' }}>Cukup
                  </option>
                  <option value="Baik"{{ $candidateLanguageProficiency->speaking == 'Baik' ? 'selected' : '' }}>Baik
                  </option>
                  <option
                    value="Sangat Baik"{{ $candidateLanguageProficiency->speaking == 'Sangat Baik' ? 'selected' : '' }}>
                    Sangat Baik
                  </option>
                </select>
                @error('speaking')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label class="form-label" for="writing">Menulis</label>
                <select id="writing" name="writing" class="form-control @error('writing') is-invalid @enderror"
                  required>
                  <option value="" disabled selected>Choose</option>
                  <option value="Cukup"{{ $candidateLanguageProficiency->writing == 'Cukup' ? 'selected' : '' }}>Cukup
                  </option>
                  <option value="Baik"{{ $candidateLanguageProficiency->writing == 'Baik' ? 'selected' : '' }}>Baik
                  </option>
                  <option
                    value="Sangat Baik"{{ $candidateLanguageProficiency->writing == 'Sangat Baik' ? 'selected' : '' }}>
                    Sangat Baik
                </select>
                @error('writing')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label class="form-label" for="reading">Membaca</label>
                <select id="reading" name="reading" class="form-control @error('reading') is-invalid @enderror"
                  required>
                  <option value="" disabled selected>Choose</option>
                  <option value="Cukup"{{ $candidateLanguageProficiency->reading == 'Cukup' ? 'selected' : '' }}>Cukup
                  </option>
                  <option value="Baik"{{ $candidateLanguageProficiency->reading == 'Baik' ? 'selected' : '' }}>Baik
                  </option>
                  <option
                    value="Sangat Baik"{{ $candidateLanguageProficiency->reading == 'Sangat Baik' ? 'selected' : '' }}>
                    Sangat Baik
                </select>
                @error('reading')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label class="form-label" for="listening">Mendengar</label>
                <select id="listening" name="listening" class="form-control @error('listening') is-invalid @enderror"
                  required>
                  <option value="" disabled selected>Choose</option>
                  <option value="Cukup"{{ $candidateLanguageProficiency->listening == 'Cukup' ? 'selected' : '' }}>
                    Cukup
                  </option>
                  <option value="Baik"{{ $candidateLanguageProficiency->listening == 'Baik' ? 'selected' : '' }}>Baik
                  </option>
                  <option
                    value="Sangat Baik"{{ $candidateLanguageProficiency->listening == 'Sangat Baik' ? 'selected' : '' }}>
                    Sangat Baik
                </select>
                @error('listening')
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
