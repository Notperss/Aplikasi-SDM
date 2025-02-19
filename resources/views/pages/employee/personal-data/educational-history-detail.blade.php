    <!-- pendidikan -->
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="d-flex justify-content-between align-items-center ">
              <h4 class="card-title">Riwayat Pendidikan</h4>
              @if (!$employee->is_verified)
                <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
                  data-bs-target="#modal-form-add-educational-history">
                  <i class="bi bi-plus-lg"></i>
                  Add
                </button>
                @include('pages.employee.personal-data.form.educational-history.modal-create')
              @endif
            </div>
            <!-- Table with outer spacing -->
            <div class="table-responsive" style="font-size: 80%;">
              <table class="table">
                <thead>
                  <tr>
                    <th>Tingkat</th>
                    <th>Institusi</th>
                    <th>Jurusan</th>
                    <th>Tempat/Kota</th>
                    <th>GPA/NEM</th>
                    <th>Tahun Masuk</th>
                    <th>Tahun Keluar</th>
                    {{-- <th style="text-align: center;">
                      <div>Tahun</div>
                      <div style="display: flex; justify-content: space-between;">
                        <span>Masuk</span>
                        <span>-</span>
                        <span>Keluar</span>
                      </div>
                    </th> --}}
                    <th>Lulus/Tidak</th>
                    <th>Ijazah</th>
                    <th style="width: 13%"></th>
                  </tr>
                </thead>

                <tbody>
                  @forelse ($employee->educationalHistories as $employeeEducationalHistory)
                    <tr>
                      <td class="text-bold-500">{{ $employeeEducationalHistory->school_level }}</td>
                      <td>{{ $employeeEducationalHistory->school_name }}</td>
                      <td class="text-bold-500">{{ $employeeEducationalHistory->study }}</td>
                      <td class="text-bold-500">{{ $employeeEducationalHistory->city }}</td>
                      <td class="text-bold-500">{{ $employeeEducationalHistory->gpa }}</td>
                      <td class="text-bold-500">{{ $employeeEducationalHistory->year_from }}</td>
                      <td class="text-bold-500">{{ $employeeEducationalHistory->year_to }}</td>
                      {{-- <td style="text-align: center;">
                        <div style="display: flex; justify-content: space-between;">
                          <span>{{ $employeeEducationalHistory->year_from }}</span>
                          <span>-</span>
                          <span>{{ $employeeEducationalHistory->year_to }}</span>
                        </div>
                      </td> --}}
                      <td class="text-bold-500">{{ $employeeEducationalHistory->graduate }}</td>
                      <td class="text-bold-500 text-center">
                        @if ($employeeEducationalHistory->file_ijazah)
                          <a href="{{ asset('storage/' . $employeeEducationalHistory->file_ijazah) }}" target="_blank"
                            class="text-sm">
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
                              data-bs-target="#modal-form-edit-educational-history-{{ $employeeEducationalHistory->id }}"
                              class="btn btn-sm btn-icon btn-secondary text-white">
                              <i class="bi bi-pencil-square"></i>
                            </a>
                            @include('pages.employee.personal-data.form.educational-history.modal-edit')

                            <a class="btn btn-sm btn-light-danger mx-2"
                              onclick="deleteEducational('{{ $employeeEducationalHistory->id }}')"><i
                                class="bi bi-trash"></i></a>

                            <form id="deleteEducationalForm_{{ $employeeEducationalHistory->id }}"
                              action="{{ route('employeeEducationalHistory.destroy', $employeeEducationalHistory) }}"
                              method="POST">
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
      function deleteEducational(getId) {
        Swal.fire({
          title: 'Are you sure?',
          text: 'You won\'t be able to revert this!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            // If the user clicks "Yes, delete it!", submit the corresponding form
            document.getElementById('deleteEducationalForm_' + getId).submit();
          }
        });
      }
    </script>
