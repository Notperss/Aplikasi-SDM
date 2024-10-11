<!-- Modals add menu -->
<div id="modal-form-position-allowance-{{ $position->id }}" class="modal fade" tabindex="-1"
  aria-labelledby="modal-form-position-allowance-{{ $position->id }}-label" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('positionAllowance', $position) }}" method="post">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-position-allowance-{{ $position->id }}-label">
            Tambah Tunjangan Jabatan
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>

        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-11"> <!-- Make form smaller with col-md-6 and center it -->

              <div class="row">
                <div class="col-md-4">
                  <div class="mb-2">
                    <label class="form-label" for="name">Direktorat</label>
                    <input id="name" value="{{ $position->directorate->name }}"
                      class="form-control @error('name') is-invalid @enderror" readonly>
                    @error('name')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>

                  <div class="mb-2">
                    <label class="form-label" for="name">Divisi</label>
                    <input id="name" value="{{ $position->division->name }}"
                      class="form-control @error('name') is-invalid @enderror" readonly>
                    @error('name')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>

                  <div class="mb-2">
                    <label class="form-label" for="name">Departmen</label>
                    <input id="name" value="{{ $position->department->name ?? '-' }}"
                      class="form-control @error('name') is-invalid @enderror" readonly>
                    @error('name')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>

                  <div class="mb-2">
                    <label class="form-label" for="name">Seksi</label>
                    <input id="name" value="{{ $position->section->name ?? '-' }}"
                      class="form-control @error('name') is-invalid @enderror" readonly>
                    @error('name')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>

                </div>
                <div class="col-md-4">
                  <div class="mb-2">
                    <label class="form-label" for="name">Level</label>
                    <input id="name" value="{{ $position->level->name }}"
                      class="form-control @error('name') is-invalid @enderror" readonly>
                    @error('name')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>

                  <div class="mb-2">
                    <label class="form-label" for="name">Nama Jabatan</label>
                    <input id="name" value="{{ $position->name }}"
                      class="form-control @error('name') is-invalid @enderror" readonly>
                    @error('name')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>

                  <div class="my-2">
                    <label class="form-label" for="description">Deskripsi</label>
                    <textarea id="description" class="form-control @error('description') is-invalid @enderror" rows="5" readonly> {{ old('description', $position->description) }} </textarea>
                    @error('description')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="my-2">
                    <label class="form-label" for="allowance_id">Tunjangan</label>
                    <select id="allowance_id" name="allowance_id[]"
                      class="form-control choices multiple-remove @error('allowance_id') is-invalid @enderror"
                      multiple="multiple">
                      <option value="" disabled>Choose</option>
                      @foreach ($allowances->where('level_id', $position->level_id) as $allowance)
                        <option value="{{ $allowance->id }}"
                          {{ in_array($allowance->id, old('allowance_id', $position->allowances->pluck('id')->toArray())) ? 'selected' : '' }}>
                          {{ $allowance->name }}
                        </option>
                      @endforeach
                    </select>
                    @error('allowance_id')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>
                  <div class="my-2">
                    <label for="selected_allowances">Daftar Tunjangan BPJS:</label>
                    <ul id="selected_allowances">
                      @if (!empty($position->allowances()->where('type', 'BPJS')->pluck('allowances.name')->toArray()))
                        @foreach ($position->allowances()->where('type', 'BPJS')->pluck('allowances.name')->toArray() as $allowance)
                          <li>{{ $allowance }}</li>
                        @endforeach
                      @else
                        <li>Tidak ada tunjangan.</li>
                      @endif
                    </ul>
                  </div>
                  <div class="mb-2">
                    <label for="selected_allowances">Daftar Tunjangan NON-BPJS:</label>
                    <ul id="selected_allowances">
                      @if (!empty($position->allowances()->where('type', 'NON-BPJS')->pluck('allowances.name')->toArray()))
                        @foreach ($position->allowances()->where('type', 'NON-BPJS')->pluck('allowances.name')->toArray() as $allowance)
                          <li>{{ $allowance }}</li>
                        @endforeach
                      @else
                        <li>Tidak ada tunjangan.</li>
                      @endif
                    </ul>
                  </div>
                  <div class="my-2">
                    <label for="selected_allowances">Daftar Tunjangan PERUSAHAAN:</label>
                    <ul id="selected_allowances">
                      @if (!empty($position->allowances()->where('type', 'PERUSAHAAN')->pluck('allowances.name')->toArray()))
                        @foreach ($position->allowances()->where('type', 'PERUSAHAAN')->pluck('allowances.name')->toArray() as $allowance)
                          <li>{{ $allowance }}</li>
                        @endforeach
                      @else
                        <li>Tidak ada tunjangan.</li>
                      @endif
                    </ul>
                  </div>
                </div>
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
