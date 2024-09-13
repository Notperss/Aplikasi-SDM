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

<div class="row">
  {{-- <div class="col-xl-6 col-md-6 col-sm-12">
    <div class="card" style="background-color:  #0536c93d;">
      <div class="card-content">
        <div class="card-body">
          <h5 class="card-title">jon doe</h5>
          <p class="card-text">
            Introducing our beautifully designed cards, thoughtfully crafted to enhance your
            browsing experience. These versatile elements are the perfect way to present
            information, products, or services on our website.
          </p>
        </div>
        <img class="img-fluid w-100" src="./assets/compiled/jpg/banana.jpg" alt="Card image cap">
      </div>
      <div class="card-footer d-flex justify-content-between">
        <span>Card Footer</span>
        <button class="btn btn-light-primary">Read More</button>
      </div>
    </div>
  </div> --}}
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
              <span class="badge bg-light-secondary">{{ $familyDetail->relationship }}</span>
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

  @include('pages.recruitment.family-details.modal-create')
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
