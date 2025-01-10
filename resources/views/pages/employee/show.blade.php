@extends('layouts.auth')
@section('title', 'Employee')
@section('content')

  <link rel="stylesheet" href="{{ asset('dist/assets/extensions/toastify-js/src/toastify.css') }}">
  <script src="{{ asset('dist/assets/extensions/toastify-js/src/toastify.js') }}"></script>

  <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />

  {{-- @if (session()->has('success'))
    <script>
      Toastify({
        text: "{{ session('success') }}", // Display success message from session
        duration: 4000, // Duration of the toast
        close: true, // Option to close the toast manually
        gravity: "top", // Toast appears at the top
        position: "right", // Align toast to the right
        backgroundColor: "#28a745", // Success color
      }).showToast();
    </script>
  @endif --}}

  <x-validation-errors />

  <nav class="navbar navbar-light">
    <div class="container d-block">
      <a href="{{ route('employee.index') }}"><i class="bi bi-chevron-left"></i></a>
      <a class="btn btn-primary ms-4" href="{{ route('employee.index') }}">
        Back
      </a>
    </div>
  </nav>

  {{-- @if ($errors->any())
    <!-- Toast with Placements -->
    <script>
      @foreach ($errors->all() as $error)
        Toastify({
          text: "{{ $error }}", // Display each error message
          duration: 4000, // Duration of the toast
          close: true, // Option to close the toast manually
          gravity: "top", // Toast appears at the top
          position: "right", // Align toast to the right
          backgroundColor: "#dc3545", // Error color (Bootstrap danger)
        }).showToast();
      @endforeach
    </script>
  @endif --}}



  <section class="section">
    <div class="row mx-3">
      <div class="col-2">
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
          <a class="btn btn-primary mt-1 show active" id="v-pills-informasi-dasar-tab" data-bs-toggle="pill"
            href="#v-pills-informasi-dasar" role="tab" aria-controls="v-pills-informasi-dasar"
            aria-selected="true">Informasi Dasar</a>
          @if ($employee->position_id)
            <a class="btn btn-primary mt-1" id="v-pills-data-keluarga-tab" data-bs-toggle="pill"
              href="#v-pills-data-keluarga" role="tab" aria-controls="v-pills-data-keluarga"
              aria-selected="false">Data Keluarga</a>
            <a class="btn btn-primary mt-1" id="v-pills-riwayat-pekerjaan-tab" data-bs-toggle="pill"
              href="#v-pills-riwayat-pekerjaan" role="tab" aria-controls="v-pills-riwayat-pekerjaan"
              aria-selected="false">Riwayat Pekerjaan</a>
            <a class="btn btn-primary mt-1" id="v-pills-riwayat-pendidikan-tab" data-bs-toggle="pill"
              href="#v-pills-riwayat-pendidikan" role="tab" aria-controls="v-pills-riwayat-pendidikan"
              aria-selected="false">Riwayat Pendidikan</a>
            <a class="btn btn-primary mt-1" id="v-pills-kemampuan-bahasa-tab" data-bs-toggle="pill"
              href="#v-pills-kemampuan-bahasa" role="tab" aria-controls="v-pills-kemampuan-bahasa"
              aria-selected="false">Kemampuan Bahasa</a>
            <a class="btn btn-primary mt-1" id="v-pills-seminar-tab" data-bs-toggle="pill" href="#v-pills-seminar"
              role="tab" aria-controls="v-pills-seminar" aria-selected="false">Seminar/Pelatihan</a>
            <a class="btn btn-primary mt-1" id="v-pills-keterampilan-tab" data-bs-toggle="pill"
              href="#v-pills-keterampilan" role="tab" aria-controls="v-pills-keterampilan"
              aria-selected="false">Sertifikasi</a>
            <a class="btn btn-primary mt-1" id="v-pills-sosial-media-tab" data-bs-toggle="pill"
              href="#v-pills-sosial-media" role="tab" aria-controls="v-pills-sosial-media"
              aria-selected="false">Sosial Media</a>
            <a class="btn btn-primary mt-1" id="v-pills-contract-tab" data-bs-toggle="pill" href="#v-pills-contract"
              role="tab" aria-controls="v-pills-contract" aria-selected="false">Kontrak</a>
            {{-- <a class="btn btn-primary mt-1" id="v-pills-allowances-tab" data-bs-toggle="pill" href="#v-pills-allowances"
              role="tab" aria-controls="v-pills-allowances" aria-selected="false">Tunjangan</a>
            <a class="btn btn-primary mt-1" id="v-pills-attendances-tab" data-bs-toggle="pill" href="#v-pills-attendances"
              role="tab" aria-controls="v-pills-attendances" aria-selected="false">Absensi</a> --}}
            <a class="btn btn-primary mt-1" id="v-pills-kpi-tab" data-bs-toggle="pill" href="#v-pills-kpi" role="tab"
              aria-controls="v-pills-kpi" aria-selected="false">Penilaian Kerja</a>
            {{-- <a class="btn btn-primary mt-1" id="v-pills-dinas-tab" data-bs-toggle="pill" href="#v-pills-dinas"
              role="tab" aria-controls="v-pills-dinas" aria-selected="false">Dinas/Tugas</a> --}}
            <a class="btn btn-primary mt-1" id="v-pills-award-tab" data-bs-toggle="pill" href="#v-pills-award"
              role="tab" aria-controls="v-pills-award" aria-selected="false">Penghargaan</a>
            <a class="btn btn-primary mt-1" id="v-pills-career-tab" data-bs-toggle="pill" href="#v-pills-career"
              role="tab" aria-controls="v-pills-career" aria-selected="false">Karir</a>
            <a class="btn btn-primary mt-1" id="v-pills-kontak-darurat-tab" data-bs-toggle="pill"
              href="#v-pills-kontak-darurat" role="tab" aria-controls="v-pills-kontak-darurat"
              aria-selected="false">Kontak Darurat</a>
            <a class="btn btn-primary mt-1" id="v-pills-photo-tab" data-bs-toggle="pill" href="#v-pills-photo"
              role="tab" aria-controls="v-pills-photo" aria-selected="false">Photo</a>
            <a class="btn btn-primary mt-1" id="v-pills-sanction-tab" data-bs-toggle="pill" href="#v-pills-sanction"
              role="tab" aria-controls="v-pills-sanction" aria-selected="false">Sanksi</a>
          @endif
        </div>
      </div>

      <div class="col-10">

        <div class="row">
          <div class="col-12 col-lg-4">
            <div class="card-body mb-2">
              <div class="d-flex justify-content-center align-items-center flex-column">

                <!-- Image Preview -->
                @php
                  $mainPhoto = $employee->employeePhotos->where('main_photo', true)->first();
                @endphp
                <img src="{{ asset($mainPhoto ? 'storage/' . $mainPhoto->file_path : 'storage/img/2.jpg') }}"
                  alt="user-avatar" class="d-block rounded" width="230px" data-fancybox id="uploadedAvatar"
                  style="cursor: pointer" />

                <!-- Upload Icon and Input -->
                <label for="photo" class="mt-2"
                  style="text-align: center; display: block; width: 100%; font-weight: bold; font-size: 120%;">
                  <span>{{ $employee->name }}</span><br>
                  <span>{{ $employee->nik }}</span>
                </label>

                <!-- Upload Icon and Input -->
                {{-- <label for="uploadImage" class="mt-2 btn btn-sm btn-primary" style="cursor: pointer;">
                  <span> Upload</span>
                  <input type="file" id="uploadImage" value="{{ old('photo', $employee->photo) }}" name="photo"
                    accept=".jpg, .jpeg, .png" style="display: none;" onchange="previewImage(event)" />
                </label> --}}

                <!-- Display validation error message -->
                @if ($errors->has('photo'))
                  <div class="alert alert-danger mt-2" style="font-size: 70%">
                    {{ $errors->first('photo') }}
                  </div>
                @endif

                <!-- Additional Information -->
                {{-- <p class="mb-0 mt-3" style="font-size: 70%"> * Latar Belakang Foto Warna Merah</p>
                <p class="mb-0" style="font-size: 70%"> * Ekstensi File : jpg, jpeg, png</p>
                <p class="mb-0" style="font-size: 70%"> * Ukuran File Maks. 50MB</p>
                <p class="mb-0" style="font-size: 70%"> * Dimensi Foto 4x6</p>
                <p class="mb-0" style="font-size: 70%"> * Pastikan Foto Wajah Terlihat Jelas</p> --}}
              </div>

              <div class="d-flex justify-content-center align-items-center flex-column mt-3">
                <div class="btn-group mb-1">
                  <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle me-1" type="button" id="dropdownMenuButton"
                      data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Cetak
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="#" id="printBiodata">Biodata</a>
                      <a class="dropdown-item" href="#" id="printFormulir">Formulir Pemutakhiran</a>
                    </div>
                  </div>
                </div>
              </div>

              <div id="biodataContent" style="display: none;">
                @include('pages.employee.print.biodata')
              </div>
              <div id="formulirContent" style="display: none;">
                @include('pages.employee.print.formulir')
              </div>

            </div>
          </div>

          <div class="col-12 col-lg-8">
            <div class="card">
              <div class="card-body">
                <div class="row">

                  <div class="form-group col-md-6">
                    <label for="name">Nama Karyawan</label>
                    <input type="text" id="name" value="{{ old('name', $employee->name) }}"
                      class="form-control @error('name') is-invalid @enderror" name="name" readonly>
                    @error('name')
                      <a style="color: red">
                        <small>
                          {{ $message }}
                        </small>
                      </a>
                    @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label for="nik">NIK</label>
                    <input type="text" id="nik" value="{{ old('nik', $employee->nik) }}"
                      class="form-control @error('nik') is-invalid @enderror" name="nik" readonly>
                    @error('nik')
                      <a style="color: red">
                        <small>
                          {{ $message }}
                        </small>
                      </a>
                    @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label for="position_id">Jabatan</label>
                    <input type="text" class="form-control" value="{{ $employee->position->name ?? '-' }}"
                      readonly>
                    @error('position_id')
                      <a style="color: red">
                        <small>
                          {{ $message }}
                        </small>
                      </a>
                    @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label for="employee_category_id">Kategori Karyawan</label>
                    <input name="employee_category_id" id="employee_category_id"
                      value="{{ $employee->employeeCategory->name }}"
                      class="form-control choices  @error('employee_category_id') is-invalid @enderror" readonly>
                    @error('employee_category_id')
                      <a style="color: red">
                        <small>
                          {{ $message }}
                        </small>
                      </a>
                    @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label for="employee_status">Status Karyawan</label>
                    <input type="text" id="employee_status" name="employee_status"
                      value="{{ $employee->employee_status }}"
                      class="form-control choices @error('employee_status') is-invalid @enderror" readonly>
                    @error('employee_status')
                      <a style="color: red">
                        <small>
                          {{ $message }}
                        </small>
                      </a>
                    @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label for="work_relationship">Hubungan Kerja</label>
                    <input type="text" id="work_relationship" value="{{ $employee->work_relationship }}"
                      class="form-control choices @error('work_relationship') is-invalid @enderror"
                      name="work_relationship" readonly>
                    @error('work_relationship')
                      <a style="color: red">
                        <small>
                          {{ $message }}
                        </small>
                      </a>
                    @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label for="work_status">Tipe Waktu Pekerjaan</label>
                    <input type="text" id="work_status" value="{{ $employee->work_status }}"
                      class="form-control choices @error('work_status') is-invalid @enderror" name="work_status"
                      readonly>
                    @error('work_status')
                      <a style="color: red">
                        <small>
                          {{ $message }}
                        </small>
                      </a>
                    @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label for="date_joining">Date Of Joining</label>
                    <input type="text" id="date_joining"
                      value="{{ Carbon\Carbon::parse($employee->date_joining)->translatedFormat('l, d F Y') }}"
                      class="form-control @error('date_joining') is-invalid @enderror" name="date_joining" readonly>
                    @error('date_joining')
                      <a style="color: red">
                        <small>
                          {{ $message }}
                        </small>
                      </a>
                    @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <!-- Display Masa Pensiun (Retirement Date) -->
                    <label for="date_joining">Masa Pensiun</label>
                    <input type="text" value="{{ $retirementDate->translatedFormat('l, d F Y') }}"
                      class="form-control @error('date_joining') is-invalid @enderror" readonly>
                  </div>
                  <div class="form-group col-md-6">
                    <!-- Display Sisa Tahun Menuju Pensiun (Remaining Time Until Retirement) -->
                    <label for="remaining_time">Sisa Tahun Menuju Pensiun</label>
                    <input type="text" value="{{ $remainingYears }} tahun {{ $remainingMonths }} bulan"
                      class="form-control" readonly>
                  </div>
                  @if ($employee->date_leaving)
                    <div class="form-group col-md-6">
                      <label for="date_leaving">Date Of Leaving</label>
                      <input type="text" id="date_leaving"
                        value="{{ Carbon\Carbon::parse($employee->date_leaving)->translatedFormat('l, d F Y') }}"
                        class="form-control @error('date_leaving') is-invalid @enderror" name="date_leaving" readonly>
                      @error('date_joining')
                        <a style="color: red">
                          <small>
                            {{ $message }}
                          </small>
                        </a>
                      @enderror
                    </div>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- <div class="row">
          <div class="col-12 col-lg-4">
            <div class="card-body mb-2">
              <div class="d-flex justify-content-center align-items-center flex-column">

                <!-- Image Preview -->
                <img src="{{ asset($employee->photo ? 'storage/' . $employee->photo : 'storage/img/2.jpg') }}"
                  alt="user-avatar" class="d-block rounded" width="150px" data-fancybox id="uploadedAvatar"
                  style="cursor: pointer" />

                <!-- Upload Icon and Input -->
                <label for="photo" class="mt-2" style="text-align: center; display: block; width: 100%;">
                  <span>{{ $employee->name }}</span>
                </label>

                <!-- Upload Icon and Input -->
                <label for="uploadImage" class="mt-2 btn btn-sm btn-primary" style="cursor: pointer;">
                  <span> Upload</span>
                  <input type="file" id="uploadImage" value="{{ old('photo', $employee->photo) }}" name="photo"
                    accept=".jpg, .jpeg, .png" style="display: none;" onchange="previewImage(event)" />
                </label>

                <!-- Display validation error message -->
                @if ($errors->has('photo'))
                  <div class="alert alert-danger mt-2" style="font-size: 70%">
                    {{ $errors->first('photo') }}
                  </div>
                @endif

                <!-- Additional Information -->
                <p class="mb-0 mt-3" style="font-size: 70%"> * Latar Belakang Foto Warna Merah</p>
                <p class="mb-0" style="font-size: 70%"> * Ekstensi File : jpg, jpeg, png</p>
                <p class="mb-0" style="font-size: 70%"> * Ukuran File Maks. 50MB</p>
                <p class="mb-0" style="font-size: 70%"> * Dimensi Foto 4x6</p>
                <p class="mb-0" style="font-size: 70%"> * Pastikan Foto Wajah Terlihat Jelas</p>
              </div>
            </div>
          </div>

          <div class="col-12 col-lg-8">
            <div class="card">
              <div class="card-body">
                <div class="row">

                  <div class="form-group col-md-6">
                    <label for="nik">NIK <code>*</code></label>
                    <input type="text" id="nik" value="{{ old('nik', $employee->nik) }}"
                      class="form-control @error('nik') is-invalid @enderror" name="nik">
                    @error('nik')
                      <a style="color: red">
                        <small>
                          {{ $message }}
                        </small>
                      </a>
                    @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label for="position_id">Jabatan</label>
                    <input type="text" class="form-control" value="{{ $employee->position->name }}" readonly>
                  <select name="position_id" id="position_id"
                  class="form-control choices  @error('position_id') is-invalid @enderror">
                  <option value="" disabled selected>Choose</option>
                  @foreach ($positions as $position)
                    <option value="{{ $position->id }}"
                      {{ old('position_id', $employee->position_id) == $position->id ? 'selected' : '' }}>
                      {{ $position->name }}</option>
                  @endforeach
                </select>
                    @error('position_id')
                      <a style="color: red">
                        <small>
                          {{ $message }}
                        </small>
                      </a>
                    @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label for="employee_category_id">Kategori Karyawan <code>*</code></label>
                    <select name="employee_category_id" id="employee_category_id"
                      class="form-control choices  @error('employee_category_id') is-invalid @enderror">
                      <option value="" disabled selected>Choose</option>
                      @foreach ($employeeCategories as $employeeCategory)
                        <option value="{{ $employeeCategory->id }}"
                          {{ old('employee_category_id', $employee->employee_category_id) == $employeeCategory->id ? 'selected' : '' }}>
                          {{ $employeeCategory->name }}</option>
                      @endforeach
                    </select>
                    @error('employee_category_id')
                      <a style="color: red">
                        <small>
                          {{ $message }}
                        </small>
                      </a>
                    @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label for="employee_status">Status Karyawan <code>*</code></label>
                    <select type="text" id="employee_status" name="employee_status"
                      class="form-control choices @error('employee_status') is-invalid @enderror">
                      <option value="" disabled>Choose</option>
                      <option value="AKTIF"
                        {{ old('employee_status', $employee->employee_status) == 'AKTIF' ? 'selected' : '' }}>AKTIF
                      </option>
                      <option value="PENSIUN"
                        {{ old('employee_status', $employee->employee_status) == 'PENSIUN' ? 'selected' : '' }}>PENSIUN
                      </option>
                      <option value="RESIGN"
                        {{ old('employee_status', $employee->employee_status) == 'RESIGN' ? 'selected' : '' }}>RESIGN
                      </option>
                      <option value="NON AKTIF"
                        {{ old('employee_status', $employee->employee_status) == 'NON AKTIF' ? 'selected' : '' }}>
                        NON AKTIF</option>
                    </select>
                    @error('employee_status')
                      <a style="color: red">
                        <small>
                          {{ $message }}
                        </small>
                      </a>
                    @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label for="work_relationship">Hubungan Kerja <code>*</code></label>
                    <select type="text" id="work_relationship"
                      class="form-control choices @error('work_relationship') is-invalid @enderror"
                      name="work_relationship">
                      <option value="" disabled selected>Choose</option>
                      <option value="KONTRAK"
                        {{ old('work_relationship', $employee->work_relationship) == 'KONTRAK' ? 'selected' : '' }}>
                        KONTRAK
                      </option>
                      <option value="TETAP"
                        {{ old('work_relationship', $employee->work_relationship) == 'TETAP' ? 'selected' : '' }}>TETAP
                      </option>
                      <option value="INTERNSHIP"
                        {{ old('work_relationship', $employee->work_relationship) == 'INTERNSHIP' ? 'selected' : '' }}>
                        INTERNSHIP
                      </option>
                    </select>
                    @error('work_relationship')
                      <a style="color: red">
                        <small>
                          {{ $message }}
                        </small>
                      </a>
                    @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label for="work_status">Tipe Waktu Pekerjaan <code>*</code></label>
                    <select type="text" id="work_status"
                      class="form-control choices @error('work_status') is-invalid @enderror" name="work_status">
                      <option value="" disabled selected>Choose</option>
                      <option value="FULL-TIME"
                        {{ old('work_status', $employee->work_status) == 'FULL-TIME' ? 'selected' : '' }}>FULL-TIME
                      </option>
                      <option value="PART-TIME"
                        {{ old('work_status', $employee->work_status) == 'PART-TIME' ? 'selected' : '' }}>PART-TIME
                      </option>
                      <option value="INTERNSHIP"
                        {{ old('work_status', $employee->work_status) == 'INTERNSHIP' ? 'selected' : '' }}>INTERNSHIP
                      </option>
                    </select>
                    @error('work_status')
                      <a style="color: red">
                        <small>
                          {{ $message }}
                        </small>
                      </a>
                    @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label for="date_joining">Date Of Joining <code>*</code></label>
                    <input type="date" id="date_joining" value="{{ $employee->date_joining }}"
                      class="form-control @error('date_joining') is-invalid @enderror" name="date_joining" required>
                    @error('date_joining')
                      <a style="color: red">
                        <small>
                          {{ $message }}
                        </small>
                      </a>
                    @enderror
                  </div>
                  <div class="form-group col-md-6">
                <label for="date_leaving">Date Of Leaving </label>
                <input type="date" id="date_leaving" value="{{ $employee->date_leaving }}"
                  class="form-control @error('date_leaving') is-invalid @enderror" name="date_leaving" required>
                @error('date_leaving')
                  <a style="color: red">
                    <small>
                      {{ $message }}
                    </small>
                  </a>
                @enderror
              </div>

                </div>
              </div>
            </div>
          </div>
        </div> --}}

        <div class="tab-content" id="v-pills-tabContent">
          @if ($employee->position_id)
            <div class="tab-pane fade" id="v-pills-data-keluarga" role="tabpanel"
              aria-labelledby="v-pills-data-keluarga-tab">
              @include('pages.employee.personal-data.family-detail')
            </div>
            <div class="tab-pane fade" id="v-pills-riwayat-pekerjaan" role="tabpanel"
              aria-labelledby="v-pills-riwayat-pekerjaan-tab">
              @include('pages.employee.personal-data.job-history-detail')
            </div>
            <div class="tab-pane fade" id="v-pills-riwayat-pendidikan" role="tabpanel"
              aria-labelledby="v-pills-riwayat-pendidikan-tab">
              @include('pages.employee.personal-data.educational-history-detail')
            </div>
            <div class="tab-pane fade" id="v-pills-kemampuan-bahasa" role="tabpanel"
              aria-labelledby="v-pills-kemampuan-bahasa-tab">
              @include('pages.employee.personal-data.language-proficiency-detail')
            </div>
            <div class="tab-pane fade" id="v-pills-seminar" role="tabpanel" aria-labelledby="v-pills-seminar-tab">
              @include('pages.employee.personal-data.training-attended-detail')
            </div>
            <div class="tab-pane fade" id="v-pills-keterampilan" role="tabpanel"
              aria-labelledby="v-pills-keterampilan-tab">
              @include('pages.employee.personal-data.training-certificate')
            </div>
            <div class="tab-pane fade" id="v-pills-sosial-media" role="tabpanel"
              aria-labelledby="v-pills-sosial-media-tab">
              @include('pages.employee.personal-data.social-platform-detail')
            </div>
            <div class="tab-pane fade" id="v-pills-contract" role="tabpanel" aria-labelledby="v-pills-contract-tab">
              @include('pages.employee.personal-data.employee-contract')
            </div>
            <div class="tab-pane fade" id="v-pills-allowances" role="tabpanel"
              aria-labelledby="v-pills-allowances-tab">
              @include('pages.employee.personal-data.allowances')
            </div>
            <div class="tab-pane fade" id="v-pills-kpi" role="tabpanel" aria-labelledby="v-pills-kpi-tab">
              @include('pages.employee.personal-data.employee-kpi')
            </div>
            <div class="tab-pane fade" id="v-pills-dinas" role="tabpanel" aria-labelledby="v-pills-dinas-tab">
              @include('pages.employee.personal-data.employee-duty')
            </div>
            <div class="tab-pane fade" id="v-pills-career" role="tabpanel" aria-labelledby="v-pills-career-tab">
              @include('pages.employee.personal-data.employee-career')
            </div>
            <div class="tab-pane fade" id="v-pills-award" role="tabpanel" aria-labelledby="v-pills-award-tab">
              @include('pages.employee.personal-data.employee-award')
            </div>
            <div class="tab-pane fade" id="v-pills-attendances" role="tabpanel"
              aria-labelledby="v-pills-attendances-tab">
              @include('pages.employee.personal-data.employee-attendance')
            </div>
            <div class="tab-pane fade" id="v-pills-kontak-darurat" role="tabpanel"
              aria-labelledby="v-pills-kontak-darurat-tab">
              @include('pages.employee.personal-data.emergency-contact')
            </div>
            <div class="tab-pane fade" id="v-pills-photo" role="tabpanel" aria-labelledby="v-pills-photo-tab">
              @include('pages.employee.personal-data.photo-employee')
            </div>
            <div class="tab-pane fade" id="v-pills-sanction" role="tabpanel" aria-labelledby="v-pills-sanction-tab">
              @include('pages.employee.personal-data.sanction')
            </div>
          @endif
          <div class="tab-pane fade show active" id="v-pills-informasi-dasar" role="tabpanel"
            aria-labelledby="v-pills-informasi-dasar-tab">
            @include('pages.employee.personal-data.employee-data')
          </div>
        </div>
      </div>
    </div>

    </div>


  </section>

  <!--preview img-->
  <script>
    function previewImage(event) {
      var reader = new FileReader();
      reader.onload = function() {
        var output = document.getElementById('uploadedAvatar');
        output.src = reader.result;
      }
      reader.readAsDataURL(event.target.files[0]);
    }
  </script>

  <!-- sweetalsert-->
  <script>
    document.getElementById('submitBtn').addEventListener('click', function(e) {
      Swal.fire({
        title: 'Are you sure to update it?',
        // text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, submit it!'
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById('updateForm').submit();
        }
      });
    });
  </script>

  <!-- /sweetalsert-->

  <!--leaflet-->
  <!-- Include Leaflet.js CSS and JS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var mapKTP, mapDomisili;
      var markerKTP, markerDomisili;

      // Initialize KTP Map when modal is shown
      $('#mapModalKTP').on('shown.bs.modal', function() {
        if (!mapKTP) {
          mapKTP = L.map('mapKTP').setView([{{ $candidate->latitude_ktp ?? -6.1580339989448305 }},
              {{ $candidate->longitude_ktp ?? 106.88319683074951 }}
            ],
            13); // Default location: Jakarta
          L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
          }).addTo(mapKTP);

          // Add a marker at the candidate's KTP location
          var markerKTP = L.marker([{{ $candidate->latitude_ktp ?? -6.1580339989448305 }},
            {{ $candidate->longitude_ktp ?? 106.88319683074951 }}
          ]).addTo(
            mapKTP);

          // Optional: Bind a popup to the marker with some information
          markerKTP.bindPopup("<b>Lokasi Alamat KTP</b>").openPopup();

          // Add marker when map is clicked
          mapKTP.on('click', function(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;

            // Update input fields for KTP
            document.getElementById('latitude_ktp').value = lat;
            document.getElementById('longitude_ktp').value = lng;

            // Place marker
            if (markerKTP) {
              mapKTP.removeLayer(markerKTP);
            }
            markerKTP = L.marker([lat, lng]).addTo(mapKTP);
          });
        }
        setTimeout(function() {
          mapKTP.invalidateSize();
        }, 100);
      });

      // Initialize Domisili Map when modal is shown
      $('#mapModalDomisili').on('shown.bs.modal', function() {
        if (!mapDomisili) {
          mapDomisili = L.map('mapDomisili').setView([{{ $candidate->latitude_domisili ?? -6.1580339989448305 }},
              {{ $candidate->longitude_domisili ?? 106.88319683074951 }}
            ],
            13); // Default location: Jakarta
          L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
          }).addTo(mapDomisili);

          // Add a marker at the candidate's domisili location
          var markerDomisili = L.marker([{{ $candidate->latitude_domisili ?? -6.1580339989448305 }},
            {{ $candidate->longitude_domisili ?? 106.88319683074951 }}
          ]).addTo(
            mapDomisili);

          // Optional: Bind a popup to the marker with some information
          markerDomisili.bindPopup("<b>Lokasi Alamat Domisili</b>").openPopup();

          // Add marker when map is clicked
          mapDomisili.on('click', function(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;

            // Update input fields for Domisili
            document.getElementById('latitude_domisili').value = lat;
            document.getElementById('longitude_domisili').value = lng;

            // Place marker
            if (markerDomisili) {
              mapDomisili.removeLayer(markerDomisili);
            }
            markerDomisili = L.marker([lat, lng]).addTo(mapDomisili);
          });
        }
        setTimeout(function() {
          mapDomisili.invalidateSize();
        }, 100);
      });

      // Optionally add logic to reset markers or clear fields if needed.
    });
  </script>
  <!--/leaflet-->
  <script>
    Fancybox.bind("[data-fancybox]", {
      // Your custom options
    });
  </script>

  <script>
    // Print Biodata
    document.getElementById('printBiodata').addEventListener('click', function(e) {
      e.preventDefault();
      printContent('biodataContent');
    });

    // Print Formulir Pemutakhiran
    document.getElementById('printFormulir').addEventListener('click', function(e) {
      e.preventDefault();
      printContent('formulirContent');
    });

    // Function to Print Content
    function printContent(contentId) {
      const content = document.getElementById(contentId).innerHTML;

      // Open a new window for the print preview
      const printWindow = window.open('', '_blank');
      printWindow.document.open();
      printWindow.document.write(`
        <html>
            <head>
                <title>Print</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                    }
                </style>
            </head>
            <body>
                ${content}
            </body>
        </html>
    `);
      printWindow.document.close();
      printWindow.print();
    }
  </script>
@endsection
