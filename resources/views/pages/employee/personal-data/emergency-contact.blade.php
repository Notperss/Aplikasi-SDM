    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="d-flex justify-content-between align-items-center ">
              <h4 class="card-title">Kontak Darurat</h4>

              @if (!$employee->is_verified)
                <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
                  data-bs-target="#modal-form-add-emergency-contact">
                  <i class="bi bi-plus-lg"></i>
                  Add
                </button>
                @include('pages.employee.personal-data.form.emergency-contact.modal-create')
              @endif

            </div>

            <!-- Table with outer spacing -->
            <div class="table-responsive">
              {{-- <h4 class="text-center">Kontak Darurat</h4> --}}
              <table class="table" style="font-size: 80%;">
                <thead>
                  <tr>
                    <th>Hubungan</th>
                    <th>Nama</th>
                    <th>No. Telp</th>
                    <th>Alamat</th>
                    <th style="width: 13%"></th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($employee->familyDetails->where('emergency_contact',1) as $emergencyContact)
                    <tr>
                      <td class="text-bold-500">{{ $emergencyContact->relation }}</td>
                      <td class="text-bold-500">{{ $emergencyContact->name }}</td>
                      <td class="text-bold-500">{{ $emergencyContact->phone_number }}</td>
                      <td class="text-bold-500">{{ $emergencyContact->address }}</td>
                      <td class="text-bold-500">

                        @if (!$employee->is_verified)
                          <div class="demo-inline-spacing">

                            <a data-bs-toggle="modal"
                              data-bs-target="#modal-form-edit-emergency-contact-{{ $emergencyContact->id }}"
                              class="btn btn-sm btn-icon btn-secondary text-white">
                              <i class="bi bi-pencil-square"></i>
                            </a>
                            @include('pages.employee.personal-data.form.emergency-contact.modal-edit')

                            <a class="btn btn-sm btn-light-danger mx-2"
                              onclick="deleteEmergencyContact('{{ $emergencyContact->id }}')"><i
                                class="bi bi-trash"></i></a>

                            <form id="deleteEmergencyContactForm_{{ $emergencyContact->id }}"
                              action="{{ route('employeeFamilyDetail.destroy', $emergencyContact->id) }}"
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

    <script>
      function deleteEmergencyContact(getId) {
        Swal.fire({
          title: 'Are you sure?',
          text: 'You won\'t be able to revert this!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            // If the user clicks "Yes, delete it!", submit the corresponding form
            document.getElementById('deleteEmergencyContactForm_' + getId).submit();
          }
        });
      }
    </script>
