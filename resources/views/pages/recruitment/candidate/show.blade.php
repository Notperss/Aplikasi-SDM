@extends('layouts.auth')
@section('title', 'Candidate')
@section('content')

  <link rel="stylesheet" href="{{ asset('dist/assets/extensions/toastify-js/src/toastify.css') }}">
  <script src="{{ asset('dist/assets/extensions/toastify-js/src/toastify.js') }}"></script>

  <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />

  @if (session()->has('success'))
    <script>
      Toastify({
        text: "{{ session('success') }}", // Display success message from session
        duration: 4000, // Duration of the toast
        close: true, // Option to close the toast manually
        gravity: "top", // Toast appears at the top
        position: "right", // Align toast to the right
        backgroundColor: "#28a745", // Success color
      }).showToast();
    </script>
  @endif

  <nav class="navbar navbar-light">
    <div class="container d-block">
      <a href="{{ route('candidate.index') }}"><i class="bi bi-chevron-left"></i></a>
      <a class="btn btn-primary ms-4" href="{{ route('candidate.index') }}">
        Back
      </a>
    </div>
  </nav>

  @if ($errors->any())
    <!-- Toast with Placements -->
    <script>
      @foreach ($errors->all() as $error)
        Toastify({
          text: "{{ $error }}", // Display each error message
          duration: 4000, // Duration of the toast
          close: true, // Option to close the toast manually
          gravity: "top", // Toast appears at the top
          position: "right", // Align toast to the right
          backgroundColor: "#dc3545", // Error color (Bootstrap danger)
        }).showToast();
      @endforeach
    </script>
  @endif



  <section class="section">
    <div class="row mx-3">
      <div class="col-2">
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
          <a class="nav-link show active" id="v-pills-informasi-dasar-tab" data-bs-toggle="pill"
            href="#v-pills-informasi-dasar" role="tab" aria-controls="v-pills-informasi-dasar"
            aria-selected="true">Informasi Dasar</a>
          <a class="nav-link" id="v-pills-data-keluarga-tab" data-bs-toggle="pill" href="#v-pills-data-keluarga"
            role="tab" aria-controls="v-pills-data-keluarga" aria-selected="false">Data Keluarga</a>
          <a class="nav-link" id="v-pills-riwayat-pekerjaan-tab" data-bs-toggle="pill" href="#v-pills-riwayat-pekerjaan"
            role="tab" aria-controls="v-pills-riwayat-pekerjaan" aria-selected="false">Riwayat Pekerjaan</a>
          <a class="nav-link" id="v-pills-riwayat-pendidikan-tab" data-bs-toggle="pill" href="#v-pills-riwayat-pendidikan"
            role="tab" aria-controls="v-pills-riwayat-pendidikan" aria-selected="false">Riwayat Pendidikan</a>
          <a class="nav-link" id="v-pills-kemampuan-bahasa-tab" data-bs-toggle="pill" href="#v-pills-kemampuan-bahasa"
            role="tab" aria-controls="v-pills-kemampuan-bahasa" aria-selected="false">Kemampuan Bahasa</a>
          <a class="nav-link" id="v-pills-seminar-tab" data-bs-toggle="pill" href="#v-pills-seminar" role="tab"
            aria-controls="v-pills-seminar" aria-selected="false">Seminar/Pelatihan</a>
          <a class="nav-link" id="v-pills-keterampilan-tab" data-bs-toggle="pill" href="#v-pills-keterampilan"
            role="tab" aria-controls="v-pills-keterampilan" aria-selected="false">Keterampilan</a>
          <a class="nav-link" id="v-pills-sosial-media-tab" data-bs-toggle="pill" href="#v-pills-sosial-media"
            role="tab" aria-controls="v-pills-sosial-media" aria-selected="false">Sosial Media</a>
        </div>
      </div>
      <div class="col-10">
        <div class="tab-content" id="v-pills-tabContent">

          <div class="tab-pane fade" id="v-pills-data-keluarga" role="tabpanel"
            aria-labelledby="v-pills-data-keluarga-tab">
            @include('pages.recruitment.candidate.show-detail.family-detail')
          </div>
          <div class="tab-pane fade" id="v-pills-riwayat-pekerjaan" role="tabpanel"
            aria-labelledby="v-pills-riwayat-pekerjaan-tab">
            @include('pages.recruitment.candidate.show-detail.employment-history-detail')
          </div>
          <div class="tab-pane fade" id="v-pills-riwayat-pendidikan" role="tabpanel"
            aria-labelledby="v-pills-riwayat-pendidikan-tab">
            @include('pages.recruitment.candidate.show-detail.educational-history-detail')
          </div>
          <div class="tab-pane fade" id="v-pills-kemampuan-bahasa" role="tabpanel"
            aria-labelledby="v-pills-kemampuan-bahasa-tab">
            @include('pages.recruitment.candidate.show-detail.language-proficiency-detail')
          </div>
          <div class="tab-pane fade" id="v-pills-seminar" role="tabpanel" aria-labelledby="v-pills-seminar-tab">
            @include('pages.recruitment.candidate.show-detail.training-attended-detail')
          </div>
          <div class="tab-pane fade" id="v-pills-keterampilan" role="tabpanel" aria-labelledby="v-pills-keterampilan-tab">
            @include('pages.recruitment.candidate.show-detail.skill-detail')
          </div>
          <div class="tab-pane fade" id="v-pills-sosial-media" role="tabpanel"
            aria-labelledby="v-pills-sosial-media-tab">
            @include('pages.recruitment.candidate.show-detail.social-platform-detail')
          </div>
          <div class="tab-pane fade show active" id="v-pills-informasi-dasar" role="tabpanel"
            aria-labelledby="v-pills-informasi-dasar-tab">
            @include('pages.recruitment.candidate.show-detail.candidate-detail')
          </div>
        </div>
      </div>
    </div>

    </div>


  </section>

  <!--preview img-->
  <script>
    function previewImage(event) {
      var reader = new FileReader();
      reader.onload = function() {
        var output = document.getElementById('uploadedAvatar');
        output.src = reader.result;
      }
      reader.readAsDataURL(event.target.files[0]);
    }
  </script>

  <!-- sweetalsert-->
  <script>
    document.getElementById('submitBtn').addEventListener('click', function(e) {
      Swal.fire({
        title: 'Are you sure to update it?',
        // text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, submit it!'
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById('updateForm').submit();
        }
      });
    });
  </script>

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
          document.getElementById('deleteCandidateEmploymentHistoryForm_' + getId).submit();
        }
      });
    }
  </script>

  <script>
    function deletecandidateLanguageProficiency(getId) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          // If the user clicks "Yes, delete it!", submit the corresponding form
          document.getElementById('deletecandidateLanguageProficiencyForm_' + getId).submit();
        }
      });
    }
  </script>

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

  <script>
    function deletecandidateSocialPlatform(getId) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          // If the user clicks "Yes, delete it!", submit the corresponding form
          document.getElementById('deletecandidateSocialPlatformForm_' + getId).submit();
        }
      });
    }
  </script>
  <!-- /sweetalsert-->

  <!--leaflet-->
  <!-- Include Leaflet.js CSS and JS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var mapKTP, mapDomisili;
      var markerKTP, markerDomisili;

      // Initialize KTP Map when modal is shown
      $('#mapModalKTP').on('shown.bs.modal', function() {
        if (!mapKTP) {
          mapKTP = L.map('mapKTP').setView([{{ $candidate->latitude_ktp ?? -6.1580339989448305 }},
              {{ $candidate->longitude_ktp ?? 106.88319683074951 }}
            ],
            13); // Default location: Jakarta
          L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
          }).addTo(mapKTP);

          // Add a marker at the candidate's KTP location
          var markerKTP = L.marker([{{ $candidate->latitude_ktp ?? -6.1580339989448305 }},
            {{ $candidate->longitude_ktp ?? 106.88319683074951 }}
          ]).addTo(
            mapKTP);

          // Optional: Bind a popup to the marker with some information
          markerKTP.bindPopup("<b>Lokasi Alamat KTP</b>").openPopup();

          // Add marker when map is clicked
          mapKTP.on('click', function(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;

            // Update input fields for KTP
            document.getElementById('latitude_ktp').value = lat;
            document.getElementById('longitude_ktp').value = lng;

            // Place marker
            if (markerKTP) {
              mapKTP.removeLayer(markerKTP);
            }
            markerKTP = L.marker([lat, lng]).addTo(mapKTP);
          });
        }
        setTimeout(function() {
          mapKTP.invalidateSize();
        }, 100);
      });

      // Initialize Domisili Map when modal is shown
      $('#mapModalDomisili').on('shown.bs.modal', function() {
        if (!mapDomisili) {
          mapDomisili = L.map('mapDomisili').setView([{{ $candidate->latitude_domisili ?? -6.1580339989448305 }},
              {{ $candidate->longitude_domisili ?? 106.88319683074951 }}
            ],
            13); // Default location: Jakarta
          L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
          }).addTo(mapDomisili);

          // Add a marker at the candidate's domisili location
          var markerDomisili = L.marker([{{ $candidate->latitude_domisili ?? -6.1580339989448305 }},
            {{ $candidate->longitude_domisili ?? 106.88319683074951 }}
          ]).addTo(
            mapDomisili);

          // Optional: Bind a popup to the marker with some information
          markerDomisili.bindPopup("<b>Lokasi Alamat Domisili</b>").openPopup();

          // Add marker when map is clicked
          mapDomisili.on('click', function(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;

            // Update input fields for Domisili
            document.getElementById('latitude_domisili').value = lat;
            document.getElementById('longitude_domisili').value = lng;

            // Place marker
            if (markerDomisili) {
              mapDomisili.removeLayer(markerDomisili);
            }
            markerDomisili = L.marker([lat, lng]).addTo(mapDomisili);
          });
        }
        setTimeout(function() {
          mapDomisili.invalidateSize();
        }, 100);
      });

      // Optionally add logic to reset markers or clear fields if needed.
    });
  </script>
  <!--/leaflet-->
  <script>
    Fancybox.bind("[data-fancybox]", {
      // Your custom options
    });
  </script>
@endsection
