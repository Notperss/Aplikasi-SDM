<!-- Modals add menu -->
<div id="modal-form-add-boxNumber" class="modal fade" tabindex="-1" aria-labelledby="modal-form-add-boxNumber-label"
  aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('boxNumber.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-add-boxNumber-label">Tambah Nomor Box</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>

        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-11"> <!-- Make form smaller with col-md-6 and center it -->

              <div class="my-2">
                <label class="form-label" for="box_number">Nomor Box <code>*</code></label>
                <input id="box_number" name="box_number" value="{{ old('box_number') }}"
                  class="form-control @error('box_number') is-invalid @enderror" required>
                @error('box_number')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label class="form-label" for="description">Deskripsi</label>
                <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror"
                  rows="5">{{ old('description') }}</textarea>
                @error('description')
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
