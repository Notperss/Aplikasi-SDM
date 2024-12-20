<!-- Modals add menu -->
<div id="modal-form-add-position" class="modal fade" tabindex="-1" aria-labelledby="modal-form-add-position-label"
  aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('position.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-add-position-label">Tambah Jabatan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>

        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-11"> <!-- Make form smaller with col-md-6 and center it -->

              <div class="row">
                <div class="col-md-6">
                  <div class="my-2">
                    <label class="form-label" for="directorate_id">Direktorat <code>*</code></label>
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
                    <label class="form-label" for="division_id">Divisi <code>*</code></label>
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

                  <div class="mb-2">
                    <label class="form-label" for="department_id">Department</label>
                    <select id="store_department_id" name="department_id"
                      class="form-control @error('department_id') is-invalid @enderror">
                      <option value="" disabled selected>Choose</option>
                      {{-- @foreach ($departments as $department)
                      <option value="{{ $department->id }}">{{ $department->name }}</option>
                      @endforeach --}}
                    </select>
                    @error('department_id')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>

                  <div class="my-2">
                    <label class="form-label" for="section_id">Seksi</label>
                    <select id="store_section_id" name="section_id"
                      class="form-control @error('section_id') is-invalid @enderror">
                      <option value="" disabled selected>Choose</option>
                      {{-- @foreach ($sections as $section)
                      <option value="{{ $section->id }}">{{ $section->name }}</option>
                      @endforeach --}}
                    </select>
                    @error('section_id')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="my-2">
                    <label class="form-label" for="level_id">Level <code>*</code></label>
                    <select id="level_id" name="level_id" class="form-control @error('level_id') is-invalid @enderror"
                      required>
                      <option value="" disabled selected>Choose</option>
                      @foreach ($levels as $level)
                        <option value="{{ $level->id }}" {{ old('level_id') ? 'selected' : '' }}>{{ $level->name }}
                        </option>
                      @endforeach
                    </select>
                    @error('level_id')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>

                  <div class="mb-2">
                    <label class="form-label" for="name">Nama Jabatan <code>*</code></label>
                    <input id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                      required>
                    @error('name')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>

                  <div class="my-2">
                    <label class="form-label" for="description">Deskripsi</label>
                    <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror"
                      rows="5"> {{ old('description') }} </textarea>
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
          <button type="submit" class="btn btn-primary ">Save</button>
        </div>
      </form>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--getDivisions -->
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
<!--getDepartments-->
<script>
  $(function() {
    const departmentSelect = new Choices('#store_department_id', {
      searchEnabled: true,
      shouldSort: false
    });

    $('#store_division_id').change(function() {
      var divisionId = $(this).val();
      if (divisionId) {
        $.ajax({
          url: "{{ route('getDepartments') }}",
          type: 'GET',
          dataType: 'json',
          data: {
            division_id: divisionId
          },
          success: function(data) {
            // Clear the existing options
            departmentSelect.clearStore();
            departmentSelect.clearChoices();

            // Add a default 'Choose' option
            departmentSelect.setChoices([{
              value: '',
              label: 'Choose',
              disabled: true,
              selected: true
            }]);

            // Add new options from the AJAX response
            $.each(data, function(key, value) {
              departmentSelect.setChoices([{
                value: value.id,
                label: value.name
              }]);
            });
          }
        });
      } else {
        // Clear the dropdown if no directorate is selected
        departmentSelect.clearStore();
        departmentSelect.clearChoices();
        departmentSelect.setChoices([{
          value: '',
          label: 'Choose',
          disabled: true,
          selected: true
        }]);
      }
    });
  });
</script>
<!--getSections -->
<script>
  $(function() {
    const sectionSelect = new Choices('#store_section_id', {
      searchEnabled: true,
      shouldSort: false
    });

    $('#store_department_id').change(function() {
      var departmentId = $(this).val();
      if (departmentId) {
        $.ajax({
          url: "{{ route('getSections') }}",
          type: 'GET',
          dataType: 'json',
          data: {
            department_id: departmentId
          },
          success: function(data) {
            // Clear the existing options
            sectionSelect.clearStore();
            sectionSelect.clearChoices();

            // Add a default 'Choose' option
            sectionSelect.setChoices([{
              value: '',
              label: 'Choose',
              disabled: true,
              selected: true
            }]);

            // Add new options from the AJAX response
            $.each(data, function(key, value) {
              sectionSelect.setChoices([{
                value: value.id,
                label: value.name
              }]);
            });
          }
        });
      } else {
        // Clear the dropdown if no directorate is selected
        sectionSelect.clearStore();
        sectionSelect.clearChoices();
        sectionSelect.setChoices([{
          value: '',
          label: 'Choose',
          disabled: true,
          selected: true
        }]);
      }
    });
  });
</script>
