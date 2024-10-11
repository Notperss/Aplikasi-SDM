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

                  <div class="mb-3">
                    <label for="file_cv" class="form-label">CV</label> <br>
                    @can('candidate.update')
                      <input class="form-control form-control-sm mb-1" accept=".pdf" type="file" id="file_cv"
                        name="file_cv">
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
                        {{-- {{ pathinfo($candidate->file_cv, PATHINFO_FILENAME) }} --}}
                        Lihat CV
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
                    <label for="file_surat_sehat" class="form-label">SURAT KETERANGAN SEHAT</label><br>
                    @can('candidate.update')
                      <input class="form-control form-control-sm mb-1" accept=".pdf" type="file" id="file_surat_sehat"
                        name="file_surat_sehat">
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
                    <input type="text" id="phone_number"
                      value="{{ old('phone_number', $candidate->phone_number) }}" maxlength="13"
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
                      <option value="Buddha"
                        {{ old('religion', $candidate->religion) == 'Buddha' ? 'selected' : '' }}>
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
                      <option value="UMUM"{{ $candidate->candidate_from == 'UMUM' ? 'selected' : '' }}>Umum</option>
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
                      name="ktp_address" rows="5"> {{ old('ktp_address', $candidate->ktp_address) }}</textarea>
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
                    <label for="current_address">Alamat Domisili</label>
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