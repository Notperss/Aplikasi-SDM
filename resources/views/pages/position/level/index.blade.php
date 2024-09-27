@extends('layouts.app')
@section('title', 'Level')
@section('content')

@section('breadcrumb')
  <x-breadcrumb title="Level" page="Jabatan" active="Level" route="{{ route('level.index') }}" />
@endsection

<section class="section">
  <section class="section">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between align-items-center ">
          <h5 class="fw-normal mb-0 text-body">Daftar Level</h5>

          <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
            data-bs-target="#modal-form-add-level">
            <i class="bi bi-plus-lg"></i>
            Level
          </button>

        </div>
      </div>
      <div class="card-body">
        <table class="table table-striped" id="table1" style="font-size: 85%">
          <thead>
            <tr>
              <th>#</th>
              <th>Level</th>
              <th>Deskripsi</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($levels as $level)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $level->name }}</td>
                <td>{{ $level->description }}</td>
                <td>

                  <div class="d-flex justify-content-end mt-2">
                    <a data-bs-toggle="modal" data-bs-target="#modal-form-edit-level-{{ $level->id }}"
                      class="btn btn-icon btn-secondary text-white">
                      <i class="bi bi-pencil-square"></i>
                    </a>
                    @include('pages.position.level.modal-edit')

                    <button class="btn btn-light-danger mx-2" onclick="showSweetAlert('{{ $level->id }}')">
                      <i class="bi bi-trash"></i>
                    </button>

                    <form id="deleteForm_{{ $level->id }}" action="{{ route('level.destroy', $level->id) }}"
                      method="POST">
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

  @include('pages.position.level.modal-create')

@endsection
