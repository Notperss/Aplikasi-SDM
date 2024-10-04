<div class="col-md-12 mt-4">
  {{-- <div class="card" style="background-color: #d1141411;" #a3b3e63d > --}}
  <div class="card" style="background-color: #a3b3e626;">
    <div class="card-content">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center ">
          <h4 class="card-title">Data Pendidikan</h4>
          <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
            data-bs-target="#modal-form-add-educational-history">
            <i class="bi bi-plus-lg"></i>
            Add
          </button>
        </div>
        {{-- <p>* Urutkan berdasarkan pengalaman terakhir.</p> --}}
      </div>
    </div>
  </div>
</div>

{{-- <div class="row">
  @foreach ($educationalHistories as $educationalHistory)
    <div class="col-xl-6 col-md-6 col-sm-12">
      <div class="card" style="background-color:  #a3b3e626;">
        <div class="card-content">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center ">
              <h6 class="card-title">
                {{ $educationalHistory->school_level }} - {{ $educationalHistory->study }}
              </h6>
              <p class="card-subtitle mb-1 text-body-secondary">
                {{ $educationalHistory->year_from }} - {{ $educationalHistory->year_to }}
              </p>
            </div>
            <div class="d-flex justify-content-between align-items-center ">
              <h5 class="card-title">
                {{ $educationalHistory->school_name }}
              </h5>
            </div>
            <p class="card-subtitle mb-1 text-body-secondary">
              GPA / NEM : {{ $educationalHistory->gpa }}
            </p>
            <p class="card-subtitle mb-1 text-body-secondary">
              @if ($educationalHistory->file_ijazah)
                <a href="{{ Storage::url($educationalHistory->file_ijazah) }}" target="_blank">
                  Lihat Ijazah
                </a>
              @else
                <span>-</span>
              @endif
            </p>
            <hr>
            <div class="d-flex justify-content-end">
              <a data-bs-toggle="modal"
                data-bs-target="#modal-form-edit-educational-history-{{ $educationalHistory->id }}"
                class="btn btn-icon btn-secondary text-white">
                <i class="bi bi-pencil-square"></i>
              </a>
              @include('pages.recruitment.educational-history.modal-edit')

              <button class="btn btn-light-danger mx-2" onclick="deleteEducational('{{ $educationalHistory->id }}')"><i
                  class="bi bi-trash"></i></button>

              <form id="deleteEducationalForm_{{ $educationalHistory->id }}"
                action="{{ route('educationalHistory.destroy', $educationalHistory) }}" method="POST">
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
          <th>Jenjang</th>
          <th>Institusi</th>
          <th>Jurusan</th> <!-- Updated: Combine year_from and year_to -->
          <th>GPA/NEM</th>
          <th>Periode</th>
          <th>Lulus/Tidak</th>
          <th>File Ijazah</th>
          <th style="width: 13%"></th>
        </tr>
      </thead>
      <tbody>
        @forelse ($educationalHistories as $educationalHistory)
          <tr>
            <td class="text-bold-500">{{ $loop->iteration }}</td>
            <td class="text-bold-500">{{ $educationalHistory->school_level }}</td>
            <td class="text-bold-500">{{ $educationalHistory->school_name }}</td>
            <td class="text-bold-500">{{ $educationalHistory->study }}</td>
            <td class="text-bold-500">{{ $educationalHistory->gpa }}</td>
            <td class="text-bold-500">
              {{ $educationalHistory->year_from }} - {{ $educationalHistory->year_to }}
            </td>
            <td class="text-bold-500">{{ $educationalHistory->graduate }}</td>
            <td class="text-bold-500">
              @if ($educationalHistory->file_ijazah)
                <a href="{{ Storage::url($educationalHistory->file_ijazah) }}" target="_blank">
                  Lihat
                </a>
              @else
                <span>-</span>
              @endif
            </td>

            <td>
              <div class="demo-inline-spacing">

                <a data-bs-toggle="modal"
                  data-bs-target="#modal-form-edit-educational-history-{{ $educationalHistory->id }}"
                  class="btn btn-sm btn-icon btn-secondary text-white">
                  <i class="bi bi-pencil-square"></i>
                </a>
                @include('pages.recruitment.educational-history.modal-edit')

                <button class="btn btn-sm btn-light-danger mx-2"
                  onclick="deleteEducational('{{ $educationalHistory->id }}')"><i class="bi bi-trash"></i></button>

                <form id="deleteEducationalForm_{{ $educationalHistory->id }}"
                  action="{{ route('educationalHistory.destroy', $educationalHistory) }}" method="POST">
                  @method('DELETE')
                  @csrf
                </form>

              </div>
            </td>
          </tr>
        @empty
          <td class="text-bold-500 text-center" colspan="9">No data available in table</td>
        @endforelse
      </tbody>
    </table>

  </div>

</div>

@include('pages.recruitment.educational-history.modal-create')

<script>
  function deleteEducational(getId) {
    Swal.fire({
      title: 'Are you sure?',
      text: 'You won\'t be able to revert this!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        // If the user clicks "Yes, delete it!", submit the corresponding form
        document.getElementById('deleteEducationalForm_' + getId).submit();
      }
    });
  }
</script>
