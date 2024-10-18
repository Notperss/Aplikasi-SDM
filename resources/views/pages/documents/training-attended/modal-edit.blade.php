<!-- Modals add menu -->
<div id="modal-form-edit-training-attended-{{ $candidateTrainingAttended->id }}" class="modal fade" tabindex="-1"
  aria-labelledby="modal-form-edit-training-attended-{{ $candidateTrainingAttended->id }}-label" aria-hidden="true"
  style="display: none;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('candidateTrainingAttended.update', $candidateTrainingAttended) }}" method="post"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-edit-training-attended-{{ $candidateTrainingAttended->id }}-label">
            Edit Data Pengalaman Kerja
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>

        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-12"> <!-- Make form smaller with col-md-6 and center it -->
              <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">
              <input type="hidden" name="name" value="{{ $candidate->name }}">

              <div class="mb-2">
                <label class="form-label" for="training_name">Nama Seminar/Pelatihan</label>
                <input id="training_name" name="training_name"
                  value="{{ old('training_name', $candidateTrainingAttended->training_name) }}"
                  class="form-control @error('training_name') is-invalid @enderror" required>
                @error('training_name')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label class="form-label" for="organizer_name">Penyelenggara</label>
                <input id="organizer_name" name="organizer_name"
                  value="{{ old('organizer_name', $candidateTrainingAttended->organizer_name) }}"
                  class="form-control @error('organizer_name') is-invalid @enderror" required>
                @error('organizer_name')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label class="form-label" for="city">Tempat/Kota</label>
                <input id="city" value="{{ old('city', $candidateTrainingAttended->city) }}" name="city"
                  class="form-control @error('city') is-invalid @enderror">
                @error('city')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="col-3 mb-2">
                <label class="form-label" for="year">Tahun</label>
                <input id="year" name="year" maxlength="4"
                  value="{{ old('year', $candidateTrainingAttended->year) }}"
                  class="form-control @error('year') is-invalid @enderror">
                @error('year')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>

              <div class="mb-2">
                <label for="file_sertifikat" class="form-label">File Setifikat</label>
                <input class="form-control" accept=".pdf" type="file" id="file_sertifikat"
                  @error('file_sertifikat') is-invalid @enderror name="file_sertifikat">
                @error('file_sertifikat')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror

                <div class="text-center my-3" style="height: 30px;">
                  @if ($candidateTrainingAttended->file_sertifikat)
                    <a href="{{ Storage::url($candidateTrainingAttended->file_sertifikat) }}" target="_blank">
                      {{ pathinfo($candidateTrainingAttended->file_sertifikat, PATHINFO_FILENAME) }}
                    </a>
                  @else
                    <span>-</span>
                  @endif
                </div>

              </div>

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