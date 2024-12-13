@extends('layouts.app')
@section('title', 'Karyawan')
@section('content')

@section('breadcrumb')
  <x-breadcrumb title="Karyawan Divisi {{ $divisionId->name ?? 'N/A' }}" page="Karyawan" active="Karyawan "
    route="{{ route('dashboard.index') }}" />
@endsection

<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />


<section class="section">
  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between align-items-center ">
        <h5 class="fw-normal mb-0 text-body">Daftar Karyawan Divisi
          {{ $divisionId->name ?? 'N/A' }}
          ( {{ $divisionId->code ?? 'N/A' }} )
        </h5>
      </div>
    </div>
    <div class="card-body">

      <table class="table table-striped" id="table1" style="font-size: 85%">
        <thead>
          <tr>
            <th>#</th>
            <th></th>
            <th>NIK</th>
            <th>Nama</th>
            <th>Kategori Karyawan</th>
            {{-- <th>Email</th>
            <th>Phone</th> --}}
            <th>Status</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($positions as $pos)
            <tr>
              <td>
                {{ $loop->iteration }}
              </td>
              <td>
                @if ($pos->employee->photo)
                  <div class="fixed-frame">
                    <img src="{{ asset('storage/' . $pos->employee->photo) }} " data-fancybox alt="Icon User"
                      class="framed-image" style="cursor: pointer">
                  </div>
                @else
                  No Image
                @endif
              </td>
              <td>
                {{ $pos->employee->nik ?? '' }}
              </td>
              <td>
                {{ $pos->employee->name ?? '' }}
              </td>
              <td>
                {{ $pos->employee->employeeCategory->name ?? '' }}
              </td>
              <td>
                @if ($pos->employee->is_verified == 0)
                  <span class="badge bg-danger">Unverified</span>
                @elseif ($pos->employee->is_verified == 1)
                  <span class="badge bg-success">Verified</span>
                @else
                  -
                @endif
              </td>
              <td>
                <a href="{{ route('employee.show', $pos->employee->id) }}" class="btn btn-sm btn-primary">Lihat</a>
              </td>
            </tr>
          @endforeach

        </tbody>
      </table>
    </div>

  </div>
</section>

{{-- @push('after-script')
  <script>
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
            data: 'email',
            name: 'email',
          },
          {
            data: 'phone_number1',
            name: 'phone_number1',
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
  </script>
@endpush --}}


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

{{-- <script>
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
  Fancybox.bind("[data-fancybox]", {
    // Your custom options
  });
</script>

@endsection
