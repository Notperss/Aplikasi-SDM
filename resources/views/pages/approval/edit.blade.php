@extends('layouts.app')
@section('title', 'Kontrak')
@section('content')

@section('breadcrumb')
  <x-breadcrumb title="Tambah Catatan" page="Persetujuan" active="Edit" route="{{ route('approval.index') }}" />
@endsection

<section class="section">
  <form action="{{ route('approval.updateStatus', encrypt($approval->id)) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="card">
      <div class="card-header">
      </div>
      <div class="card-body">
        <div class="row justify-content-center">
          <div class="col-md-11"> <!-- Make form smaller with col-md-6 and center it -->


            <div class="col-md-6">
              <div class="mb-2">
                {{-- <label class="form-label" for="contract_number">Divisi</label> --}}
                @php
                  // Prepare status and approval badge
                  $status =
                      '<span class="badge bg-primary mb-1" style="font-size: 150%">' .
                      $approval->description .
                      '</span>';

                  if ($approval->is_approve === 1) {
                      $appr = '<span class="badge bg-success" style="font-size: 150%">Disetujui</span>';
                  } elseif ($approval->is_approve === 0) {
                      $appr = '<span class="badge bg-danger" style="font-size: 150%">Ditolak</span>';
                  } else {
                      $appr = '<span class="badge bg-secondary" style="font-size: 150%">Pending</span>';
                  }
                @endphp
                {!! $status !!} {!! $appr !!}
                @error('contract_number')
                  <a style="color: red"><small>{{ $message }}</small></a>
                @enderror
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="my-2">
                  <label class="form-label" for="contract_number">NIK</label>
                  <input id="contract_number"
                    value="{{ $item->employeeCareer->employee->nik ?? ($item->employee->nik ?? '-') }}"
                    class="form-control @error('contract_number') is-invalid @enderror" readonly>
                  @error('contract_number')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>
              </div>

              <div class="col-md-6">
                <div class="my-2">
                  <label class="form-label" for="contract_number">Nama Lengkap</label>
                  <input id="contract_number"
                    value="{{ $approval->selectedCandidate->candidate->name ??
                        ($approval->employeeCareer->employee->name ?? $approval->employee->name) }}"
                    class="form-control @error('contract_number') is-invalid @enderror" readonly>
                  @error('contract_number')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>
              </div>

              <div class="col-md-6">
                <div class="my-2">
                  <label class="form-label" for="contract_number">Jabatan</label>
                  <input id="contract_number" value="{{ $approval->position_id ? $approval->position->name : '-' }}"
                    class="form-control @error('contract_number') is-invalid @enderror" readonly>
                  @error('contract_number')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>
              </div>

              <div class="col-md-6">
                <div class="my-2">
                  <label class="form-label" for="contract_number">Divisi</label>
                  <input id="contract_number"
                    value="{{ $approval->position_id ? $approval->position->division->name : '-' }}"
                    class="form-control @error('contract_number') is-invalid @enderror" readonly>
                  @error('contract_number')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>
              </div>

              <div class="col-md-6">
                <div class="my-2">
                  <label class="form-label" for="contract_number">Dibuat</label>
                  <input id="contract_number"
                    value="{{ $approval->created_at ? Carbon\Carbon::parse($approval->created_at)->translatedFormat('d-m-Y') : '-' }}"
                    class="form-control @error('contract_number') is-invalid @enderror" readonly>
                  @error('contract_number')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="my-2">
                  <label class="form-label" for="note">Catatan</label>
                  <textarea id="note" name="note" class="form-control @error('note') is-invalid @enderror" rows="5"> {{ $approval->note ? $approval->note : '' }}</textarea>
                  @error('note')
                    <a style="color: red"><small>{{ $message }}</small></a>
                  @enderror
                </div>
              </div>
            </div>




          </div>
        </div>
        <div class="col-12 d-flex justify-content-end mt-4">
          <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
          <button type="button" class="btn btn-light-secondary me-1 mb-1" onclick="window.history.back();">
            Back
          </button>

        </div>
      </div>
    </div>

  </form>

</section>
@endsection
