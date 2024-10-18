@extends('layouts.app')
@section('title', 'Seleksi')
@section('content')

@section('breadcrumb')
  <x-breadcrumb title="Hasil Seleksi" page="Recruitment" active="Seleksi" route="{{ route('selection.index') }}" />
@endsection

<section class="section">

  <div class="card">
    <div class="card-header">
    </div>
    <div class="card-body">
      <div class="row justify-content-center">

        <div class="row">

          <div class="col-md-6">
            <div class="my-2">
              <label class="form-label" for="name">Nama Seleksi</label>
              <input id="name" name="name" value="{{ old('name', $selection->name) }}"
                class="form-control @error('name') is-invalid @enderror" readonly>
              @error('name')
                <a style="color: red"><small>{{ $message }}</small></a>
              @enderror
            </div>
            <div class="mb-2">
              <label class="form-label" for="pic_selection">PIC Divisi Pemohon</label>
              <input id="pic_selection" name="pic_selection"
                value="{{ old('pic_selection', $selection->pic_selection) }}"
                class="form-control @error('pic_selection') is-invalid @enderror" readonly>
              @error('pic_selection')
                <a style="color: red"><small>{{ $message }}</small></a>
              @enderror
            </div>
            <div class="mb-2">
              <label class="form-label" for="interviewer">Pewawancara</label>
              <input id="interviewer" name="interviewer" value="{{ old('interviewer', $selection->interviewer) }}"
                class="form-control @error('interviewer') is-invalid @enderror" readonly>
              @error('interviewer')
                <a style="color: red"><small>{{ $message }}</small></a>
              @enderror
            </div>
          </div>

          <div class="col-md-6">
            <div class="my-2">
              <label class="form-label" for="position_id">Jabatan</label>
              <input id="position_id" name="position_id" value="{{ old('position_id', $selection->position->name) }}"
                class="form-control @error('position_id') is-invalid @enderror" disabled>
              @error('position_id')
                <a style="color: red"><small>{{ $message }}</small></a>
              @enderror
            </div>
            <div class="my-2">
              <label class="form-label" for="start_selection">Tgl Mulai Seleksi</label>
              <input type="text" id="start_selection" name="start_selection"
                value="{{ Carbon\Carbon::parse($selection->start_selection)->translatedFormat('l, d F Y') }}"
                class="form-control @error('start_selection') is-invalid @enderror" readonly>
              @error('start_selection')
                <a style="color: red"><small>{{ $message }}</small></a>
              @enderror
            </div>
            <div class="mb-2">
              <label class="form-label" for="end_selection">Tgl Selesai Seleksi</label>
              <input type="text" id="end_selection" name="end_selection"
                value="{{ $selection->end_selection ? Carbon\Carbon::parse($selection->end_selection)->translatedFormat('l, d F Y') : '-' }}"
                class="form-control @error('end_selection') is-invalid @enderror" readonly>
              @error('end_selection')
                <a style="color: red"><small>{{ $message }}</small></a>
              @enderror
            </div>

          </div>
          <div class="col-md-12">

            <div class="mb-2">
              <label class="form-label" for="description">Keterangan</label>
              <textarea id="description" name="description" rows="5"
                class="form-control @error('description') is-invalid @enderror" readonly>{{ old('description', $selection->description) }} </textarea>
              @error('description')
                <a style="color: red"><small>{{ $message }}</small></a>
              @enderror
            </div>

            <div class="mb-2">
              <label for="file_selection" class="form-label">File :</label>
              @if ($selection->file_selection)
                <a href="{{ asset('storage/' . $selection->file_selection) }}" target="_blank"
                  class="text-sm btn btn-sm btn-primary mt-3">
                  Lihat File
                </a>
              @else
                <span>-</span>
              @endif

              @error('file_selection')
                <a style="color: red"><small>{{ $message }}</small></a>
              @enderror

            </div>
          </div>

        </div>

      </div>

    </div>
  </div>


  <div class="col-md-12">
    <div class="d-flex justify-content-between align-items-center ">
      <h5 class="fw-normal my-3 text-body">Daftar Kandidat</h5>
    </div>
    <table class="table table-striped" id="table1" style="font-size: 85%">
      <thead>
        <tr>
          <th></th>
          <th>Pelamar</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($selection->SelectedCandidates as $selectedCandidate)
          <tr>
            <td class="text-center">
              @if ($selectedCandidate->candidate->photo)
                <div class="fixed-frame">
                  <img src="{{ asset('storage/' . $selectedCandidate->candidate->photo) }}" alt="img"
                    class="framed-image enlargeable" style="cursor: pointer;">
                </div>
              @else
                No Image
              @endif
            </td>
            <td>{{ $selectedCandidate->candidate->name }}</td>
            <td>{{ $selectedCandidate->candidate->email }}</td>
            <td>{{ $selectedCandidate->candidate->phone_number }}</td>
            <td>
              <a data-bs-toggle="modal" data-bs-target="#modal-form-edit-result-selection-{{ $selectedCandidate->id }}"
                class="btn btn-sm btn-icon btn-secondary text-white">
                <i class="bi bi-pencil-square"></i>
              </a>

              @include('pages.recruitment.selection.modal-result')

            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

</section>



<script>
  function destroyCandidate(getId) {
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
  function openMyModalEdit(selectionId) {
    let modalId = `modal-form-add-candidate-edit-${selectionId}`;
    let myModal = new bootstrap.Modal(document.getElementById(modalId), {});
    myModal.show();
  }

  function confirmSelection(candidateId, candidateName) {
    // Show a confirmation alert
    if (confirm('Apakah Anda yakin ingin memilih ' + candidateName + ' sebagai kandidat?')) {
      // If confirmed, set the selected candidate ID in the hidden input field
      document.getElementById('selected_candidate').value = candidateId;

      // Submit the form
      document.getElementById('candidateSelectionForm').submit();
    }
  }
</script> --}}

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
