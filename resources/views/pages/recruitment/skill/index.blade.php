<div class="col-md-12 mt-4">
  {{-- <div class="card" style="background-color: #d1141411;" #a3b3e63d > --}}
  <div class="card" style="background-color: #a3b3e626;">
    <div class="card-content">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center ">
          <h4 class="card-title">Data Keterampilan/Kompetensi</h4>
          <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
            data-bs-target="#modal-form-add-skill">
            <i class="bi bi-plus-lg"></i>
            Add
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <!-- Table with outer spacing -->
  <div class="table-responsive">
    <table class="table table-sm">
      <thead>
        <tr>
          <th>Nama Keterampilan/Kompetensi</th>
          <th>Kemahiran</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($skills as $skill)
          <tr>
            <td class="text-bold-500">{{ $skill->skill }}</td>
            <td class="text-bold-500">
              <span
                style="color: {{ $skill->mastery == 'Cukup' ? 'orange' : ($skill->mastery == 'Baik' ? 'rgba(0, 128, 255, 0.974)' : 'green') }}">
                {{ $skill->mastery }}
              </span>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  @include('pages.recruitment.skill.modal-create')
</div>

<script>
  function deleteskill(getId) {
    Swal.fire({
      title: 'Are you sure?',
      text: 'You won\'t be able to revert this!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        // If the user clicks "Yes, delete it!", submit the corresponding form
        document.getElementById('deleteskillForm_' + getId).submit();
      }
    });
  }
</script>
