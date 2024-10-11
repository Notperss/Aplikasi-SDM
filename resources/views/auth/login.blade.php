@extends('layouts.auth')
@section('title', 'Login')
@section('content')
  <style>
    /* Style for the entire right section */
    #auth-right {
      display: flex;
      justify-content: center;
      /* Center horizontally */
      align-items: center;
      /* Center vertically */
      height: 150vh;
      /* Full height of the viewport */
      overflow: hidden;
      /* Prevents overflow */
    }

    /* Style for the logo */
    #auth-right img {
      width: 1500px;
      /* Set the logo width */
      height: auto;
      /* Maintain aspect ratio */
      max-width: 170%;
      /* Ensure it doesn't exceed container width */
    }
  </style>

  <div class="row h-100">
    <div class="col-lg-5 col-12">
      <div id="auth-left">
        <div class="auth-logo">
        </div>

        <div class="text-center">
          <a href="#">
            <img src="{{ asset('img/cmnplogo.png') }}" class="mb-2" alt="Logo" width="40%">
          </a>
          <p class="auth-subtitle mb-2">Please sign-in to your account.</p>
        </div>
        @if ($errors->has('email'))
          <p class="mb-2 text-sm text-danger">The email address or password is incorrect.</p>
        @endif
        <form method="POST" action="{{ route('login') }}">
          @csrf
          <div class="form-group position-relative has-icon-left mb-4">
            <input type="email" class="form-control form-control-xl" name="email" placeholder="Email" required>
            <div class="form-control-icon">
              <i class="bi bi-person"></i>
            </div>
          </div>
          <div class="form-group position-relative has-icon-left mb-4">
            <input type="password" class="form-control form-control-xl" name="password" placeholder="Password">
            <div class="form-control-icon">
              <i class="bi bi-shield-lock"></i>
            </div>
          </div>
          <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
        </form>
      </div>
    </div>
    <div class="col-lg-7 d-none d-lg-block">
      <div id="auth-right">
        <a href="#"><img src="{{ asset('img/login-img.png') }}" alt="Logo" width="1000px"></a>
      </div>
    </div>

    {{-- <div class="d-flex justify-content-center align-items-center vh-100">
      <div class="card" style="width: 600px;">
        <div class="card-content">
          <div class="card-body">
            <h1 class="auth-title">Log in.</h1>
            <p class="auth-subtitle mb-5">Please sign-in to your account.</p>
            @if ($errors->has('email'))
              <p class="mb-2 text-sm text-danger">The email address or password is incorrect.</p>
            @endif
            <form method="POST" action="{{ route('login') }}">
              @csrf
              <div class="form-group position-relative has-icon-left mb-4">
                <input type="email" class="form-control form-control-xl" name="email" placeholder="Email">
                <div class="form-control-icon">
                  <i class="bi bi-person"></i>
                </div>
              </div>
              <div class="form-group position-relative has-icon-left mb-4">
                <input type="password" class="form-control form-control-xl" name="password" placeholder="Password">
                <div class="form-control-icon">
                  <i class="bi bi-shield-lock"></i>
                </div>
                <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
            </form>
          </div>
        </div>
      </div>
    </div> --}}

  </div>
@endsection
