    <div class="col-12">
      <div class="card">
        <div class="card-body">

          <div class="row">
            <div class="d-flex justify-content-between align-items-center ">
              <h4 class="card-title">Seminar/Pelatihan</h4>
              @if (!$employee->is_verified)
                <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
                  data-bs-target="#modal-form-add-training-attended">
                  <i class="bi bi-plus-lg"></i>
                  Add
                </button>
                @include('pages.employee.personal-data.form.training-attended.modal-create')
              @endif
            </div>
            <!-- Table with outer spacing -->
            <div class="table-responsive">
              <table class="table table-sm" style="font-size: 80%" style="margin: 0;">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Pelatihan/Seminar</th>
                    <th>Penyelenggara</th>
                    <th>Tempat/Kota</th>
                    <th>Tahun</th>
                    <th>File</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($employee->trainingAttendeds as $employeeTrainingAttended)
                    <tr>
                      <td class="text-bold-500">{{ $loop->iteration }}</td>
                      <td class="text-bold-500">{{ $employeeTrainingAttended->training_name }}</td>
                      <td class="text-bold-500">{{ $employeeTrainingAttended->organizer_name }}</td>
                      <td class="text-bold-500">{{ $employeeTrainingAttended->city }}</td>
                      <td class="text-bold-500">{{ $employeeTrainingAttended->year }}</td>
                      <td class="text-bold-500">
                        @if ($employeeTrainingAttended->file_sertifikat)
                          <a href="{{ Storage::url($employeeTrainingAttended->file_sertifikat) }}" target="_blank">
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
                              data-bs-target="#modal-form-edit-training-attended-{{ $employeeTrainingAttended->id }}"
                              class="btn btn-sm btn-icon btn-secondary text-white">
                              <i class="bi bi-pencil-square"></i>
                            </a>
                            @include('pages.employee.personal-data.form.training-attended.modal-edit')

                            <a class="btn btn-sm btn-light-danger mx-2"
                              onclick="deleteTrainingAttend('{{ $employeeTrainingAttended->id }}')"><i
                                class="bi bi-trash"></i></a>

                            <form id="deleteTrainingAttendForm_{{ $employeeTrainingAttended->id }}"
                              action="{{ route('employeeTrainingAttended.destroy', $employeeTrainingAttended->id) }}"
                              method="POST">
                              @method('DELETE')
                              @csrf
                            </form>

                          </div>
                        @endif
                      </td>
                    </tr>
                  @empty
                    <td class="text-bold-500 text-center" colspan="7">No data available in table</td>
                  @endforelse
                </tbody>
              </table>

            </div>

          </div>
        </div>
      </div>
    </div>

    <script>
      function deleteTrainingAttend(getId) {
        Swal.fire({
          title: 'Are you sure?',
          text: 'You won\'t be able to revert this!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            // If the user clicks "Yes, delete it!", submit the corresponding form
            document.getElementById('deleteTrainingAttendForm_' + getId).submit();
          }
        });
      }
    </script>
