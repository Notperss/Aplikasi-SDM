@extends('layouts.app')
@section('title', 'Tunjangan')
@section('content')

@section('breadcrumb')
  <x-breadcrumb title="Tunjangan" page="Unit Kerja" active="Tunjangan" route="{{ route('allowance.index') }}" />
@endsection

<section class="section">
  <section class="section">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between align-items-center ">
          <h5 class="fw-normal mb-0 text-body">Daftar Tunjangan</h5>

          <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
            data-bs-target="#modal-form-add-allowance">
            <i class="bi bi-plus-lg"></i>
            Tunjangan
          </button>

        </div>
      </div>
      <div class="card-body">
        <table class="table table-striped" id="table1" style="font-size: 85%">
          <thead>
            <tr>
              <th>#</th>
              <th>Tunjangan</th>
              <th>Tipe</th>
              <th>Tipe Tunj. Perusahaan</th>
              <th>Level</th>
              <th>Jumlah</th>
              <th>Deskripsi</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($allowances as $allowance)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $allowance->name }}</td>
                <td>{{ $allowance->type }}</td>
                <td>{{ $allowance->natura ?? '-' }}</td>
                <td>{{ $allowance->level->name }}</td>
                <td>Rp. {{ number_format($allowance->amount, 0, ',', '.') }}</td>
                <td>{{ $allowance->description }}</td>
                <td>
                  <div class="d-flex justify-content-end mt-2">
                    <a data-bs-toggle="modal" data-bs-target="#modal-form-edit-allowance-{{ $allowance->id }}"
                      class="btn btn-icon btn-secondary text-white">
                      <i class="bi bi-pencil-square"></i>
                    </a>
                    @include('pages.position.allowance.modal-edit')

                    <button class="btn btn-light-danger mx-2" onclick="showSweetAlert('{{ $allowance->id }}')">
                      <i class="bi bi-trash"></i>
                    </button>

                    <form id="deleteForm_{{ $allowance->id }}"
                      action="{{ route('allowance.destroy', $allowance->id) }}" method="POST">
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

  @include('pages.position.allowance.modal-create')

@endsection
