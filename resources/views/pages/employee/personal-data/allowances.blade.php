    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="d-flex justify-content-between align-items-center ">
              <h4 class="card-title">Tunjangan</h4>

              {{-- <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
                data-bs-target="#modal-form-add-social-platform">
                <i class="bi bi-plus-lg"></i>
                Add
              </button>
              @include('pages.employee.personal-data.form.social-platform.modal-create') --}}

            </div>
            <div class="table-responsive">
              <table class="table table-sm" style="font-size: 80%">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Tunjangam</th>
                    <th>Level</th>
                    <th>Tipe</th>
                    <th>Tipe Tunj. Perusahaan</th>
                    <th>Deskripsi</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($employee->position->allowances as $allowance)
                    <tr>
                      <td class="text-bold-500">{{ $loop->iteration }}</td>
                      <td class="text-bold-500">{{ $allowance->name }}</td>
                      <td class="text-bold-500">{{ $allowance->level->name }}</td>
                      <td class="text-bold-500">{{ $allowance->type }}</td>
                      <td class="text-bold-500">{{ $allowance->natura ?? '-' }}</td>
                      <td class="text-bold-500">{{ $allowance->description }}</td>
                    </tr>
                  @empty
                    <td class="text-bold-500 text-center" colspan="6">No data available in table</td>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- <script>
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
    </script> --}}
