    <div class="col-12">
      <div class="card">
        <div class="card-body">

          <div class="row">
            <div class="d-flex justify-content-between align-items-center ">
              <h4 class="card-title">Penghargaan</h4>
              @if (!$employee->is_verified)
                <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
                  data-bs-target="#modal-form-add-award">
                  <i class="bi bi-plus-lg"></i>
                  Add
                </button>
                @include('pages.employee.personal-data.form.employee-award.modal-create')
              @endif
            </div>
            <!-- Table with outer spacing -->
            <div class="table-responsive">
              <table class="table table-sm" style="font-size: 80%" style="margin: 0;">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nama Penghargaan</th>
                    <th>Tanggal Penghargaan</th>
                    <th>File</th>
                    <th style="width: 13%"></th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($employee->employeeAwards as $employeeAward)
                    <tr>
                      <td class="text-bold-500">{{ $loop->iteration }}</td>
                      <td class="text-bold-500">{{ $employeeAward->name_award }}</td>
                      <td class="text-bold-500">
                        {{ Carbon\Carbon::parse($employeeAward->date_award)->translatedFormat('d-m-Y') }}</td>
                      <td class="text-bold-500">
                        @if ($employeeAward->file_award)
                          <a href="{{ Storage::url($employeeAward->file_award) }}" target="_blank">
                            Lihat
                          </a>
                        @else
                          <span>-</span>
                        @endif
                      </td>
                      <td>
                        @if (!$employee->is_verified)
                          <div class="demo-inline-spacing">

                            <a data-bs-toggle="modal" data-bs-target="#modal-form-edit-award-{{ $employeeAward->id }}"
                              class="btn btn-sm btn-icon btn-secondary text-white">
                              <i class="bi bi-pencil-square"></i>
                            </a>
                            @include('pages.employee.personal-data.form.employee-award.modal-edit')

                            <a class="btn btn-sm btn-light-danger mx-2"
                              onclick="deleteAward('{{ $employeeAward->id }}')"><i class="bi bi-trash"></i></a>

                            <form id="deleteAwardForm_{{ $employeeAward->id }}"
                              action="{{ route('employeeAward.destroy', $employeeAward->id) }}" method="POST">
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
