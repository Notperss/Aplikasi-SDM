<!-- Modals add menu -->
<div id="modal-form-edit-social-platform-{{ $candidateSocialPlatform->id }}" class="modal fade" tabindex="-1"
  aria-labelledby="modal-form-edit-social-platform-{{ $candidateSocialPlatform->id }}-label" aria-hidden="true"
  style="display: none;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('candidateSocialPlatform.update', $candidateSocialPlatform) }}" method="post">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-edit-social-platform-{{ $candidateSocialPlatform->id }}-label">
            Edit Data Pengalaman Kerja
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>

        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-12"> <!-- Make form smaller with col-md-6 and center it -->
              <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">

              <div class="mb-2">
                <label class="form-label" for="platform">Platform</label>
                <select id="platform" name="platform" class="form-control @error('platform') is-invalid @enderror"
                  required>
                  <option value="" disabled selected>Choose</option>
                  <option value="Instagram"
                    {{ old('platform', $candidateSocialPlatform->platform) == 'Instagram' ? 'selected' : '' }}>Instagram
                  </option>
                  <option value="LinkedIn"
                    {{ old('platform', $candidateSocialPlatform->platform) == 'LinkedIn' ? 'selected' : '' }}>
                    LinkedIn</option>
                  <option value="Facebook"
                    {{ old('platform', $candidateSocialPlatform->platform) == 'Facebook' ? 'selected' : '' }}>
                    Facebook</option>
                  <option value="Twitter"
                    {{ old('platform', $candidateSocialPlatform->platform) == 'Twitter' ? 'selected' : '' }}>
                    Twitter</option>
                  <option value="Tik-Tok"
                    {{ old('platform', $candidateSocialPlatform->platform) == 'Tik-Tok' ? 'selected' : '' }}>
                    Tik-Tok</option>
                  <option value="Discord"
                    {{ old('platform', $candidateSocialPlatform->platform) == 'Discord' ? 'selected' : '' }}>
                    Discord</option>
                  <option value="Platform-lainnya"
                    {{ old('platform', $candidateSocialPlatform->platform) == 'Platform-lainnya' ? 'selected' : '' }}>
                    Platform-lainnya</option>
                </select>
                @error('platform')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label class="form-label" for="account_name">Nama Akun</label>
                <input id="account_name" name="account_name"
                  value="{{ old('account_name', $candidateSocialPlatform->account_name) }}"
                  class="form-control @error('account_name') is-invalid @enderror" required>
                @error('account_name')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label class="form-label" for="account_link">Link Akun</label>
                <input id="account_link" name="account_link"
                  value="{{ old('account_link', $candidateSocialPlatform->account_link) }}"
                  class="form-control @error('account_link') is-invalid @enderror">
                @error('account_link')
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
