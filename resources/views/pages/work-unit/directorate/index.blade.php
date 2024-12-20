@extends('layouts.app')
@section('title', 'Direktorat')
@section('content')

@section('breadcrumb')
  <x-breadcrumb title="Direktorat" page="Unit Kerja" active="Direktorat" route="{{ route('directorate.index') }}" />
@endsection

<section class="section">
  <section class="section">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between align-items-center ">
          <h5 class="fw-normal mb-0 text-body">Daftar Direktorat</h5>

          <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
            data-bs-target="#modal-form-add-directorate">
            <i class="bi bi-plus-lg"></i>
            Direktorat
          </button>

        </div>
      </div>
      <div class="card-body">
        <table class="table table-striped" id="table1" style="font-size: 85%">
          <thead>
            <tr>
              <th>#</th>
              <th>Kode</th>
              <th>Direktorat</th>
              <th>type</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($directorates as $directorate)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $directorate->code }}</td>
                <td>{{ $directorate->name }}</td>
                <td>
                  @if ($directorate->is_non == 1)
                    <span class="badge bg-light-primary">Direktorat</span>
                  @elseif ($directorate->is_non == 2)
                    <span class="badge bg-light-info">Non-Direktorat</span>
                  @else
                    <span class="badge bg-light-warning">Lain-lain</span>
                  @endif
                </td>
                <td>

                  <div class="d-flex justify-content-end mt-2">
                    <a data-bs-toggle="modal" data-bs-target="#modal-form-edit-directorate-{{ $directorate->id }}"
                      class="btn btn-icon btn-secondary text-white">
                      <i class="bi bi-pencil-square"></i>
                    </a>
                    @include('pages.work-unit.directorate.modal-edit')

                    <button class="btn btn-light-danger mx-2" onclick="showSweetAlert('{{ $directorate->id }}')">
                      <i class="bi bi-trash"></i>
                    </button>

                    <form id="deleteForm_{{ $directorate->id }}"
                      action="{{ route('directorate.destroy', $directorate->id) }}" method="POST">
                      @method('DELETE')
                      @csrf
                    </form>
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

  @include('pages.work-unit.directorate.modal-create')

@endsection
