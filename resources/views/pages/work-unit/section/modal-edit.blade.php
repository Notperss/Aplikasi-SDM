<!-- Modals add menu -->
<div id="modal-form-edit-section-{{ $section->id }}" class="modal fade" tabindex="-1"
  aria-labelledby="modal-form-edit-section-{{ $section->id }}-label" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('section.update', $section) }}" method="post">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-edit-section-{{ $section->id }}-label">
            Edit Data Section
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>

        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-11"> <!-- Make form smaller with col-md-6 and center it -->

              {{-- <div class="mb-2">
                <label class="form-label" for="directorate_{{ $section->id }}">Direktorat</label>
                <select id="directorate_{{ $section->id }}" name="directorate_id"
                  class="form-control @error('directorate_id') is-invalid @enderror" required>
                  <option value="" disabled>Choose</option>
                  @foreach ($directorates as $directorate)
                    <option value="{{ $directorate->id }}"
                      {{ $directorate->id == $section->division->directorate_id ? 'selected' : '' }}>
                      {{ $directorate->name }}</option>
                  @endforeach
                </select>
                @error('directorate_id')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label class="form-label" for="division_{{ $section->id }}">Divisi</label>
                <select id="division_{{ $section->id }}" name="division_id"
                  class="form-control @error('division_id') is-invalid @enderror" required>
                  <option value="" disabled>Choose</option>
                </select>
                @error('division_id')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div> --}}

              <div class="mb-2">
                <label class="form-label" for="directorate_{{ $section->id }}">Direktorat</label>
                <select id="directorate_{{ $section->id }}" name="directorate_id"
                  class="form-control @error('directorate_id') is-invalid @enderror" required>
                  <option value="" disabled>Choose</option>
                  @foreach ($directorates as $directorate)
                    <option value="{{ $directorate->id }}"
                      {{ $directorate->id == $section->department->division->directorate_id ? 'selected' : '' }}>
                      {{ $directorate->name }}</option>
                  @endforeach
                </select>
                @error('directorate_id')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label class="form-label" for="division_{{ $section->id }}">Divisi</label>
                <select id="division_{{ $section->id }}" name="division_id"
                  class="form-control @error('division_id') is-invalid @enderror" required>
                  <option value="" disabled>Choose</option>
                  @foreach ($divisions->where('directorate_id', $section->department->division->directorate_id) as $division)
                    <option value="{{ $division->id }}"
                      {{ $division->id == $section->department->division_id ? 'selected' : '' }}>
                      {{ $division->name }}</option>
                  @endforeach
                  {{-- The options will be populated dynamically using JavaScript --}}
                </select>
                @error('division_id')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label class="form-label" for="department_{{ $section->id }}">Department</label>
                <select id="department_{{ $section->id }}" name="department_id"
                  class="form-control @error('department_id') is-invalid @enderror" required>
                  <option value="" disabled>Choose</option>
                  @foreach ($departments->where('division_id', $section->department->division_id) as $department)
                    <option value="{{ $department->id }}"
                      {{ $department->id == $section->department_id ? 'selected' : '' }}>
                      {{ $department->name }}</option>
                  @endforeach
                  {{-- The options will be populated dynamically using JavaScript --}}
                </select>
                @error('department_id')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="my-2">
                <label class="form-label" for="name">Section</label>
                <input id="name" name="name" value="{{ $section->name }}"
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

<script>
  $(document).ready(function() {
    @foreach ($sections as $section)
      // Initialize Choices.js for the division select
      const divisionSelect_{{ $section->id }} = new Choices('#division_{{ $section->id }}', {
        searchEnabled: true,
        shouldSort: false
      });

      // Handle the change event for the directorate dropdown
      $('#directorate_{{ $section->id }}').change(function() {
        var directorateId = $(this).val();

        // Clear existing choices in the division dropdown
        divisionSelect_{{ $section->id }}.clearStore();
        divisionSelect_{{ $section->id }}.clearChoices();

        // Add a default 'Choose' option
        divisionSelect_{{ $section->id }}.setChoices([{
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
                // Check if this division is the current division for the section
                const isSelected = division.id == {{ $section->department->division_id }} ? true :
                  false;

                divisionSelect_{{ $section->id }}.setChoices([{
                  value: division.id,
                  label: division.name,
                  selected: isSelected // Mark as selected if it matches the section's division_id
                }], 'value', 'label', false); // Append new choices
              });
            },
            error: function(xhr, status, error) {
              console.error('Error fetching divisions:', error);
            }
          });
        }
      });
    @endforeach
  });
</script>

<script>
  $(document).ready(function() {
    @foreach ($sections as $section)
      // Initialize Choices.js for the department select
      const departmentSelect_{{ $section->id }} = new Choices('#department_{{ $section->id }}', {
        searchEnabled: true,
        shouldSort: false
      });

      // Handle the change event for the division dropdown
      $('#division_{{ $section->id }}').change(function() {
        var divisionId = $(this).val();

        // Clear existing choices in the department dropdown
        departmentSelect_{{ $section->id }}.clearStore();
        departmentSelect_{{ $section->id }}.clearChoices();

        // Add a default 'Choose' option
        departmentSelect_{{ $section->id }}.setChoices([{
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
                // Check if this department is the current department for the section
                const isSelected = department.id == {{ $section->department_id }} ?
                  true :
                  false;

                departmentSelect_{{ $section->id }}.setChoices([{
                  value: department.id,
                  label: department.name,
                  selected: isSelected // Mark as selected if it matches the section's department_id
                }], 'value', 'label', false); // Append new choices
              });
            },
            error: function(xhr, status, error) {
              console.error('Error fetching departments:', error);
            }
          });
        }
      });
    @endforeach
  });
</script>
