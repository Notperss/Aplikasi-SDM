<!-- Modals add menu -->
<div id="modal-form-add-emergency-contact" class="modal fade" tabindex="-1"
  aria-labelledby="modal-form-add-emergency-contact-label" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('employeeFamilyDetail.store') }}" method="post">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-add-emergency-contact-label">Tambah Data Keluarga</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>
        <div class="card-body">
          <div class="row">

            <input type="hidden" name="employee_id" value="{{ $employee->id }}">
            <input type="hidden" name="emergency_contact" value="1">

            <div class="col-12 mb-1">
              <label class="form-label" for="relation">Hubungan <code>*</code></label>
              <input type="text" id="relation" name="relation"
                class="form-control @error('relation') is-invalid @enderror" required />
              @error('relation')
                <a style="color: red">
                  <small>
                    {{ $message }}
                  </small>
                </a>
              @enderror
            </div>

            <div class="col-12 mb-1">
              <label class="form-label" for="name">Nama <code>*</code></label>
              <input type="text" id="name" name="name"
                class="form-control @error('name') is-invalid @enderror" required />
              @error('name')
                <a style="color: red">
                  <small>
                    {{ $message }}
                  </small>
                </a>
              @enderror
            </div>

            <div class="col-12 mb-1">
              <label for="phone_number">No. Telpon <code>*</code></label>
              <input type="text" id="phone_number" value="{{ old('phone_number') }}" maxlength="13"
                oninput="this.value = this.value.replace(/\D+/g, '')"
                class="form-control @error('phone_number') is-invalid @enderror" name="phone_number">
              @error('phone_number')
                <a style="color: red">
                  <small>
                    {{ $message }}
                  </small>
                </a>
              @enderror
            </div>

            <div class="col-12 mb-1">
              <label class="form-label" for="address">Alamat <code>*</code></label>
              <textarea type="text" id="address" name="address" class="form-control @error('address') is-invalid @enderror"
                rows="3" required></textarea>
              @error('address')
                <a style="color: red">
                  <small>
                    {{ $message }}
                  </small>
                </a>
              @enderror
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

{{-- <script>
  $(document).ready(function() {
    // Initially hide the BPJS field
    $('#bpjs-field').hide();

    // Show/hide BPJS based on the selected "Masuk Ke dalam Kartu Keluarga"
    $('input[name="is_in_kk"]').change(function() {
      var selectedValue = $('input[name="is_in_kk"]:checked').val();
      // Show the BPJS field if "Ya" is selected (value is 1)
      if (selectedValue === '1') {
        $('#bpjs-field').show();
      } else {
        // Hide the BPJS field and reset its value
        $('#bpjs-field').hide();
        $('input[name="is_bpjs"]').prop('checked', '0'); // Reset BPJS options
      }
    });

    // Trigger the change event on page load to handle any pre-selected value
    $('input[name="is_in_kk"]:checked').trigger('change');
  });
</script> --}}
