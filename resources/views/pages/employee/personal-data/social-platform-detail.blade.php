    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="d-flex justify-content-between align-items-center ">
              <h4 class="card-title">Sosial Media</h4>
              @if (!$employee->is_verified)
                <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
                  data-bs-target="#modal-form-add-social-platform">
                  <i class="bi bi-plus-lg"></i>
                  Add
                </button>
                @include('pages.employee.personal-data.form.social-platform.modal-create')
              @endif
            </div>
            <div class="table-responsive">
              <table class="table table-sm" style="font-size: 80%">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Platform</th>
                    <th>Nama Akun</th>
                    <th>Link Akun</th>
                    <th style="width: 13%"></th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($employee->socialsPlatform as $employeeSocialPlatform)
                    <tr>
                      <td class="text-bold-500">{{ $loop->iteration }}</td>
                      <td class="text-bold-500">{{ $employeeSocialPlatform->platform }}</td>
                      <td class="text-bold-500">{{ $employeeSocialPlatform->account_name }}</td>
                      <td class="text-bold-500">
                        <a href="{{ $employeeSocialPlatform->account_link }}"
                          target="_blank">{{ $employeeSocialPlatform->account_link }}</a>
                      </td>
                      <td>
                        @if (!$employee->is_verified)
                          <div class="demo-inline-spacing">

                            <a data-bs-toggle="modal"
                              data-bs-target="#modal-form-edit-social-platform-{{ $employeeSocialPlatform->id }}"
                              class="btn btn-sm btn-icon btn-secondary text-white">
                              <i class="bi bi-pencil-square"></i>
                            </a>
                            @include('pages.employee.personal-data.form.social-platform.modal-edit')

                            <a class="btn btn-sm btn-light-danger mx-2"
                              onclick="deleteemployeeSocialPlatform('{{ $employeeSocialPlatform->id }}')">
                              <i class="bi bi-trash"></i>
                            </a>

                            <form id="deleteemployeeSocialPlatformForm_{{ $employeeSocialPlatform->id }}"
                              action="{{ route('employeeSocialPlatform.destroy', $employeeSocialPlatform) }}"
                              method="POST">
                              @method('DELETE')
                              @csrf
                            </form>

                          </div>
                        @endif
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

    <script>
      function deletecandidateSocialPlatform(getId) {
        Swal.fire({
          title: 'Are you sure?',
          text: 'You won\'t be able to revert this!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            // If the user clicks "Yes, delete it!", submit the corresponding form
            document.getElementById('deletecandidateSocialPlatformForm_' + getId).submit();
          }
        });
      }
    </script>
