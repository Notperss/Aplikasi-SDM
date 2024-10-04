<!-- Modals add menu -->
<div id="modal-form-add-division" class="modal fade" tabindex="-1" aria-labelledby="modal-form-add-division-label"
  aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('division.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-add-division-label">Tambah Divisi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>

        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-11"> <!-- Make form smaller with col-md-6 and center it -->

              <div class="my-2">
                <label class="form-label" for="directorate_id">Direktorat</label>
                <select id="directorate_id" name="directorate_id"
                  class="form-control @error('directorate_id') is-invalid @enderror" required>
                  <option value="" disabled selected>Choose</option>
                  @foreach ($directorates as $directorate)
                    <option value="{{ $directorate->id }}">{{ $directorate->name }}</option>
                  @endforeach
                </select>
                @error('directorate_id')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label class="form-label" for="code">Kode Divisi</label>
                <input id="code" name="code" maxlength="5"
                  class="form-control @error('code') is-invalid @enderror" required>
                @error('code')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="my-2">
                <label class="form-label" for="name">Nama Divisi</label>
                <input id="name" name="name" class="form-control @error('name') is-invalid @enderror" required>
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
