<!-- Modals add menu -->
<div id="modal-form-edit-department-{{ $department->id }}" class="modal fade" tabindex="-1"
  aria-labelledby="modal-form-edit-department-{{ $department->id }}-label" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('department.update', $department) }}" method="post">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-edit-department-{{ $department->id }}-label">
            Edit Data Department
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>

        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-11"> <!-- Make form smaller with col-md-6 and center it -->

              {{-- <div class="mb-2">
                <label class="form-label" for="directorate_{{ $department->id }}">Direktorat</label>
                <select id="directorate_{{ $department->id }}" name="directorate_id"
                  class="form-control @error('directorate_id') is-invalid @enderror" required>
                  <option value="" disabled>Choose</option>
                  @foreach ($directorates as $directorate)
                    <option value="{{ $directorate->id }}"
                      {{ $directorate->id == $department->division->directorate_id ? 'selected' : '' }}>
                      {{ $directorate->name }}</option>
                  @endforeach
                </select>
                @error('directorate_id')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label class="form-label" for="division_{{ $department->id }}">Divisi</label>
                <select id="division_{{ $department->id }}" name="division_id"
                  class="form-control @error('division_id') is-invalid @enderror" required>
                  <option value="" disabled>Choose</option>
                </select>
                @error('division_id')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div> --}}

              <div class="mb-2">
                <label class="form-label" for="directorate_{{ $department->id }}">Direktorat</label>
                <select id="directorate_{{ $department->id }}" name="directorate_id"
                  class="form-control @error('directorate_id') is-invalid @enderror" required>
                  <option value="" disabled>Choose</option>
                  @foreach ($directorates as $directorate)
                    <option value="{{ $directorate->id }}"
                      {{ $directorate->id == $department->division->directorate_id ? 'selected' : '' }}>
                      {{ $directorate->name }}</option>
                  @endforeach
                </select>
                @error('directorate_id')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label class="form-label" for="division_{{ $department->id }}">Divisi</label>
                <select id="division_{{ $department->id }}" name="division_id"
                  class="form-control @error('division_id') is-invalid @enderror" required>
                  <option value="" disabled>Choose</option>
                  @foreach ($divisions->where('directorate_id', $department->division->directorate_id) as $division)
                    <option value="{{ $division->id }}"
                      {{ $division->id == $department->division_id ? 'selected' : '' }}>
                      {{ $division->name }}</option>
                  @endforeach
                  {{-- The options will be populated dynamically using JavaScript --}}
                </select>
                @error('division_id')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="my-2">
                <label class="form-label" for="name">Department</label>
                <input id="name" name="name" value="{{ $department->name }}"
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
    @foreach ($departments as $department)
      // Initialize Choices.js for the division select
      const divisionSelect_{{ $department->id }} = new Choices('#division_{{ $department->id }}', {
        searchEnabled: true,
        shouldSort: false
      });

      // Handle the change event for the directorate dropdown
      $('#directorate_{{ $department->id }}').change(function() {
        var directorateId = $(this).val();

        // Clear existing choices in the division dropdown
        divisionSelect_{{ $department->id }}.clearStore();
        divisionSelect_{{ $department->id }}.clearChoices();

        // Add a default 'Choose' option
        divisionSelect_{{ $department->id }}.setChoices([{
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
                // Check if this division is the current division for the department
                const isSelected = division.id == {{ $department->division_id }} ? true : false;

                divisionSelect_{{ $department->id }}.setChoices([{
                  value: division.id,
                  label: division.name,
                  selected: isSelected // Mark as selected if it matches the department's division_id
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
