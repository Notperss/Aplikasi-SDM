<div class="col-md-12 mt-4">
  {{-- <div class="card" style="background-color: #d1141411;" #a3b3e63d > --}}
  <div class="card" style="background-color: #a3b3e626;">
    <div class="card-content">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center ">
          <h4 class="card-title">Dokumen Lainnya</h4>
          {{-- <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
            data-bs-target="#modal-form-add-language-proficiency">
            <i class="bi bi-plus-lg"></i>
            Add
          </button> --}}
        </div>
        {{-- <p>* Urutkan berdasarkan pengalaman terakhir.</p> --}}
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card" style="background-color: #a3b3e626;">
      <div class="card-content">
        <div class="card-body">

          <div class="row mb-3">
            <div class="col-12">
              <div class="card mb-0" style="background-color: #a3b3e626;">
                <div class="card-content">
                  <div class="card-body">
                    <div class="row">

                      <div class="col-xl-4 d-flex justify-content-center align-items-center text-center my-0"
                        style="height: 30px;">
                        <!-- Upload Form -->
                        <form id="uploadIjazah" action="{{ route('upload.document', $candidate) }}" method="POST"
                          enctype="multipart/form-data">
                          @csrf
                          <div class="my-0">
                            <!-- Hidden File Input -->
                            <input type="file" class="form-control d-none" id="ijazah" name="file"
                              accept=".pdf" required>
                            <input type="hidden" name="type_document" value="ijazah">
                            <input type="hidden" value="{{ $candidate->id }}" name="candidate_id">
                            <input type="hidden" value="{{ $candidate->name }}" name="candidate_name">
                            <!-- Upload Button with Icon and Text -->
                            <label for="ijazah" class="btn btn-sm btn-light" style="cursor: pointer;">
                              <i class="bi bi-filetype-pdf"></i> Ijazah & Transkrip Nilai
                            </label>
                          </div>

                          <!-- Display validation error message -->
                          @if ($errors->has('pdf'))
                            <div class="alert alert-danger">
                              {{ $errors->first('pdf') }}
                            </div>
                          @endif

                          {{-- <button type="submit" class="btn btn-primary">Upload PDF</button> --}}
                        </form>
                      </div>
                      @foreach ($candidateDocuments as $candidateDocument)
                        @if (
                            $candidateDocument &&
                                $candidateDocument->where('candidate_id', $candidate->id)->where('type_document', 'ijazah')->exists())
                          <div class="col-xl-6 d-flex justify-content-center align-items-center text-center my-0"
                            style="height: 30px;">
                            <p class="mb-0">
                              {{ pathinfo($candidateDocument->where('candidate_id', $candidate->id)->where('type_document', 'ijazah')->first()->file,PATHINFO_FILENAME) }}
                            </p>
                          </div>

                          <div class="col-xl-2 d-flex justify-content-center align-items-center text-center my-0"
                            style="height: 30px;">
                            @if (
                                $candidateDocument &&
                                    $candidateDocument->where('candidate_id', $candidate->id)->where('type_document', 'ijazah')->exists())
                              <a href="{{ Storage::url($candidateDocument->where('candidate_id', $candidate->id)->where('type_document', 'ijazah')->first()->file) }}"
                                target="_blank">
                                <i class="bi bi-eye my-0"></i>
                              </a>
                            @endif
                          </div>
                        @else
                          <div class="col-xl-6 d-flex justify-content-center align-items-center text-center my-0"
                            style="height: 30px;">
                            <p class="mb-0">Silahkan unggah file dengan ekstensi .pdf</p>
                          </div>
                        @endif
                      @break
                    @endforeach

                  </div>

                </div>
              </div>
            </div>
            <p class="my-0 text-sm">* Ekstensi File : pdf</p>
            <p class="mb-0 text-sm">* Ukuran File Maks. 500KB</p>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-12">
            <div class="card mb-0" style="background-color: #a3b3e626;">
              <div class="card-content">
                <div class="card-body">
                  <div class="row">

                    <div class="col-xl-4 d-flex justify-content-center align-items-center text-center my-0"
                      style="height: 30px;">
                      <!-- Upload Form -->
                      <form id="uploadKtp" action="{{ route('upload.document', $candidate) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="my-0">
                          <!-- Hidden File Input -->
                          <input type="file" class="form-control d-none" id="ktp" name="file"
                            accept=".pdf" required>
                          <input type="hidden" name="type_document" value="ktp">
                          <input type="hidden" value="{{ $candidate->id }}" name="candidate_id">
                          <input type="hidden" value="{{ $candidate->name }}" name="candidate_name">
                          <!-- Upload Button with Icon and Text -->
                          <label for="ktp" class="btn btn-sm btn-light" style="cursor: pointer;">
                            <i class="bi bi-filetype-pdf"></i> KTP & NPWP
                          </label>
                        </div>

                        <!-- Display validation error message -->
                        @if ($errors->has('pdf'))
                          <div class="alert alert-danger">
                            {{ $errors->first('pdf') }}
                          </div>
                        @endif

                        {{-- <button type="submit" class="btn btn-primary">Upload PDF</button> --}}
                      </form>
                    </div>
                    @foreach ($candidateDocuments as $candidateDocument)
                      @if (
                          $candidateDocument &&
                              $candidateDocument->where('candidate_id', $candidate->id)->where('type_document', 'ktp')->exists())
                        <div class="col-xl-6 d-flex justify-content-center align-items-center text-center my-0"
                          style="height: 30px;">
                          <p class="mb-0">
                            {{ pathinfo($candidateDocument->where('candidate_id', $candidate->id)->where('type_document', 'ktp')->first()->file,PATHINFO_FILENAME) }}
                          </p>
                        </div>

                        <div class="col-xl-2 d-flex justify-content-center align-items-center text-center my-0"
                          style="height: 30px;">
                          {{-- <a href="{{ Storage::url($candidateDocument->file->where('type_document', 'ktp')) }}"
                            target="_blank">
                            <i class="bi bi-eye my-0"></i>
                          </a> --}}
                          @if (
                              $candidateDocument &&
                                  $candidateDocument->where('candidate_id', $candidate->id)->where('type_document', 'ktp')->exists())
                            <a href="{{ Storage::url($candidateDocument->where('candidate_id', $candidate->id)->where('type_document', 'ktp')->first()->file) }}"
                              target="_blank">
                              <i class="bi bi-eye my-0"></i>
                            </a>
                          @endif

                        </div>
                      @else
                        <div class="col-xl-6 d-flex justify-content-center align-items-center text-center my-0"
                          style="height: 30px;">
                          <p class="mb-0">Silahkan unggah file dengan ekstensi .pdf</p>
                        </div>
                      @endif
                    @break
                  @endforeach

                </div>

              </div>
            </div>
          </div>
          <p class="my-0 text-sm">* Ekstensi File : pdf</p>
          <p class="mb-0 text-sm">* Ukuran File Maks. 500KB</p>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-12">
          <div class="card mb-0" style="background-color: #a3b3e626;">
            <div class="card-content">
              <div class="card-body">
                <div class="row">

                  <div class="col-xl-4 d-flex justify-content-center align-items-center text-center my-0"
                    style="height: 30px;">
                    <!-- Upload Form -->
                    <form id="uploadSkck" action="{{ route('upload.document', $candidate) }}" method="POST"
                      enctype="multipart/form-data">
                      @csrf
                      <div class="my-0">
                        <!-- Hidden File Input -->
                        <input type="file" class="form-control d-none" id="skck" name="file"
                          accept=".pdf" required>
                        <input type="hidden" name="type_document" value="skck">
                        <input type="hidden" value="{{ $candidate->id }}" name="candidate_id">
                        <input type="hidden" value="{{ $candidate->name }}" name="candidate_name">
                        <!-- Upload Button with Icon and Text -->
                        <label for="skck" class="btn btn-sm btn-light" style="cursor: pointer;">
                          <i class="bi bi-filetype-pdf"></i> SKCK Aktif
                        </label>
                      </div>

                      <!-- Display validation error message -->
                      @if ($errors->has('pdf'))
                        <div class="alert alert-danger">
                          {{ $errors->first('pdf') }}
                        </div>
                      @endif

                      {{-- <button type="submit" class="btn btn-primary">Upload PDF</button> --}}
                    </form>
                  </div>
                  @foreach ($candidateDocuments as $candidateDocument)
                    @if (
                        $candidateDocument &&
                            $candidateDocument->where('candidate_id', $candidate->id)->where('type_document', 'skck')->exists())
                      <div class="col-xl-6 d-flex justify-content-center align-items-center text-center my-0"
                        style="height: 30px;">
                        <p class="mb-0">
                          {{ pathinfo($candidateDocument->where('candidate_id', $candidate->id)->where('type_document', 'skck')->first()->file,PATHINFO_FILENAME) }}
                        </p>
                      </div>

                      <div class="col-xl-2 d-flex justify-content-center align-items-center text-center my-0"
                        style="height: 30px;">
                        {{-- <a href="{{ Storage::url($candidateDocument->file->where('type_document', 'skck')) }}"
                            target="_blank">
                            <i class="bi bi-eye my-0"></i>
                          </a> --}}
                        @if (
                            $candidateDocument &&
                                $candidateDocument->where('candidate_id', $candidate->id)->where('type_document', 'skck')->exists())
                          <a href="{{ Storage::url($candidateDocument->where('candidate_id', $candidate->id)->where('type_document', 'skck')->first()->file) }}"
                            target="_blank">
                            <i class="bi bi-eye my-0"></i>
                          </a>
                        @endif

                      </div>
                    @else
                      <div class="col-xl-6 d-flex justify-content-center align-items-center text-center my-0"
                        style="height: 30px;">
                        <p class="mb-0">Silahkan unggah file dengan ekstensi .pdf</p>
                      </div>
                    @endif
                  @break
                @endforeach

              </div>

            </div>
          </div>
        </div>
        <p class="my-0 text-sm">* Ekstensi File : pdf</p>
        <p class="mb-0 text-sm">* Ukuran File Maks. 500KB</p>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-12">
        <div class="card mb-0" style="background-color: #a3b3e626;">
          <div class="card-content">
            <div class="card-body">
              <div class="row">

                <div class="col-xl-4 d-flex justify-content-center align-items-center text-center my-0"
                  style="height: 30px;">
                  <!-- Upload Form -->
                  <form id="uploadAkta-kk" action="{{ route('upload.document', $candidate) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="my-0">
                      <!-- Hidden File Input -->
                      <input type="file" class="form-control d-none" id="akta-kk" name="file"
                        accept=".pdf" required>
                      <input type="hidden" name="type_document" value="akta-kk">
                      <input type="hidden" value="{{ $candidate->id }}" name="candidate_id">
                      <input type="hidden" value="{{ $candidate->name }}" name="candidate_name">
                      <!-- Upload Button with Icon and Text -->
                      <label for="akta-kk" class="btn btn-sm btn-light" style="cursor: pointer;">
                        <i class="bi bi-filetype-pdf"></i> Akte Lahir & Kartu Keluarga
                      </label>
                    </div>

                    <!-- Display validation error message -->
                    @if ($errors->has('pdf'))
                      <div class="alert alert-danger">
                        {{ $errors->first('pdf') }}
                      </div>
                    @endif

                    {{-- <button type="submit" class="btn btn-primary">Upload PDF</button> --}}
                  </form>
                </div>
                @foreach ($candidateDocuments as $candidateDocument)
                  @if (
                      $candidateDocument &&
                          $candidateDocument->where('candidate_id', $candidate->id)->where('type_document', 'akta-kk')->exists())
                    <div class="col-xl-6 d-flex justify-content-center align-items-center text-center my-0"
                      style="height: 30px;">
                      <p class="mb-0">
                        {{ pathinfo($candidateDocument->where('candidate_id', $candidate->id)->where('type_document', 'akta-kk')->first()->file,PATHINFO_FILENAME) }}
                      </p>
                    </div>

                    <div class="col-xl-2 d-flex justify-content-center align-items-center text-center my-0"
                      style="height: 30px;">
                      {{-- <a href="{{ Storage::url($candidateDocument->file->where('type_document', 'akta-kk')) }}"
                            target="_blank">
                            <i class="bi bi-eye my-0"></i>
                          </a> --}}
                      @if (
                          $candidateDocument &&
                              $candidateDocument->where('candidate_id', $candidate->id)->where('type_document', 'akta-kk')->exists())
                        <a href="{{ Storage::url($candidateDocument->where('candidate_id', $candidate->id)->where('type_document', 'akta-kk')->first()->file) }}"
                          target="_blank">
                          <i class="bi bi-eye my-0"></i>
                        </a>
                      @endif

                    </div>
                  @else
                    <div class="col-xl-6 d-flex justify-content-center align-items-center text-center my-0"
                      style="height: 30px;">
                      <p class="mb-0">Silahkan unggah file dengan ekstensi .pdf</p>
                    </div>
                  @endif
                @break
              @endforeach

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
