@extends('layouts.app')
@section('title', 'Seleksi')
@section('content')

@section('breadcrumb')
  <x-breadcrumb title="Hasil Seleksi" page="Recruitment" active="Seleksi" route="{{ route('selection.index') }}" />
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

          <div class="row">

            <div class="col-md-12">
              <div class="my-2">
                <label class="form-label" for="name">Nama Seleksi</label>
                <textarea id="name" name="name" value="{{ old('name', $selection->name) }}"
                  class="form-control @error('name') is-invalid @enderror" rows="3" readonly>{{ old('name', $selection->name) }}</textarea>
                @error('name')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>
            </div>

            <div class="col-md-6">
              <div class="my-2">
                <label class="form-label" for="position_id">Jabatan <code>*</code></label>
                <select id="position_id" name="position_id[]"
                  class="form-control choices @error('position_id') is-invalid @enderror multiple-remove" required
                  multiple>
                  <option value="" disabled>Choose</option>

                  @foreach ($positions as $position)
                    <option value="{{ $position->id }}"
                      {{ in_array($position->id, old('position_id', $selectedPositionIds)) ? 'selected' : '' }}>
                      {{ $position->name }}
                    </option>
                  @endforeach
                  {{-- @foreach ($positions as $position)
                      <option value="{{ $position->id }}"
                        {{ in_array($position->id, old('position_id', $position->id)) ? 'selected' : '' }}>
                        {{ $position->name }}
                      </option>
                    @endforeach --}}
                </select>
                @error('position_id')
                  <div style="color: red"><small>{{ $message }}</small></div>
                @enderror
              </div>

              {{-- <div class="mb-2">
                  <label class="form-label" for="interviewer">Pewawancara <code>*</code></label>
                  <textarea id="interviewer" name="interviewer" rows="3"
                    class="form-control @error('interviewer') is-invalid @enderror" required>{{ old('interviewer', $selection->interviewer) }} </textarea>
                  @error('interviewer')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div> --}}
            </div>


            <div class="col-md-6">

              {{-- <div class="my-2">
              <label class="form-label" for="position_id">Jabatan</label>
              <input id="position_id" name="position_id"
                value="{{ implode(', ', old('position_id', $selection->selectedPositions->pluck('name')->toArray() ?? [])) }}"
                class="form-control @error('position_id') is-invalid @enderror" readonly>
              @error('position_id')
                <a style="color: red"><small>{{ $message }}</small></a>
              @enderror
            </div> --}}

              <div class="my-2">
                <label class="form-label" for="pic_selection">Divisi Pemohon</label>
                <input id="pic_selection" value="{{ old('pic_selection', $selection->division->name ?? '-') }}"
                  class="form-control @error('pic_selection') is-invalid @enderror" readonly>
                <input type="hidden" name="division_id" value="{{ $selection->division_id }}" hidden>
                @error('pic_selection')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="my-2">
                <label class="form-label" for="start_selection">Tgl Mulai Seleksi</label>
                <input type="text" id="start_selection" name="start_selections"
                  value="{{ $selection->start_selection ? Carbon\Carbon::parse($selection->start_selection)->translatedFormat('l, d F Y') : '-' }}"
                  class="form-control @error('start_selection') is-invalid @enderror" readonly>
                @error('start_selection')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              {{-- <div class="mb-2">
              <label class="form-label" for="end_selection">Tgl Selesai Seleksi</label>
              <input type="text" id="end_selection" name="end_selection"
                value="{{ $selection->end_selection ? Carbon\Carbon::parse($selection->end_selection)->translatedFormat('l, d F Y') : '-' }}"
                class="form-control @error('end_selection') is-invalid @enderror" readonly>
              @error('end_selection')
                <a style="color: red"><small>{{ $message }}</small></a>
              @enderror
            </div> --}}

            </div>
            <div class="col-md-12">

              <div class="my-2">
                <label class="form-label" for="interviewer">Pewawancara</label>
                <textarea id="interviewer" name="interviewer" rows="3"
                  class="form-control @error('interviewer') is-invalid @enderror" readonly> {{ old('interviewer', $selection->interviewer) }} </textarea>
                @error('interviewer')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label class="form-label" for="description">Keterangan</label>
                <textarea id="description" name="descriptions" rows="5"
                  class="form-control @error('description') is-invalid @enderror" readonly>{{ old('description', $selection->description) }} </textarea>
                @error('description')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label class="form-label" for="fptk_number">Nomor FPTK</label>
                <input type="text" id="fptk_number" name="fptk_number" value="{{ $selection->fptk_number }}"
                  class="form-control @error('fptk_number') is-invalid @enderror" readonly>
                @error('fptk_number')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label for="file_fptk" class="form-label">File FPTK :</label>
                @if ($selection->file_fptk)
                  <a href="{{ asset('storage/' . $selection->file_fptk) }}" target="_blank"
                    class="text-sm btn btn-sm btn-primary my-2 mx-3">
                    Lihat File
                  </a>
                @else
                  <span>-</span>
                @endif

                @error('file_fptk')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror

              </div>

              {{-- <div class="mb-2">
              <label for="file_selection" class="form-label">File Seleksi :</label>
              <input class="form-control @error('file_selection') is-invalid @enderror" accept=".pdf" type="file"
                id="file_selection" name="file_selection">

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

            </div> --}}
            </div>

          </div>

          {{-- <div class="col-12 d-flex justify-content-end mt-4">
          @if (!$selection->is_approve)
            <button class="btn btn-primary me-1 mb-1" onclick="closeSelection({{ $selection->id }})">Tutup
              Seleksi</button>

            <form id="closeSelection_{{ $selection->id }}" action="{{ route('selection.close', $selection) }}"
              method="post" enctype="multipart/form-data">
              @csrf
              @method('patch')
              <input type="hidden" name="selected_option" id="selectedOptionInput_{{ $selection->id }}"
                value="">
            </form>
          @endif
          <a class="btn btn-light-secondary me-1 mb-1" href="{{ route('selection.index') }}">Cancel</a>
        </div> --}}

        </div>
        <div class="col-12 d-flex justify-content-end mt-4">
          <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
          <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
        </div>
      </div>
    </div>
  </form>

  <div class="card">
    <div class="card-header">

      <div class="d-flex justify-content-between align-items-center ">
        <h5 class="fw-normal my-3 text-body">Tahapan Seleksi</h5>
        @if (!$selection->is_approve)
          @role(['staff', 'senior-officer', 'super-admin'])
            <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
              data-bs-target="#modal-form-history-selection">
              <i class="bi bi-plus-lg"></i>
              Tahapan Seleksi
            </button>
            @include('pages.recruitment.selection.modal-history')
          @endrole
        @endif
      </div>

    </div>
    <div class="card-body">
      <div class="row justify-content-center">
        <div class="col-md-12">
          <table class="table table-striped" id="table2" style="font-size: 85%">
            <thead>
              <tr>
                <th></th>
                <th>Tanggal</th>
                <th>Proses</th>
                <th>Keterangan</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($selection->historySelections as $historySelection)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ Carbon\Carbon::parse($historySelection->date)->translatedFormat('l, d F Y') ?? '-' }}</td>
                  <td>{{ $historySelection->name_process }}</td>
                  <td>{{ $historySelection->description }}</td>
                  <td>
                    @if (!$selection->is_approve)
                      <button class="btn btn-danger mx-2" onclick="deleteHistory('{{ $historySelection->id }}')"><i
                          class="bi bi-trash"></i></button>

                      <form id="historyDeleteForm_{{ $historySelection->id }}"
                        action="{{ route('historySelection.destroy', $historySelection->id) }}" method="POST">
                        @method('DELETE')
                        @csrf
                      </form>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header">

      @if (!$selection->is_approve)
      @endif
      <div class="d-flex justify-content-between align-items-center ">
        <div class="d-flex justify-content-between align-items-center ">
          <h5 class="fw-normal my-3 text-body">Daftar Kandidat</h5>
        </div>
      </div>

    </div>
    <div class="card-body">
      <div class="row justify-content-center">
        <div class="col-md-12">

          <table class="table table-striped" id="table1" style="font-size: 85%">
            <thead>
              <tr>
                <th></th>
                <th>Pelamar</th>
                <th>Email</th>
                <th>Phone</th>
                {{-- <th>Status</th> --}}
                <th>Jabatan</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($selectedCandidates as $selectedCandidate)
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
                  {{-- <td>
                      @if ($selectedCandidate->is_approve)
                        <span class="badge bg-primary mt-1">Disetujui</span>
                      @elseif ($selectedCandidate->is_approve === 0)
                        <span class="badge bg-danger mt-1">Ditolak</span>
                      @else
                        -
                      @endif
                    </td> --}}
                  <td>
                    @if ($selectedCandidate->position_id)
                      <span class="badge bg-primary">{{ $selectedCandidate->position->name }}</span>
                    @else
                      -
                    @endif
                  </td>
                  <td>
                    <div class="btn-group mb-1">

                      <a data-bs-toggle="modal"
                        data-bs-target="#modal-form-edit-result-selection-{{ $selectedCandidate->id }}"
                        class="btn btn-sm btn-icon btn-secondary text-white">
                        <i class="bi bi-pencil-square"></i>
                      </a>

                      @include('pages.recruitment.selection.modal-result')

                      @if ($selectedCandidate->position_id)
                        @role('super-admins')
                          <div class="dropdown">
                            <button class="btn btn-sm btn-primary dropdown-toggle me-1" type="button"
                              id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                              aria-expanded="false">
                              <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            {{-- <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
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
                                action="{{ route('selectedCandidate.approve', $selectedCandidate->id) }}" method="POST"
                                style="display: none;">
                                @csrf
                                @method('patch')
                              </form>

                              <form id="rejectForm_{{ $selectedCandidate->id }}"
                                action="{{ route('selectedCandidate.reject', $selectedCandidate->id) }}" method="POST"
                                style="display: none;">
                                @csrf
                                @method('patch')
                              </form>

                            </div> --}}

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
                                <input type="hidden" name="is_approve" value="1"> <!-- Approve value -->
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

                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header">

      <h5>Hasil Akhir Seleksi</h5>

    </div>
    <div class="card-body">
      <div class="row justify-content-center">
        <div class="col-md-12">

          <div class="mb-2">
            <label for="file_selection" class="form-label">Upload File Seleksi</label>

            <div class="input-group">
              <label class="btn btn-secondary" for="file_selection">Pilih File</label>
              <input type="text" class="form-control" id="file_name_display" placeholder="No file selected"
                readonly>
            </div>

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

          <div class="col-12 d-flex justify-content-end mt-4">
            @role(['staff', 'senior-officer', 'super-admin'])
              <button class="btn btn-primary me-1 mb-1" onclick="closeSelection({{ $selection->id }})">Tutup
                Seleksi</button>

              <form id="closeSelection_{{ $selection->id }}" action="{{ route('selection.close', $selection) }}"
                method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')

                <input class="form-control @error('file_selection') is-invalid @enderror" accept=".pdf" type="file"
                  id="file_selection" name="file_selection" hidden>

                <input type="hidden" name="selected_option" id="selectedOptionInput_{{ $selection->id }}"
                  value="">
              </form>
            @endrole
            @if (!$selection->is_approve)
            @endif
            <a class="btn btn-light-secondary me-1 mb-1" href="{{ route('selection.index') }}">Cancel</a>
          </div>

        </div>
      </div>
    </div>
  </div>

</section>



{{-- <script>
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
</script> --}}

<script>
  function closeSelection(getId) {
    Swal.fire({
      title: 'Tutup Seleksi?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes!',
      html: `
        <label for="selectionOption" hidden>Choose an option:</label>
        <select id="selectionOption" class="swal2-select" hidden>
          <option value="1">Kandidat Terpilih</option>
          <option value="0">Tidak Ada kandidat Terpilih</option>
        </select>
      `,
      preConfirm: () => {
        const selectedOption = document.getElementById('selectionOption').value;
        if (!selectedOption) {
          Swal.showValidationMessage('You need to select an option');
        }
        return selectedOption;
      }
    }).then((result) => {
      if (result.isConfirmed) {
        // Get the selected option (A or B)
        const selectedOption = result.value;

        // Set the selected option in the hidden input field
        document.getElementById('selectedOptionInput_' + getId).value = selectedOption;

        // Submit the corresponding form
        document.getElementById('closeSelection_' + getId).submit();
      }
    });
  }

  function deleteHistory(getId) {
    Swal.fire({
      title: 'Are you sure?',
      text: 'You won\'t be able to revert this!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        // If the user clicks "Yes, delete it!", submit the corresponding form
        document.getElementById('historyDeleteForm_' + getId).submit();
      }
    });
  }
</script>

{{-- <script>
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
</script> --}}

<script>
  function confirmAction(action, message, candidateId) {
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
          document.getElementById('approveForm_' + candidateId).submit();
        } else if (action === 'reject') {
          document.getElementById('rejectForm_' + candidateId).submit();
        }
      }
    });
  }
</script>

{{-- <script>
  function editAlert(getId) {
    Swal.fire({
      title: 'Tutup Seleksi?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes!'
    }).then((result) => {
      if (result.isConfirmed) {
        // Redirect to the edit route using Blade's route helper
        window.location.href = "{{ route('candidate.edit', ':id') }}".replace(':id', getId);
      }
    });
  }
</script> --}}


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

<script>
  document.getElementById('file_selection').addEventListener('change', function() {
    const fileInput = this;
    const fileNameDisplay = document.getElementById('file_name_display');

    if (fileInput.files.length > 0) {
      fileNameDisplay.value = fileInput.files[0].name;
    } else {
      fileNameDisplay.value = "No file selected";
    }
  });
</script>

<style>
  /* .input-group {
  display: flex;
  align-items: center;
  gap: 10px;
  } */

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
