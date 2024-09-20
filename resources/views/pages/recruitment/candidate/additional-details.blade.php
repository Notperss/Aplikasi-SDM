@extends('layouts.app')
@section('title', 'Candidate')
@section('content')

@section('breadcrumb')
  <x-breadcrumb title="Data Diri Pelamar" page="Recruitment" active="Candidate" route="{{ route('candidate.index') }}" />
@endsection

<section class="section">

  <div class="row">

    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title">Informasi Tambahan - {{ $candidate->name }}</h5>
        </div>
        <div class="card-body">
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <a class="nav-link active" id="family-relationship-tab" data-bs-toggle="tab" href="#family-relationship"
                role="tab" aria-controls="family-relationship" aria-selected="true">Keluarga</a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="employment-history-tab" data-bs-toggle="tab" href="#employment-history"
                role="tab" aria-controls="employment-history" aria-selected="false">Pengalaman</a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="educational-history-tab" data-bs-toggle="tab" href="#educational-history"
                role="tab" aria-controls="educational-history" aria-selected="false">Pendidikan</a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="training-attended-tab" data-bs-toggle="tab" href="#training-attended"
                role="tab" aria-controls="training-attended" aria-selected="false">Seminar/Pelatihan</a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="skill-tab" data-bs-toggle="tab" href="#skill" role="tab"
                aria-controls="skill" aria-selected="false">Keterampilan/Kompetensi</a>
            </li>
            {{-- <li class="nav-item" role="presentation">
              <a class="nav-link" id="language-proficiency-tab" data-bs-toggle="tab" href="#language-proficiency"
                role="tab" aria-controls="language-proficiency" aria-selected="false">Bahasa Asing</a>
            </li> --}}
            {{-- <li class="nav-item" role="presentation">
              <a class="nav-link" id="candidate-document-tab" data-bs-toggle="tab" href="#candidate-document"
                role="tab" aria-controls="candidate-document" aria-selected="false">Dokumen-dokumen</a>
            </li> --}}
          </ul>

          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="family-relationship" role="tabpanel"
              aria-labelledby="family-relationship-tab">
              @include('pages.recruitment.family-details.index')
            </div>
            <div class="tab-pane fade" id="employment-history" role="tabpanel" aria-labelledby="employment-history-tab">
              @include('pages.recruitment.employment-history.index')
            </div>
            <div class="tab-pane fade" id="educational-history" role="tabpanel"
              aria-labelledby="educational-history-tab">
              @include('pages.recruitment.educational-history.index')
            </div>
            <div class="tab-pane fade" id="training-attended" role="tabpanel" aria-labelledby="training-attended-tab">
              @include('pages.recruitment.training-attended.index')
            </div>
            <div class="tab-pane fade" id="skill" role="tabpanel" aria-labelledby="skill-tab">
              @include('pages.recruitment.skill.index')
            </div>
            {{-- <div class="tab-pane fade" id="language-proficiency" role="tabpanel"
              aria-labelledby="language-proficiency-tab">
              @include('pages.recruitment.language-proficiency.index')
            </div> --}}
            {{-- <div class="tab-pane fade" id="candidate-document" role="tabpanel" aria-labelledby="candidate-document-tab">
              @include('pages.recruitment.candidate-document.index')
            </div> --}}

          </div>
        </div>
      </div>
    </div>

    {{-- <div class="col-md-12">

      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Javascript Behavior</h4>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-3">
              <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link active" id="v-pills-family-relationship-tab" data-bs-toggle="pill" href="#v-pills-family-relationship"
                  role="tab" aria-controls="v-pills-family-relationship" aria-selected="true">family-relationship</a>
                <a class="nav-link" id="v-pills-employment-history-tab" data-bs-toggle="pill" href="#v-pills-employment-history"
                  role="tab" aria-controls="v-pills-employment-history" aria-selected="false">employment-history</a>
                <a class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" href="#v-pills-messages"
                  role="tab" aria-controls="v-pills-messages" aria-selected="false">Messages</a>
                <a class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" href="#v-pills-settings"
                  role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a>
              </div>
            </div>
            <div class="col-9">
              <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-family-relationship" role="tabpanel"
                  aria-labelledby="v-pills-family-relationship-tab">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ut nulla neque.
                  Ut hendrerit nulla a euismod pretium.
                  Fusce venenatis sagittis ex efficitur suscipit. In tempor mattis fringilla. Sed
                  id tincidunt orci, et volutpat ligula.
                  Aliquam sollicitudin sagittis ex, a rhoncus nisl feugiat quis. Lorem ipsum dolor
                  sit amet, consectetur adipiscing elit.
                  Nunc ultricies ligula a tempor vulputate. Suspendisse pretium mollis ultrices.
                </div>
                <div class="tab-pane fade" id="v-pills-employment-history" role="tabpanel" aria-labelledby="v-pills-employment-history-tab">
                  Integer interdum diam eleifend metus lacinia, quis gravida eros mollis. Fusce
                  non sapien sit amet magna dapibus
                  ultrices. Morbi tincidunt magna ex, eget faucibus sapien bibendum non. Duis a
                  mauris ex. Ut finibus risus sed massa
                  mattis porta. Aliquam sagittis massa et purus efficitur ultricies.
                </div>
                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                  Integer pretium dolor at sapien laoreet ultricies. Fusce congue et lorem id
                  convallis. Nulla volutpat tellus nec
                  molestie finibus. In nec odio tincidunt eros finibus ullamcorper. Ut sodales,
                  dui nec posuere finibus, nisl sem aliquam
                  metus, eu accumsan lacus felis at odio.
                </div>
                <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                  Sed lacus quam, convallis quis condimentum ut, accumsan congue massa.
                  Pellentesque et quam vel massa pretium ullamcorper
                  vitae eu tortor.
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> --}}

  </div>
</section>

@endsection
