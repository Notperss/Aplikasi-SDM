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

          <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
            data-bs-target="#modal-form-add-selection">
            <i class="bi bi-plus-lg"></i>
            Seleksi
          </button>

        </div>
      </div>
      <div class="card-body">
        <table class="table table-striped" id="table1" style="font-size: 85%">
          <thead>
            <tr>
              <th>#</th>
              <th>Nama Seleksi</th>
              <th>Tgl Mulai Seleksi</th>
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
                <td>{{ Carbon\Carbon::parse($selection->start_selection)->translatedFormat('d F Y') }}</td>

                <td>{{ $selection->interviewer }}</td>
                <td>{{ $selection->description }}</td>
                <td>{{ 'Proses' }}</td>
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
                <td>
                  {{-- 
                  <div class="d-flex justify-content-end mt-2">
                    <a data-bs-toggle="modal" data-bs-target="#modal-form-edit-selection-{{ $selection->id }}"
                      class="btn btn-icon btn-secondary text-white">
                      <i class="bi bi-pencil-square"></i>
                    </a>

                    <a class="btn btn-icon btn-secondary text-white" href="{{ route('selection.edit', $selection) }}">
                      <i class="bi bi-pencil-square"></i>
                    </a>
                    @include('pages.recruitment.selection.modal-edit')

                    <button class="btn btn-light-danger mx-2" onclick="showSweetAlert('{{ $selection->id }}')">
                      <i class="bi bi-trash"></i>
                    </button>

                    <form id="deleteForm_{{ $selection->id }}"
                      action="{{ route('selection.destroy', $selection->id) }}" method="POST">
                      @method('DELETE')
                      @csrf
                    </form>
                  </div> --}}

                  <a class="btn btn-sm btn-info mx-1"
                    href="{{ route('selectedCandidate.resultSelection', $selection) }}">
                    <i class="bi bi-card-checklist"></i>
                  </a>


                  <div class="btn-group">
                    <div class="dropdown">
                      <button class="btn btn-sm btn-primary dropdown-toggle me-1" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                        <a class="dropdown-item" href="{{ route('selection.edit', $selection) }}">Edit</a>

                        <button class="dropdown-item" onclick="showSweetAlert('{{ $selection->id }}')">Hapus</button>

                        <form id="deleteForm_{{ $selection->id }}"
                          action="{{ route('selection.destroy', $selection->id) }}" method="POST">
                          @method('DELETE')
                          @csrf
                        </form>
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
                    <form action="{{ route('selections.restore', $selection->id) }}" method="POST">
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
