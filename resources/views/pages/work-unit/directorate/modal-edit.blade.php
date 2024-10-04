<!-- Modals add menu -->
<div id="modal-form-edit-directorate-{{ $directorate->id }}" class="modal fade" tabindex="-1"
  aria-labelledby="modal-form-edit-directorate-{{ $directorate->id }}-label" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('directorate.update', $directorate) }}" method="post">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-edit-directorate-{{ $directorate->id }}-label">
            Edit Data Direktorat
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>

        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-11"> <!-- Make form smaller with col-md-6 and center it -->

              <div class="my-2">
                <label class="form-label" for="code">Kode Direktorat</label>
                <input id="code" name="code" value="{{ $directorate->code }}"
                  class="form-control @error('code') is-invalid @enderror" required>
                @error('code')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label class="form-label" for="name">Nama Direktorat</label>
                <input id="name" name="name" value="{{ $directorate->name }}"
                  class="form-control @error('name') is-invalid @enderror" required>
                @error('name')
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
