<!-- Modals add menu -->
<div id="modal-form-edit-position-{{ $position->id }}" class="modal fade" tabindex="-1"
  aria-labelledby="modal-form-edit-position-{{ $position->id }}-label" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('position.update', $position) }}" method="post">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-edit-position-{{ $position->id }}-label">
            Edit Data Jabatan
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>

        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-11"> <!-- Make form smaller with col-md-6 and center it -->

              <div class="row">
                <div class="col-md-6">
                  <div class="mb-2">
                    <label class="form-label" for="directorate_{{ $position->id }}">Direktorat</label>
                    <select id="directorate_{{ $position->id }}" name="directorate_id"
                      class="form-control @error('directorate_id') is-invalid @enderror" required>
                      <option value="" disabled>Choose</option>
                      @foreach ($directorates as $directorate)
                        <option value="{{ $directorate->id }}"
                          {{ $directorate->id == $position->directorate_id ? 'selected' : '' }}>
                          {{ $directorate->name }}</option>
                      @endforeach
                    </select>
                    @error('directorate_id')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>

                  <div class="mb-2">
                    <label class="form-label" for="division_{{ $position->id }}">Divisi</label>
                    <select id="division_{{ $position->id }}" name="division_id"
                      class="form-control @error('division_id') is-invalid @enderror">
                      <option value="" disabled>Choose</option>
                      @foreach ($divisions->where('directorate_id', $position->directorate_id) as $division)
                        <option value="{{ $division->id }}"
                          {{ $division->id == $position->division_id ? 'selected' : '' }}>
                          {{ $division->name }}</option>
                      @endforeach
                      {{-- The options will be populated dynamically using JavaScript --}}
                    </select>
                    @error('division_id')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>

                  <div class="mb-2">
                    <label class="form-label" for="department_{{ $position->id }}">Department</label>
                    <select id="department_{{ $position->id }}" name="department_id"
                      class="form-control @error('department_id') is-invalid @enderror">
                      <option value="" disabled>Choose</option>
                      @foreach ($departments->where('division_id', $position->division_id) as $department)
                        <option value="{{ $department->id }}"
                          {{ $department->id == $position->department_id ? 'selected' : '' }}>
                          {{ $department->name }}</option>
                      @endforeach
                      {{-- The options will be populated dynamically using JavaScript --}}
                    </select>
                    @error('department_id')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>

                  <div class="mb-2">
                    <label class="form-label" for="section_{{ $position->id }}">section</label>
                    <select id="section_{{ $position->id }}" name="section_id"
                      class="form-control @error('section_id') is-invalid @enderror">
                      <option value="" disabled>Choose</option>
                      @foreach ($sections->where('deparment_id', $position->deparment_id) as $section)
                        <option value="{{ $section->id }}"
                          {{ $section->id == $position->section_id ? 'selected' : '' }}>
                          {{ $section->name }}</option>
                      @endforeach
                      {{-- The options will be populated dynamically using JavaScript --}}
                    </select>
                    @error('department_id')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="my-2">
                    <label class="form-label" for="level_id">Level</label>
                    <select id="level_id" name="level_id" class="form-control @error('level_id') is-invalid @enderror"
                      required>
                      <option value="" disabled selected>Choose</option>
                      @foreach ($levels as $level)
                        <option value="{{ $level->id }}"
                          {{ old('level_id', $level->id) == $position->level_id ? 'selected' : '' }}>
                          {{ $level->name }}
                        </option>
                      @endforeach
                    </select>
                    @error('level_id')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>

                  <div class="mb-2">
                    <label class="form-label" for="name">Jabatan</label>
                    <input id="name" name="name" value="{{ $position->name }}"
                      class="form-control @error('name') is-invalid @enderror" required>
                    @error('name')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>

                  <div class="my-2">
                    <label class="form-label" for="description">Deskripsi</label>
                    <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror"
                      rows="5"> {{ old('description', $position->description) }} </textarea>
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


<script>
  $(document).ready(function() {
    @foreach ($positions as $position)
      // Initialize Choices.js for the division select
      const divisionSelect_{{ $position->id }} = new Choices('#division_{{ $position->id }}', {
        searchEnabled: true,
        shouldSort: false
      });

      // Handle the change event for the directorate dropdown
      $('#directorate_{{ $position->id }}').change(function() {
        var directorateId = $(this).val();

        // Clear existing choices in the division dropdown
        divisionSelect_{{ $position->id }}.clearStore();
        divisionSelect_{{ $position->id }}.clearChoices();

        // Add a default 'Choose' option
        divisionSelect_{{ $position->id }}.setChoices([{
          value: '',
          label: 'Choose',
          disabled: true,
          selected: true
        }]);

        if (directorateId) {
          $.ajax({
            url: "{{ route('getDivisions') }}",
            type: 'GET',
            dataType: 'json',
            data: {
              directorate_id: directorateId
            },
            success: function(data) {
              // Populate the division dropdown with the response data
              $.each(data, function(index, division) {
                // Check if this division is the current division for the position
                const isSelected = division.id == {{ $position->division_id ?? 'null' }} ? true :
                  false;

                divisionSelect_{{ $position->id }}.setChoices([{
                  value: division.id,
                  label: division.name,
                  selected: isSelected // Mark as selected if it matches the position's division_id
                }], 'value', 'label', false); // Append new choices
              });
            },
            error: function(xhr, status, error) {
              console.error('Error fetching divisions:', error);
            }
          });
        } else {
          // Clear the department dropdown and reset to the 'Choose' option
          divisionSelect_{{ $position->id }}.clearStore();
          divisionSelect_{{ $position->id }}.clearChoices();
        }
      });

      // If division_id is null on page load, reset the department dropdown to 'Choose'
      @if (is_null($position->division_id))
        divisionSelect_{{ $position->id }}.clearStore();
        divisionSelect_{{ $position->id }}.clearChoices();
      @endif
    @endforeach
  });
</script>

<script>
  $(document).ready(function() {
    @foreach ($positions as $position)
      // Initialize Choices.js for the department select
      const departmentSelect_{{ $position->id }} = new Choices('#department_{{ $position->id }}', {
        searchEnabled: true,
        shouldSort: false
      });

      // Handle the change event for the division dropdown
      $('#division_{{ $position->id }}').change(function() {
        var divisionId = $(this).val();

        // Clear existing choices in the department dropdown
        departmentSelect_{{ $position->id }}.clearStore();
        departmentSelect_{{ $position->id }}.clearChoices();

        // Add a default 'Choose' option
        departmentSelect_{{ $position->id }}.setChoices([{
          value: '',
          label: 'Choose',
          disabled: true,
          selected: true
        }]);

        if (divisionId) {
          $.ajax({
            url: "{{ route('getDepartments') }}",
            type: 'GET',
            dataType: 'json',
            data: {
              division_id: divisionId
            },
            success: function(data) {
              // Populate the department dropdown with the response data
              $.each(data, function(index, department) {
                // Check if this department is the current department for the position
                const isSelected = department.id == {{ $position->department_id ?? 'null' }} ?
                  true :
                  false;

                departmentSelect_{{ $position->id }}.setChoices([{
                  value: department.id,
                  label: department.name,
                  selected: isSelected // Mark as selected if it matches the position's department_id
                }], 'value', 'label', false); // Append new choices
              });
            },
            error: function(xhr, status, error) {
              console.error('Error fetching departments:', error);
            }
          });
        } else {
          // Clear the department dropdown and reset to the 'Choose' option
          departmentSelect_{{ $position->id }}.clearStore();
          departmentSelect_{{ $position->id }}.clearChoices([{
            value: '',
            label: 'Choose',
            disabled: true,
            selected: true
          }]);
        }
      });

      // If division_id is null on page load, reset the department dropdown to 'Choose'
      @if (is_null($position->department_id))
        departmentSelect_{{ $position->id }}.clearStore();
        departmentSelect_{{ $position->id }}.clearChoices([{
          value: '',
          label: 'Choose',
          disabled: true,
          selected: true
        }]);
      @endif
    @endforeach
  });
</script>

<script>
  $(document).ready(function() {
    @foreach ($positions as $position)
      // Initialize Choices.js for the department select
      const sectionSelect_{{ $position->id }} = new Choices('#section_{{ $position->id }}', {
        searchEnabled: true,
        shouldSort: false
      });

      // Handle the change event for the department dropdown
      $('#department_{{ $position->id }}').change(function() {
        var departmentId = $(this).val();

        // Clear existing choices in the section dropdown
        sectionSelect_{{ $position->id }}.clearStore();
        sectionSelect_{{ $position->id }}.clearChoices();

        // Add a default 'Choose' option
        sectionSelect_{{ $position->id }}.setChoices([{
          value: '',
          label: 'Choose',
          disabled: true,
          selected: true
        }]);

        if (departmentId) {
          $.ajax({
            url: "{{ route('getSections') }}",
            type: 'GET',
            dataType: 'json',
            data: {
              department_id: departmentId
            },
            success: function(data) {
              // Populate the section dropdown with the response data
              $.each(data, function(index, section) {
                // Check if this section is the current section for the position
                const isSelected = section.id == {{ $position->section_id ?? 'null' }} ?
                  true :
                  false;

                sectionSelect_{{ $position->id }}.setChoices([{
                  value: section.id,
                  label: section.name,
                  selected: isSelected // Mark as selected if it matches the position's section_id
                }], 'value', 'label', false); // Append new choices
              });
            },
            error: function(xhr, status, error) {
              console.error('Error fetching sections:', error);
            }
          });
        } else {
          // Clear the department dropdown and reset to the 'Choose' option
          sectionSelect_{{ $position->id }}.clearStore();
          sectionSelect_{{ $position->id }}.clearChoices([{
            value: '',
            label: 'Choose',
            disabled: true,
            selected: true
          }]);
        }
      });

      // If division_id is null on page load, reset the department dropdown to 'Choose'
      @if (is_null($position->department_id))
        sectionSelect_{{ $position->id }}.clearStore();
        sectionSelect_{{ $position->id }}.clearChoices([{
          value: '',
          label: 'Choose',
          disabled: true,
          selected: true
        }]);
      @endif
    @endforeach
  });
</script>