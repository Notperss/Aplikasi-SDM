@extends('layouts.app')
@section('title', 'Nomor Box')
@section('content')

@section('breadcrumb')
  <x-breadcrumb title="Nomor Box" page="Folder Divisi" active="Nomor Box" route="{{ route('boxNumber.index') }}" />
@endsection

<section class="section">
  <section class="section">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between align-items-center ">
          <h5 class="fw-normal mb-0 text-body">Daftar Nomor Box</h5>

          <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
            data-bs-target="#modal-form-add-boxNumber">
            <i class="bi bi-plus-lg"></i>
            Nomor Box
          </button>

        </div>
      </div>
      <div class="card-body">
        <table class="table table-striped" id="table1" style="font-size: 85%">
          <thead>
            <tr>
              <th>#</th>
              <th>Nomor Box</th>
              <th>Deskripsi</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($boxNumbers as $boxNumber)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $boxNumber->box_number }}</td>
                <td>{{ $boxNumber->description }}</td>
                <td>
                  <div class="d-flex justify-content-end mt-2">
                    <button class="btn btn-primary btn-sm mx-1"
                      onclick="printSingleBox('{{ $boxNumber->box_number }}', '{{ $boxNumber->description }}')">
                      <i class="bi bi-printer"></i> Cetak
                    </button>

                    <a data-bs-toggle="modal" data-bs-target="#modal-form-edit-boxNumber-{{ $boxNumber->id }}"
                      class="btn btn-icon btn-secondary text-white">
                      <i class="bi bi-pencil-square"></i>
                    </a>

                    @include('pages.folder-division.box-number.modal-edit')

                    <button class="btn btn-light-danger mx-2" onclick="showSweetAlert('{{ $boxNumber->id }}')">
                      <i class="bi bi-trash"></i>
                    </button>

                    <form id="deleteForm_{{ $boxNumber->id }}" action="{{ route('boxNumber.destroy', $boxNumber->id) }}"
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
    function printSingleBox(boxNumber, description) {
      let printContent = `
            <div style="
                width: 300px;
                padding: 20px;
                margin-left: 10px;
                text-align: center;
                border: 2px solid black;
                border-radius: 10px;
                font-family: Arial, sans-serif; ">

                <p style="font-size: 18px; font-weight: bold; margin-bottom: 5px; font-size:125%;">${boxNumber}</p>
                <hr style="border: 1px solid black; margin: 10px 0;">
                <p style="font-size: 14px; color: #333;">${description}</p>
            </div>
        `;

      let originalContents = document.body.innerHTML;
      document.body.innerHTML = printContent;
      window.print();
      document.body.innerHTML = originalContents;
      location.reload(); // Reload agar tampilan kembali normal setelah cetak
    }
  </script>

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

  @include('pages.folder-division.box-number.modal-create')

@endsection
