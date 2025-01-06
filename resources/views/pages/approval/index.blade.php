@extends('layouts.app')
@section('title', 'Persetujuan')
@section('content')

@section('breadcrumb')
  <x-breadcrumb title="Persetujuan" page="Karyawan" active="Persetujuan" route="{{ route('approval.index') }}" />
@endsection

<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />


<section class="section">
  <div class="row">
    <h5>Persetujuan Pending</h5>
    <div class="col-6 col-lg-2 col-md-6">
      <div class="card">
        <div class="card-body px-4 py-4-5">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 d-flex justify-content-start ">
              <div class=" mb-2" style="background-color: #fff">

              </div>
            </div>
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
              <h6 class="text-muted font-semibold">Karyawan Baru</h6>
              <h4 class="font-extrabold mb-0">
                @role('super-admin')
                  {{ DB::table('approvals')->whereNotNull('selected_candidate_id')->whereNull('is_approve')->count() }}
                @else
                  {{ DB::table('approvals')->whereNotNull('selected_candidate_id')->whereNull('is_approve')->where('company_id', auth()->user()->company_id)->count() }}
                @endrole
              </h4>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-2 col-md-6">
      <div class="card">
        <div class="card-body px-4 py-4-5">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 d-flex justify-content-start ">
              <div class=" mb-2" style="background-color: #953b3bcc">
              </div>
            </div>
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
              <h6 class="text-muted font-semibold">Buka Verifikasi</h6>
              <h4 class="font-extrabold mb-0">
                @role('super-admin')
                  {{ DB::table('approvals')->whereNotNull('employee_id')->whereNull('is_approve')->count() }}
                @else
                  {{ DB::table('approvals')->whereNotNull('employee_id')->whereNull('is_approve')->where('company_id', auth()->user()->company_id)->count() }}
                @endrole
              </h4>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-2 col-md-6">
      <div class="card">
        <div class="card-body px-4 py-4-5">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 d-flex justify-content-start ">
              <div class=" mb-2" style="background-color: #314299ec">
              </div>
            </div>
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
              <h6 class="text-muted font-semibold">Promosi</h6>
              <h4 class="font-extrabold mb-0">
                @role('super-admin')
                  {{ DB::table('approvals')->join('employee_careers', 'approvals.employee_career_id', '=', 'employee_careers.id')->whereNotNull('approvals.employee_career_id')->whereNull('approvals.is_approve')->where('employee_careers.type', 'PROMOSI')->count() }}
                @else
                  {{ DB::table('approvals')->join('employee_careers', 'approvals.employee_career_id', '=', 'employee_careers.id')->whereNotNull('approvals.employee_career_id')->whereNull('approvals.is_approve')->where('employee_careers.type', 'PROMOSI')->where('company_id', auth()->user()->company_id)->count() }}
                @endrole
              </h4>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-2 col-md-6">
      <div class="card">
        <div class="card-body px-4 py-4-5">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 d-flex justify-content-start ">
              <div class=" mb-2" style="background-color: #57a042cc">
              </div>
            </div>
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
              <h6 class="text-muted font-semibold">Demosi</h6>
              <h4 class="font-extrabold mb-0">
                @role('super-admin')
                  {{ DB::table('approvals')->join('employee_careers', 'approvals.employee_career_id', '=', 'employee_careers.id')->whereNotNull('approvals.employee_career_id')->whereNull('approvals.is_approve')->where('employee_careers.type', 'DEMOSI')->count() }}
                @else
                  {{ DB::table('approvals')->join('employee_careers', 'approvals.employee_career_id', '=', 'employee_careers.id')->whereNotNull('approvals.employee_career_id')->whereNull('approvals.is_approve')->where('employee_careers.type', 'DEMOSI')->where('company_id', auth()->user()->company_id)->count() }}
                @endrole
              </h4>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-2 col-md-6">
      <div class="card">
        <div class="card-body px-4 py-4-5">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 d-flex justify-content-start ">
              <div class=" mb-2" style="background-color: #7b20a2cc">
              </div>
            </div>
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
              <h6 class="text-muted font-semibold">Mutasi</h6>
              <h4 class="font-extrabold mb-0">
                @role('super-admin')
                  {{ DB::table('approvals')->join('employee_careers', 'approvals.employee_career_id', '=', 'employee_careers.id')->whereNotNull('approvals.employee_career_id')->whereNull('approvals.is_approve')->where('employee_careers.type', 'MUTASI')->count() }}
                @else
                  {{ DB::table('approvals')->join('employee_careers', 'approvals.employee_career_id', '=', 'employee_careers.id')->whereNotNull('approvals.employee_career_id')->whereNull('approvals.is_approve')->where('employee_careers.type', 'MUTASI')->where('company_id', auth()->user()->company_id)->count() }}
                @endrole
              </h4>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-2 col-md-6">
      <div class="card">
        <div class="card-body px-4 py-4-5">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 d-flex justify-content-start ">
              <div class=" mb-2" style="background-color: #b4237fcc">
              </div>
            </div>
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
              <h6 class="text-muted font-semibold">Rotasi</h6>
              <h4 class="font-extrabold mb-0">
                @role('super-admin')
                  {{ DB::table('approvals')->join('employee_careers', 'approvals.employee_career_id', '=', 'employee_careers.id')->whereNotNull('approvals.employee_career_id')->whereNull('approvals.is_approve')->where('employee_careers.type', 'ROTASI')->count() }}
                @else
                  {{ DB::table('approvals')->join('employee_careers', 'approvals.employee_career_id', '=', 'employee_careers.id')->whereNotNull('approvals.employee_career_id')->whereNull('approvals.is_approve')->where('employee_careers.type', 'ROTASI')->where('company_id', auth()->user()->company_id)->count() }}
                @endrole
              </h4>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-2 col-md-6">
      <div class="card">
        <div class="card-body px-4 py-4-5">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 d-flex justify-content-start ">
              <div class=" mb-2" style="background-color: #b4a623cc">
              </div>
            </div>
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
              <h6 class="text-muted font-semibold">Pensiun</h6>
              <h4 class="font-extrabold mb-0">
                @role('super-admin')
                  {{ DB::table('approvals')->join('employee_careers', 'approvals.employee_career_id', '=', 'employee_careers.id')->whereNotNull('approvals.employee_career_id')->whereNull('approvals.is_approve')->where('employee_careers.type', 'PENSIUN')->count() }}
                @else
                  {{ DB::table('approvals')->join('employee_careers', 'approvals.employee_career_id', '=', 'employee_careers.id')->whereNotNull('approvals.employee_career_id')->whereNull('approvals.is_approve')->where('employee_careers.type', 'PENSIUN')->where('company_id', auth()->user()->company_id)->count() }}
                @endrole
              </h4>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-2 col-md-6">
      <div class="card">
        <div class="card-body px-4 py-4-5">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 d-flex justify-content-start ">
              <div class=" mb-2" style="background-color: #2b0f70cc">
              </div>
            </div>
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
              <h6 class="text-muted font-semibold">Resign</h6>
              <h4 class="font-extrabold mb-0">
                @role('super-admin')
                  {{ DB::table('approvals')->join('employee_careers', 'approvals.employee_career_id', '=', 'employee_careers.id')->whereNotNull('approvals.employee_career_id')->whereNull('approvals.is_approve')->where('employee_careers.type', 'RESIGN')->count() }}
                @else
                  {{ DB::table('approvals')->join('employee_careers', 'approvals.employee_career_id', '=', 'employee_careers.id')->whereNotNull('approvals.employee_career_id')->whereNull('approvals.is_approve')->where('employee_careers.type', 'RESIGN')->where('company_id', auth()->user()->company_id)->count() }}
                @endrole
              </h4>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-2 col-md-6">
      <div class="card">
        <div class="card-body px-4 py-4-5">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 d-flex justify-content-start ">
              <div class=" mb-2" style="background-color: #8e0321cc">
              </div>
            </div>
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
              <h6 class="text-muted font-semibold">Non-Aktif</h6>
              <h4 class="font-extrabold mb-0">
                @role('super-admin')
                  {{ DB::table('approvals')->join('employee_careers', 'approvals.employee_career_id', '=', 'employee_careers.id')->whereNotNull('approvals.employee_career_id')->whereNull('approvals.is_approve')->where('employee_careers.type', 'NON-AKTIF')->count() }}
                @else
                  {{ DB::table('approvals')->join('employee_careers', 'approvals.employee_career_id', '=', 'employee_careers.id')->whereNotNull('approvals.employee_career_id')->whereNull('approvals.is_approve')->where('employee_careers.type', 'NON-AKTIF')->where('company_id', auth()->user()->company_id)->count() }}
                @endrole
              </h4>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

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
            <th>Divisi</th>
            <th>Status</th>
            <th>Dibuat</th>
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
    </script>
  --}}


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
            data: 'photo',
            name: 'photo',
            orderable: false,
            searchable: false,
          },
          {
            data: 'employee_nik',
            name: 'employee_nik',
            orderable: false,
            searchable: false,
          },
          {
            data: 'employee_name',
            name: 'employee_name',
            orderable: false,
            searchable: false,
          },
          {
            data: 'employee_position',
            name: 'employee_position',
            orderable: false,
            searchable: false,
          },
          {
            data: 'employee_division',
            name: 'employee_division',
            orderable: false,
            searchable: false,
          },
          {
            data: 'is_approve',
            name: 'is_approve',
          },
          {
            data: 'created_at',
            name: 'created_at',
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

  <script>
    Fancybox.bind("[data-fancybox]", {
      // Your custom options
    });
  </script>
@endpush
@endsection

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


{{--
- tambah kpi di contract dashboard v
- export semua data karyawan v
- filter karyawan non-aktif,pensiun, dan aktif v
- Kontrak Berakhir Bulan Depan +2 builan v
--}}
