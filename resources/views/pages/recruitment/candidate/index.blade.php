@extends('layouts.app')
@section('title', 'Pelamar')
@section('content')

@section('breadcrumb')
  <x-breadcrumb title="Pelamar" page="Recruitment" active="Pelamar" route="{{ route('candidate.index') }}" />
@endsection

<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />


<section class="section">
  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between align-items-center ">
        <h5 class="fw-normal mb-0 text-body">Daftar Pelamar</h5>
        @can('candidate.store')
          <div>
            <a href="{{ route('candidate.create') }}" class="btn btn-primary btn-md">
              <i class="bi bi-plus-lg"></i>
              Pelamar</a>
            <button type="button" class="btn btn-success btn-md" data-bs-toggle="modal"
              data-bs-target="#modal-form-export-candidate">
              Export Pelamar
            </button>
          </div>
        @endcan
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped" id="table-candidate" style="font-size: 85%">
          <thead>
            <tr>
              <th></th>
              <th></th>
              <th>Nama</th>
              <th>Email</th>
              <th>Telp</th>
              <th>Pendidikan</th>
              <th>Jurusan</th>
              <th>Tgl Lamaran Diterima</th>
              <th>File CV</th>
              {{-- <th>Status</th> --}}
              <th></th>
            </tr>
          </thead>
          <tbody>
            {{-- @foreach ($candidates as $candidate)
            <tr>
              <td class="text-center">
                @if ($candidate->photo)
                  <div class="fixed-frame">
                    <img src="{{ asset('storage/' . $candidate->photo) }}" data-fancybox alt="Icon User"
                      class="framed-image" style="cursor: pointer">
                  </div>
                @else
                  No Image
                @endif
              </td>
              <td>{{ $candidate->name }}</td>
              <td>{{ $candidate->email }}</td>
              <td>{{ $candidate->phone_number }}</td>
              <td>{{ Carbon\Carbon::parse($candidate->created_at)->translatedFormat('d F Y') }}</td>
              <!-- <td>
                  <span class="badge bg-success">Hire</span>
                </td> -->
              <td>
                <div class="btn-group mb-1">
                  <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle me-1" type="button" id="dropdownMenuButton"
                      data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <!-- <a class="dropdown-item" href="{{ route('additional-details', $candidate) }}">
                          Kelengkapan Data</a> -->
                      <a class="dropdown-item" href="{{ route('candidate.edit', $candidate) }}">Edit</a>
                      <!-- <button class="dropdown-item" onclick="editAlert({{ $candidate->id }})">Edit</button> -->
                      @role('super-admin')
                        <button class="dropdown-item" onclick="showSweetAlert('{{ $candidate->id }}')">Hapus</button>

                        <form id="deleteForm_{{ $candidate->id }}"
                          action="{{ route('candidate.destroy', $candidate->id) }}" method="POST">
                          @method('DELETE')
                          @csrf
                        </form>
                      @endrole
                    </div>
                  </div>
                </div>

              </td>
            </tr>
          @endforeach --}}
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

@include('pages.recruitment.candidate.export-candidate')

@push('after-script')
  <script>
    jQuery(document).ready(function($) {
      $('#table-candidate').DataTable({
        processing: true,
        serverSide: true,
        ordering: true,
        pageLength: 10, // Show all records by default
        lengthMenu: [
          [10, 25, 50, 100, -1],
          [10, 25, 50, 100, 'All']
        ], // Add 'All' option to the length menu
        ajax: {
          url: "{{ route('candidate.index') }}",
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
            data: 'name',
            name: 'name',
          },
          {
            data: 'email',
            name: 'email',
          },
          {
            data: 'phone_number',
            name: 'phone_number',
          },
          {
            data: 'last_educational',
            name: 'last_educational',
          },
          {
            data: 'study',
            name: 'study',
          },
          {
            data: 'date_applieds',
            name: 'date_applied',
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

{{-- <script>
  function editAlert(getId) {
    Swal.fire({
      title: 'Apakah ingin mengedit data?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, edit it!'
    }).then((result) => {
      if (result.isConfirmed) {
        // Redirect to the edit route using Blade's route helper
        window.location.href = "{{ route('candidate.edit', ':id') }}".replace(':id', getId);
      }
    });
  }
</script> --}}

<script>
  Fancybox.bind("[data-fancybox]", {
    // Your custom options
  });
</script>

{{-- @include('pages.recruitment.candidate.modal-create') --}}

@endsection
