<link rel="stylesheet" href="{{ asset('dist/assets/extensions/toastify-js/src/toastify.css') }}">
<script src="{{ asset('dist/assets/extensions/toastify-js/src/toastify.js') }}"></script>

@if ($errors->any() || session()->has('error'))
  <!-- Toast with Placements -->
  <script>
    @foreach ($errors->all() as $error)
      Toastify({
        text: `<div style="position: relative;">
                <span>{{ $error }}</span>
                </div>
              <div class="toast-progress"></div>
            `,
        duration: 7000, // Duration of the toast
        close: false, // Option to close the toast manually
        gravity: "top", // Toast appears at the top
        position: "right", // Align toast to the right
        backgroundColor: "#dc3545", // Error color (Bootstrap danger)
        escapeMarkup: false,
      }).showToast();
    @endforeach

    // Handle session error message
    @if (session()->has('error'))
      Toastify({
        text: `<div style="position: relative;">
                <span>{{ session('error') }}</span>
                </div>
              <div class="toast-progress"></div>
            `,
        duration: 7000, // Duration of the toast
        close: false, // Option to close the toast manually
        gravity: "top", // Toast appears at the top
        position: "right", // Align toast to the right
        backgroundColor: "#dc3545", // Error color (Bootstrap danger)
        escapeMarkup: false,
      }).showToast();
    @endif
  </script>
@endif

@if (session()->has('success'))
  <script>
    Toastify({
      text: `<div style="position: relative;">
              <span>{{ session('success') }}</span>
              </div>
            <div class="toast-progress"></div>
            `,
      duration: 7000, // Duration of the toast
      close: false, // Option to close the toast manually
      gravity: "top", // Toast appears at the top
      position: "right", // Align toast to the right
      backgroundColor: "#28a745", // Success color.
      escapeMarkup: false,
    }).showToast();
  </script>
@endif

<style>
  .toastify .toast-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 4px;
    width: 100%;
    background-color: #443c3c92;
    /* Progress bar color */
    animation: shrink-progress 7s linear forwards;
    animation-play-state: running;
    /* Initial state: running */
  }

  .toastify:hover .toast-progress {
    animation-play-state: paused;

    animation: none;
    /* Pause on hover */
  }

  @keyframes shrink-progress {
    from {
      width: 100%;
    }

    to {
      width: 0;
    }
  }
</style>
