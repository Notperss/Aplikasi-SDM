    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="d-flex justify-content-between align-items-center ">
              <h4 class="card-title">Riwayat Pekerjaan</h4>
              @can('candidate.store')
                <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
                  data-bs-target="#modal-form-add-employment-history">
                  <i class="bi bi-plus-lg"></i>
                  Add
                </button>
                @include('pages.recruitment.employment-history.modal-create')
              @endcan
            </div>
            <!-- Table with outer spacing -->
            <div class="table-responsive">
              <table class="table" style="font-size: 80%;">
                <thead>
                  <tr>
                    <th>Nama Perusahaan</th>
                    <th>Posisi </th>
                    <th>Atasan</th>
                    <th style="text-align: center;">
                      <div>Lama Bekerja</div>
                      <div style="display: flex; justify-content: space-between;">
                        <span>Masuk</span>
                        <span>-</span>
                        <span>Keluar</span>
                      </div>
                    </th>
                    <th>Gaji</th>
                    <th>Alasan Berhenti</th>
                    <th>File</th>
                    <th style="width: 13%"></th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($candidate->employmentHistories as $candidateEmploymentHistory)
                    <tr>
                      <td>{{ $candidateEmploymentHistory->company_name }}</td>
                      <td class="text-bold-500">{{ $candidateEmploymentHistory->position }}</td>
                      <td class="text-bold-500">{{ $candidateEmploymentHistory->direct_supervisor }}</td>
                      <td style="text-align: center;">
                        <div style="display: flex; justify-content: space-between;">
                          <span>{{ $candidateEmploymentHistory->year_from }}</span>
                          <span>-</span>
                          <span>{{ $candidateEmploymentHistory->year_to }}</span>
                        </div>
                      </td>
                      <td class="text-bold-500">Rp.
                        {{ number_format($candidateEmploymentHistory->salary, 0, ',', '.') }}
                      </td>
                      <td class="text-bold-500">{{ $candidateEmploymentHistory->reason }}</td>
                      <td class="text-bold-500 text-center">
                        @if ($candidateEmploymentHistory->file)
                          <a href="{{ asset('storage/' . $candidateEmploymentHistory->file) }}" target="_blank"
                            class="text-sm">
                            Lihat
                          </a>
                        @else
                          <span>-</span>
                        @endif
                      </td>
                      <td>
                        @can('candidate.update')
                          <div class="demo-inline-spacing">
                            <a data-bs-toggle="modal"
                              data-bs-target="#modal-form-edit-employment-history-{{ $candidateEmploymentHistory->id }}"
                              class="btn btn-icon btn-sm btn-secondary text-white">
                              <i class="bi bi-pencil-square"></i>
                            </a>
                            @include('pages.recruitment.employment-history.modal-edit')

                            <a class="btn btn-sm btn-light-danger mx-2"
                              onclick="deleteEmploymenHistory('{{ $candidateEmploymentHistory->id }}')"><i
                                class="bi bi-trash"></i></a>

                            <form id="deleteCandidateEmploymentHistoryForm_{{ $candidateEmploymentHistory->id }}"
                              action="{{ route('candidateEmploymentHistory.destroy', $candidateEmploymentHistory) }}"
                              method="POST">
                              @method('DELETE')
                              @csrf
                            </form>
                          </div>
                        @endcan
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td class="text-center" colspan="8">No data available in table</td>
                    </tr>
                  @endforelse

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
