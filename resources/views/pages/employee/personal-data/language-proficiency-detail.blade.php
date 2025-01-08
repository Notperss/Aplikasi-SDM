    <div class="col-12 ">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="d-flex justify-content-between align-items-center ">
              <h4 class="card-title">Kemampuan Bahasa</h4>
              @if (!$employee->is_verified)
                <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
                  data-bs-target="#modal-form-add-language-proficiency">
                  <i class="bi bi-plus-lg"></i>
                  Add
                </button>
                @include('pages.employee.personal-data.form.language-proficiency.modal-create')
              @endif
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
                    <th style="width: 13%"></th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($employee->languageProficiencies as $employeeLanguageProficiency)
                    <tr>
                      <td>{{ $employeeLanguageProficiency->language }}</td>
                      <td>{{ $employeeLanguageProficiency->speaking }}</td>
                      <td>{{ $employeeLanguageProficiency->writing }}</td>
                      <td>{{ $employeeLanguageProficiency->reading }}</td>
                      <td>{{ $employeeLanguageProficiency->listening }}</td>
                      <td>
                        @if (!$employee->is_verified)
                          <div class="demo-inline-spacing">

                            <a data-bs-toggle="modal"
                              data-bs-target="#modal-form-edit-language-proficiency-{{ $employeeLanguageProficiency->id }}"
                              class="btn btn-sm btn-icon btn-secondary text-white">
                              <i class="bi bi-pencil-square"></i>
                            </a>
                            @include('pages.employee.personal-data.form.language-proficiency.modal-edit')

                            <a class="btn btn-sm btn-light-danger mx-2"
                              onclick="deleteLanguageProficiency('{{ $employeeLanguageProficiency->id }}')">
                              <i class="bi bi-trash"></i>
                            </a>

                            <form id="deleteLanguageProficiencyForm_{{ $employeeLanguageProficiency->id }}"
                              action="{{ route('employeeLanguageProficiency.destroy', $employeeLanguageProficiency) }}"
                              method="POST">
                              @method('DELETE')
                              @csrf
                            </form>

                          </div>
                        @endif
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
    <script>
      function deleteLanguageProficiency(getId) {
        Swal.fire({
          title: 'Are you sure?',
          text: 'You won\'t be able to revert this!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            // If the user clicks "Yes, delete it!", submit the corresponding form
            document.getElementById('deleteLanguageProficiencyForm_' + getId).submit();
          }
        });
      }
    </script>
