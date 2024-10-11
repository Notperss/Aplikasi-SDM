    <!-- pendidikan -->
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="d-flex justify-content-between align-items-center ">
              <h4 class="card-title">Riwayat Pendidikan</h4>
              @can('candidate.store')
                <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
                  data-bs-target="#modal-form-add-educational-history">
                  <i class="bi bi-plus-lg"></i>
                  Add
                </button>
                @include('pages.recruitment.educational-history.modal-create')
              @endcan
            </div>
            <!-- Table with outer spacing -->
            <div class="table-responsive" style="font-size: 80%;">
              <table class="table">
                <thead>
                  <tr>
                    <th>Tingkat</th>
                    <th>Institusi</th>
                    <th>Jurusan</th>
                    <th>GPA/NEM</th>
                    <th style="text-align: center;">
                      <div>Tahun</div>
                      <div style="display: flex; justify-content: space-between;">
                        <span>Masuk</span>
                        <span>-</span>
                        <span>Keluar</span>
                      </div>
                    </th>
                    <th>Lulus/Tidak</th>
                    <th>Ijazah</th>
                    <th></th>
                  </tr>
                </thead>

                <tbody>
                  @forelse ($candidate->educationalHistories as $candidateEducationalHistory)
                    <tr>
                      <td class="text-bold-500">{{ $candidateEducationalHistory->school_level }}</td>
                      <td>{{ $candidateEducationalHistory->school_name }}</td>
                      <td class="text-bold-500">{{ $candidateEducationalHistory->study }}</td>
                      <td class="text-bold-500">{{ $candidateEducationalHistory->gpa }}</td>
                      <td style="text-align: center;">
                        <div style="display: flex; justify-content: space-between;">
                          <span>{{ $candidateEducationalHistory->year_from }}</span>
                          <span>-</span>
                          <span>{{ $candidateEducationalHistory->year_to }}</span>
                        </div>
                      </td>
                      <td class="text-bold-500">{{ $candidateEducationalHistory->graduate }}</td>
                      <td class="text-bold-500 text-center">
                        @if ($candidateEducationalHistory->file_ijazah)
                          <a href="{{ asset('storage/' . $candidateEducationalHistory->file_ijazah) }}" target="_blank"
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
                              data-bs-target="#modal-form-edit-educational-history-{{ $candidateEducationalHistory->id }}"
                              class="btn btn-sm btn-icon btn-secondary text-white">
                              <i class="bi bi-pencil-square"></i>
                            </a>
                            @include('pages.recruitment.educational-history.modal-edit')

                            <a class="btn btn-sm btn-light-danger mx-2"
                              onclick="deleteEducational('{{ $candidateEducationalHistory->id }}')"><i
                                class="bi bi-trash"></i></a>

                            <form id="deleteEducationalForm_{{ $candidateEducationalHistory->id }}"
                              action="{{ route('candidateEducationalHistory.destroy', $candidateEducationalHistory) }}"
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
