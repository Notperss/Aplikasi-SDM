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
        <div class="d-flex justify-content-between align-items-center ">
          <h5 class="fw-normal mb-0 text-body">Daftar Kontrak</h5>

          <!-- Button trigger for basic modal -->
          {{-- <button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal"
            data-bs-target="#import-contract">
            Import Kontrak
          </button> --}}

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
    <script>
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
