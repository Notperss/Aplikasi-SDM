@extends('layouts.app')
@section('title', 'KPI')
@section('content')

@section('breadcrumb')
  <x-breadcrumb title="KPI" page="Karyawan" active="KPI" route="{{ route('employeeKpi.index') }}" />
@endsection

<div class="col-md-12 mt-4">
  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between align-items-center ">
        <h4 class="card-title">Data KPI</h4>
        <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
          data-bs-target="#modal-form-add-kpi">
          <i class="bi bi-plus-lg"></i>
          Add
        </button>
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
              <th>Tahun</th>
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
    $('#table-kpi').DataTable({
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
          data: 'year',
          name: 'year',
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
</script>
@endpush
