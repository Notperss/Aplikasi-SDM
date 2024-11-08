    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="d-flex justify-content-between align-items-center ">
              <h4 class="card-title">Data Keluarga</h4>

              <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
                data-bs-target="#modal-form-add-family-details">
                <i class="bi bi-plus-lg"></i>
                Add
              </button>
              @include('pages.employee.personal-data.form.family-details.modal-create')

            </div>

            <!-- Table with outer spacing -->
            <div class="table-responsive">
              <h4 class="text-center">Keluarga Kandung</h4>
              <table class="table" style="font-size: 80%;">
                <thead>
                  <tr>
                    <th>Hubungan</th>
                    <th>Nama</th>
                    <th>L/P</th>
                    <th>Tgl Lahir</th>
                    <th>No. Telp</th>
                    <th>Pendidikan</th>
                    <th>Pekerjaan</th>
                    <th>Alamat</th>
                    <th style="width: 13%"></th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $orderedRelations = ['BAPAK', 'IBU', 'SAUDARA KANDUNG', 'SAUDARA TIRI'];

                    $sortedFamilyDetails = $employee->familyDetails
                        ->whereIn('relation', $orderedRelations)
                        ->sortBy(function ($employeeFamilyDetail) use ($orderedRelations) {
                            return array_search($employeeFamilyDetail->relation, $orderedRelations);
                        });
                  @endphp
                  @forelse ($sortedFamilyDetails as $employeeFamilyDetail)
                    <tr>
                      <td class="text-bold-500">{{ $employeeFamilyDetail->relation }}</td>
                      <td>{{ $employeeFamilyDetail->name }}</td>
                      <td class="text-bold-500">{{ $employeeFamilyDetail->gender }}</td>
                      <td class="text-bold-500">
                        {{ Carbon\Carbon::parse($employeeFamilyDetail->dob_family)->translatedFormat('d F Y') }}
                      </td>
                      <td class="text-bold-500">{{ $employeeFamilyDetail->phone_number }}</td>
                      <td class="text-bold-500">{{ $employeeFamilyDetail->education }}</td>
                      <td class="text-bold-500">{{ $employeeFamilyDetail->job }}</td>
                      <td class="text-bold-500">{{ $employeeFamilyDetail->address }}</td>
                      <td class="text-bold-500">

                        <div class="demo-inline-spacing">

                          <a data-bs-toggle="modal"
                            data-bs-target="#modal-form-edit-family-details-{{ $employeeFamilyDetail->id }}"
                            class="btn btn-sm btn-icon btn-secondary text-white">
                            <i class="bi bi-pencil-square"></i>
                          </a>
                          @include('pages.employee.personal-data.form.family-details.modal-edit')

                          <a class="btn btn-sm btn-light-danger mx-2"
                            onclick="deleteFamilyDetail('{{ $employeeFamilyDetail->id }}')"><i
                              class="bi bi-trash"></i></a>

                          <form id="deleteFamilyDetailForm_{{ $employeeFamilyDetail->id }}"
                            action="{{ route('employeeFamilyDetail.destroy', $employeeFamilyDetail->id) }}"
                            method="POST">
                            @method('DELETE')
                            @csrf
                          </form>
                        </div>

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
            <hr class="my-4">
            <!-- Table with outer spacing -->
            <div class="table-responsive">
              <h4 class="text-center">Keluarga KK</h4>
              <table class="table" style="font-size: 80%;">
                <thead>
                  <tr>
                    <th>Hubungan</th>
                    <th>Nama</th>
                    <th>L/P</th>
                    <th>Tgl Lahir</th>
                    <th>No. Telp</th>
                    <th>Pendidikan</th>
                    <th>Pekerjaan</th>
                    <th>Alamat</th>
                    <th style="width: 13%"></th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $orderedRelations = ['SUAMI', 'ISTRI', 'ANAK', 'BAPAK', 'IBU', 'SAUDARA KANDUNG', 'SAUDARA TIRI'];

                    $sortedFamilyDetails = $employee->familyDetails
                        ->where('is_in_kk', true)
                        ->whereIn('relation', $orderedRelations)
                        ->sortBy(function ($employeeFamilyDetail) use ($orderedRelations) {
                            return array_search($employeeFamilyDetail->relation, $orderedRelations);
                        });
                  @endphp
                  @forelse ($sortedFamilyDetails as $employeeFamilyDetail)
                    <tr>
                      <td class="text-bold-500">{{ $employeeFamilyDetail->relation }}</td>
                      <td>{{ $employeeFamilyDetail->name }}</td>
                      <td class="text-bold-500">{{ $employeeFamilyDetail->gender }}</td>
                      <td class="text-bold-500">
                        {{ Carbon\Carbon::parse($employeeFamilyDetail->dob_family)->translatedFormat('d F Y') }}
                      </td>
                      <td class="text-bold-500">{{ $employeeFamilyDetail->phone_number }}</td>
                      <td class="text-bold-500">{{ $employeeFamilyDetail->education }}</td>
                      <td class="text-bold-500">{{ $employeeFamilyDetail->job }}</td>
                      <td class="text-bold-500">{{ $employeeFamilyDetail->address }}</td>
                      <td class="text-bold-500">
                        <div class="demo-inline-spacing">

                          <a data-bs-toggle="modal"
                            data-bs-target="#modal-form-edit-family-details-{{ $employeeFamilyDetail->id }}"
                            class="btn btn-sm btn-icon btn-secondary text-white">
                            <i class="bi bi-pencil-square"></i>
                          </a>
                          @include('pages.employee.personal-data.form.family-details.modal-edit')

                          <a class="btn btn-sm btn-light-danger mx-2"
                            onclick="deleteFamilyDetail('{{ $employeeFamilyDetail->id }}')"><i
                              class="bi bi-trash"></i></a>

                          <form id="deleteFamilyDetailForm_{{ $employeeFamilyDetail->id }}"
                            action="{{ route('employeeFamilyDetail.destroy', $employeeFamilyDetail->id) }}"
                            method="POST">
                            @method('DELETE')
                            @csrf
                          </form>
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
      function deleteFamilyDetail(getId) {
        Swal.fire({
          title: 'Are you sure?',
          text: 'You won\'t be able to revert this!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            // If the user clicks "Yes, delete it!", submit the corresponding form
            document.getElementById('deleteFamilyDetailForm_' + getId).submit();
          }
        });
      }
    </script>
