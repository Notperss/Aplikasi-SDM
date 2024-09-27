<!-- Modals add menu -->
<div id="modal-form-add-department" class="modal fade" tabindex="-1" aria-labelledby="modal-form-add-department-label"
  aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('department.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-add-department-label">Tambah Divisi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>

        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-11"> <!-- Make form smaller with col-md-6 and center it -->

              <div class="mb-2">
                <label class="form-label" for="directorate_id">Direktorat</label>
                <select id="store_directorate_id" name="directorate_id"
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
                <label class="form-label" for="division_id">Divisi</label>
                <select id="store_division_id" name="division_id"
                  class="form-control @error('division_id') is-invalid @enderror" required>
                  <option value="" disabled selected>Choose</option>
                  {{-- @foreach ($divisions as $division)
                    <option value="{{ $division->id }}">{{ $division->name }}</option>
                  @endforeach --}}
                </select>
                @error('division_id')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>


              <div class="my-2">
                <label class="form-label" for="name">Department</label>
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
<script>
  $(function() {
    const divisionSelect = new Choices('#store_division_id', {
      searchEnabled: true,
      shouldSort: false
    });

    $('#store_directorate_id').change(function() {
      var directorateId = $(this).val();
      if (directorateId) {
        $.ajax({
          url: "{{ route('getDivisions') }}",
          type: 'GET',
          dataType: 'json',
          data: {
            directorate_id: directorateId
          },
          success: function(data) {
            // Clear the existing options
            divisionSelect.clearStore();
            divisionSelect.clearChoices();

            // Add a default 'Choose' option
            divisionSelect.setChoices([{
              value: '',
              label: 'Choose',
              disabled: true,
              selected: true
            }]);

            // Add new options from the AJAX response
            $.each(data, function(key, value) {
              divisionSelect.setChoices([{
                value: value.id,
                label: value.name
              }]);
            });
          }
        });
      } else {
        // Clear the dropdown if no directorate is selected
        divisionSelect.clearStore();
        divisionSelect.clearChoices();
        divisionSelect.setChoices([{
          value: '',
          label: 'Choose',
          disabled: true,
          selected: true
        }]);
      }
    });
  });
</script>
