@extends('layouts.app')
@section('title', 'Penilaian Kerja')
@section('content')

@section('breadcrumb')
  <x-breadcrumb title="Penilaian Kerja" page="Karyawan" active="Penilaian Kerja" route="{{ route('employeeKpi.index') }}" />
@endsection

<div class="col-md-12 mt-4">
  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between align-items-center ">
        <h4 class="card-title">Data Penilaian Kerja</h4>
        {{-- <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
          data-bs-target="#modal-form-add-kpi">
          <i class="bi bi-plus-lg"></i>
          Add
        </button> --}}
      </div>

      <div class="d-flex justify-content-between align-items-center my-2">
        <div>
          <label for="start-date" class="me-2">Dari:</label>
          <input type="date" id="start-date" class="form-control form-control-sm" placeholder="Start Date"
            style="width: 150px; display: inline-block;">

          <label for="end-date" class="me-2">Sampai:</label>
          <input type="date" id="end-date" class="form-control form-control-sm" placeholder="End Date"
            style="width: 150px; display: inline-block;">

          <button id="filter-date" class="btn btn-primary btn-sm ms-2">Filter</button>
        </div>
        <a href="{{ route('employeeKpi.export', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}"
          class="btn btn-success btn-md" id="export-button">
          Export
        </a>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped" id="table-kpi" style="font-size: 85%; width: 100%">
          <thead>
            <tr>
              <th>#</th>
              <th>NIK</th>
              <th>Nama Karyawan</th>
              <th>Nomor Kontrak</th>
              <th>Tanggal PK</th>
              <th>Nilai</th>
              <th>Rekomendasi Kontrak</th>
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

@include('pages.employee.kpi.modal-create')

<script>
  function deleteKpi(getId) {
    Swal.fire({
      title: 'Are you sure?',
      text: 'You won\'t be able to revert this!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        // If the user clicks "Yes, delete it!", submit the corresponding form
        document.getElementById('deleteKpiForm_' + getId).submit();
      }
    });
  }
</script>

@push('after-script')
<script>
  jQuery(document).ready(function($) {
    const table = $('#table-kpi').DataTable({
      processing: true,
      serverSide: true,
      ordering: true,
      pageLength: 10, // Show all records by default
      lengthMenu: [
        [10, 25, 50, 100, -1],
        [10, 25, 50, 100, 'All']
      ], // Add 'All' option to the length menu
      ajax: {
        url: "{{ route('employeeKpi.index') }}",
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
          orderable: false,
        },
        {
          data: 'employee.name',
          name: 'employee.name',
          orderable: false,
        },
        {
          data: 'contract.contract_number',
          name: 'contract.contract_number',
        },
        {
          data: 'kpi_date',
          name: 'kpi_date',
        },
        {
          data: 'grade',
          name: 'grade',
        },
        {
          data: 'contract_recommendation',
          name: 'contract_recommendation',
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
      let exportUrl = "{{ route('employeeKpi.export') }}";
      const params = [];

      if (startDate) params.push(`start_date=${startDate}`);
      if (endDate) params.push(`end_date=${endDate}`);

      if (params.length) exportUrl += `?${params.join('&')}`;

      $('#export-button').attr('href', exportUrl);
    });


  });
</script>
@endpush
