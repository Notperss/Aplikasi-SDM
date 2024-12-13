@extends('layouts.app')
@section('title', 'Seminar/Pelatihan')
@section('content')

@section('breadcrumb')
  <x-breadcrumb title="Seminar/Pelatihan" page="Karyawan" active="Seminar/Pelatihan" route="{{ route('employee.index') }}" />
@endsection

<div class="col-md-12 mt-4">
  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between align-items-center ">
        <h4 class="card-title">Data Seminar/Pelatihan</h4>
        <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
          data-bs-target="#modal-form-add-training-attended">
          <i class="bi bi-plus-lg"></i>
          Add
        </button>
      </div>

      <div class="d-flex justify-content-between align-items-center my-2">
        <div>
          <label for="start-date" class="me-2">Start Date:</label>
          <input type="date" id="start-date" class="form-control form-control-sm" placeholder="Start Date"
            style="width: 150px; display: inline-block;">

          <label for="end-date" class="me-2">End Date:</label>
          <input type="date" id="end-date" class="form-control form-control-sm" placeholder="End Date"
            style="width: 150px; display: inline-block;">

          <button id="filter-date" class="btn btn-primary btn-sm ms-2">Filter</button>
        </div>
        <a href="{{ route('employeeTrainingAttended.export', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}"
          class="btn btn-success btn-md" id="export-button">
          Export
        </a>
      </div>

    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped" id="table-training" style="font-size: 85%; width: 100%">
          <thead>
            <tr>
              <th>#</th>
              <th>NIK</th>
              <th>Nama Karyawan</th>
              <th>Pelatihan/Seminar</th>
              <th>Penyelenggara</th>
              <th>Tempat/Kota</th>
              <th>Tanggal</th>
              <th>File</th>
              <th style="width: 13%"></th>
            </tr>
          </thead>
          <tbody>
            {{-- @forelse ($trainingAttendeds as $employeeTrainingAttended)
              <tr>
                <td class="text-bold-500">{{ $loop->iteration }}</td>
                <td class="text-bold-500">{{ $employeeTrainingAttended->employee->nik }}</td>
                <td class="text-bold-500">{{ $employeeTrainingAttended->employee->name }}</td>
                <td class="text-bold-500">{{ $employeeTrainingAttended->training_name }}</td>
                <td class="text-bold-500">{{ $employeeTrainingAttended->organizer_name }}</td>
                <td class="text-bold-500">{{ $employeeTrainingAttended->city }}</td>
                <td class="text-bold-500">{{ $employeeTrainingAttended->year }}</td>
                <td class="text-bold-500">
                  @if ($employeeTrainingAttended->file_sertifikat)
                    <a href="{{ Storage::url($employeeTrainingAttended->file_sertifikat) }}" target="_blank">
                      Lihat
                    </a>
                  @else
                    <span>-</span>
                  @endif
                </td>
                <td>
                  <div class="demo-inline-spacing">

                    <a data-bs-toggle="modal"
                      data-bs-target="#modal-form-edit-training-attended-{{ $employeeTrainingAttended->id }}"
                      class="btn btn-sm btn-icon btn-secondary text-white">
                      <i class="bi bi-pencil-square"></i>
                    </a>

                    @include('pages.employee.personal-data.form.training-attended.modal-edit')

                    <button class="btn btn-sm btn-light-danger mx-2"
                      onclick="deleteTrainingAttend('{{ $employeeTrainingAttended->id }}')"><i
                        class="bi bi-trash"></i></button>

                    <form id="deleteTrainingAttendForm_{{ $employeeTrainingAttended->id }}"
                      action="{{ route('employeeTrainingAttended.destroy', $employeeTrainingAttended->id) }}"
                      method="POST">
                      @method('DELETE')
                      @csrf
                    </form>


                  </div>
                </td>
              </tr>
            @empty
              <td class="text-bold-500 text-center" colspan="7">No data available in table</td>
            @endforelse --}}
          </tbody>
        </table>

      </div>
    </div>
  </div>
</div>
</div>

@endsection

@include('pages.employee.training-attended.modal-create')

<script>
  function deleteTrainingAttend(getId) {
    Swal.fire({
      title: 'Are you sure?',
      text: 'You won\'t be able to revert this!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        // If the user clicks "Yes, delete it!", submit the corresponding form
        document.getElementById('deleteTrainingAttendForm_' + getId).submit();
      }
    });
  }
</script>

@push('after-script')
{{-- <script>
  jQuery(document).ready(function($) {
    $('#table-training').DataTable({
      processing: true,
      serverSide: true,
      ordering: true,
      pageLength: 10, // Show all records by default
      lengthMenu: [
        [10, 25, 50, 100, -1],
        [10, 25, 50, 100, 'All']
      ], // Add 'All' option to the length menu
      ajax: {
        url: "{{ route('employeeTrainingAttended.index') }}",
      },
      columns: [{
          data: 'DT_RowIndex',
          name: 'DT_RowIndex',
          orderable: false,
          searchable: false,
          width: '5%',
        },
        {
          data: 'employee.nik',
          name: 'employee.nik',
        },
        {
          data: 'employee.name',
          name: 'employee.name',
        },
        // {
        //   data: 'employeeCategory',
        //   name: 'employeeCategory',
        //   orderable: false,
        //   searchable: false,
        // },
        {
          data: 'training_name',
          name: 'training_name',
        },
        {
          data: 'organizer_name',
          name: 'organizer_name',
        },
        {
          data: 'city',
          name: 'city',
        },
        {
          data: 'training_date',
          name: 'training_date',
        },
        {
          data: 'file',
          name: 'file',
        },
        {
          data: 'action',
          name: 'action',
          orderable: false,
          searchable: false,
          className: 'no-print' // Add this class to exclude the column from printing
        },
      ],
      columnDefs: [{
        className: 'text-center',
        targets: '_all'
      }, ],
    });
  });
</script> --}}

<script>
  jQuery(document).ready(function($) {
    const table = $('#table-training').DataTable({
      processing: true,
      serverSide: true,
      ordering: true,
      pageLength: 10,
      lengthMenu: [
        [10, 25, 50, 100, -1],
        [10, 25, 50, 100, 'All']
      ],
      ajax: {
        url: "{{ route('employeeTrainingAttended.index') }}",
        data: function(d) {
          d.start_date = $('#start-date').val();
          d.end_date = $('#end-date').val();
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
          data: 'employee.nik',
          name: 'employee.nik',
          orderable: false,
          searchable: false,
        },
        {
          data: 'employee.name',
          name: 'employee.name',
          orderable: false,
          searchable: false,
        },
        {
          data: 'training_name',
          name: 'training_name'
        },
        {
          data: 'organizer_name',
          name: 'organizer_name'
        },
        {
          data: 'city',
          name: 'city'
        },
        {
          data: 'training_date',
          name: 'training_date'
        },
        {
          data: 'file',
          name: 'file',
          orderable: false,
          searchable: false,
        },
        {
          data: 'action',
          name: 'action',
          orderable: false,
          searchable: false,
          className: 'no-print'
        },
      ],
      columnDefs: [{
        className: 'text-center',
        targets: '_all'
      }],
    });

    // Reload table on filter button click
    $('#filter-date').on('click', function() {
      table.ajax.reload();

      // Update export button URL
      const startDate = $('#start-date').val();
      const endDate = $('#end-date').val();
      let exportUrl = "{{ route('employeeTrainingAttended.export') }}";
      const params = [];

      if (startDate) params.push(`start_date=${startDate}`);
      if (endDate) params.push(`end_date=${endDate}`);

      if (params.length) exportUrl += `?${params.join('&')}`;

      $('#export-button').attr('href', exportUrl);
    });
  });
</script>
@endpush
