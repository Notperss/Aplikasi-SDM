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
                  <div class="form-group col-md-6">
                    <label for="blood_type">Gol. Darah</label>
                    <select type="text" value="{{ old('blood_type') }}" id="blood_type" maxlength="2"
                      class="form-control @error('blood_type') is-invalid @enderror" name="blood_type">
                      <option value="" disabled selected>Choose</option>
                      <option value="A-">A-</option>
                      <option value="A+">A+</option>
                      <option value="B-">B-</option>
                      <option value="B+">B+</option>
                      <option value="AB-">BA-</option>
                      <option value="AB+">AB+</option>
                      <option value="O+">O+</option>
                      <option value="O-">O-</option>
                    </select>
                    @error('blood_type')
                      <a style="color: red">
                        <small>
                          {{ $message }}
                        </small>
                      </a>
                    @enderror
                  </div>
                </div>
                <div class="form-group">
                  <label for="candidate_from">Pelamar Dari</label>
                  <select type="text" value="{{ old('candidate_from') }}" id="candidate_from"
                    class="form-control @error('candidate_from') is-invalid @enderror" name="candidate_from">
                    <option value="" disabled selected>Choose</option>
                    <option value="MANAJEMEN">Manajemen</option>
                    <option value="UMUM">Umum</option>
                  </select>
                  @error('candidate_from')
                    <a style="color: red">
                      <small>
                        {{ $message }}
                      </small>
                    </a>
                  @enderror
                </div>
                {{-- <div class="row">
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
                </div> --}}
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

                <div class="col-12 d-flex justify-content-end mt-4">
                  <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                  <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                </div>

              </div>
            </div>
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
@endsection
