    <div class="col-12">
      <div class="card">
        <div class="card-body">

          <div class="row">
            <div class="d-flex justify-content-between align-items-center ">
              <h4 class="card-title">Karir</h4>
              @if (!$employee->is_verified)
                <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
                  data-bs-target="#modal-form-add-career">
                  <i class="bi bi-plus-lg"></i>
                  Add
                </button>
                @include('pages.employee.personal-data.form.employee-career.modal-create')
              @endif
            </div>
            <!-- Table with outer spacing -->
            <div class="table-responsive">
              <table class="table table-sm" style="font-size: 80%" style="margin: 0;">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Akhir</th>
                    <th>Penempatan</th>
                    <th>Jabatan</th>
                    <th>Tipe Karir</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th>File</th>
                    <th style="width: 13%"></th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($employee->employeeCareers->where('cmnp_career',0) as $employeeCareer)
                    <tr>
                      <td class="text-bold-500">{{ $loop->iteration }}</td>
                      <td class="text-bold-500">
                        {{ Carbon\Carbon::parse($employeeCareer->start_date)->translatedFormat('d-m-Y') }}
                      </td>
                      <td class="text-bold-500">
                        @if ($employeeCareer->is_approve)
                          @if ($employeeCareer->position_id)
                            {{ $employeeCareer->end_date ? Carbon\Carbon::parse($employeeCareer->end_date)->translatedFormat('d-m-Y') : 'Sekarang' }}
                          @else
                            -
                          @endif
                        @endif
                      </td>
                      <td class="text-bold-500">DIVISI {{ $employeeCareer->position->division->name ?? '' }}</td>
                      <td class="text-bold-500">{{ $employeeCareer->position->name ?? '' }}</td>
                      <td class="text-bold-500">{{ $employeeCareer->type ?? '' }}</td>
                      <td class="text-bold-500">
                        @if ($employeeCareer->is_approve)
                          <span class="badge bg-success">Disetujui</span>
                        @elseif ($employeeCareer->is_approve === false)
                          <span class="badge bg-danger">Ditolak</span>
                        @else
                          <span class="badge bg-secondary">Pending</span>
                        @endif
                      </td>
                      <td class="text-bold-500">{{ $employeeCareer->description }}</td>
                      <td class="text-bold-500">
                        @if ($employeeCareer->file_career)
                          {{-- <a href="{{ Storage::url($employeeCareer->file_career) }}" target="_blank">
                            Lihat
                          </a> --}}
                          <a href="{{ asset('storage/' . $employeeCareer->file_career) }}" target="_blank"
                            class="text-sm">
                            Lihat
                          </a>
                        @else
                          <span>-</span>
                        @endif
                      </td>
                      <td>
                        @if ($employeeCareer->is_approve === null && !$employee->is_verified)
                          <div class="demo-inline-spacing">

                            <a data-bs-toggle="modal" data-bs-target="#modal-form-edit-career-{{ $employeeCareer->id }}"
                              class="btn btn-sm btn-icon btn-secondary text-white">
                              <i class="bi bi-pencil-square"></i>
                            </a>
                            @include('pages.employee.personal-data.form.employee-career.modal-edit')

                            <a class="btn btn-sm btn-light-danger mx-2"
                              onclick="deleteCareer('{{ $employeeCareer->id }}')"><i class="bi bi-trash"></i></a>

                            <form id="deleteCareerForm_{{ $employeeCareer->id }}"
                              action="{{ route('employeeCareer.destroy', $employeeCareer->id) }}" method="POST">
                              @method('DELETE')
                              @csrf
                            </form>

                          </div>
                        @endif
                      </td>
                    </tr>
                  @empty
                    <td class="text-bold-500 text-center" colspan="10">No data available in table</td>
                  @endforelse
                </tbody>
              </table>

            </div>

          </div>
        </div>
      </div>
    </div>

    <div class="col-12">
      <div class="card">
        <div class="card-body">

          <div class="row">
            <div class="d-flex justify-content-between align-items-center ">
              <h4 class="card-title">Karir CMNP</h4>
              @if (!$employee->is_verified)
                <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
                  data-bs-target="#modal-form-add-cmnp-career">
                  <i class="bi bi-plus-lg"></i>
                  Add
                </button>
                @include('pages.employee.personal-data.form.employee-career.modal-create-cmnp')
              @endif
            </div>
            <!-- Table with outer spacing -->
            <div class="table-responsive">
              <table class="table table-sm" style="font-size: 80%" style="margin: 0;">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Akhir</th>
                    <th>Penempatan</th>
                    <th>Jabatan</th>
                    <th>Tipe Karir</th>
                    {{-- <th>Status</th> --}}
                    <th>Keterangan</th>
                    {{-- <th>File</th> --}}
                    <th style="width: 13%"></th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($employee->employeeCareers->where('cmnp_career', 1) as $employeeCareer)
                    <tr>
                      <td class="text-bold-500">{{ $loop->iteration }}</td>
                      <td class="text-bold-500">
                        {{ Carbon\Carbon::parse($employeeCareer->start_date)->translatedFormat('d-m-Y') }}
                      </td>
                      <td class="text-bold-500">
                        {{ $employeeCareer->end_date ? Carbon\Carbon::parse($employeeCareer->end_date)->translatedFormat('d-m-Y') : '-' }}
                      </td>
                      <td class="text-bold-500">{{ $employeeCareer->placement ?? '' }}</td>
                      <td class="text-bold-500">{{ $employeeCareer->position_name ?? '' }}</td>
                      <td class="text-bold-500">{{ $employeeCareer->type ?? '' }}</td>
                      {{-- <td class="text-bold-500">
                        @if ($employeeCareer->is_approve)
                          <span class="badge bg-success">Disetujui</span>
                        @elseif ($employeeCareer->is_approve === false)
                          <span class="badge bg-danger">Ditolak</span>
                        @else
                          <span class="badge bg-secondary">Pending</span>
                        @endif
                      </td> --}}
                      <td class="text-bold-500">{{ $employeeCareer->description }}</td>
                      {{-- <td class="text-bold-500">
                        @if ($employeeCareer->file_career)
                          <a href="{{ Storage::url($employeeCareer->file_career) }}" target="_blank">
                            Lihat
                          </a>
                        @else
                          <span>-</span>
                        @endif
                      </td> --}}
                      <td>
                        @if ($employeeCareer->is_approve === null && !$employee->is_verified)
                          <div class="demo-inline-spacing">

                            <a data-bs-toggle="modal"
                              data-bs-target="#modal-form-edit-career-{{ $employeeCareer->id }}"
                              class="btn btn-sm btn-icon btn-secondary text-white">
                              <i class="bi bi-pencil-square"></i>
                            </a>
                            @include('pages.employee.personal-data.form.employee-career.modal-edit')

                            <a class="btn btn-sm btn-light-danger mx-2"
                              onclick="deleteCareer('{{ $employeeCareer->id }}')"><i class="bi bi-trash"></i></a>

                            <form id="deleteCareerForm_{{ $employeeCareer->id }}"
                              action="{{ route('employeeCareer.destroy', $employeeCareer->id) }}" method="POST">
                              @method('DELETE')
                              @csrf
                            </form>

                          </div>
                        @endif
                      </td>
                    </tr>
                  @empty
                    <td class="text-bold-500 text-center" colspan="10">No data available in table</td>
                  @endforelse
                </tbody>
              </table>

            </div>

          </div>
        </div>
      </div>
    </div>

    <script>
      function deleteCareer(getId) {
        Swal.fire({
          title: 'Are you sure?',
          text: 'You won\'t be able to revert this!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            // If the user clicks "Yes, delete it!", submit the corresponding form
            document.getElementById('deleteCareerForm_' + getId).submit();
          }
        });
      }
    </script>
