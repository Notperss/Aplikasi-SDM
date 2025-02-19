@extends('layouts.app')
@section('title', 'Folder Division')
@section('content')


  <section class="section">

    <button type="button" class="btn btn-primary btn-md my-2" data-bs-toggle="modal" data-bs-target="#modal-form-add-folder">
      <i class="bi bi-plus-lg"></i>
      Add Folder
    </button>


    <div class="row">
      @forelse ($folders as $folder)
        <div class="col-6 col-lg-3 col-md-6">
          <div class="card">

            <div class="container d-flex justify-content-between">
              @if ($folder->is_lock == false)
                @can('folder-division.edit-destroy-lock')
                  <a href="#" onclick="showSweetAlert({{ $folder->id }})" title="Delete folder">
                    <i class="bi bi-x"></i>
                  </a>

                  <a data-bs-toggle="modal" data-bs-target="#modal-form-edit-menu-{{ $folder->id }}" class="ms-auto"
                    title="Edit folder"> <i class="bi bi-three-dots"></i></a>
                  @include('pages.folder-division.edit')

                  <form id="deleteForm_{{ $folder->id }}" action="{{ route('folder.destroy', $folder->id) }}"
                    method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                  </form>

                  <a href="{{ route('lockFolder', $folder->id) }}" class="position-absolute"
                    style="bottom: 10px; right: 10px;" title="Kunci Folder"
                    onclick="return confirm('Apakah anda yakin mengunci folder?')">
                    <i class="bi bi-unlock"></i>
                  </a>
                @endcan
              @else
                @role('super-admin')
                  <a href="{{ route('lockFolder', $folder->id) }}" class="position-absolute"
                    style="bottom: 10px; right: 10px;" title="Buka Folder"
                    onclick="return confirm('Apakah anda yakin membuka folder?')">
                    <i class="bi bi-lock"></i>
                  </a>
                @else
                  <a href="#" class="position-absolute" style="bottom: 10px; right: 10px;" title="Buka Folder"
                    onclick="alert('Hubungi Administrator untuk membuka kunci!')">
                    <i class="bi bi-lock"></i>
                  </a>
                @endrole
              @endif

            </div>

            <a href="{{ route('folder.show', $folder->id ?? $folders->id) }}">
              <div class="card-body d-flex align-items-center">
                <div class="stats-icon red me-2 col-1"> <!-- Added margin to the right -->
                  <!--?xml version="1.0" encoding="UTF-8"?-->
                  <svg id="Folder" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <title>{{ $folder->name }}</title>
                    <g id="Iconly/Bulk/Folder" stroke="none" stroke-width="1.5" fill="none" fill-rule="evenodd">
                      <g id="Folder" transform="translate(2.000000, 2.000000)" fill="#000000" fill-rule="nonzero">
                        <path
                          d="M14.8843323,3.11484513 L11.9412555,3.11484513 C11.2080743,3.11969094 10.5119831,2.79355206 10.0473723,2.22750605 L9.07820198,0.887624037 C8.62136927,0.31661331 7.92529647,-0.0110552829 7.19321021,0.000284957392 L5.11260609,0.000284957392 C1.37818844,0.000284957392 0,2.19201248 0,5.91883662 L0,9.94735606 C-0.00463617276,10.3903837 19.9956459,10.3898196 19.9969279,9.94735606 L19.9969279,8.77606845 C20.0147108,5.04924432 18.6720988,3.11484513 14.8843323,3.11484513 Z"
                          id="Folder-2" opacity="0.400000006"></path>
                        <path
                          d="M14.8754408,3.11484513 C16.1802327,3.01393322 17.4752961,3.40673057 18.5031608,4.21514559 C18.621539,4.31552489 18.7315614,4.42532357 18.8321452,4.54346104 C19.1520715,4.91754096 19.3993274,5.34785435 19.5612458,5.81235593 C19.8798358,6.76703956 20.0273193,7.77029104 19.9969279,8.77606845 L19.9969279,8.77606845 L19.9969279,14.0291158 C19.9956459,14.4715793 19.9629621,14.9133965 19.8991217,15.351251 C19.7775415,16.1239787 19.5056946,16.8655159 19.0988893,17.5341052 C18.9119086,17.8570558 18.6848671,18.1551872 18.4231376,18.4214442 C17.2383174,19.5088523 15.6649665,20.0748744 14.0574255,19.9920344 L14.0574255,19.9920344 L5.93062139,19.9920344 C4.32050324,20.0742686 2.74462362,19.5084891 1.55601786,18.4214442 C1.2974126,18.1546676 1.07337551,17.8565589 0.889157562,17.5341052 C0.484759175,16.8659959 0.218698886,16.1237488 0.106708149,15.351251 C0.0354980265,14.9141289 9.54911799e-06,14.4719769 9.54911799e-06,14.0291158 L9.54911799e-06,14.0291158 L9.54911799e-06,8.77606845 C9.54911799e-06,8.33735101 0.0235818457,7.89894905 0.0711422669,7.46280662 C0.0978166787,7.25871863 0.160056973,7.06350403 0.160056973,6.86828943 C0.250315474,6.34196459 0.414967564,5.8310872 0.649087856,5.35093961 C1.34262256,3.86908334 2.76525786,3.11484513 5.09482315,3.11484513 L5.09482315,3.11484513 Z M15.1155105,11.8906286 L4.97034256,11.8906286 C4.51365457,11.8906286 4.1434358,12.2600946 4.1434358,12.715854 C4.1434358,13.1716133 4.51365457,13.5410793 4.97034256,13.5410793 L4.97034256,13.5410793 L15.0532702,13.5410793 C15.2741185,13.550676 15.4896225,13.471626 15.6516714,13.321577 C15.8137204,13.171528 15.9088212,12.962974 15.9157429,12.7424741 C15.9282326,12.5486632 15.8644288,12.3576409 15.7379135,12.2100707 C15.5923887,12.011764 15.3617941,11.8934137 15.1155105,11.8906286 L15.1155105,11.8906286 Z">
                        </path>
                      </g>
                    </g>
                  </svg>
                </div>
                <div class="folder-name">
                  <h6 class="text-muted font-semibold" style="font-size: 80%">
                    {{ $folder->name ?? $folders->name }}
                  </h6>
                </div>
              </div>
            </a>
          </div>
        </div>
      @empty
        <div class="container">
          <div class="card">
            <div class="card-body text-center">
              <h6 class="font-extrabold mb-0">
                Folder Empty
              </h6>
            </div>
          </div>
        </div>
      @endforelse
    </div>

    <div class="row">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title">Notification</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped" id="table1">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">Nomor</th>
                  <th class="text-center">Tanggal Notifikasi</th>
                  <th class="text-center">Pengingat</th>
                  <th class="text-center">Keterangan</th>
                  <th class="text-center">Folder</th>
                  {{-- <th class="text-center">File</th> --}}
                  {{-- <th class="text-center">Action</th> --}}
                </tr>
              </thead>
              <tbody>
                @foreach ($notifications as $notif)
                  <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $notif->number ?? 'N/A' }}</td>
                    <td class="text-center">
                      {{ Carbon\Carbon::parse($notif->date_notifikasi)->translatedFormat('l, d F Y') ?? 'N/A' }}
                    </td>
                    <td class="text-center">{{ $notif->notification ?? 'N/A' }}</td>
                    <td class="text-center">{{ $notif->description ?? 'N/A' }}</td>
                    <td class="text-center">
                      @if ($notif->folder->ancestors->count() > 3)
                        .../
                      @endif
                      @forelse ($notif->folder->ancestors->slice(-3) as $ancestor)
                        <small>{{ $ancestor->name }}</small> /
                      @empty
                      @endforelse
                      <strong>
                        <a href="{{ route('folder.show', $notif->folder->id) }}">{{ $notif->folder->name }}</a>
                      </strong>
                    </td>
                    {{-- <td class="text-center"><a type="button" href="{{ asset('storage/' . $file->file) }}"
                      class="btn btn-warning btn-sm text-white " download>Unduh</a>
                    <p class="mt-1"><small>{{ pathinfo($file->file, PATHINFO_FILENAME) }}</small></p>
                  </td> --}}
                    {{-- <td class="text-center">Action</td> --}}
                    {{-- <td class="text-center">
                    @foreach ($file->ancestors as $ances)
                      {{ $ances->name }},
                    @endforeach
                  </td> --}}
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        <div class="viewmodal" style="display: none;"></div>
      </div>
    </div>

    <div class="row">
      <!--Recent-->
      <div class="card">
        <div class="card-header">
          <h5 class="card-title">Recent File</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped" id="table1">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">Nomor</th>
                  <th class="text-center">Tanggal</th>
                  <th class="text-center">Keterangan</th>
                  <th class="text-center">Folder</th>
                  {{-- <th class="text-center">File</th> --}}
                  {{-- <th class="text-center">Action</th> --}}
                </tr>
              </thead>
              <tbody>
                @foreach ($folderFiles as $file)
                  <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $file->number ?? 'N/A' }}</td>
                    <td class="text-center">
                      {{ Carbon\Carbon::parse($file->date)->translatedFormat('l, d F Y') ?? 'N/A' }}
                    </td>
                    <td class="text-center">{{ $file->description ?? 'N/A' }}</td>
                    <td class="text-center">
                      @if ($file->folder->ancestors->count() > 3)
                        .../
                      @endif
                      @forelse ($file->folder->ancestors->slice(-3) as $ancestor)
                        <small>{{ $ancestor->name }}</small> /
                      @empty
                      @endforelse
                      <strong>
                        <a href="{{ route('folder.show', $file->folder->id) }}">{{ $file->folder->name }}</a>
                      </strong>
                    </td>
                    {{-- <td class="text-center"><a type="button" href="{{ asset('storage/' . $file->file) }}"
                      class="btn btn-warning btn-sm text-white " download>Unduh</a>
                    <p class="mt-1"><small>{{ pathinfo($file->file, PATHINFO_FILENAME) }}</small></p>
                  </td> --}}
                    {{-- <td class="text-center">Action</td> --}}
                    {{-- <td class="text-center">
                    @foreach ($file->ancestors as $ances)
                      {{ $ances->name }},
                    @endforeach
                  </td> --}}
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        <div class="viewmodal" style="display: none;"></div>
      </div>
    </div>

    @include('pages.folder-division.add-folder')

    {{-- <div class="modal fade" data-backdrop="false" id="modal-form-add-folder" tabindex="-1" dialog>
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Folder</h5>
            <button class="btn close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form class="form" method="POST" action="{{ route('folder.store') }}" enctype="multipart/form-data"
            id="myForm">
            @csrf
            <div class="modal-body">
              <div class="row">
                <div class="form-group">
                  <label for="basicInput">Nama Folder <code style="color:red;">*</code></label>
                  <input type="text" class="form-control" id="basicInput" name="name" placeholder="name"
                    required>
                </div>
                <div class="form-group">
                  <label for="basicInput">Keterangan</label>
                  <textarea type="text" class="form-control" id="basicInput" name="description" placeholder="description"></textarea>
                </div>

                <div class="form-group">
                  <label for="helperText">Parent</label>
                  <select type="text" id="helperText" class="form-control" name="parent">
                    <option value="none">No Parent</option>
                    @foreach ($folders as $folder)
                      <option value="{{ $folder->id }}">{{ $folder->name }}</option>
                    @endforeach
                  </select>
                  <p><small class="text-muted">Find helper text here for given textbox.</small></p>
                </div>

              </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
              <button class="btn btn-warning" style="width:120px;" type="button" data-dismiss="modal"
                aria-label="Close">
                Close
              </button>
              <button type="submit" style="width:120px;" class="btn btn-info">Submit</button>
            </div>
          </form>

        </div>
      </div>
    </div> --}}

  </section>

@endsection

@push('after-script')
  <script>
    function showSweetAlert(folderId) {
      Swal.fire({
        title: 'Are you sure?',
        html: 'Jika menghapus folder, semua data di dalamnya akan terhapus!<br><small class="text-danger">Pastikan folder kosong sebelum dihapus!</small>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          // If the user clicks "Yes, delete it!", submit the corresponding form
          document.getElementById('deleteForm_' + folderId).submit();
        }
      });
    }
  </script>

  {{-- <script>
    jQuery(document).ready(function($) {
      $('#container-table').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        lengthMenu: [
          [10, 25, 50, -1],
          [10, 25, 50, 'All']
        ],
        lengthChange: true,
        pageLength: 15,
        dom: 'Bfrtip',
        buttons: [{
            extend: 'copy',
            className: "btn btn-info"
          },
          {
            extend: 'excel',
            className: "btn btn-info"
          },
          {
            extend: 'print',
            className: "btn btn-info",
            exportOptions: {
              columns: ':not(.no-print)' // Exclude elements with class 'no-print'
            }
          },
        ],
        ajax: {
          url: "{{ route('archive-container.index') }}",
        },

        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false,
            width: '5%',
          },
          {
            data: 'number_container',
            name: 'number_container',
          },
          {
            data: 'number_document',
            name: 'number_document',
          },
          {
            data: 'regarding',
            name: 'regarding',
          },
          {
            data: 'division.name',
            name: 'division.name',
          },
          {
            data: 'detail_location',
            name: 'detail_location',
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
  <script>
    function upload() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $.ajax({
        type: "get",
        url: "{{ route('form_upload') }}",
        dataType: "json",
        success: function(response) {
          $('.viewmodal').html(response.data).show();
          $('#modalupload').modal('show');
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      });
    }

    jQuery(document).ready(function($) {
      console.log('Document is ready');

      $('#mymodal').on('show.bs.modal', function(e) {
        var button = $(e.relatedTarget);
        var modal = $(this);

        modal.find('.modal-body').load(button.data("remote"));
        modal.find('.modal-title').html(button.data("title"));
      });
    });
  </script>
  <div class="modal fade" data-backdrop="false" id="mymodal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
          <button class="btn close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <i class="fa fa-spinner fa spin"></i>
        </div>
        <div style="text-align: right;">
          <button class="btn btn-warning mb-2 mx-2" style="width: 10%" type="button" data-dismiss="modal"
            aria-label="Close">
            Close
          </button>
        </div>
      </div>
    </div>
  </div> --}}

  <style>
    #mymodal {
      z-index: 1001;
      background-color: rgba(0, 0, 0, 0.5);
    }
  </style>
@endpush
