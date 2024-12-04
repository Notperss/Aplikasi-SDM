@extends('layouts.app')
@section('title', 'Penghargaan')
@section('content')

@section('breadcrumb')
  <x-breadcrumb title="Edit Penghargaan" page="Karyawan" active="Penghargaan" route="{{ route('employeeAward.index') }}" />
@endsection

<section class="section">
  <form action="{{ route('employeeAward.update', $employeeAward) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="card">
      <div class="card-header">
      </div>
      <div class="card-body">
        <div class="row justify-content-center">
          <div class="col-md-12"> <!-- Make form smaller with col-md-6 and center it -->

            <div class="mb-2">
              <label class="form-label" for="name_award">Nama Penghargaan <code>*</code></label>
              <input id="name_award" type="text" name="name_award"
                value="{{ old('name_award', $employeeAward->name_award) }}"
                class="form-control @error('name_award') is-invalid @enderror">
              @error('name_award')
                <a style="color: red"><small>{{ $message }}</small></a>
              @enderror
            </div>

            <div class="mb-2">
              <label class="form-label" for="date_award">Tanggal Penghargaan <code>*</code></label>
              <input id="date_award" type="date" name="date_award"
                value="{{ old('date_award', $employeeAward->date_award) }}"
                class="form-control @error('date_award') is-invalid @enderror">
              @error('date_award')
                <a style="color: red"><small>{{ $message }}</small></a>
              @enderror
            </div>


            <div class="mb-2">
              <label for="file_award" class="form-label">File</label>
              <input class="form-control" accept=".pdf" type="file" id="file_award"
                @error('file_award') is-invalid @enderror name="file_award">
              @error('file_award')
                <a style="color: red"><small>{{ $message }}</small></a>
              @enderror
              <div class="text-center my-3" style="height: 30px;">
                @if ($employeeAward->file_award)
                  <a href="{{ Storage::url($employeeAward->file_award) }}" target="_blank">
                    {{ pathinfo($employeeAward->file_award, PATHINFO_FILENAME) }}
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
