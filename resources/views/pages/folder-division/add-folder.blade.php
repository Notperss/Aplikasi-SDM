    <div class="modal fade" data-backdrop="false" id="modal-form-add-folder" tabindex="-1" dialog>
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Folder</h5>
            <button class="btn close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form class="form" method="POST" action="{{ route('folder.store') }}" enctype="multipart/form-data"
            id="myForm">
            @csrf
            <div class="modal-body">
              <div class="row">
                <input type="hidden" name="parent" value="{{ isset($folders->id) ? $folders->id : '' }}">
                <div class="form-group">
                  <label for="basicInput">Nama Folder <code style="color:red;">*</code></label>
                  <input type="text" class="form-control" id="basicInput" name="name" placeholder="name" required>
                </div>
                <div class="form-group">
                  <label for="basicInput">Keterangan</label>
                  <textarea type="text" class="form-control" id="basicInput" name="description" placeholder="description"></textarea>
                </div>

                {{-- <div class="form-group">
                  <label for="helperText">Parent</label>
                  <select type="text" id="helperText" class="form-control" name="parent">
                    <option value="none">No Parent</option>
                    @foreach ($folders as $folder)
                      <option value="{{ $folder->id }}">{{ $folder->name }}</option>
                    @endforeach
                  </select>
                  <p><small class="text-muted">Find helper text here for given textbox.</small></p>
                </div> --}}

              </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
              <button type="submit" style="width:120px;" class="btn btn-primary">Submit</button>
            </div>
          </form>

        </div>
      </div>
    </div>
