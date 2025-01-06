@extends('layouts.app')
@section('title', 'Karyawan')
@section('content')

@section('breadcrumb')
  <x-breadcrumb title="Karyawan" page="Karyawan" active="Karyawan" route="{{ route('employee.index') }}" />
@endsection

<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />


<section class="section">
  <div class="card">

    <div class="card-header">
      <div class="d-flex justify-content-between align-items-center ">
        <h5 class="fw-normal mb-0 text-body">Daftar Karyawan</h5>
        <a href="{{ route('employee.create') }}" class="btn btn-primary btn-md">
          <i class="bi bi-plus-lg"></i>
          Karyawan</a>
      </div>



      <div class="d-flex justify-content-between align-items-center my-2">
        <div>
          <label for="start-date" class="me-2">Start Date:</label>
          <input type="date" id="start-date" class="form-control form-control-sm" placeholder="Start Date"
            style="width: 150px; display: inline-block;">

          <label for="end-date" class="me-2">End Date:</label>
          <input type="date" id="end-date" class="form-control form-control-sm" placeholder="End Date"
            style="width: 150px; display: inline-block;">

          <label for="employee-status" class="me-2">Status:</label>
          <select id="employee-status" class="form-select form-select-sm" style="width: 200px; display: inline-block;">
            <option value="">Semua</option>
            <option value="AKTIF">Aktif</option>
            <option value="NONAKTIF">Nonaktif</option>
          </select>

          <button id="filter-date" class="btn btn-primary btn-sm ms-2">Filter</button>
        </div>
        <a href="{{ route('employee.export', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}"
          class="btn btn-success btn-md" id="export-button">
          Export
        </a>
      </div>


      {{-- <div class="d-flex justify-content-between align-items-center my-2">
        <div class="d-flex gap-2">
          <div>
            Status:
            <select id="employee-status" class="form-select form-select-sm" style="width: 150px;">
              <option value="">Semua</option>
              <option value="AKTIF">Aktif</option>
              <option value="NONAKTIF">Nonaktif</option>
            </select>
          </div>
          Dari :
          <input type="date" id="start-date" class="form-control form-control-sm" placeholder="Start Date"
            style="width: 150px;">
          Sampai :
          <input type="date" id="end-date" class="form-control form-control-sm" placeholder="End Date"
            style="width: 150px;">
          <button id="filter-date" class="btn btn-primary btn-sm d-flex align-items-center">
            <i class="bi bi-funnel me-1"></i> Filter
          </button>
        </div>



        <a href="{{ route('employee.export', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}"
          class="btn btn-success btn-md d-flex align-items-center">
          Export
        </a>
      </div> --}}

    </div>

    <div class="card-body">

      <table class="table table-striped" id="table-employee" style="font-size: 85%">
        <thead>
          <tr>
            <th>#</th>
            <th></th>
            <th>NIK</th>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Divisi</th>
            <th>Kategori Karyawan</th>
            <th>Status</th>
            <th></th>
          </tr>
        </thead>
        <tbody>

        </tbody>
      </table>
    </div>

  </div>
</section>

@push('after-script')
  {{-- <script>
    jQuery(document).ready(function($) {
      $('#table-employee').DataTable({
        processing: true,
        serverSide: true,
        ordering: true,
        pageLength: 10, // Show all records by default
        lengthMenu: [
          [10, 25, 50, 100, -1],
          [10, 25, 50, 100, 'All']
        ], // Add 'All' option to the length menu
        ajax: {
          url: "{{ route('employee.index') }}",
        },
        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false,
            width: '5%',
          },
          {
            data: 'photo',
            name: 'photo',
          },
          {
            data: 'nik',
            name: 'nik',
          },
          {
            data: 'name',
            name: 'name',
          },
          {
            data: 'employeeCategory',
            name: 'employeeCategory',
            orderable: false,
            searchable: false,
          },
          {
            data: 'position',
            name: 'position',
          },
          {
            data: 'division',
            name: 'division',
          },
          {
            data: 'is_verified',
            name: 'is_verified',
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
      const table = $('#table-employee').DataTable({
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
            d.start_date = $('#start-date').val();
            d.end_date = $('#end-date').val();
            d.employee_status = $('#employee-status').val();
          }
        },
        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false,
            width: '5%'
          },
          {
            data: 'photo',
            name: 'photo'
          },
          {
            data: 'nik',
            name: 'nik'
          },
          {
            data: 'name_employee',
            name: 'name',
            // render: function(data, type, row) {
            //   return `${data.name}<br><small>${data.position.name}</small>`;
            // }
          },


          {
            data: 'position.name',
            name: 'position.name',
            // orderable: false,
          },
          {
            data: 'position.division.name',
            name: 'position.division.name',
            // orderable: false,
          },
          {
            data: 'employeeCategory',
            name: 'employeeCategory.name',
            // orderable: false,
            // searchable: false
          },
          {
            data: 'is_verified',
            name: 'is_verified'
          },
          {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false,
            className: 'no-print'
          }
        ],
        columnDefs: [{
          className: 'text-center',
          targets: '_all'
        }]
      });

      // Reload table on filter button click
      $('#filter-date').on('click', function() {
        table.ajax.reload();

        // Update export button URL
        const startDate = $('#start-date').val();
        const endDate = $('#end-date').val();
        const employeeStatus = $('#employee-status').val();

        let exportUrl = "{{ route('employee.export') }}";
        const params = [];

        if (startDate) params.push(`start_date=${startDate}`);
        if (endDate) params.push(`end_date=${endDate}`);
        if (employeeStatus) params.push(`employee_status=${employeeStatus}`);

        if (params.length) exportUrl += `?${params.join('&')}`;

        $('.btn-success').attr('href', exportUrl);
      });
    });
  </script>
@endpush


<style>
  .fixed-frame {
    width: 100px;
    height: 150px;
    border: 0.5px solid #bcbbbb;
    /* Frame border */
    border-radius: 10px;
    /* Rounded corners */
    padding: 2px;
    /* Padding inside the frame */
    box-sizing: border-box;
    /* Ensures border and padding are included in the 100px size */
    /* box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5); */
    /* Optional shadow effect */
    overflow: hidden;
    /* Prevents image overflow */
    display: flex;
    /* Centers the image */
    justify-content: center;
    align-items: center;
  }

  .framed-image {
    max-width: 100%;
    max-height: 100%;
    object-fit: cover;
    /* Ensures the image covers the frame while maintaining proportions */
    border-radius: 7px;
    /* Optional: ensure the image corners match the frame */
  }
</style>

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

<script>
  Fancybox.bind("[data-fancybox]", {
    // Your custom options
  });
</script>

{{-- @include('pages.recruitment.employee.modal-create') --}}

@endsection


{{-- 
- carreer after cmnp and before, change at print personal data
--}}
