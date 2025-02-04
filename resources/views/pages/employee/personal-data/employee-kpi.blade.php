    <div class="col-12">
      <div class="card">
        <div class="card-body">

          <div class="row">
            <div class="d-flex justify-content-between align-items-center ">
              <h4 class="card-title">Penilaian Kerja</h4>

              {{-- @if (!$employee->is_verified)
                <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
                  data-bs-target="#modal-form-add-kpi">
                  <i class="bi bi-plus-lg"></i>
                  Add
                </button>
                @include('pages.employee.personal-data.form.kpi.modal-create')
              @endif --}}

            </div>
            <!-- Table with outer spacing -->
            <div class="table-responsive">
              <table class="table table-sm" style="font-size: 80%" style="margin: 0;">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nomor Kontrak</th>
                    <th>Tanggal</th>
                    <th>Nilai</th>
                    <th>Rekomendasi Kontrak</th>
                    <th>File</th>
                    <th style="width: 13%"></th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($employee->kpis as $employeeKpi)
                    <tr>
                      <td class="text-bold-500">{{ $loop->iteration }}</td>
                      <td class="text-bold-500">{{ $employeeKpi->contract->contract_number ?? '-' }}</td>
                      <td class="text-bold-500">
                        {{ $employeeKpi->kpi_date ? Carbon\Carbon::parse($employeeKpi->kpi_date)->translatedFormat('d-m-Y') : '' }}
                      </td>
                      <td class="text-bold-500">{{ $employeeKpi->grade }}</td>
                      <td class="text-bold-500">
                        @if ($employeeKpi->contract_recommendation)
                          <span class="badge bg-success">Kontrak Kerja Di Perpanjang</span>
                        @else
                          <span class="badge bg-danger">Kontrak Kerja Tidak DI Lanjutkan</span>
                        @endif
                      </td>
                      <td class="text-bold-500">
                        @if ($employeeKpi->file)
                          {{-- <a href="{{ Storage::url($employeeKpi->file) }}" target="_blank">
                            Lihat
                          </a> --}}
                          <a href="{{ asset('storage/' . $employeeKpi->file) }}" target="_blank" class="text-sm">
                            Lihat
                          </a>
                        @else
                          <span>-</span>
                        @endif
                      </td>
                      <td>
                        @if (!$employee->is_verified)
                          <div class="demo-inline-spacing">

                            <a data-bs-toggle="modal" data-bs-target="#modal-form-edit-kpi-{{ $employeeKpi->id }}"
                              class="btn btn-sm btn-icon btn-secondary text-white">
                              <i class="bi bi-pencil-square"></i>
                            </a>
                            @include('pages.employee.personal-data.form.kpi.modal-edit')

                            <a class="btn btn-sm btn-light-danger mx-2" onclick="deleteKpi('{{ $employeeKpi->id }}')"><i
                                class="bi bi-trash"></i></a>

                            <form id="deleteKpiForm_{{ $employeeKpi->id }}"
                              action="{{ route('employeeKpi.destroy', $employeeKpi->id) }}" method="POST">
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
      function deleteKpi(getId) {
        Swal.fire({
          title: 'Are you sure?',
          text: 'You won\'t be able to revert this!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            // If the user clicks "Yes, delete it!", submit the corresponding form
            document.getElementById('deleteKpiForm_' + getId).submit();
          }
        });
      }
    </script>
