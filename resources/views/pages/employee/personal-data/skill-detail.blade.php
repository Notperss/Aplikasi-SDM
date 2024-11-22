    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="d-flex justify-content-between align-items-center ">
              <h4 class="card-title">Keterampilan/Kompetensi</h4>
              @if (!$employee->is_verified)
                <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
                  data-bs-target="#modal-form-add-skill">
                  <i class="bi bi-plus-lg"></i>
                  Add
                </button>
                @include('pages.employee.personal-data.form.skill.modal-create')
              @endif
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
                  @forelse ($employee->skills as $employeeSkill)
                    <tr>
                      <td class="text-bold-500">{{ $employeeSkill->name }}</td>
                      <td class="text-bold-500">
                        {{ $employeeSkill->mastery }}
                      </td>
                      <td>
                        @if (!$employee->is_verified)
                          <div class="demo-inline-spacing">
                            <a data-bs-toggle="modal" data-bs-target="#modal-form-edit-skill-{{ $employeeSkill->id }}"
                              class="btn btn-icon btn-secondary text-white">
                              <i class="bi bi-pencil-square"></i>
                            </a>
                            @include('pages.employee.personal-data.form.skill.modal-edit')

                            <a onclick="deleteskill('{{ $employeeSkill->id }}')" title="Delete"
                              class="btn btn-light-danger">
                              <i class="bi bi-trash"></i>
                            </a>
                            <form id="deleteskillForm_{{ $employeeSkill->id }}"
                              action="{{ route('employeeSkill.destroy', $employeeSkill->id) }}" method="POST">
                              @method('DELETE')
                              @csrf
                            </form>
                          </div>
                        @endif
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


    <script>
      function deleteskill(getId) {
        Swal.fire({
          title: 'Are you sure?',
          text: 'You won\'t be able to revert this!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            // If the user clicks "Yes, delete it!", submit the corresponding form
            document.getElementById('deleteskillForm_' + getId).submit();
          }
        });
      }
    </script>
