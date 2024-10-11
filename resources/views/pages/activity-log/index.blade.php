@extends('layouts.app')

@section('title', 'Activity Log')
@section('content')
  <div class="page-heading">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>Activity Log</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
          <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
            <ol class="breadcrumb">
              {{-- <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li> --}}
              <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Activity Log</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>

  <section class="section">

    <div class="card">
      <div class="card-header">
        <h5 class="card-title">
          List of Activity log
        </h5>
      </div>
      <div class="card-body">
        <table class="table table-striped" id="log-table" style="font-size: 75%">
          <thead>
            <tr>
              <th class="text-center">#</th>
              <th class="text-center">Log Name</th>
              <th class="text-center">User</th>
              <th class="text-center">Description</th>
              <th class="text-center">Created At</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>
      <div class="viewmodal" style="display: none;"></div>
    </div>

  </section>

@endsection
@push('after-script')
  <script>
    jQuery(document).ready(function($) {
      $('#log-table').DataTable({
        processing: true,
        serverSide: true,
        ordering: true,
        pageLength: 10, // Show all records by default
        lengthMenu: [
          [10, 25, 50, 100, -1],
          [10, 25, 50, 100, 'All']
        ], // Add 'All' option to the length menu
        ajax: {
          url: "{{ route('activity-log.index') }}",
        },
        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false,
            width: '5%',
          },
          {
            data: 'log_name',
            name: 'log_name',
          },
          {
            data: 'causer',
            name: 'causer',
          },
          {
            data: 'description',
            name: 'description',
          },
          {
            data: 'created_at',
            name: 'created_at',
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

  <style>
    #mymodal {
      z-index: 1001;
      background-color: rgba(0, 0, 0, 0.5);
    }
  </style>
@endpush
