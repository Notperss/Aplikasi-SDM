    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="d-flex justify-content-between align-items-center ">
              <h4 class="card-title">Riwayat Pekerjaan</h4>

              @if (!$employee->is_verified)
                <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
                  data-bs-target="#modal-form-add-job-history">
                  <i class="bi bi-plus-lg"></i>
                  Add
                </button>
                @include('pages.employee.personal-data.form.job-history.modal-create')
              @endif

            </div>
            <!-- Table with outer spacing -->
            <div class="table-responsive">
              <table class="table" style="font-size: 80%;">
                <thead>
                  <tr>
                    <th>Nama Perusahaan</th>
                    <th>Jabatan </th>
                    <th>Kota</th>
                    <th>Periode</th>
                    <th>Thn Keluar</th>
                    {{-- <th style="text-align: center;">
                      <div>Lama Bekerja</div>
                      <div style="display: flex; justify-content: space-between;">
                        <span>Masuk</span>
                        <span>-</span>
                        <span>Keluar</span>
                      </div>
                    </th> --}}
                    <th>Gaji</th>
                    <th>Keterangan</th>
                    <th>File</th>
                    <th style="width: 13%"></th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($employee->jobHistories as $employeeJobHistory)
                    <tr>
                      <td>{{ $employeeJobHistory->company_name }}</td>
                      <td class="text-bold-500">{{ $employeeJobHistory->position }}</td>
                      <td class="text-bold-500">{{ $employeeJobHistory->city }}</td>
                      <td class="text-bold-500">{{ $employeeJobHistory->period }}</td>
                      <td class="text-bold-500">{{ $employeeJobHistory->year_out }}</td>
                      {{-- <td style="text-align: center;">
                        <div style="display: flex; justify-content: space-between;">
                          <span>{{ $employeeJobHistory->year_from }}</span>
                          <span>-</span>
                          <span>{{ $employeeJobHistory->year_to }}</span>
                        </div>
                      </td> --}}
                      <td class="text-bold-500">Rp.
                        {{ number_format($employeeJobHistory->salary, 0, ',', '.') }}
                      </td>
                      <td class="text-bold-500">{{ $employeeJobHistory->reason }}</td>
                      <td class="text-bold-500 text-center">
                        @if ($employeeJobHistory->file)
                          <a href="{{ asset('storage/' . $employeeJobHistory->file) }}" target="_blank" class="text-sm">
                            Lihat
                          </a>
                        @else
                          <span>-</span>
                        @endif
                      </td>
                      <td>
                        @if (!$employee->is_verified)
                          <div class="demo-inline-spacing">
                            <a data-bs-toggle="modal"
                              data-bs-target="#modal-form-edit-job-history-{{ $employeeJobHistory->id }}"
                              class="btn btn-icon btn-sm btn-secondary text-white">
                              <i class="bi bi-pencil-square"></i>
                            </a>
                            @include('pages.employee.personal-data.form.job-history.modal-edit')

                            <a class="btn btn-sm btn-light-danger mx-2"
                              onclick="deleteJobHistory('{{ $employeeJobHistory->id }}')"><i
                                class="bi bi-trash"></i></a>

                            <form id="deleteJobHistoryForm_{{ $employeeJobHistory->id }}"
                              action="{{ route('employeeJobHistory.destroy', $employeeJobHistory) }}" method="POST">
                              @method('DELETE')
                              @csrf
                            </form>
                          </div>
                        @endif
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td class="text-center" colspan="9">No data available in table</td>
                    </tr>
                  @endforelse

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script>
      function deleteJobHistory(getId) {
        Swal.fire({
          title: 'Are you sure?',
          text: 'You won\'t be able to revert this!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            // If the user clicks "Yes, delete it!", submit the corresponding form
            document.getElementById('deleteJobHistoryForm_' + getId).submit();
          }
        });
      }
    </script>
