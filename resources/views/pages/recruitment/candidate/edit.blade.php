@extends('layouts.app')
@section('title', 'Pelamar')
@section('content')

@section('breadcrumb')
  <x-breadcrumb title="Edit Data Diri Pelamar" page="Recruitment" active="Pelamar" route="{{ route('candidate.index') }}" />
@endsection

<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />

<section class="section">
  <form id="updateForm" action="{{ route('candidate.update', $candidate) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')
    <div class="row justify-content-center">

      <div class="col-12 col-lg-4">
        <div class="card-body mb-2">
          <div class="d-flex justify-content-center align-items-center flex-column">

            <!-- Image Preview -->
            <img src="{{ asset($candidate->photo ? 'storage/' . $candidate->photo : 'storage/img/2.jpg') }}"
              alt="user-avatar" class="d-block rounded" width="150px" data-fancybox id="uploadedAvatar"
              style="cursor: pointer" />

            <!-- Upload Icon and Input -->
            <label for="photo" class="mt-2" style="text-align: center; display: block; width: 100%;">
              <span>{{ $candidate->name }}</span>
            </label>
            @can('candidate.update')
              <label for="uploadImage" class="mt-2 btn btn-sm btn-primary" style="cursor: pointer;">
                <span> Upload</span>
                <input type="file" id="uploadImage" value="{{ old('photo') }}" name="photo"
                  accept=".jpg, .jpeg, .png" style="display: none;" onchange="previewImage(event)" />
              </label>
            @endcan
          </div>

          <div class="card mt-3">
            <div class="card-content">
              <div class="card-body">

                <div class="form-group">
                  <label for="date_applied">Tanggal Lamaran Diterima <code>*</code></label>
                  <input type="date" id="date_applied" value="{{ old('date_applied', $candidate->date_applied) }}"
                    class="form-control @error('date_applied') is-invalid @enderror" name="date_applied">
                  @error('date_applied')
                    <a style="color: red">
                      <small>
                        {{ $message }}
                      </small>
                    </a>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="file_cv" class="form-label">CV <code>*</code></label> <br>
                  @can('candidate.update')
                    <input class="form-control form-control-sm mb-1 @error('file_cv') is-invalid @enderror" accept=".pdf"
                      type="file" id="file_cv" name="file_cv">
                  @endcan
                  @if ($candidate->file_cv)
                    <a href="{{ asset('storage/' . $candidate->file_cv) }}" target="_blank"
                      class="text-sm btn btn-sm btn-primary">
                      {{-- {{ pathinfo($candidate->file_cv, PATHINFO_FILENAME) }} --}}
                      Lihat CV
                    </a>
                  @else
                    <span>-</span>
                  @endif

                  @error('file_cv')
                    <a style="color: red">
                      <small>
                        {{ $message }}
                      </small>
                    </a>
                  @enderror
                </div>
                <div class="mb-3">
                  <label for="file_ktp" class="form-label">KTP & NPWP</label><br>
                  @can('candidate.update')
                    <input class="form-control form-control-sm mb-1" accept=".pdf" type="file" id="file_ktp"
                      name="file_ktp">
                  @endcan
                  @if ($candidate->file_ktp)
                    <a href="{{ asset('storage/' . $candidate->file_ktp) }}" target="_blank"
                      class="text-sm btn btn-sm btn-primary">
                      Lihat KTP & NPWP
                    </a>
                  @else
                    <span>-</span>
                  @endif
                </div>
                <div class="mb-3">
                  <label for="file_ijazah" class="form-label">IJAZAH & TRANSKRIP NILAI</label><br>
                  @can('candidate.update')
                    <input class="form-control form-control-sm mb-1" accept=".pdf" type="file" id="file_ijazah"
                      name="file_ijazah">
                  @endcan
                  @if ($candidate->file_ijazah)
                    <a href="{{ asset('storage/' . $candidate->file_ijazah) }}" target="_blank"
                      class="text-sm btn btn-sm btn-primary">
                      Lihat Ijazah & Transkrip Nilai
                    </a>
                  @else
                    <span>-</span>
                  @endif
                </div>
                <div class="mb-3">
                  <label for="file_skck" class="form-label">SKCK AKTIF</label><br>
                  @can('candidate.update')
                    <input class="form-control form-control-sm mb-1" accept=".pdf" type="file" id="file_skck"
                      name="file_skck">
                  @endcan
                  @if ($candidate->file_skck)
                    <a href="{{ asset('storage/' . $candidate->file_skck) }}" target="_blank"
                      class="text-sm btn btn-sm btn-primary">
                      Lihat SKCK
                    </a>
                  @else
                    <span>-</span>
                  @endif
                </div>
                <div class="mb-3">
                  <label for="file_kk" class="form-label">KARTU KELUARGA</label><br>
                  @can('candidate.update')
                    <input class="form-control form-control-sm mb-1" accept=".pdf" type="file" id="file_kk"
                      name="file_kk">
                  @endcan
                  @if ($candidate->file_kk)
                    <a href="{{ asset('storage/' . $candidate->file_kk) }}" target="_blank"
                      class="text-sm btn btn-sm btn-primary">
                      Lihat KK
                    </a>
                  @else
                    <span>-</span>
                  @endif
                </div>
                <div class="mb-3">
                  <label for="file_surat_sehat" class="form-label">SURAT KETERANGAN SEHAT <br>/ BEBAS
                    NARKOBA</label><br>
                  @can('candidate.update')
                    <input class="form-control form-control-sm mb-1" accept=".pdf" type="file"
                      id="file_surat_sehat" name="file_surat_sehat">
                  @endcan
                  @if ($candidate->file_surat_sehat)
                    <a href="{{ asset('storage/' . $candidate->file_surat_sehat) }}" target="_blank"
                      class="text-sm btn btn-sm btn-primary">
                      Lihat Surat <i class="mdi mdi-car-seat-heater:"></i>
                    </a>
                  @else
                    <span>-</span>
                  @endif
                </div>
                <div class="mb-3">
                  <label for="file_vaksin" class="form-label">SERTIFIKAT VAKSIN</label><br>
                  @can('candidate.update')
                    <input class="form-control form-control-sm mb-1" accept=".pdf" type="file" id="file_vaksin"
                      name="file_vaksin">
                  @endcan
                  @if ($candidate->file_vaksin)
                    <a href="{{ asset('storage/' . $candidate->file_vaksin) }}" target="_blank"
                      class="text-sm btn btn-sm btn-primary">
                      Lihat Vaksin
                    </a>
                  @else
                    <span>-</span>
                  @endif
                </div>
                <div class="mb-3">
                  <label for="file_sertifikat" class="form-label">SERTIFIKAT PELATIHAN</label><br>
                  @can('candidate.update')
                    <input class="form-control form-control-sm mb-1" accept=".pdf" type="file"
                      id="file_sertifikat" name="file_sertifikat">
                  @endcan
                  @if ($candidate->file_sertifikat)
                    <a href="{{ asset('storage/' . $candidate->file_sertifikat) }}" target="_blank"
                      class="text-sm btn btn-sm btn-primary">
                      Lihat Sertifikat
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

      <div class="col-12 col-lg-8">
        <div class="card">
          <div class="card-body">
            <div class="row">

              <div class="col-md-6 col-12">

                <div class="form-group">
                  <label for="name">Nama Lengkap <code>*</code></label>
                  <input type="text" id="name" value="{{ old('name', $candidate->name) }}"
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
                  <input type="email" id="email" value="{{ old('email', $candidate->email) }}"
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
                  <label for="phone_number">No. Telp <code>*</code></label>
                  <input type="text" id="phone_number"
                    value="{{ old('phone_number', $candidate->phone_number) }}"
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
                  <input type="text" id="paspor_number" maxlength="9"
                    value="{{ old('paspor_number', $candidate->paspor_number) }}" maxlength="16"
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
                  <input type="text" id="ktp_number" value="{{ old('ktp_number', $candidate->ktp_number) }}"
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
                  <input type="text" id="kk_number" value="{{ old('kk_number', $candidate->kk_number) }}"
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
                  <label for="nationality">Kewarganegaraan</label>
                  <input type="text" value="{{ old('nationality', $candidate->nationality) }}" id="nationality"
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
                  <label for="applied_position">Jabatan Yang Dilamar</label>
                  <input type="text" value="{{ old('applied_position', $candidate->applied_position) }}"
                    id="applied_position" class="form-control @error('applied_position') is-invalid @enderror"
                    name="applied_position">
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
                  <input type="text" value="{{ old('recommended_position', $candidate->recommended_position) }}"
                    id="recommended_position"
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
                  <label for="glasses">Kacamata</label>
                  <select type="text" id="glasses" class="form-control @error('glasses') is-invalid @enderror"
                    name="glasses">
                    {{-- <option value="" disabled selected>Choose</option> --}}
                    <option value="0" {{ old('glasses', $candidate->glasses) == '0' ? 'selected' : '' }}>Tidak
                    </option>
                    <option value="1" {{ old('glasses', $candidate->glasses) == '1' ? 'selected' : '' }}>Iya
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

                {{-- <div class="form-group">
                  <label for="candidate_from">Pelamar Dari</label>
                  <select type="text" value="{{ old('candidate_from') }}" id="candidate_from"
                    class="form-control @error('candidate_from') is-invalid @enderror" name="candidate_from">
                    <option value="" disabled>Choose</option>
                    <option value="MANAJEMEN" {{ $candidate->candidate_from == 'MANAJEMEN' ? 'selected' : '' }}>
                      Manajemen
                    </option>
                    <option value="UMUM"{{ $candidate->candidate_from == 'UMUM' ? 'selected' : '' }}>Umum</option>
                  </select>
                  @error('candidate_from')
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
                  <label for="pob">Tempat Lahir <code>*</code></label>
                  <input type="text" id="pob" value="{{ old('pob', $candidate->pob) }}"
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
                  <input type="date" id="dob" name="dob" value="{{ old('dob', $candidate->dob) }}"
                    class="form-control @error('dob') is-invalid @enderror" placeholder="Select date..">
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
                        {{ old('gender', $candidate->gender) == 'LAKI-LAKI' ? 'selected' : '' }}>
                        Laki-laki
                      </option>
                      <option value="PEREMPUAN"
                        {{ old('gender', $candidate->gender) == 'PEREMPUAN' ? 'selected' : '' }}>
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
                    <select id="blood_type" class="form-control @error('blood_type') is-invalid @enderror"
                      name="blood_type">
                      <option value="" disabled selected>Choose</option>
                      <option value="A" {{ $candidate->blood_type == 'A' ? 'selected' : '' }}>A</option>
                      <option value="A-" {{ $candidate->blood_type == 'A-' ? 'selected' : '' }}>A-</option>
                      <option value="A+" {{ $candidate->blood_type == 'A+' ? 'selected' : '' }}>A+</option>
                      <option value="B" {{ $candidate->blood_type == 'B' ? 'selected' : '' }}>B</option>
                      <option value="B-" {{ $candidate->blood_type == 'B-' ? 'selected' : '' }}>B-</option>
                      <option value="B+" {{ $candidate->blood_type == 'B+' ? 'selected' : '' }}>B+</option>
                      <option value="AB" {{ $candidate->blood_type == 'AB' ? 'selected' : '' }}>AB</option>
                      <option value="AB-" {{ $candidate->blood_type == 'AB-' ? 'selected' : '' }}>AB-</option>
                      <option value="AB+" {{ $candidate->blood_type == 'AB+' ? 'selected' : '' }}>AB+</option>
                      <option value="O" {{ $candidate->blood_type == 'O' ? 'selected' : '' }}>O</option>
                      <option value="O-" {{ $candidate->blood_type == 'O-' ? 'selected' : '' }}>O-</option>
                      <option value="O+" {{ $candidate->blood_type == 'O+' ? 'selected' : '' }}>O+</option>
                    </select>
                    @error('blood_type')
                      <small class="text-danger">
                        {{ $message }}
                      </small>
                    @enderror
                  </div>
                </div>

                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="height">Tinggi (cm)</label>
                    <input type="text" value="{{ old('height', $candidate->height) }}" id="height"
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
                    <input type="text" value="{{ old('weight', $candidate->weight) }}" id="weight"
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
                  <select id="marital_status" name="marital_status"
                    class="form-control @error('marital_status') is-invalid @enderror">
                    <option value="" disabled selected>Choose</option>
                    <option value="Kawin"
                      {{ old('marital_status', $candidate->marital_status) == 'Kawin' ? 'selected' : '' }}>
                      Kawin
                    </option>
                    <option value="Belum Kawin"
                      {{ old('marital_status', $candidate->marital_status) == 'Belum Kawin' ? 'selected' : '' }}>
                      Belum Kawin
                    </option>
                    <option value="Cerai Hidup"
                      {{ old('marital_status', $candidate->marital_status) == 'Cerai Hidup' ? 'selected' : '' }}>
                      Cerai Hidup
                    </option>
                    <option value="Cerai Mati"
                      {{ old('marital_status', $candidate->marital_status) == 'Cerai Mati' ? 'selected' : '' }}>
                      Cerai Mati
                    </option>
                  </select>
                  @error('marital_status')
                    <span class="text-danger">
                      <small>{{ $message }}</small>
                    </span>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="religion">Agama</label>
                  <select id="religion" name="religion"
                    class="form-control @error('religion') is-invalid @enderror">
                    <option value="" disabled selected>Choose</option>
                    <option value="Islam" {{ old('religion', $candidate->religion) == 'Islam' ? 'selected' : '' }}>
                      Islam</option>
                    <option value="Kristen"
                      {{ old('religion', $candidate->religion) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                    <option value="Katolik"
                      {{ old('religion', $candidate->religion) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                    <option value="Hindu" {{ old('religion', $candidate->religion) == 'Hindu' ? 'selected' : '' }}>
                      Hindu</option>
                    <option value="Buddha" {{ old('religion', $candidate->religion) == 'Buddha' ? 'selected' : '' }}>
                      Buddha</option>
                    <option value="Konghucu"
                      {{ old('religion', $candidate->religion) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                    <option value="Dan Lain-lain"
                      {{ old('religion', $candidate->religion) == 'Dan Lain-lain' ? 'selected' : '' }}>
                      Dan Lain-lain
                    </option>
                  </select>
                  @error('religion')
                    <span class="text-danger">
                      <small>{{ $message }}</small>
                    </span>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="last_educational">Pendidikan Terakhir <code>*</code></label>
                  <select type="text" id="last_educational" name="last_educational"
                    class="form-control @error('last_educational') is-invalid @enderror">
                    <option value="" disabled selected>Choose</option>
                    <option value="S-3"
                      {{ old('last_educational', $candidate->last_educational) == 'S-3' ? 'selected' : '' }}> S-3
                    </option>
                    <option value="S-2"
                      {{ old('last_educational', $candidate->last_educational) == 'S-2' ? 'selected' : '' }}> S-2
                    </option>
                    <option value="S-1"
                      {{ old('last_educational', $candidate->last_educational) == 'S-1' ? 'selected' : '' }}> S-1
                    </option>
                    <option value="D-4"
                      {{ old('last_educational', $candidate->last_educational) == 'D-4' ? 'selected' : '' }}> D-4
                    </option>
                    <option value="D-3"
                      {{ old('last_educational', $candidate->last_educational) == 'D-3' ? 'selected' : '' }}> D-3
                    </option>
                    <option value="D-2"
                      {{ old('last_educational', $candidate->last_educational) == 'D-2' ? 'selected' : '' }}> D-2
                    </option>
                    <option value="D-1"
                      {{ old('last_educational', $candidate->last_educational) == 'D-1' ? 'selected' : '' }}> D-1
                    </option>
                    {{-- <option value="MA"
                      {{ old('last_educational', $candidate->last_educational) == 'MA' ? 'selected' : '' }}> MA
                    </option>
                    <option value="SMK"
                      {{ old('last_educational', $candidate->last_educational) == 'SMK' ? 'selected' : '' }}> SMK
                    </option>
                    <option value="MTS"
                      {{ old('last_educational', $candidate->last_educational) == 'MTS' ? 'selected' : '' }}> MTS
                    </option> --}}
                    <option value="SMA"
                      {{ old('last_educational', $candidate->last_educational) == 'SMA' ? 'selected' : '' }}> SMA
                    </option>
                    <option value="SMP"
                      {{ old('last_educational', $candidate->last_educational) == 'SMP' ? 'selected' : '' }}> SMP
                    </option>
                    <option value="SD"
                      {{ old('last_educational', $candidate->last_educational) == 'SD' ? 'selected' : '' }}> SD
                    </option>
                  </select>
                  @error('last_educational')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="study">Jurusan <code>*</code></label>
                  <input type="text" value="{{ old('study', $candidate->study) }}" id="study"
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
                  <input type="text" value="{{ old('ethnic', $candidate->ethnic) }}" id="ethnic"
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
                      {{ old('disability', $candidate->disability) == 'Tunanetra' ? 'selected' : '' }}>
                      Tunanetra (Tidak bisa melihat / buta)
                    </option>
                    <option value="Tunarungu"
                      {{ old('disability', $candidate->disability) == 'Tunarungu' ? 'selected' : '' }}>
                      Tunarungu (Tidak bisa mendengar / tuli)
                    </option>
                    <option value="Tunawicara"
                      {{ old('disability', $candidate->disability) == 'Tunawicara' ? 'selected' : '' }}>
                      Tunawicara (Tidak bisa berbicara / bisu)
                    </option>
                    <option value="Tunadaksa"
                      {{ old('disability', $candidate->disability) == 'Tunadaksa' ? 'selected' : '' }}>
                      Tunadaksa (Cacat tubuh)
                    </option>
                    {{-- <option value="Tunalaras"
                      {{ old('disability', $candidate->disability) == 'Tunalaras' ? 'selected' : '' }}>
                      Tunalaras (Cacat suara dan nada)
                    </option> --}}
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
                    rows="5"> {{ old('tag', $candidate->tag) }}</textarea>
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
                    <label for="candidate_from">Pelamar Dari <code>*</code></label>
                    <select type="text" value="{{ old('candidate_from') }}" id="candidate_from"
                      class="form-control @error('candidate_from') is-invalid @enderror" name="candidate_from">
                      <option value="" disabled>Choose</option>
                      <option value="MANAJEMEN" {{ $candidate->candidate_from == 'MANAJEMEN' ? 'selected' : '' }}>
                        Manajemen
                      </option>
                      <option value="UMUM"{{ $candidate->candidate_from == 'UMUM' ? 'selected' : '' }}>Umum
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
                    name="reference" rows="5"> {{ old('reference', $candidate->reference) }}</textarea>
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
                    name="ktp_address" rows="5"> {{ old('ktp_address', $candidate->ktp_address) }}</textarea>
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
                    value="{{ old('zipcode_ktp', $candidate->zipcode_ktp) }}"
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
                    <input type="text" id="latitude_ktp" value="{{ $candidate->latitude_ktp }}"
                      name="latitude_ktp" class="form-control" readonly>
                  </div>
                  <div class="form-group col-md-5">
                    <label for="longitude_ktp">Longitude Alamat KTP</label>
                    <input type="text" id="longitude_ktp" value="{{ $candidate->latitude_ktp }}"
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
                    name="current_address" rows="5"> {{ old('current_address', $candidate->current_address) }}</textarea>
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
                    <input type="text" id="latitude_domisili" value="{{ $candidate->latitude_domisili }}"
                      name="latitude_domisili" class="form-control" readonly>
                  </div>
                  <div class="form-group col-md-5">
                    <label for="longitude_domisili">Longitude Alamat Domisili</label>
                    <input type="text" id="longitude_domisili" value="{{ $candidate->longitude_domisili }}"
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

              <div class="col-12">

                <div class="row">
                  <div class="form-group col-md-5">
                    <label for="sim_a">SIM A</label>
                    <input type="text" value="{{ old('sim_a', $candidate->sim_a) }}"
                      oninput="this.value = this.value.replace(/\D+/g, '')" id="sim_a" name="sim_a"
                      class="form-control">
                  </div>
                  <div class="form-group col-md-3">
                    <label for="expired_sim_a">Masa Berlaku</label>
                    <input type="date" value="{{ old('expired_sim_a', $candidate->expired_sim_a) }}"
                      id="expired_sim_a" name="expired_sim_a" class="form-control">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="file_sim_a">File</label>
                    <input class="form-control" accept=".jpg, .png, .pdf, .jpeg" type="file" name="file_sim_a"
                      id="file_sim_a">
                    @if ($candidate->file_sim_a)
                      <a href="{{ asset('storage/' . $candidate->file_sim_a) }}" target="_blank"
                        class="text-sm btn btn-sm btn-primary mt-2">
                        Lihat SIM A
                      </a>
                    @endif
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
                    <input type="text" value="{{ old('sim_b', $candidate->sim_b) }}"
                      oninput="this.value = this.value.replace(/\D+/g, '')" id="sim_b" name="sim_b"
                      class="form-control">
                  </div>
                  <div class="form-group col-md-3">
                    <label for="expired_sim_b">Masa Berlaku</label>
                    <input type="date" value="{{ old('expired_sim_b', $candidate->expired_sim_b) }}"
                      id="expired_sim_b" name="expired_sim_b" class="form-control">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="file_sim_b">File</label>
                    <input class="form-control" accept=".jpg, .png, .pdf, .jpeg" type="file" name="file_sim_b"
                      id="file_sim_b">
                    @if ($candidate->file_sim_b)
                      <a href="{{ asset('storage/' . $candidate->file_sim_b) }}" target="_blank"
                        class="text-sm btn btn-sm btn-primary mt-2">
                        Lihat SIM B
                      </a>
                    @endif
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
                    <input type="text" value="{{ old('sim_c', $candidate->sim_c) }}"
                      oninput="this.value = this.value.replace(/\D+/g, '')" id="sim_c" name="sim_c"
                      class="form-control">
                  </div>
                  <div class="form-group col-md-3">
                    <label for="expired_sim_c">Masa Berlaku</label>
                    <input type="date" value="{{ old('expired_sim_c', $candidate->expired_sim_c) }}"
                      id="expired_sim_c" name="expired_sim_c" class="form-control">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="file_sim_c">File</label>
                    <input class="form-control" accept=".jpg, .png, .pdf, .jpeg" type="file" name="file_sim_c"
                      id="file_sim_c">
                    @if ($candidate->file_sim_c)
                      <a href="{{ asset('storage/' . $candidate->file_sim_c) }}" target="_blank"
                        class="text-sm btn btn-sm btn-primary mt-2">
                        Lihat SIM C
                      </a>
                    @endif
                    @error('file_sim_c')
                      <a style="color: red">
                        <small>
                          {{ $message }}
                        </small>
                      </a>
                    @enderror
                  </div>
                </div>

                <div class="row">
                  <div class="form-group">
                    <label for="note">Catatan</label>
                    <textarea type="text" id="note" class="form-control  @error('note') is-invalid @enderror" name="note"
                      rows="5">{{ old('note', $candidate->note) }}</textarea>
                    @error('note')
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
                @can('candidate.update')
                  <button type="button" id="submitBtn" class="btn btn-primary me-1 mb-1">Submit</button>
                @endcan
                <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Map Modal -->
      <!-- Modal for KTP Map -->
      <div class="modal fade" id="mapModalKTP" tabindex="-1" aria-labelledby="mapModalKTPLabel"
        aria-hidden="true">
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

  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="d-flex justify-content-between align-items-center ">
            <h4 class="card-title">Riwayat Pekerjaan</h4>


            <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
              data-bs-target="#modal-form-add-job-history">
              <i class="bi bi-plus-lg"></i>
              Add
            </button>
            {{-- @include('pages.candidate.personal-data.form.job-history.modal-create') --}}

          </div>
          <!-- Table with outer spacing -->
          <div class="table-responsive">
            <table class="table" style="font-size: 80%;">
              <thead>
                <tr>
                  <th>Nama Perusahaan</th>
                  <th>Jabatan </th>
                  <th>Kota</th>
                  <th>Periode</th>
                  <th>Keterangan</th>
                  <th style="width: 13%"></th>
                </tr>
              </thead>
              <tbody>
                @forelse ($candidate->jobHistories as $candidateJobHistory)
                  <tr>
                    <td>{{ $candidateJobHistory->company_name }}</td>
                    <td class="text-bold-500">{{ $candidateJobHistory->position }}</td>
                    <td class="text-bold-500">{{ $candidateJobHistory->city }}</td>
                    <td class="text-bold-500">{{ $candidateJobHistory->period }}</td>
                    <td class="text-bold-500">{{ $candidateJobHistory->reason }}</td>
                    {{-- <td class="text-bold-500 text-center">
                      @if ($candidateJobHistory->file)
                        <a href="{{ asset('storage/' . $candidateJobHistory->file) }}" target="_blank"
                          class="text-sm">
                          Lihat
                        </a>
                      @else
                        <span>-</span>
                      @endif
                    </td> --}}
                    <td>
                      <div class="demo-inline-spacing">
                        <a data-bs-toggle="modal"
                          data-bs-target="#modal-form-edit-job-history-{{ $candidateJobHistory->id }}"
                          class="btn btn-icon btn-sm btn-secondary text-white">
                          <i class="bi bi-pencil-square"></i>
                        </a>
                        {{-- @include('pages.candidate.personal-data.form.job-history.modal-edit') --}}

                        <!-- Modals add menu -->
                        <div id="modal-form-edit-job-history-{{ $candidateJobHistory->id }}" class="modal fade"
                          tabindex="-1"
                          aria-labelledby="modal-form-edit-job-history-{{ $candidateJobHistory->id }}-label"
                          aria-hidden="true" style="display: none;">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                              <form action="{{ route('candidateJobHistory.update', $candidateJobHistory) }}"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="modal-header">
                                  <h5 class="modal-title"
                                    id="modal-form-edit-job-history-{{ $candidateJobHistory->id }}-label">
                                    Edit Data Pengalaman Kerja
                                  </h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"> </button>
                                </div>

                                <div class="card-body">
                                  <div class="row justify-content-center">
                                    <div class="col-md-12"> <!-- Make form smaller with col-md-6 and center it -->
                                      <input type="hidden" name="name" value="{{ $candidate->name }}">

                                      <div class="mb-2">
                                        <label class="form-label" for="company_name">Nama Perusahaan</label>
                                        <input id="company_name" value="{{ $candidateJobHistory->company_name }}"
                                          name="company_name"
                                          class="form-control @error('company_name') is-invalid @enderror" required>
                                        @error('company_name')
                                          <a style="color: red"><small>{{ $message }}</small></a>
                                        @enderror
                                      </div>

                                      <div class="mb-2">
                                        <label class="form-label" for="position">Posisi / Jabatan</label>
                                        <input id="position" value="{{ $candidateJobHistory->position }}"
                                          name="position"
                                          class="form-control @error('position') is-invalid @enderror" required>
                                        @error('position')
                                          <a style="color: red"><small>{{ $message }}</small></a>
                                        @enderror
                                      </div>

                                      <div class="mb-2">
                                        <label class="form-label" for="city">Kota</label>
                                        <input type="text" value="{{ $candidateJobHistory->city }}"
                                          id="city" name="city"
                                          class="form-control @error('city') is-invalid @enderror" required />
                                        @error('city')
                                          <a style="color: red"><small>{{ $message }}</small></a>
                                        @enderror
                                      </div>

                                      <div class=" mb-2">
                                        <label for="period">Periode</label>
                                        <input type="text" value="{{ $candidateJobHistory->period }}"
                                          oninput="this.value = this.value.replace(/\D+/g, '')" maxlength="4"
                                          id="year" name="period" value="{{ old('period') }}"
                                          class="form-control  @error('period') is-invalid @enderror" />
                                        @error('period')
                                          <a style="color: red"><small>{{ $message }}</small></a>
                                        @enderror
                                      </div>

                                      {{-- <div class="mb-2">
                                        <label for="salary">Gaji Terakhir</label>
                                        <div class="input-group mb-3">
                                          <span class="input-group-text" id="salary">Rp. </span>
                                          <input type="text" id="salary"
                                            value="{{ old('salary', $candidateJobHistory->salary) }}"
                                            oninput="this.value = this.value.replace(/\D+/g, '')"
                                            class="form-control @error('salary') is-invalid @enderror"
                                            name="salary">
                                        </div>
                                        @error('salary')
                                          <a style="color: red"><small>{{ $message }}</small></a>
                                        @enderror
                                      </div> --}}

                                      <div class="mb-2">
                                        <label class="form-label" for="reason">Keterangan Tambahan</label>
                                        <textarea id="reason" name="reason" class="form-control @error('reason') is-invalid @enderror" rows="2"
                                          required>{{ $candidateJobHistory->reason }}</textarea>
                                        @error('reason')
                                          <a style="color: red"><small>{{ $message }}</small></a>
                                        @enderror
                                      </div>

                                      {{-- <div class="mb-2">
                                        <label for="file" class="form-label">File</label>
                                        <input class="form-control" accept=".pdf" type="file" id="file"
                                          name="file">

                                        <div class="text-center my-3" style="height: 30px;">
                                          <a href="{{ Storage::url($candidateJobHistory->file) }}" target="_blank">
                                            {{ pathinfo($candidateJobHistory->file, PATHINFO_FILENAME) }}
                                          </a>
                                        </div>
                                      </div> --}}

                                    </div>
                                  </div>
                                </div>

                                <div class="modal-footer">
                                  <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-primary ">Save</button>
                                </div>
                              </form>

                            </div><!-- /.modal-content -->
                          </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->


                        <a class="btn btn-sm btn-light-danger mx-2"
                          onclick="deleteJobHistory('{{ $candidateJobHistory->id }}')"><i
                            class="bi bi-trash"></i></a>

                        <form id="deleteJobHistoryForm_{{ $candidateJobHistory->id }}"
                          action="{{ route('candidateJobHistory.destroy', $candidateJobHistory) }}" method="POST">
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
        </div>
      </div>
    </div>
  </div>

  <div id="modal-form-add-job-history" class="modal fade" tabindex="-1"
    aria-labelledby="modal-form-add-job-history-label" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form action="{{ route('candidateJobHistory.store') }}" method="post" enctype="multipart/form-data">
          @csrf

          <div class="modal-header">
            <h5 class="modal-title" id="modal-form-add-job-history-label">Tambah Data Pengalaman Kerja</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
          </div>

          <div class="card-body">
            <div class="row justify-content-center">
              <div class="col-md-11"> <!-- Make form smaller with col-md-6 and center it -->
                <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">
                <input type="hidden" name="name" value="{{ $candidate->name }}">

                <div class="mb-2">
                  <label class="form-label" for="company_name">Nama Perusahaan <code>*</code></label>
                  <input id="company_name" name="company_name"
                    class="form-control @error('company_name') is-invalid @enderror" required>
                  @error('company_name')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>

                <div class="mb-2">
                  <label class="form-label" for="position">Posisi / Jabatan <code>*</code></label>
                  <input id="position" name="position" class="form-control @error('position') is-invalid @enderror"
                    required>
                  @error('position')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>



                {{-- <div class="mb-2">
                <label class="form-label" for="company_type">Jenis Perusahaan</label>
                <input type="text" id="company_type" name="company_type"
                  class="form-control @error('company_type') is-invalid @enderror" required />
                @error('company_type')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div> --}}

                <div class="mb-2">
                  <label class="form-label" for="city">Kota</label>
                  <input type="text" id="city" name="city"
                    class="form-control @error('city') is-invalid @enderror" />
                  @error('city')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>

                <div class="mb-2">
                  <label for="period">Periode <code>*</code></label>

                  <input type="text" id="period" name="period"
                    class="form-control @error('period') is-invalid @enderror" required />
                  {{-- <input type="text" oninput="this.value = this.value.replace(/\D+/g, '')" maxlength="4"
                    id="year" name="period" value="{{ old('period') }}"
                    class="form-control  @error('period') is-invalid @enderror" required /> --}}
                  @error('period')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>

                {{-- <div class="mb-2">
                <label class="form-label" for="year_out">Tahun Keluar</label>
                <input type="text" id="year_out" name="year_out"
                  class="form-control @error('year_out') is-invalid @enderror" />
                <input type="text" oninput="this.value = this.value.replace(/\D+/g, '')" maxlength="4"
                    id="year_out" name="year_out" value="{{ old('year_out') }}"
                    class="form-control  @error('year_out') is-invalid @enderror" />
                @error('year_out')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div> --}}




                {{-- <div class="mb-2">
                  <label for="salary">Gaji Terakhir</label>
                  <div class="input-group mb-3">
                    <span class="input-group-text" id="salary">Rp. </span>
                    <input type="text" id="salary" value="{{ old('salary') }}"
                      oninput="this.value = this.value.replace(/\D+/g, '')"
                      class="form-control @error('salary') is-invalid @enderror" name="salary">
                  </div>
                  @error('salary')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div> --}}

                <div class="mb-2">
                  <label class="form-label" for="reason">Keterangan Tambahan</label>
                  <textarea id="reason" name="reason" class="form-control @error('reason') is-invalid @enderror" rows="2"></textarea>
                  @error('reason')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>

                {{-- <div class="mb-2">
                  <label for="file" class="form-label">File</label>
                  <input class="form-control" accept=".pdf" type="file" id="file" name="file">
                </div> --}}
                {{-- <div class="mb-2">
                <label class="form-label" for="job_description">Deskripsi Pekerjaan / Tanggung Jawab</label>
                <textarea id="job_description" name="job_description"
                  class="form-control @error('job_description') is-invalid @enderror" rows="3" required></textarea>
                @error('job_description')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div> --}}
              </div>
            </div>
          </div>


          <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary ">Save</button>
          </div>
        </form>

      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->


</section>

<script>
  function deleteJobHistory(getId) {
    Swal.fire({
      title: 'Are you sure?',
      text: 'You won\'t be able to revert this!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        // If the user clicks "Yes, delete it!", submit the corresponding form
        document.getElementById('deleteJobHistoryForm_' + getId).submit();
      }
    });
  }
</script>


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
        mapDomisili = L.map('mapDomisili').setView([
            {{ $candidate->latitude_domisili ?? -6.1580339989448305 }},
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


@endsection
