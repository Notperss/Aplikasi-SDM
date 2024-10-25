<link rel="stylesheet" href="{{ asset('dist/assets/extensions/toastify-js/src/toastify.css') }}">
<script src="{{ asset('dist/assets/extensions/toastify-js/src/toastify.js') }}"></script>

@if ($errors->any() || session()->has('error'))
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

    // Handle session error message
    @if (session()->has('error'))
      Toastify({
        text: "{{ session('error') }}", // Display session error
        duration: 4000, // Duration of the toast
        close: true, // Option to close the toast manually
        gravity: "top", // Toast appears at the top
        position: "right", // Align toast to the right
        backgroundColor: "#dc3545", // Error color (Bootstrap danger)
      }).showToast();
    @endif
  </script>
@endif

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
