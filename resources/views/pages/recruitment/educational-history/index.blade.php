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

<div class="row">
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

  @include('pages.recruitment.educational-history.modal-create')
</div>

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
