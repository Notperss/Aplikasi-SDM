@extends('layouts.app')
@section('title', 'Seminar/Pelatihan')
@section('content')

@section('breadcrumb')
  <x-breadcrumb title="Edit Seminar/Pelatihan" page="Karyawan" active="Seminar/Pelatihan"
    route="{{ route('employeeTrainingAttended.index') }}" />
@endsection

<section class="section">
  <form action="{{ route('employeeTrainingAttended.update', $employeeTrainingAttended) }}" method="post"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="card">
      <div class="card-header">
      </div>
      <div class="card-body">
        <div class="row justify-content-center">
          <div class="col-md-11"> <!-- Make form smaller with col-md-6 and center it -->

            <div class="mb-2">
              <label class="form-label" for="training_name">Nama Seminar/Pelatihan</label>
              <input id="training_name" name="training_name" value="{{ old('training_name') }}"
                class="form-control @error('training_name') is-invalid @enderror" required>
              @error('training_name')
                <a style="color: red"><small>{{ $message }}</small></a>
              @enderror
            </div>

            <div class="mb-2">
              <label class="form-label" for="organizer_name">Penyelenggara</label>
              <input id="organizer_name" name="organizer_name" value="{{ old('organizer_name') }}"
                class="form-control @error('organizer_name') is-invalid @enderror" required>
              @error('organizer_name')
                <a style="color: red"><small>{{ $message }}</small></a>
              @enderror
            </div>

            <div class="row mb-2">
              <div class="col-md-6">
                <label class="form-label" for="city">Tempat/Kota</label>
                <input id="city" value="{{ old('city') }}" name="city"
                  class="form-control @error('city') is-invalid @enderror">
                @error('city')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <label class="form-label" for="start_date">Tanggal Mulai</label>
                <input type="date" id="start_date" name="start_date" maxlength="4" value="{{ old('start_date') }}"
                  class="form-control @error('start_date') is-invalid @enderror">
                @error('start_date')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>
              <div class="col-md-6">
                <label class="form-label" for="end_date">Tanggal Akhir</label>
                <input type="date" id="end_date" name="end_date" maxlength="4" value="{{ old('end_date') }}"
                  class="form-control @error('end_date') is-invalid @enderror">
                @error('end_date')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>
            </div>

            <div class="row mt-3">
              <div class="col-md-4 d-flex align-items-end">
                <a class="btn btn-primary" onclick="openMyModalAdd()">
                  <i class="bi bi-plus-lg"></i> Karyawan
                </a>
              </div>
            </div>

            <div class="my-2">
              <label class="form-label">Karyawan Mengikuti Training:</label>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Divisi</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody id="employee-table-body">
                  <!-- Selected employees will be appended here dynamically -->
                </tbody>
              </table>
              <p id="employee-empty-state" class="text-muted">Belum ada karyawan yang ditambahkan.</p>

              <input type="hidden" name="employees" id="employeesInput">
            </div>

          </div>
        </div>
        <div class="col-12 d-flex justify-content-end mt-4">
          <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
          <a href="{{ route('employeeTrainingAttended.index') }}" class="btn btn-light-secondary me-1 mb-1">Kembali</a>
        </div>
      </div>
    </div>

  </form>

</section>
@endsection

<!-- Add your modal structure here -->
<div class="modal fade" id="employeeAddModal" tabindex="-1" aria-labelledby="employeeModalLabel" aria-hidden="true"
style="background-color: #000">
<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="employeeModalLabel">Daftar Karyawan</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="table-employee" style="width: 100%">
          <thead>
            <tr>
              <th>#</th>
              <th>NIK</th>
              <th>Nama</th>
              <th>Jabatan</th>
              <th>Divisi</th>
              <th></th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>

<style>
#employee-list .d-flex {
  align-items: flex-start !important;
  /* Aligns content to the left */
}
</style>

<script>
  function openMyModalAdd() {
    const modalId = 'employeeAddModal';
    const myModal = new bootstrap.Modal(document.getElementById(modalId), {});
    myModal.show();
  }
</script>

@push('after-script')
<script>
  jQuery(document).ready(function($) {
    const employeeTable = $('#table-employee').DataTable({
      processing: true,
      serverSide: true,
      ordering: true,
      pageLength: 10,
      lengthMenu: [
        [10, 25, 50, 100, -1],
        [10, 25, 50, 100, 'All']
      ],
      ajax: {
        url: "{{ route('employee.index') }}",
        data: function(d) {
          d.employee_status = 'AKTIF';
        },
      },
      columns: [{
          data: 'DT_RowIndex',
          name: 'DT_RowIndex',
          orderable: false,
          searchable: false,
          width: '5%'
        },
        {
          data: 'nik',
          name: 'nik'
        },
        {
          data: 'name',
          name: 'name'
        },
        {
          data: 'position.name',
          name: 'position.name',
          orderable: false,
        },
        {
          data: 'position.division.name',
          name: 'position.division.name',
          orderable: false,
        },
        {
          data: null,
          orderable: false,
          searchable: false,
          render: function(data) {
            return `
                            <button class="btn btn-sm btn-primary select-employee"
                                    data-id="${data.id}"
                                    data-nik="${data.nik}"
                                    data-name="${data.name}"
                                    data-position="${data.position.name}"
                                    data-division="${data.position.division.name}">
                                Pilih
                            </button>
                        `;
          },
        },
      ],
      columnDefs: [{
        className: 'text-center',
        targets: '_all'
      }],
    });

    // Attach event listener to dynamically loaded "Pilih" buttons
    $('#table-employee').on('click', '.select-employee', function() {
      const employeeId = $(this).data('id');
      const employeeName = $(this).data('name');
      const employeeNik = $(this).data('nik');
      const employeePosition = $(this).data('position');
      const employeeDivision = $(this).data('division');

      if (isEmployeeAlreadyAdded(employeeId)) {
        debounceAlert(employeeId);
        return;
      }

      const employeeTableBody = $('#employee-table-body');

      // Append the employee to the table
      const row = `
                <tr data-id="${employeeId}">
                    <td>${employeeNik}</td>
                    <td>${employeeName}</td>
                    <td>${employeePosition}</td>
                    <td>${employeeDivision}</td>
                    <td>
                        <a class="btn btn-sm btn-danger remove-employee">Hapus</a>
                    </td>
                </tr>
            `;
      employeeTableBody.append(row);
      updateEmptyState();

      $('#employeeAddModal').modal('hide');
    });

    // Remove employee from the table
    $('#employee-table-body').on('click', '.remove-employee', function() {
      $(this).closest('tr').remove();
      updateEmptyState();
    });

    // Check if an employee has already been added
    function isEmployeeAlreadyAdded(employeeId) {
      return $('#employee-table-body').find(`tr[data-id="${employeeId}"]`).length > 0;
    }

    // Update the "empty state" message
    function updateEmptyState() {
      if ($('#employee-table-body tr').length === 0) {
        $('#employee-empty-state').removeClass('d-none');
      } else {
        $('#employee-empty-state').addClass('d-none');
      }
    }

    $('#selectedEmployeesForm').on('submit', function(event) {
      event.preventDefault();

      const employees = [];
      $('#employee-table-body tr').each(function() {
        const id = $(this).data('id');
        employees.push({
          id: id
        });
      });

      // Set the hidden input to the JSON string of employees
      $('#employeesInput').val(JSON.stringify(employees));

      // Now submit the form
      this.submit();
    });

  });
</script>
@endpush
