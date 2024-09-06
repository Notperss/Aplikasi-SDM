@extends('layouts.app')
@section('title', 'Permissions')
@section('content')

@section('breadcrumb')
  <x-breadcrumb title="Permission Management" page="Roles & Permissions" active="Permission Management"
    route="{{ route('permission.index') }}" />
@endsection
<!-- Content -->
<section class="section">
  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between align-items-center">
        <h4 class="fw-normal mb-0 text-body card-title">permissions list</h4>
        @can('permission.store')
          <button type="button" class="btn btn-primary btn-md " data-bs-toggle="modal"
            data-bs-target="#modal-form-add-permission">
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
              <th>Guard Name</th>
              <th>Assigned To</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            @foreach ($permissions as $permission)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $permission->name }}</td>
                <td>{{ $permission->guard_name }}</td>
                <td>
                  @foreach ($permission->roles as $role)
                    <span class="badge bg-light-info me-1">{{ $role->name }}</span>
                  @endforeach
                </td>
                <td>
                  <div class="demo-inline-spacing">

                    @can('permission.update')
                      <a data-bs-toggle="modal" data-bs-target="#modal-form-edit-permission-{{ $permission->id }}"
                        class="btn btn-icon btn-secondary text-white">
                        <i class="bi bi-pencil-square"></i>
                      </a>
                      @include('management-access.permission.modal-edit')
                    @endcan

                    @can('permission.destroy')
                      <a onclick="showSweetAlert('{{ $permission->id }}')" title="Delete"
                        class="btn btn-icon btn-danger text-white">
                        <i class="bi bi-x-square"></i>
                      </a>
                      <form id="deleteForm_{{ $permission->id }}"
                        action="{{ route('permission.destroy', $permission->id) }}" method="POST">
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

<!-- Add Role Modal -->
@include('management-access.permission.modal-create')
<!--/ Add Role Modal -->

</div>
<!-- / Content -->

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
