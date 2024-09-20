@extends('layouts.app')
@section('title', 'Pelamar')
@section('content')

@section('breadcrumb')
  <x-breadcrumb title="Pelamar" page="Recruitment" active="Pelamar" route="{{ route('candidate.index') }}" />
@endsection

<section class="section">
  <section class="section">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between align-items-center ">
          <h5 class="fw-normal mb-0 text-body">Daftar Pelamar</h5>
          @can('route.store')
            {{-- <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
              data-bs-target="#modal-form-add-candidate">
              <i class="bi bi-plus-lg"></i>
              Add Candidate
            </button> --}}
            <a href="{{ route('candidate.create') }}" class="btn btn-primary btn-md">
              <i class="bi bi-plus-lg"></i>
              Pelamar</a>
          @endcan
        </div>
      </div>
      <div class="card-body">
        <table class="table table-striped" id="table1" style="font-size: 85%">
          <thead>
            <tr>
              <th></th>
              <th>Pelamar</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Date Applied</th>
              {{-- <th>Status</th> --}}
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($candidates as $candidate)
              <tr>
                <td class="text-center">
                  @if ($candidate->photo)
                    <img src="{{ asset('storage/' . $candidate->photo) }}" alt="Icon User" width="100px">
                  @else
                    No Image
                  @endif
                </td>
                <td>{{ $candidate->name }}</td>
                <td>{{ $candidate->email }}</td>
                <td>{{ $candidate->phone_number }}</td>
                <td>{{ Carbon\Carbon::parse($candidate->created_at)->translatedFormat('d F Y') }}</td>
                {{-- <td>
                  <span class="badge bg-success">Hire</span>
                </td> --}}
                <td>
                  <div class="btn-group mb-1">
                    <div class="dropdown">
                      <button class="btn btn-primary dropdown-toggle me-1" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{ route('additional-details', $candidate) }}">Kelengkapan
                          Data</a>
                        <a class="dropdown-item" href="{{ route('candidate.show', $candidate) }}">Lihat</a>
                        <a class="dropdown-item" href="{{ route('candidate.edit', $candidate) }}">Edit</a>
                        <a class="dropdown-item" href="#"
                          onclick="showSweetAlert('{{ $candidate->id }}')">Hapus</a>

                        <form id="deleteForm_{{ $candidate->id }}"
                          action="{{ route('candidate.destroy', $candidate->id) }}" method="POST">
                          @method('DELETE')
                          @csrf
                        </form>
                      </div>
                    </div>
                  </div>

                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </section>
  <script>
    function showSweetAlert(getId) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          // If the user clicks "Yes, delete it!", submit the corresponding form
          document.getElementById('deleteForm_' + getId).submit();
        }
      });
    }
  </script>

  {{-- @include('pages.recruitment.candidate.modal-create') --}}

@endsection
