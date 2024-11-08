@extends('layouts.app')
@section('title', 'Seleksi')
@section('content')

@section('breadcrumb')
  <x-breadcrumb title="Seleksi" page="Recruitment" active="Seleksi" route="{{ route('selection.index') }}" />
@endsection

<section class="section">
  <section class="section">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between align-items-center ">
          <h5 class="fw-normal mb-0 text-body">Daftar Seleksi</h5>

          @role('staff|super-admin')
            <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
              data-bs-target="#modal-form-add-selection">
              <i class="bi bi-plus-lg"></i>
              Seleksi
            </button>
          @endrole

        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped" id="table1" style="font-size: 85%">
            <thead>
              <tr>
                <th>#</th>
                <th>Nama Seleksi</th>
                {{-- <th>Tgl Mulai Seleksi</th> --}}
                <th>Divisi Pemohon</th>
                <th>Pewawancara</th>
                <th>Keterangan</th>
                <th>Status</th>
                <th>File</th>
                <th style="width:13%"></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($selections as $selection)
                <tr>
                  <td class="text-center">{{ $loop->iteration }}</td>
                  <td>{{ $selection->name }}</td>
                  {{-- <td>{{ Carbon\Carbon::parse($selection->start_selection)->translatedFormat('d F Y') }}</td> --}}
                  <td>{{ $selection->division->name ?? '-' }}</td>
                  <td>{{ $selection->interviewer }}</td>
                  <td>{{ $selection->description }}</td>
                  <td>
                    <div class="text-center">
                      {{-- @if ($selection->is_approve)
                        @if ($selection->is_finished)
                          <span class="badge bg-primary">Selesai - Disetujui</span><br>
                          @if ($selection->status == 'kandidat terpilih')
                            <span class="badge bg-primary mt-1">{{ $selection->status }}</span>
                          @else
                            <span class="badge bg-danger mt-1">{{ $selection->status }}</span>
                          @endif
                        @else
                          <span class="badge bg-warning ">Proses</span> <br>
                        @endif
                      @elseif ($selection->is_approve === 0)
                        <span class="badge bg-danger">Selesai - Ditolak</span><br>
                      @else
                        <span class="badge bg-warning">Proses</span>
                      @endif --}}

                      @if ($selection->is_finished)
                        @if ($selection->status)
                          @if ($selection->is_approve)
                            <span class="badge bg-primary">Selesai - Disetujui</span><br>
                            <span class="badge bg-primary mt-1">Kandidat Terpilih</span>
                          @elseif ($selection->is_approve === 0)
                            <span class="badge bg-danger">Selesai - Ditolak</span><br>
                          @else
                            <span class="badge bg-info">Pending</span>
                          @endif
                        @else
                          <span class="badge bg-primary">Selesai</span><br>
                          <span class="badge bg-danger mt-1">Tidak Ada Yang Terpilih</span>
                        @endif
                      @else
                        <span class="badge bg-warning ">Proses</span> <br>
                      @endif

                    </div>
                  </td>
                  <td>
                    @if ($selection->file_selection)
                      <a href="{{ Storage::url($selection->file_selection) }}" target="_blank">
                        Lihat
                      </a>
                    @else
                      -
                      {{-- @foreach ($selection->SelectedCandidates as $candidate)
                      {{ $candidate->candidate->name }},
                    @endforeach --}}
                    @endif
                  </td>
                  {{-- <td>{{ $selection->status }}</td> --}}
                  <td>
                    @if ($selection->is_finished == 0 || auth()->user()->hasRole('super-admin'))
                      @role('ka-dep|super-admin')
                        <a class="btn btn-sm btn-info mx-1"
                          href="{{ route('selectedCandidate.resultSelection', $selection) }}">
                          <i class="bi bi-card-checklist"></i>
                        </a>
                      @endrole

                      @role('staff|super-admin')
                        <div class="btn-group">
                          <div class="dropdown">
                            <button class="btn btn-sm btn-primary dropdown-toggle me-1" type="button"
                              id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                              aria-expanded="false">
                              <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                              <a class="dropdown-item" href="{{ route('selection.edit', $selection) }}">Edit</a>

                              <button class="dropdown-item"
                                onclick="showSweetAlert('{{ $selection->id }}')">Hapus</button>

                              <form id="deleteForm_{{ $selection->id }}"
                                action="{{ route('selection.destroy', $selection->id) }}" method="POST">
                                @method('DELETE')
                                @csrf
                              </form>
                            </div>
                          </div>
                        </div>
                      @endif
                    @endrole

                    <!--APPROVE FOR MANAGER-->
                    @if (
                        ($selection->is_finished == 1 && $selection->status == 1 && $selection->is_approve == null) ||
                            auth()->user()->hasRole('super-admin'))
                      @role('manager|super-admin')
                        <div class="dropdown">
                          <button class="btn btn-sm btn-primary dropdown-toggle me-1" type="button"
                            id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical"></i>
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <button class="dropdown-item"
                              onclick="confirmAction('approve', 'Apakah Anda yakin ingin menyetujui?', {{ $selection->id }})">
                              Approve
                            </button>

                            <button class="dropdown-item"
                              onclick="confirmAction('reject', 'Apakah Anda yakin ingin menolak?', {{ $selection->id }})">
                              Reject
                            </button>

                            <!-- Forms for Approve and Reject actions -->
                            <form id="approveForm_{{ $selection->id }}"
                              action="{{ route('selection.updateApprovalStatus', $selection->id) }}" method="POST"
                              style="display: none;">
                              @csrf
                              @method('patch')
                              <input type="hidden" name="is_approve" value="1"> <!-- Approve value -->
                            </form>

                            <form id="rejectForm_{{ $selection->id }}"
                              action="{{ route('selection.updateApprovalStatus', $selection->id) }}" method="POST"
                              style="display: none;">
                              @csrf
                              @method('patch')
                              <input type="hidden" name="is_approve" value="0"> <!-- Reject value -->
                            </form>
                          </div>
                        </div>
                      @endrole
                    @endif


                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

    @role('super-admins')
      <div class="card">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center ">
            <h5 class="fw-normal mb-0 text-body">Restore Seleksi</h5>
          </div>
        </div>
        <div class="card-body">
          <table class="table table-striped" style="font-size: 85%">
            <thead>
              <tr>
                <th>ID</th>
                <th>Jabatan</th>
                <th>Tgl Seleksi</th>
                <th>Deleted At</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($softDeletedSelections as $selection)
                <tr>
                  <td>{{ $selection->id }}</td>
                  <td>{{ $selection->position->name }}</td>
                  <td>{{ $selection->start_selection }}</td>
                  <td>{{ $selection->deleted_at }}</td>
                  <td>
                    <form action="{{ route('selection.restore', $selection->id) }}" method="POST">
                      @csrf
                      @method('PATCH')
                      <button type="submit" class="btn btn-success btn-sm">Restore</button>
                    </form>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="text-center">No soft deleted selections found.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    @endrole

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

  <script>
    function confirmAction(action, message, selectionId) {
      Swal.fire({
        title: 'Are you sure?',
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, ' + action + ' it!',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          // Submit the correct form based on the action type
          if (action === 'approve') {
            document.getElementById('approveForm_' + selectionId).submit();
          } else if (action === 'reject') {
            document.getElementById('rejectForm_' + selectionId).submit();
          }
        }
      });
    }
  </script>

  @include('pages.recruitment.selection.modal-create')

  <style>
    .fixed-frame {
      position: relative;
      z-index: 10;
      /* Ensure photo appears on top of modal */
    }

    .framed-image {
      width: 100px;
      /* Set fixed size */
      height: 140px;
      /* Maintain aspect ratio for 2x3 */
      object-fit: cover;
      /* Ensure the image covers the frame without distortion */
      border: 2px solid #ddd;
      /* Optional: Add a border */
      border-radius: 4px;
      /* Optional: Rounded corners */
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
      /* Optional: Add shadow */
      transition: transform 0.3s ease;
      /* Smooth transition for enlarge effect */
    }

    /* Hover effect for enlarging */
    .fixed-frame:hover .framed-image {
      transform: scale(2);
      /* Enlarge the image */
      z-index: 20;
      /* Ensure it appears above other elements */
    }
  </style>

@endsection
