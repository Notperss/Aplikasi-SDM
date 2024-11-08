@extends('layouts.app')
@section('title', 'Jabatan')
@section('content')

@section('breadcrumb')
  <x-breadcrumb title="Jabatan" page="Position" active="Jabatan" route="{{ route('position.index') }}" />
@endsection

<section class="section">
  <section class="section">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between align-items-center ">
          <h5 class="fw-normal mb-0 text-body">Daftar Jabatan</h5>

          <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
            data-bs-target="#modal-form-add-position">
            <i class="bi bi-plus-lg"></i>
            Jabatan
          </button>

        </div>
      </div>
      <div class="card-body">
        <table class="table table-striped" id="position-table" style="font-size: 85%; width: 100%">
          <thead>
            <tr>
              <th>#</th>
              <th>Jabatan</th>
              <th>Level</th>
              <th>Direktorat</th>
              <th>Divisi</th>
              <th>Departmen</th>
              <th>Seksi</th>
              <th>Deskripsi</th>
              <th></th>
            </tr>
          </thead>

          {{-- <tbody>
            @foreach ($positions as $position)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $position->name }}</td>
                <td>{{ $position->level->name ?? '-' }}</td>
                <td>{{ $position->directorate->code ?? '-' }}</td>
                <td>{{ $position->division->code ?? '-' }}</td>
                <td>{{ $position->department->name ?? '-' }}</td>
                <td>{{ $position->section->name ?? '-' }}</td>

                <td>{{ $position->description }}</td>
                <td>
                  <div class="d-flex justify-content-end mt-2">
                    <a data-bs-toggle="modal" data-bs-target="#modal-form-position-allowance-{{ $position->id }}"
                      class="btn btn-sm btn-icon btn-light-primary " title="tunjangan">
                      <i class="bi bi-wallet-fill"></i>
                    </a>
                    @include('pages.position.position.modal-add-allowance')

                    <a data-bs-toggle="modal" data-bs-target="#modal-form-edit-position-{{ $position->id }}"
                      class="btn btn-sm btn-icon btn-secondary text-white mx-2" title="edit">
                      <i class="bi bi-pencil-square"></i>
                    </a>
                    @include('pages.position.position.modal-edit')

                    <button class="btn btn-sm btn-light-danger mr-2" onclick="showSweetAlert('{{ $position->id }}')"
                      title="hapus">
                      <i class="bi bi-trash"></i>
                    </button>

                    <form id="deleteForm_{{ $position->id }}" action="{{ route('position.destroy', $position->id) }}"
                      method="POST">
                      @method('DELETE')
                      @csrf
                    </form>
                  </div>

                </td>
              </tr>
            @endforeach
          </tbody> --}}
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

  @include('pages.position.position.modal-create')

@endsection

@push('after-script')
  <script>
    jQuery(document).ready(function($) {
      $('#position-table').DataTable({
        processing: true,
        serverSide: true,
        ordering: true,
        pageLength: 10, // Show all records by default
        lengthMenu: [
          [10, 25, 50, 100, -1],
          [10, 25, 50, 100, 'All']
        ], // Add 'All' option to the length menu
        ajax: {
          url: "{{ route('position.index') }}",
        },
        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false,
            width: '5%',
          },
          {
            data: 'name',
            name: 'name',
          },
          {
            data: 'level.name',
            name: 'level.name',
          },
          {
            data: 'division.directorate.name',
            name: 'division.directorate.name',
          },
          {
            data: 'division.name',
            name: 'division.name',
          },
          {
            data: 'department',
            name: 'department',
            orderable: false,
            searchable: false,
          },
          {
            data: 'section',
            name: 'section',
            orderable: false,
            searchable: false,
          },
          {
            data: 'description',
            name: 'description',
          },
          {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false,
            className: 'no-print' // Add this class to exclude the column from printing
          },
        ],
        columnDefs: [{
          className: 'text-center',
          targets: '_all'
        }, ],
      });
    });
  </script>
@endpush
