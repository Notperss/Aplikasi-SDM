@extends('layouts.app')

@section('title', 'Profile')

@section('breadcrumb')
  <x-breadcrumb title="Profile" page="User Management" active="Profile" route="{{ route('profile.edit') }}" />
@endsection

@section('content')
  @if ($errors->updatePassword->any())
    @foreach ($errors->updatePassword->all() as $error)
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ $error }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endforeach
  @endif

  <div class="pt-4 mb-4 mb-lg-3 pb-lg-4">
    <div class="row g-4">
      <div class="col-auto">
        <div class="avatar-sm">
          <img
            src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('dist/assets/compiled/jpg/1.jpg') }}"
            alt="user-img" class="img-thumbnail rounded-circle" style="width: 100px" />
        </div>
      </div>
      <!--end col-->
      <div class="col">
        <div class="p-2">
          <h3 class="text-white mb-1">{{ auth()->user()->name }}</h3>
          <p class="text-white-75">{{ auth()->user()->getRoleNames()[0] }}</p>
          <div class="hstack text-white-50 gap-1">
            <div class="me-2"><i
                class="ri-map-pin-user-line me-1 text-white-75 fs-16 align-middle"></i>{{ auth()->user()->name ?? 'N/A' }}
            </div>
            <div>
              <i class="ri-building-line me-1 text-white-75 fs-16 align-middle"></i>{{ auth()->user()->name ?? 'N/A' }}
            </div>
          </div>
        </div>
      </div>
      <!--end col-->

    </div>
    <!--end row-->
  </div>

  <div class="row">
    <div class="col-lg-12">
      <div>
        <div class="d-flex">
          <!-- Nav tabs -->
          <ul class="nav nav-pills animation-nav profile-nav gap-2 gap-lg-3 flex-grow-1" role="tablist">
            <li class="nav-item">
              <a class="nav-link fs-14 active" data-bs-toggle="tab" href="#overview-tab" role="tab">
                <i class="ri-airplay-fill d-inline-block d-md-none"></i> <span
                  class="d-none d-md-inline-block">Overview</span>
              </a>
            </li>
          </ul>

          <div class="flex-shrink-0">
            <a data-bs-toggle="modal" data-bs-target="#modal-form-edit-password-{{ auth()->user()->id }}"
              class="btn btn-success"><i class="ri-edit-box-line align-bottom"></i>
              Change Password</a>
          </div>
        </div>
        <!-- Tab panes -->
        <div class="tab-content pt-4 text-muted">
          <div class="tab-pane active" id="overview-tab" role="tabpanel">
            <div class="row">
              <div class="col-xxl-12">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title mb-3">Info Profile</h5>
                    <div class="table-responsive">
                      <table class="table table-borderless mb-0">
                        <tbody>
                          <tr>
                            <th class="ps-0" scope="row">Full Name :</th>
                            <td class="text-muted">{{ auth()->user()->name }}</td>
                          </tr>
                          <th class="ps-0" scope="row">E-mail :</th>
                          <td class="text-muted">{{ auth()->user()->email }}</td>
                          </tr>
                          {{-- <tr>
                            <th class="ps-0" scope="row">Division :</th>
                            <td class="text-muted">{{ auth()->user()->division->name ?? 'N/A' }}</td>
                          </tr>
                          <tr>
                          <tr>
                            <th class="ps-0" scope="row">Company :</th>
                            <td class="text-muted">{{ auth()->user()->company->name ?? 'N/A' }}
                            </td>
                          </tr> --}}
                          <tr>
                            <th class="ps-0" scope="row">Joining Date</th>
                            <td class="text-muted">
                              {{ Carbon\Carbon::parse(auth()->user()->created_at)->translatedFormat('H:i - l, d F Y') ?? 'N/A' }}
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div><!-- end card body -->
                </div><!-- end card -->
              </div>
              <!-- end card body -->
            </div><!-- end card -->
            <!--end col-->
          </div>
          <!--end row-->
        </div>
        <!--end tab-pane-->
      </div>
    </div>
    <!--end tab-content-->
  </div>
  {{-- </div>
  <!--end col-->
  </div> --}}
  <!--end row-->
  @include('profile.partials.change-password')

@endsection
