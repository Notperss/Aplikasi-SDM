@extends('layouts.app')
@section('title', 'Employee')
@section('content')

@section('breadcrumb')
  <x-breadcrumb title="Edit Data Diri Karyawan" page="Recruitment" active="Karyawan" route="{{ route('employee.index') }}" />
@endsection

<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />

<section class="section">
  <form action="{{ route('employee.update', $employee) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')
    <div class="row">


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
              {{-- <i class="bi bi-upload" style="font-size: 24px; color: rgba(0, 128, 255, 0.974);"></i> --}}
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

          {{-- <div class="card mt-3">
            <div class="card-content">
              <div class="card-body">

                <div class="mb-3">
                  <label for="file_cv" class="form-label">CV</label>
                  <input class="form-control" accept=".pdf" type="file" id="file_cv" name="file_cv">
                </div>
                <div class="mb-3">
                  <label for="file_ktp" class="form-label">KTP & NPWP</label>
                  <input class="form-control" accept=".pdf" type="file" id="file_ktp" name="file_ktp">
                </div>
                <div class="mb-3">
                  <label for="file_ijazah" class="form-label">IJAZAH & TRANSKRIP NILAI</label>
                  <input class="form-control" accept=".pdf" type="file" id="file_ijazah" name="file_ijazah">
                </div>
                <div class="mb-3">
                  <label for="file_skck" class="form-label">SKCK AKTIF</label>
                  <input class="form-control" accept=".pdf" type="file" id="file_skck" name="file_skck">
                </div>
                <div class="mb-3">
                  <label for="file_kk" class="form-label">KARTU KELUARGA</label>
                  <input class="form-control" accept=".pdf" type="file" id="file_kk" name="file_kk">
                </div>
                <div class="mb-3">
                  <label for="file_surat_sehat" class="form-label">SURAT KETERANGAN SEHAT</label>
                  <input class="form-control" accept=".pdf" type="file" id="file_surat_sehat"
                    name="file_surat_sehat">
                </div>
                <div class="mb-3">
                  <label for="file_vaksin" class="form-label">SERTIFIKAT VAKSIN</label>
                  <input class="form-control" accept=".pdf" type="file" id="file_vaksin" name="file_vaksin">
                </div>
                <div class="mb-3">
                  <label for="file_sertifikat" class="form-label">SERTIFIKAT PELATIHAN</label>
                  <input class="form-control" accept=".pdf" type="file" id="file_sertifikat"
                    name="file_sertifikat">
                </div>
                <p class="card-text text-sm">
                  * Ekstensi File : pdf <br>
                  * Ukuran File Maks. 50MB
                </p>
              </div>
            </div>
          </div> --}}

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
                    {{ old('work_relationship', $employee->work_relationship) == 'KONTRAK' ? 'selected' : '' }}>KONTRAK
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
                <label for="date_joining">TMT Masuk <code>*</code></label>
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
              {{-- <div class="form-group col-md-6">
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
              </div> --}}

            </div>
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-6 col-12">
                <div class="form-group">
                  <label for="name">Nama Lengkap <code>*</code></label>
                  <input type="text" id="name" value="{{ old('name', $employee->name) }}"
                    class="form-control @error('name') is-invalid @enderror" name="name">
                  @error('name')
                    <a style="color: red">
                      <small>
                        {{ $message }}
                      </small>
                    </a>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" id="email" value="{{ old('email', $employee->email) }}"
                    class="form-control @error('email') is-invalid @enderror" name="email">
                  @error('email')
                    <a style="color: red">
                      <small>
                        {{ $message }}
                      </small>
                    </a>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="phone_number1">No. Telpon <code>*</code></label>
                  <input type="text" id="phone_number1"
                    value="{{ old('phone_number1', $employee->phone_number1) }}" maxlength="14"
                    oninput="this.value = this.value.replace(/\D+/g, '')"
                    class="form-control @error('phone_number1') is-invalid @enderror" name="phone_number1">
                  @error('phone_number1')
                    <a style="color: red">
                      <small>
                        {{ $message }}
                      </small>
                    </a>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="phone_number2">No. Telpon 2</label>
                  <input type="text" id="phone_number2"
                    value="{{ old('phone_number2', $employee->phone_number2) }}" maxlength="14"
                    oninput="this.value = this.value.replace(/\D+/g, '')"
                    class="form-control @error('phone_number2') is-invalid @enderror" name="phone_number2">
                  @error('phone_number2')
                    <a style="color: red">
                      <small>
                        {{ $message }}
                      </small>
                    </a>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="paspor_number">No. Paspor</label>
                  <input type="text" id="paspor_number" maxlength="12"
                    value="{{ old('paspor_number', $employee->paspor_number) }}"
                    class="form-control @error('paspor_number') is-invalid @enderror" name="paspor_number">
                  @error('paspor_number')
                    <a style="color: red">
                      <small>
                        {{ $message }}
                      </small>
                    </a>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="ktp_number">No. KTP <code>*</code></label>
                  <input type="text" id="ktp_number" value="{{ old('ktp_number', $employee->ktp_number) }}"
                    maxlength="16" oninput="this.value = this.value.replace(/\D+/g, '')"
                    class="form-control @error('ktp_number') is-invalid @enderror" name="ktp_number">
                  @error('ktp_number')
                    <a style="color: red">
                      <small>
                        {{ $message }}
                      </small>
                    </a>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="kk_number">No. Kartu Keluarga</label>
                  <input type="text" id="kk_number" value="{{ old('kk_number', $employee->kk_number) }}"
                    maxlength="16" oninput="this.value = this.value.replace(/\D+/g, '')"
                    class="form-control @error('kk_number') is-invalid @enderror" name="kk_number">
                  @error('kk_number')
                    <a style="color: red">
                      <small>
                        {{ $message }}
                      </small>
                    </a>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="npwp_number">No. NPWP</label>
                  <input type="text" id="npwp_number" maxlength="20"
                    value="{{ old('npwp_number', $employee->npwp_number) }}"
                    class="form-control @error('npwp_number') is-invalid @enderror" name="npwp_number">
                  @error('npwp_number')
                    <a style="color: red">
                      <small>
                        {{ $message }}
                      </small>
                    </a>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="bpjs_kesehatan_number">No. BPJS Kesehatan</label>
                  <input type="text" id="bpjs_kesehatan_number" maxlength="20"
                    value="{{ old('bpjs_kesehatan_number', $employee->bpjs_kesehatan_number) }}"
                    oninput="this.value = this.value.replace(/\D+/g, '')"
                    class="form-control @error('bpjs_kesehatan_number') is-invalid @enderror"
                    name="bpjs_kesehatan_number">
                  @error('bpjs_kesehatan_number')
                    <a style="color: red">
                      <small>
                        {{ $message }}
                      </small>
                    </a>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="bpjs_naker_number">No. BPJS Ketenagakerjaan</label>
                  <input type="text" id="bpjs_naker_number"
                    value="{{ old('bpjs_naker_number', $employee->bpjs_naker_number) }}"
                    oninput="this.value = this.value.replace(/\D+/g, '')" maxlength="20"
                    class="form-control @error('bpjs_naker_number') is-invalid @enderror" name="bpjs_naker_number">
                  @error('bpjs_naker_number')
                    <a style="color: red">
                      <small>
                        {{ $message }}
                      </small>
                    </a>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="glasses">Kacamata</label>
                  <select type="text" id="glasses" class="form-control @error('glasses') is-invalid @enderror"
                    name="glasses">
                    {{-- <option value="" disabled selected>Choose</option> --}}
                    <option value="0" {{ old('glasses', $employee->glasses) == '0' ? 'selected' : '' }}>Tidak
                    </option>
                    <option value="1" {{ old('glasses', $employee->glasses) == '1' ? 'selected' : '' }}>Iya
                    </option>
                  </select>
                  @error('glasses')
                    <a style="color: red">
                      <small>
                        {{ $message }}
                      </small>
                    </a>
                  @enderror
                </div>

              </div>

              <div class="col-md-6 col-12">
                <div class="form-group">
                  <label for="pob">Tempat Lahir <code>*</code></label>
                  <input type="text" id="pob" value="{{ old('pob', $employee->pob) }}"
                    class="form-control @error('pob') is-invalid @enderror" name="pob">
                  @error('pob')
                    <a style="color: red">
                      <small>
                        {{ $message }}
                      </small>
                    </a>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="dob">Tanggal Lahir <code>*</code></label>
                  <input type="date" id="dob" name="dob" value="{{ old('dob', $employee->dob) }}"
                    class="form-control  @error('dob') is-invalid @enderror" placeholder="Select date..">
                  @error('dob')
                    <a style="color: red">
                      <small>
                        {{ $message }}
                      </small>
                    </a>
                  @enderror
                </div>

                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="gender">Jenis Kelamin <code>*</code></label>
                    <select name="gender" id="gender"
                      class="form-control  @error('gender') is-invalid @enderror">
                      <option value="" disabled selected>Choose</option>
                      <option value="LAKI-LAKI"
                        {{ old('gender', $employee->gender) == 'LAKI-LAKI' ? 'selected' : '' }}>
                        Laki-laki
                      </option>
                      <option value="PEREMPUAN"
                        {{ old('gender', $employee->gender) == 'PEREMPUAN' ? 'selected' : '' }}>
                        Perempuan
                      </option>
                    </select>
                    @error('gender')
                      <a style="color: red">
                        <small>
                          {{ $message }}
                        </small>
                      </a>
                    @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label for="blood_type">Gol. Darah</label>
                    <select id="blood_type" maxlength="2"
                      class="form-control @error('blood_type') is-invalid @enderror" name="blood_type">
                      <option value="" disabled {{ old('blood_type') === null ? 'selected' : '' }}>Choose
                      </option>
                      <option value="A" {{ old('blood_type', $employee->blood_type) == 'A' ? 'selected' : '' }}>
                        A</option>
                      <option value="A-" {{ old('blood_type', $employee->blood_type) == 'A-' ? 'selected' : '' }}>
                        A-</option>
                      <option value="A+" {{ old('blood_type', $employee->blood_type) == 'A+' ? 'selected' : '' }}>
                        A+</option>
                      <option value="B" {{ old('blood_type', $employee->blood_type) == 'B' ? 'selected' : '' }}>
                        B</option>
                      <option value="B-" {{ old('blood_type', $employee->blood_type) == 'B-' ? 'selected' : '' }}>
                        B-</option>
                      <option value="B+" {{ old('blood_type', $employee->blood_type) == 'B+' ? 'selected' : '' }}>
                        B+</option>
                      <option value="AB" {{ old('blood_type', $employee->blood_type) == 'AB' ? 'selected' : '' }}>
                        AB</option>
                      <option value="AB-"
                        {{ old('blood_type', $employee->blood_type) == 'AB-' ? 'selected' : '' }}>AB-</option>
                      <option value="AB+"
                        {{ old('blood_type', $employee->blood_type) == 'AB+' ? 'selected' : '' }}>AB+</option>
                      <option value="O" {{ old('blood_type', $employee->blood_type) == 'O' ? 'selected' : '' }}>
                        O</option>
                      <option value="O-" {{ old('blood_type', $employee->blood_type) == 'O-' ? 'selected' : '' }}>
                        O-</option>
                      <option value="O+" {{ old('blood_type', $employee->blood_type) == 'O+' ? 'selected' : '' }}>
                        O+</option>
                    </select>

                    @error('blood_type')
                      <a style="color: red">
                        <small>{{ $message }}</small>
                      </a>
                    @enderror
                  </div>

                </div>

                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="height">Tinggi (cm)</label>
                    <input type="text" value="{{ old('height', $employee->height) }}" id="height"
                      class="form-control @error('height') is-invalid @enderror" maxlength="3"
                      oninput="this.value = this.value.replace(/\D+/g, '')" name="height">
                    @error('height')
                      <a style="color: red">
                        <small>
                          {{ $message }}
                        </small>
                      </a>
                    @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label for="weight">Berat (kg)</label>
                    <input type="text" value="{{ old('weight', $employee->weight) }}" id="weight"
                      class="form-control  @error('weight') is-invalid @enderror" maxlength="3"
                      oninput="this.value = this.value.replace(/\D+/g, '')" name="weight">
                    @error('weight')
                      <a style="color: red">
                        <small>
                          {{ $message }}
                        </small>
                      </a>
                    @enderror
                  </div>
                </div>

                <div class="form-group">
                  <label for="marital_status">Status Perkawinan <code>*</code></label>
                  <select id="marital_status" class="form-control @error('marital_status') is-invalid @enderror"
                    name="marital_status">
                    <option value="" disabled selected>Choose</option>
                    <option value="Kawin"
                      {{ old('marital_status', $employee->marital_status) == 'Kawin' ? 'selected' : '' }}>Kawin
                    </option>
                    <option value="Belum Kawin"
                      {{ old('marital_status', $employee->marital_status) == 'Belum Kawin' ? 'selected' : '' }}>Belum
                      Kawin</option>
                    <option value="Cerai Hidup"
                      {{ old('marital_status', $employee->marital_status) == 'Cerai Hidup' ? 'selected' : '' }}>Cerai
                      Hidup</option>
                    <option value="Cerai Mati"
                      {{ old('marital_status', $employee->marital_status) == 'Cerai Mati' ? 'selected' : '' }}>Cerai
                      Mati</option>
                  </select>

                  @error('marital_status')
                    <a style="color: red">
                      <small>{{ $message }}</small>
                    </a>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="religion">Agama</label>
                  <select id="religion" name="religion"
                    class="form-control @error('religion') is-invalid @enderror">
                    <option value="" disabled selected>Select Religion</option>
                    <option value="Islam" {{ old('religion', $employee->religion) == 'Islam' ? 'selected' : '' }}>
                      Islam
                    </option>
                    <option value="Kristen" {{ old('religion', $employee->religion) == 'Kristen' ? 'selected' : '' }}>
                      Kristen
                    </option>
                    <option value="Katolik" {{ old('religion', $employee->religion) == 'Katolik' ? 'selected' : '' }}>
                      Katolik
                    </option>
                    <option value="Hindu" {{ old('religion', $employee->religion) == 'Hindu' ? 'selected' : '' }}>
                      Hindu
                    </option>
                    <option value="Buddha" {{ old('religion', $employee->religion) == 'Buddha' ? 'selected' : '' }}>
                      Buddha
                    </option>
                    <option value="Konghucu"
                      {{ old('religion', $employee->religion) == 'Konghucu' ? 'selected' : '' }}>
                      Konghucu
                    </option>
                    <option value="Dan Lain-lain"
                      {{ old('religion', $employee->religion) == 'Dan Lain-lain' ? 'selected' : '' }}>
                      Dan Lain-lain
                    </option>
                  </select>
                  @error('religion')
                    <a style="color: red">
                      <small>
                        {{ $message }}
                      </small>
                    </a>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="nationality">Kewarganegaraan</label>
                  <input type="text" value="{{ $employee->nationality }}" id="nationality"
                    class="form-control @error('nationality') is-invalid @enderror" name="nationality">
                  @error('nationality')
                    <a style="color: red">
                      <small>
                        {{ $message }}
                      </small>
                    </a>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="last_educational">Pendidikan Terakhir <code>*</code></label>
                  <select type="text" id="last_educational" name="last_educational"
                    class="form-control @error('last_educational') is-invalid @enderror">
                    <option value="" disabled selected>Choose</option>
                    <option value="S-3"
                      {{ old('last_educational', $employee->last_educational) == 'S-3' ? 'selected' : '' }}> S-3
                    </option>
                    <option value="S-2"
                      {{ old('last_educational', $employee->last_educational) == 'S-2' ? 'selected' : '' }}> S-2
                    </option>
                    <option value="S-1"
                      {{ old('last_educational', $employee->last_educational) == 'S-1' ? 'selected' : '' }}> S-1
                    </option>
                    <option value="D-4"
                      {{ old('last_educational', $employee->last_educational) == 'D-4' ? 'selected' : '' }}> D-4
                    </option>
                    <option value="D-3"
                      {{ old('last_educational', $employee->last_educational) == 'D-3' ? 'selected' : '' }}> D-3
                    </option>
                    <option value="D-2"
                      {{ old('last_educational', $employee->last_educational) == 'D-2' ? 'selected' : '' }}> D-2
                    </option>
                    <option value="D-1"
                      {{ old('last_educational', $employee->last_educational) == 'D-1' ? 'selected' : '' }}> D-1
                    </option>
                    <option value="MA"
                      {{ old('last_educational', $employee->last_educational) == 'MA' ? 'selected' : '' }}> MA
                    </option>
                    <option value="SMK"
                      {{ old('last_educational', $employee->last_educational) == 'SMK' ? 'selected' : '' }}> SMK
                    </option>
                    <option value="SMA"
                      {{ old('last_educational', $employee->last_educational) == 'SMA' ? 'selected' : '' }}> SMA
                    </option>
                    <option value="MTS"
                      {{ old('last_educational', $employee->last_educational) == 'MTS' ? 'selected' : '' }}> MTS
                    </option>
                    <option value="SMP"
                      {{ old('last_educational', $employee->last_educational) == 'SMP' ? 'selected' : '' }}> SMP
                    </option>
                    <option value="SD"
                      {{ old('last_educational', $employee->last_educational) == 'SD' ? 'selected' : '' }}> SD
                    </option>
                  </select>
                  @error('last_educational')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="study">Jurusan <code>*</code></label>
                  <input type="text" value="{{ old('study', $employee->study) }}" id="study"
                    class="form-control @error('study') is-invalid @enderror" name="study">
                  @error('study')
                    <a style="color: red">
                      <small>
                        {{ $message }}
                      </small>
                    </a>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="ethnic">Suku Bangsa</label>
                  <input type="text" value="{{ old('ethnic', $employee->ethnic) }}" id="ethnic"
                    class="form-control @error('ethnic') is-invalid @enderror" name="ethnic">
                  @error('ethnic')
                    <a style="color: red">
                      <small>
                        {{ $message }}
                      </small>
                    </a>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="disability">Penyandang Disabilitas</label>
                  <select type="text" id="disability" name="disability"
                    class="form-control @error('disability') is-invalid @enderror">
                    <option value="" selected>Tidak Ada</option>
                    <option value="Tunanetra"
                      {{ old('disability', $employee->disability) == 'Tunanetra' ? 'selected' : '' }}>
                      Tunanetra (Tidak bisa melihat / buta)
                    </option>
                    <option value="Tunarungu"
                      {{ old('disability', $employee->disability) == 'Tunarungu' ? 'selected' : '' }}>
                      Tunarungu (Tidak bisa mendengar / tuli)
                    </option>
                    <option value="Tunawicara"
                      {{ old('disability', $employee->disability) == 'Tunawicara' ? 'selected' : '' }}>
                      Tunawicara (Tidak bisa berbicara / bisu)
                    </option>
                    <option value="Tunadaksa"
                      {{ old('disability', $employee->disability) == 'Tunadaksa' ? 'selected' : '' }}>
                      Tunadaksa (Cacat tubuh)
                    </option>
                  </select>
                  @error('disability')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>

              </div>

              <div class="col-12">
                <div class="form-group">
                  <label for="tag">Tag</label>
                  <textarea type="text" id="tag" class="form-control  @error('tag') is-invalid @enderror" name="tag"
                    rows="3">{{ old('tag', $employee->tag) }}</textarea>
                  @error('tag')
                    <a style="color: red">
                      <small>
                        {{ $message }}
                      </small>
                    </a>
                  @enderror
                </div>

                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="candidate_from">Pelamar Dari</label>
                    <select type="text" id="candidate_from"
                      class="form-control @error('candidate_from') is-invalid @enderror" name="candidate_from">
                      <option value="" disabled selected>Choose</option>
                      <option value="MANAJEMEN"
                        {{ old('candidate_from', $employee->candidate_from) == 'MANAJEMEN' ? 'selected' : '' }}>
                        Manajemen
                      </option>
                      <option value="UMUM"
                        {{ old('candidate_from', $employee->candidate_from) == 'UMUM' ? 'selected' : '' }}>Umum
                      </option>
                    </select>
                    @error('candidate_from')
                      <a style="color: red">
                        <small>
                          {{ $message }}
                        </small>
                      </a>
                    @enderror
                  </div>
                </div>

                <div class="form-group">
                  <label for="reference">Refrensi</label>
                  <textarea type="text" id="reference" class="form-control  @error('reference') is-invalid @enderror"
                    name="reference" rows="3">{{ old('reference', $employee->reference) }}</textarea>
                  @error('reference')
                    <a style="color: red">
                      <small>
                        {{ $message }}
                      </small>
                    </a>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="ktp_address">Alamat Sesuai KTP <code>*</code></label>
                  <textarea type="text" id="ktp_address" class="form-control  @error('ktp_address') is-invalid @enderror"
                    name="ktp_address" rows="5">{{ old('ktp_address', $employee->ktp_address) }}</textarea>
                  @error('ktp_address')
                    <a style="color: red">
                      <small>
                        {{ $message }}
                      </small>
                    </a>
                  @enderror
                </div>

                <div class="form-group col-md-3">
                  <label for="zipcode_ktp">Kode Pos KTP <code>*</code></label>
                  <input type="text" oninput="this.value = this.value.replace(/\D+/g, '')" id="zipcode_ktp"
                    value="{{ old('zipcode_ktp', $employee->zipcode) }}"
                    class="form-control  @error('zipcode_ktp') is-invalid @enderror" name="zipcode_ktp">
                  @error('zipcode_ktp')
                    <a style="color: red">
                      <small>
                        {{ $message }}
                      </small>
                    </a>
                  @enderror
                </div>

                <div class="row">
                  <!-- Latitude and Longitude for Alamat KTP -->
                  <div class="form-group col-md-5">
                    <label for="latitude_ktp">Latitude Alamat KTP</label>
                    <input type="text" id="latitude_ktp" value="{{ $employee->latitude_ktp }}"
                      name="latitude_ktp" class="form-control" readonly>
                  </div>
                  <div class="form-group col-md-5">
                    <label for="longitude_ktp">Longitude Alamat KTP</label>
                    <input type="text" id="longitude_ktp" value="{{ $employee->longitude_ktp }}"
                      name="longitude_ktp" class="form-control" readonly>
                  </div>
                  <div class="form-group col-md-2">
                    <label for="map_ktp">Map</label>
                    <button type="button" class="form-control btn btn-sm btn-primary" data-bs-toggle="modal"
                      data-bs-target="#mapModalKTP">
                      Open
                    </button>
                  </div>
                </div>

                <div class="form-group">
                  <label for="current_address">Alamat Domisili <code>*</code></label>
                  <textarea type="text" id="current_address" class="form-control @error('current_address') is-invalid @enderror"
                    name="current_address" rows="5"> {{ old('current_address', $employee->current_address) }}</textarea>
                  @error('current_address')
                    <a style="color: red">
                      <small>
                        {{ $message }}
                      </small>
                    </a>
                  @enderror
                </div>

                <div class="row mt-3">
                  <!-- Latitude and Longitude for Alamat Domisili -->
                  <div class="form-group col-md-5">
                    <label for="latitude_domisili">Latitude Alamat Domisili</label>
                    <input type="text" id="latitude_domisili" value="{{ $employee->latitude_domisili }}"
                      name="latitude_domisili" class="form-control" readonly>
                  </div>
                  <div class="form-group col-md-5">
                    <label for="longitude_domisili">Longitude Alamat Domisili</label>
                    <input type="text" id="longitude_domisili" value="{{ $employee->longitude_domisili }}"
                      name="longitude_domisili" class="form-control" readonly>
                  </div>
                  <div class="form-group col-md-2">
                    <label for="map_domisili">Map</label>
                    <button type="button" class="form-control btn btn-sm btn-primary" data-bs-toggle="modal"
                      data-bs-target="#mapModalDomisili">
                      Open
                    </button>
                  </div>
                </div>
              </div>

              <hr>

              <div class="col-12">

                {{-- sim --}}
                <div class="row">
                  <div class="form-group col-md-5">
                    <label for="sim_a">SIM A</label>
                    <input type="text" value="{{ old('sim_a', $employee->sim_a) }}"
                      oninput="this.value = this.value.replace(/\D+/g, '')" id="sim_a" name="sim_a"
                      class="form-control">
                  </div>
                  <div class="form-group col-md-3">
                    <label for="expired_sim_a">Masa Berlaku</label>
                    <input type="date" value="{{ old('expired_sim_a', $employee->expired_sim_a) }}"
                      id="expired_sim_a" name="expired_sim_a" class="form-control">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="file_sim_a">File</label>
                    <input class="form-control" accept=".jpg, .png, .pdf, .jpeg" type="file" name="file_sim_a"
                      id="file_sim_a">
                    @error('file_sim_a')
                      <a style="color: red">
                        <small>
                          {{ $message }}
                        </small>
                      </a>
                    @enderror
                  </div>
                </div>

                <div class="row">
                  <div class="form-group col-md-5">
                    <label for="sim_b">SIM B</label>
                    <input type="text" value="{{ old('sim_b', $employee->sim_b) }}"
                      oninput="this.value = this.value.replace(/\D+/g, '')" id="sim_b" name="sim_b"
                      class="form-control">
                  </div>
                  <div class="form-group col-md-3">
                    <label for="expired_sim_b">Masa Berlaku</label>
                    <input type="date" value="{{ old('expired_sim_b', $employee->expired_sim_b) }}"
                      id="expired_sim_b" name="expired_sim_b" class="form-control">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="file_sim_b">File</label>
                    <input class="form-control" accept=".jpg, .png, .pdf, .jpeg" type="file" name="file_sim_b"
                      id="file_sim_b">
                    @error('file_sim_b')
                      <a style="color: red">
                        <small>
                          {{ $message }}
                        </small>
                      </a>
                    @enderror
                  </div>
                </div>

                <div class="row">
                  <div class="form-group col-md-5">
                    <label for="sim_c">SIM C</label>
                    <input type="text" value="{{ old('sim_c', $employee->sim_c) }}"
                      oninput="this.value = this.value.replace(/\D+/g, '')" id="sim_c" name="sim_c"
                      class="form-control">
                  </div>
                  <div class="form-group col-md-3">
                    <label for="expired_sim_c">Masa Berlaku</label>
                    <input type="date" value="{{ old('expired_sim_c', $employee->expired_sim_c) }}"
                      id="expired_sim_c" name="expired_sim_c" class="form-control">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="file_sim_c">File</label>
                    <input class="form-control" accept=".jpg, .png, .pdf, .jpeg" type="file" name="file_sim_c"
                      id="file_sim_c">
                    @error('file_sim_c')
                      <a style="color: red">
                        <small>
                          {{ $message }}
                        </small>
                      </a>
                    @enderror
                  </div>
                </div>

                <hr>

                {{-- filefile --}}
                <div class="row">
                  <div class="form-group col-md-4">
                    <label for="file_cv" class="form-label">CV</label>
                    <input class="form-control" accept=".pdf" type="file" id="file_cv" name="file_cv">
                    @error('file_cv')
                      <a style="color: red">
                        <small>
                          {{ $message }}
                        </small>
                      </a>
                    @enderror
                  </div>
                  <div class="form-group col-md-4">
                    <label for="file_ktp" class="form-label">KTP & NPWP</label>
                    <input class="form-control" accept=".pdf" type="file" id="file_ktp" name="file_ktp">
                    @error('file_ktp')
                      <a style="color: red">
                        <small>
                          {{ $message }}
                        </small>
                      </a>
                    @enderror
                  </div>
                  <div class="form-group col-md-4">
                    <label for="file_ijazah" class="form-label">IJAZAH & TRANSKRIP NILAI</label>
                    <input class="form-control" accept=".pdf" type="file" id="file_ijazah" name="file_ijazah">
                    @error('file_ijazah')
                      <a style="color: red">
                        <small>
                          {{ $message }}
                        </small>
                      </a>
                    @enderror
                  </div>
                  <div class="form-group col-md-4">
                    <label for="file_skck" class="form-label">SKCK AKTIF</label>
                    <input class="form-control" accept=".pdf" type="file" id="file_skck" name="file_skck">
                    @error('file_skck')
                      <a style="color: red">
                        <small>
                          {{ $message }}
                        </small>
                      </a>
                    @enderror
                  </div>
                  <div class="form-group col-md-4">
                    <label for="file_kk" class="form-label">KARTU KELUARGA</label>
                    <input class="form-control" accept=".pdf" type="file" id="file_kk" name="file_kk">
                    @error('file_kk')
                      <a style="color: red">
                        <small>
                          {{ $message }}
                        </small>
                      </a>
                    @enderror
                  </div>
                  <div class="form-group col-md-4">
                    <label for="file_surat_sehat" class="form-label">SURAT SEHAT / BEBAS NARKOBA</label>
                    <input class="form-control" accept=".pdf" type="file" id="file_surat_sehat"
                      name="file_surat_sehat">
                    @error('file_surat_sehat')
                      <a style="color: red">
                        <small>
                          {{ $message }}
                        </small>
                      </a>
                    @enderror
                  </div>
                  <div class="form-group col-md-4">
                    <label for="file_vaksin" class="form-label">SERTIFIKAT VAKSIN</label>
                    <input class="form-control" accept=".pdf" type="file" id="file_vaksin" name="file_vaksin">
                    @error('file_vaksin')
                      <a style="color: red">
                        <small>
                          {{ $message }}
                        </small>
                      </a>
                    @enderror
                  </div>
                  <div class="form-group col-md-4">
                    <label for="file_sertifikat" class="form-label">SERTIFIKAT PELATIHAN</label>
                    <input class="form-control" accept=".pdf" type="file" id="file_sertifikat"
                      name="file_sertifikat">
                    @error('file_sertifikat')
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

            <div class="col-12 d-flex justify-content-end mt-4">
              <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
              <a href="{{ route('employee.index') }}" class="btn btn-light-secondary me-1 mb-1">Back</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    </div>

    <!-- Map Modal -->
    <!-- Modal for KTP Map -->
    <div class="modal fade" id="mapModalKTP" tabindex="-1" aria-labelledby="mapModalKTPLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="mapModalKTPLabel">Select Location for Alamat KTP</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div id="mapKTP" style="height: 400px;"></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal for Domisili Map -->
    <div class="modal fade" id="mapModalDomisili" tabindex="-1" aria-labelledby="mapModalDomisiliLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="mapModalDomisiliLabel">Select Location for Alamat Domisili</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div id="mapDomisili" style="height: 400px;"></div>
          </div>
        </div>
      </div>
    </div>


  </form>
</section>

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
        mapKTP = L.map('mapKTP').setView([{{ $employee->latitude_ktp ?? -6.1580339989448305 }},
            {{ $employee->longitude_ktp ?? 106.88319683074951 }}
          ],
          13); // Default location: Jakarta
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(mapKTP);

        // Add a marker at the candidate's KTP location
        var markerKTP = L.marker([{{ $employee->latitude_ktp ?? -6.1580339989448305 }},
          {{ $employee->longitude_ktp ?? 106.88319683074951 }}
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
        mapDomisili = L.map('mapDomisili').setView([
            {{ $employee->latitude_domisili ?? -6.1580339989448305 }},
            {{ $employee->longitude_domisili ?? 106.88319683074951 }}
          ],
          13); // Default location: Jakarta
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(mapDomisili);

        // Add a marker at the candidate's domisili location
        var markerDomisili = L.marker([{{ $employee->latitude_domisili ?? -6.1580339989448305 }},
          {{ $employee->longitude_domisili ?? 106.88319683074951 }}
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


@endsection
