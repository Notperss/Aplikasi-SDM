@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

@section('breadcrumb')
  <x-breadcrumb title="Dashboard" page="" active="Dashboard" route="{{ route('dashboard.index') }}" />
@endsection

<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />


<div class="page-content">

  <div class="row">
    <div class="col-6 col-lg-2 col-md-6">
      <div class="card">
        <div class="card-body px-4 py-4-5">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 d-flex justify-content-start ">
              <div class="stats-icon purple mb-2">
                <svg id="user" width="24" height="24" viewBox="0 0 24 24" fill="none"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M12.2314 14.6231C15.2615 14.6153 17.8379 16.0066 18.7849 19.0014C16.8761 20.1651 14.6293 20.6133 12.2314 20.6074C9.83364 20.6133 7.58679 20.1651 5.67798 19.0014C6.62608 16.0033 9.19812 14.6153 12.2314 14.6231Z"
                    stroke="#000000" stroke-width="1.4" stroke-linecap="square"></path>
                  <path
                    d="M6.84448 13.773C4.72011 13.7675 2.91382 14.7429 2.24988 16.8426C2.97457 17.2844 3.76875 17.5791 4.6116 17.7558"
                    stroke="#000000" stroke-width="1.4" stroke-linecap="square"></path>
                  <path
                    d="M17.6555 13.773C19.7799 13.7675 21.5862 14.7429 22.2501 16.8426C21.5254 17.2844 20.7312 17.5791 19.8884 17.7558"
                    stroke="#000000" stroke-width="1.4" stroke-linecap="square"></path>
                  <path
                    d="M16.3484 7.49102C16.3484 9.75453 14.5134 11.5895 12.2499 11.5895C9.98642 11.5895 8.15149 9.75453 8.15149 7.49102C8.15149 5.22751 9.98642 3.39258 12.2499 3.39258C14.5134 3.39258 16.3484 5.22751 16.3484 7.49102Z"
                    stroke="#000000" stroke-width="1.4" stroke-linecap="square"></path>
                  <path
                    d="M16.733 6.05059C17.0226 5.95272 17.3328 5.89966 17.6555 5.89966C19.2461 5.89966 20.5355 7.18907 20.5355 8.77964C20.5355 10.3702 19.2461 11.6596 17.6555 11.6596C16.8825 11.6596 16.1806 11.3551 15.6633 10.8594"
                    stroke="#000000" stroke-width="1.4" stroke-linecap="square"></path>
                  <path
                    d="M7.50042 5.97469C7.28971 5.92561 7.07012 5.89966 6.84446 5.89966C5.25389 5.89966 3.96448 7.18907 3.96448 8.77964C3.96448 10.3702 5.25389 11.6596 6.84446 11.6596C7.53768 11.6596 8.1737 11.4147 8.6707 11.0067"
                    stroke="#000000" stroke-width="1.4" stroke-linecap="square"></path>
                </svg>
              </div>
            </div>
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
              <h6 class="text-muted font-semibold">Total Semua Karyawan</h6>
              <h4 class="font-extrabold mb-0">
                @role('super-admin')
                  {{ DB::table('employees')->where('employee_status', 'AKTIF')->count() }}
                @else
                  {{ DB::table('employees')->where('employee_status', 'AKTIF')->where('company_id', auth()->user()->company_id)->count() }}
                @endrole
              </h4>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-6 col-lg-2 col-md-6">
      <div class="card">
        <div class="card-body px-4 py-4-5">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 d-flex justify-content-start ">
              <div class="stats-icon blue mb-2">
                <svg id="Add User" width="24" height="25" viewBox="0 0 24 24" fill="none"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M20.043 8.41895V13.9289H18.543V8.41895H20.043Z"
                    fill="#000000"></path>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M16.498 10.4238H22.088V11.9238H16.498V10.4238Z"
                    fill="#000000"></path>
                  <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M10.171 4C8.14347 4 6.5 5.64275 6.5 7.66973C6.5 9.69672 8.14347 11.3395 10.171 11.3395C12.1971 11.3395 13.8408 9.69686 13.8408 7.66973C13.8408 5.6426 12.1971 4 10.171 4ZM5 7.66973C5 4.81374 7.31562 2.5 10.171 2.5C13.0253 2.5 15.3408 4.81389 15.3408 7.66973C15.3408 10.5256 13.0253 12.8395 10.171 12.8395C7.31562 12.8395 5 10.5257 5 7.66973Z"
                    fill="#000000"></path>
                  <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M4.08399 19.685C5.86797 20.6222 7.94447 21.0057 10.2032 21.0001H10.2068C12.4655 21.0057 14.542 20.6222 16.3259 19.685C15.3015 17.2392 13.0146 16.0617 10.2069 16.0689H10.2031C7.39191 16.0617 5.10872 17.2364 4.08399 19.685ZM10.205 14.5689C6.70556 14.5605 3.5886 16.1881 2.44701 19.7981L2.26976 20.3586L2.77172 20.6646C4.97609 22.0084 7.53873 22.5064 10.205 22.5001C12.8713 22.5064 15.4339 22.0084 17.6383 20.6646L18.1402 20.3586L17.963 19.7981C16.8226 16.1917 13.701 14.5605 10.205 14.5689Z"
                    fill="#000000"></path>
                </svg>
              </div>
            </div>
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
              <h6 class="text-muted font-semibold">Karyawan Aktif Bulan Ini</h6>
              <h4 class="font-extrabold mb-0">
                @role('super-admin')
                  {{ DB::table('employees')->where('employee_status', 'AKTIF')->whereMonth('created_at', now()->month)->count() }}
                @else
                  {{ DB::table('employees')->where('company_id', auth()->user()->company_id)->where('employee_status', 'AKTIF')->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count() }}
                @endrole
              </h4>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-6 col-lg-2 col-md-6">
      <div class="card">
        <div class="card-body px-4 py-4-5">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 d-flex justify-content-start ">
              <div class="stats-icon green mb-2">
                <svg id="Face" width="24" height="25" viewBox="0 0 24 24" fill="none"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M12.25 21.3887C7.141 21.3887 3 17.2477 3 12.1387C3 7.02967 7.141 2.88867 12.25 2.88867C17.359 2.88867 21.5 7.02967 21.5 12.1387C21.5 15.7087 19.477 18.8067 16.515 20.3487"
                    stroke="#000000" stroke-width="1.5" stroke-linecap="square"></path>
                  <path d="M11.6865 8.41553L9.77148 14.9085L9.95248 15.2105H13.5445" stroke="#000000" stroke-width="1.5"
                    stroke-linecap="square"></path>
                  <path d="M16.6366 11.3125H16.6466" stroke="#000000" stroke-width="1.5" stroke-linecap="square"></path>
                  <path d="M7.18348 11.3125H7.19348" stroke="#000000" stroke-width="1.5" stroke-linecap="square"></path>
                </svg>
              </div>
            </div>
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
              <h6 class="text-muted font-semibold">Karyawan Inaktif Bulan Ini</h6>
              <h4 class="font-extrabold mb-0">
                @role('super-admin')
                  {{ DB::table('employees')->where('employee_status', '!=', 'AKTIF')->whereMonth('created_at', now()->month)->count() }}
                @else
                  {{ DB::table('employees')->where('company_id', auth()->user()->company_id)->where('employee_status', '!=', 'AKTIF')->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count() }}
                @endrole
              </h4>
              </h6>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-6 col-lg-2 col-md-6">
      <div class="card">
        <div class="card-body px-4 py-4-5">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 d-flex justify-content-start ">
              <div class="stats-icon mb-2">
                <svg id="Add User" width="24" height="24" viewBox="0 0 24 24" fill="none"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M10.1272 12.1087C12.8502 12.1087 15.0652 9.89369 15.0652 7.17069C15.0652 4.44669 12.8502 2.23169 10.1272 2.23169C7.40421 2.23169 5.18921 4.44669 5.18921 7.17069C5.18921 9.89369 7.40421 12.1087 10.1272 12.1087Z"
                    fill="#fff1f1"></path>
                  <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M22.0102 9.94177H19.9652V7.93677H18.4652V9.94177H16.4202V11.4418H18.4652V13.4468H19.9652V11.4418H22.0102V9.94177Z"
                    fill="#fff1f1"></path>
                  <path opacity="0.4" fill-rule="evenodd" clip-rule="evenodd"
                    d="M10.154 14.3367H10.101C6.35399 14.3367 3.62399 16.1777 2.60799 19.3907L2.48999 19.7647L2.82399 19.9687C4.78199 21.1627 7.22299 21.7677 10.081 21.7677C10.112 21.7687 10.143 21.7687 10.175 21.7677C13.072 21.7677 15.446 21.1787 17.431 19.9687L17.765 19.7647L17.647 19.3907C16.632 16.1777 13.901 14.3367 10.154 14.3367Z"
                    fill="#fff1f1"></path>
                </svg>
              </div>
            </div>
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
              <h6 class="text-muted font-semibold">Karyawan Aktif Tahun Ini</h6>
              <h4 class="font-extrabold mb-0">
                @role('super-admin')
                  {{ DB::table('employees')->where('employee_status', 'AKTIF')->whereYear('created_at', now()->year)->count() }}
                @else
                  {{ DB::table('employees')->where('company_id', auth()->user()->company_id)->where('employee_status', 'AKTIF')->whereYear('created_at', now()->year)->count() }}
                @endrole
              </h4>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-6 col-lg-2 col-md-6">
      <div class="card">
        <div class="card-body px-4 py-4-5">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 d-flex justify-content-start ">
              <div class="stats-icon red mb-2">
                <svg id="Face" width="24" height="25" viewBox="0 0 24 24" fill="none"
                  xmlns="http://www.w3.org/2000/svg">
                  <path opacity="0.4" fill-rule="evenodd" clip-rule="evenodd"
                    d="M12.25 2.38867C6.874 2.38867 2.5 6.76267 2.5 12.1387C2.5 17.5147 6.874 21.8887 12.25 21.8887C17.626 21.8887 22 17.5147 22 12.1387C22 6.76267 17.626 2.38867 12.25 2.38867Z"
                    fill="#000000"></path>
                  <path d="M15.8956 12.0629H17.3956V10.5629H15.8856L15.8956 12.0629Z" fill="#000000"></path>
                  <path
                    d="M9.52762 15.9609H14.2936V14.4609H10.6846L12.6176 7.90889L11.1786 7.48389L8.95762 15.0129L9.52762 15.9609Z"
                    fill="#000000"></path>
                  <path d="M6.44262 12.0629H7.94262V10.5629H6.43262L6.44262 12.0629Z" fill="#000000"></path>
                </svg>
              </div>
            </div>
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
              <h6 class="text-muted font-semibold">Karyawan Inaktif Tahun Ini</h6>
              <h4 class="font-extrabold mb-0">
                @role('super-admin')
                  {{ DB::table('employees')->where('employee_status', '!=', 'AKTIF')->whereYear('created_at', now()->year)->count() }}
                @else
                  {{ DB::table('employees')->where('company_id', auth()->user()->company_id)->where('employee_status', '!=', 'AKTIF')->whereYear('created_at', now()->year)->count() }}
                @endrole
              </h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- <div class="row">
    <h5>Data karyawan Perbulan</h5>
    <div class="col-6 col-lg-2 col-md-6">
      <div class="card">
        <div class="card-body px-4 py-4-5">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 d-flex justify-content-start ">
              <div class=" mb-2" style="background-color: #fff">

              </div>
            </div>
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
              <h6 class="text-muted font-semibold">Karyawan Baru</h6>
              <h4 class="font-extrabold mb-0">
                @role('super-admin')
                  {{ DB::table('approvals')->join('employee_careers', 'approvals.employee_career_id', '=', 'employee_careers.id')->whereNotNull('selected_candidate_id')->whereNull('approvals.is_approve')->whereMonth('employee_careers.start_date', now()->month)->count() }}
                @else
                  {{ DB::table('approvals')->join('employee_careers', 'approvals.employee_career_id', '=', 'employee_careers.id')->whereNotNull('selected_candidate_id')->whereNull('approvals.is_approve')->whereMonth('employee_careers.start_date', now()->month)->where('approvals.company_id', auth()->user()->company_id)->count() }}
                @endrole
              </h4>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-2 col-md-6">
      <div class="card">
        <div class="card-body px-4 py-4-5">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 d-flex justify-content-start ">
              <div class=" mb-2" style="background-color: #953b3bcc">
              </div>
            </div>
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
              <h6 class="text-muted font-semibold">Buka Verifikasi</h6>
              <h4 class="font-extrabold mb-0">
                @role('super-admin')
                  {{ DB::table('approvals')->whereNotNull('employee_id')->where('is_approve', 1)->whereMonth('created_at', now()->month)->count() }}
                @else
                  {{ DB::table('approvals')->whereNotNull('employee_id')->where('is_approve', 1)->whereMonth('created_at', now()->month)->where('company_id', auth()->user()->company_id)->count() }}
                @endrole
              </h4>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-2 col-md-6">
      <div class="card">
        <div class="card-body px-4 py-4-5">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 d-flex justify-content-start ">
              <div class=" mb-2" style="background-color: #314299ec">
              </div>
            </div>
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
              <h6 class="text-muted font-semibold">Promosi</h6>
              <h4 class="font-extrabold mb-0">
                @role('super-admin')
                  {{ DB::table('approvals')->join('employee_careers', 'approvals.employee_career_id', '=', 'employee_careers.id')->whereNotNull('approvals.employee_career_id')->whereNull('approvals.is_approve')->where('employee_careers.type', 'PROMOSI')->count() }}
                @else
                  {{ DB::table('approvals')->join('employee_careers', 'approvals.employee_career_id', '=', 'employee_careers.id')->whereNotNull('approvals.employee_career_id')->whereNull('approvals.is_approve')->where('employee_careers.type', 'PROMOSI')->where('company_id', auth()->user()->company_id)->count() }}
                @endrole
              </h4>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-2 col-md-6">
      <div class="card">
        <div class="card-body px-4 py-4-5">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 d-flex justify-content-start ">
              <div class=" mb-2" style="background-color: #57a042cc">
              </div>
            </div>
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
              <h6 class="text-muted font-semibold">Demosi</h6>
              <h4 class="font-extrabold mb-0">
                @role('super-admin')
                  {{ DB::table('approvals')->join('employee_careers', 'approvals.employee_career_id', '=', 'employee_careers.id')->whereNotNull('approvals.employee_career_id')->whereNull('approvals.is_approve')->where('employee_careers.type', 'DEMOSI')->count() }}
                @else
                  {{ DB::table('approvals')->join('employee_careers', 'approvals.employee_career_id', '=', 'employee_careers.id')->whereNotNull('approvals.employee_career_id')->whereNull('approvals.is_approve')->where('employee_careers.type', 'DEMOSI')->where('company_id', auth()->user()->company_id)->count() }}
                @endrole
              </h4>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-2 col-md-6">
      <div class="card">
        <div class="card-body px-4 py-4-5">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 d-flex justify-content-start ">
              <div class=" mb-2" style="background-color: #7b20a2cc">
              </div>
            </div>
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
              <h6 class="text-muted font-semibold">Mutasi</h6>
              <h4 class="font-extrabold mb-0">
                @role('super-admin')
                  {{ DB::table('approvals')->join('employee_careers', 'approvals.employee_career_id', '=', 'employee_careers.id')->whereNotNull('approvals.employee_career_id')->whereNull('approvals.is_approve')->where('employee_careers.type', 'MUTASI')->count() }}
                @else
                  {{ DB::table('approvals')->join('employee_careers', 'approvals.employee_career_id', '=', 'employee_careers.id')->whereNotNull('approvals.employee_career_id')->whereNull('approvals.is_approve')->where('employee_careers.type', 'MUTASI')->where('company_id', auth()->user()->company_id)->count() }}
                @endrole
              </h4>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-2 col-md-6">
      <div class="card">
        <div class="card-body px-4 py-4-5">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 d-flex justify-content-start ">
              <div class=" mb-2" style="background-color: #b4237fcc">
              </div>
            </div>
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
              <h6 class="text-muted font-semibold">Rotasi</h6>
              <h4 class="font-extrabold mb-0">
                @role('super-admin')
                  {{ DB::table('approvals')->join('employee_careers', 'approvals.employee_career_id', '=', 'employee_careers.id')->whereNotNull('approvals.employee_career_id')->whereNull('approvals.is_approve')->where('employee_careers.type', 'ROTASI')->count() }}
                @else
                  {{ DB::table('approvals')->join('employee_careers', 'approvals.employee_career_id', '=', 'employee_careers.id')->whereNotNull('approvals.employee_career_id')->whereNull('approvals.is_approve')->where('employee_careers.type', 'ROTASI')->where('company_id', auth()->user()->company_id)->count() }}
                @endrole
              </h4>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-2 col-md-6">
      <div class="card">
        <div class="card-body px-4 py-4-5">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 d-flex justify-content-start ">
              <div class=" mb-2" style="background-color: #b4a623cc">
              </div>
            </div>
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
              <h6 class="text-muted font-semibold">Pensiun</h6>
              <h4 class="font-extrabold mb-0">
                @role('super-admin')
                  {{ DB::table('approvals')->join('employee_careers', 'approvals.employee_career_id', '=', 'employee_careers.id')->whereNotNull('approvals.employee_career_id')->whereNull('approvals.is_approve')->where('employee_careers.type', 'PENSIUN')->count() }}
                @else
                  {{ DB::table('approvals')->join('employee_careers', 'approvals.employee_career_id', '=', 'employee_careers.id')->whereNotNull('approvals.employee_career_id')->whereNull('approvals.is_approve')->where('employee_careers.type', 'PENSIUN')->where('company_id', auth()->user()->company_id)->count() }}
                @endrole
              </h4>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-2 col-md-6">
      <div class="card">
        <div class="card-body px-4 py-4-5">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 d-flex justify-content-start ">
              <div class=" mb-2" style="background-color: #2b0f70cc">
              </div>
            </div>
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
              <h6 class="text-muted font-semibold">Resign</h6>
              <h4 class="font-extrabold mb-0">
                @role('super-admin')
                  {{ DB::table('approvals')->join('employee_careers', 'approvals.employee_career_id', '=', 'employee_careers.id')->whereNotNull('approvals.employee_career_id')->whereNull('approvals.is_approve')->where('employee_careers.type', 'RESIGN')->count() }}
                @else
                  {{ DB::table('approvals')->join('employee_careers', 'approvals.employee_career_id', '=', 'employee_careers.id')->whereNotNull('approvals.employee_career_id')->whereNull('approvals.is_approve')->where('employee_careers.type', 'RESIGN')->where('company_id', auth()->user()->company_id)->count() }}
                @endrole
              </h4>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-2 col-md-6">
      <div class="card">
        <div class="card-body px-4 py-4-5">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 d-flex justify-content-start ">
              <div class=" mb-2" style="background-color: #8e0321cc">
              </div>
            </div>
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
              <h6 class="text-muted font-semibold">Non-Aktif</h6>
              <h4 class="font-extrabold mb-0">
                @role('super-admin')
                  {{ DB::table('approvals')->join('employee_careers', 'approvals.employee_career_id', '=', 'employee_careers.id')->whereNotNull('approvals.employee_career_id')->whereNull('approvals.is_approve')->where('employee_careers.type', 'NON-AKTIF')->count() }}
                @else
                  {{ DB::table('approvals')->join('employee_careers', 'approvals.employee_career_id', '=', 'employee_careers.id')->whereNotNull('approvals.employee_career_id')->whereNull('approvals.is_approve')->where('employee_careers.type', 'NON-AKTIF')->where('company_id', auth()->user()->company_id)->count() }}
                @endrole
              </h4>
            </div>
          </div>
        </div>
      </div>
    </div>


  </div> --}}

  {{-- <div class="col-12 mb-4 text-center">
    <div class="col-md-4 mx-auto">
      <form method="GET" action="{{ route('dashboard.index') }}">
        <div class="d-flex justify-content-between align-items-center">
          <select name="month" class="form-control w-48" onchange="this.form.submit()">
            @for ($i = 1; $i <= 12; $i++)
              <option value="{{ $i }}" {{ $i == $selectedMonth ? 'selected' : '' }}>
                {{ Carbon\Carbon::create()->month($i)->format('F') }}
              </option>
            @endfor
          </select>

          <select name="year" class="form-control w-48" onchange="this.form.submit()">
            @for ($i = Carbon\Carbon::now()->year - 5; $i <= Carbon\Carbon::now()->year + 5; $i++)
              <option value="{{ $i }}" {{ $i == $selectedYear ? 'selected' : '' }}>
                {{ $i }}
              </option>
            @endfor
          </select>
        </div>
      </form>
    </div>
  </div>

  <div class="row">
    <h5 class="col-12 mb-4 text-center text-primary">Data Karyawan Perbulan</h5>

    <div class="col-6 col-lg-2 col-md-6 mb-4">
      <div class="card shadow-sm border-light rounded">
        <div class="card-body text-center">
          <h6 class="text-muted font-semibold">Karyawan Baru</h6>
          <h4 class="font-extrabold mb-0">{{ $data['karyawan_baru'] }}</h4>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-2 col-md-6 mb-4">
      <div class="card shadow-sm border-light rounded">
        <div class="card-body text-center">
          <h6 class="text-muted font-semibold">Buka Verifikasi</h6>
          <h4 class="font-extrabold mb-0">{{ $data['buka_verifikasi'] }}</h4>
        </div>
      </div>
    </div>

    @foreach ($data['categories'] as $label => $count)
      <div class="col-6 col-lg-2 col-md-6 mb-4">
        <div class="card shadow-sm border-light rounded">
          <div class="card-body text-center">
            <h6 class="text-muted font-semibold">{{ $label }}</h6>
            <h4 class="font-extrabold mb-0">{{ $count }}</h4>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <div class="row">
    <h5 class="col-12 mb-4 text-center text-primary">Data Karyawan Pertahun</h5>

    <div class="col-6 col-lg-2 col-md-6 mb-4">
      <div class="card shadow-sm border-light rounded">
        <div class="card-body text-center">
          <h6 class="text-muted font-semibold">Karyawan Baru</h6>
          <h4 class="font-extrabold mb-0">{{ $data['karyawan_baru'] }}</h4>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-2 col-md-6 mb-4">
      <div class="card shadow-sm border-light rounded">
        <div class="card-body text-center">
          <h6 class="text-muted font-semibold">Buka Verifikasi</h6>
          <h4 class="font-extrabold mb-0">{{ $data['buka_verifikasi'] }}</h4>
        </div>
      </div>
    </div>

    @foreach ($data['categories'] as $label => $count)
      <div class="col-6 col-lg-2 col-md-6 mb-4">
        <div class="card shadow-sm border-light rounded">
          <div class="card-body text-center">
            <h6 class="text-muted font-semibold">{{ $label }}</h6>
            <h4 class="font-extrabold mb-0">{{ $count }}</h4>
          </div>
        </div>
      </div>
    @endforeach
  </div> --}}

  {{-- <div class="col-12 mb-4 text-center">
    <div class="col-md-4 mx-auto">
      <form method="GET" action="{{ route('dashboard.index') }}">
        <div class="d-flex justify-content-between align-items-center">
          <select name="month" class="form-control w-48" onchange="this.form.submit()">
            @for ($i = 1; $i <= 12; $i++)
              <option value="{{ $i }}" {{ $i == $selectedMonth ? 'selected' : '' }}>
                {{ Carbon\Carbon::create()->month($i)->format('F') }}
              </option>
            @endfor
          </select>

          <select name="year" class="form-control w-48" onchange="this.form.submit()">
            @for ($i = Carbon\Carbon::now()->year - 5; $i <= Carbon\Carbon::now()->year + 5; $i++)
              <option value="{{ $i }}" {{ $i == $selectedYear ? 'selected' : '' }}>
                {{ $i }}
              </option>
            @endfor
          </select>
        </div>
      </form>
    </div>
  </div>

  <div class="row">
    <h5 class="col-12 mb-4 text-center text-primary">Data Karyawan Perbulan</h5>

    <div class="col-6 col-lg-2 col-md-6 mb-4">
      <div class="card shadow-sm border-light rounded">
        <div class="card-body text-center">
          <h6 class="text-muted font-semibold">Karyawan Baru</h6>
          <h4 class="font-extrabold mb-0">{{ $data['karyawan_baru'] }}</h4>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-2 col-md-6 mb-4">
      <div class="card shadow-sm border-light rounded">
        <div class="card-body text-center">
          <h6 class="text-muted font-semibold">Buka Verifikasi</h6>
          <h4 class="font-extrabold mb-0">{{ $data['buka_verifikasi'] }}</h4>
        </div>
      </div>
    </div>

    @foreach ($data['categories'] as $label => $count)
      <div class="col-6 col-lg-2 col-md-6 mb-4">
        <div class="card shadow-sm border-light rounded">
          <div class="card-body text-center">
            <h6 class="text-muted font-semibold">{{ $label }}</h6>
            <h4 class="font-extrabold mb-0">{{ $count }}</h4>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <div class="row">
    <h5 class="col-12 mb-4 text-center text-primary">Data Karyawan Pertahun</h5>

    <div class="col-6 col-lg-2 col-md-6 mb-4">
      <div class="card shadow-sm border-light rounded">
        <div class="card-body text-center">
          <h6 class="text-muted font-semibold">Karyawan Baru</h6>
          <h4 class="font-extrabold mb-0">{{ $data['karyawan_baru'] }}</h4>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-2 col-md-6 mb-4">
      <div class="card shadow-sm border-light rounded">
        <div class="card-body text-center">
          <h6 class="text-muted font-semibold">Buka Verifikasi</h6>
          <h4 class="font-extrabold mb-0">{{ $data['buka_verifikasi'] }}</h4>
        </div>
      </div>
    </div>

    @foreach ($data['categories'] as $label => $count)
      <div class="col-6 col-lg-2 col-md-6 mb-4">
        <div class="card shadow-sm border-light rounded">
          <div class="card-body text-center">
            <h6 class="text-muted font-semibold">{{ $label }}</h6>
            <h4 class="font-extrabold mb-0">{{ $count }}</h4>
          </div>
        </div>
      </div>
    @endforeach
  </div> --}}

  <div class="col-12 mb-4 text-center">
    <div class="col-md-4 mx-auto">
      <form id="filterForm" method="GET" action="{{ route('dashboard.index') }}">
        <div class="d-flex justify-content-between align-items-center">
          <select name="month" class="form-control w-48" onchange="this.form.submit()">
            @for ($i = 1; $i <= 12; $i++)
              <option value="{{ $i }}" {{ $i == $selectedMonth ? 'selected' : '' }}>
                {{ Carbon\Carbon::create()->month($i)->format('F') }}
              </option>
            @endfor
          </select>

          <select name="year" class="form-control w-48" onchange="this.form.submit()">
            @for ($i = Carbon\Carbon::now()->year - 5; $i <= Carbon\Carbon::now()->year + 5; $i++)
              <option value="{{ $i }}" {{ $i == $selectedYear ? 'selected' : '' }}>
                {{ $i }}
              </option>
            @endfor
          </select>

          <!-- Reset Button -->
          <button type="button" class="btn btn-secondary" onclick="resetFilters()">Reset</button>
        </div>
      </form>
    </div>
  </div>

  <div class="row">
    <h5 class="col-12 mb-4 text-center text-primary">
      Data Karyawan Perbulan
      ({{ \Carbon\Carbon::create()->month((int) $selectedMonth)->locale('id')->translatedFormat('F') }} -
      {{ $selectedYear }} )
    </h5>


    <div class="col-6 col-lg-2 col-md-6 mb-4">
      <div class="card shadow-sm border-light rounded">
        <div class="card-body text-center">
          <h6 class="text-muted font-semibold">Karyawan Baru</h6>
          <h4 class="font-extrabold mb-0">{{ $dataPerMonth['karyawan_baru'] }}</h4>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-2 col-md-6 mb-4">
      <div class="card shadow-sm border-light rounded">
        <div class="card-body text-center">
          <h6 class="text-muted font-semibold">Buka Verifikasi</h6>
          <h4 class="font-extrabold mb-0">{{ $dataPerMonth['buka_verifikasi'] }}</h4>
        </div>
      </div>
    </div>

    @foreach ($dataPerMonth['categories'] as $label => $count)
      <div class="col-6 col-lg-2 col-md-6 mb-4">
        <div class="card shadow-sm border-light rounded">
          <div class="card-body text-center">
            <h6 class="text-muted font-semibold">{{ $label }}</h6>
            <h4 class="font-extrabold mb-0">{{ $count }}</h4>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <div class="row">
    <h5 class="col-12 mb-4 text-center text-primary">Data Karyawan Pertahun ({{ $selectedYear }})</h5>

    <div class="col-6 col-lg-2 col-md-6 mb-4">
      <div class="card shadow-sm border-light rounded">
        <div class="card-body text-center">
          <h6 class="text-muted font-semibold">Karyawan Baru</h6>
          <h4 class="font-extrabold mb-0">{{ $dataPerYear['karyawan_baru'] }}</h4>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-2 col-md-6 mb-4">
      <div class="card shadow-sm border-light rounded">
        <div class="card-body text-center">
          <h6 class="text-muted font-semibold">Buka Verifikasi</h6>
          <h4 class="font-extrabold mb-0">{{ $dataPerYear['buka_verifikasi'] }}</h4>
        </div>
      </div>
    </div>

    @foreach ($dataPerYear['categories'] as $label => $count)
      <div class="col-6 col-lg-2 col-md-6 mb-4">
        <div class="card shadow-sm border-light rounded">
          <div class="card-body text-center">
            <h6 class="text-muted font-semibold">{{ $label }}</h6>
            <h4 class="font-extrabold mb-0">{{ $count }}</h4>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        {{-- <div class="card-header">
          <h5 class="card-title">Horizontal Navs</h5>
        </div> --}}
        <div class="card-body">
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <a class="nav-link active" id="employee-tab" data-bs-toggle="tab" href="#employee" role="tab"
                aria-controls="employee" aria-selected="true">Karyawan</a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="gender-tab" data-bs-toggle="tab" href="#gender" role="tab"
                aria-controls="gender" aria-selected="true">Jenis Kelamin</a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="educational-tab" data-bs-toggle="tab" href="#educational" role="tab"
                aria-controls="educational" aria-selected="false">Pendidikan</a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="position-tab" data-bs-toggle="tab" href="#position" role="tab"
                aria-controls="position" aria-selected="false">Level Jabatan</a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="age-tab" data-bs-toggle="tab" href="#age" role="tab"
                aria-controls="age" aria-selected="false">Usia</a>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="employee" role="tabpanel" aria-labelledby="employee-tab">
              @include('pages.dashboard.table.employee-categories')
            </div>
            <div class="tab-pane fade show" id="gender" role="tabpanel" aria-labelledby="gender-tab">
              @include('pages.dashboard.table.gender')
            </div>
            <div class="tab-pane fade" id="educational" role="tabpanel" aria-labelledby="educational-tab">
              @include('pages.dashboard.table.educational')
            </div>
            <div class="tab-pane fade" id="position" role="tabpanel" aria-labelledby="position-tab">
              @include('pages.dashboard.table.position')
            </div>
            <div class="tab-pane fade" id="age" role="tabpanel" aria-labelledby="age-tab">
              @include('pages.dashboard.table.age')
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @foreach ($companies as $company)
    <div class="row">
      <h5>Karyawan {{ $company->name }}</h5>

      <h6 class="mt-2">Divisi Direktorat</h6>
      @forelse($company->divisions->where('directorate.is_non', true) as $division)
        <div class="col-6 col-lg-3 col-md-6">
          <div class="card">
            <div class="card-body ">
              <div class="row">
                <div class="col-md-12">
                  @php
                    $positionsWithActiveEmployeeCount = $division
                        ->positions()
                        ->whereHas('employee', function ($query) {
                            $query
                                ->where('employee_status', 'AKTIF')
                                ->when(!Auth::user()->hasRole('super-admin'), function ($query) {
                                    $query->where('company_id', Auth::user()->company_id);
                                });
                        })
                        ->count();

                  @endphp
                  <h6 class="text-muted font-semibold">
                    <a href="{{ route('getDivisionEmployee', $division->id) }}"> {{ $division->code }}</a>
                  </h6>
                  <h4 class="font-extrabold mb-0 float-end">
                    {{ $positionsWithActiveEmployeeCount }}
                  </h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12">
          <div class="card">
            <div class="card-body ">
              <div class="row">
                <h6 class="text-muted text-center font-semibold">
                  Empty
                </h6>
              </div>
            </div>
          </div>
        </div>
      @endforelse

      <h6 class="mt-2">Divisi Non-Direktorat</h6>
      @forelse($company->divisions->where('directorate.is_non', false) as $division)
        <div class="col-6 col-lg-3 col-md-6">
          <div class="card">
            <div class="card-body ">
              <div class="row">
                <div class="col-md-12">
                  <h6 class="text-muted font-semibold">
                    <a href="{{ route('getDivisionEmployee', $division->id) }}"> {{ $division->code }}</a>
                  </h6>
                  @php
                    $positionsWithEmployeeCount = $division->positions
                        ->filter(function ($position) {
                            return $position->employee !== null;
                        })
                        ->count();
                  @endphp
                  <h4 class="font-extrabold mb-0 float-end">
                    {{ $positionsWithEmployeeCount }}
                  </h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12">
          <div class="card">
            <div class="card-body ">
              <div class="row">
                <h6 class="text-muted text-center font-semibold">
                  Empty
                </h6>
              </div>
            </div>
          </div>
        </div>
      @endforelse

    </div>
  @endforeach

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center ">
            <h4>Data Karyawan Pertahun</h4>
            <div class="col-md-2">
              <label for="year-select">Pilih Tahun</label>
              <select id="year-select" class="form-control">
                @for ($year = 2015; $year <= date('Y'); $year++)
                  <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>{{ $year }}
                  </option>
                @endfor
              </select>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div id="employee-data"></div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Kontrak Berakhir Bulan Depan</h4>
        </div>
        <div class="card-body" style="word-break: break-all">
          <div class="table-responsive">
            <table class="table" id="table3" style="font-size: 80%">
              <thead>
                <tr>
                  <th scope="col" style="width: 5%">#</th>
                  <th scope="col"></th>
                  <th scope="col">NIK</th>
                  <th scope="col">Nama</th>
                  <th scope="col">No. Kontrak</th>
                  <th scope="col">Tgl Mulai</th>
                  <th scope="col">Tgl Berakhir</th>
                  <th scope="col">Durasi</th>
                  <th scope="col">Kontrak Ke- </th>
                  <th scope="col">Divisi</th>
                  <th scope="col" class="text-center">PK</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($contractsIncoming as $contract)
                  <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td>
                      @if ($contract->employee->photo)
                        <div class="fixed-frame">
                          <img src="{{ asset('storage/' . $contract->employee->photo) }}" data-fancybox
                            alt="Icon User" class="framed-image" style="cursor: pointer">
                        </div>
                      @else
                        <div class="fixed-frame">
                          No Image
                        </div>
                      @endif
                    </td>

                    <td>
                      {{ $contract->employee->nik ?? 'N/A' }}
                    </td>

                    <td>
                      {{ $contract->employee->name ?? 'N/A' }}
                    </td>

                    <td>
                      {{ $contract->contract_number ?? 'N/A' }}
                    </td>

                    <td>
                      {{ Carbon\Carbon::parse($contract->start_date)->translatedFormat('d-m-Y') ?? 'N/A' }}
                    </td>

                    <td>
                      {{ Carbon\Carbon::parse($contract->end_date)->translatedFormat('d-m-Y') ?? 'N/A' }}
                    </td>

                    <td>
                      {{ $contract->duration ?? 'N/A' }} Bulan
                    </td>

                    <td>
                      {{ $contract->contract_sequence_number ?? 'N/A' }}
                    </td>

                    <td>
                      {{ $contract->employee->position->division->code ?? 'N/A' }}
                    </td>

                    <td class="text-center">
                      @if ($contract->contractKpi)
                        {{ $contract->contractKpi->grade }} <br>
                        @if ($contract->contractKpi->contract_recommendation)
                          <span class="badge bg-success">Kontrak Di Perpanjang</span>
                        @else
                          <span class="badge bg-danger">Kontrak tidak diperpanjang</span>
                        @endif
                      @else
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                          data-bs-target="#modal-form-add-kpi">
                          <i class="bi bi-plus-lg"></i>
                          PK
                        </button>
                        @include('pages.employee.personal-data.form.kpi.modal-create')
                      @endif
                    </td>

                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>


    <div class="col-12">
      <div class="card">
        <div class="card-header">

          <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-normal mb-0 text-body">Daftar Kontrak Sudah Berakhir</h5>

            <div class="row">
              <!-- Export Button -->
              <a id="export-contracts-button" class="btn btn-outline-primary block mb-1"
                href="{{ route('contract.exportExpired') }}">
                Export Kontrak
              </a>

              <!-- Dropdown for Selecting Month -->
              <div class="col-md-5">
                <label for="month-select-contract">Pilih Bulan</label>
                <select id="month-select-contract" class="form-control">
                  @foreach (range(1, 12) as $month)
                    <option value="{{ $month }}" {{ $month == date('n') ? 'selected' : '' }}>
                      {{ DateTime::createFromFormat('!m', $month)->format('F') }}
                    </option>
                  @endforeach
                </select>
              </div>

              <!-- Dropdown for Selecting Year -->
              <div class="col-md-5">
                <label for="year-select-contract">Pilih Tahun</label>
                <select id="year-select-contract" class="form-control">
                  @for ($year = 2015; $year <= date('Y'); $year++)
                    <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>
                      {{ $year }}
                    </option>
                  @endfor
                </select>
              </div>

              <!-- Reset Button -->
              <div class="col-md-2 my-4">
                <button id="reset-filters" class="btn btn-secondary ">Reset</button>
              </div>

            </div>
          </div>

        </div>
        <div class="card-body" style="word-break: break-all">
          <div id="contracts-list">
            @include('pages.dashboard.contract-expired-list', ['contractsExpired' => $contractsExpired])
          </div>
        </div>
      </div>

    </div>

  </div>

</div>

<script src="{{ asset('dist/assets/extensions/apexcharts/apexcharts.min.js') }}"></script>


{{-- <script>
  var employeeActiveData = @json($employeeActiveData); // Active employee data
  var employeeNonActiveData = @json($employeeNonActiveData); // Non-active employee data

  // Calculate total employees per month
  var totalData = employeeActiveData.map((val, index) => val + employeeNonActiveData[index]);

  var options = {
    chart: {
      type: 'bar',
      height: 400,
      stacked: true,
    },
    series: [{
        name: 'Karyawan Aktif',
        data: employeeActiveData,
      },
      {
        name: 'Karyawan Non-Aktif',
        data: employeeNonActiveData,
      },
      // {
      //   name: 'total',
      //   data: totalData,
      //   color: 'transparent',
      // },
    ],
    xaxis: {
      categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
    },
    plotOptions: {
      bar: {
        horizontal: false,
      },
    },
    colors: ['#1E90FF', '#FF6347'],
    dataLabels: {
      enabled: true,
      style: {
        fontSize: ['16px'],
        colors: ['#fff', '#fff', '#ff9900'] // Set label colors (black in this example for clarity)
      },
      formatter: function(val, opts) {
        return val;
      },
    },
    legend: {
      position: 'top',
    },
  };

  var chart = new ApexCharts(document.querySelector("#employee-data"), options);
  chart.render();
</script> --}}


{{-- <script>
  document.addEventListener('DOMContentLoaded', function() {
    // Data passed from the controller
    var employeeActiveData = @json($employeeActiveData); // e.g., [10, 20, 15, ..., 5]
    var employeeNonActiveData = @json($employeeNonActiveData); // e.g., [2, 5, 3, ..., 1]

    var options = {
      chart: {
        type: 'bar',
        height: 350,
        stacked: true, // Enable stacking
      },
      series: [{
          name: 'Karyawan Aktif',
          data: employeeActiveData,
        },
        {
          name: 'Karyawan Non-Aktif',
          data: employeeNonActiveData,
        }
      ],
      xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
          'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
        ],
      },
      plotOptions: {
        bar: {
          horizontal: false, // Keep bars vertical
          dataLabels: {
            position: 'top', // Position data labels at the top of each segment
          },
        },
      },
      dataLabels: {
        enabled: true,
        formatter: function(val) {
          return val;
        },
        style: {
          colors: ['#fff']
        }
      },
      colors: ['#1E90FF', '#FF6347'], // Customize colors
      legend: {
        position: 'top',
      },
      title: {
        text: `Employee Data for the Year {{ date('Y') }}`,
        align: 'center',
        style: {
          fontSize: '20px',
          fontWeight: 'bold',
          color: '#e3a520',
        }
      },
      tooltip: {
        y: {
          formatter: function(val) {
            return val + " Karyawan";
          }
        }
      },
    };

    var chart = new ApexCharts(document.querySelector("#employee-data"), options);
    chart.render();
    // Year selection and chart update logic
    document.getElementById('year-select').addEventListener('change', function() {
      var selectedYear = this.value;

      fetch(`/employee-chart-data/${selectedYear}`)
        .then(response => response.json())
        .then(data => {
          chart.updateSeries([{
              name: 'Karyawan Aktif',
              data: data.employeeActiveData,
            },
            {
              name: 'Karyawan Non-Aktif',
              data: data.employeeNonActiveData,
            }
          ]);
          chart.updateOptions({
            title: {
              text: `Employee Data for the Year ${selectedYear}`,
            }
          });
        })
        .catch(error => console.error('Error fetching data:', error));
    });
  });
</script> --}}

<script>
  // document.addEventListener('DOMContentLoaded', () => {
  //   const monthSelect = document.getElementById('month-select-contract');
  //   const yearSelect = document.getElementById('year-select-contract');
  //   const contractsList = document.getElementById('contracts-list');

  //   function fetchFilteredContracts() {
  //     const month = monthSelect.value;
  //     const year = yearSelect.value;

  //     fetch(`/contracts/expired?month=${month}&year=${year}`)
  //       .then(response => response.text())
  //       .then(html => {
  //         contractsList.innerHTML = html;
  //       })
  //       .catch(error => console.error('Error fetching filtered contracts:', error));
  //   }

  //   monthSelect.addEventListener('change', fetchFilteredContracts);
  //   yearSelect.addEventListener('change', fetchFilteredContracts);
  // });

  document.addEventListener('DOMContentLoaded', () => {
    const monthSelect = document.getElementById('month-select-contract');
    const yearSelect = document.getElementById('year-select-contract');
    const contractsList = document.getElementById('contracts-list');
    const resetButton = document.getElementById('reset-filters');
    const exportButton = document.getElementById('export-contracts-button'); // Add this line

    // Function to fetch filtered contracts based on selected month and year
    function fetchFilteredContracts() {
      const month = monthSelect.value;
      const year = yearSelect.value;

      const url = `{{ route('contracts.expired') }}?month=${month}&year=${year}`;

      fetch(url)
        .then(response => response.text())
        .then(html => {
          contractsList.innerHTML = html; // Update the contracts list with the fetched data
        })
        .catch(error => console.error('Error fetching filtered contracts:', error));
    }

    // Function to update the export button's href dynamically
    const updateExportHref = () => {
      const selectedMonth = monthSelect.value;
      const selectedYear = yearSelect.value;
      const baseHref =
        "{{ route('contract.exportExpired') }}"; // This should be replaced with the correct server-side route
      exportButton.href = `${baseHref}?month=${selectedMonth}&year=${selectedYear}`; // Update export button href
    };

    // Function to reset filters to current month and year
    function resetFilters() {
      monthSelect.value = new Date().getMonth() + 1; // Reset to current month (1-based)
      yearSelect.value = new Date().getFullYear(); // Reset to current year
      fetchFilteredContracts(); // Fetch the unfiltered data for the current month and year
    }

    // Add event listeners for changing month and year
    monthSelect.addEventListener('change', () => {
      fetchFilteredContracts(); // Fetch data when month changes
      updateExportHref(); // Update export button URL when month changes
    });

    yearSelect.addEventListener('change', () => {
      fetchFilteredContracts(); // Fetch data when year changes
      updateExportHref(); // Update export button URL when year changes
    });

    // Add event listener for reset button
    resetButton.addEventListener('click', resetFilters);

    // Initial fetch to load contracts with default values
    fetchFilteredContracts();
    updateExportHref(); // Initialize export button href on page load
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Data passed from the controller
    var employeeActiveData = @json($employeeActiveData);
    var employeeNonActiveData = @json($employeeNonActiveData);

    var options = {
      chart: {
        type: 'bar',
        height: 350,
        stacked: true,
      },
      series: [{
          name: 'Karyawan Aktif',
          data: employeeActiveData
        },
        {
          name: 'Karyawan Non-Aktif',
          data: employeeNonActiveData
        }
      ],
      xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      },
      plotOptions: {
        bar: {
          horizontal: false,
          dataLabels: {
            position: 'top'
          },
        },
      },
      dataLabels: {
        enabled: true,
        formatter: function(val) {
          return val;
        },
        style: {
          colors: ['#fff']
        }
      },
      colors: ['#1E90FF', '#FF6347'],
      legend: {
        position: 'top'
      },
      title: {
        text: `Employee Data for the Year {{ date('Y') }}`,
        align: 'center',
        style: {
          fontSize: '20px',
          fontWeight: 'bold',
          color: '#e3a520'
        }
      },
      tooltip: {
        y: {
          formatter: function(val) {
            return val + " Karyawan";
          }
        }
      },
    };

    var chart = new ApexCharts(document.querySelector("#employee-data"), options);
    chart.render();

    // Year selection and chart update logic
    document.getElementById('year-select').addEventListener('change', function() {
      var selectedYear = this.value;

      // Use route() helper for dynamic URL generation
      fetch(`{{ route('employee-chart-data', ['year' => '__YEAR__']) }}`.replace('__YEAR__', selectedYear))
        .then(response => response.json())
        .then(data => {
          chart.updateSeries([{
              name: 'Karyawan Aktif',
              data: data.employeeActiveData
            },
            {
              name: 'Karyawan Non-Aktif',
              data: data.employeeNonActiveData
            }
          ]);
          chart.updateOptions({
            title: {
              text: `Employee Data for the Year ${selectedYear}`
            }
          });
        })
        .catch(error => console.error('Error fetching data:', error));
    });
  });
</script>

<script>
  Fancybox.bind("[data-fancybox]", {
    // Your custom options
  });
</script>

<style>
  .fixed-frame {
    width: 80px;
    height: 130px;
    /* border: 0.5px solid #bcbbbb; */
    /* Frame border */
    border-radius: 10px;
    /* Rounded corners */
    padding: 1px;
    /* background: #e3a520; */
    /* Padding inside the frame */
    box-sizing: border-box;
    /* Ensures border and padding are included in the 100px size */
    /* box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5); */
    /* Optional shadow effect */
    overflow: hidden;
    /* Prevents image overflow */
    display: flex;
    /* Centers the image */
    justify-content: center;
    align-items: center;
  }

  .framed-image {
    max-width: 100%;
    max-height: 100%;
    object-fit: cover;
    /* Ensures the image covers the frame while maintaining proportions */
    border-radius: 7px;
    /* Optional: ensure the image corners match the frame */
  }
</style>

<script>
  function resetFilters() {
    // Get the current month and year
    const currentMonth = {{ Carbon\Carbon::now()->month }};
    const currentYear = {{ Carbon\Carbon::now()->year }};

    // Set the dropdown values to the current month and year
    document.querySelector('select[name="month"]').value = currentMonth;
    document.querySelector('select[name="year"]').value = currentYear;

    // Submit the form to reload the page with the default values
    document.getElementById('filterForm').submit();
  }
</script>


@endsection

@push('after-script')
@endpush
