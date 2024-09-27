<!-- Modals add menu -->
<div id="modal-form-add-company" class="modal fade modal-form-company" tabindex="-1"
  aria-labelledby="modal-form-add-company-label" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="modal-form" action="{{ route('company.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-add-company-label">Add Company</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
              name="name">
            @error('name')
              <a style="color: red">
                <small>
                  {{ $message }}
                </small>
              </a>
            @enderror
          </div>

          <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="address" class="form-control @error('address') is-invalid @enderror" id="address"
              name="address">
            @error('address')
              <a style="color: red">
                <small>
                  {{ $message }}
                </small>
              </a>
            @enderror
          </div>

          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea type="description" class="form-control @error('description') is-invalid @enderror" id="description"
              name="description" rows="3"> </textarea>
            @error('description')
              <a style="color: red">
                <small>
                  {{ $message }}
                </small>
              </a>
            @enderror
          </div>

          <div class="mb-2">
            <label for="logo" class="form-label">Logo</label>
            <input class="form-control" accept=".jpg, .jpeg, .png" type="file" id="logo" name="logo">
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
