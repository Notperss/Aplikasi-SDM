@extends('layouts.app')
@section('title', 'Pelamar')
@section('content')

@section('breadcrumb')
  <x-breadcrumb title="Data Diri Pelamar" page="Recruitment" active="Pelamar" route="{{ route('candidate.index') }}" />
@endsection

<!-- // Basic multiple Column Form section start -->
{{-- <section id="multiple-column-form">
  <div class="row match-height">
    <div class="col-12">
      <div class="card">
        <div class="card-content">
          <div class="card-body">
            <form action="{{ route('candidate.store') }}" method="post" enctype="multipart/form-data">
              @csrf

              <div class="row">

                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" id="name" value="{{ old('name') }}"
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
                    <input type="email" id="email" value="{{ old('email') }}"
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
                    <label for="phone_number">No. Telpon</label>
                    <input type="text" id="phone_number" value="{{ old('phone_number') }}" maxlength="13"
                      oninput="this.value = this.value.replace(/\D+/g, '')"
                      class="form-control @error('phone_number') is-invalid @enderror" name="phone_number">
                    @error('phone_number')
                      <a style="color: red">
                        <small>
                          {{ $message }}
                        </small>
                      </a>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="ktp_number">No. KTP</label>
                    <input type="text" id="ktp_number" value="{{ old('ktp_number') }}" maxlength="16"
                      oninput="this.value = this.value.replace(/\D+/g, '')"
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
                    <input type="text" id="kk_number" value="{{ old('kk_number') }}" maxlength="16"
                      oninput="this.value = this.value.replace(/\D+/g, '')"
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
                    <input type="text" inputmode="numeric" value="{{ old('npwp_number') }}" maxlength="16"
                      oninput="this.value = this.value.replace(/\D+/g, '')" id="npwp_number"
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
                    <label for="ktp_address">Alamat Sesuai KTP</label>
                    <textarea type="text" id="ktp_address" value="{{ old('ktp_address') }}"
                      class="form-control  @error('ktp_address') is-invalid @enderror" name="ktp_address" rows="5"></textarea>
                    @error('ktp_address')
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
                    <label for="pob">Tempat Lahir</label>
                    <input type="text" id="pob" value="{{ old('pob') }}"
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
                    <label for="dob">Tanggal Lahir</label>
                    <input type="date" id="dob" name="dob" value="{{ old('dob') }}"
                      class="form-control flatpickr-no-config @error('dob') is-invalid @enderror"
                      placeholder="Select date..">
                    @error('dob')
                      <a style="color: red">
                        <small>
                          {{ $message }}
                        </small>
                      </a>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="gender">Jenis Kelamin</label>
                    <select name="gender" id="gender"
                      class="form-control  @error('gender') is-invalid @enderror">
                      <option value="" disabled selected>Choose</option>
                      <option value="LAKI-LAKI" {{ old('gender') == 'LAKI-LAKI' ? 'selected' : '' }}>
                        Laki-laki
                      </option>
                      <option value="PEREMPUAN" {{ old('gender') == 'PEREMPUAN' ? 'selected' : '' }}>
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
                  <div class="form-group">
                    <label for="religion">Agama</label>
                    <input type="text" id="religion" value="{{ old('religion') }}"
                      class="form-control @error('religion') is-invalid @enderror" name="religion">
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
                    <input type="text" value="{{ old('nationality') }}" id="nationality"
                      class="form-control @error('nationality') is-invalid @enderror" name="nationality">
                    @error('nationality')
                      <a style="color: red">
                        <small>
                          {{ $message }}
                        </small>
                      </a>
                    @enderror
                  </div>
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label for="height">Tinggi (cm)</label>
                      <input type="text" value="{{ old('height') }}" id="height"
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
                      <input type="text" value="{{ old('weight') }}" id="weight"
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
                    <label for="current_address">Alamat Sekarang</label>
                    <textarea type="text" id="current_address" class="form-control @error('current_address') is-invalid @enderror"
                      name="current_address" rows="5"> {{ old('current_address') }}</textarea>
                  </div>
                  @error('current_address')
                    <a style="color: red">
                      <small>
                        {{ $message }}
                      </small>
                    </a>
                  @enderror
                </div>

                <div class="col-12 d-flex justify-content-end mt-4">
                  <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                  <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section> --}}
<!-- // Basic multiple Column Form section end -->

{{-- <section class="section">
  <form action="{{ route('candidate.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
      <div class="col-12 col-lg-4">
        <div class="card-body mb-2">
          <div class="d-flex justify-content-center align-items-center flex-column">

            <!-- Image Preview -->
            <img src="{{ asset('storage/img/2.jpg') }}" alt="user-avatar" class="d-block rounded" width="150px"
              id="uploadedAvatar" />

            <!-- Upload Icon and Input -->
            <label for="uploadImage" class="mt-2" style="cursor: pointer;">
              <i class="bi bi-upload" style="font-size: 24px; color: rgba(0, 128, 255, 0.974);"></i>
              <span> Upload</span>
              <input type="file" id="uploadImage" value="{{ old('photo') }}" name="photo"
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
            <p class="mb-0" style="font-size: 70%"> * Ukuran File Maks. 500KB</p>
            <p class="mb-0" style="font-size: 70%"> * Pastikan foto wajah terlihat jelas</p>
          </div>
        </div>

      </div>
      <div class="col-12 col-lg-8">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-6 col-12">
                <div class="form-group">
                  <label for="name">Nama Lengkap</label>
                  <input type="text" id="name" value="{{ old('name') }}"
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
                  <input type="email" id="email" value="{{ old('email') }}"
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
                  <label for="phone_number">No. Telpon</label>
                  <input type="text" id="phone_number" value="{{ old('phone_number') }}" maxlength="13"
                    oninput="this.value = this.value.replace(/\D+/g, '')"
                    class="form-control @error('phone_number') is-invalid @enderror" name="phone_number">
                  @error('phone_number')
                    <a style="color: red">
                      <small>
                        {{ $message }}
                      </small>
                    </a>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="ktp_number">No. KTP</label>
                  <input type="text" id="ktp_number" value="{{ old('ktp_number') }}" maxlength="16"
                    oninput="this.value = this.value.replace(/\D+/g, '')"
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
                  <input type="text" id="kk_number" value="{{ old('kk_number') }}" maxlength="16"
                    oninput="this.value = this.value.replace(/\D+/g, '')"
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
                  <input type="text" inputmode="numeric" value="{{ old('npwp_number') }}" maxlength="16"
                    oninput="this.value = this.value.replace(/\D+/g, '')" id="npwp_number"
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
                  <label for="ktp_address">Alamat Sesuai KTP</label>
                  <textarea type="text" id="ktp_address" class="form-control  @error('ktp_address') is-invalid @enderror"
                    name="ktp_address" rows="5">{{ old('ktp_address') }}</textarea>
                  @error('ktp_address')
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
                  <label for="pob">Tempat Lahir</label>
                  <input type="text" id="pob" value="{{ old('pob') }}"
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
                  <label for="dob">Tanggal Lahir</label>
                  <input type="date" id="dob" name="dob" value="{{ old('dob') }}"
                    class="form-control flatpickr-no-config @error('dob') is-invalid @enderror"
                    placeholder="Select date..">
                  @error('dob')
                    <a style="color: red">
                      <small>
                        {{ $message }}
                      </small>
                    </a>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="gender">Jenis Kelamin</label>
                  <select name="gender" id="gender" class="form-control  @error('gender') is-invalid @enderror">
                    <option value="" disabled selected>Choose</option>
                    <option value="LAKI-LAKI" {{ old('gender') == 'LAKI-LAKI' ? 'selected' : '' }}>
                      Laki-laki
                    </option>
                    <option value="PEREMPUAN" {{ old('gender') == 'PEREMPUAN' ? 'selected' : '' }}>
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
                <div class="form-group">
                  <label for="religion">Agama</label>
                  <input type="text" id="religion" value="{{ old('religion') }}"
                    class="form-control @error('religion') is-invalid @enderror" name="religion">
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
                  <input type="text" value="{{ old('nationality') }}" id="nationality"
                    class="form-control @error('nationality') is-invalid @enderror" name="nationality">
                  @error('nationality')
                    <a style="color: red">
                      <small>
                        {{ $message }}
                      </small>
                    </a>
                  @enderror
                </div>
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="height">Tinggi (cm)</label>
                    <input type="text" value="{{ old('height') }}" id="height"
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
                    <input type="text" value="{{ old('weight') }}" id="weight"
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
                  <label for="current_address">Alamat Sekarang</label>
                  <textarea type="text" id="current_address" class="form-control @error('current_address') is-invalid @enderror"
                    name="current_address" rows="5"> {{ old('current_address') }}</textarea>
                </div>
                @error('current_address')
                  <a style="color: red">
                    <small>
                      {{ $message }}
                    </small>
                  </a>
                @enderror
              </div>

              <div class="col-12 d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
              </div>
            </div>

  </form>
  </div>
  </div>
  </div>
  </div>
</section> --}}

<section class="section">
  <form action="{{ route('candidate.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">

      <div class="col-12 col-lg-4">
        <div class="card-body mb-2">
          <div class="d-flex justify-content-center align-items-center flex-column">

            <!-- Image Preview -->
            <img src="{{ asset('storage/img/2.jpg') }}" alt="user-avatar" class="d-block rounded" width="150px"
              id="uploadedAvatar" />

            <!-- Upload Icon and Input -->
            <label for="uploadImage" class="mt-2 btn btn-sm btn-primary" style="cursor: pointer;">
              {{-- <i class="bi bi-upload" style="font-size: 24px; color: rgba(0, 128, 255, 0.974);"></i> --}}
              <span> Upload</span>
              <input type="file" id="uploadImage" value="{{ old('photo') }}" name="photo"
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
            <p class="mb-0" style="font-size: 70%"> * Ukuran File Maks. 500KB</p>
            <p class="mb-0" style="font-size: 70%"> * Dimensi Foto 3x4</p>
            <p class="mb-0" style="font-size: 70%"> * Pastikan foto wajah terlihat jelas</p>
          </div>

          <div class="card mt-3">
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
                <p class="card-text text-sm">
                  * Ekstensi File : pdf <br>
                  * Ukuran File Maks. 500KB
                </p>
              </div>
            </div>
          </div>

        </div>
      </div>

      <div class="col-12 col-lg-8">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-6 col-12">
                <div class="form-group">
                  <label for="name">Nama Lengkap</label>
                  <input type="text" id="name" value="{{ old('name') }}"
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
                  <input type="email" id="email" value="{{ old('email') }}"
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
                  <label for="phone_number">No. Telpon</label>
                  <input type="text" id="phone_number" value="{{ old('phone_number') }}" maxlength="14"
                    oninput="this.value = this.value.replace(/\D+/g, '')"
                    class="form-control @error('phone_number') is-invalid @enderror" name="phone_number">
                  @error('phone_number')
                    <a style="color: red">
                      <small>
                        {{ $message }}
                      </small>
                    </a>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="paspor_number">No. Paspor</label>
                  <input type="text" id="paspor_number" maxlength="9" value="{{ old('paspor_number') }}"
                    maxlength="16" class="form-control @error('paspor_number') is-invalid @enderror"
                    name="paspor_number">
                  @error('paspor_number')
                    <a style="color: red">
                      <small>
                        {{ $message }}
                      </small>
                    </a>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="ktp_number">No. KTP</label>
                  <input type="text" id="ktp_number" value="{{ old('ktp_number') }}" maxlength="16"
                    oninput="this.value = this.value.replace(/\D+/g, '')"
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
                  <input type="text" id="kk_number" value="{{ old('kk_number') }}" maxlength="16"
                    oninput="this.value = this.value.replace(/\D+/g, '')"
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
                  <label for="applied_position">Jabatan Yang Dilamar</label>
                  <input type="text" value="{{ old('applied_position') }}" id="applied_position"
                    class="form-control @error('applied_position') is-invalid @enderror" name="applied_position">
                  @error('applied_position')
                    <a style="color: red">
                      <small>
                        {{ $message }}
                      </small>
                    </a>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="recommended_position">Rekomendasi Penempatan</label>
                  <input type="text" value="{{ old('recommended_position') }}" id="recommended_position"
                    class="form-control @error('recommended_position') is-invalid @enderror"
                    name="recommended_position">
                  @error('recommended_position')
                    <a style="color: red">
                      <small>
                        {{ $message }}
                      </small>
                    </a>
                  @enderror
                </div>

                {{-- <div class="form-group">
                  <label for="ktp_address">Alamat Sesuai KTP</label>
                  <textarea type="text" id="ktp_address" class="form-control  @error('ktp_address') is-invalid @enderror"
                    name="ktp_address" rows="5">{{ old('ktp_address') }}</textarea>
                  @error('ktp_address')
                    <a style="color: red">
                      <small>
                        {{ $message }}
                      </small>
                    </a>
                  @enderror
                </div> --}}
              </div>

              <div class="col-md-6 col-12">
                <div class="form-group">
                  <label for="pob">Tempat Lahir</label>
                  <input type="text" id="pob" value="{{ old('pob') }}"
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
                  <label for="dob">Tanggal Lahir</label>
                  <input type="date" id="dob" name="dob" value="{{ old('dob') }}"
                    class="form-control flatpickr-no-config @error('dob') is-invalid @enderror"
                    placeholder="Select date..">
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
                    <label for="gender">Jenis Kelamin</label>
                    <select name="gender" id="gender"
                      class="form-control  @error('gender') is-invalid @enderror">
                      <option value="" disabled selected>Choose</option>
                      <option value="LAKI-LAKI" {{ old('gender') == 'LAKI-LAKI' ? 'selected' : '' }}>
                        Laki-laki
                      </option>
                      <option value="PEREMPUAN" {{ old('gender') == 'PEREMPUAN' ? 'selected' : '' }}>
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
                      <option value="-" {{ old('blood_type') == '-' ? 'selected' : '' }}>-</option>
                      <option value="A-" {{ old('blood_type') == 'A-' ? 'selected' : '' }}>A-</option>
                      <option value="A+" {{ old('blood_type') == 'A+' ? 'selected' : '' }}>A+</option>
                      <option value="B-" {{ old('blood_type') == 'B-' ? 'selected' : '' }}>B-</option>
                      <option value="B+" {{ old('blood_type') == 'B+' ? 'selected' : '' }}>B+</option>
                      <option value="AB-" {{ old('blood_type') == 'AB-' ? 'selected' : '' }}>AB-</option>
                      <option value="AB+" {{ old('blood_type') == 'AB+' ? 'selected' : '' }}>AB+</option>
                      <option value="O-" {{ old('blood_type') == 'O-' ? 'selected' : '' }}>O-</option>
                      <option value="O+" {{ old('blood_type') == 'O+' ? 'selected' : '' }}>O+</option>
                    </select>

                    @error('blood_type')
                      <a style="color: red">
                        <small>{{ $message }}</small>
                      </a>
                    @enderror
                  </div>

                </div>

                <div class="form-group">
                  <label for="marital_status">Status Perkawinan</label>
                  <select id="marital_status" class="form-control @error('marital_status') is-invalid @enderror"
                    name="marital_status">
                    <option value="" disabled selected>Choose</option>
                    <option value="Kawin" {{ old('marital_status') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                    <option value="Belum Kawin" {{ old('marital_status') == 'Belum Kawin' ? 'selected' : '' }}>Belum
                      Kawin</option>
                    <option value="Cerai Hidup" {{ old('marital_status') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai
                      Hidup</option>
                    <option value="Cerai Mati" {{ old('marital_status') == 'Cerai Mati' ? 'selected' : '' }}>Cerai
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
                    <option value="Islam" {{ old('religion') == 'Islam' ? 'selected' : '' }}>
                      Islam
                    </option>
                    <option value="Kristen" {{ old('religion') == 'Kristen' ? 'selected' : '' }}>
                      Kristen
                    </option>
                    <option value="Katolik" {{ old('religion') == 'Katolik' ? 'selected' : '' }}>
                      Katolik
                    </option>
                    <option value="Hindu" {{ old('religion') == 'Hindu' ? 'selected' : '' }}>
                      Hindu
                    </option>
                    <option value="Buddha" {{ old('religion') == 'Buddha' ? 'selected' : '' }}>
                      Buddha
                    </option>
                    <option value="Konghucu" {{ old('religion') == 'Konghucu' ? 'selected' : '' }}>
                      Konghucu
                    </option>
                    <option value="Dan Lain-lain" {{ old('religion') == 'Dan Lain-lain' ? 'selected' : '' }}>
                      Dan Lain-lain
                    </option>
                  </select>
                  @error('religion')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="nationality">Kewarganegaraan</label>
                  <input type="text" value="Indonesia" id="nationality"
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
                  <label for="ethnic">Suku Bangsa</label>
                  <input type="text" value="{{ old('ethnic') }}" id="ethnic"
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
                  <label for="candidate_from">Pelamar Dari</label>
                  <select type="text" id="candidate_from"
                    class="form-control @error('candidate_from') is-invalid @enderror" name="candidate_from">
                    <option value="" disabled selected>Choose</option>
                    <option value="MANAJEMEN" {{ old('candidate_from') == 'MANAJEMEN' ? 'selected' : '' }}>Manajemen
                    </option>
                    <option value="UMUM" {{ old('candidate_from') == 'UMUM' ? 'selected' : '' }}>Umum</option>
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

              <div class="col-12">
                <div class="form-group">
                  <label for="ktp_address">Alamat Sesuai KTP</label>
                  <textarea type="text" id="ktp_address" class="form-control  @error('ktp_address') is-invalid @enderror"
                    name="ktp_address" rows="5">{{ old('ktp_address') }}</textarea>
                  @error('ktp_address')
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
                    <input type="text" id="latitude_ktp" name="latitude_ktp" class="form-control" readonly>
                  </div>
                  <div class="form-group col-md-5">
                    <label for="longitude_ktp">Longitude Alamat KTP</label>
                    <input type="text" id="longitude_ktp" name="longitude_ktp" class="form-control" readonly>
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
                  <label for="current_address">Alamat Domisili</label>
                  <textarea type="text" id="current_address" class="form-control @error('current_address') is-invalid @enderror"
                    name="current_address" rows="5"> {{ old('current_address') }}</textarea>
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
                    <input type="text" id="latitude_domisili" name="latitude_domisili" class="form-control"
                      readonly>
                  </div>
                  <div class="form-group col-md-5">
                    <label for="longitude_domisili">Longitude Alamat Domisili</label>
                    <input type="text" id="longitude_domisili" name="longitude_domisili" class="form-control"
                      readonly>
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

                <div class="row">
                  <div class="form-group col-md-5">
                    <label for="sim_a">SIM A</label>
                    <input type="text" value="{{ old('sim_a') }}"
                      oninput="this.value = this.value.replace(/\D+/g, '')" id="sim_a" name="sim_a"
                      class="form-control">
                  </div>
                  <div class="form-group col-md-3">
                    <label for="expired_sim_a">Masa Berlaku</label>
                    <input type="date" value="{{ old('expired_sim_a') }}" id="expired_sim_a"
                      name="expired_sim_a" class="form-control">
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
                    <input type="text" value="{{ old('sim_b') }}"
                      oninput="this.value = this.value.replace(/\D+/g, '')" id="sim_b" name="sim_b"
                      class="form-control">
                  </div>
                  <div class="form-group col-md-3">
                    <label for="expired_sim_b">Masa Berlaku</label>
                    <input type="date" value="{{ old('expired_sim_b') }}" id="expired_sim_b"
                      name="expired_sim_b" class="form-control">
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
                    <input type="text" value="{{ old('sim_c') }}"
                      oninput="this.value = this.value.replace(/\D+/g, '')" id="sim_c" name="sim_c"
                      class="form-control">
                  </div>
                  <div class="form-group col-md-3">
                    <label for="expired_sim_c">Masa Berlaku</label>
                    <input type="date" value="{{ old('expired_sim_c') }}" id="expired_sim_c"
                      name="expired_sim_c" class="form-control">
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

              </div>

              <div class="col-12 d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
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
        mapKTP = L.map('mapKTP').setView([-6.158011331721201, 106.88320219516756],
          13); // Default location: Jakarta
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(mapKTP);

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
        mapDomisili = L.map('mapDomisili').setView([-6.158011331721201, 106.88320219516756],
          13); // Default location: Jakarta
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(mapDomisili);

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
@endsection
