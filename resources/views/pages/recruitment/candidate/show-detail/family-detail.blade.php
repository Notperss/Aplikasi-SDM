    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="d-flex justify-content-between align-items-center ">
              <h4 class="card-title">Data Keluarga</h4>
              @can('candidate.store')
                <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
                  data-bs-target="#modal-form-add-family-details">
                  <i class="bi bi-plus-lg"></i>
                  Add
                </button>
                @include('pages.recruitment.family-details.modal-create')
              @endcan
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

                    $sortedFamilyDetails = $candidate->familyDetails
                        ->whereIn('relation', $orderedRelations)
                        ->sortBy(function ($candidateFamilyDetail) use ($orderedRelations) {
                            return array_search($candidateFamilyDetail->relation, $orderedRelations);
                        });
                  @endphp
                  @forelse ($sortedFamilyDetails as $candidateFamilyDetail)
                    <tr>
                      <td class="text-bold-500">{{ $candidateFamilyDetail->relation }}</td>
                      <td>{{ $candidateFamilyDetail->name }}</td>
                      <td class="text-bold-500">{{ $candidateFamilyDetail->gender }}</td>
                      <td class="text-bold-500">
                        {{ Carbon\Carbon::parse($candidateFamilyDetail->dob_family)->translatedFormat('d F Y') }}
                      </td>
                      <td class="text-bold-500">{{ $candidateFamilyDetail->phone_number }}</td>
                      <td class="text-bold-500">{{ $candidateFamilyDetail->education }}</td>
                      <td class="text-bold-500">{{ $candidateFamilyDetail->job }}</td>
                      <td class="text-bold-500">{{ $candidateFamilyDetail->address }}</td>
                      <td class="text-bold-500">
                        @can('candidate.update')
                          <div class="demo-inline-spacing">

                            <a data-bs-toggle="modal"
                              data-bs-target="#modal-form-edit-family-details-{{ $candidateFamilyDetail->id }}"
                              class="btn btn-sm btn-icon btn-secondary text-white">
                              <i class="bi bi-pencil-square"></i>
                            </a>
                            @include('pages.recruitment.family-details.modal-edit')

                            <a class="btn btn-sm btn-light-danger mx-2"
                              onclick="deleteFamilyDetail('{{ $candidateFamilyDetail->id }}')"><i
                                class="bi bi-trash"></i></a>

                            <form id="deleteFamilyDetailForm_{{ $candidateFamilyDetail->id }}"
                              action="{{ route('candidateFamilyDetail.destroy', $candidateFamilyDetail->id) }}"
                              method="POST">
                              @method('DELETE')
                              @csrf
                            </form>
                          </div>
                        @endcan
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

                    $sortedFamilyDetails = $candidate->familyDetails
                        ->where('is_in_kk', true)
                        ->whereIn('relation', $orderedRelations)
                        ->sortBy(function ($candidateFamilyDetail) use ($orderedRelations) {
                            return array_search($candidateFamilyDetail->relation, $orderedRelations);
                        });
                  @endphp
                  @forelse ($sortedFamilyDetails as $candidateFamilyDetail)
                    <tr>
                      <td class="text-bold-500">{{ $candidateFamilyDetail->relation }}</td>
                      <td>{{ $candidateFamilyDetail->name }}</td>
                      <td class="text-bold-500">{{ $candidateFamilyDetail->gender }}</td>
                      <td class="text-bold-500">
                        {{ Carbon\Carbon::parse($candidateFamilyDetail->dob_family)->translatedFormat('d F Y') }}
                      </td>
                      <td class="text-bold-500">{{ $candidateFamilyDetail->phone_number }}</td>
                      <td class="text-bold-500">{{ $candidateFamilyDetail->education }}</td>
                      <td class="text-bold-500">{{ $candidateFamilyDetail->job }}</td>
                      <td class="text-bold-500">{{ $candidateFamilyDetail->address }}</td>
                      <td class="text-bold-500">
                        <div class="demo-inline-spacing">

                          <a data-bs-toggle="modal"
                            data-bs-target="#modal-form-edit-family-details-{{ $candidateFamilyDetail->id }}"
                            class="btn btn-sm btn-icon btn-secondary text-white">
                            <i class="bi bi-pencil-square"></i>
                          </a>
                          @include('pages.recruitment.family-details.modal-edit')

                          <a class="btn btn-sm btn-light-danger mx-2"
                            onclick="deleteFamilyDetail('{{ $candidateFamilyDetail->id }}')"><i
                              class="bi bi-trash"></i></a>

                          <form id="deleteFamilyDetailForm_{{ $candidateFamilyDetail->id }}"
                            action="{{ route('candidateFamilyDetail.destroy', $candidateFamilyDetail->id) }}"
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
