<!-- Modals add menu -->
<div id="modal-form-edit-selection-{{ $selection->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
  class="modal fade" tabindex="-1" aria-labelledby="modal-form-edit-selection-{{ $selection->id }}-label"
  aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <form action="{{ route('selection.update', $selection) }}" method="post">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-edit-selection-{{ $selection->id }}-label">
            Edit Data Direktorat
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>

        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-11"> <!-- Make form smaller with col-md-6 and center it -->

              <div class="row">

                <div class="col-md-6">
                  <div class="my-2">
                    <label class="form-label" for="name">Nama Seleksi <code>*</code></label>
                    <input id="name" name="name" value="{{ old('name') }}"
                      class="form-control @error('name') is-invalid @enderror" required>
                    @error('name')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>
                  <div class="mb-2">
                    <label class="form-label" for="pic_selection">PIC Divisi Pemohon <code>*</code></label>
                    <input id="pic_selection" name="pic_selection" value="{{ old('pic_selection') }}"
                      class="form-control @error('pic_selection') is-invalid @enderror" required>
                    @error('pic_selection')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>
                  <div class="mb-2">
                    <label class="form-label" for="interviewer">Pewawancara <code>*</code></label>
                    <input id="interviewer" name="interviewer" value="{{ old('interviewer') }}"
                      class="form-control @error('interviewer') is-invalid @enderror" required>
                    @error('interviewer')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="my-2">
                    <label class="form-label" for="position_id">Jabatan <code>*</code></label>
                    <select id="position_id" name="position_id"
                      class="form-control @error('position_id') is-invalid @enderror" required>
                      <option value="" disabled selected>Choose</option>
                      @foreach ($positions as $position)
                        <option value="{{ $position->id }}" {{ old('position_id') ? 'selection' : '' }}>
                          {{ $position->name }}</option>
                      @endforeach
                    </select>
                    @error('position_id')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>
                  <div class="my-2">
                    <label class="form-label" for="start_selection">Tgl Mulai Seleksi <code>*</code></label>
                    <input type="date" id="start_selection" name="start_selection"
                      value="{{ old('start_selection') }}"
                      class="form-control @error('start_selection') is-invalid @enderror" required>
                    @error('start_selection')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>
                  <div class="mb-2">
                    <label class="form-label" for="end_selection">Tgl Selesai Seleksi</label>
                    <input type="date" id="end_selection" name="end_selection" value="{{ old('end_selection') }}"
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
                      class="form-control @error('description') is-invalid @enderror">{{ old('description') }} </textarea>
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
                  </div>
                </div>

              </div>

              <hr>

              <a class="btn btn-primary btn-md" onclick="openMyModalEdit({{ $selection->id }})">
                <i class="bi bi-plus-lg"></i>
                kandidat
              </a>


              <div class="col-md-12">
                <table class="table table-striped" id="editSelectedCandidatesTable" style="font-size: 85%">
                  <thead>
                    <tr>
                      <th>Pelamar</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    {{-- @foreach ($selection->SelectedCandidates as $candidate)
                      <tr>
                        <td>{{ $candidate->candidate->name }}</td>
                        <td>{{ $candidate->candidate->email }}</td>
                        <td>{{ $candidate->candidate->phone_number }}</td>
                        <td>Action</td>
                      </tr>
                    @endforeach --}}
                  </tbody>
                </table>
              </div>

            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary ">Save</button>
        </div>
      </form>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="modal-form-add-candidate-edit-{{ $selection->id }}" class="modal fade" tabindex="-1"
  aria-labelledby="modal-form-add-candidate-edit-{{ $selection->id }}-label" aria-hidden="true"
  style="display: none;">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">

      <div class="card">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center ">
            <h5 class="fw-normal mb-0 text-body">Daftar Pelamar</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
          </div>
        </div>
        <div class="card-body">
          <table class="table table-striped" id="table4-{{ $selection->id }}" style="font-size: 85%">
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
                      <button class="btn btn-sm btn-primary ">
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

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

<script>
  function openMyModalEdit(selectionId) {
    let modalId = `modal-form-add-candidate-edit-${selectionId}`;
    let myModal = new bootstrap.Modal(document.getElementById(modalId), {});
    myModal.show();
  }
</script>
{{-- <script>
  document.addEventListener('DOMContentLoaded', function() {
    @foreach ($selections as $selection)
      let jquery_datatable_{{ $selection->id }} = $("#table4-{{ $selection->id }}").DataTable({
        responsive: true,
      });
    @endforeach
  });
</script> --}}
