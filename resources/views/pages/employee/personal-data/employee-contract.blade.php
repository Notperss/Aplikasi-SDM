    <div class="col-12">
      <div class="card">
        <div class="card-body">

          <div class="row">
            <div class="d-flex justify-content-between align-items-center ">
              <h4 class="card-title">Kontrak</h4>
              @if (!$employee->is_verified)
                <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
                  data-bs-target="#modal-form-add-contract">
                  <i class="bi bi-plus-lg"></i>
                  Add
                </button>
                @include('pages.employee.personal-data.form.employee-contract.modal-create')
              @endif
            </div>
            <!-- Table with outer spacing -->
            <div class="table-responsive">
              <table class="table table-sm" style="font-size: 80%" style="margin: 0;">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>No. Kontrak</th>
                    <th>Tgl Awal</th>
                    <th>Tgl Akhir</th>
                    <th>Durasi</th>
                    <th>Kontrak Ke</th>
                    <th>Deskripsi</th>
                    <th>PK</th>
                    <th>File</th>
                    <th>Lock</th>
                    <th style="width: 12%"></th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($employee->contracts as $contract)
                    <tr>
                      <td class="text-bold-500">{{ $loop->iteration }}</td>
                      <td class="text-bold-500">{{ $contract->contract_number }}</td>
                      <td class="text-bold-500">
                        {{ Carbon\Carbon::parse($contract->start_date)->translatedFormat('l, d F Y') }}</td>
                      <td class="text-bold-500">
                        {{ Carbon\Carbon::parse($contract->end_date)->translatedFormat('l, d F Y') }}</td>
                      <td class="text-bold-500">{{ $contract->duration }}</td>
                      <td class="text-bold-500">{{ $contract->contract_sequence_number }}</td>
                      <td class="text-bold-500">{{ $contract->description }}</td>
                      <td class="text-bold-500">{{ $contract->contractKpi->grade ?? '-' }}</td>
                      <td class="text-bold-500">
                        @if ($contract->file)
                          {{-- <a href="{{ Storage::url($contract->file) }}" target="_blank">
                            Lihat
                          </a> --}}
                          <a href="{{ asset('storage/' . $contract->file) }}" target="_blank" class="text-sm">
                            Lihat
                          </a>
                        @else
                          <span>-</span>
                        @endif
                      </td>
                      <td class="text-bold-500">

                        @if ($contract->is_lock)
                          @role('super-admin')
                            <button onclick="lockContract('{{ $contract->id }}')" title="Locked"
                              class="btn btn-sm btn-success"><i class="bi bi-lock-fill"></i></button>
                          @else
                            <button onclick="alert('Hubungin Administrator Jika Ingin Membuka Kunci!')" title="Unlocked"
                              class="btn btn-sm btn-success"><i class="bi bi-lock-fill"></i></button>
                          @endrole
                        @else
                          <button onclick="lockContract('{{ $contract->id }}')" title="Unlocked"
                            class="btn btn-sm btn-danger"><i class="bi bi-unlock-fill"></i></button>
                        @endif

                        <form id="lockContractForm_{{ $contract->id }}"
                          action="{{ route('contract.lock', $contract->id) }}" method="POST">
                          @method('put')
                          @csrf

                        </form>
                      </td>
                      <td>
                        @if (!$employee->is_verified)
                          @if (!$contract->is_lock)
                            <div class="demo-inline-spacing">

                              <a data-bs-toggle="modal" data-bs-target="#modal-form-edit-contract-{{ $contract->id }}"
                                class="btn btn-sm btn-icon btn-secondary text-white">
                                <i class="bi bi-pencil-square"></i>
                              </a>
                              @include('pages.employee.personal-data.form.employee-contract.modal-edit')

                              <a class="btn btn-sm btn-light-danger mx-2"
                                onclick="deleteContract('{{ $contract->id }}')"><i class="bi bi-trash"></i></a>

                              <form id="deleteContractForm_{{ $contract->id }}"
                                action="{{ route('contract.destroy', $contract->id) }}" method="POST">
                                @method('DELETE')
                                @csrf
                              </form>

                            </div>
                          @endif
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
      function deleteContract(getId) {
        Swal.fire({
          title: 'Are you sure?',
          text: 'You won\'t be able to revert this!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            // If the user clicks "Yes, delete it!", submit the corresponding form
            document.getElementById('deleteContractForm_' + getId).submit();
          }
        });
      }

      function lockContract(getId) {
        Swal.fire({
          title: 'Are you sure you want to lock this contract?"',
          text: 'You won\'t be able to revert this!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, Lock it!'
        }).then((result) => {
          if (result.isConfirmed) {
            // If the user clicks "Yes, delete it!", submit the corresponding form
            document.getElementById('lockContractForm_' + getId).submit();
          }
        });
      }
    </script>
