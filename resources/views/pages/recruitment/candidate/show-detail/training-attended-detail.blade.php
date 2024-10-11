    <div class="col-12">
      <div class="card">
        <div class="card-body">

          <div class="row">
            <div class="d-flex justify-content-between align-items-center ">
              <h4 class="card-title">Seminar/Pelatihan</h4>
              @can('candidate.store')
                <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
                  data-bs-target="#modal-form-add-training-attended">
                  <i class="bi bi-plus-lg"></i>
                  Add
                </button>
                @include('pages.recruitment.training-attended.modal-create')
              @endcan
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
                  @forelse ($candidate->trainingAttendeds as $candidateTrainingAttended)
                    <tr>
                      <td class="text-bold-500">{{ $loop->iteration }}</td>
                      <td class="text-bold-500">{{ $candidateTrainingAttended->training_name }}</td>
                      <td class="text-bold-500">{{ $candidateTrainingAttended->organizer_name }}</td>
                      <td class="text-bold-500">{{ $candidateTrainingAttended->city }}</td>
                      <td class="text-bold-500">{{ $candidateTrainingAttended->year }}</td>
                      <td class="text-bold-500">
                        @if ($candidateTrainingAttended->file_sertifikat)
                          <a href="{{ Storage::url($candidateTrainingAttended->file_sertifikat) }}" target="_blank">
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
                              data-bs-target="#modal-form-edit-training-attended-{{ $candidateTrainingAttended->id }}"
                              class="btn btn-sm btn-icon btn-secondary text-white">
                              <i class="bi bi-pencil-square"></i>
                            </a>
                            @include('pages.recruitment.training-attended.modal-edit')

                            <a class="btn btn-sm btn-light-danger mx-2"
                              onclick="deleteTrainingAttend('{{ $candidateTrainingAttended->id }}')"><i
                                class="bi bi-trash"></i></a>

                            <form id="deleteTrainingAttendForm_{{ $candidateTrainingAttended->id }}"
                              action="{{ route('candidateTrainingAttended.destroy', $candidateTrainingAttended->id) }}"
                              method="POST">
                              @method('DELETE')
                              @csrf
                            </form>

                          </div>
                        @endcan
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
