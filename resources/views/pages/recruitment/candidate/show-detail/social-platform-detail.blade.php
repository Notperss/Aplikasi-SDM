    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="d-flex justify-content-between align-items-center ">
              <h4 class="card-title">Sosial Media</h4>
              @can('candidate.store')
                <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
                  data-bs-target="#modal-form-add-social-platform">
                  <i class="bi bi-plus-lg"></i>
                  Add
                </button>
                @include('pages.recruitment.social-platform.modal-create')
              @endcan
            </div>
            <div class="table-responsive">
              <table class="table table-sm" style="font-size: 80%">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Platform</th>
                    <th>Nama Akun</th>
                    <th>Link Akun</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($candidate->socialsPlatform as $candidateSocialPlatform)
                    <tr>
                      <td class="text-bold-500">{{ $loop->iteration }}</td>
                      <td class="text-bold-500">{{ $candidateSocialPlatform->platform }}</td>
                      <td class="text-bold-500">{{ $candidateSocialPlatform->account_name }}</td>
                      <td class="text-bold-500">
                        <a href="{{ $candidateSocialPlatform->account_link }}"
                          target="_blank">{{ $candidateSocialPlatform->account_link }}</a>
                      </td>
                      <td>
                        @can('candidate.update')
                          <div class="demo-inline-spacing">

                            <a data-bs-toggle="modal"
                              data-bs-target="#modal-form-edit-social-platform-{{ $candidateSocialPlatform->id }}"
                              class="btn btn-sm btn-icon btn-secondary text-white">
                              <i class="bi bi-pencil-square"></i>
                            </a>
                            @include('pages.recruitment.social-platform.modal-edit')

                            <a class="btn btn-sm btn-light-danger mx-2"
                              onclick="deletecandidateSocialPlatform('{{ $candidateSocialPlatform->id }}')">
                              <i class="bi bi-trash"></i>
                            </a>

                            <form id="deletecandidateSocialPlatformForm_{{ $candidateSocialPlatform->id }}"
                              action="{{ route('candidateSocialPlatform.destroy', $candidateSocialPlatform) }}"
                              method="POST">
                              @method('DELETE')
                              @csrf
                            </form>

                          </div>
                        @endcan
                      </td>
                    </tr>
                  @empty
                    <td class="text-bold-500 text-center" colspan="5">No data available in table</td>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
