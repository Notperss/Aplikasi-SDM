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
      <div class="table-responsive">
        <table class="table table-striped" id="table1" style="font-size: 85%;">
          <thead>
            <tr>
              <th>#</th>
              <th></th>
              <th>Kandidat</th>
              <th>Seleksi</th>
              <th>Jabatan</th>
              <th>Keterangan</th>
              <th>File</th>
              <th>Status</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            {{-- @foreach ($candidates as $candidate)
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
          @endforeach --}}

            @foreach ($selectedCandidates as $selectedCandidate)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="text-center">
                  @if ($selectedCandidate->candidate->photo)
                    <div class="fixed-frame">
                      <img src="{{ asset('storage/' . $selectedCandidate->candidate->photo) }}" data-fancybox
                        alt="Icon User" class="framed-image" style="cursor: pointer">
                    </div>
                  @else
                    No Image
                  @endif
                </td>
                <td>{{ $selectedCandidate->candidate->name }}</td>
                <td>
                  {{ $selectedCandidate->selection->name ?? '-' }}
                </td>
                <td>
                  <span class="badge bg-primary">{{ $selectedCandidate->position->name ?? '-' }}</span>
                </td>
                <td>
                  {{ $selectedCandidate->description ?? '-' }}
                </td>
                <td>

                  @if ($selectedCandidate->file_selected_candidate)
                    <a href="{{ asset('storage/' . $selectedCandidate->file_selected_candidate) }}"
                      class="btn btn-sm btn-primary" target="_blank">
                      Lihat
                    </a>
                  @else
                    -
                  @endif

                </td>
                <td>
                  @if ($selectedCandidate->is_approve === 1)
                    <span class="badge bg-success">Disetujui</span>
                  @elseif($selectedCandidate->is_approve === 0)
                    <span class="badge bg-danger">Ditolak</span>
                  @else
                    -
                  @endif
                </td>
                <td>
                  @if ($selectedCandidate->is_hire === null)
                    <div class="btn-group mb-1">
                      @role('staff|ka-si|super-admin')
                        <a class="btn btn-sm btn-info mx-1" title="Tambahkan ke karyawan"
                          href="{{ route('employee.newEmployee', encrypt($selectedCandidate->id)) }}">
                          <i class="bi bi-person-plus-fill"></i>
                        </a>
                      @endrole
                      {{-- @if ($selectedCandidate->is_approve === 1)
                    @endif --}}

                      {{--
                      @if ($selectedCandidate->is_approve === null || auth()->user()->hasRole('super-admin'))
                        @role('manager|super-admin')
                          <div class="dropdown">
                            <button class="btn btn-sm btn-primary dropdown-toggle me-1" type="button"
                              id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                              aria-expanded="false">
                              <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                              <button class="dropdown-item"
                                onclick="confirmAction('approve', 'Apakah Anda yakin ingin menyetujui?', {{ $selectedCandidate->id }})">
                                Approve
                              </button>

                              <button class="dropdown-item"
                                onclick="confirmAction('reject', 'Apakah Anda yakin ingin menolak?', {{ $selectedCandidate->id }})">
                                Reject
                              </button>

                              <!-- Forms for Approve and Reject actions -->
                              <form id="approveForm_{{ $selectedCandidate->id }}"
                                action="{{ route('selectedCandidate.updateApprovalStatus', $selectedCandidate->id) }}"
                                method="POST" style="display: none;">
                                @csrf
                                @method('patch')
                                <input type="hidden" name="is_approve" value="1"> <!-- hire value -->
                              </form>

                              <form id="rejectForm_{{ $selectedCandidate->id }}"
                                action="{{ route('selectedCandidate.updateApprovalStatus', $selectedCandidate->id) }}"
                                method="POST" style="display: none;">
                                @csrf
                                @method('patch')
                                <input type="hidden" name="is_approve" value="0"> <!-- Reject value -->
                              </form>
                            </div>
                          </div>
                        @endrole
                      @endif
                      --}}
                    </div>
                  @endif

                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
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
  function confirmAction(actionType, message, getId) {
    Swal.fire({
      title: message,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Ya, lanjutkan!',
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

{{-- @include('pages.recruitment.candidate.modal-create') --}}

@endsection
