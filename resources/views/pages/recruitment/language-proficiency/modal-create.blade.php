<!-- Modals add menu -->
<div id="modal-form-add-language-proficiency" class="modal fade" tabindex="-1"
  aria-labelledby="modal-form-add-language-proficiency-label" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('candidateLanguageProficiency.store') }}" method="post">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-add-language-proficiency-label">Tambah Data Bahasa Asing</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>

        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-12"> <!-- Make form smaller with col-md-6 and center it -->
              <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">

              <div class="mb-2">
                <label class="form-label" for="language">Bahasa Asing</label>
                <input id="language" name="language" class="form-control @error('language') is-invalid @enderror"
                  required>
                @error('language')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label class="form-label" for="speaking">Lisan</label>
                <select id="speaking" name="speaking" class="form-control @error('speaking') is-invalid @enderror"
                  required>
                  <option value="" disabled selected>Choose</option>
                  <option value="Cukup">Cukup</option>
                  <option value="Baik">Baik</option>
                  <option value="Sangat Baik">Sangat Baik</option>
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
                  <option value="Cukup">Cukup</option>
                  <option value="Baik">Baik</option>
                  <option value="Sangat Baik">Sangat Baik</option>
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
                  <option value="Cukup">Cukup</option>
                  <option value="Baik">Baik</option>
                  <option value="Sangat Baik">Sangat Baik</option>
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
                  <option value="Cukup">Cukup</option>
                  <option value="Baik">Baik</option>
                  <option value="Sangat Baik">Sangat Baik</option>
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
