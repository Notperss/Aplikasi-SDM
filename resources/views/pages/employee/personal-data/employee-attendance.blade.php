    <div class="col-12">

      <div class="row">
        <div class="col-4 col-lg-2 col-md-3">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <h6 class="text-muted font-semibold">Total Hadir</h6>
                  <h4 class="font-extrabold mb-0">
                    {{ $employee->employeeAttendances->where('status', 'H')->count() }}
                  </h4>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-4 col-lg-2 col-md-3">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <h6 class="text-muted font-semibold">Total Absen</h6>
                  <h4 class="font-extrabold mb-0">
                    {{ $employee->employeeAttendances->where('status', 'A')->count() }}
                  </h4>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-4 col-lg-2 col-md-3">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <h6 class="text-muted font-semibold">Total Libur</h6>
                  <h4 class="font-extrabold mb-0">
                    {{ $employee->employeeAttendances->where('status', 'L')->count() }}
                  </h4>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-4 col-lg-2 col-md-3">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <h6 class="text-muted font-semibold">Total Telat</h6>
                  <h4 class="font-extrabold mb-0">
                    {{ $employee->employeeAttendances->where('status', 'T')->count() }}
                  </h4>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-4 col-lg-2 col-md-3">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <h6 class="text-muted font-semibold">Total Izin</h6>
                  <h4 class="font-extrabold mb-0">
                    {{ $employee->employeeAttendances->where('status', 'I')->count() }}
                  </h4>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-4 col-lg-2 col-md-3">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <h6 class="text-muted font-semibold">Total Sakit</h6>
                  <h4 class="font-extrabold mb-0">
                    {{ $employee->employeeAttendances->where('status', 'S')->count() }}
                  </h4>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-4 col-lg-2 col-md-3">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <h6 class="text-muted font-semibold">Total IPC</h6>
                  <h4 class="font-extrabold mb-0">
                    {{ $employee->employeeAttendances->where('status', 'IPC')->count() }}
                  </h4>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-4 col-lg-2 col-md-3">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <h6 class="text-muted font-semibold">Total IDT</h6>
                  <h4 class="font-extrabold mb-0">
                    {{ $employee->employeeAttendances->where('status', 'IDT')->count() }}
                  </h4>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-4 col-lg-2 col-md-3">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <h6 class="text-muted font-semibold">Total CT</h6>
                  <h4 class="font-extrabold mb-0">
                    {{ $employee->employeeAttendances->where('status', 'CT')->count() }}
                  </h4>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-4 col-lg-2 col-md-3">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <h6 class="text-muted font-semibold">Total C</h6>
                  <h4 class="font-extrabold mb-0">
                    {{ $employee->employeeAttendances->where('status', 'C')->count() }}
                  </h4>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-4 col-lg-2 col-md-3">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <h6 class="text-muted font-semibold">Total TM</h6>
                  <h4 class="font-extrabold mb-0">
                    {{ $employee->employeeAttendances->where('status', 'TM')->count() }}
                  </h4>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-4 col-lg-2 col-md-3">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <h6 class="text-muted font-semibold">Total TP</h6>
                  <h4 class="font-extrabold mb-0">
                    {{ $employee->employeeAttendances->where('status', 'TP')->count() }}
                  </h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-body">

          <div class="row">
            <div class="d-flex justify-content-between align-items-center ">
              <h4 class="card-title">Absensi</h4>

              <a id="export-attends-button" class="btn btn-success">
                Export Absensi
              </a>
            </div>

            <div class="d-flex justify-content-between align-items-center">

              <div class="row">
                <input type="hidden" id="employee-nik" value="{{ $employee->nik }}">
                <input type="hidden" id="employee-name" value="{{ $employee->name }}">
                <!-- Dropdown for Selecting Month -->
                <div class="col-md-5">
                  <label for="month-select-attend">Pilih Bulan</label>
                  <select id="month-select-attend" class="form-control">
                    @foreach (range(1, 12) as $month)
                      <option value="{{ $month }}" {{ $month == date('n') ? 'selected' : '' }}>
                        {{ DateTime::createFromFormat('!m', $month)->format('F') }}
                      </option>
                    @endforeach
                  </select>
                </div>

                <!-- Dropdown for Selecting Year -->
                <div class="col-md-5">
                  <label for="year-select-attend">Pilih Tahun</label>
                  <select id="year-select-attend" class="form-control">
                    @for ($year = 2015; $year <= date('Y'); $year++)
                      <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>
                        {{ $year }}
                      </option>
                    @endfor
                  </select>
                </div>

                <!-- Reset Button -->
                <div class="col-md-2 my-4">
                  <button id="reset-filters" class="btn btn-secondary ">Reset</button>
                </div>

              </div>
            </div>

            <div id="attends-list">
              @php
                $employeeAttendances = $employee->employeeAttendances;
              @endphp

              @include('pages.employee.personal-data.form.employee-attendance.employee-attendance', [
                  'employeeAttendances' => $employeeAttendances,
              ])
            </div>

          </div>

        </div>
      </div>

    </div>

    <script>
      function deleteAward(getId) {
        Swal.fire({
          title: 'Are you sure?',
          text: 'You won\'t be able to revert this!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            // If the user clicks "Yes, delete it!", submit the corresponding form
            document.getElementById('deleteAwardForm_' + getId).submit();
          }
        });
      }
    </script>

    {{-- <script>
      $(document).ready(function() {
        $('#filterForm').on('submit', function(e) {
          e.preventDefault();

          const month = $('#month').val();
          const year = $('#year').val();
          const employeeId = $('#employeeId').val();

          $.ajax({
            url: '{{ route('employee.attendances') }}',
            method: 'GET',
            data: {
              month: month,
              year: year,
              employeeId: employeeId
            },
            success: function(response) {
              let tableBody = '';
              response.attendances.forEach((attendance, index) => {
                tableBody += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${attendance.check_in_time}</td>
                            <td>${attendance.check_out_time}</td>
                            <td>${attendance.clock_in}</td>
                            <td>${attendance.clock_out}</td>
                            <td>${attendance.working_type}</td>
                            <td>${attendance.status}</td>
                            <td>${attendance.late}</td>
                            <td>${attendance.date}</td>
                            <td>${attendance.working_hours}</td>
                        </tr>
                    `;
              });

              $('#attendanceTable tbody').html(tableBody);
            },
            error: function(error) {
              alert('Error fetching data: ' + error.responseJSON.message);
            }
          });
        });
      });
    </script> --}}

    {{-- <script>
      $(document).ready(function() {
        $('#filterForm').on('submit', function(e) {
          e.preventDefault();

          const month = $('#month').val(); // Match with your form
          const year = $('#year-attend').val(); // Match with your form
          const employeeId = $('#employeeId').val();

          console.log('Selected year:', year); // Debugging

          $.ajax({
            url: '{{ route('employee.attendances') }}',
            method: 'GET',
            data: {
              month: month,
              year: year,
              employeeId: employeeId
            },
            success: function(response) {
              let tableBody = '';
              if (response.attendances.length > 0) {
                response.attendances.forEach((attendance, index) => {
                  tableBody += `
                <tr>
                  <td>${index + 1}</td>
                  <td>${attendance.check_in_time ?? '-'}</td>
                  <td>${attendance.check_out_time ?? '-'}</td>
                  <td>${attendance.clock_in ?? '-'}</td>
                  <td>${attendance.clock_out ?? '-'}</td>
                  <td>${attendance.working_type ?? '-'}</td>
                  <td>${attendance.status ?? '-'}</td>
                  <td>${attendance.late ?? '-'}</td>
                  <td>${attendance.date ?? '-'}</td>
                  <td>${attendance.working_hours ?? '-'}</td>
                </tr>
              `;
                });
              } else {
                tableBody = `
              <tr>
                <td colspan="10" class="text-center">No attendance records found</td>
              </tr>
            `;
              }

              $('#attendanceTable tbody').html(tableBody);
            },
            error: function(error) {
              alert('Error fetching data: ' + (error.responseJSON?.message || 'Unexpected error'));
            }
          });
        });
      });
    </script> --}}

    {{-- <script>
      document.addEventListener('DOMContentLoaded', () => {
        const monthSelect = document.getElementById('month-select-attend');
        const yearSelect = document.getElementById('year-select-attend');
        const attendsList = document.getElementById('attends-list');
        const resetButton = document.getElementById('reset-filters');
        const nikInput = document.getElementById(
          'employee-nik'); // Assuming you have an input field with this ID for nik

        // Function to fetch filtered attends based on selected month and year
        function fetchFilteredAttends() {
          const month = monthSelect.value;
          const year = yearSelect.value;
          const nik = nikInput?.value; // Safely get nik if the input exists

          const url = `{{ route('employee.attendances') }}?month=${month}&year=${year}${nik ? `&nik=${nik}` : ''}`;

          fetch(url)
            .then(response => response.text())
            .then(html => {
              attendsList.innerHTML = html; // Update the attends list with the fetched data
            })
            .catch(error => console.error('Error fetching filtered attends:', error));
        }

        // Function to reset filters to current month and year
        function resetFilters() {
          monthSelect.value = new Date().getMonth() + 1; // Reset to current month (1-based)
          yearSelect.value = new Date().getFullYear(); // Reset to current year
          fetchFilteredAttends(); // Fetch the unfiltered data for the current month and year
        }

        // Add event listeners for changing month and year
        monthSelect.addEventListener('change', fetchFilteredAttends); // Fetch data when month changes
        yearSelect.addEventListener('change', fetchFilteredAttends); // Fetch data when year changes

        // Add event listener for reset button
        resetButton.addEventListener('click', resetFilters);

        // Initial fetch to load attends with default values
        fetchFilteredAttends();
      });
    </script> --}}

    <script>
      document.addEventListener('DOMContentLoaded', () => {
        const monthSelect = document.getElementById('month-select-attend');
        const yearSelect = document.getElementById('year-select-attend');
        const attendsList = document.getElementById('attends-list');
        const resetButton = document.getElementById('reset-filters');
        const exportButton = document.getElementById('export-attends-button');
        const nikInput = document.getElementById('employee-nik'); // Optional: Add this if filtering by NIK
        const employeeName = document.getElementById('employee-name'); // Optional: Add this if filtering by NIK

        function fetchFilteredAttends() {
          const month = monthSelect.value;
          const year = yearSelect.value;
          const nik = nikInput?.value;
          const name = employeeName?.value;

          const url =
            `{{ route('employee.attendances') }}?month=${month}&year=${year}${nik ? `&nik=${nik}` : ''}${name ? `&name=${name}` : ''}`;
          fetch(url)
            .then(response => response.text())
            .then(html => {
              attendsList.innerHTML = html;
            })
            .catch(error => console.error('Error fetching filtered attends:', error));
        }

        function updateExportLink() {
          const month = monthSelect.value;
          const year = yearSelect.value;
          const nik = nikInput?.value;
          const name = employeeName?.value;

          const exportUrl =
            `{{ route('export.attendanceEmployee') }}?month=${month}&year=${year}${nik ? `&nik=${nik}` : ''}${name ? `&name=${name}` : ''}`;
          exportButton.setAttribute('href', exportUrl);
        }

        function resetFilters() {
          monthSelect.value = new Date().getMonth() + 1;
          yearSelect.value = new Date().getFullYear();
          fetchFilteredAttends();
        }

        monthSelect.addEventListener('change', () => {
          fetchFilteredAttends();
          updateExportLink();
        });
        yearSelect.addEventListener('change', () => {
          fetchFilteredAttends();
          updateExportLink();
        });
        resetButton.addEventListener('click', resetFilters);

        updateExportLink();
        fetchFilteredAttends();
      });
    </script>
