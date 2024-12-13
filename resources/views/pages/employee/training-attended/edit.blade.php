@extends('layouts.app')
@section('title', 'Seminar/Pelatihan')
@section('content')

@section('breadcrumb')
  <x-breadcrumb title="Edit Seminar/Pelatihan" page="Karyawan" active="Seminar/Pelatihan"
    route="{{ route('employeeTrainingAttended.index') }}" />
@endsection

<section class="section">
  <form action="{{ route('employeeTrainingAttended.update', $employeeTrainingAttended) }}" method="post"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="card">
      <div class="card-header">
      </div>
      <div class="card-body">
        <div class="row justify-content-center">
          <div class="col-md-11"> <!-- Make form smaller with col-md-6 and center it -->



            <div class="mb-2">
              <label class="form-label" for="training_name">Nama Seminar/Pelatihan</label>
              <input id="training_name" name="training_name"
                value="{{ old('training_name', $employeeTrainingAttended->training_name) }}"
                class="form-control @error('training_name') is-invalid @enderror" required>
              @error('training_name')
                <a style="color: red"><small>{{ $message }}</small></a>
              @enderror
            </div>

            <div class="mb-2">
              <label class="form-label" for="organizer_name">Penyelenggara</label>
              <input id="organizer_name" name="organizer_name"
                value="{{ old('organizer_name', $employeeTrainingAttended->organizer_name) }}"
                class="form-control @error('organizer_name') is-invalid @enderror" required>
              @error('organizer_name')
                <a style="color: red"><small>{{ $message }}</small></a>
              @enderror
            </div>

            <div class="mb-2">
              <label class="form-label" for="city">Tempat/Kota</label>
              <input id="city" value="{{ old('city', $employeeTrainingAttended->city) }}" name="city"
                class="form-control @error('city') is-invalid @enderror">
              @error('city')
                <a style="color: red"><small>{{ $message }}</small></a>
              @enderror
            </div>

            <div class="col-3 mb-2">
              <label class="form-label" for="training_date">Tahun</label>
              <input type="date" id="training_date" name="training_date" maxlength="4"
                value="{{ old('training_date', $employeeTrainingAttended->training_date) }}"
                class="form-control @error('training_date') is-invalid @enderror">
              @error('training_date')
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
                @if ($employeeTrainingAttended->file_sertifikat)
                  <a href="{{ Storage::url($employeeTrainingAttended->file_sertifikat) }}" target="_blank">
                    {{ pathinfo($employeeTrainingAttended->file_sertifikat, PATHINFO_FILENAME) }}
                  </a>
                @else
                  <span>-</span>
                @endif
              </div>

            </div>



          </div>
        </div>
        <div class="col-12 d-flex justify-content-end mt-4">
          <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
          <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
        </div>
      </div>
    </div>

  </form>

</section>
@endsection
