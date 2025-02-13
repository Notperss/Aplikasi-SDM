<!-- Modals add menu -->
<div id="modal-form-edit-result-selection-{{ $selectedCandidate->id }}" class="modal fade" tabindex="-1"
  aria-labelledby="modal-form-edit-result-selection-{{ $selectedCandidate->id }}-label" aria-hidden="true"
  style="display: none;">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <form action="{{ route('selectedCandidate.update', $selectedCandidate) }}" method="post"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-edit-result-selection-{{ $selectedCandidate->id }}-label">
            {{ $selectedCandidate->candidate->name }}
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>

        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-11"> <!-- Make form smaller with col-md-6 and center it -->

              <div class="row">
                <div class="col-md-12 my-2">
                  {{-- <div class="my-2">
                    <input type="radio" class="btn-check" value="1" name="result_selection"
                      id="primary-outlined-{{ $selectedCandidate->id }}" autocomplete="off"
                      @checked($selectedCandidate->candidate->is_hire)>
                    <label class="btn btn-outline-primary"
                      for="primary-outlined-{{ $selectedCandidate->id }}">Hired</label>

                    <input type="radio" class="btn-check" value="0" name="result_selection"
                      id="danger-outlined-{{ $selectedCandidate->id }}" autocomplete="off" @checked($selectedCandidate->candidate->is_hire === false)>
                    <label class="btn btn-outline-danger"
                      for="danger-outlined-{{ $selectedCandidate->id }}">Failed</label>
                  </div> --}}

                  <div class="my-2">
                    <label class="form-label" for="position_id">Jabatan</label>
                    <select id="position_id" name="position_id"
                      class="form-control choices @error('position_id') is-invalid @enderror ">
                      <option value="" selected>Tidak Ada</option>

                      @foreach ($selectedPositions as $selectedPosition)
                        <option value="{{ $selectedPosition->id }}"
                          {{ $selectedCandidate->position_id == $selectedPosition->id ? 'selected' : '' }}>
                          {{ $selectedPosition->name }}
                        </option>
                      @endforeach

                    </select>
                    @error('position_id')
                      <div style="color: red"><small>{{ $message }}</small></div>
                    @enderror
                  </div>

                  {{-- @if ($selectedCandidate->position_id)
                    <div class="mb-2">
                      <label class="form-label" for="position">Jabatan Yang Dipilih</label>
                      <input id="position" value="{{ $selectedCandidate->position->name ?? 'No position selected' }}"
                        class="form-control @error('position') is-invalid @enderror" readonly>
                    </div>
                  @endif --}}


                  <div class="mb-2">
                    <label class="form-label" for="description">Keterangan Hasil Seleksi</label>
                    <textarea id="description" name="description" rows="5"
                      class="form-control @error('description') is-invalid @enderror">{{ old('description', $selectedCandidate->description) }} </textarea>
                    @error('description')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>

                  <div class="mb-2">
                    <label for="file_selected_candidate" class="form-label">File</label>
                    <input class="form-control @error('file_selected_candidate') is-invalid @enderror"
                      accept=".pdf, .png, .jpeg, .jpg" type="file" id="file_selected_candidate"
                      name="file_selected_candidate">
                    @if ($selectedCandidate->file_selected_candidate)
                      <a href="{{ asset('storage/' . $selectedCandidate->file_selected_candidate) }}" target="_blank"
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
        </div>
        @if (!$selection->is_approve)
          @can('selection.result-selection')
            <div class="modal-footer">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary ">Save</button>
            </div>
          @endcan
        @endif
      </form>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
