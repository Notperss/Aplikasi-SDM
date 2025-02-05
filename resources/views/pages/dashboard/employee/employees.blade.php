@extends('layouts.app')
@section('title', 'Karyawan')
@section('content')

@section('breadcrumb')
  <x-breadcrumb title="Daftar {{ request('status') }}" page="Dashboard" active="Karyawan "
    route="{{ route('dashboard.index') }}" />
@endsection

<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />


<section class="section">
  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between align-items-center ">
        <h5 class="fw-normal mb-0 text-body">Daftar Karyawan
        </h5>
        @if (request('status') === 'Karyawan Pensiun Tahun Ini' || request('status') === 'Karyawan Yang Akan Pensiun')
          <a href="{{ route('exportRetirement', ['status' => request('status')]) }}" class="btn btn-success btn-sm">
            Export.
          </a>
        @else
          <a href="{{ url('/export-employee-in-out') }}?status={{ request('status') }}&isMonth={{ request('isMonth') }}"
            class="btn btn-sm btn-success">
            Export
          </a>
        @endif

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
            <th>Usia</th>
            <th>Jabatan</th>
            <th>Kategori Karyawan</th>
            @if (request('status') === 'Karyawan Pensiun Tahun Ini' || request('status') === 'Karyawan Yang Akan Pensiun')
              <th>Masa Pensiun</th>
              <th>Sisa Tahun Menuju Pensiun</th>
            @endif
            {{-- <th>Email</th>
            <th>Phone</th> --}}
            <th>Status</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($employees as $employee)
            <tr>
              <td> {{ $loop->iteration }}
              </td>
              <td>
                @php
                  $mainPhoto = $employee->employeePhotos->where('main_photo', true)->first();
                  $currentDate = \Carbon\Carbon::now();

                  if ($employee->dob) {
                      $dob = \Carbon\Carbon::parse($employee->dob);

                      // Calculate the difference
                      $ageYears = $dob->age;
                      $ageMonths = $dob->diffInMonths($currentDate) % 12;
                  }
                @endphp
                @if ($mainPhoto)
                  <div class="fixed-frame">
                    <img src="{{ asset('storage/' . $mainPhoto->file_path) }} " data-fancybox alt="Icon User"
                      class="framed-image" style="cursor: pointer">
                  </div>
                @else
                  No Image
                @endif
              </td>
              <td> {{ $employee->nik ?? '' }} </td>
              <td> {{ $employee->name ?? '' }} </td>
              <td> {{ $ageYears . ' Tahun ' . $ageMonths . ' Bulan' }} </td>
              <td> {{ $employee->position->name ?? '' }} </td>
              <td>
                @php
                  $categoryName = $employee->employeeCategory->name ?? '-';
                  $levelId = $employee->position->level->id ?? '-';

                  $badgeColors = [
                      1 => 'bg-light-primary',
                      2 => 'bg-light-success',
                      3 => 'bg-light-warning',
                      4 => 'bg-light-danger',
                      5 => 'bg-light-info',
                  ];

                  $badgeClass = $badgeColors[$levelId] ?? 'badge-secondary';
                @endphp

                @if (in_array($levelId, [1, 2, 3, 4, 5]))
                  <span>{{ $categoryName }}</span><br>
                  <span class="badge {{ $badgeClass }}">{{ $employee->position->level->name }}</span>
                @endif

                {{-- <span class="badge bg-light-primary">asoidjhoa</span> --}}
                {{-- {{ $employee->employeeCategory->name ?? '' }} --}}
              </td>
              @if (request('status') === 'Karyawan Pensiun Tahun Ini' || request('status') === 'Karyawan Yang Akan Pensiun')
                <td>
                  @php
                    $retirementDate = \Carbon\Carbon::parse($employee->dob)->addYears(55);

                    $currentDate = \Carbon\Carbon::now();
                    $diff = $currentDate->diff($retirementDate);

                    $remainingYears = $diff->invert ? 0 : $diff->y; // Whole years (set to 0 if the date has passed)
                    $remainingMonths = $diff->invert ? 0 : $diff->m; // Remaining months after whole years (set to 0 if the date has passed)
                  @endphp
                  {{ $retirementDate->translatedFormat('l, d F Y') }}
                </td>
                <td>
                  {{ $remainingYears . ' tahun ' . $remainingMonths . ' bulan' }}
                </td>
              @endif
              <td>
                @if ($employee->is_verified == 0)
                  <span class="badge bg-danger">Unverified</span>
                @elseif ($employee->is_verified == 1)
                  <span class="badge bg-success">Verified</span>
                @else
                  -
                @endif
              </td>
              <td>
                <a href="{{ route('employee.show', $employee->id) }}" class="btn btn-sm btn-primary">Lihat</a>
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
