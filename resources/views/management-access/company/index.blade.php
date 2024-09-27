@extends('layouts.app')
@section('title', 'Company')
@section('content')

@section('breadcrumb')
  <x-breadcrumb title="Company" page="Access Management" active="Company" route="{{ route('company.index') }}" />
@endsection
<!-- Content -->
<section class="section">
  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between align-items-center ">
        <h4 class="fw-normal mb-0 text-body">Company</h4>
        @can('company.store')
          <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
            data-bs-target="#modal-form-add-company">
            <i class="bi bi-plus-lg"></i>
            Add
          </button>
        @endcan

      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive text-nowrap mx-2">
        <table class="table" id="table1">
          <thead>
            <tr>
              <th>#</th>
              <th>Nama</th>
              <th>Alamat</th>
              <th>Deskripsi</th>
              <th>Logo</th>
              <th></th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            @foreach ($companies as $company)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $company->name }}</td>
                <td>{{ $company->address }}</td>
                <td>{{ $company->description }}</td>
                <td class="text-center">
                  @if ($company->logo)
                    <img src="{{ asset('storage/' . ($company->logo ?? '')) }}" alt="Logo" width="60px">
                  @else
                    no image
                  @endif
                </td>
                <td>
                  <div class="demo-inline-spacing">
                    @can('company.update')
                      <a data-bs-toggle="modal" data-bs-target="#modal-form-edit-company-{{ $company->id }}"
                        class="btn btn-icon btn-secondary text-white">
                        <i class="bi bi-pencil-square"></i>
                      </a>
                      @include('management-access.company.modal-edit')
                    @endcan

                    @can('company.destroy')
                      <a onclick="showSweetAlert('{{ $company->id }}')" title="Delete"
                        class="btn btn-icon btn-danger text-white">
                        <i class="bi bi-x-square"></i>
                      </a>
                      <form id="deleteForm_{{ $company->id }}" action="{{ route('company.destroy', $company->id) }}"
                        method="POST">
                        @method('DELETE')
                        @csrf
                      </form>
                    @endcan
                  </div>

                </td>
              </tr>
            @endforeach

          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
<!-- / Content -->

<!--/ Basic Bootstrap Table -->
@include('management-access.company.modal-create')

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
        // If the company clicks "Yes, delete it!", submit the corresponding form
        document.getElementById('deleteForm_' + getId).submit();
      }
    });
  }
</script>
@endsection
