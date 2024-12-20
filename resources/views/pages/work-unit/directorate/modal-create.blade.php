<!-- Modals add menu -->
<div id="modal-form-add-directorate" class="modal fade" tabindex="-1" aria-labelledby="modal-form-add-directorate-label"
  aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('directorate.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-add-directorate-label">Tambah Direktorat</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>

        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-11"> <!-- Make form smaller with col-md-6 and center it -->

              <div class="my-2">
                <label class="form-label" for="code">Kode Direktorat <code>*</code></label>
                <input id="code" name="code" class="form-control @error('code') is-invalid @enderror" required>
                @error('code')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>
              <div class="mb-2">
                <label class="form-label" for="name">Nama Direktorat <code>*</code></label>
                <input id="name" name="name" class="form-control @error('name') is-invalid @enderror" required>
                @error('name')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label class="form-label" for="is_non">Type <code>*</code></label>
                <select id="is_non" name="is_non" class="form-control @error('is_non') is-invalid @enderror"
                  required>
                  <option value="" disabled selected>Choose</option>
                  <option value="2" {{ old('is_non') == '2' ? 'selected' : '' }}>Non-Direktorat</option>
                  <option value="1" {{ old('is_non') == '1' ? 'selected' : '' }}>Direktorat</option>
                  <option value="0" {{ old('is_non') == '0' ? 'selected' : '' }}>Lain-Lain</option>
                </select>
                @error('is_non')
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
