<!-- Modals add menu -->
<div id="modal-form-add-training-attended" class="modal fade" tabindex="-1"
  aria-labelledby="modal-form-add-training-attended-label" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <form id="selectedEmployeesForm" action="{{ route('employeeTrainingAttended.store') }}" method="post"
        enctype="multipart/form-data">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-add-training-attended-label">Tambah Data Seminar/Pelatihan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>

        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-11"> <!-- Make form smaller with col-md-6 and center it -->

              <div class="mb-2">
                <label class="form-label" for="training_name">Nama Seminar/Pelatihan</label>
                <input id="training_name" name="training_name" value="{{ old('training_name') }}"
                  class="form-control @error('training_name') is-invalid @enderror" required>
                @error('training_name')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label class="form-label" for="organizer_name">Penyelenggara</label>
                <input id="organizer_name" name="organizer_name" value="{{ old('organizer_name') }}"
                  class="form-control @error('organizer_name') is-invalid @enderror" required>
                @error('organizer_name')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="row mb-2">
                <div class="col-md-6">
                  <label class="form-label" for="city">Tempat/Kota</label>
                  <input id="city" value="{{ old('city') }}" name="city"
                    class="form-control @error('city') is-invalid @enderror">
                  @error('city')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <label class="form-label" for="start_date">Tanggal Mulai</label>
                  <input type="date" id="start_date" name="start_date" maxlength="4" value="{{ old('start_date') }}"
                    class="form-control @error('start_date') is-invalid @enderror">
                  @error('start_date')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="end_date">Tanggal Akhir</label>
                  <input type="date" id="end_date" name="end_date" maxlength="4" value="{{ old('end_date') }}"
                    class="form-control @error('end_date') is-invalid @enderror">
                  @error('end_date')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>
              </div>

              <div class="row mt-3">
                <div class="col-md-4 d-flex align-items-end">
                  <a class="btn btn-primary" onclick="openMyModalAdd()">
                    <i class="bi bi-plus-lg"></i> Karyawan
                  </a>
                </div>
              </div>

              <div class="my-2">
                <label class="form-label">Karyawan Mengikuti Training:</label>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>NIK</th>
                      <th>Nama</th>
                      <th>Jabatan</th>
                      <th>Divisi</th>
                      <th>Upload</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody id="employee-table-body">
                    <!-- Selected employees will be appended here dynamically -->
                  </tbody>
                </table>
                <p id="employee-empty-state" class="text-muted">Belum ada karyawan yang ditambahkan.</p>

                <input type="hidden" name="employees" id="employeesInput">
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

<!-- Add your modal structure here -->
<div class="modal fade" id="employeeAddModal" tabindex="-1" aria-labelledby="employeeModalLabel" aria-hidden="true"
  style="background-color: #000">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="employeeModalLabel">Daftar Karyawan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="table-employee" style="width: 100%">
            <thead>
              <tr>
                <th>#</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Divisi</th>
                <th></th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- <script>
  document.addEventListener("DOMContentLoaded", function() {
    const employeeSelect = document.getElementById("employee_id");
    const employeeList = document.getElementById("employee-list");
    const addEmployeeBtn = document.getElementById("add-selected-employee");

    addEmployeeBtn.addEventListener("click", function() {
      const selectedEmployeeId = employeeSelect.value;
      const selectedEmployeeName = employeeSelect.options[employeeSelect.selectedIndex].text;
      const selectedEmployeePhoto = employeeSelect.options[employeeSelect.selectedIndex].dataset.photo;
      const selectedEmployeeNIK = employeeSelect.options[employeeSelect.selectedIndex].dataset.nik;
      const selectedEmployeePosition = employeeSelect.options[employeeSelect.selectedIndex].dataset.position;
      const selectedEmployeeDivision = employeeSelect.options[employeeSelect.selectedIndex].dataset.division;

      // Ensure a valid employee is selected
      if (!selectedEmployeeId) {
        alert("Silakan pilih karyawan terlebih dahulu.");
        return;
      }

      // Check if employee is already in the list
      if (document.querySelector(`[data-employee-id="${selectedEmployeeId}"]`)) {
        alert("Karyawan ini sudah ditambahkan.");
        return;
      }

      const newEmployeeItem = document.createElement("div");
      newEmployeeItem.classList.add("d-flex", "flex-column", "mb-3",
        "mr-2"); // Use flex-column for vertical alignment
      newEmployeeItem.setAttribute("data-employee-id", selectedEmployeeId);
      newEmployeeItem.innerHTML = `
      <div class="d-flex align-items-center mb-2">
          <input type="hidden" name="employees[]" value="${selectedEmployeeId}">
          <img src="${selectedEmployeePhoto}" alt="Photo of ${selectedEmployeeName}" 
              class="rounded-circle me-2" style="width: 80px; height: 80px; object-fit: cover;">
        <div>
          <strong>${selectedEmployeeName}</strong><br>
          <small>NIK: ${selectedEmployeeNIK}</small><br>
          <small>Jabatan: ${selectedEmployeePosition}</small><br>
          <small>Divisi: ${selectedEmployeeDivision}</small>
        </div>
      </div>
      <span class="remove-btn text-danger mt-2" style="cursor: pointer;" title="Remove">Remove</span>
      `;

      const employeeListContainer = document.getElementById("employee-list");
      employeeListContainer.appendChild(newEmployeeItem); // Add the new employee to the list


      // Add event listener to remove button
      newEmployeeItem.querySelector(".remove-btn").addEventListener("click", function() {
        newEmployeeItem.remove();
      });

      // Append to the employee list
      employeeList.appendChild(newEmployeeItem);

      // Reset the select dropdown
      employeeSelect.value = "";
    });
  });
</script> --}}

<style>
  #employee-list .d-flex {
    align-items: flex-start !important;
    /* Aligns content to the left */
  }
</style>

<script>
  function openMyModalAdd() {
    const modalId = 'employeeAddModal';
    const myModal = new bootstrap.Modal(document.getElementById(modalId), {});
    myModal.show();
  }
</script>

@push('after-script')
  <script>
    jQuery(document).ready(function($) {
      const employeeTable = $('#table-employee').DataTable({
        processing: true,
        serverSide: true,
        ordering: true,
        pageLength: 10,
        lengthMenu: [
          [10, 25, 50, 100, -1],
          [10, 25, 50, 100, 'All']
        ],
        ajax: {
          url: "{{ route('employee.index') }}",
          data: function(d) {
            d.employee_status = 'AKTIF';
          },
        },
        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false,
            width: '5%'
          },
          {
            data: 'nik',
            name: 'nik'
          },
          {
            data: 'name',
            name: 'name'
          },
          {
            data: 'position.name',
            name: 'position.name',
            orderable: false,
          },
          {
            data: 'position.division.name',
            name: 'position.division.name',
            orderable: false,
          },
          {
            data: null,
            orderable: false,
            searchable: false,
            render: function(data) {
              return `
                            <button class="btn btn-sm btn-primary select-employee"
                                    data-id="${data.id}"
                                    data-nik="${data.nik}"
                                    data-name="${data.name}"
                                    data-position="${data.position.name}"
                                    data-division="${data.position.division.name}">
                                Pilih
                            </button>
                        `;
            },
          },
        ],
        columnDefs: [{
          className: 'text-center',
          targets: '_all'
        }],
      });

      // Attach event listener to dynamically loaded "Pilih" buttons
      $('#table-employee').on('click', '.select-employee', function() {
        const employeeId = $(this).data('id');
        const employeeName = $(this).data('name');
        const employeeNik = $(this).data('nik');
        const employeePosition = $(this).data('position');
        const employeeDivision = $(this).data('division');
        const button = $(this);

        if (isEmployeeAlreadyAdded(employeeId)) {
          // Jika karyawan sudah dipilih, hapus dari tabel & ubah tombol kembali ke "Pilih"
          removeEmployee(employeeId);
          button.text('Pilih').removeClass('btn-danger remove-employee').addClass('btn-primary select-employee');
          return;
        }

        const employeeTableBody = $('#employee-table-body');

        // Append the employee to the table
        const row = `
      <tr data-id="${employeeId}">
        <td>${employeeNik}</td>
        <td>${employeeName}</td>
        <td>${employeePosition}</td>
        <td>${employeeDivision}</td>
        <td>
          <input type="file"  accept=".pdf, .jpg, .jpeg, .png" name="employee_files[${employeeId}]" class="form-control">
        </td>
        <td>
          <a class="btn btn-sm btn-danger remove-employee" data-id="${employeeId}">Hapus</a>
        </td>
      </tr>
    `;
        employeeTableBody.append(row);
        updateEmptyState();

        // Ubah tombol menjadi "Hapus"
        button.text('Hapus').removeClass('btn-primary select-employee').addClass('btn-danger remove-employee');
      });

      // Remove employee from the table & reset button
      $('#employee-table-body').on('click', '.remove-employee', function() {
        const row = $(this).closest('tr');
        const employeeId = row.data('id');

        row.remove();
        updateEmptyState();

        // Ubah tombol kembali ke "Pilih"
        $(`#table-employee .btn[data-id="${employeeId}"]`)
          .text('Pilih')
          .removeClass('btn-danger remove-employee')
          .addClass('btn-primary select-employee');
      });

      // Hapus employee jika tombol "Pilih" diklik kembali
      function removeEmployee(employeeId) {
        $(`#employee-table-body tr[data-id="${employeeId}"]`).remove();
        updateEmptyState();
      }

      // Check if an employee has already been added
      function isEmployeeAlreadyAdded(employeeId) {
        return $('#employee-table-body').find(`tr[data-id="${employeeId}"]`).length > 0;
      }

      // Update the "empty state" message
      function updateEmptyState() {
        if ($('#employee-table-body tr').length === 0) {
          $('#employee-empty-state').removeClass('d-none');
        } else {
          $('#employee-empty-state').addClass('d-none');
        }
      }

      // Form submission
      $('#selectedEmployeesForm').on('submit', function(event) {
        event.preventDefault();

        const employees = [];
        $('#employee-table-body tr').each(function() {
          const id = $(this).data('id');
          employees.push({
            id: id
          });
        });

        // Set the hidden input to the JSON string of employees
        $('#employeesInput').val(JSON.stringify(employees));

        // Submit the form
        this.submit();
      });

    });
  </script>
@endpush
