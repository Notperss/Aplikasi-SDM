<!-- Modals history menu -->
<div id="modal-form-history-selection" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="modal-form-history-selection-label" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content">
      <form id="historyForm" action="{{ route('historySelection.store', $selection) }}" method="post"
        enctype="multipart/form-data">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-history-selection-label">Tambah Tahapan Seleksi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>

        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-11"> <!-- Make form smaller with col-md-6 and center it -->
              <div class="row">

                <div class="col-md-12">

                  <div class="my-2">
                    <label class="form-label" for="date">Tanggal <code>*</code></label>
                    <input type="date" id="date" name="date" value="{{ old('date') }}"
                      class="form-control @error('date') is-invalid @enderror">
                    @error('date')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>

                  <div class="mb-2">
                    <label class="form-label" for="name_process">Proses <code>*</code></label>
                    <input id="name_process" name="name_process" value="{{ old('name_process') }}"
                      class="form-control @error('name_process') is-invalid @enderror" required>
                    @error('name_process')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>

                  <div class="mb-2">
                    <label class="form-label" for="description">Keterangan</label>
                    <textarea id="description" name="description" rows="5"
                      class="form-control @error('description') is-invalid @enderror">{{ old('description') }} </textarea>
                    @error('description')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>

                </div>

              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
          <a onclick="storeHistory()" class="btn btn-primary ">Save</a>
        </div>
      </form>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
  function storeHistory() {
    Swal.fire({
      title: 'Are you sure?',
      // text: 'You won\'t be able to revert this!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes!'
    }).then((result) => {
      if (result.isConfirmed) {
        // If the user clicks "Yes, delete it!", submit the corresponding form
        document.getElementById('historyForm').submit();
      }
    });
  }
</script>
