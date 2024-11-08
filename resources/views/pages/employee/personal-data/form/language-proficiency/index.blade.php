<div class="col-md-12 mt-4">
  {{-- <div class="card" style="background-color: #d1141411;" #a3b3e63d > --}}
  <div class="card" style="background-color: #a3b3e626;">
    <div class="card-content">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center ">
          <h4 class="card-title">Kemampuan Bahasa Asing</h4>
          <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
            data-bs-target="#modal-form-add-language-proficiency">
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
  @foreach ($languageProficiencies as $languageProficiency)
    <div class="col-xl-4 col-md-4 col-sm-6">
      <div class="card" style="background-color:  #a3b3e626;">
        <div class="card-content">
          <div class="card-body">
            <h5 class="card-title">{{ $languageProficiency->language }}</h5>
            <hr>
            <p class="mb-0">Lisan :
              <span
                style="color: {{ $languageProficiency->speaking == 'Cukup' ? 'orange' : ($languageProficiency->speaking == 'Baik' ? 'rgba(0, 128, 255, 0.974)' : 'green') }}">
                {{ $languageProficiency->speaking }}
              </span>
            </p>
            <p class="mb-0">Menulis :
              <span
                style="color: {{ $languageProficiency->writing == 'Cukup' ? 'orange' : ($languageProficiency->writing == 'Baik' ? 'rgba(0, 128, 255, 0.974)' : 'green') }}">
                {{ $languageProficiency->writing }}
              </span>
            </p>
            <p class="mb-0">Membaca :
              <span
                style="color: {{ $languageProficiency->reading == 'Cukup' ? 'orange' : ($languageProficiency->reading == 'Baik' ? 'rgba(0, 128, 255, 0.974)' : 'green') }}">
                {{ $languageProficiency->reading }}
              </span>
            </p>
            <p class="mb-0">Mendengar :
              <span
                style="color: {{ $languageProficiency->listening == 'Cukup' ? 'orange' : ($languageProficiency->listening == 'Baik' ? 'rgba(0, 128, 255, 0.974)' : 'green') }}">
                {{ $languageProficiency->listening }}
              </span>
            </p>

            <div class="d-flex justify-content-end mt-2">
              <a data-bs-toggle="modal"
                data-bs-target="#modal-form-edit-language-proficiency-{{ $languageProficiency->id }}"
                class="btn btn-icon btn-secondary text-white">
                <i class="bi bi-pencil-square"></i>
              </a>
              @include('pages.recruitment.language-proficiency.modal-edit')

              <button class="btn btn-light-danger mx-2"
                onclick="deletelanguageProficiency('{{ $languageProficiency->id }}')">
                <i class="bi bi-trash"></i>
              </button>

              <form id="deletelanguageProficiencyForm_{{ $languageProficiency->id }}"
                action="{{ route('languageProficiency.destroy', $languageProficiency) }}" method="POST">
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
          <th>Bahasa</th>
          <th>Lisan</th>
          <th>Menulis</th>
          <th>Membaca</th>
          <th>Mendengar</th>
          <th style="width: 13%"></th>
        </tr>
      </thead>
      <tbody>
        @forelse ($languageProficiencies as $languageProficiency)
          <tr>
            <td class="text-bold-500">{{ $loop->iteration }}</td>
            <td class="text-bold-500">{{ $languageProficiency->language }}</td>
            <td class="text-bold-500">{{ $languageProficiency->speaking }}</td>
            <td class="text-bold-500">{{ $languageProficiency->writing }}</td>
            <td class="text-bold-500">{{ $languageProficiency->reading }}</td>
            <td class="text-bold-500">{{ $languageProficiency->listening }}</td>
            <td>
              <div class="demo-inline-spacing">

                <a data-bs-toggle="modal"
                  data-bs-target="#modal-form-edit-language-proficiency-{{ $languageProficiency->id }}"
                  class="btn btn-sm btn-icon btn-secondary text-white">
                  <i class="bi bi-pencil-square"></i>
                </a>
                @include('pages.recruitment.language-proficiency.modal-edit')

                <button class="btn btn-sm btn-light-danger mx-2"
                  onclick="deletelanguageProficiency('{{ $languageProficiency->id }}')">
                  <i class="bi bi-trash"></i>
                </button>

                <form id="deletelanguageProficiencyForm_{{ $languageProficiency->id }}"
                  action="{{ route('languageProficiency.destroy', $languageProficiency) }}" method="POST">
                  @method('DELETE')
                  @csrf
                </form>

              </div>
            </td>
          </tr>
        @empty
          <td class="text-bold-500 text-center" colspan="7">No data available in table</td>
        @endforelse
      </tbody>
    </table>

  </div>

</div>

@include('pages.recruitment.language-proficiency.modal-create')

<script>
  function deletelanguageProficiency(getId) {
    Swal.fire({
      title: 'Are you sure?',
      text: 'You won\'t be able to revert this!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        // If the user clicks "Yes, delete it!", submit the corresponding form
        document.getElementById('deletelanguageProficiencyForm_' + getId).submit();
      }
    });
  }
</script>
