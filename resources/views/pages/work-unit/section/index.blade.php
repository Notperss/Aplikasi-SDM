@extends('layouts.app')
@section('title', 'Section')
@section('content')

@section('breadcrumb')
  <x-breadcrumb title="Section" page="Unit Kerja" active="Section" route="{{ route('section.index') }}" />
@endsection

<section class="section">
  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between align-items-center ">
        <h5 class="fw-normal mb-0 text-body">Daftar Section</h5>

        <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
          data-bs-target="#modal-form-add-section">
          <i class="bi bi-plus-lg"></i>
          Section
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
            <th>Departmen</th>
            <th>Section</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($sections as $section)
            <tr>
              <td class="text-center">{{ $loop->iteration }}</td>
              <td>{{ $section->department->division->directorate->name }}</td>
              <td>{{ $section->department->division->name }}</td>
              <td>{{ $section->department->name }}</td>
              <td>{{ $section->name }}</td>
              <td>

                <div class="d-flex justify-content-end mt-2">
                  <a data-bs-toggle="modal" data-bs-target="#modal-form-edit-section-{{ $section->id }}"
                    class="btn btn-icon btn-secondary text-white">
                    <i class="bi bi-pencil-square"></i>
                  </a>
                  @include('pages.work-unit.section.modal-edit')

                  <button class="btn btn-light-danger mx-2" onclick="showSweetAlert('{{ $section->id }}')">
                    <i class="bi bi-trash"></i>
                  </button>

                  <form id="deleteForm_{{ $section->id }}" action="{{ route('section.destroy', $section->id) }}"
                    method="POST">
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

@include('pages.work-unit.section.modal-create')

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
