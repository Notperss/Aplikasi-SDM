<div class="col-md-12 mt-4">
  {{-- <div class="card" style="background-color: #d1141411;" #a3b3e63d > --}}
  <div class="card" style="background-color: #a3b3e626;">
    <div class="card-content">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center ">
          <h4 class="card-title">Dokumen Lainnya</h4>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card" style="background-color: #a3b3e626;">
      <div class="card-content">
        <div class="card-body">
          <!-- CV -->
          <div class="row mb-3">
            <div class="col-12">
              <div class="card mb-0" style="background-color: #a3b3e626;">
                <div class="card-content">
                  <div class="card-body">
                    <div class="row">

                      <div class="col-xl-4 d-flex justify-content-center align-items-center text-center my-3"
                        style="height: 30px;">
                        <!-- Upload Form -->
                        <form id="uploadCV" action="{{ route('upload.document', $candidate) }}" method="POST"
                          enctype="multipart/form-data">
                          @csrf
                          <div class="mb-0">
                            <!-- Hidden File Input -->
                            <input type="file" class="form-control d-none" id="CV" name="file"
                              accept=".pdf" required>
                            <input type="hidden" name="type_document" value="CV" hidden>
                            {{-- <input type="hidden" value="{{ $candidate->id }}" name="candidate_id">  --}}
                            <input type="hidden" value="{{ $candidate->name }}" name="candidate_name">
                            <!-- Upload Button with Icon and Text -->
                            <label for="CV" class="btn btn-sm btn-light" style="cursor: pointer;">
                              <i class="bi bi-filetype-pdf"></i> CV
                            </label>
                          </div>

                        </form>
                      </div>
                      @forelse ($cvDocuments as $cvDocument)
                        <div class="col-xl-6 d-flex justify-content-center align-items-center text-center my-3"
                          style="height: 30px;">
                          <p class="mb-0">
                            {{ pathinfo($cvDocument->file, PATHINFO_FILENAME) }}
                          </p>
                        </div>
                        <div class="col-xl-2 d-flex justify-content-center align-items-center text-center my-3"
                          style="height: 30px;">
                          <a href="{{ Storage::url($cvDocument->file) }}" target="_blank">
                            <i class="bi bi-eye my-3"></i>
                          </a>
                        </div>
                      @break

                      @empty
                        <div class="col-xl-6 d-flex justify-content-center align-items-center text-center my-3"
                          style="height: 30px;">
                          <p class="mb-0">Silahkan unggah file dengan ekstensi .pdf</p>
                        </div>
                      @endforelse
                    </div>
                  </div>
                </div>
              </div>
              <p class="my-0 text-sm">* Ekstensi File : pdf</p>
              <p class="mb-0 text-sm">* Ukuran File Maks. 500KB</p>
            </div>
          </div>

          <!-- ijazah -->
          <div class="row mb-3">
            <div class="col-12">
              <div class="card mb-0" style="background-color: #a3b3e626;">
                <div class="card-content">
                  <div class="card-body">
                    <div class="row">

                      <div class="col-xl-4 d-flex justify-content-center align-items-center text-center my-3"
                        style="height: 30px;">
                        <!-- Upload Form -->
                        <form id="uploadIjazah" action="{{ route('upload.document', $candidate) }}" method="POST"
                          enctype="multipart/form-data">
                          @csrf
                          <div class="my-3">
                            <!-- Hidden File Input -->
                            <input type="file" class="form-control d-none" id="ijazah" name="file"
                              accept=".pdf" required>
                            <input type="hidden" name="type_document" value="ijazah" hidden>
                            {{-- <input type="hidden" value="{{ $candidate->id }}" name="candidate_id">  --}}
                            <input type="hidden" value="{{ $candidate->name }}" name="candidate_name">
                            <!-- Upload Button with Icon and Text -->
                            <label for="ijazah" class="btn btn-sm btn-light" style="cursor: pointer;">
                              <i class="bi bi-filetype-pdf"></i> Ijazah & Transkrip Nilai
                            </label>
                          </div>

                        </form>
                      </div>
                      @forelse ($ijazahDocuments as $ijazahDocument)
                        <div class="col-xl-6 d-flex justify-content-center align-items-center text-center my-3"
                          style="height: 30px;">
                          <p class="mb-0">
                            {{ pathinfo($ijazahDocument->file, PATHINFO_FILENAME) }}
                          </p>
                        </div>
                        <div class="col-xl-2 d-flex justify-content-center align-items-center text-center my-3"
                          style="height: 30px;">
                          <a href="{{ Storage::url($ijazahDocument->file) }}" target="_blank">
                            <i class="bi bi-eye my-3"></i>
                          </a>
                        </div>
                      @break

                      @empty
                        <div class="col-xl-6 d-flex justify-content-center align-items-center text-center my-3"
                          style="height: 30px;">
                          <p class="mb-0">Silahkan unggah file dengan ekstensi .pdf</p>
                        </div>
                      @endforelse
                    </div>
                  </div>
                </div>
              </div>
              <p class="my-0 text-sm">* Ekstensi File : pdf</p>
              <p class="mb-0 text-sm">* Ukuran File Maks. 500KB</p>
            </div>
          </div>

          <!-- ktp & npwp -->
          <div class="row mb-3">
            <div class="col-12">
              <div class="card mb-0" style="background-color: #a3b3e626;">
                <div class="card-content">
                  <div class="card-body">
                    <div class="row">

                      <div class="col-xl-4 d-flex justify-content-center align-items-center text-center my-3"
                        style="height: 30px;">
                        <!-- Upload Form -->
                        <form id="uploadKtp" action="{{ route('upload.document', $candidate) }}" method="POST"
                          enctype="multipart/form-data">
                          @csrf
                          <div class="my-3">
                            <!-- Hidden File Input -->
                            <input type="file" class="form-control d-none" id="ktp" name="file"
                              accept=".pdf" required>
                            <input type="hidden" name="type_document" value="ktp" hidden>
                            {{-- <input type="hidden" value="{{ $candidate->id }}" name="candidate_id"> --}}
                            <input type="hidden" value="{{ $candidate->name }}" name="candidate_name">
                            <!-- Upload Button with Icon and Text -->
                            <label for="ktp" class="btn btn-sm btn-light" style="cursor: pointer;">
                              <i class="bi bi-filetype-pdf"></i> KTP & NPWP
                            </label>
                          </div>

                        </form>
                      </div>
                      @forelse($ktpDocuments as $ktpDocument)
                        <div class="col-xl-6 d-flex justify-content-center align-items-center text-center my-3"
                          style="height: 30px;">
                          <p class="mb-0">
                            {{ pathinfo($ktpDocument->file, PATHINFO_FILENAME) }}
                          </p>
                        </div>

                        <div class="col-xl-2 d-flex justify-content-center align-items-center text-center my-3"
                          style="height: 30px;">
                          <a href="{{ Storage::url($ktpDocument->file) }}" target="_blank">
                            <i class="bi bi-eye my-3"></i>
                          </a>
                        </div>
                      @break

                      @empty
                        <div class="col-xl-6 d-flex justify-content-center align-items-center text-center my-3"
                          style="height: 30px;">
                          <p class="mb-0">Silahkan unggah file dengan ekstensi .pdf</p>
                        </div>
                      @endforelse

                    </div>

                  </div>
                </div>
              </div>
              <p class="my-0 text-sm">* Ekstensi File : pdf</p>
              <p class="mb-0 text-sm">* Ukuran File Maks. 500KB</p>
            </div>
          </div>

          <!-- skck -->
          <div class="row mb-3">
            <div class="col-12">
              <div class="card mb-0" style="background-color: #a3b3e626;">
                <div class="card-content">
                  <div class="card-body">
                    <div class="row">

                      <div class="col-xl-4 d-flex justify-content-center align-items-center text-center my-3"
                        style="height: 30px;">
                        <!-- Upload Form -->
                        <form id="uploadSkck" action="{{ route('upload.document', $candidate) }}" method="POST"
                          enctype="multipart/form-data">
                          @csrf
                          <div class="my-3">
                            <!-- Hidden File Input -->
                            <input type="file" class="form-control d-none" id="skck" name="file"
                              accept=".pdf" required>
                            <input type="hidden" name="type_document" value="skck" hidden>
                            {{-- <input type="hidden" value="{{ $candidate->id }}" name="candidate_id"> --}}
                            <input type="hidden" value="{{ $candidate->name }}" name="candidate_name">
                            <!-- Upload Button with Icon and Text -->
                            <label for="skck" class="btn btn-sm btn-light" style="cursor: pointer;">
                              <i class="bi bi-filetype-pdf"></i> SKCK Aktif
                            </label>
                          </div>

                        </form>
                      </div>
                      @forelse ($skckDocuments as $skckDocument)
                        <div class="col-xl-6 d-flex justify-content-center align-items-center text-center my-3"
                          style="height: 30px;">
                          <p class="mb-0">
                            {{ pathinfo($skckDocument->file, PATHINFO_FILENAME) }}
                          </p>
                        </div>
                        <div class="col-xl-2 d-flex justify-content-center align-items-center text-center my-3"
                          style="height: 30px;">
                          <a href="{{ Storage::url($skckDocument->file) }}" target="_blank">
                            <i class="bi bi-eye my-3"></i>
                          </a>
                        </div>
                      @break

                      @empty
                        <div class="col-xl-6 d-flex justify-content-center align-items-center text-center my-3"
                          style="height: 30px;">
                          <p class="mb-0">Silahkan unggah file dengan ekstensi .pdf</p>
                        </div>
                      @endforelse
                    </div>

                  </div>
                </div>
              </div>
              <p class="my-0 text-sm">* Ekstensi File : pdf</p>
              <p class="mb-0 text-sm">* Ukuran File Maks. 500KB</p>
            </div>
          </div>

          <!-- akta & kk -->
          <div class="row mb-3">
            <div class="col-12">
              <div class="card mb-0" style="background-color: #a3b3e626;">
                <div class="card-content">
                  <div class="card-body">
                    <div class="row">

                      <div class="col-xl-4 d-flex justify-content-center align-items-center text-center my-3"
                        style="height: 30px;">
                        <!-- Upload Form -->
                        <form id="uploadAkta-kk" action="{{ route('upload.document', $candidate) }}" method="POST"
                          enctype="multipart/form-data">
                          @csrf
                          <div class="my-3">
                            <!-- Hidden File Input -->
                            <input type="file" class="form-control d-none" id="akta-kk" name="file"
                              accept=".pdf" required>
                            <input type="hidden" name="type_document" value="akta-kk" hidden>
                            {{-- <input type="hidden" value="{{ $candidate->id }}" name="candidate_id"> --}}
                            <input type="hidden" value="{{ $candidate->name }}" name="candidate_name">
                            <!-- Upload Button with Icon and Text -->
                            <label for="akta-kk" class="btn btn-sm btn-light" style="cursor: pointer;">
                              <i class="bi bi-filetype-pdf"></i> Akte Lahir & Kartu Keluarga
                            </label>
                          </div>

                        </form>
                      </div>
                      @forelse ($aktaDocuments as $aktaDocument)
                        <div class="col-xl-6 d-flex justify-content-center align-items-center text-center my-3"
                          style="height: 30px;">
                          <p class="mb-0">
                            {{ pathinfo($aktaDocument->file, PATHINFO_FILENAME) }}
                          </p>
                        </div>
                        <div class="col-xl-2 d-flex justify-content-center align-items-center text-center my-3"
                          style="height: 30px;">
                          <a href="{{ Storage::url($aktaDocument->file) }}" target="_blank">
                            <i class="bi bi-eye my-3"></i>
                          </a>
                        </div>
                      @break

                      @empty
                        <div class="col-xl-6 d-flex justify-content-center align-items-center text-center my-3"
                          style="height: 30px;">
                          <p class="mb-0">Silahkan unggah file dengan ekstensi .pdf</p>
                        </div>
                      @endforelse
                    </div>

                  </div>
                </div>
              </div>
              <p class="my-0 text-sm">* Ekstensi File : pdf</p>
              <p class="mb-0 text-sm">* Ukuran File Maks. 500KB</p>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>


{{-- @include('pages.recruitment.language-proficiency.modal-create') --}}
</div>

<script>
  document.getElementById('ijazah').addEventListener('change', function() {
    if (this.files.length > 0) {
      document.getElementById('uploadIjazah').submit();
    }
  });
  document.getElementById('ktp').addEventListener('change', function() {
    if (this.files.length > 0) {
      document.getElementById('uploadKtp').submit();
    }
  });
  document.getElementById('skck').addEventListener('change', function() {
    if (this.files.length > 0) {
      document.getElementById('uploadSkck').submit();
    }
  });
  document.getElementById('akta-kk').addEventListener('change', function() {
    if (this.files.length > 0) {
      document.getElementById('uploadAkta-kk').submit();
    }
  });
  document.getElementById('CV').addEventListener('change', function() {
    if (this.files.length > 0) {
      document.getElementById('uploadCV').submit();
    }
  });
</script>

<script>
  function deletelanguageProficiency(getId) {
    Swal.fire({
      title: 'Are you sure?',
      text: 'You won\'t be able to revert this!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        // If the user clicks "Yes, delete it!", submit the corresponding form
        document.getElementById('deletelanguageProficiencyForm_' + getId).submit();
      }
    });
  }
</script>
