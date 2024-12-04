@extends('layouts.app')
@section('title', 'Dinas/Tugas')
@section('content')

@section('breadcrumb')
  <x-breadcrumb title="Edit Dinas/Tugas" page="Karyawan" active="Dinas/Tugas" route="{{ route('employeeDuty.index') }}" />
@endsection

<section class="section">
  <form action="{{ route('employeeDuty.update', $employeeDuty) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="card">
      <div class="card-header">
      </div>
      <div class="card-body">
        <div class="row justify-content-center">
          <div class="col-md-12"> <!-- Make form smaller with col-md-6 and center it -->

            <div class="mb-2">
              <label class="form-label" for="name_duty">Dinas/Tugas <code>*</code></label>
              <input id="name_duty" name="name_duty" value="{{ old('name_duty', $employeeDuty->name_duty) }}"
                class="form-control @error('name_duty') is-invalid @enderror">
              @error('name_duty')
                <a style="color: red"><small>{{ $message }}</small></a>
              @enderror
            </div>

            <div class="row mb-2">
              <div class="col-md-6">
                <label class="form-label" for="start_date">Tanggal Mulai <code>*</code></label>
                <input id="start_date" type="date" name="start_date"
                  value="{{ old('start_date', $employeeDuty->start_date) }}"
                  class="form-control @error('start_date') is-invalid @enderror">
                @error('start_date')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>
              <div class="col-md-6">
                <label class="form-label" for="end_date">Tanggal Selesai <code>*</code></label>
                <input id="end_date" type="date" name="end_date"
                  value="{{ old('end_date', $employeeDuty->end_date) }}"
                  class="form-control @error('end_date') is-invalid @enderror">
                @error('end_date')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>
            </div>

            <div class="mb-2">
              <label class="form-label" for="location">Lokasi <code>*</code></label>
              <input id="location" name="location" value="{{ old('location', $employeeDuty->location) }}"
                class="form-control @error('location') is-invalid @enderror" required>
              @error('location')
                <a style="color: red"><small>{{ $message }}</small></a>
              @enderror
            </div>

            <div class="mb-2">
              <label class="form-label" for="description">Keterangan</label>
              <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $employeeDuty->description) }} </textarea>
              @error('description')
                <a style="color: red"><small>{{ $message }}</small></a>
              @enderror
            </div>

            <div class="mb-2">
              <label for="file" class="form-label">File</label>
              <input class="form-control" accept=".pdf" type="file" id="file"
                @error('file') is-invalid @enderror name="file">
              @error('file')
                <a style="color: red"><small>{{ $message }}</small></a>
              @enderror
              <div class="text-center my-3" style="height: 30px;">
                @if ($employeeDuty->file)
                  <a href="{{ Storage::url($employeeDuty->file) }}" target="_blank">
                    {{ pathinfo($employeeDuty->file, PATHINFO_FILENAME) }}
                  </a>
                @else
                  <span>No File</span>
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
