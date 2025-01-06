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
                <div class="col-md-12">
                  <div class="my-2">
                    <label class="form-label" for="name">Nama Seleksi <code>*</code></label>
                    <textarea id="name" name="name" value="{{ old('name') }}"
                      class="form-control @error('name') is-invalid @enderror" rows="3" required> {{ old('name') }} </textarea>
                    @error('name')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>
                </div>

                <div class="col-md-6">

                  <div class="my-2">
                    <label class="form-label" for="position_id">Jabatan <code>*</code></label>
                    <select id="position_id" name="position_id[]"
                      class="form-control choices @error('position_id') is-invalid @enderror multiple-remove"
                      multiple="multiple" required>
                      <option value="" disabled>Choose</option>
                      @foreach ($positions as $position)
                        <option value="{{ $position->id }}" {{ old('position_id') ? 'selection' : '' }}>
                          {{ $position->name }}</option>
                      @endforeach
                    </select>
                    @error('position_id')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>

                  {{-- <div class="mb-2">
                    <label class="form-label" for="interviewer">Pewawancara <code>*</code></label>
                    <textarea id="interviewer" name="interviewer" value="{{ old('interviewer') }}"
                      class="form-control @error('interviewer') is-invalid @enderror" rows="3" required> </textarea>
                    @error('interviewer')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div> --}}
                </div>
                <div class="col-md-6">

                  <div class="my-2">
                    <label class="form-label" for="division_id">Divisi Pemohon <code>*</code></label>
                    <select id="division_id" name="division_id" value="{{ old('division_id') }}"
                      class="form-control choices @error('division_id') is-invalid @enderror" required>
                      <option value="" selected disabled>Choose</option>
                      @foreach ($divisions as $division)
                        <option value="{{ $division->id }}"
                          {{ old('division_id') == $division->id ? 'selected' : '' }}>
                          {{ $division->name }}
                        </option>
                      @endforeach
                    </select>
                    @error('division_id')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>


                  <div class="my-2">
                    <label class="form-label" for="start_selection">Tgl Mulai Seleksi</label>
                    <input type="date" id="start_selection" name="start_selection"
                      value="{{ old('start_selection') }}"
                      class="form-control @error('start_selection') is-invalid @enderror">
                    @error('start_selection')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>
                  {{-- <div class="mb-2">
                    <label class="form-label" for="end_selection">Tgl Selesai Seleksi</label>
                    <input type="date" id="end_selection" name="end_selection" value="{{ old('end_selection') }}"
                      class="form-control @error('end_selection') is-invalid @enderror">
                    @error('end_selection')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div> --}}
                </div>
                <div class="col-md-12">
                  <div class="mb-2">
                    <label class="form-label" for="interviewer">Pewawancara <code>*</code></label>
                    <textarea id="interviewer" name="interviewer" value="{{ old('interviewer') }}"
                      class="form-control @error('interviewer') is-invalid @enderror" rows="3" required> </textarea>
                    @error('interviewer')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>
                  <div class="mb-2">
                    <label class="form-label" for="description">Keterangan</label>
                    <textarea id="description" name="description" rows="5"
                      class="form-control @error('description') is-invalid @enderror">{{ old('description') }} </textarea>
                    @error('description')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>
                  <div class="my-2">
                    <label class="form-label" for="fptk_number">Nomor FPTK <code>*</code></label>
                    <input id="fptk_number" name="fptk_number" value="{{ old('fptk_number') }}"
                      class="form-control @error('fptk_number') is-invalid @enderror" required>
                    @error('fptk_number')
                      <a style="color: red"><small>{{ $message }}</small></a>
                    @enderror
                  </div>
                  <div class="mb-2">
                    <label for="file_fptk" class="form-label">File FPTK</label>
                    <input class="form-control @error('file_fptk') is-invalid @enderror" accept=".pdf" type="file"
                      id="file_fptk" name="file_fptk">
                    @error('file_fptk')
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
  <div class="modal-dialog modal-dialog-centered modal-fullscreen">
    <div class="modal-content">

      <div class="card">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center ">
            <h5 class="fw-normal mb-0 text-body">Daftar Pelamar</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
          </div>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped" id="table-candidate" style="font-size: 85%; width: 100%">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col"></th>
                  <th scope="col">Pelamar</th>
                  <th scope="col">Usia</th>
                  <th scope="col">Jenis Kelamin</th>
                  {{-- <th scope="col">Phone</th>
                  <th scope="col">Posisi yang dilamar</th> --}}
                  <th scope="col">Pendidikan</th>
                  <th scope="col">Jurusan</th>
                  <th scope="col">Penyandang Disabilitas</th>
                  <th scope="col">Status Perkawinan</th>
                  <th scope="col">pernah Seleksi</th>
                  <th scope="col">Tag</th>
                  <th scope="col"></th>
                </tr>
                <tr>
                  <th scope="col">
                  </th>
                  <th scope="col"><button id="resetFilter" class="btn btn-primary btn-sm">Reset</button></th>
                  <th scope="col">
                    <textarea type="text" class="form-control form-control-sm" id="nameSearch" placeholder="search ..."></textarea>
                  </th>
                  {{-- <th scope="col">
                    <input type="text" oninput="this.value = this.value.replace(/\D+/g, '')" maxlength="2"
                      class="form-control form-control-sm" id="ageSearch" placeholder="search ..."></input>
                  </th> --}}
                  <th scope="col">
                    <select id="ageFilter" class="form-control form-control-sm" style="width: 100%">
                      <option value="" selected>Semua</option>
                      <option value="<20">
                        < 20</option>
                      <option value="20-25">20-25</option>
                      <option value="25-35">25-35</option>
                      <option value="35-50">35-50</option>
                      <option value=">50"> > 50</option>
                    </select>
                  </th>
                  <th scope="col">
                    <select type="text" id="genderFilter" class="form-control form-control-sm"
                      style="width: 100%">
                      <option value="" selected>Semua</option>
                      <option value="LAKI-LAKI">LAKI-LAKI</option>
                      <option value="PEREMPUAN">PEREMPUAN</option>
                    </select>
                  </th>
                  {{-- <th scope="col">
                    <textarea type="text" class="form-control form-control-sm" id="phoneSearch" placeholder="search ..."></textarea>
                  </th>
                  <th scope="col">
                    <textarea type="text" class="form-control form-control-sm" id="appPositionSearch" placeholder="search ..."></textarea>
                  </th> --}}
                  <th scope="col">
                    <select type="text" id="educateFilter" class="form-control form-control-sm"
                      style="width: 100%">
                      <option value="" selected>Semua</option>
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
                      <option value="" selected>Semua</option>
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
                    <textarea type="text" class="form-control form-control-sm" id="tagSearch" placeholder="search Tag ..."></textarea>
                  </th>
                  <th scope="col">
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
                          <td>{{ $candidate->gender }}</td>
                          <td>{{ $candidate->phone_number }}</td>
                          <td>{{ $candidate->applied_position }}</td>
                          <td>{{ $candidate->last_educational }}</td>
                          <td>{{ $candidate->study }}</td>
                          <td>{{ $candidate->disability }}</td>
                          <td>{{ $candidate->marital_status }}</td>
                          <td>{{ $candidate->tag }}</td>
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
                @endforeach --}}
              </tbody>
            </table>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
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

@push('after-script')
  {{-- <script>
    jQuery(document).ready(function($) {
      $('#table-candidate').DataTable({
        processing: true,
        serverSide: true,
        ordering: true,
        pageLength: 10, // Show all records by default
        lengthMenu: [
          [10, 25, 50, 100, -1],
          [10, 25, 50, 100, 'All']
        ], // Add 'All' option to the length menu
        ajax: {
          url: "{{ route('selection.index') }}",
        },
        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false,
            width: '5%',
          }, {
            data: 'photo',
            name: 'photo',
          },
          {
            data: 'name',
            name: 'name',
          },
          {
            data: 'gender',
            name: 'gender',
          },
          {
            data: 'phone_number',
            name: 'phone_number',
          },
          {
            data: 'applied_position',
            name: 'applied_position',
          },
          {
            data: 'last_educational',
            name: 'last_educational',
          },
          {
            data: 'study',
            name: 'study',
          },
          {
            data: 'disability',
            name: 'disability',
          },
          {
            data: 'marital_status',
            name: 'marital_status',
          },
          {
            data: 'tag',
            name: 'tag',
          },
          {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false,
            className: 'no-print' // Add this class to exclude the column from printing
          },
        ],
        columnDefs: [{
          className: 'text-center',
          targets: '_all'
        }, ],
      });
    });
  </script>

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
  </script> --}}

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
          url: "{{ route('selection.index') }}",
          data: function(d) {
            d.name = $('#nameSearch').val();
            // d.age = $('#ageSearch').val();
            d.age = $('#ageFilter').val();
            d.gender = $('#genderFilter').val();
            // d.phone_number = $('#phoneSearch').val(); // Should match the database column
            // d.applied_position = $('#appPositionSearch').val();
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
          // {
          //   data: 'phone_number',
          //   name: 'phone_number'
          // },
          // {
          //   data: 'applied_position',
          //   name: 'applied_position'
          // },
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
            data: 'selectionCount',
            name: 'selectionCount'
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
      // $('#ageSearch').keyup(function() {
      //   table.draw();
      // });
      // Event listener for the year filter dropdown
      $('#ageFilter').change(function() {
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

      // Delegate event handling for 'Pilih' buttons
      $('#table-candidate').on('click', '.pilih-candidate', function() {
        const button = $(this);
        const id = button.data('id');
        const name = button.data('name');
        const email = button.data('email');
        const phone = button.data('phone');

        // If the button is in 'Pilih' state
        if (button.text().trim() === 'Pilih') {
          // Check if the candidate is already added
          if ($(`#selectedCandidatesTable tbody tr[data-id="${id}"]`).length > 0) {
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
        </tr>`;
          $('#selectedCandidatesTable tbody').append(row);

          // Change button text to 'Remove'
          button.text('Remove');
          button.removeClass('btn-primary').addClass('btn-danger');
        }
        // If the button is in 'Remove' state
        else {
          // Remove the candidate from the selected table
          $(`#selectedCandidatesTable tbody tr[data-id="${id}"]`).remove();

          // Change button text back to 'Pilih'
          button.text('Pilih');
          button.removeClass('btn-danger').addClass('btn-primary');
        }
      });

      // Use event delegation for removing a candidate directly from the selected table
      $('#selectedCandidatesTable').on('click', '.remove-candidate', function() {
        const row = $(this).closest('tr');
        const id = row.data('id');

        // Remove the row from the table
        row.remove();

        // Change the corresponding 'Remove' button back to 'Pilih'
        const button = $(`.pilih-candidate[data-id="${id}"]`);
        if (button.length > 0) {
          button.text('Pilih');
          button.removeClass('btn-danger').addClass('btn-primary');
        }
      });

      // Handle form submission to send selected candidates
      $('#selectedCandidatesForm').on('submit', function(event) {
        event.preventDefault();

        const candidates = [];
        $('#selectedCandidatesTable tbody tr').each(function() {
          const id = $(this).data('id');
          candidates.push({
            id: id
          });
        });

        // Set the hidden input value to the JSON string of candidates
        $('#candidatesInput').val(JSON.stringify(candidates));

        // Submit the form
        this.submit();
      });
    });
  </script>
@endpush

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
