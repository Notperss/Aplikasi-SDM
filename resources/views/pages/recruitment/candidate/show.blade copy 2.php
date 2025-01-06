@extends('layouts.auth')
@section('title', 'Candidate')
@section('content')

<nav class="navbar navbar-light">
  <div class="container d-block">
    <a href="{{ route('candidate.index') }}"><i class="bi bi-chevron-left"></i></a>
    <a class="btn btn-primary ms-4" href="{{ route('candidate.index') }}">
      Back
    </a>
  </div>
</nav>


<section class="section">
  <div class="row mx-3">
    <div class="col-3">
      <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <a class="nav-link active" id="v-pills-informasi-dasar-tab" data-bs-toggle="pill"
          href="#v-pills-informasi-dasar" role="tab" aria-controls="v-pills-informasi-dasar"
          aria-selected="true">informasi-dasar</a>
        <a class="nav-link" id="v-pills-data-keluarga-tab" data-bs-toggle="pill" href="#v-pills-data-keluarga"
          role="tab" aria-controls="v-pills-data-keluarga" aria-selected="false">data-keluarga</a>
        <a class="nav-link" id="v-pills-riwayat-pekerjaan-tab" data-bs-toggle="pill" href="#v-pills-riwayat-pekerjaan"
          role="tab" aria-controls="v-pills-riwayat-pekerjaan" aria-selected="false">riwayat-pekerjaan</a>
        <a class="nav-link" id="v-pills-riwayat-pendidikan-tab" data-bs-toggle="pill" href="#v-pills-riwayat-pendidikan"
          role="tab" aria-controls="v-pills-riwayat-pendidikan" aria-selected="false">riwayat-pendidikan</a>
        <a class="nav-link" id="v-pills-kemampuan-bahasa-tab" data-bs-toggle="pill" href="#v-pills-kemampuan-bahasa"
          role="tab" aria-controls="v-pills-kemampuan-bahasa" aria-selected="false">kemampuan-bahasa</a>
        <a class="nav-link" id="v-pills-seminar-tab" data-bs-toggle="pill" href="#v-pills-seminar" role="tab"
          aria-controls="v-pills-seminar" aria-selected="false">seminar</a>
        <a class="nav-link" id="v-pills-keterampilan-tab" data-bs-toggle="pill" href="#v-pills-keterampilan" role="tab"
          aria-controls="v-pills-keterampilan" aria-selected="false">keterampilan</a>
        <a class="nav-link" id="v-pills-sosial-media-tab" data-bs-toggle="pill" href="#v-pills-sosial-media" role="tab"
          aria-controls="v-pills-sosial-media" aria-selected="false">sosial-media</a>
      </div>
    </div>
    <div class="col-9">
      <div class="tab-content" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ut nulla neque.
          Ut hendrerit nulla a euismod pretium.
          Fusce venenatis sagittis ex efficitur suscipit. In tempor mattis fringilla. Sed
          id tincidunt orci, et volutpat ligula.
          Aliquam sollicitudin sagittis ex, a rhoncus nisl feugiat quis. Lorem ipsum dolor
          sit amet, consectetur adipiscing elit.
          Nunc ultricies ligula a tempor vulputate. Suspendisse pretium mollis ultrices.
        </div>
        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
          Integer interdum diam eleifend metus lacinia, quis gravida eros mollis. Fusce
          non sapien sit amet magna dapibus
          ultrices. Morbi tincidunt magna ex, eget faucibus sapien bibendum non. Duis a
          mauris ex. Ut finibus risus sed massa
          mattis porta. Aliquam sagittis massa et purus efficitur ultricies.
        </div>
        <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
          Integer pretium dolor at sapien laoreet ultricies. Fusce congue et lorem id
          convallis. Nulla volutpat tellus nec
          molestie finibus. In nec odio tincidunt eros finibus ullamcorper. Ut sodales,
          dui nec posuere finibus, nisl sem aliquam
          metus, eu accumsan lacus felis at odio.
        </div>
        <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
          Sed lacus quam, convallis quis condimentum ut, accumsan congue massa.
          Pellentesque et quam vel massa pretium ullamcorper
          vitae eu tortor.
        </div>
      </div>
    </div>
  </div>













  <form id="updateForm" action="{{ route('candidate.update', $candidate) }}" method="post"
    enctype="multipart/form-data">
    @csrf
    @method('put')
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
            @can('candidate.update')
            <label for="uploadImage" class="mt-2 btn btn-sm btn-primary" style="cursor: pointer;">
              <span> Upload</span>
              <input type="file" id="uploadImage" value="{{ old('photo') }}" name="photo" accept=".jpg, .jpeg, .png"
                style="display: none;" onchange="previewImage(event)" />
            </label>
            @endcan
          </div>

          <div class="card mt-3">
            <div class="card-content">
              <div class="card-body">

                <div class="mb-3">
                  <label for="file_cv" class="form-label">CV</label> <br>
                  @can('candidate.update')
                  <input class="form-control form-control-sm mb-1" accept=".pdf" type="file" id="file_cv"
                    name="file_cv">
                  @endcan
                  @if ($candidate->file_cv)
                  <a href="{{ Storage::url($candidate->file_cv) }}" target="_blank"
                    class="text-sm btn btn-sm btn-primary">
                    {{-- {{ pathinfo($candidate->file_cv, PATHINFO_FILENAME) }} --}}
                    Lihat CV
                  </a>
                  @else
                  <span>-</span>
                  @endif
                </div>
                <div class="mb-3">
                  <label for="file_ktp" class="form-label">KTP & NPWP</label><br>
                  @can('candidate.update')
                  <input class="form-control form-control-sm mb-1" accept=".pdf" type="file" id="file_ktp"
                    name="file_ktp">
                  @endcan
                  @if ($candidate->file_ktp)
                  <a href="{{ Storage::url($candidate->file_ktp) }}" target="_blank"
                    class="text-sm btn btn-sm btn-primary">
                    Lihat KTP & NPWP
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
                  <a href="{{ Storage::url($candidate->file_skck) }}" target="_blank"
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
                  <a href="{{ Storage::url($candidate->file_kk) }}" target="_blank"
                    class="text-sm btn btn-sm btn-primary">
                    Lihat KK
                  </a>
                  @else
                  <span>-</span>
                  @endif
                </div>
                <div class="mb-3">
                  <label for="file_surat_sehat" class="form-label">SURAT KETERANGAN SEHAT</label><br>
                  @can('candidate.update')
                  <input class="form-control form-control-sm mb-1" accept=".pdf" type="file" id="file_surat_sehat"
                    name="file_surat_sehat">
                  @endcan
                  @if ($candidate->file_surat_sehat)
                  <a href="{{ Storage::url($candidate->file_surat_sehat) }}" target="_blank"
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
                  <a href="{{ Storage::url($candidate->file_vaksin) }}" target="_blank"
                    class="text-sm btn btn-sm btn-primary">
                    Lihat Vaksin
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
                  <label for="phone_number">No. Telp</label>
                  <input type="text" id="phone_number" value="{{ old('phone_number', $candidate->phone_number) }}"
                    maxlength="13" oninput="this.value = this.value.replace(/\D+/g, '')"
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
                  <label for="ktp_number">No. KTP</label>
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
                  <input type="text" id="kk_number" value="{{ old('kk_number', $candidate->kk_number) }}" maxlength="16"
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
                    id="recommended_position" class="form-control @error('recommended_position') is-invalid @enderror"
                    name="recommended_position">
                  @error('recommended_position')
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
                  <label for="dob">Tanggal Lahir</label>
                  <input type="date" id="dob" name="dob" value="{{ old('dob', $candidate->dob) }}"
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
                    <select name="gender" id="gender" class="form-control  @error('gender') is-invalid @enderror">
                      <option value="" disabled selected>Choose</option>
                      <option value="LAKI-LAKI" {{ old('gender', $candidate->gender) == 'LAKI-LAKI' ? 'selected' : ''
                        }}>
                        Laki-laki
                      </option>
                      <option value="PEREMPUAN" {{ old('gender', $candidate->gender) == 'PEREMPUAN' ? 'selected' : ''
                        }}>
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
                      <option value="A-" {{ $candidate->blood_type == 'A-' ? 'selected' : '' }}>A-</option>
                      <option value="A+" {{ $candidate->blood_type == 'A+' ? 'selected' : '' }}>A+</option>
                      <option value="B-" {{ $candidate->blood_type == 'B-' ? 'selected' : '' }}>B-</option>
                      <option value="B+" {{ $candidate->blood_type == 'B+' ? 'selected' : '' }}>B+</option>
                      <option value="AB-" {{ $candidate->blood_type == 'AB-' ? 'selected' : '' }}>AB-</option>
                      <option value="AB+" {{ $candidate->blood_type == 'AB+' ? 'selected' : '' }}>AB+</option>
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
                <div class="form-group">
                  <label for="marital_status">Status Perkawinan</label>
                  <select id="marital_status" name="marital_status"
                    class="form-control @error('marital_status') is-invalid @enderror">
                    <option value="" disabled selected>Choose</option>
                    <option value="Kawin" {{ old('marital_status', $candidate->marital_status) == 'Kawin' ? 'selected' :
                      '' }}>
                      Kawin
                    </option>
                    <option value="Belum Kawin" {{ old('marital_status', $candidate->marital_status) == 'Belum Kawin' ?
                      'selected' : '' }}>
                      Belum Kawin
                    </option>
                    <option value="Cerai Hidup" {{ old('marital_status', $candidate->marital_status) == 'Cerai Hidup' ?
                      'selected' : '' }}>
                      Cerai Hidup
                    </option>
                    <option value="Cerai Mati" {{ old('marital_status', $candidate->marital_status) == 'Cerai Mati' ?
                      'selected' : '' }}>
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
                  <select id="religion" name="religion" class="form-control @error('religion') is-invalid @enderror">
                    <option value="" disabled selected>Choose</option>
                    <option value="Islam" {{ old('religion', $candidate->religion) == 'Islam' ? 'selected' : '' }}>
                      Islam</option>
                    <option value="Kristen" {{ old('religion', $candidate->religion) == 'Kristen' ? 'selected' : ''
                      }}>Kristen</option>
                    <option value="Katolik" {{ old('religion', $candidate->religion) == 'Katolik' ? 'selected' : ''
                      }}>Katolik</option>
                    <option value="Hindu" {{ old('religion', $candidate->religion) == 'Hindu' ? 'selected' : '' }}>
                      Hindu</option>
                    <option value="Buddha" {{ old('religion', $candidate->religion) == 'Buddha' ? 'selected' : '' }}>
                      Buddha</option>
                    <option value="Konghucu" {{ old('religion', $candidate->religion) == 'Konghucu' ? 'selected' : ''
                      }}>Konghucu</option>
                    <option value="Dan Lain-lain" {{ old('religion', $candidate->religion) == 'Dan Lain-lain' ?
                      'selected' : '' }}>
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
                  <label for="candidate_from">Pelamar Dari</label>
                  <select type="text" value="{{ old('candidate_from') }}" id="candidate_from"
                    class="form-control @error('candidate_from') is-invalid @enderror" name="candidate_from">
                    <option value="" disabled>Choose</option>
                    <option value="MANAJEMEN" {{ $candidate->candidate_from == 'MANAJEMEN' ? 'selected' : '' }}>
                      Manajemen
                    </option>
                    <option value="UMUM" {{ $candidate->candidate_from == 'UMUM' ? 'selected' : '' }}>Umum</option>
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
                  <textarea type="text" id="ktp_address"
                    class="form-control  @error('ktp_address') is-invalid @enderror" name="ktp_address"
                    rows="5"> {{ old('ktp_address', $candidate->ktp_address) }}</textarea>
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
                    <input type="text" id="latitude_ktp" value="{{ $candidate->latitude_ktp }}" name="latitude_ktp"
                      class="form-control" readonly>
                  </div>
                  <div class="form-group col-md-5">
                    <label for="longitude_ktp">Longitude Alamat KTP</label>
                    <input type="text" id="longitude_ktp" value="{{ $candidate->latitude_ktp }}" name="longitude_ktp"
                      class="form-control" readonly>
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
                  <textarea type="text" id="current_address"
                    class="form-control @error('current_address') is-invalid @enderror" name="current_address"
                    rows="5"> {{ old('current_address', $candidate->current_address) }}</textarea>
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

  <!-- data keluarga -->
  <div class="col-12 col-lg-10">
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
                    {{ Carbon\Carbon::parse($candidateFamilyDetail->dob)->translatedFormat('d F Y') }}
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
                        onclick="deleteFamilyDetail('{{ $candidateFamilyDetail->id }}')"><i class="bi bi-trash"></i></a>

                      <form id="deleteFamilyDetailForm_{{ $candidateFamilyDetail->id }}"
                        action="{{ route('candidateFamilyDetail.destroy', $candidateFamilyDetail->id) }}" method="POST">
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
                    {{ Carbon\Carbon::parse($candidateFamilyDetail->dob)->translatedFormat('d F Y') }}
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
                        onclick="deleteFamilyDetail('{{ $candidateFamilyDetail->id }}')"><i class="bi bi-trash"></i></a>

                      <form id="deleteFamilyDetailForm_{{ $candidateFamilyDetail->id }}"
                        action="{{ route('candidateFamilyDetail.destroy', $candidateFamilyDetail->id) }}" method="POST">
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

  <!-- pendidikan -->
  <div class="col-12 col-lg-10">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="d-flex justify-content-between align-items-center ">
            <h4 class="card-title">Riwayat Pendidikan</h4>
            @can('candidate.store')
            <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
              data-bs-target="#modal-form-add-educational-history">
              <i class="bi bi-plus-lg"></i>
              Add
            </button>
            @include('pages.recruitment.educational-history.modal-create')
            @endcan
          </div>
          <!-- Table with outer spacing -->
          <div class="table-responsive" style="font-size: 80%;">
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
                  <th></th>
                </tr>
              </thead>

              <tbody>
                @forelse ($candidate->educationalHistories as $candidateEducationalHistory)
                <tr>
                  <td class="text-bold-500">{{ $candidateEducationalHistory->school_level }}</td>
                  <td>{{ $candidateEducationalHistory->school_name }}</td>
                  <td class="text-bold-500">{{ $candidateEducationalHistory->study }}</td>
                  <td class="text-bold-500">{{ $candidateEducationalHistory->gpa }}</td>
                  <td style="text-align: center;">
                    <div style="display: flex; justify-content: space-between;">
                      <span>{{ $candidateEducationalHistory->year_from }}</span>
                      <span>-</span>
                      <span>{{ $candidateEducationalHistory->year_to }}</span>
                    </div>
                  </td>
                  <td class="text-bold-500">{{ $candidateEducationalHistory->graduate }}</td>
                  <td class="text-bold-500 text-center">
                    @if ($candidateEducationalHistory->file_ijazah)
                    <a href="{{ Storage::url($candidateEducationalHistory->file_ijazah) }}" target="_blank"
                      class="text-sm">
                      Lihat
                    </a>
                    @else
                    <span>-</span>
                    @endif
                  </td>
                  <td>
                    @can('candidate.update')
                    <div class="demo-inline-spacing">
                      <a data-bs-toggle="modal"
                        data-bs-target="#modal-form-edit-educational-history-{{ $candidateEducationalHistory->id }}"
                        class="btn btn-sm btn-icon btn-secondary text-white">
                        <i class="bi bi-pencil-square"></i>
                      </a>
                      @include('pages.recruitment.educational-history.modal-edit')

                      <a class="btn btn-sm btn-light-danger mx-2"
                        onclick="deleteEducational('{{ $candidateEducationalHistory->id }}')"><i
                          class="bi bi-trash"></i></a>

                      <form id="deleteEducationalForm_{{ $candidateEducationalHistory->id }}"
                        action="{{ route('candidateEducationalHistory.destroy', $candidateEducationalHistory) }}"
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
        </div>
      </div>
    </div>
  </div>

  <!-- pengalaman -->
  <div class="col-12 col-lg-10">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="d-flex justify-content-between align-items-center ">
            <h4 class="card-title">Data Pengalaman Kerja</h4>
            @can('candidate.store')
            <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
              data-bs-target="#modal-form-add-employment-history">
              <i class="bi bi-plus-lg"></i>
              Add
            </button>
            @include('pages.recruitment.employment-history.modal-create')
            @endcan
          </div>
          <!-- Table with outer spacing -->
          <div class="table-responsive">
            <table class="table" style="font-size: 80%;">
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
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @forelse ($candidate->employmentHistories as $candidateEmploymentHistory)
                <tr>
                  <td>{{ $candidateEmploymentHistory->company_name }}</td>
                  <td class="text-bold-500">{{ $candidateEmploymentHistory->position }}</td>
                  <td class="text-bold-500">{{ $candidateEmploymentHistory->city }}</td>
                  <td style="text-align: center;">
                    <div style="display: flex; justify-content: space-between;">
                      <span>{{ $candidateEmploymentHistory->year_from }}</span>
                      <span>-</span>
                      <span>{{ $candidateEmploymentHistory->year_to }}</span>
                    </div>
                  </td>
                  <td class="text-bold-500">Rp.
                    {{ number_format($candidateEmploymentHistory->salary, 0, ',', '.') }}
                  </td>
                  <td class="text-bold-500">{{ $candidateEmploymentHistory->reason }}</td>
                  <td class="text-bold-500 text-center">
                    @if ($candidateEmploymentHistory->file)
                    <a href="{{ Storage::url($candidateEmploymentHistory->file) }}" target="_blank" class="text-sm">
                      Lihat
                    </a>
                    @else
                    <span>-</span>
                    @endif
                  </td>
                  <td>
                    @can('candidate.update')
                    <div class="demo-inline-spacing">
                      <a data-bs-toggle="modal"
                        data-bs-target="#modal-form-edit-employment-history-{{ $candidateEmploymentHistory->id }}"
                        class="btn btn-icon btn-secondary text-white">
                        <i class="bi bi-pencil-square"></i>
                      </a>
                      @include('pages.recruitment.employment-history.modal-edit')

                      <a class="btn btn-light-danger mx-2"
                        onclick="deleteEmploymenHistory('{{ $candidateEmploymentHistory->id }}')"><i
                          class="bi bi-trash"></i></a>

                      <form id="deleteCandidateEmploymentHistoryForm_{{ $candidateEmploymentHistory->id }}"
                        action="{{ route('candidateEmploymentHistory.destroy', $candidateEmploymentHistory) }}"
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

  <!-- Bahasa Asing -->
  <div class="col-12 col-lg-10">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="d-flex justify-content-between align-items-center ">
            <h4 class="card-title">Kemampuan Bahasa Asing</h4>
            @can('candidate.store')
            <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
              data-bs-target="#modal-form-add-language-proficiency">
              <i class="bi bi-plus-lg"></i>
              Add
            </button>
            @include('pages.recruitment.language-proficiency.modal-create')
            @endcan
          </div>
          <!-- Table with outer spacing -->
          <div class="table-responsive">
            <table class="table" style="font-size: 80%">
              <thead>
                <tr>
                  <th>Bahasa</th>
                  <th>Lisan</th>
                  <th>Menulis</th>
                  <th>Membaca</th>
                  <th>Mendengar</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @forelse ($candidate->languageProficiencies as $candidateLanguageProficiency)
                <tr>
                  <td>{{ $candidateLanguageProficiency->language }}</td>
                  <td>{{ $candidateLanguageProficiency->speaking }}</td>
                  <td>{{ $candidateLanguageProficiency->writing }}</td>
                  <td>{{ $candidateLanguageProficiency->reading }}</td>
                  <td>{{ $candidateLanguageProficiency->listening }}</td>
                  <td>
                    <div class="demo-inline-spacing">

                      <a data-bs-toggle="modal"
                        data-bs-target="#modal-form-edit-language-proficiency-{{ $candidateLanguageProficiency->id }}"
                        class="btn btn-sm btn-icon btn-secondary text-white">
                        <i class="bi bi-pencil-square"></i>
                      </a>
                      @include('pages.recruitment.language-proficiency.modal-edit')

                      <a class="btn btn-sm btn-light-danger mx-2"
                        onclick="deletecandidateLanguageProficiency('{{ $candidateLanguageProficiency->id }}')">
                        <i class="bi bi-trash"></i>
                      </a>

                      <form id="deletecandidateLanguageProficiencyForm_{{ $candidateLanguageProficiency->id }}"
                        action="{{ route('candidateLanguageProficiency.destroy', $candidateLanguageProficiency) }}"
                        method="POST">
                        @method('DELETE')
                        @csrf
                      </form>

                    </div>
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

  <!-- Seminar/Pelatihan -->
  <div class="col-12 col-lg-10">
    <div class="card">
      <div class="card-body">

        <div class="row">
          <div class="d-flex justify-content-between align-items-center ">
            <h4 class="card-title">Data Seminar/Pelatihan</h4>
            @can('candidate.store')
            <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
              data-bs-target="#modal-form-add-training-attended">
              <i class="bi bi-plus-lg"></i>
              Add
            </button>
            @include('pages.recruitment.training-attended.modal-create')
            @endcan
          </div>
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
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @forelse ($candidate->trainingAttendeds as $candidateTrainingAttended)
                <tr>
                  <td class="text-bold-500">{{ $loop->iteration }}</td>
                  <td class="text-bold-500">{{ $candidateTrainingAttended->training_name }}</td>
                  <td class="text-bold-500">{{ $candidateTrainingAttended->organizer_name }}</td>
                  <td class="text-bold-500">{{ $candidateTrainingAttended->city }}</td>
                  <td class="text-bold-500">{{ $candidateTrainingAttended->year }}</td>
                  <td class="text-bold-500">
                    @if ($candidateTrainingAttended->file_sertifikat)
                    <a href="{{ Storage::url($candidateTrainingAttended->file_sertifikat) }}" target="_blank">
                      Lihat
                    </a>
                    @else
                    <span>-</span>
                    @endif
                  </td>
                  <td>
                    @can('candidate.update')
                    <div class="demo-inline-spacing">

                      <a data-bs-toggle="modal"
                        data-bs-target="#modal-form-edit-training-attended-{{ $candidateTrainingAttended->id }}"
                        class="btn btn-sm btn-icon btn-secondary text-white">
                        <i class="bi bi-pencil-square"></i>
                      </a>
                      @include('pages.recruitment.training-attended.modal-edit')

                      <a class="btn btn-sm btn-light-danger mx-2"
                        onclick="deleteTrainingAttend('{{ $candidateTrainingAttended->id }}')"><i
                          class="bi bi-trash"></i></a>

                      <form id="deleteTrainingAttendForm_{{ $candidateTrainingAttended->id }}"
                        action="{{ route('candidateTrainingAttended.destroy', $candidateTrainingAttended->id) }}"
                        method="POST">
                        @method('DELETE')
                        @csrf
                      </form>

                    </div>
                    @endcan
                  </td>
                </tr>
                @empty
                <td class="text-bold-500 text-center" colspan="7">No data available in table</td>
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
          <div class="d-flex justify-content-between align-items-center ">
            <h4 class="card-title">Data Keterampilan/Kompetensi</h4>
            @can('candidate.store')
            <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
              data-bs-target="#modal-form-add-skill">
              <i class="bi bi-plus-lg"></i>
              Add
            </button>
            @include('pages.recruitment.skill.modal-create')
            @endcan
          </div>
          <div class="table-responsive">
            <table class="table table-sm" style="font-size: 80%">
              <thead>
                <tr>
                  <th>Nama Keterampilan/Kompetensi</th>
                  <th>Kemahiran</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @forelse ($candidate->skills as $candidateSkill)
                <tr>
                  <td class="text-bold-500">{{ $candidateSkill->name }}</td>
                  <td class="text-bold-500">
                    {{ $candidateSkill->mastery }}
                  </td>
                  <td>
                    @can('candidate.update')
                    <div class="demo-inline-spacing">
                      <a data-bs-toggle="modal" data-bs-target="#modal-form-edit-skill-{{ $candidateSkill->id }}"
                        class="btn btn-icon btn-secondary text-white">
                        <i class="bi bi-pencil-square"></i>
                      </a>
                      @include('pages.recruitment.skill.modal-edit')

                      <a onclick="deleteskill('{{ $candidateSkill->id }}')" title="Delete" class="btn btn-light-danger">
                        <i class="bi bi-trash"></i>
                      </a>
                      <form id="deleteskillForm_{{ $candidateSkill->id }}"
                        action="{{ route('candidateSkill.destroy', $candidateSkill->id) }}" method="POST">
                        @method('DELETE')
                        @csrf
                      </form>
                    </div>
                    @endcan
                  </td>
                </tr>
                @empty
                <td class="text-bold-500 text-center" colspan="3">No data available in table</td>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- social platform -->
  <div class="col-12 col-lg-10">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="d-flex justify-content-between align-items-center ">
            <h4 class="card-title">Sosial Platform</h4>
            @can('candidate.store')
            <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
              data-bs-target="#modal-form-add-social-platform">
              <i class="bi bi-plus-lg"></i>
              Add
            </button>
            @include('pages.recruitment.social-platform.modal-create')
            @endcan
          </div>
          <div class="table-responsive">
            <table class="table table-sm" style="font-size: 80%">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Platform</th>
                  <th>Nama Akun</th>
                  <th>Link Akun</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @forelse ($candidate->socialsPlatform as $candidateSocialPlatform)
                <tr>
                  <td class="text-bold-500">{{ $loop->iteration }}</td>
                  <td class="text-bold-500">{{ $candidateSocialPlatform->platform }}</td>
                  <td class="text-bold-500">{{ $candidateSocialPlatform->account_name }}</td>
                  <td class="text-bold-500">
                    <a href="{{ $candidateSocialPlatform->account_link }}" target="_blank">{{
                      $candidateSocialPlatform->account_link }}</a>
                  </td>
                  <td>
                    @can('candidate.update')
                    <div class="demo-inline-spacing">

                      <a data-bs-toggle="modal"
                        data-bs-target="#modal-form-edit-social-platform-{{ $candidateSocialPlatform->id }}"
                        class="btn btn-sm btn-icon btn-secondary text-white">
                        <i class="bi bi-pencil-square"></i>
                      </a>
                      @include('pages.recruitment.social-platform.modal-edit')

                      <a class="btn btn-sm btn-light-danger mx-2"
                        onclick="deletecandidateSocialPlatform('{{ $candidateSocialPlatform->id }}')">
                        <i class="bi bi-trash"></i>
                      </a>

                      <form id="deletecandidateSocialPlatformForm_{{ $candidateSocialPlatform->id }}"
                        action="{{ route('candidateSocialPlatform.destroy', $candidateSocialPlatform) }}" method="POST">
                        @method('DELETE')
                        @csrf
                      </form>

                    </div>
                    @endcan
                  </td>
                </tr>
                @empty
                <td class="text-bold-500 text-center" colspan="5">No data available in table</td>
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
                    <a href="{{ Storage::url($candidateDocument->file) }}" class="btn btn-primary" target="_blank">
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

<!--preview img-->
<script>
  function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function () {
      var output = document.getElementById('uploadedAvatar');
      output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
  }
</script>

<!-- sweetalsert-->
<script>
  document.getElementById('submitBtn').addEventListener('click', function (e) {
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

<script>
  function deleteEducational(getId) {
    Swal.fire({
      title: 'Are you sure?',
      text: 'You won\'t be able to revert this!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        // If the user clicks "Yes, delete it!", submit the corresponding form
        document.getElementById('deleteEducationalForm_' + getId).submit();
      }
    });
  }
</script>

<script>
  function deleteEmploymenHistory(getId) {
    Swal.fire({
      title: 'Are you sure?',
      text: 'You won\'t be able to revert this!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        // If the user clicks "Yes, delete it!", submit the corresponding form
        document.getElementById('deleteCandidateEmploymentHistoryForm_' + getId).submit();
      }
    });
  }
</script>

<script>
  function deletecandidateLanguageProficiency(getId) {
    Swal.fire({
      title: 'Are you sure?',
      text: 'You won\'t be able to revert this!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        // If the user clicks "Yes, delete it!", submit the corresponding form
        document.getElementById('deletecandidateLanguageProficiencyForm_' + getId).submit();
      }
    });
  }
</script>

<script>
  function deleteTrainingAttend(getId) {
    Swal.fire({
      title: 'Are you sure?',
      text: 'You won\'t be able to revert this!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        // If the user clicks "Yes, delete it!", submit the corresponding form
        document.getElementById('deleteTrainingAttendForm_' + getId).submit();
      }
    });
  }
</script>

<script>
  function deleteskill(getId) {
    Swal.fire({
      title: 'Are you sure?',
      text: 'You won\'t be able to revert this!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        // If the user clicks "Yes, delete it!", submit the corresponding form
        document.getElementById('deleteskillForm_' + getId).submit();
      }
    });
  }
</script>

<script>
  function deletecandidateSocialPlatform(getId) {
    Swal.fire({
      title: 'Are you sure?',
      text: 'You won\'t be able to revert this!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        // If the user clicks "Yes, delete it!", submit the corresponding form
        document.getElementById('deletecandidateSocialPlatformForm_' + getId).submit();
      }
    });
  }
</script>
<!-- /sweetalsert-->

<!--leaflet-->
<!-- Include Leaflet.js CSS and JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    var mapKTP, mapDomisili;
    var markerKTP, markerDomisili;

    // Initialize KTP Map when modal is shown
    $('#mapModalKTP').on('shown.bs.modal', function () {
      if (!mapKTP) {
        mapKTP = L.map('mapKTP').setView([-6.158011331721201, 106.88320219516756],
          13); // Default location: Jakarta
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(mapKTP);

        // Add marker when map is clicked
        mapKTP.on('click', function (e) {
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
      setTimeout(function () {
        mapKTP.invalidateSize();
      }, 100);
    });

    // Initialize Domisili Map when modal is shown
    $('#mapModalDomisili').on('shown.bs.modal', function () {
      if (!mapDomisili) {
        mapDomisili = L.map('mapDomisili').setView([-6.158011331721201, 106.88320219516756],
          13); // Default location: Jakarta
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(mapDomisili);

        // Add marker when map is clicked
        mapDomisili.on('click', function (e) {
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
      setTimeout(function () {
        mapDomisili.invalidateSize();
      }, 100);
    });

    // Optionally add logic to reset markers or clear fields if needed.
  });
</script>
<!--/leaflet-->

@endsection