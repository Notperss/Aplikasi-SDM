<div class="col-md-12 mt-4">
  {{-- <div class="card" style="background-color: #d1141411;" #a3b3e63d > --}}
  <div class="card" style="background-color: #a3b3e626;">
    <div class="card-content">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center ">
          <h4 class="card-title">Sosial Media</h4>
          <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
            data-bs-target="#modal-form-add-social-media">
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
  <!-- Table with outer spacing -->
  <div class="table-responsive">
    <table class="table table-sm" style="margin: 0; font-size: 70%">
      <thead>
        <tr>
          <th>#</th>
          <th>Platform</th>
          <th>Nama Akun</th>
          <th>Link Akun</th>
          <th style="width: 13%"></th>
        </tr>
      </thead>
      <tbody>
        @forelse ($socialsMedia as $socialMedia)
          <tr>
            <td class="text-bold-500">{{ $loop->iteration }}</td>
            <td class="text-bold-500">{{ $socialMedia->platform }}</td>
            <td class="text-bold-500">{{ $socialMedia->account_name }}</td>
            <td class="text-bold-500">
              <a href="{{ $socialMedia->account_link }}" target="_blank">{{ $socialMedia->account_link }}</a>
            </td>
            <td>
              <div class="demo-inline-spacing">

                <a data-bs-toggle="modal" data-bs-target="#modal-form-edit-social-media-{{ $socialMedia->id }}"
                  class="btn btn-sm btn-icon btn-secondary text-white">
                  <i class="bi bi-pencil-square"></i>
                </a>
                @include('pages.recruitment.social-media.modal-edit')

                <button class="btn btn-sm btn-light-danger mx-2" onclick="deletesocialMedia('{{ $socialMedia->id }}')">
                  <i class="bi bi-trash"></i>
                </button>

                <form id="deletesocialMediaForm_{{ $socialMedia->id }}"
                  action="{{ route('socialMedia.destroy', $socialMedia) }}" method="POST">
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

@include('pages.recruitment.social-media.modal-create')

<script>
  function deletesocialMedia(getId) {
    Swal.fire({
      title: 'Are you sure?',
      text: 'You won\'t be able to revert this!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        // If the user clicks "Yes, delete it!", submit the corresponding form
        document.getElementById('deletesocialMediaForm_' + getId).submit();
      }
    });
  }
</script>
