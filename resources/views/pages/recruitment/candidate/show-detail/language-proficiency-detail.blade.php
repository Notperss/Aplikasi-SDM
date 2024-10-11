    <div class="col-12 ">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="d-flex justify-content-between align-items-center ">
              <h4 class="card-title">Kemampuan Bahasa</h4>
              @can('candidate.store')
                <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
                  data-bs-target="#modal-form-add-language-proficiency">
                  <i class="bi bi-plus-lg"></i>
                  Add
                </button>
                @include('pages.recruitment.language-proficiency.modal-create')
              @endcan
            </div>
            <!-- Table with outer spacing -->
            <div class="table-responsive">
              <table class="table" style="font-size: 80%">
                <thead>
                  <tr>
                    <th>Bahasa</th>
                    <th>Lisan</th>
                    <th>Menulis</th>
                    <th>Membaca</th>
                    <th>Mendengar</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($candidate->languageProficiencies as $candidateLanguageProficiency)
                    <tr>
                      <td>{{ $candidateLanguageProficiency->language }}</td>
                      <td>{{ $candidateLanguageProficiency->speaking }}</td>
                      <td>{{ $candidateLanguageProficiency->writing }}</td>
                      <td>{{ $candidateLanguageProficiency->reading }}</td>
                      <td>{{ $candidateLanguageProficiency->listening }}</td>
                      <td>
                        <div class="demo-inline-spacing">

                          <a data-bs-toggle="modal"
                            data-bs-target="#modal-form-edit-language-proficiency-{{ $candidateLanguageProficiency->id }}"
                            class="btn btn-sm btn-icon btn-secondary text-white">
                            <i class="bi bi-pencil-square"></i>
                          </a>
                          @include('pages.recruitment.language-proficiency.modal-edit')

                          <a class="btn btn-sm btn-light-danger mx-2"
                            onclick="deletecandidateLanguageProficiency('{{ $candidateLanguageProficiency->id }}')">
                            <i class="bi bi-trash"></i>
                          </a>

                          <form id="deletecandidateLanguageProficiencyForm_{{ $candidateLanguageProficiency->id }}"
                            action="{{ route('candidateLanguageProficiency.destroy', $candidateLanguageProficiency) }}"
                            method="POST">
                            @method('DELETE')
                            @csrf
                          </form>

                        </div>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td class="text-center" colspan="6">No data available in table</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
