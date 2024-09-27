<div class="col-md-12 mt-4">
  {{-- <div class="card" style="background-color: #d1141411;" #a3b3e63d > --}}
  <div class="card" style="background-color: #a3b3e626;">
    <div class="card-content">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center ">
          <h4 class="card-title">Data Pengalaman Kerja</h4>
          <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
            data-bs-target="#modal-form-add-employment-history">
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
  @foreach ($employmentHistories as $employmentHistory)
    <div class="col-xl-6 col-md-6 col-sm-12">
      <div class="card" style="background-color:  #a3b3e626;">
        <div class="card-content">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center ">
              <h5 class="card-title">{{ $employmentHistory->position }}</h5>
              <p class="card-subtitle mb-1 text-body-secondary">
                {{ $employmentHistory->year_from }} - {{ $employmentHistory->year_to }}</p>
            </div>
            <h6 class="card-subtitle text-body-secondary">
              {{ $employmentHistory->company_name }} - {{ $employmentHistory->company_type }}
            </h6>
            <hr>
            <p>{{ $employmentHistory->reason }}</p><br>
            <p>file:</p>
            <div class="d-flex justify-content-end">
              <a data-bs-toggle="modal"
                data-bs-target="#modal-form-edit-employment-history-{{ $employmentHistory->id }}"
                class="btn btn-icon btn-secondary text-white">
                <i class="bi bi-pencil-square"></i>
              </a>
              @include('pages.recruitment.employment-history.modal-edit')

              <button class="btn btn-light-danger mx-2"
                onclick="deleteEmploymenHistory('{{ $employmentHistory->id }}')"><i class="bi bi-trash"></i></button>

              <form id="deleteEmploymentHistoryForm_{{ $employmentHistory->id }}"
                action="{{ route('employmentHistory.destroy', $employmentHistory) }}" method="POST">
                @method('DELETE')
                @csrf
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endforeach

  @include('pages.recruitment.employment-history.modal-create')
</div> --}}

<div class="row">
  <!-- Table with outer spacing -->
  <div class="table-responsive">
    <table class="table table-sm" style="margin: 0; font-size: 80%">
      <thead>
        <tr>
          <th>#</th>
          <th>Nama Perusahaan</th>
          <th>Posisi</th>
          <th>Periode</th> <!-- Updated: Combine year_from and year_to -->
          <th>Gaji Terakhir</th>
          <th>Alasan Keluar</th>
          <th>File</th>
          <th style="width: 15%"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($employmentHistories as $employmentHistory)
          <tr>
            <td class="text-bold-500">{{ $loop->iteration }}</td>
            <td class="text-bold-500">{{ $employmentHistory->company_name }}</td>
            <td class="text-bold-500">{{ $employmentHistory->position }}</td>
            <td class="text-bold-500">
              {{ $employmentHistory->year_from }} - {{ $employmentHistory->year_to }}
            </td> <!-- Combine year_from and year_to -->
            <td class="text-bold-500">Rp. {{ number_format($employmentHistory->salary, 0, ',', '.') }}</td>
            <td class="text-bold-500">{{ $employmentHistory->job_description }}</td>
            <td class="text-bold-500">
              @if ($employmentHistory->file)
                <a href="{{ Storage::url($employmentHistory->file) }}" target="_blank">
                  Lihat
                </a>
              @else
                N/A
              @endif
            </td>
            <td>
              <div class="demo-inline-spacing">
                <a data-bs-toggle="modal"
                  data-bs-target="#modal-form-edit-employment-history-{{ $employmentHistory->id }}"
                  class="btn btn-icon btn-secondary text-white">
                  <i class="bi bi-pencil-square"></i>
                </a>
                @include('pages.recruitment.employment-history.modal-edit')

                <button class="btn btn-light-danger mx-2"
                  onclick="deleteEmploymenHistory('{{ $employmentHistory->id }}')"><i class="bi bi-trash"></i></button>

                <form id="deleteEmploymentHistoryForm_{{ $employmentHistory->id }}"
                  action="{{ route('employmentHistory.destroy', $employmentHistory) }}" method="POST">
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

  @include('pages.recruitment.employment-history.modal-create')
</div>


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
  function deleteEmploymenHistory(getId) {
    Swal.fire({
      title: 'Are you sure?',
      text: 'You won\'t be able to revert this!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        // If the user clicks "Yes, delete it!", submit the corresponding form
        document.getElementById('deleteEmploymentHistoryForm_' + getId).submit();
      }
    });
  }
</script>
