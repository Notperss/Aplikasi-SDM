    <div class="col-12">
      <div class="card">
        <div class="card-body">

          <div class="row">
            <div class="d-flex justify-content-between align-items-center ">
              <h4 class="card-title">Dinas/Tugas</h4>

              <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
                data-bs-target="#modal-form-add-duty">
                <i class="bi bi-plus-lg"></i>
                Add
              </button>
              @include('pages.employee.personal-data.form.employee-duty.modal-create')

            </div>
            <!-- Table with outer spacing -->
            <div class="table-responsive">
              <table class="table table-sm" style="font-size: 80%" style="margin: 0;">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Dinas/Tugas</th>
                    <th>Tanggal</th>
                    <th>Tempat</th>
                    <th>File</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($employee->employeeDuties as $employeeDuty)
                    <tr>
                      <td class="text-bold-500">{{ $loop->iteration }}</td>
                      <td class="text-bold-500">{{ $employeeDuty->name_duty }}</td>
                      <td class="text-bold-500">
                        {{ Carbon\Carbon::parse($employeeDuty->date_duty)->translatedFormat('l, d F Y') }}</td>
                      <td class="text-bold-500">{{ $employeeDuty->location }}</td>
                      <td class="text-bold-500">
                        @if ($employeeDuty->file)
                          <a href="{{ Storage::url($employeeDuty->file) }}" target="_blank">
                            Lihat
                          </a>
                        @else
                          <span>-</span>
                        @endif
                      </td>
                      <td>

                        <div class="demo-inline-spacing">

                          <a data-bs-toggle="modal" data-bs-target="#modal-form-edit-duty-{{ $employeeDuty->id }}"
                            class="btn btn-sm btn-icon btn-secondary text-white">
                            <i class="bi bi-pencil-square"></i>
                          </a>
                          @include('pages.employee.personal-data.form.employee-duty.modal-edit')

                          <a class="btn btn-sm btn-light-danger mx-2" onclick="deleteDuty('{{ $employeeDuty->id }}')"><i
                              class="bi bi-trash"></i></a>

                          <form id="deleteDutyForm_{{ $employeeDuty->id }}"
                            action="{{ route('employeeDuty.destroy', $employeeDuty->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                          </form>

                        </div>

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
      function deleteDuty(getId) {
        Swal.fire({
          title: 'Are you sure?',
          text: 'You won\'t be able to revert this!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            // If the user clicks "Yes, delete it!", submit the corresponding form
            document.getElementById('deleteDutyForm_' + getId).submit();
          }
        });
      }
    </script>
