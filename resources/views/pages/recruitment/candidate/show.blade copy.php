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
                    <a href="{{ Storage::url($candidate->file_cv) }}" target="_blank"
                      class="text-sm btn btn-sm btn-primary">
                      {{-- {{ pathinfo($candidate->file_cv, PATHINFO_FILENAME) }} --}}
                      Lihat
                    </a>
                  @else
                    <span>-</span>
                  @endif
                </div>
                <div class="mb-3">
                  <label for="file_ktp" class="form-label">KTP & NPWP</label><br>
                  @if ($candidate->file_ktp)
                    <a href="{{ Storage::url($candidate->file_ktp) }}" target="_blank"
                      class="text-sm btn btn-sm btn-primary">
                      {{-- {{ pathinfo($candidate->file_ktp, PATHINFO_FILENAME) }} --}}
                      Lihat
                    </a>
                  @else
                    <span>-</span>
                  @endif
                </div>
                <div class="mb-3">
                  <label for="file_skck" class="form-label">SKCK AKTIF</label><br>
                  @if ($candidate->file_skck)
                    <a href="{{ Storage::url($candidate->file_skck) }}" target="_blank"
                      class="text-sm btn btn-sm btn-primary">
                      {{-- {{ pathinfo($candidate->file_skck, PATHINFO_FILENAME) }} --}}
                      Lihat
                    </a>
                  @else
                    <span>-</span>
                  @endif
                </div>
                <div class="mb-3">
                  <label for="file_kk" class="form-label">KARTU KELUARGA</label><br>
                  @if ($candidate->file_kk)
                    <a href="{{ Storage::url($candidate->file_kk) }}" target="_blank"
                      class="text-sm btn btn-sm btn-primary">
                      {{-- {{ pathinfo($candidate->file_kk, PATHINFO_FILENAME) }} --}}
                      Lihat
                    </a>
                  @else
                    <span>-</span>
                  @endif
                </div>
                <div class="mb-3">
                  <label for="file_surat_sehat" class="form-label">SURAT KETERANGAN SEHAT</label><br>
                  @if ($candidate->file_surat_sehat)
                    <a href="{{ Storage::url($candidate->file_surat_sehat) }}" target="_blank"
                      class="text-sm btn btn-sm btn-primary">
                      {{-- {{ pathinfo($candidate->file_surat_sehat, PATHINFO_FILENAME) }} --}}
                      Lihat
                    </a>
                  @else
                    <span>-</span>
                  @endif
                </div>
                <div class="mb-3">
                  <label for="file_vaksin" class="form-label">SERTIFIKAT VAKSIN</label><br>
                  @if ($candidate->file_vaksin)
                    <a href="{{ Storage::url($candidate->file_vaksin) }}" target="_blank"
                      class="text-sm btn btn-sm btn-primary">
                      {{-- {{ pathinfo($candidate->file_vaksin, PATHINFO_FILENAME) }} --}}
                      Lihat
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
                    maxlength="13" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number"
                    readonly>
                </div>
                <div class="form-group">
                  <label for="paspor_number">No. Paspor</label>
                  <input type="text" id="paspor_number" value="{{ old('paspor_number', $candidate->paspor_number) }}"
                    maxlength="16" class="form-control @error('paspor_number') is-invalid @enderror" name="paspor_number"
                    readonly>
                </div>
                <div class="form-group">
                  <label for="ktp_number">No. KTP</label>
                  <input type="text" id="ktp_number" value="{{ old('ktp_number', $candidate->ktp_number) }}"
                    maxlength="16" class="form-control @error('ktp_number') is-invalid @enderror" name="ktp_number"
                    readonly>
                </div>
                <div class="form-group">
                  <label for="kk_number">No. Kartu Keluarga</label>
                  <input type="text" id="kk_number" value="{{ old('kk_number', $candidate->kk_number) }}"
                    maxlength="16" class="form-control @error('kk_number') is-invalid @enderror" name="kk_number"
                    readonly>
                </div>
                <div class="form-group">
                  <label for="npwp_number">Jabatan Yang Dilamar</label>
                  <input type="text" inputmode="numeric"
                    value="{{ old('npwp_number', $candidate->applied_position) }}" id="npwp_number"
                    class="form-control @error('npwp_number') is-invalid @enderror" name="npwp_number" readonly>
                </div>
                <div class="form-group">
                  <label for="npwp_number">Rekomendasi Penempatan</label>
                  <input type="text" inputmode="numeric"
                    value="{{ old('npwp_number', $candidate->recommended_position) }}" maxlength="16" id="npwp_number"
                    class="form-control @error('npwp_number') is-invalid @enderror" name="npwp_number" readonly>
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
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="gender">Jenis Kelamin</label>
                    <select name="gender" id="gender" class="form-control  @error('gender') is-invalid @enderror"
                      disabled>
                      <option value="" disabled selected>Choose</option>
                      <option value="LAKI-LAKI"
                        {{ old('gender', $candidate->gender) == 'LAKI-LAKI' ? 'selected' : '' }}>
                        Laki-laki
                      </option>
                      <option value="PEREMPUAN"
                        {{ old('gender', $candidate->gender) == 'PEREMPUAN' ? 'selected' : '' }}>
                        Perempuan
                      </option>
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="blood_type">Gol. Darah</label>
                    <input type="text" value="{{ old('blood_type', $candidate->blood_type) }}" id="blood_type"
                      class="form-control  @error('blood_type') is-invalid @enderror" maxlength="3" name="blood_type"
                      readonly>
                  </div>
                </div>
                <div class="form-group">
                  <label for="npwp_number">Status Perkawinan </label>
                  <input type="text" value="{{ old('npwp_number', $candidate->marital_status) }}" maxlength="16"
                    id="npwp_number" class="form-control @error('npwp_number') is-invalid @enderror"
                    name="npwp_number" readonly>
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
                <div class="form-group">
                  <label for="ethnic">Suku Bangsa</label>
                  <input type="text" value="{{ old('ethnic', $candidate->ethnic) }}" id="ethnic"
                    class="form-control @error('ethnic') is-invalid @enderror" name="ethnic" readonly>
                </div>
                <div class="form-group">
                  <label for="candidate_from">Pelamar Dari</label>
                  <input type="text" value="{{ old('candidate_from', $candidate->candidate_from) }}"
                    id="candidate_from" class="form-control @error('candidate_from') is-invalid @enderror"
                    name="candidate_from" readonly>
                </div>
              </div>

              <div class="col-12">
                <div class="form-group">
                  <label for="ktp_address">Alamat Sesuai KTP</label>
                  <textarea type="text" id="ktp_address" class="form-control  @error('ktp_address') is-invalid @enderror"
                    name="ktp_address" rows="5" readonly> {{ old('ktp_address', $candidate->ktp_address) }}</textarea>
                </div>
                <div class="row">
                  <!-- Latitude and Longitude for Alamat KTP -->
                  <div class="form-group col-md-6">
                    <label for="latitude_ktp">Latitude Alamat KTP</label>
                    <input type="text" id="latitude_ktp" value="{{ $candidate->latitude_ktp }}"
                      class="form-control" readonly>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="longitude_ktp">Longitude Alamat KTP</label>
                    <input type="text" id="longitude_ktp" value="{{ $candidate->longitude_ktp }}"
                      class="form-control" readonly>
                  </div>
                </div>
                <div class="form-group">
                  <label for="current_address">Alamat Sekarang</label>
                  <textarea type="text" id="current_address" class="form-control @error('current_address') is-invalid @enderror"
                    name="current_address" rows="5" readonly> {{ old('current_address', $candidate->current_address) }}</textarea>
                </div>
                <div class="row">
                  <!-- Latitude and Longitude for Alamat domisili -->
                  <div class="form-group col-md-6">
                    <label for="latitude_domisili">Latitude Domisili</label>
                    <input type="text" id="latitude_domisili" value="{{ $candidate->latitude_domisili }}"
                      class="form-control" readonly>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="longitude_domisili">Longitude Domisili</label>
                    <input type="text" id="longitude_domisili" value="{{ $candidate->longitude_domisili }}"
                      class="form-control" readonly>
                  </div>
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
                      <th>Tgl Lahir</th>
                      <th>No. Telp</th>
                      <th>Pendidikan</th>
                      <th>Pekerjaan</th>
                      <th>Alamat</th>
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
                        <td class="text-bold-500">
                          {{ Carbon\Carbon::parse($familyDetail->dob)->translatedFormat('d F Y') }}
                        </td>
                        <td class="text-bold-500">{{ $familyDetail->phone_number }}</td>
                        <td class="text-bold-500">{{ $familyDetail->education }}</td>
                        <td class="text-bold-500">{{ $familyDetail->job }}</td>
                        <td class="text-bold-500">{{ $familyDetail->address }}</td>
                      </tr>
                    @empty
                      <tr>
                        <td class="text-center" colspan="8">No data available in table</td>
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
                      <th>Tgl Lahir</th>
                      <th>No. Telp</th>
                      <th>Pendidikan</th>
                      <th>Pekerjaan</th>
                      <th>Alamat</th>
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
                        <td class="text-bold-500">
                          {{ Carbon\Carbon::parse($familyDetail->dob)->translatedFormat('d F Y') }}
                        </td>
                        <td class="text-bold-500">{{ $familyDetail->phone_number }}</td>
                        <td class="text-bold-500">{{ $familyDetail->education }}</td>
                        <td class="text-bold-500">{{ $familyDetail->job }}</td>
                        <td class="text-bold-500">{{ $familyDetail->address }}</td>
                      </tr>
                    @empty
                      <tr>
                        <td class="text-center" colspan="8">No data available in table</td>
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
                      <th>Lulus/Tidak</th>
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
                        <td class="text-bold-500">{{ $educationalHistory->graduate }}</td>
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
                        <td class="text-center" colspan="8">No data available in table</td>
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
                      <th>Posisi </th>
                      <th>Atasan</th>
                      <th style="text-align: center;">
                        <div>Lama Bekerja</div>
                        <div style="display: flex; justify-content: space-between;">
                          <span>Masuk</span>
                          <span>-</span>
                          <span>Keluar</span>
                        </div>
                      </th>
                      <th>Gaji</th>
                      <th>Alasan Berhenti</th>
                      <th>File</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($candidate->employmentHistories as $employmentHistory)
                      <tr>
                        <td>{{ $employmentHistory->company_name }}</td>
                        <td class="text-bold-500">{{ $employmentHistory->position }}</td>
                        <td class="text-bold-500">{{ $employmentHistory->direct_supervisor }}</td>
                        <td style="text-align: center;">
                          <div style="display: flex; justify-content: space-between;">
                            <span>{{ $employmentHistory->year_from }}</span>
                            <span>-</span>
                            <span>{{ $employmentHistory->year_to }}</span>
                          </div>
                        </td>
                        <td class="text-bold-500">Rp. {{ number_format($employmentHistory->salary, 0, ',', '.') }}</td>
                        <td class="text-bold-500">{{ $employmentHistory->reason }}</td>
                        <td class="text-bold-500 text-center">
                          @if ($employmentHistory->file)
                            <a href="{{ Storage::url($employmentHistory->file) }}" target="_blank" class="text-sm">
                              Lihat
                            </a>
                          @else
                            <span>-</span>
                          @endif
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td class="text-center" colspan="7">No data available in table</td>
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

      <!-- Seminar/Pelatihan -->
      <div class="col-12 col-lg-10">
        <div class="card">
          <div class="card-body">

            <div class="row">
              <h3>Pelatihan/Seminar</h3>
              <!-- Table with outer spacing -->
              <div class="table-responsive">
                <table class="table table-sm" style="margin: 0;">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Pelatihan/Seminar</th>
                      <th>Penyelenggara</th>
                      <th>Tempat/Kota</th>
                      <th>Tahun</th>
                      <th>File</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($candidate->trainingAttendeds as $trainingAttended)
                      <tr>
                        <td class="text-bold-500">{{ $loop->iteration }}</td>
                        <td class="text-bold-500">{{ $trainingAttended->training_name }}</td>
                        <td class="text-bold-500">{{ $trainingAttended->organizer_name }}</td>
                        <td class="text-bold-500">{{ $trainingAttended->city }}</td>
                        <td class="text-bold-500">{{ $trainingAttended->year }}</td>
                        <td class="text-bold-500">
                          @if ($trainingAttended->file_sertifikat)
                            <a href="{{ Storage::url($trainingAttended->file_sertifikat) }}" target="_blank">
                              Lihat
                            </a>
                          @else
                            <span>-</span>
                          @endif
                        </td>
                      </tr>
                    @empty
                      <td class="text-bold-500 text-center" colspan="9">No data available in table</td>
                    @endforelse
                  </tbody>
                </table>

              </div>

            </div>
          </div>
        </div>
      </div>

      <!-- keterampilan -->
      <div class="col-12 col-lg-10">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <h3>Keterampilan/Kompeten</h3>
              <!-- Table with outer spacing -->
              <div class="table-responsive">
                <table class="table table-sm">
                  <thead>
                    <tr>
                      <th>Nama Keterampilan/Kompetensi</th>
                      <th>Kemahiran</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($candidate->skills as $skill)
                      <tr>
                        <td class="text-bold-500">{{ $skill->name }}</td>
                        <td class="text-bold-500">
                          {{ $skill->mastery }}
                        </td>
                      </tr>
                    @empty
                      <td class="text-bold-500 text-center" colspan="2">No data available in table</td>
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
