@extends('layouts.app')
@section('title', 'Users')
@section('content')

@section('breadcrumb')
  <x-breadcrumb title="User Management" page="Access Management" active="User Management" route="{{ route('user.index') }}" />
@endsection
<!-- Content -->
<section class="section">
  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between align-items-center ">
        <h4 class="fw-normal mb-0 text-body">Users</h4>
        @can('user.store')
          <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
            data-bs-target="#modal-form-add-user">
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
              <th>User</th>
              <th>Email</th>
              <th>Role</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            @foreach ($users as $user)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                  @foreach ($user->roles as $role)
                    <span class="badge bg-light-info me-1">{{ $role->name }}</span>
                  @endforeach
                </td>
                <td>
                  @if (!blank($user->email_verified_at))
                    <span class="badge bg-light-primary me-1">Active</span>
                  @else
                    <span class="badge bg-light-danger me-1">Inactive</span>
                  @endif
                </td>
                <td>
                  <div class="demo-inline-spacing">
                    @can('user.update')
                      <a data-bs-toggle="modal" data-bs-target="#modal-form-edit-user-{{ $user->id }}"
                        class="btn btn-icon btn-secondary text-white">
                        <i class="bi bi-pencil-square"></i>
                      </a>
                      @include('management-access.user.modal-edit')
                    @endcan

                    @can('user.destroy')
                      <a onclick="showSweetAlert('{{ $user->id }}')" title="Delete"
                        class="btn btn-icon btn-danger text-white">
                        <i class="bi bi-x-square"></i>
                      </a>
                      <form id="deleteForm_{{ $user->id }}" action="{{ route('user.destroy', $user->id) }}"
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
@include('management-access.user.modal-create')

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
@endsection
