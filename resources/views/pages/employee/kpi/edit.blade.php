@extends('layouts.app')
@section('title', 'KPI')
@section('content')

@section('breadcrumb')
  <x-breadcrumb title="Edit KPI" page="Karyawan" active="KPI" route="{{ route('employeeKpi.index') }}" />
@endsection

<section class="section">
  <form action="{{ route('employeeKpi.update', $employeeKpi) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="card">
      <div class="card-header">
      </div>
      <div class="card-body">
        <div class="row justify-content-center">
          <div class="col-md-12"> <!-- Make form smaller with col-md-6 and center it -->

            <div class="col-12 mb-2">
              <label class="form-label" for="kpi_date">Tanggal PK <code>*</code></label>
              <input type="date" id="kpi_date" name="kpi_date" maxlength="4"
                value="{{ old('kpi_date', $employeeKpi->kpi_date) }}"
                class="form-control @error('kpi_date') is-invalid @enderror">
              @error('kpi_date')
                <a style="color: red"><small>{{ $message }}</small></a>
              @enderror
            </div>

            <div class="mb-2">
              <label class="form-label" for="grade">Nilai <code>*</code></label>
              <input id="grade" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                name="grade" value="{{ old('grade', $employeeKpi->grade) }}"
                class="form-control @error('grade') is-invalid @enderror" required>
              @error('grade')
                <a style="color: red"><small>{{ $message }}</small></a>
              @enderror
            </div>

            <div class="mb-2">
              <label class="form-label" for="contract_recommendation">Rekomendasi Kontrak <code>*</code></label>
              <select id="contract_recommendation" name="contract_recommendation"
                class="form-control @error('contract_recommendation') is-invalid @enderror">
                <option value="" disabled selected>Choose</option>
                <option value="1"{{ $employeeKpi->contract_recommendation == '1' ? 'selected' : '' }}>Kontrak
                  Kerja Di Perpanjang</option>
                <option value="0"{{ $employeeKpi->contract_recommendation == '0' ? 'selected' : '' }}>Kontrak
                  Kerja Tidak Di Lanjutkan</option>
              </select>
              @error('contract_recommendation')
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
                @if ($employeeKpi->file)
                  <a href="{{ Storage::url($employeeKpi->file) }}" target="_blank">
                    {{ pathinfo($employeeKpi->file, PATHINFO_FILENAME) }}
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
