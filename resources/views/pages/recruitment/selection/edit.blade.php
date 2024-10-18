@extends('layouts.app')
@section('title', 'Seleksi')
@section('content')

@section('breadcrumb')
  <x-breadcrumb title="Edit Seleksi" page="Recruitment" active="Seleksi" route="{{ route('selection.index') }}" />
@endsection

<section class="section">
  <form action="{{ route('selection.update', $selection) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="card">
      <div class="card-header">
      </div>
      <div class="card-body">
        <div class="row justify-content-center">
          <div class="col-md-11"> <!-- Make form smaller with col-md-6 and center it -->

            <div class="row">

              <div class="col-md-6">
                <div class="my-2">
                  <label class="form-label" for="name">Nama Seleksi</label>
                  <input id="name" name="name" value="{{ old('name', $selection->name) }}"
                    class="form-control @error('name') is-invalid @enderror">
                  @error('name')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>
                <div class="mb-2">
                  <label class="form-label" for="pic_selection">PIC Divisi Pemohon</label>
                  <input id="pic_selection" name="pic_selection"
                    value="{{ old('pic_selection', $selection->pic_selection) }}"
                    class="form-control @error('pic_selection') is-invalid @enderror">
                  @error('pic_selection')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>
                <div class="mb-2">
                  <label class="form-label" for="interviewer">Pewawancara</label>
                  <input id="interviewer" name="interviewer" value="{{ old('interviewer', $selection->interviewer) }}"
                    class="form-control @error('interviewer') is-invalid @enderror" required>
                  @error('interviewer')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>
              </div>

              <div class="col-md-6">
                <div class="my-2">
                  <label class="form-label" for="position_id">Jabatan</label>
                  <select id="position_id" name="position_id"
                    class="form-control @error('position_id') is-invalid @enderror" required>
                    <option value="" disabled selected>Choose</option>
                    @foreach ($positions as $position)
                      <option value="{{ $position->id }}"
                        {{ old('position_id', $selection->position_id) == $position->id ? 'selected' : '' }}>
                        {{ $position->name }}</option>
                    @endforeach
                  </select>
                  @error('position_id')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>
                <div class="my-2">
                  <label class="form-label" for="start_selection">Tgl Mulai Seleksi</label>
                  <input type="date" id="start_selection" name="start_selection"
                    value="{{ old('start_selection', $selection->start_selection) }}"
                    class="form-control @error('start_selection') is-invalid @enderror" required>
                  @error('start_selection')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>
                <div class="mb-2">
                  <label class="form-label" for="end_selection">Tgl Selesai Seleksi</label>
                  <input type="date" id="end_selection" name="end_selection"
                    value="{{ old('end_selection', $selection->end_selection) }}"
                    class="form-control @error('end_selection') is-invalid @enderror">
                  @error('end_selection')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>

              </div>
              <div class="col-md-12">

                <div class="mb-2">
                  <label class="form-label" for="description">Keterangan</label>
                  <textarea id="description" name="description" rows="5"
                    class="form-control @error('description') is-invalid @enderror">{{ old('description', $selection->description) }} </textarea>
                  @error('description')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>

                <div class="mb-2">
                  <label for="file_selection" class="form-label">File</label>
                  <input class="form-control @error('file_selection') is-invalid @enderror" accept=".pdf"
                    type="file" id="file_selection" name="file_selection">
                  @error('file_selection')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                  @if ($selection->file_selection)
                    <a href="{{ asset('storage/' . $selection->file_selection) }}" target="_blank"
                      class="text-sm btn btn-sm btn-primary mt-3">
                      Lihat File
                    </a>
                  @else
                    <span>-</span>
                  @endif
                </div>
              </div>

            </div>

          </div>
        </div>
        <div class="col-12 d-flex justify-content-end mt-4">
          <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
          <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
        </div>
      </div>
    </div>

  </form>




  <a class="btn btn-primary btn-md mb-2" onclick="openMyModalEdit({{ $selection->id }})">
    <i class="bi bi-plus-lg"></i>
    Kandidat
  </a>


  <div class="col-md-12">
    <div class="d-flex justify-content-between align-items-center ">
      <h5 class="fw-normal my-3 text-body">Daftar Kandidat</h5>
    </div>
    <table class="table table-striped" id="table2" style="font-size: 85%">
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
              <button class="btn btn-danger mx-2" onclick="destroyCandidate('{{ $selectedCandidate->id }}')">
                <i class="bi bi-trash"></i>
              </button>

              <form id="deleteForm_{{ $selectedCandidate->id }}"
                action="{{ route('selectedCandidate.destroy', $selectedCandidate->id) }}" method="POST">
                @method('DELETE')
                @csrf
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

</section>

<div id="modal-form-add-candidate-edit-{{ $selection->id }}" class="modal fade" tabindex="-1"
  aria-labelledby="modal-form-add-candidate-edit-{{ $selection->id }}-label" aria-hidden="true"
  style="display: none;">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">

      <form id="candidateSelectionForm" action="{{ route('selectedCandidate.addCandidate', $selection) }}"
        method="post" enctype="multipart/form-data">
        @csrf

        <div class="card">
          <div class="card-header">
            <div class="d-flex justify-content-between align-items-center ">
              <h5 class="fw-normal mb-0 text-body">Daftar Pelamar</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
          </div>
          <div class="card-body">
            <table class="table table-striped" id="table1" style="font-size: 85%">
              <thead>
                <tr>
                  <th></th>
                  <th>Pelamar</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($candidates as $candidate)
                  <tr>
                    <td class="text-center">
                      @if ($candidate->photo)
                        <div class="fixed-frame">
                          <img src="{{ asset('storage/' . $candidate->photo) }}" alt="img"
                            class="framed-image enlargeable" style="cursor: pointer;">
                        </div>
                      @else
                        No Image
                      @endif
                    </td>
                    <td>{{ $candidate->name }}</td>
                    <td>{{ $candidate->email }}</td>
                    <td>{{ $candidate->phone_number }}</td>
                    <td>
                      <div class="btn-group mb-1">
                        <!-- Update selected candidate on button click -->
                        <button type="button" class="btn btn-sm btn-primary"
                          onclick="confirmSelection('{{ $candidate->id }}', '{{ $candidate->name }}')">
                          Pilih
                        </button>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>


          </div>
        </div>
        <input type="hidden" name="selected_candidate" id="selected_candidate">
      </form>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

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


<script>
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
</script>

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
