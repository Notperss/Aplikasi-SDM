@extends('layouts.auth')
@section('title', 'Candidate')
@section('content')

  {{-- @section('breadcrumb')
  <x-breadcrumb title="Data Diri Pelamar" page="Recruitment" active="Candidate" route="{{ route('candidate.index') }}" />
@endsection --}}

  <nav class="navbar navbar-light">
    <div class="container d-block">
      <a href="{{ url()->previous() }}"><i class="bi bi-chevron-left"></i></a>
      <a class="btn btn-primary ms-4" href="{{ url()->previous() }}">
        Back
      </a>
    </div>
  </nav>


  <section class="section">
    <div class="row justify-content-center">

      <div class="col-12 text-center mb-3">
        <h3>Data Lengkap {{ $candidate->name }}</h3>
      </div>

      <div class="col-12 col-lg-3">
        <div class="card-body mb-2">
          <div class="d-flex justify-content-center align-items-center flex-column">

            <!-- Image Preview -->
            <img src="{{ asset($candidate->photo ? 'storage/' . $candidate->photo : 'storage/img/2.jpg') }}"
              alt="user-avatar" class="d-block rounded" width="150px" id="uploadedAvatar" />

            <!-- Upload Icon and Input -->
            <label for="photo" class="mt-2" style="text-align: center; display: block; width: 100%;">
              <span>{{ $candidate->name }}</span>
            </label>
          </div>

          <div class="card mt-3">
            <div class="card-content">
              <div class="card-body">

                <div class="mb-3">
                  <label for="file_cv" class="form-label">CV</label> <br>
                  @if ($candidate->file_cv)
                    <a href="{{ Storage::url($candidate->file_cv) }}" target="_blank" class="text-sm">
                      {{ pathinfo($candidate->file_cv, PATHINFO_FILENAME) }}
                    </a>
                  @else
                    <span>-</span>
                  @endif
                </div>
                <div class="mb-3">
                  <label for="file_ktp" class="form-label">KTP & NPWP</label><br>
                  @if ($candidate->file_ktp)
                    <a href="{{ Storage::url($candidate->file_ktp) }}" target="_blank" class="text-sm">
                      {{ pathinfo($candidate->file_ktp, PATHINFO_FILENAME) }}
                    </a>
                  @else
                    <span>-</span>
                  @endif
                </div>
                <div class="mb-3">
                  <label for="file_skck" class="form-label">SKCK AKTIF</label><br>
                  @if ($candidate->file_skck)
                    <a href="{{ Storage::url($candidate->file_skck) }}" target="_blank" class="text-sm">
                      {{ pathinfo($candidate->file_skck, PATHINFO_FILENAME) }}
                    </a>
                  @else
                    <span>-</span>
                  @endif
                </div>
                <div class="mb-3">
                  <label for="file_kk" class="form-label">KARTU KELUARGA</label><br>
                  @if ($candidate->file_kk)
                    <a href="{{ Storage::url($candidate->file_kk) }}" target="_blank" class="text-sm">
                      {{ pathinfo($candidate->file_kk, PATHINFO_FILENAME) }}
                    </a>
                  @else
                    <span>-</span>
                  @endif

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-lg-7">
        <div class="card">
          <div class="card-body">
            <div class="row">

              <div class="col-md-6 col-12">
                <div class="form-group">
                  <label for="name">Nama Lengkap</label>
                  <input type="text" id="name" value="{{ old('name', $candidate->name) }}"
                    class="form-control @error('name') is-invalid @enderror" name="name" readonly>
                </div>
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" id="email" value="{{ old('email', $candidate->email) }}"
                    class="form-control @error('email') is-invalid @enderror" name="email" readonly>
                </div>
                <div class="form-group">
                  <label for="phone_number">No. Telp</label>
                  <input type="text" id="phone_number" value="{{ old('phone_number', $candidate->phone_number) }}"
                    maxlength="13" oninput="this.value = this.value.replace(/\D+/g, '')"
                    class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" readonly>
                </div>
                <div class="form-group">
                  <label for="ktp_number">No. KTP</label>
                  <input type="text" id="ktp_number" value="{{ old('ktp_number', $candidate->ktp_number) }}"
                    maxlength="16" oninput="this.value = this.value.replace(/\D+/g, '')"
                    class="form-control @error('ktp_number') is-invalid @enderror" name="ktp_number" readonly>
                </div>
                <div class="form-group">
                  <label for="kk_number">No. Kartu Keluarga</label>
                  <input type="text" id="kk_number" value="{{ old('kk_number', $candidate->kk_number) }}"
                    maxlength="16" oninput="this.value = this.value.replace(/\D+/g, '')"
                    class="form-control @error('kk_number') is-invalid @enderror" name="kk_number" readonly>
                </div>
                <div class="form-group">
                  <label for="npwp_number">Jabatan Yang Dilamar</label>
                  <input type="text" inputmode="numeric"
                    value="{{ old('npwp_number', $candidate->applied_position) }}" maxlength="16"
                    oninput="this.value = this.value.replace(/\D+/g, '')" id="npwp_number"
                    class="form-control @error('npwp_number') is-invalid @enderror" name="npwp_number" readonly>
                </div>
                <div class="form-group">
                  <label for="npwp_number">Rekomendasi Penempatan</label>
                  <input type="text" inputmode="numeric"
                    value="{{ old('npwp_number', $candidate->recommended_position) }}" maxlength="16"
                    oninput="this.value = this.value.replace(/\D+/g, '')" id="npwp_number"
                    class="form-control @error('npwp_number') is-invalid @enderror" name="npwp_number" readonly>
                </div>
                <div class="form-group">
                  <label for="npwp_number">Status Perkawinan </label>
                  <input type="text" inputmode="numeric"
                    value="{{ old('npwp_number', $candidate->marital_status) }}" maxlength="16" id="npwp_number"
                    class="form-control @error('npwp_number') is-invalid @enderror" name="npwp_number" readonly>
                </div>
                <div class="form-group">
                  <label for="ktp_address">Alamat Sesuai KTP</label>
                  <textarea type="text" id="ktp_address" class="form-control  @error('ktp_address') is-invalid @enderror"
                    name="ktp_address" rows="5" readonly> {{ old('ktp_address', $candidate->ktp_address) }}</textarea>
                </div>
              </div>

              <div class="col-md-6 col-12">
                <div class="form-group">
                  <label for="pob">Tempat Lahir</label>
                  <input type="text" id="pob" value="{{ old('pob', $candidate->pob) }}"
                    class="form-control @error('pob') is-invalid @enderror" name="pob" readonly>
                </div>
                <div class="form-group">
                  <label for="dob">Tanggal Lahir </label>
                  {{-- <label for="dob">Tanggal Lahir {{ $ageInYears }} tahun {{ $ageInMonths }} bulan</label> --}}
                  <input type="date" id="dob" name="dob" value="{{ old('dob', $candidate->dob) }}"
                    class="form-control @error('dob') is-invalid @enderror" placeholder="Select date.." readonly>
                </div>
                <div class="form-group">
                  <label for="gender">Jenis Kelamin</label>
                  <select name="gender" id="gender" class="form-control  @error('gender') is-invalid @enderror"
                    disabled>
                    <option value="" disabled selected>Choose</option>
                    <option value="LAKI-LAKI" {{ old('gender', $candidate->gender) == 'LAKI-LAKI' ? 'selected' : '' }}>
                      Laki-laki
                    </option>
                    <option value="PEREMPUAN" {{ old('gender', $candidate->gender) == 'PEREMPUAN' ? 'selected' : '' }}>
                      Perempuan
                    </option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="religion">Agama</label>
                  <input type="text" id="religion" value="{{ old('religion', $candidate->religion) }}"
                    class="form-control @error('religion') is-invalid @enderror" name="religion" readonly>
                </div>
                <div class="form-group">
                  <label for="nationality">Kewarganegaraan</label>
                  <input type="text" value="{{ old('nationality', $candidate->nationality) }}" id="nationality"
                    class="form-control @error('nationality') is-invalid @enderror" name="nationality" readonly>
                </div>
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="ethnic">Suku Bangsa</label>
                    <input type="text" value="{{ old('ethnic', $candidate->ethnic) }}" id="ethnic"
                      class="form-control @error('ethnic') is-invalid @enderror" maxlength="3"
                      oninput="this.value = this.value.replace(/\D+/g, '')" name="ethnic" readonly>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="blood_type">Gol. Darah</label>
                    <input type="text" value="{{ old('blood_type', $candidate->blood_type) }}" id="blood_type"
                      class="form-control  @error('blood_type') is-invalid @enderror" maxlength="3"
                      oninput="this.value = this.value.replace(/\D+/g, '')" name="blood_type" readonly>
                  </div>
                </div>
                <div class="form-group">
                  <label for="candidate_from">Pelamar Dari</label>
                  <input type="text" value="{{ old('candidate_from', $candidate->candidate_from) }}"
                    id="candidate_from" class="form-control @error('candidate_from') is-invalid @enderror"
                    name="candidate_from" readonly>
                </div>
                <div class="form-group">
                  <label for="current_address">Alamat Sekarang</label>
                  <textarea type="text" id="current_address" class="form-control @error('current_address') is-invalid @enderror"
                    name="current_address" rows="5" readonly> {{ old('current_address', $candidate->current_address) }}</textarea>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>

      <!-- data keluarga -->
      <div class="col-12 col-lg-10">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <h3>Data Keluarga</h3>

              <!-- Table with outer spacing -->
              <div class="table-responsive">
                <h4 class="text-center">Keluarga kandung</h4>
                <table class="table">
                  <thead>
                    <tr>
                      <th>Hubungan</th>
                      <th>Nama</th>
                      <th>L/P</th>
                      <th>Pendidikan</th>
                      <th>Pekerjaan</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                      $orderedRelations = ['BAPAK', 'IBU', 'SAUDARA KANDUNG'];

                      $sortedFamilyDetails = $candidate->familyDetails
                          ->whereIn('relation', $orderedRelations)
                          ->sortBy(function ($familyDetail) use ($orderedRelations) {
                              return array_search($familyDetail->relation, $orderedRelations);
                          });
                    @endphp
                    @forelse ($sortedFamilyDetails as $familyDetail)
                      <tr>
                        <td class="text-bold-500">{{ $familyDetail->relation }}</td>
                        <td>{{ $familyDetail->name }}</td>
                        <td class="text-bold-500">{{ $familyDetail->gender }}</td>
                        <td class="text-bold-500">{{ $familyDetail->education }}</td>
                        <td class="text-bold-500">{{ $familyDetail->job }}</td>
                      </tr>
                    @empty
                      <tr>
                        <td class="text-center" colspan="5">No data available in table</td>
                      </tr>
                    @endforelse

                  </tbody>
                </table>
              </div>
              <hr class="my-4">
              <!-- Table with outer spacing -->
              <div class="table-responsive">
                <h4 class="text-center">Keluarga KK</h4>
                <table class="table">
                  <thead>
                    <tr>
                      <th>Hubungan</th>
                      <th>Nama</th>
                      <th>L/P</th>
                      <th>Pendidikan</th>
                      <th>Pekerjaan</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                      $orderedRelations = ['SUAMI', 'ISTRI', 'ANAK'];

                      $sortedFamilyDetails = $candidate->familyDetails
                          ->whereIn('relation', $orderedRelations)
                          ->sortBy(function ($familyDetail) use ($orderedRelations) {
                              return array_search($familyDetail->relation, $orderedRelations);
                          });
                    @endphp
                    @forelse ($sortedFamilyDetails as $familyDetail)
                      <tr>
                        <td class="text-bold-500">{{ $familyDetail->relation }}</td>
                        <td>{{ $familyDetail->name }}</td>
                        <td class="text-bold-500">{{ $familyDetail->gender }}</td>
                        <td class="text-bold-500">{{ $familyDetail->education }}</td>
                        <td class="text-bold-500">{{ $familyDetail->job }}</td>
                      </tr>
                    @empty
                      <tr>
                        <td class="text-center" colspan="5">No data available in table</td>
                      </tr>
                    @endforelse

                  </tbody>
                </table>
              </div>

            </div>
          </div>
        </div>
      </div>

      <!-- pendidikan -->
      <div class="col-12 col-lg-10">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <h3>Riwayat Pendidikan</h3>
              <!-- Table with outer spacing -->
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Tingkat</th>
                      <th>Institusi</th>
                      <th>Jurusan</th>
                      <th>GPA/NEM</th>
                      <th style="text-align: center;">
                        <div>Tahun</div>
                        <div style="display: flex; justify-content: space-between;">
                          <span>Masuk</span>
                          <span>-</span>
                          <span>Keluar</span>
                        </div>
                      </th>
                      <th>Ijazah</th>
                    </tr>
                  </thead>

                  <tbody>
                    @forelse ($candidate->educationalHistories as $educationalHistory)
                      <tr>
                        <td class="text-bold-500">{{ $educationalHistory->school_level }}</td>
                        <td>{{ $educationalHistory->school_name }}</td>
                        <td class="text-bold-500">{{ $educationalHistory->study }}</td>
                        <td class="text-bold-500">{{ $educationalHistory->gpa }}</td>
                        <td style="text-align: center;">
                          <div style="display: flex; justify-content: space-between;">
                            <span>{{ $educationalHistory->year_from }}</span>
                            <span>-</span>
                            <span>{{ $educationalHistory->year_to }}</span>
                          </div>
                        </td>
                        <td class="text-bold-500 text-center">
                          @if ($educationalHistory->file_ijazah)
                            <a href="{{ Storage::url($educationalHistory->file_ijazah) }}" target="_blank"
                              class="text-sm">
                              Lihat
                            </a>
                          @else
                            <span>-</span>
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

      <!-- pengalaman -->
      <div class="col-12 col-lg-10">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <h3>Pengalaman Kerja</h3>
              <!-- Table with outer spacing -->
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Nama Perusahaan</th>
                      <th style="text-align: center;">
                        <div>Lama Bekerja</div>
                        <div style="display: flex; justify-content: space-between;">
                          <span>Masuk</span>
                          <span>-</span>
                          <span>Keluar</span>
                        </div>
                      </th>
                      <th>Posisi Terakhir</th>
                      <th>Gaji</th>
                      <th>Alasan Berhenti</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($candidate->employmentHistories as $employmentHistory)
                      <tr>
                        <td>{{ $employmentHistory->company_name }}</td>
                        <td style="text-align: center;">
                          <div style="display: flex; justify-content: space-between;">
                            <span>{{ $employmentHistory->year_from }}</span>
                            <span>-</span>
                            <span>{{ $employmentHistory->year_to }}</span>
                          </div>
                        </td>
                        <td class="text-bold-500">{{ $employmentHistory->position }}</td>
                        <td class="text-bold-500">Rp. {{ number_format($employmentHistory->salary, 0, ',', '.') }}</td>
                        <td class="text-bold-500">{{ $employmentHistory->reason }}</td>
                      </tr>
                    @empty
                      <tr>
                        <td class="text-center" colspan="5">No data available in table</td>
                      </tr>
                    @endforelse

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Bahasa Asing -->
      <div class="col-12 col-lg-10">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <h3>Bahasa Asing</h3>
              <!-- Table with outer spacing -->
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Bahasa</th>
                      <th>Lisan</th>
                      <th>Menulis</th>
                      <th>Membaca</th>
                      <th>Mendengar</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($candidate->languageProficiencies as $languageProficiency)
                      <tr>
                        <td>{{ $languageProficiency->language }}</td>
                        <td>{{ $languageProficiency->speaking }}</td>
                        <td>{{ $languageProficiency->writing }}</td>
                        <td>{{ $languageProficiency->reading }}</td>
                        <td>{{ $languageProficiency->listening }}</td>
                      </tr>
                    @empty
                      <tr>
                        <td class="text-center" colspan="5">No data available in table</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Dokumen-dokumen-->
      {{-- <div class="col-12 col-lg-10">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <h3>Dokumen-dokumen</h3>
              <!-- Table with outer spacing -->
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Jenis File</th>
                      <th>Nama File</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($candidate->candidateDocuments as $candidateDocument)
                      <tr>
                        <td>{{ $candidateDocument->type_document }}</td>
                        <td>{{ pathinfo($candidateDocument->file, PATHINFO_FILENAME) }}</td>
                        <td>
                          <a href="{{ Storage::url($candidateDocument->file) }}" class="btn btn-primary"
                            target="_blank">
                            Lihat
                          </a>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td class="text-center" colspan="3">No data available in table</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div> --}}

    </div>
  </section>

@endsection
