@extends('layouts.app')
@section('title', 'Department')
@section('content')

@section('breadcrumb')
  <x-breadcrumb title="Department" page="Unit Kerja" active="Department" route="{{ route('department.index') }}" />
@endsection

<section class="section">
  <section class="section">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between align-items-center ">
          <h5 class="fw-normal mb-0 text-body">Daftar Department</h5>

          <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
            data-bs-target="#modal-form-add-department">
            <i class="bi bi-plus-lg"></i>
            Department
          </button>

        </div>
      </div>
      <div class="card-body">
        <table class="table table-striped" id="table1" style="font-size: 85%">
          <thead>
            <tr>
              <th>#</th>
              <th>Direktorat</th>
              <th>Divisi</th>
              <th>Department</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($departments as $department)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $department->division->directorate->name }}</td>
                <td>{{ $department->division->name }}</td>
                <td>{{ $department->name }}</td>
                <td>

                  <div class="d-flex justify-content-end mt-2">
                    <a data-bs-toggle="modal" data-bs-target="#modal-form-edit-department-{{ $department->id }}"
                      class="btn btn-icon btn-secondary text-white">
                      <i class="bi bi-pencil-square"></i>
                    </a>
                    @include('pages.work-unit.department.modal-edit')

                    <button class="btn btn-light-danger mx-2" onclick="showSweetAlert('{{ $department->id }}')">
                      <i class="bi bi-trash"></i>
                    </button>

                    <form id="deleteForm_{{ $department->id }}"
                      action="{{ route('department.destroy', $department->id) }}" method="POST">
                      @method('DELETE')
                      @csrf
                    </form>
                  </div>

                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </section>
  <script>
    function showSweetAlert(getId) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          // If the user clicks "Yes, delete it!", submit the corresponding form
          document.getElementById('deleteForm_' + getId).submit();
        }
      });
    }
  </script>

  @include('pages.work-unit.department.modal-create')

  {{-- <script>
    $(document).ready(function() {
      $('#directorate_id').change(function() {
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
              $('#division_id').empty();
              $('#division_id').append('<option value="" selected disabled>Choose</option>');
              $.each(data, function(key, value) {
                $('#division_id').append('<option value="' + value.id + '">' + value.name +
                  '</option>');
              });
              // Manually reset the selected option in the division_id dropdown
              $('#division_id').val('').trigger('change');
            }
          });
        } else {
          $('#division_id').empty();
          $('#division_id').append('<option value="" selected disabled>Choose</option>');
        }
      });
    });
  </script> --}}

@endsection
