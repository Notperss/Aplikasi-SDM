<div class="col-md-12 mt-4">
  {{-- <div class="card" style="background-color: #d1141411;" #a3b3e63d > --}}
  <div class="card" style="background-color: #a3b3e626;">
    <div class="card-content">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center ">
          <h4 class="card-title">Data Keluarga</h4>
          <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
            data-bs-target="#modal-form-add-family-details">
            <i class="bi bi-plus-lg"></i>
            Add
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- <div class="row">
  @foreach ($familyDetails as $familyDetail)
    <div class="col-xl-6 col-md-6 col-sm-12">
      <div class="card" style="background-color:  #a3b3e626;">
        <div class="card-content">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center ">
              <h5 class="card-title">{{ $familyDetail->name }}<span style="color: red">
                  @if ($familyDetail->gender == 'LAKI-LAKI')
                    (L)
                  @elseif ($familyDetail->gender == 'PEREMPUAN')
                    (P)
                  @else
                    N/A
                  @endif
                  </spans>
              </h5>
              <span class="badge bg-light-secondary">{{ $familyDetail->relation }}</span>
            </div>
            <hr>
            <div class="table-responsive" style="font-size: 85%">
              <table class="table table-borderless">
                <tbody>
                  <tr>
                    <th class="p-1">Tgl Lahir</th>
                    <td class="p-1">: {{ Carbon\Carbon::parse($familyDetail->dob)->translatedFormat('d F Y') }}
                    </td>
                  </tr>
                  <tr>
                    <th class="p-1">No. Telepon</th>
                    <td class="p-1">: {{ $familyDetail->phone_number }}</td>
                  </tr>
                  <tr>
                    <th class="p-1">Pendidikan</th>
                    <td class="p-1">: {{ $familyDetail->education }}</td>
                  </tr>
                  <tr>
                    <th class="p-1">Pekerjaan</th>
                    <td class="p-1">: {{ $familyDetail->job }}</td>
                  </tr>
                  <tr>
                    <th class="p-1">Alamat</th>
                    <td class="p-1">: {{ $familyDetail->address }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="d-flex justify-content-end">
              <a data-bs-toggle="modal" data-bs-target="#modal-form-edit-family-details-{{ $familyDetail->id }}"
                class="btn btn-icon btn-secondary text-white">
                <i class="bi bi-pencil-square"></i>
              </a>
              @include('pages.recruitment.family-details.modal-edit')

              <button class="btn btn-light-danger mx-2" onclick="deleteFamilyDetail('{{ $familyDetail->id }}')"><i
                  class="bi bi-trash"></i></button>

              <form id="deleteFamilyDetailForm_{{ $familyDetail->id }}"
                action="{{ route('familyDetails.destroy', $familyDetail->id) }}" method="POST">
                @method('DELETE')
                @csrf
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endforeach
</div> --}}

<div class="row">
  <!-- Table with outer spacing -->
  <div class="table-responsive">
    <table class="table table-sm" style="margin: 0; font-size: 70%">
      <thead>
        <tr>
          <th>#</th>
          <th>Hub.</th>
          <th>Nama</th>
          <th>Jenis Kelamin</th> <!-- Updated: Combine year_from and year_to -->
          <th>Tgl Lahir</th>
          <th>No. Telp</th>
          <th>Pendidikan Terakhir</th>
          <th>Pekerjaan Terakhir</th>
          <th>Alamat</th>
          <th style="width: 13%"></th>
        </tr>
      </thead>
      <tbody>
        @forelse ($familyDetails as $familyDetail)
          <tr>
            <td class="text-bold-500">{{ $loop->iteration }}</td>
            <td class="text-bold-500">{{ $familyDetail->relation }}</td>
            <td class="text-bold-500">{{ $familyDetail->name }}</td>
            <td class="text-bold-500">
              @if ($familyDetail->gender == 'LAKI-LAKI')
                L
              @elseif ($familyDetail->gender == 'PEREMPUAN')
                P
              @else
                N/A
              @endif
            </td>
            <td class="text-bold-500">
              {{ Carbon\Carbon::parse($familyDetail->dob)->translatedFormat('d F Y') }}
            </td>
            <td class="text-bold-500">{{ $familyDetail->phone_number }}</td>
            <td class="text-bold-500">{{ $familyDetail->education }}</td>
            <td class="text-bold-500">{{ $familyDetail->job }}</td>
            <td class="text-bold-500">{{ $familyDetail->address }}</td>

            <td>
              <div class="demo-inline-spacing">

                <a data-bs-toggle="modal" data-bs-target="#modal-form-edit-family-details-{{ $familyDetail->id }}"
                  class="btn btn-sm btn-icon btn-secondary text-white">
                  <i class="bi bi-pencil-square"></i>
                </a>
                @include('pages.recruitment.family-details.modal-edit')

                <button class="btn btn-sm btn-light-danger mx-2"
                  onclick="deleteFamilyDetail('{{ $familyDetail->id }}')"><i class="bi bi-trash"></i></button>

                <form id="deleteFamilyDetailForm_{{ $familyDetail->id }}"
                  action="{{ route('familyDetails.destroy', $familyDetail->id) }}" method="POST">
                  @method('DELETE')
                  @csrf
                </form>
              </div>
            </td>
          </tr>
        @empty
          <td class="text-bold-500 text-center" colspan="10">No data available in table</td>
        @endforelse
      </tbody>
    </table>

  </div>

</div>

@include('pages.recruitment.family-details.modal-create')

<style>
  .biodata-item {
    margin-bottom: 10px;
    padding-right: 10px;
  }

  .biodata-item strong {
    width: 150px;
  }

  .biodata-item span {
    flex-grow: 1;
    text-align: right;
    word-wrap: break-word;
    /* To handle long text */
  }
</style>

<script>
  function deleteFamilyDetail(getId) {
    Swal.fire({
      title: 'Are you sure?',
      text: 'You won\'t be able to revert this!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        // If the user clicks "Yes, delete it!", submit the corresponding form
        document.getElementById('deleteFamilyDetailForm_' + getId).submit();
      }
    });
  }
</script>
