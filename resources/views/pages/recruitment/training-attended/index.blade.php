<div class="col-md-12 mt-4">
  {{-- <div class="card" style="background-color: #d1141411;" #a3b3e63d > --}}
  <div class="card" style="background-color: #a3b3e626;">
    <div class="card-content">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center ">
          <h4 class="card-title">Data Seminar/Pelatihan</h4>
          <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
            data-bs-target="#modal-form-add-training-attended">
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
  @foreach ($trainingAttendeds as $trainingAttended)
    <div class="col-xl-6 col-md-6 col-sm-12">
      <div class="card" style="background-color:  #a3b3e626;">
        <div class="card-content">
          <div class="card-body">
            <div class="table-responsive" style="font-size: 85%">
              <table class="table table-borderless">
                <tbody>
                  <tr>
                    <th class="p-1">Nama Pelatihan/Seminar</th>
                    <td class="p-1">: {{ $trainingAttended->training_name }}
                    </td>
                  </tr>
                  <tr>
                    <th class="p-1">Penyelenggara</th>
                    <td class="p-1">: {{ $trainingAttended->organizer_name }}</td>
                  </tr>
                  <tr>
                    <th class="p-1">Tahun</th>
                    <td class="p-1">: {{ $trainingAttended->year }}</td>
                  </tr>
                  <tr>
                    <th class="p-1">Tempat/Kota</th>
                    <td class="p-1">: {{ $trainingAttended->city }}</td>
                  </tr>
                  <tr>
                    <th class="p-1">File Sertifikat</th>
                    <td class="p-1">:
                      @if ($trainingAttended->file_sertifikat)
                        <a href="{{ Storage::url($trainingAttended->file_sertifikat) }}" target="_blank">
                          Lihat
                        </a>
                      @else
                        <span>-</span>
                      @endif
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <hr>
            <div class="d-flex justify-content-end">
              <a data-bs-toggle="modal" data-bs-target="#modal-form-edit-training-attended-{{ $trainingAttended->id }}"
                class="btn btn-icon btn-secondary text-white">
                <i class="bi bi-pencil-square"></i>
              </a>
              @include('pages.recruitment.training-attended.modal-edit')

              <button class="btn btn-light-danger mx-2" onclick="deleteTrainingAttend('{{ $trainingAttended->id }}')"><i
                  class="bi bi-trash"></i></button>

              <form id="deleteTrainingAttendForm_{{ $trainingAttended->id }}"
                action="{{ route('trainingAttended.destroy', $trainingAttended->id) }}" method="POST">
                @method('DELETE')
                @csrf
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endforeach

  @include('pages.recruitment.training-attended.modal-create')
</div>

<script>
  function deleteTrainingAttend(getId) {
    Swal.fire({
      title: 'Are you sure?',
      text: 'You won\'t be able to revert this!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        // If the user clicks "Yes, delete it!", submit the corresponding form
        document.getElementById('deleteTrainingAttendForm_' + getId).submit();
      }
    });
  }
</script>