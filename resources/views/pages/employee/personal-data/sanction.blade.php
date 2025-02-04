    <div class="col-12">
      <div class="card">
        <div class="card-body">

          <div class="row">
            <div class="d-flex justify-content-between align-items-center ">
              <h4 class="card-title">Sanksi</h4>
              @if (!$employee->is_verified)
                <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
                  data-bs-target="#modal-form-add-sanction">
                  <i class="bi bi-plus-lg"></i>
                  Add
                </button>
                @include('pages.employee.personal-data.form.sanction.modal-create')
              @endif
            </div>
            <!-- Table with outer spacing -->
            <div class="table-responsive">
              <table class="table table-sm" style="font-size: 80%" style="margin: 0;">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nama Sanksi</th>
                    <th>kategori</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>File</th>
                    <th style="width: 13%"></th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($employee->employeeSanctions as $sanction)
                    <tr>
                      <td class="text-bold-500">{{ $loop->iteration }}</td>
                      <td class="text-bold-500">{{ $sanction->sanction_name }}</td>
                      <td class="text-bold-500">{{ $sanction->sanction_category }}</td>
                      <td class="text-bold-500">
                        {{ $sanction->start_date ? Carbon\Carbon::parse($sanction->start_date)->translatedFormat('d-m-Y') : '' }}
                      </td>
                      <td class="text-bold-500">
                        {{ $sanction->end_date ? Carbon\Carbon::parse($sanction->end_date)->translatedFormat('d-m-Y') : '' }}
                      </td>
                      <td class="text-bold-500">
                        @if ($sanction->file_sanction)
                          {{-- <a href="{{ Storage::url($sanction->file_sanction) }}" target="_blank">
                            Lihat
                          </a> --}}
                          <a href="{{ asset('storage/' . $sanction->file_sanction) }}" target="_blank" class="text-sm">
                            Lihat
                          </a>
                        @else
                          <span>-</span>
                        @endif
                      </td>
                      <td>
                        @if (!$employee->is_verified)
                          <div class="demo-inline-spacing">

                            <a data-bs-toggle="modal" data-bs-target="#modal-form-edit-sanction-{{ $sanction->id }}"
                              class="btn btn-sm btn-icon btn-secondary text-white">
                              <i class="bi bi-pencil-square"></i>
                            </a>
                            @include('pages.employee.personal-data.form.sanction.modal-edit')

                            <a class="btn btn-sm btn-light-danger mx-2"
                              onclick="deleteTrainingAttend('{{ $sanction->id }}')"><i class="bi bi-trash"></i></a>

                            <form id="deleteTrainingAttendForm_{{ $sanction->id }}"
                              action="{{ route('employeeFamilyDetail.destroy', $sanction->id) }}" method="POST">
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
