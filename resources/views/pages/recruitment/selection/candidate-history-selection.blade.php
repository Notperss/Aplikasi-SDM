@extends('layouts.app')
@section('title', 'History Seleksi')
@section('content')

@section('breadcrumb')
  <x-breadcrumb title="History Seleksi {{ $candidate->name }}" page="Recruitment" active="History Seleksi"
    route="{{ route('selection.index') }}" />
@endsection

<section class="section">
  <section class="section">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between align-items-center ">
          <h5 class="fw-normal mb-0 text-body">Daftar Seleksi </h5>

          {{-- @role('staff|super-admin')
            <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
              data-bs-target="#modal-form-add-selection">
              <i class="bi bi-plus-lg"></i>
              Seleksi
            </button>
          @endrole --}}

        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped" id="table1" style="font-size: 85%">
            <thead>
              <tr>
                <th>#</th>
                <th>Nama Seleksi</th>
                <th>Tgl Mulai Seleksi</th>
                <th>Divisi Pemohon</th>
                <th>Pewawancara</th>
                <th>Keterangan</th>
                <th>File</th>
                {{-- <th style="width:13%"></th> --}}
              </tr>
            </thead>
            <tbody>
              @foreach ($candidate->selectedCandidates as $candidate)
                <tr>
                  <td class="text-center">{{ $loop->iteration }}</td>
                  <td>{{ $candidate->selection->name }}</td>
                  <td>{{ Carbon\Carbon::parse($candidate->selection->start_selection)->translatedFormat('d F Y') }}</td>
                  <td>{{ $candidate->selection->division->name ?? '-' }}</td>
                  <td>{{ $candidate->selection->interviewer }}</td>
                  <td>{{ $candidate->selection->description }}</td>

                  <td>
                    @if ($candidate->selection->file_selection)
                      <a href="{{ Storage::url($candidate->selection->file_selection) }}" target="_blank">
                        Lihat
                      </a>
                    @else
                      -
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
