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
                  <label class="form-label" for="name">Nama Seleksi <code>*</code></label>
                  <input id="name" name="name" value="{{ old('name', $selection->name) }}"
                    class="form-control @error('name') is-invalid @enderror" required>
                  @error('name')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>
                <div class="mb-2">
                  <label class="form-label" for="division_id">Divisi Pemohon <code>*</code></label>
                  <select id="division_id" name="division_id" value="{{ old('division_id') }}"
                    class="form-control choices @error('division_id') is-invalid @enderror" required>
                    <option value="" selected disabled>Choose</option>
                    @foreach ($divisions as $division)
                      <option value="{{ $division->id }}"
                        {{ old('division_id', $selection->division_id) == $division->id ? 'selected' : '' }}>
                        {{ $division->name }}
                      </option>
                    @endforeach
                  </select>
                  @error('division_id')
                    <a style="color: red"><small>{{ $message }}</small></a>
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

                {{--
                @if ($selection->selectedPositions)
                  <div class="my-2">
                    <label class="form-label" for="list-group">Jabatan yang dipilih</label>
                    <ul class="list-group">
                      <div class="row">
                        @forelse ($selection->selectedPositions as $position)
                          <div class="col-md-6">
                            <li class="list-group-item"><i class="bi bi-dot"></i> {{ $position->name }}</li>
                          </div>
                        @empty
                          <div class="col-md-12">
                            <li class="list-group-item"><i class="bi bi-dot"></i> Tidak ada jabatan yang dipilih</li>
                          </div>
                        @endforelse
                      </div>
                    </ul>
                    @error('position_id')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>
                @endif --}}

                <div class="my-2">
                  <label class="form-label" for="start_selection">Tgl Mulai Seleksi</label>
                  <input type="date" id="start_selection" name="start_selection"
                    value="{{ old('start_selection', $selection->start_selection) }}"
                    class="form-control @error('start_selection') is-invalid @enderror">
                  @error('start_selection')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>
                {{-- <div class="mb-2">
                  <label class="form-label" for="end_selection">Tgl Selesai Seleksi</label>
                  <input type="date" id="end_selection" name="end_selection"
                    value="{{ old('end_selection', $selection->end_selection) }}"
                    class="form-control @error('end_selection') is-invalid @enderror">
                  @error('end_selection')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div> --}}

              </div>
              <div class="col-md-12">

                <div class="mb-2">
                  <label class="form-label" for="interviewer">Pewawancara <code>*</code></label>
                  <textarea id="interviewer" name="interviewer" rows="3"
                    class="form-control @error('interviewer') is-invalid @enderror" required>{{ old('interviewer', $selection->interviewer) }} </textarea>
                  @error('interviewer')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>

                <div class="mb-2">
                  <label class="form-label" for="description">Keterangan</label>
                  <textarea id="description" name="description" rows="5"
                    class="form-control @error('description') is-invalid @enderror">{{ old('description', $selection->description) }} </textarea>
                  @error('description')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>

                <div class="mb-2">
                  <label class="form-label" for="fptk_number">Nomor FPTK <code>*</code></label>
                  <input id="fptk_number" name="fptk_number" value="{{ old('fptk_number', $selection->fptk_number) }}"
                    class="form-control @error('fptk_number') is-invalid @enderror" required>
                  @error('fptk_number')
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



  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between align-items-center ">
        <h5 class="fw-normal my-3 text-body">History Seleksi</h5>
        <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
          data-bs-target="#modal-form-history-selection">
          <i class="bi bi-plus-lg"></i>
          History Seleksi
        </button>
        @include('pages.recruitment.selection.modal-history')
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
                  <td> <button class="btn btn-danger mx-2" onclick="deleteHistory('{{ $historySelection->id }}')"><i
                        class="bi bi-trash"></i></button>

                    <form id="historyDeleteForm_{{ $historySelection->id }}"
                      action="{{ route('historySelection.destroy', $historySelection->id) }}" method="POST">
                      @method('DELETE')
                      @csrf
                    </form>
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
      <div class="d-flex justify-content-between align-items-center ">
        <h5 class="fw-normal my-3 text-body">Daftar Kandidat</h5>
        <a class="btn btn-primary btn-md mb-2" onclick="openMyModalEdit({{ $selection->id }})">
          <i class="bi bi-plus-lg"></i>
          Kandidat
        </a>
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
                    @if ($dataCount > 1)
                      <button class="btn btn-danger mx-2"
                        onclick="destroyCandidate('{{ $selectedCandidate->id }}', {{ $dataCount }})">
                        <i class="bi bi-trash"></i>
                      </button>

                      <form id="deleteForm_{{ $selectedCandidate->id }}"
                        action="{{ route('selectedCandidate.destroy', $selectedCandidate->id) }}" method="POST">
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









</section>

<div id="modal-form-add-candidate-edit-{{ $selection->id }}" class="modal fade" tabindex="-1"
  aria-labelledby="modal-form-add-candidate-edit-{{ $selection->id }}-label" aria-hidden="true"
  style="display: none;">
  <div class="modal-dialog modal-dialog-centered modal-fullscreen">
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
            <table class="table table-striped" id="table-candidate" style="font-size: 85%; width: 100%">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col"></th>
                  <th scope="col">Pelamar</th>
                  <th scope="col">Usia</th>
                  <th scope="col">Jenis Kelamin</th>
                  <th scope="col">Phone</th>
                  <th scope="col">Posisi yang dilamar</th>
                  <th scope="col">Pendidikan</th>
                  <th scope="col">Jurusan</th>
                  <th scope="col">Penyandang Disabilitas</th>
                  <th scope="col">Status Perkawinan</th>
                  <th scope="col">Tag</th>
                  <th scope="col"></th>
                </tr>
                <tr>
                  <th scope="col">
                  </th>
                  <th scope="col"><a id="resetFilter" class="btn btn-primary btn-sm">Reset</a></th>
                  <th scope="col">
                    <textarea type="text" class="form-control form-control-sm" id="nameSearch" placeholder="search ..."></textarea>
                  </th>
                  <th scope="col">
                    <input type="text" oninput="this.value = this.value.replace(/\D+/g, '')" maxlength="2"
                      class="form-control form-control-sm" id="ageSearch" placeholder="search ..."></input>
                  </th>
                  <th scope="col">
                    <select type="text" id="genderFilter" class="form-control form-control-sm"
                      style="width: 100%">
                      <option value="" disabled selected>Choose</option>
                      <option value="LAKI-LAKI">LAKI-LAKI</option>
                      <option value="PEREMPUAN">PEREMPUAN</option>
                    </select>
                  </th>
                  <th scope="col">
                    <textarea type="text" class="form-control form-control-sm" id="phoneSearch" placeholder="search ..."></textarea>
                  </th>
                  <th scope="col">
                    <textarea type="text" class="form-control form-control-sm" id="appPositionSearch" placeholder="search ..."></textarea>
                  </th>
                  <th scope="col">
                    <select type="text" id="educateFilter" class="form-control form-control-sm"
                      style="width: 100%">
                      <option value="" disabled selected>Choose</option>
                      <option value="S-3"> S-3 </option>
                      <option value="S-2"> S-2 </option>
                      <option value="S-1"> S-1 </option>
                      <option value="D-4"> D-4 </option>
                      <option value="D-3"> D-3 </option>
                      <option value="D-2"> D-2 </option>
                      <option value="D-1"> D-1 </option>
                      <option value="MA"> MA </option>
                      <option value="SMK"> SMK </option>
                      <option value="SMA"> SMA </option>
                      <option value="MTS"> MTS </option>
                      <option value="SMP"> SMP </option>
                      <option value="SD"> SD </option>
                    </select>
                  </th>
                  <th scope="col">
                    <textarea type="text" class="form-control form-control-sm" id="studySearch" placeholder="search ..."></textarea>
                  </th>
                  <th scope="col">
                    <textarea type="text" class="form-control form-control-sm" id="disabilitySearch" placeholder="search ..."></textarea>
                  </th>
                  <th scope="col">
                    <select type="text" id="maritalFilter" class="form-control form-control-sm"
                      style="width: 100%">
                      <option value="" disabled selected>Choose</option>
                      <option value="Kawin">Kawin</option>
                      <option value="Belum Kawin">
                        Belum Kawin</option>
                      <option value="Cerai Hidup">
                        Cerai Hidup</option>
                      <option value="Cerai Mati">
                        Cerai Mati</option>
                    </select>
                  </th>
                  <th scope="col" colspan="2">
                    <textarea type="text" class="form-control form-control-sm" id="tagSearch" placeholder="search ..."></textarea>
                  </th>

                </tr>
              </thead>
              <tbody>
                {{-- @foreach ($candidates as $candidate)
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
                @endforeach --}}
              </tbody>
            </table>


          </div>
        </div>
        <input type="hidden" name="selected_candidate" id="selected_candidate" value="">
      </form>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>



<script>
  function openMyModalEdit(selectionId) {
    let modalId = `modal-form-add-candidate-edit-${selectionId}`;
    let myModal = new bootstrap.Modal(document.getElementById(modalId), {});
    myModal.show();
  }

  // function confirmSelection(candidateId, candidateName) {
  //   // alert('Button clicked for candidate: ' + candidateName); // Test alert

  //   if (confirm('Apakah Anda yakin ingin memilih ' + candidateName + ' sebagai kandidat?')) {
  //     document.getElementById('selected_candidate').value = candidateId;
  //     document.getElementById('candidateSelectionForm').submit();
  //   }
  // }

  function addCandidate(getId, getName) {
    Swal.fire({
      // title: 'Are you sure?',
      text: 'Apakah Anda yakin ingin memilih ' + getName + ' sebagai kandidat?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, select it!'
    }).then((result) => {
      if (result.isConfirmed) {
        // Set the selected candidate ID into the hidden input field
        document.getElementById('selected_candidate').value = getId;
        // Submit the form
        document.getElementById('candidateSelectionForm').submit();
      }
    });
  }
</script>

@push('after-script')
  <script>
    // Initialize DataTable for candidate listing
    jQuery(document).ready(function($) {
      const table = $('#table-candidate').DataTable({
        searching: false,
        processing: true,
        serverSide: true,
        ordering: false,
        pageLength: 10,
        lengthMenu: [
          [10, 25, 50, 100, -1],
          [10, 25, 50, 100, 'All']
        ], // Add 'All' option to the length menu
        ajax: {
          url: "{{ route('selection.getCandidate') }}",
          data: function(d) {
            d.name = $('#nameSearch').val();
            d.age = $('#ageSearch').val();
            d.gender = $('#genderFilter').val();
            d.phone_number = $('#phoneSearch').val(); // Should match the database column
            d.applied_position = $('#appPositionSearch').val();
            d.last_educational = $('#educateFilter').val();
            d.study = $('#studySearch').val();
            d.disability = $('#disabilitySearch').val();
            d.marital_status = $('#maritalFilter').val();
            d.tag = $('#tagSearch').val();
            console.log(d);
          }
        },
        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false,
            width: '5%'
          },
          {
            data: 'photo',
            name: 'photo'
          },
          {
            data: 'name',
            name: 'name'
          },
          {
            data: 'age',
            name: 'age'
          },
          {
            data: 'gender',
            name: 'gender'
          },
          {
            data: 'phone_number',
            name: 'phone_number'
          },
          {
            data: 'applied_position',
            name: 'applied_position'
          },
          {
            data: 'last_educational',
            name: 'last_educational'
          },
          {
            data: 'study',
            name: 'study'
          },
          {
            data: 'disability',
            name: 'disability'
          },
          {
            data: 'marital_status',
            name: 'marital_status'
          },
          {
            data: 'tag',
            name: 'tag'
          },
          {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false,
            className: 'no-print'
          }
        ],
        columnDefs: [{
          className: 'text-center',
          targets: '_all'
        }],
      });

      $('#nameSearch').keyup(function() {
        table.draw();
      });
      $('#ageSearch').keyup(function() {
        table.draw();
      });
      // Event listener for the year filter dropdown
      $('#genderFilter').change(function() {
        table.draw();
      });
      // Event listener for the regarding search input
      $('#phoneSearch').keyup(function() {
        table.draw();
      });
      // Event listener for the regarding search input
      $('#appPositionSearch').keyup(function() {
        table.draw();
      });
      $('#educateFilter').change(function() {
        table.draw();
      });
      $('#studySearch').keyup(function() {
        table.draw();
      });
      // Event listener for the regarding search input
      $('#disabilitySearch').keyup(function() {
        table.draw();
      });
      $('#maritalFilter').change(function() {
        table.draw();
      });
      $('#tagSearch').keyup(function() {
        table.draw();
      });

      // Event listener for the reset button
      $('#resetFilter').click(function() {
        $('#nameSearch').val(''); // Clear the regarding search input
        $('#ageSearch').val(''); // Clear the regarding search input
        $('#genderFilter').val(''); // Clear the regarding search input
        $('#phoneSearch').val(''); // Clear the regarding search input
        $('#appPositionSearch').val(''); // Clear the regarding search input
        $('#educateFilter').val(''); // Clear the regarding search input
        $('#studySearch').val(''); // Clear the regarding search input
        $('#disabilitySearch').val(''); // Clear the regarding search input
        $('#maritalFilter').val(''); // Clear the regarding search input
        $('#tagSearch').val(''); // Clear the regarding search input
        table.draw(); // Redraw the table
      });
    });
  </script>
@endpush


<script>
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
<script>
  function destroyCandidate(getId, dataCount) {
    if (dataCount <= 1) {
      Swal.fire({
        title: 'Error!',
        text: 'Cannot delete the last remaining item!',
        icon: 'error',
        confirmButtonText: 'OK'
      });
      return; // Stop the process if there is only one item
    }

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
