@extends('layouts.app')
@section('title', 'Persetujuan')
@section('content')

@section('breadcrumb')
  <x-breadcrumb title="Persetujuan" page="Karyawan" active="Persetujuan" route="{{ route('approval.index') }}" />
@endsection

<section class="section">
  <section class="section">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between align-items-center ">
          <h5 class="fw-normal mb-0 text-body">Daftar Persetujuan</h5>

        </div>
      </div>
      <div class="card-body">
        <table class="table table-striped" id="table-approval" style="font-size: 85%">
          <thead>
            <tr>
              <th>#</th>
              <th></th>
              <th>NIK</th>
              <th>Nama Lengkap</th>
              <th>Jabatan</th>
              <th>Keterangan</th>
              <th>File</th>
              <th></th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>
    </div>
  </section>

  {{--
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
  </script> --}}


  <script>
    function confirmAction(actionType, message, getId) {
      Swal.fire({
        title: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Confirm!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          // Submit the corresponding form based on action type
          const formId = actionType === 'approve' ? 'approveForm_' : 'rejectForm_';
          document.getElementById(formId + getId).submit();
        }
      });
    }
  </script>


  @push('after-script')
    <script>
      jQuery(document).ready(function($) {
        $('#table-approval').DataTable({
          processing: true,
          serverSide: true,
          ordering: true,
          pageLength: 10, // Show all records by default
          lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, 'All']
          ], // Add 'All' option to the length menu
          ajax: {
            url: "{{ route('approval.index') }}",
          },
          columns: [{
              data: 'DT_RowIndex',
              name: 'DT_RowIndex',
              orderable: false,
              searchable: false,
              width: '5%',
            },
            {
              data: 'employee_career_id',
              name: 'employee_career_id',
            },
            {
              data: 'selected_candidate_id',
              name: 'selected_candidate_id',
            },
            {
              data: 'is_approve',
              name: 'is_approve',
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
@endsection
