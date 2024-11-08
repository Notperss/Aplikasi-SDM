@extends('layouts.app')
@section('title', 'Jabatan')
@section('content')

@section('breadcrumb')
  <x-breadcrumb title="Tambah Tunjangan Jabatan" page="Position" active="Jabatan" route="{{ route('position.index') }}" />
@endsection

<section class="section">
  <form action="{{ route('positionAllowance', $position) }}" method="post">
    @csrf
    @method('PUT')

    <div class="card">
      <div class="card-body">
        <div class="row justify-content-center">
          <div class="col-md-11"> <!-- Make form smaller with col-md-6 and center it -->

            <div class="row">

              <div class="col-md-6">
                <div class="mb-2">
                  <label class="form-label" for="name">Direktorat</label>
                  <input id="name" value="{{ $position->directorate->name }}"
                    class="form-control @error('name') is-invalid @enderror" readonly>
                  @error('name')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>

                <div class="mb-2">
                  <label class="form-label" for="name">Divisi</label>
                  <input id="name" value="{{ $position->division->name }}"
                    class="form-control @error('name') is-invalid @enderror" readonly>
                  @error('name')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>

                <div class="mb-2">
                  <label class="form-label" for="name">Departmen</label>
                  <input id="name" value="{{ $position->department->name ?? '-' }}"
                    class="form-control @error('name') is-invalid @enderror" readonly>
                  @error('name')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>

                <div class="mb-2">
                  <label class="form-label" for="name">Seksi</label>
                  <input id="name" value="{{ $position->section->name ?? '-' }}"
                    class="form-control @error('name') is-invalid @enderror" readonly>
                  @error('name')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>

              </div>
              <div class="col-md-6">
                <div class="mb-2">
                  <label class="form-label" for="name">Level</label>
                  <input id="name" value="{{ $position->level->name }}"
                    class="form-control @error('name') is-invalid @enderror" readonly>
                  @error('name')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>

                <div class="mb-2">
                  <label class="form-label" for="name">Nama Jabatan</label>
                  <input id="name" value="{{ $position->name }}"
                    class="form-control @error('name') is-invalid @enderror" readonly>
                  @error('name')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>

                <div class="my-2">
                  <label class="form-label" for="description">Deskripsi</label>
                  <textarea id="description" class="form-control @error('description') is-invalid @enderror" rows="5" readonly> {{ old('description', $position->description) }} </textarea>
                  @error('description')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>
              </div>

            </div>


            <div class="row">


              <div class="col-md-12">
                <div class="my-2">
                  <label class="form-label" for="allowance_id">Tambah Tunjangan</label>
                  <select id="allowance_id" name="allowance_id[]"
                    class="form-control choices multiple-remove @error('allowance_id') is-invalid @enderror"
                    multiple="multiple">
                    <option value="" disabled>Choose</option>
                    @foreach ($allowances->where('level_id', $position->level_id) as $allowance)
                      <option value="{{ $allowance->id }}"
                        {{ in_array($allowance->id, old('allowance_id', $position->allowances->pluck('id')->toArray())) ? 'selected' : '' }}>
                        {{ $allowance->name }}
                      </option>
                    @endforeach
                  </select>
                  @error('allowance_id')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <label for="selected_allowances">Daftar Tunjangan BPJS:</label>
                    <ul id="selected_allowances">
                      @if (!empty($position->allowances()->where('type', 'BPJS')->pluck('allowances.name')->toArray()))
                        @foreach ($position->allowances()->where('type', 'BPJS')->pluck('allowances.name')->toArray() as $allowance)
                          <li><span class="badge bg-light-info">{{ $allowance }}</span></li>
                        @endforeach
                      @else
                        <li>Tidak ada tunjangan.</li>
                      @endif
                    </ul>
                  </div>
                  <div class="col-md-4">
                    <label for="selected_allowances">Daftar Tunjangan NON-BPJS:</label>
                    <ul id="selected_allowances">
                      @if (!empty($position->allowances()->where('type', 'NON-BPJS')->pluck('allowances.name')->toArray()))
                        @foreach ($position->allowances()->where('type', 'NON-BPJS')->pluck('allowances.name')->toArray() as $allowance)
                          <li><span class="badge bg-light-info">{{ $allowance }}</span></li>
                        @endforeach
                      @else
                        <li>Tidak ada tunjangan.</li>
                      @endif
                    </ul>
                  </div>
                  <div class="col-md-4">
                    <label for="selected_allowances">Daftar Tunjangan PERUSAHAAN:</label>
                    <ul id="selected_allowances">
                      @if (!empty($position->allowances()->where('type', 'PERUSAHAAN')->pluck('allowances.name')->toArray()))
                        @foreach ($position->allowances()->where('type', 'PERUSAHAAN')->pluck('allowances.name')->toArray() as $allowance)
                          <li><span class="badge bg-light-info">{{ $allowance }}</span></li>
                        @endforeach
                      @else
                        <li>Tidak ada tunjangan.</li>
                      @endif
                    </ul>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>

        <hr>

        <div class="col-12 d-flex justify-content-end mt-4">
          <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
          <a href="{{ route('position.index') }}" class="btn btn-light-secondary me-1 mb-1">Back</a>
        </div>
      </div>
    </div>
  </form>

</section>

@endsection
