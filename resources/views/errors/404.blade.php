@extends('layouts.auth')
@section('title', '404')
@section('content')
  <link rel="stylesheet" crossorigin href="{{ asset('dist/assets/compiled/css/error.css') }}">
  <div id="error">
    <div class="error-page container">
      <div class="col-md-8 col-12 offset-md-2">
        <div class="text-center">
          <img class="img-error" src="{{ asset('dist/assets/compiled/svg/error-404.svg') }}" alt="Not Found" width="50%"
            height="auto">
          <h1 class="error-title">NOT FOUND</h1>
          <p class='fs-5 text-gray-600'>The page you are looking not found.</p>
          <a href="{{ route('dashboard.index') }}" class="btn btn-lg btn-outline-primary mt-3">Go Home</a>
        </div>
      </div>
    </div>
  </div>
@endsection
