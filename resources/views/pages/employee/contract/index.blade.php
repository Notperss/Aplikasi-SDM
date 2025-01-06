@extends('layouts.app')
@section('title', 'Kontrak')
@section('content')

@section('breadcrumb')
  <x-breadcrumb title="Kontrak" page="Karyawan" active="Kontrak" route="{{ route('contract.index') }}" />
@endsection

<section class="section">
  <section class="section">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between align-items-center mb-2 ">
          <h5 class="fw-normal mb-0 text-body">Daftar Kontrak</h5>

          <!-- Button trigger for basic modal -->
          {{-- <button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal"
            data-bs-target="#import-contract">
            Import Kontrak
          </button> --}}

        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
          <div>
            <label for="start-date" class="me-2">Start Date:</label>
            <input type="date" id="start-date" class="form-control form-control-sm"
              style="width: 150px; display: inline-block;">

            <label for="end-date" class="me-2">End Date:</label>
            <input type="date" id="end-date" class="form-control form-control-sm"
              style="width: 150px; display: inline-block;">

            <select id="filter-type" class="form-select form-select-sm" style="width: 200px; display: inline-block;">
              <option value="">All Contracts</option>
              <option value="before_end">Before Contract End</option>
              <option value="incoming_end">Incoming Contract End</option>
              <option value="ended">Contract Ended</option>
            </select>

            <button id="filter-date" class="btn btn-primary btn-sm ms-2">Filter</button>
          </div>
          <a href="{{ route('contract.export') }}" class="btn btn-success btn-md" id="export-button">
            Export
          </a>
        </div>

      </div>
      <div class="card-body">
        <table class="table table-striped" id="table-contract" style="font-size: 85%">
          <thead>
            <tr>
              <th>#</th>
              <th>No. Kontrak</th>
              <th>Nik</th>
              <th>Nama</th>
              <th>Tgl Awal</th>
              <th>Tgl Akhir</th>
              <th>Durasi</th>
              <th>Kontrak Ke-</th>
              <th>Keterangan</th>
              <th>File</th>
              {{-- <th></th> --}}
            </tr>
          </thead>
          <tbody>

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


  @push('after-script')
    {{-- <script>
      jQuery(document).ready(function($) {
        $('#table-contract').DataTable({
          processing: true,
          serverSide: true,
          ordering: true,
          pageLength: 10, // Show all records by default
          lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, 'All']
          ], // Add 'All' option to the length menu
          ajax: {
            url: "{{ route('contract.index') }}",
          },
          columns: [{
              data: 'DT_RowIndex',
              name: 'DT_RowIndex',
              orderable: false,
              searchable: false,
              width: '5%',
            },
            {
              data: 'contract_number',
              name: 'contract_number',
            },
            {
              data: 'nik_employee',
              name: 'nik_employee',
            },
            {
              data: 'name_employee',
              name: 'name_employee',
              orderable: false,
              searchable: false,
            },
            {
              data: 'start_date',
              name: 'start_date',
            },
            {
              data: 'end_date',
              name: 'end_date',
            },
            {
              data: 'duration',
              name: 'duration',
            },
            {
              data: 'contract_sequence_number',
              name: 'contract_sequence_number',
            },
            {
              data: 'description',
              name: 'description',
            },
            {
              data: 'file',
              name: 'file',
            },
            // {
            //   data: 'action',
            //   name: 'action',
            //   orderable: false,
            //   searchable: false,
            //   className: 'no-print' // Add this class to exclude the column from printing
            // },
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
        const table = $('#table-contract').DataTable({
          processing: true,
          serverSide: true,
          ordering: true,
          pageLength: 10,
          lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, 'All']
          ],
          ajax: {
            url: "{{ route('contract.index') }}",
            data: function(d) {
              d.start_date = $('#start-date').val();
              d.end_date = $('#end-date').val();
              d.filter_type = $('#filter-type').val();
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
              data: 'contract_number',
              name: 'contract_number'
            },
            {
              data: 'nik_employee',
              name: 'nik_employee'
            },
            {
              data: 'employee.name',
              name: 'employee.name',
              // orderable: false,
              // searchable: false
            },
            {
              data: 'start_date',
              name: 'start_date'
            },
            {
              data: 'end_date',
              name: 'end_date'
            },
            {
              data: 'duration',
              name: 'duration'
            },
            {
              data: 'contract_sequence_number',
              name: 'contract_sequence_number'
            },
            {
              data: 'description',
              name: 'description'
            },
            {
              data: 'file',
              name: 'file',
              orderable: false,
              searchable: false,
            }
          ],
          columnDefs: [{
            className: 'text-center',
            targets: '_all'
          }]
        });

        // Reload table and update export button on filter
        $('#filter-date').on('click', function() {
          table.ajax.reload();

          // Update export URL
          const startDate = $('#start-date').val();
          const endDate = $('#end-date').val();
          const filterType = $('#filter-type').val();

          let exportUrl = "{{ route('contract.export') }}";
          const params = [];

          if (startDate) params.push(`start_date=${startDate}`);
          if (endDate) params.push(`end_date=${endDate}`);
          if (filterType) params.push(`filter_type=${filterType}`);

          if (params.length) exportUrl += `?${params.join('&')}`;

          $('#export-button').attr('href', exportUrl);
        });
      });
    </script>
  @endpush

  <!--Basic Modal -->
  <div class="modal fade text-left" id="import-contract" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="myModalLabel1">Import Kontrak</h5>
          <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
            <i data-feather="x"></i>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('contract.import') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
              <label for="file" class="form-label">Pilih File</label>
              <input class="form-control" accept=".csv,.xls,.xlsx" type="file" id="file" name="file">
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                <i class="bx bx-x d-block d-sm-none"></i>
                <span class="d-none d-sm-block">Close</span>
              </button>
              <button type="submit" class="btn btn-primary ms-1">
                <i class="bx bx-check d-block d-sm-none"></i>
                <span class="d-none d-sm-block">Submit</span>
              </button>
            </div>

          </form>
        </div>

      </div>
    </div>
  </div>

@endsection
