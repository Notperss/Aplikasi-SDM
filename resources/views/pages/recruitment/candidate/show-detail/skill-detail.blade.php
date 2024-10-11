    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="d-flex justify-content-between align-items-center ">
              <h4 class="card-title">Keterampilan/Kompetensi</h4>
              @can('candidate.store')
                <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
                  data-bs-target="#modal-form-add-skill">
                  <i class="bi bi-plus-lg"></i>
                  Add
                </button>
                @include('pages.recruitment.skill.modal-create')
              @endcan
            </div>
            <div class="table-responsive">
              <table class="table table-sm" style="font-size: 80%">
                <thead>
                  <tr>
                    <th>Nama Keterampilan/Kompetensi</th>
                    <th>Kemahiran</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($candidate->skills as $candidateSkill)
                    <tr>
                      <td class="text-bold-500">{{ $candidateSkill->name }}</td>
                      <td class="text-bold-500">
                        {{ $candidateSkill->mastery }}
                      </td>
                      <td>
                        @can('candidate.update')
                          <div class="demo-inline-spacing">
                            <a data-bs-toggle="modal" data-bs-target="#modal-form-edit-skill-{{ $candidateSkill->id }}"
                              class="btn btn-icon btn-secondary text-white">
                              <i class="bi bi-pencil-square"></i>
                            </a>
                            @include('pages.recruitment.skill.modal-edit')

                            <a onclick="deleteskill('{{ $candidateSkill->id }}')" title="Delete"
                              class="btn btn-light-danger">
                              <i class="bi bi-trash"></i>
                            </a>
                            <form id="deleteskillForm_{{ $candidateSkill->id }}"
                              action="{{ route('candidateSkill.destroy', $candidateSkill->id) }}" method="POST">
                              @method('DELETE')
                              @csrf
                            </form>
                          </div>
                        @endcan
                      </td>
                    </tr>
                  @empty
                    <td class="text-bold-500 text-center" colspan="3">No data available in table</td>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
