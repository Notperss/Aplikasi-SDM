@extends('layouts.app')
@section('title', 'Calon Karyawan')
@section('content')

@section('breadcrumb')
  <x-breadcrumb title="Calon Karyawan" page="Recruitment" active="Calon Karyawan" route="{{ route('candidate.index') }}" />
@endsection

<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />


<section class="section">
  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between align-items-center ">
        <h5 class="fw-normal mb-0 text-body">Daftar Calon Karyawan</h5>
      </div>
    </div>
    <div class="card-body">
      <table class="table table-striped" id="table1" style="font-size: 85%;">
        <thead>
          <tr>
            <th>#</th>
            <th></th>
            <th>Kandidat</th>
            <th>Jabatan</th>
            <th>Keterangan</th>
            <th>File</th>
            <th>Status</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($candidates as $candidate)
            <tr>
              <td>{{ $loop->iteration }}</td>

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
              <td>
                @foreach ($candidate->selectedCandidates as $selectedCandidate)
                  <span class="badge bg-primary">{{ $selectedCandidate->position->name ?? '-' }}</span>
                @endforeach
              </td>
              <td>
                @foreach ($candidate->selectedCandidates as $selectedCandidate)
                  {{ $selectedCandidate->description ?? '-' }}
                @endforeach
              </td>
              <td>
                @foreach ($candidate->selectedCandidates as $selectedCandidate)
                  @if ($selectedCandidate->file_selected_candidate)
                    <a href="{{ asset('storage/' . $selectedCandidate->file_selected_candidate) }}"
                      class="btn btn-sm btn-primary" target="_blank">
                      Lihat
                    </a>
                  @else
                    -
                  @endif
                @endforeach
              </td>
              <td>
                Status
              </td>
              {{-- <td>{{ Carbon\Carbon::parse($candidate->created_at)->translatedFormat('d F Y') }}</td> --}}
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

                      <a class="dropdown-item" href="#"
                        onclick="confirmAction('approve', 'Apakah Anda yakin ingin menyetujui?')">Approve</a>

                      <a class="dropdown-item" href="#"
                        onclick="confirmAction('reject', 'Apakah Anda yakin ingin menolak?')">Reject</a>

                    </div>
                  </div>
                </div>

              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</section>

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




<script>
  function confirmAction(actionType, message) {
    Swal.fire({
      title: message,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, proceed!',
      cancelButtonText: 'Cancel'
    }).then((result) => {
      if (result.isConfirmed) {

      }
    });
  }
</script>


{{-- @include('pages.recruitment.candidate.modal-create') --}}

@endsection
