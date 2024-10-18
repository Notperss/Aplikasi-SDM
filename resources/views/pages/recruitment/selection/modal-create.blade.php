<!-- Modals add menu -->
<div id="modal-form-add-selection" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="modal-form-add-selection-label" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <form id="selectedCandidatesForm" action="{{ route('selection.store') }}" method="post"
        enctype="multipart/form-data">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-add-selection-label">Tambah Seleksi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>

        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-11"> <!-- Make form smaller with col-md-6 and center it -->

              <div class="row">

                <div class="col-md-6">
                  <div class="my-2">
                    <label class="form-label" for="name">Nama Seleksi</label>
                    <input id="name" name="name" value="{{ old('name') }}"
                      class="form-control @error('name') is-invalid @enderror">
                    @error('name')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>
                  <div class="mb-2">
                    <label class="form-label" for="pic_selection">PIC Divisi Pemohon</label>
                    <input id="pic_selection" name="pic_selection" value="{{ old('pic_selection') }}"
                      class="form-control @error('pic_selection') is-invalid @enderror">
                    @error('pic_selection')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>
                  <div class="mb-2">
                    <label class="form-label" for="interviewer">Pewawancara</label>
                    <input id="interviewer" name="interviewer" value="{{ old('interviewer') }}"
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
                        <option value="{{ $position->id }}" {{ old('position_id') ? 'selection' : '' }}>
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

              <a class="btn btn-primary btn-md" onclick="openMyModal2()">
                <i class="bi bi-plus-lg"></i>
                Kandidat
              </a>

              <input type="hidden" name="candidates" id="candidatesInput">

              <div class="col-md-12">
                <table class="table table-striped" id="selectedCandidatesTable" style="font-size: 85%">
                  <thead>
                    <tr>
                      <th>Pelamar</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- Selected candidates will be appended here -->
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


<div id="modal-form-add-candidate" class="modal fade" tabindex="-1"
  aria-labelledby="modal-form-add-candidate-label" aria-hidden="true" style="display: none;">
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
          <table class="table table-striped" id="table4" style="font-size: 85%">
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
                      <button class="btn btn-sm btn-primary pilih-candidate" data-id="{{ $candidate->id }}"
                        data-name="{{ $candidate->name }}" data-email="{{ $candidate->email }}"
                        data-phone="{{ $candidate->phone_number }}">
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


{{-- @include('pages.recruitment.selection.modal-candidate') --}}

<script>
  function openMyModal2() {
    let myModal = new
    bootstrap.Modal(document.getElementById('modal-form-add-candidate'), {});
    myModal.show();
  }
</script>

{{-- <script>
  // Function to append selected candidate to the table
  document.querySelectorAll('.pilih-candidate').forEach(button => {
    button.addEventListener('click', function() {
      const id = this.getAttribute('data-id');
      const name = this.getAttribute('data-name');
      const email = this.getAttribute('data-email');
      const phone = this.getAttribute('data-phone');

      // Check if the candidate is already added
      if (document.querySelector(`#selectedCandidatesTable tbody tr[data-id="${id}"]`)) {
        alert('Candidate already added!');
        return;
      }

      // Append the candidate to the selected table
      const row = `
        <tr data-id="${id}">
          <td>${name}</td>
          <td>${email}</td>
          <td>${phone}</td>
          <td><button type="button" class="btn btn-sm btn-danger remove-candidate">Remove</button></td>
        </tr>
      `;
      document.querySelector('#selectedCandidatesTable tbody').insertAdjacentHTML('beforeend', row);

      // Attach remove functionality
      attachRemoveFunctionality();
    });
  });

  // Attach functionality to remove a candidate from the selected list
  function attachRemoveFunctionality() {
    document.querySelectorAll('.remove-candidate').forEach(button => {
      button.addEventListener('click', function() {
        this.closest('tr').remove();
      });
    });
  }

  // Handle form submission to send selected candidates
  document.getElementById('selectedCandidatesForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const candidates = [];
    const rows = document.querySelectorAll('#selectedCandidatesTable tbody tr');

    rows.forEach(row => {
      const id = row.getAttribute('data-id');
      const name = row.cells[0].textContent;
      const email = row.cells[1].textContent;
      const phone = row.cells[2].textContent;

      candidates.push({
        id: id,
      });
    });

    // Set the hidden input value to the JSON string of candidates
    document.getElementById('candidatesInput').value = JSON.stringify(candidates);

    // Submit the form
    this.submit();
  });
</script> --}}

<script>
  // Function to handle candidate selection and toggling button
  document.querySelectorAll('.pilih-candidate').forEach(button => {
    button.addEventListener('click', function() {
      const id = this.getAttribute('data-id');
      const name = this.getAttribute('data-name');
      const email = this.getAttribute('data-email');
      const phone = this.getAttribute('data-phone');

      // If the button is in 'Pilih' state
      if (this.textContent.trim() === 'Pilih') {
        // Check if the candidate is already added
        if (document.querySelector(`#selectedCandidatesTable tbody tr[data-id="${id}"]`)) {
          alert('Candidate already added!');
          return;
        }

        // Append the candidate to the selected table
        const row = `
          <tr data-id="${id}">
            <td>${name}</td>
            <td>${email}</td>
            <td>${phone}</td>
            <td><button type="button" class="btn btn-sm btn-danger remove-candidate">Remove</button></td>
          </tr>
        `;
        document.querySelector('#selectedCandidatesTable tbody').insertAdjacentHTML('beforeend', row);

        // Change button text to 'Remove'
        this.textContent = 'Remove';
        this.classList.remove('btn-primary');
        this.classList.add('btn-danger');
      }
      // If the button is in 'Remove' state
      else {
        // Remove the candidate from the selected table
        const row = document.querySelector(`#selectedCandidatesTable tbody tr[data-id="${id}"]`);
        if (row) {
          row.remove();
        }

        // Change button text back to 'Pilih'
        this.textContent = 'Pilih';
        this.classList.remove('btn-danger');
        this.classList.add('btn-primary');
      }
    });
  });

  // Use event delegation for removing a candidate directly from the table
  document.querySelector('#selectedCandidatesTable').addEventListener('click', function(event) {
    if (event.target.classList.contains('remove-candidate')) {
      const row = event.target.closest('tr');
      const id = row.getAttribute('data-id');

      // Remove the row
      row.remove();

      // Change the corresponding 'Remove' button back to 'Pilih'
      const button = document.querySelector(`.pilih-candidate[data-id="${id}"]`);
      if (button) {
        button.textContent = 'Pilih';
        button.classList.remove('btn-danger');
        button.classList.add('btn-primary');
      }
    }
  });

  // Handle form submission to send selected candidates
  document.getElementById('selectedCandidatesForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const candidates = [];
    const rows = document.querySelectorAll('#selectedCandidatesTable tbody tr');

    rows.forEach(row => {
      const id = row.getAttribute('data-id');
      candidates.push({
        id: id,
      });
    });

    // Set the hidden input value to the JSON string of candidates
    document.getElementById('candidatesInput').value = JSON.stringify(candidates);

    // Submit the form
    this.submit();
  });
</script>
