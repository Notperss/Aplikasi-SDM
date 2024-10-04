<!-- Modals add menu -->
<div id="modal-form-edit-allowance-{{ $allowance->id }}" class="modal fade" tabindex="-1"
  aria-labelledby="modal-form-edit-allowance-{{ $allowance->id }}-label" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('allowance.update', $allowance) }}" method="post">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-edit-allowance-{{ $allowance->id }}-label">
            Edit Data Tunjangan
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>

        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-11"> <!-- Make form smaller with col-md-6 and center it -->

              <div class="row">
                <div class="col-md-6">
                  <div class="my-2">
                    <label class="form-label" for="name">Nama Tunjangan</label>
                    <input id="name" name="name" value="{{ $allowance->name }}"
                      class="form-control @error('name') is-invalid @enderror" required>
                    @error('name')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>

                  <div class="mb-2">
                    <label class="form-label" for="type">Tipe Tunjangan</label>
                    <select id="type_{{ $allowance->id }}" name="type"
                      class="form-control @error('type') is-invalid @enderror" required>
                      <option value="" disabled selected>Choose</option>
                      <option value="PERUSAHAAN"{{ old('type', $allowance->type) == 'PERUSAHAAN' ? 'selected' : '' }}>
                        PERUSAHAAN</option>
                      <option value="BPJS"{{ old('type', $allowance->type) == 'BPJS' ? 'selected' : '' }}>BPJS
                      </option>
                      <option value="NON-BPJS"{{ old('type', $allowance->type) == 'NON-BPJS' ? 'selected' : '' }}>
                        NON-BPJS</option>
                    </select>
                    @error('type')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>

                  <div class="my-2" id="natura-field-{{ $allowance->id }}" style="display:none;">
                    <label class="form-label" for="natura_{{ $allowance->id }}">Tipe Tunjangan Perusahaan</label>
                    <select id="natura_{{ $allowance->id }}" name="natura"
                      class="form-control @error('natura.' . $allowance->id) is-invalid @enderror">
                      <option value="">-</option>
                      <option value="NATURA"
                        {{ old('natura.' . $allowance->id, $allowance->natura) == 'NATURA' ? 'selected' : '' }}>NATURA
                      </option>
                      <option value="NON-NATURA"
                        {{ old('natura.' . $allowance->id, $allowance->natura) == 'NON-NATURA' ? 'selected' : '' }}>
                        NON-NATURA</option>
                    </select>
                    @error('natura.' . $allowance->id)
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="my-2">
                    <label class="form-label" for="level_id">Level</label>
                    <select id="level_id" name="level_id" class="form-control @error('level_id') is-invalid @enderror"
                      required>
                      <option value="" disabled selected>Choose</option>
                      @foreach ($levels as $level)
                        <option value="{{ $level->id }}"
                          {{ $level->id == $allowance->level_id ? 'selected' : '' }}>
                          {{ $level->name }}</option>
                      @endforeach
                    </select>
                    @error('level_id')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>

                  <div class="mb-2">
                    <label for="amount">Jumlah</label>
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="amount">Rp. </span>
                      <input type="text" id="amount" value="{{ old('amount', $allowance->amount) }}"
                        oninput="this.value = this.value.replace(/\D+/g, '')"
                        class="form-control @error('amount') is-invalid @enderror" name="amount">
                    </div>
                    @error('amount')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>

                  <div class="my-2" hidden>
                    <label class="form-label" for="efective_date">Tanggal Lahir</label>
                    <input type="date" id="efective_date" name="efective_date"
                      value="{{ old('efective_date', $allowance->date_efective) }}"
                      class="form-control flatpickr-no-config @error('efective_date') is-invalid @enderror"
                      placeholder="Select date..">
                    @error('efective_date')
                      <a style="color: red">
                        <small>
                          {{ $message }}
                        </small>
                      </a>
                    @enderror
                  </div>

                </div>
              </div>

              <div class="row">
                <div class="my-2">
                  <label class="form-label" for="description">Deskirpsi</label>
                  <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror"> {{ $allowance->description }}</textarea>
                  @error('description')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
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


<script>
  $(document).ready(function() {
    @foreach ($allowances as $allowance)
      // Initially hide the natura field
      $('#natura-field-{{ $allowance->id }}').hide();

      // Handle the change event for the type dropdown specific to each allowance
      $('#type_{{ $allowance->id }}').change(function() {
        var selectedType = $(this).val();
        // Show the natura field if "PERUSAHAAN" is selected
        if (selectedType === 'PERUSAHAAN') {
          $('#natura-field-{{ $allowance->id }}').show();
        } else {
          // Hide the natura field and reset its value
          $('#natura-field-{{ $allowance->id }}').hide();
          $('#natura_{{ $allowance->id }}').val(null);
        }
      });

      // Show natura field if 'PERUSAHAAN' is already selected on load
      if ($('#type_{{ $allowance->id }}').val() === 'PERUSAHAAN') {
        $('#natura-field-{{ $allowance->id }}').show();
      }
    @endforeach
  });
</script>
