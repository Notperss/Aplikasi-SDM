@extends('layouts.app')
@section('title', 'Penghargaan')
@section('content')

@section('breadcrumb')
  <x-breadcrumb title="Penghargaan" page="Karyawan" active="Penghargaan" route="{{ route('employeeAward.index') }}" />
@endsection

<div class="col-md-12 mt-4">
  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between align-items-center ">
        <h4 class="card-title">Data Penghargaan</h4>
        <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
          data-bs-target="#modal-form-add-award">
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
        <a href="{{ route('employeeAward.export', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}"
          class="btn btn-success btn-md" id="export-button">
          Export
        </a>
      </div>

    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped" id="table-award" style="font-size: 85%; width: 100%">
          <thead>
            <tr>
              <th>#</th>
              <th>NIK</th>
              <th>Nama Karyawan</th>
              <th>Nama Penghargaan</th>
              <th>Tgl Penghargaan</th>
              <th>File</th>
              <th style="width: 13%"></th>
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

@endsection

@include('pages.employee.award.modal-create')

<script>
  function deleteAward(getId) {
    Swal.fire({
      title: 'Are you sure?',
      text: 'You won\'t be able to revert this!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        // If the user clicks "Yes, delete it!", submit the corresponding form
        document.getElementById('deleteAwardForm_' + getId).submit();
      }
    });
  }
</script>

@push('after-script')
<script>
  jQuery(document).ready(function($) {
    const table = $('#table-award').DataTable({
      processing: true,
      serverSide: true,
      ordering: true,
      pageLength: 10, // Show all records by default
      lengthMenu: [
        [10, 25, 50, 100, -1],
        [10, 25, 50, 100, 'All']
      ], // Add 'All' option to the length menu
      ajax: {
        url: "{{ route('employeeAward.index') }}",
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
        {
          data: 'name_award',
          name: 'name_award',
        },
        {
          data: 'date_award',
          name: 'date_award',
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

    // Reload table on filter button click
    $('#filter-date').on('click', function() {
      table.ajax.reload();

      // Update export button URL
      const startDate = $('#start-date').val();
      const endDate = $('#end-date').val();
      let exportUrl = "{{ route('employeeAward.export') }}";
      const params = [];

      if (startDate) params.push(`start_date=${startDate}`);
      if (endDate) params.push(`end_date=${endDate}`);

      if (params.length) exportUrl += `?${params.join('&')}`;

      $('#export-button').attr('href', exportUrl);
    });
  });
</script>
@endpush
