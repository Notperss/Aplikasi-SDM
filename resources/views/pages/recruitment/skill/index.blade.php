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
          <th>#</th>
          <th>Nama Keterampilan/Kompetensi</th>
          <th>Kemahiran</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @forelse ($skills as $skill)
          <tr>
            <td class="text-bold-500">{{ $loop->iteration }}</td>
            <td class="text-bold-500">{{ $skill->name }}</td>
            <td class="text-bold-500">
              {{-- <span
                style="color: {{ $skill->mastery == 'Cukup' ? 'orange' : ($skill->mastery == 'Baik' ? 'rgba(0, 128, 255, 0.974)' : 'green') }}">
                {{ $skill->mastery }}
              </span> --}}
              {{ $skill->mastery }}
            </td>
            <td>
              <div class="demo-inline-spacing">
                <a data-bs-toggle="modal" data-bs-target="#modal-form-edit-skill-{{ $skill->id }}"
                  class="btn btn-icon btn-secondary text-white">
                  <i class="bi bi-pencil-square"></i>
                </a>
                @include('pages.recruitment.skill.modal-edit')

                <a onclick="deleteskill('{{ $skill->id }}')" title="Delete" class="btn btn-light-danger">
                  <i class="bi bi-trash"></i>
                </a>
                <form id="deleteskillForm_{{ $skill->id }}" action="{{ route('skill.destroy', $skill->id) }}"
                  method="POST">
                  @method('DELETE')
                  @csrf
                </form>
              </div>
            </td>
          </tr>
        @empty
          <td class="text-bold-500 text-center" colspan="4">No data available in table</td>
        @endforelse
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
