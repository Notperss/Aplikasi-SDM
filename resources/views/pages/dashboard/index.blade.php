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
              <h6 class="text-muted font-semibold">TOTAL SEMUA KARYAWAN</h6>
              <h4 class="font-extrabold mb-0">

                {{ $allActiveEmployee }}

              </h4>
            </div>

            </a>
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

            <a href="{{ route('employeeInOut', ['status' => 'employeeIn', 'isMonth' => true]) }}">
              <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <h6 class="text-muted font-semibold">KARYAWAN MASUK BULAN INI</h6>
                <h4 class="font-extrabold mb-0">

                  {{ $activePermonth }}

                </h4>
              </div>
            </a>

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
            <a href="{{ route('employeeInOut', ['status' => 'employeeOut', 'isMonth' => true]) }}">
              <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <h6 class="text-muted font-semibold">KARYAWAN KELUAR BULAN INI</h6>
                <h4 class="font-extrabold mb-0">

                  {{ $nonActivePermonth }}

                </h4>
                </h6>
              </div>
            </a>
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
            <a href="{{ route('employeeInOut', ['status' => 'employeeIn']) }}">
              <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <h6 class="text-muted font-semibold">KARYAWAN MASUK TAHUN INI</h6>
                <h4 class="font-extrabold mb-0">

                  {{ $activePeryear }}

                </h4>
              </div>
            </a>
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
            <a href="{{ route('employeeInOut', ['status' => 'employeeOut']) }}">

              <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <h6 class="text-muted font-semibold">KARYAWAN KELUAR TAHUN INI</h6>
                <h4 class="font-extrabold mb-0">
                  {{ $nonActivePeryear }}

                </h4>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-6 col-lg-2 col-md-6">
      <div class="card">
        <div class="card-body px-4 py-4-5">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 d-flex justify-content-start ">
              <div class="stats-icon mb-2" style="background-color: #fff">
                <svg id="user" width="24" height="24" viewBox="0 0 24 24" fill="none"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M23.3466 16.5689C22.6166 14.2829 20.6816 12.9749 18.0266 12.9749H18.0076C16.9256 12.9649 15.9586 13.1829 15.1426 13.5999C17.4196 14.3309 19.1076 15.9529 19.8846 18.2479C21.1176 18.0769 22.1896 17.6979 23.1376 17.1189L23.4506 16.9199L23.3466 16.5689Z"
                    fill="#000000"></path>
                  <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M16.2905 11.2484C16.8025 11.5334 17.3815 11.6944 18.0075 11.6944C19.9705 11.6944 21.5635 10.1004 21.5635 8.13738C21.5635 6.18438 19.9705 4.59038 18.0075 4.59038C17.6185 4.59038 17.2485 4.65738 16.8975 4.77038C17.4095 5.59638 17.7035 6.57238 17.7035 7.60638C17.7035 9.01038 17.1815 10.2814 16.2905 11.2484Z"
                    fill="#000000"></path>
                  <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M9.31032 13.5815C8.51332 13.1835 7.57432 12.9745 6.51232 12.9745H6.47432C3.81932 12.9745 1.88432 14.2835 1.16332 16.5685L1.04932 16.9195L1.36232 17.1185C2.26332 17.6695 3.32632 18.0385 4.51132 18.2285C5.29832 15.9245 7.01532 14.2925 9.31032 13.5815Z"
                    fill="#000000"></path>
                  <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M6.49346 11.6941C7.11946 11.6941 7.69746 11.5331 8.21046 11.2481C7.31846 10.2811 6.79646 9.01007 6.79646 7.60607C6.79646 6.57307 7.09046 5.59607 7.60346 4.77107C7.25246 4.65707 6.88246 4.59007 6.49346 4.59007C4.53046 4.59007 2.93646 6.18407 2.93646 8.13707C2.93646 10.1011 4.53046 11.6941 6.49346 11.6941Z"
                    fill="#000000"></path>
                  <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M12.216 14.1034C12.2 14.1034 12.185 14.1034 12.17 14.1034C8.756 14.1034 6.267 15.7814 5.341 18.7104L5.229 19.0644L5.546 19.2584C7.354 20.3604 9.514 20.8964 12.149 20.8964H12.234C14.871 20.8964 17.032 20.3604 18.84 19.2584L19.158 19.0644L19.046 18.7104C18.119 15.7814 15.631 14.1034 12.216 14.1034Z"
                    fill="#000000"></path>
                  <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M12.2502 12.1186C14.7362 12.1186 16.7582 10.0966 16.7582 7.61058C16.7582 5.12558 14.7362 3.10358 12.2502 3.10358C9.76419 3.10358 7.74219 5.12558 7.74219 7.61058C7.74219 10.0966 9.76419 12.1186 12.2502 12.1186Z"
                    fill="#000000"></path>
                </svg>
              </div>
            </div>
            {{-- @php
              $currentYear = Carbon\Carbon::now()->year;

              $retirementCount = \App\Models\Employee\Employee::query()
                  ->where('employee_status', 'AKTIF') // Only count active employees
                  ->whereYear('dob', '<=', $currentYear - 55) // Employees born 55 years ago or earlier
                  ->whereYear('dob', '>', $currentYear - 56) // Ensure they turn 55 this year
                  ->when(!auth()->user()->hasRole('super-admin'), function ($query) {
                      $query->where('company_id', auth()->user()->company_id);
                  })
                  ->count();
            @endphp --}}
            <a href="{{ route('employeeInOut', ['status' => 'retirement']) }}">

              <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <h6 class="text-muted font-semibold"><small>KARYAWAN PENSIUN TAHUN INI, <br>(USIA >= 55 TAHUN)</small>
                </h6>
                <h4 class="font-extrabold mb-0">
                  {{ $retirementCount }}
                </h4>
              </div>
            </a>


          </div>
        </div>
      </div>
    </div>
  </div>

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
            @for ($i = Carbon\Carbon::now()->year - 5; $i <= Carbon\Carbon::now()->year; $i++)
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
      Data Log Karyawan Perbulan
      ({{ \Carbon\Carbon::create()->month((int) $selectedMonth)->locale('id')->translatedFormat('F') }} -
      {{ $selectedYear }} )
    </h5>


    <div class="col-6 col-lg-2 col-md-6 mb-4">
      <div class="card shadow-sm border-light rounded">
        <div class="card-body text-center">
          <h6 class="text-muted font-semibold">KARYAWAN BARU</h6>
          <h4 class="font-extrabold mb-0">
            {{ $dataPerMonth['karyawan_baru'] }}
          </h4>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-2 col-md-6 mb-4">
      <div class="card shadow-sm border-light rounded">
        <div class="card-body text-center">
          <h6 class="text-muted font-semibold">BUKA VERIFIKASI</h6>
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
    <h5 class="col-12 mb-4 text-center text-primary">Data Log Karyawan Pertahun ({{ $selectedYear }})</h5>

    <div class="col-6 col-lg-2 col-md-6 mb-4">
      <div class="card shadow-sm border-light rounded">
        <div class="card-body text-center">
          <h6 class="text-muted font-semibold">KARYAWAN BARU</h6>
          <a href="{{ route('approval.log', ['year' => $selectedYear, 'type' => 'KARYAWAN BARU']) }}">
            <h4 class="font-extrabold mb-0">{{ $dataPerYear['karyawan_baru'] }}</h4>
          </a>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-2 col-md-6 mb-4">
      <div class="card shadow-sm border-light rounded">
        <div class="card-body text-center">
          <h6 class="text-muted font-semibold">BUKA VERIFIKASI</h6>
          <h4 class="font-extrabold mb-0">
            <a href="{{ route('approval.log', ['year' => $selectedYear, 'type' => 'BUKA VERIFIKASI']) }}">
              {{ $dataPerYear['buka_verifikasi'] }}
            </a>
          </h4>
        </div>
      </div>
    </div>

    @foreach ($dataPerYear['categories'] as $label => $count)
      <div class="col-6 col-lg-2 col-md-6 mb-4">
        <div class="card shadow-sm border-light rounded">
          <div class="card-body text-center">
            <h6 class="text-muted font-semibold">{{ $label }}</h6>
            <h4 class="font-extrabold mb-0">
              <a href="{{ route('approval.log', ['year' => $selectedYear, 'type' => $label]) }}">
                {{ $count }}
              </a>
            </h4>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <div class="row">
    <h5 class="col-12 mb-4 text-center text-primary">Data Aktif Karyawan Pertahun ({{ $selectedYear }})</h5>

    @for ($month = 1; $month <= 12; $month++)
      <div class="col-6 col-lg-2 col-md-6 mb-4">
        <div class="card shadow-sm border-light rounded">
          <div class="card-body text-center">
            {{-- <h6 class="text-muted font-semibold">{{ \Carbon\Carbon::create()->month($month)->format('F') }}</h6>
            <h4 class="font-extrabold mb-0"> --}}

            <div class="d-flex justify-content-between align-items-center">
              <h6 class="text-muted font-semibold">
                <a href="{{ route('employeeDataPerMonth', ['year' => $selectedYear, 'month' => $month]) }}">
                  {{ strtoupper(\Carbon\Carbon::create()->locale('id')->month($month)->translatedFormat('F')) }}</a>
              </h6>
              <span class="h6"> {{ $monthlyEmployeeActive[$month] }} </span>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <h6 class="text-muted font-semibold" style="font-size: 80%">
                MASUK
              </h6>
              <span class="h6"> {{ $employeeIn[$month] }} </span>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <h6 class="text-muted font-semibold" style="font-size: 80%">
                KELUAR
              </h6>
              <span class="h6"> {{ $employeeOut[$month] }} </span>
            </div>

            <!-- You can add additional data here if needed -->
            </h4>
          </div>
        </div>
      </div>
    @endfor
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">

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
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="religion-tab" data-bs-toggle="tab" href="#religion" role="tab"
                aria-controls="religion" aria-selected="false">Agama</a>
            </li>
          </ul>

          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="employee" role="tabpanel" aria-labelledby="employee-tab"
              data-url="{{ route('dashboard.employeeCategory') }}">
              <!-- Loading Spinner -->
              <div class="d-flex justify-content-center align-items-center" id="employee-loader">
                <div class="spinner-border text-primary" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
              </div>
              <!-- Content will be loaded dynamically -->
            </div>
            <div class="tab-pane fade" id="gender" role="tabpanel" aria-labelledby="gender-tab"
              data-url="{{ route('dashboard.gender') }}">
              <!-- Loading Spinner -->
              <div class="d-flex justify-content-center align-items-center" id="gender-loader">
                <div class="spinner-border text-primary">
                  <span class="visually-hidden">Loading...</span>
                </div>
              </div>
              <!-- Content will be loaded dynamically -->
            </div>
            <div class="tab-pane fade" id="educational" role="tabpanel" aria-labelledby="educational-tab"
              data-url="{{ route('dashboard.educational') }}">
              <!-- Loading Spinner -->
              <div class="d-flex justify-content-center align-items-center" id="educational-loader">
                <div class="spinner-border text-primary">
                  <span class="visually-hidden">Loading...</span>
                </div>
              </div>
              <!-- Content will be loaded dynamically -->
            </div>
            <div class="tab-pane fade" id="position" role="tabpanel" aria-labelledby="position-tab"
              data-url="{{ route('dashboard.position') }}">
              <!-- Loading Spinner -->
              <div class="d-flex justify-content-center align-items-center" id="position-loader">
                <div class="spinner-border text-primary">
                  <span class="visually-hidden">Loading...</span>
                </div>
              </div>
              <!-- Content will be loaded dynamically -->
            </div>
            <div class="tab-pane fade" id="age" role="tabpanel" aria-labelledby="age-tab"
              data-url="{{ route('dashboard.age') }}">
              <!-- Loading Spinner -->
              <div class="d-flex justify-content-center align-items-center" id="age-loader">
                <div class="spinner-border text-primary">
                  <span class="visually-hidden">Loading...</span>
                </div>
              </div>
              <!-- Content will be loaded dynamically -->
            </div>
            <div class="tab-pane fade" id="religion" role="tabpanel" aria-labelledby="religion-tab"
              data-url="{{ route('dashboard.religion') }}">
              <!-- Loading Spinner -->
              <div class="d-flex justify-content-center align-items-center" id="religion-loader">
                <div class="spinner-border text-primary">
                  <span class="visually-hidden">Loading...</span>
                </div>
              </div>
              <!-- Content will be loaded dynamically -->
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

                    $positionsWithActiveEmployeeOfficeCount = $division
                        ->positions()
                        ->whereHas('employee', function ($query) {
                            $query
                                ->where('employee_status', 'AKTIF')
                                ->whereHas('employeeCategory', function ($query) {
                                    $query->where('name', 'OFFICE'); // Adjust based on your relationship
                                })
                                ->when(!Auth::user()->hasRole('super-admin'), function ($query) {
                                    $query->where('company_id', Auth::user()->company_id);
                                });
                        })
                        ->count();

                    $positionsWithActiveEmployeeNonOfficeCount = $division
                        ->positions()
                        ->whereHas('employee', function ($query) {
                            $query
                                ->where('employee_status', 'AKTIF')
                                ->whereHas('employeeCategory', function ($query) {
                                    $query->where('name', 'NON-OFFICE'); // Adjust based on your relationship
                                })
                                ->when(!Auth::user()->hasRole('super-admin'), function ($query) {
                                    $query->where('company_id', Auth::user()->company_id);
                                });
                        })
                        ->count();

                    $levelsWithCounts = $division
                        ->positions()
                        ->whereHas('employee', function ($query) {
                            $query
                                ->where('employee_status', 'AKTIF')
                                ->when(!Auth::user()->hasRole('super-admin'), function ($query) {
                                    $query->where('company_id', Auth::user()->company_id);
                                });
                        })
                        ->with('level')
                        ->get()
                        ->sortBy('level.id')
                        ->groupBy('level.name') // Group positions by level name
                        ->map(function ($positions) {
                            return $positions->count(); // Count positions for each level
                        });
                  @endphp
                  <div class="d-flex justify-content-between align-items-center">
                    <h6 class="text-muted font-semibold">
                      <a href="{{ route('getDivisionEmployee', $division->id) }}"> {{ $division->code }}</a>
                    </h6>
                    <span class="h5"> {{ $positionsWithActiveEmployeeCount }} </span>
                  </div>

                  <div class="d-flex justify-content-between align-items-center">
                    <h6 class="text-muted font-semibold">
                      Office
                    </h6>
                    <span class="h5"> {{ $positionsWithActiveEmployeeOfficeCount }} </span>
                  </div>

                  <div class="d-flex justify-content-between align-items-center">
                    <h6 class="text-muted font-semibold">
                      Non-Office
                    </h6>
                    <span class="h5"> {{ $positionsWithActiveEmployeeNonOfficeCount }} </span>
                  </div>

                  <hr>

                  @foreach ($levelsWithCounts as $levelName => $count)
                    <a href="#" data-bs-toggle="modal" data-bs-target="#employeeLevelModal"
                      data-level-name="{{ $levelName }}" data-division-id="{{ $division->id }}">

                      <div class="d-flex justify-content-between align-items-center ">
                        <h6 class="text-muted font-semibold" style="font-size: 75%">
                          {{ $levelName ?? 'No Level Assigned' }}
                        </h6>
                        <span style="font-size: 85%">{{ $count }}</span>
                      </div>
                    </a>
                    @include('pages.dashboard.modal-level-division')
                  @endforeach

                  {{-- <h6 class="text-muted font-semibold">
                    <a href="{{ route('getDivisionEmployee', $division->id) }}"> {{ $division->code }}</a>
                  </h6>
                  <h4 class="font-extrabold mb-0 float-end">
                    {{ $positionsWithActiveEmployeeCount }}
                  </h4> --}}
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
                @php
                  $positionsWithEmployeeCount = $division->positions
                      ->filter(function ($position) {
                          return $position->employee !== null;
                      })
                      ->count();

                  $positionsWithActiveEmployeeOfficeCount = $division
                      ->positions()
                      ->whereHas('employee', function ($query) {
                          $query
                              ->where('employee_status', 'AKTIF')
                              ->whereHas('employeeCategory', function ($query) {
                                  $query->where('name', 'OFFICE'); // Adjust based on your relationship
                              })
                              ->when(!Auth::user()->hasRole('super-admin'), function ($query) {
                                  $query->where('company_id', Auth::user()->company_id);
                              });
                      })
                      ->count();

                  $positionsWithActiveEmployeeNonOfficeCount = $division
                      ->positions()
                      ->whereHas('employee', function ($query) {
                          $query
                              ->where('employee_status', 'AKTIF')
                              ->whereHas('employeeCategory', function ($query) {
                                  $query->where('name', 'NON-OFFICE'); // Adjust based on your relationship
                              })
                              ->when(!Auth::user()->hasRole('super-admin'), function ($query) {
                                  $query->where('company_id', Auth::user()->company_id);
                              });
                      })
                      ->count();

                  $levelsWithCounts = $division
                      ->positions()
                      ->whereHas('employee', function ($query) {
                          $query
                              ->where('employee_status', 'AKTIF')
                              ->when(!Auth::user()->hasRole('super-admin'), function ($query) {
                                  $query->where('company_id', Auth::user()->company_id);
                              });
                      })
                      ->with('level')
                      ->get()
                      ->sortBy('level.id')
                      ->groupBy('level.name')
                      ->map(function ($positions) {
                          return $positions->count(); // Count positions for each level
                      });

                @endphp
                <div class="col-md-12">
                  {{-- <h6 class="text-muted font-semibold">
                    <a href="{{ route('getDivisionEmployee', $division->id) }}"> {{ $division->code }}</a>
                  </h6>
                  <h4 class="font-extrabold mb-0 float-end">
                    {{ $positionsWithEmployeeCount }}
                  </h4> --}}
                  <div class="d-flex justify-content-between align-items-center">
                    <h6 class="text-muted font-semibold">
                      <a href="{{ route('getDivisionEmployee', $division->id) }}"> {{ $division->code }}</a>
                    </h6>
                    <span class="h5"> {{ $positionsWithEmployeeCount }} </span>
                  </div>

                  <div class="d-flex justify-content-between align-items-center">
                    <h6 class="text-muted font-semibold">
                      Office
                    </h6>
                    <span class="h5"> {{ $positionsWithActiveEmployeeOfficeCount }} </span>
                  </div>

                  <div class="d-flex justify-content-between align-items-center">
                    <h6 class="text-muted font-semibold">
                      Non-Office
                    </h6>
                    <span class="h5"> {{ $positionsWithActiveEmployeeNonOfficeCount }} </span>
                  </div>

                  <hr>

                  @foreach ($levelsWithCounts as $levelName => $count)
                    <a href="#" data-bs-toggle="modal" data-bs-target="#employeeLevelModal"
                      data-level-name="{{ $levelName }}" data-division-id="{{ $division->id }}">

                      <div class="d-flex justify-content-between align-items-center ">
                        <h6 class="text-muted font-semibold" style="font-size: 75%">
                          {{ $levelName ?? 'No Level Assigned' }}
                        </h6>
                        <span style="font-size: 85%">{{ $count }}</span>
                      </div>
                    </a>
                    @include('pages.dashboard.modal-level-division')
                  @endforeach

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

  {{-- <div class="row">
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
  </div> --}}

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            {{-- <h4>Data Karyawan Pertahun</h4> --}}
            {{--   <div class="col-md-2">
              <label for="year-select">Pilih Tahun</label>
              <select id="year-select" class="form-control" aria-label="Pilih Tahun">
                @for ($year = 2015; $year <= date('Y'); $year++)
                  <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>{{ $year }}
                  </option>
                @endfor
              </select>
            </div> --}}
          </div>
        </div>
        <div class="card-body">
          <div id="employee-data" class="text-center">
            <div id="loader" class="d-none">
              <div class="spinner-border text-primary">
                <span class="sr-only">Loading...</span>
              </div>
              <p>Memuat data, harap tunggu...</p>
            </div>
          </div>
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
            <table class="table" id="table10" style="font-size: 80%">
              <thead>
                <tr>
                  <th scope="col" style="width: 5%">#</th>
                  <th scope="col"></th>
                  <th scope="col">NIK</th>
                  <th scope="col">Nama</th>
                  {{-- <th scope="col">Jabatan</th> --}}
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

                    {{-- <td>
                      {{ $contract->employee->position->name ?? 'N/A' }}
                    </td> --}}

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
                          data-bs-target="#modal-form-add-kpi{{ $contract->employee->id }}">
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

            {{-- <div class="row">
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

            </div> --}}
          </div>

        </div>

        <div class="card-body" style="word-break: break-all">

          <div class="d-flex justify-content-between align-items-center my-2">
            {{-- <div>
              <label for="start-date" class="me-2">Start Date:</label>
              <input type="date" id="start-date" class="form-control form-control-sm" placeholder="Start Date"
                style="width: 150px; display: inline-block;">

              <label for="end-date" class="me-2">End Date:</label>
              <input type="date" id="end-date" class="form-control form-control-sm" placeholder="End Date"
                style="width: 150px; display: inline-block;">


              <button id="filter-date" class="btn btn-primary btn-sm ms-2">Filter</button>
            </div> --}}
            <div>
              <label for="month" class="me-2">Bulan:</label>
              <select id="month" class="form-control form-control-sm"
                style="width: 150px; display: inline-block;">
                @foreach (range(1, 12) as $month)
                  <option value="{{ $month }}" {{ $month == date('n') ? 'selected' : '' }}>
                    {{ DateTime::createFromFormat('!m', $month)->format('F') }}
                  </option>
                @endforeach
              </select>

              <label for="year" class="me-2">Tahun:</label>
              <select id="year" class="form-control form-control-sm"
                style="width: 150px; display: inline-block;">
                @for ($year = 2020; $year <= date('Y'); $year++)
                  <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>
                    {{ $year }}
                  </option>
                @endfor
              </select>

              <button id="filter-date" class="btn btn-primary btn-sm ms-2">Filter</button>
              <button id="reset-filters" class="btn btn-secondary btn-sm ms-2 ">Reset</button>

            </div>

            <a href="{{ route('contract.exportExpired', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}"
              class="btn btn-success btn-md" id="export-button">
              Export
            </a>
          </div>
          <div id="contracts-list">
            {{-- @include('pages.dashboard.contract-expired-list', ['contractsExpired' => $contractsExpired]) --}}
            <table class="table" id="table-expired-contract" style="font-size: 80%; width:100%">
              <thead>
                <tr>
                  <th scope="col" style="width: 1%">#</th>
                  <th scope="col" style="width: 10%">NIK</th>
                  <th scope="col" style="width: 15%">Nama</th>
                  <th scope="col">No. Kontrak</th>
                  <th scope="col">Tgl Mulai </th>
                  <th scope="col">Tgl Berakhir</th>
                  <th scope="col">Durasi</th>
                  <th scope="col">Kontrak Ke- </th>
                  <th scope="col">Divisi</th>
                  <th scope="col" class="text-center" style="width: 7%">PK</th>
                  <th scope="col" style="width: 10%"></th>
                </tr>
              </thead>
              <tbody>
                {{-- @foreach ($contractsExpired as $contract)
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
                      {{ $contract->employee->position->name ?? 'N/A' }}
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
                    <td>{{ $contract->employee->position->division->code ?? 'N/A' }}</td>
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
                    <td>
                      @php
                        // Fetch the latest contract for the employee
                        $latestContract = $contract
                            ->where('employee_id', $contract->employee->id)
                            ->orderBy('start_date', 'desc')
                            ->first();
                      @endphp

                      @if ($latestContract && $latestContract->start_date >= now())
                        <p>Kontrak diperbarui</p>
                      @else
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                          data-bs-target="#modal-form-add-contract">
                          <i class="bi bi-plus-lg"></i>
                          Kontrak
                        </button>
                        @include('pages.employee.personal-data.form.employee-contract.modal-create')
                      @endif

                    </td>
                @endforeach --}}
              </tbody>
            </table>

          </div>
        </div>
      </div>

    </div>

  </div>


</div>

<script src="{{ asset('dist/assets/extensions/apexcharts/apexcharts.min.js') }}"></script>

{{-- <script>
  document.addEventListener('DOMContentLoaded', function() {
    var employeeLevelModal = document.getElementById('employeeLevelModal');
    employeeLevelModal.addEventListener('show.bs.modal', function(event) {
      // Button that triggered the modal
      var button = event.relatedTarget;

      // Extract level name from the button's data attribute
      var levelName = button.getAttribute('data-level-name');
      var divisionId = button.getAttribute('data-division-id');

      // Update the modal title
      document.getElementById('modalLevelName').textContent = levelName;

      // Fetch employee data via AJAX
      fetch(
          `/employees-by-level-and-division?level_name=${encodeURIComponent(levelName)}&division_id=${encodeURIComponent(divisionId)}`
        )
        .then(response => response.json())
        .then(data => {
          var employeeList = document.getElementById('employeeList');
          employeeList.innerHTML = ''; // Clear previous data

          // Populate the table with employee data
          data.forEach(employee => {
            var row = `<tr>
                            <td>${employee.name}</td>
                            <td>${employee.position.name}</td>
                            <td>${employee.position.level.name}</td>
                            <td>${employee.employeeCategory.name}</td>
                        </tr>`;
            employeeList.insertAdjacentHTML('beforeend', row);
          });
        })
        .catch(error => {
          console.error('Error fetching employee data:', error);
        });
    });
  });
</script> --}}

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var employeeLevelModal = document.getElementById('employeeLevelModal');
    employeeLevelModal.addEventListener('show.bs.modal', function(event) {
      var button = event.relatedTarget;
      var levelName = button.getAttribute('data-level-name');
      var divisionId = button.getAttribute('data-division-id');

      document.getElementById('modalLevelName').textContent = levelName;

      fetch("{{ route('getEmployeesByLevelAndDivision') }}?level_name=" + encodeURIComponent(levelName) +
          "&division_id=" + encodeURIComponent(divisionId))

        .then(response => response.json())
        .then(data => {
          var employeeList = document.getElementById('employeeList');
          employeeList.innerHTML = '';

          data.forEach(employee => {
            var row = `<tr>
                            <td>${employee.nik}</td>
                            <td>${employee.name}</td>
                            <td>${employee.position.name}</td>
                            <td>${employee.position.level.name}</td>
                            <td>${employee.position.division.name}</td>
                        </tr>`;
            employeeList.insertAdjacentHTML('beforeend', row);
          });

          $('#employeeTable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            destroy: true,
          });
        })
        .catch(error => {
          console.error('Error fetching employee data:', error);
        });
    });

    employeeLevelModal.addEventListener('hidden.bs.modal', function() {
      $('#employeeTable').DataTable().destroy();
    });
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Data passed from the controller
    var employeeActiveData = @json($employeeActiveData);
    var employeeNonActiveData = @json($employeeNonActiveData);
    var monthlyEmployeeData = @json($monthlyEmployeeData);

    var options = {
      chart: {
        type: 'bar',
        height: 350,
        stacked: true,
      },
      series: [{
          name: 'Karyawan Masuk',
          data: employeeActiveData
        },
        {
          name: 'Karyawan Keluar',
          data: employeeNonActiveData
        },
        {
          name: 'Karyawan Bekerja',
          data: monthlyEmployeeData
        },
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
      colors: ['#1E90FF', '#FF6347', '#ffa200'],
      legend: {
        position: 'top'
      },
      title: {
        text: `Data Karyawan Pertahun ({{ $selectedYear }})`,
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
    // document.getElementById('year-select').addEventListener('change', function() {
    //   var selectedYear = this.value;

    //   // Use route() helper for dynamic URL generation
    //   fetch(`{{ route('employee-chart-data', ['year' => '__YEAR__']) }}`.replace('__YEAR__', selectedYear))
    //     .then(response => response.json())
    //     .then(data => {
    //       chart.updateSeries([{
    //           name: 'Karyawan Masuk',
    //           data: data.employeeActiveData
    //         },
    //         {
    //           name: 'Karyawan Keluar',
    //           data: data.employeeNonActiveData
    //         },
    //         {
    //           name: 'Karyawan Bekerja',
    //           data: data.monthlyEmployeeData
    //         }
    //       ]);
    //       chart.updateOptions({
    //         title: {
    //           text: `Employee Data for the Year ${selectedYear}`
    //         }
    //       });
    //     })
    //     .catch(error => {
    //       console.error('Error fetching data:', error);
    //       alert('Gagal mengambil data. Silakan coba lagi.');
    //     })
    //     .finally(() => {
    //       // Hide loader
    //       document.getElementById('loader').style.display = 'none';
    //     });
    // });
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
{{-- <script>
  document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.nav-link');

    // Function to load content dynamically
    function loadTabContent(tab) {
      const targetId = tab.getAttribute('href').substring(1); // Get the tab content ID
      const targetTab = document.getElementById(targetId);
      const loader = targetTab.querySelector('#' + targetId + '-loader'); // Find the loader
      const url = targetTab.getAttribute('data-url');

      // Show the loader while content is being fetched
      // loader.style.display = 'flex';
      loader.classList.add('mt-3');

      // Check if content is already loaded
      if (!targetTab.dataset.loaded) {
        // Fetch content using AJAX
        fetch(url)
          .then(response => response.text())
          .then(data => {
            targetTab.innerHTML = data;
            targetTab.dataset.loaded = true; // Mark as loaded
            loader.style.display = 'none'; // Hide the loader
          })
          .catch(error => {
            console.error('Error loading tab content:', error);
            loader.style.display = 'none'; // Hide the loader in case of error
          });
      } else {
        loader.style.display = 'none'; // Hide the loader if content is already loaded
      }
    }

    // Load content for the active tab on page load
    const activeTab = document.querySelector('.nav-link.active');
    if (activeTab) {
      loadTabContent(activeTab);
    }

    // Add click event listener for other tabs
    tabs.forEach(tab => {
      tab.addEventListener('click', function() {
        loadTabContent(tab);
      });
    });
  });

  
</script> --}}

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.nav-link');

    // Function untuk load content dalam tab
    function loadTabContent(tab) {
      const targetId = tab.getAttribute('href').substring(1); // Ambil ID tab content
      const targetTab = document.getElementById(targetId);
      const loader = targetTab.querySelector('#' + targetId + '-loader'); // Loader
      const url = targetTab.getAttribute('data-url');

      // Tampilkan loader saat konten sedang dimuat
      if (loader) {
        loader.style.display = 'block';
      }

      // Cek apakah data sudah dimuat sebelumnya
      if (!targetTab.dataset.loaded) {
        fetch(url)
          .then(response => response.text())
          .then(data => {
            targetTab.innerHTML = data; // Masukkan konten ke dalam tab
            targetTab.dataset.loaded = true; // Tandai sudah dimuat

            // Sembunyikan loader setelah selesai
            if (loader) {
              loader.style.display = 'none';
            }

            // Inisialisasi DataTables jika ada dalam tab yang baru dimuat
            $(targetTab).find('.dataTable').DataTable({
              "paging": true,
              "lengthChange": true,
              "searching": true,
              "ordering": true,
              "info": true,
              "autoWidth": false
            });
          })
          .catch(error => {
            console.error('Error loading tab content:', error);
            if (loader) {
              loader.style.display = 'none';
            }
          });
      } else {
        if (loader) {
          loader.style.display = 'none';
        }
      }
    }

    // Load konten tab yang aktif saat halaman pertama kali dimuat
    const activeTab = document.querySelector('.nav-link.active');
    if (activeTab) {
      loadTabContent(activeTab);
    }

    // Tambahkan event listener untuk klik tab
    tabs.forEach(tab => {
      tab.addEventListener('click', function(event) {
        event.preventDefault(); // Mencegah reload saat klik tab
        loadTabContent(tab);
      });
    });
  });
</script>


{{-- <script>
  jQuery(document).ready(function($) {
    const table = $('#table-expired-contract').DataTable({
      processing: true,
      serverSide: true,
      ordering: true,
      pageLength: 10,
      lengthMenu: [
        [10, 25, 50, 100, -1],
        [10, 25, 50, 100, 'All']
      ],
      ajax: {
        url: "{{ route('dashboard.index') }}",
        data: function(d) {
          d.month = $('#month').val();
          d.year = $('#year').val();
          // d.employee_status = $('#employee-status').val();
        }
      },
      columns: [{
          data: 'DT_RowIndex',
          name: 'DT_RowIndex',
          orderable: false,
          searchable: false,
          width: '5%'
        },

        {
          data: 'employee.nik',
          name: 'employee.nik'
        },
        {
          data: 'employee.name',
          name: 'employee.name'
        },
        {
          data: 'contract_number',
          name: 'contract_number',
          // orderable: false,
        },
        {
          data: 'start_date',
          name: 'start_date',
          // orderable: false,
        },
        {
          data: 'end_date',
          name: 'end_date',
          // orderable: false,
        },
        {
          data: 'duration',
          name: 'duration',
          // orderable: false,
          // searchable: false
        },
        {
          data: 'contract_sequence_number',
          name: 'contract_sequence_number',
          // orderable: false,
          // searchable: false
        },
        {
          data: 'employee.position.division.code',
          name: 'employee.position.division.code',
          // orderable: false,
          // searchable: false
        },
        {
          data: 'pk',
          name: 'pk'
        },
        {
          data: 'contract',
          name: 'contract',
          orderable: false,
          searchable: false,
        }
      ],
      columnDefs: [{
        className: 'text-center',
        targets: [0, 1, 3, 4, 5, 6, 7, 8]
      }]
    });

    // Reload table on filter button click
    $('#filter-date').on('click', function() {
      table.ajax.reload();

      // Update export button URL
      const month = $('#month').val();
      const year = $('#year').val();
      // const employeeStatus = $('#employee-status').val();

      let exportUrl = "{{ route('contract.exportExpired') }}";
      const params = [];

      if (startDate) params.push(`start_date=${startDate}`);
      if (endDate) params.push(`end_date=${endDate}`);
      // if (employeeStatus) params.push(`employee_status=${employeeStatus}`);

      if (params.length) exportUrl += `?${params.join('&')}`;

      $('.btn-success').attr('href', exportUrl);
    });
  });
</script> --}}

<script>
  jQuery(document).ready(function($) {
    const table = $('#table-expired-contract').DataTable({
      processing: true,
      serverSide: true,
      ordering: true,
      pageLength: 10,
      lengthMenu: [
        [10, 25, 50, 100, -1],
        [10, 25, 50, 100, 'All']
      ],
      ajax: {
        url: "{{ route('dashboard.index') }}",
        data: function(d) {
          d.month = $('#month').val();
          d.year = $('#year').val();
        }
      },
      columns: [{
          data: 'DT_RowIndex',
          name: 'DT_RowIndex',
          orderable: false,
          searchable: false,
          width: '5%'
        },
        {
          data: 'employee.nik',
          name: 'employee.nik'
        },
        {
          data: 'employee.name',
          name: 'employee.name'
        },
        {
          data: 'contract_number',
          name: 'contract_number'
        },
        {
          data: 'start_date',
          name: 'start_date',
          render: function(data, type, row) {
            if (data) {
              const date = new Date(data); // Parse the date string
              const formattedDate = date.toLocaleDateString('en-GB'); // Format as d-m-Y (British format)
              return formattedDate;
            }
            return '-'; // Return '-' if the date is not available
          },
          searchable: false,
        },
        {
          data: 'end_date',
          name: 'end_date',
          render: function(data, type, row) {
            if (data) {
              const date = new Date(data); // Parse the date string
              const formattedDate = date.toLocaleDateString('en-GB'); // Format as d-m-Y (British format)
              return formattedDate;
            }
            return '-'; // Return '-' if the date is not available
          },
          searchable: false,
        },

        {
          data: 'duration',
          name: 'duration',
          orderable: false,
          searchable: false
        },
        {
          data: 'contract_sequence_number',
          name: 'contract_sequence_number',
          orderable: false,
          searchable: false
        },

        {
          data: 'employee.position.division.code',
          name: 'employee.position.division.code'
        },
        {
          data: 'pk',
          name: 'pk',
          orderable: false,
          searchable: false
        },
        {
          data: 'contract',
          name: 'contract',
          orderable: false,
          searchable: false
        }
      ],
      columnDefs: [{
        className: 'text-center',
        targets: [0, 1, 3, 4, 5, 6, 7, 8]
      }]
    });

    // Reload table and update export button on filter button click
    // $('#filter-date').on('click', function() {
    //   table.ajax.reload();

    //   const month = $('#month').val();
    //   const year = $('#year').val();

    //   // Construct export URL with parameters
    //   let exportUrl = "{{ route('contract.exportExpired') }}";
    //   const params = [];

    //   if (month) params.push(`month=${month}`);
    //   if (year) params.push(`year=${year}`);

    //   if (params.length) exportUrl += `?${params.join('&')}`;

    //   // Update the export button URL
    //   $('.btn-success').attr('href', exportUrl);
    // });

    $('#filter-date').on('click', function() {
      // Reload the DataTable with the selected filters
      table.ajax.reload();

      // Get the selected month and year values
      const month = $('#month').val();
      const year = $('#year').val();

      // Construct the export URL with query parameters
      let exportUrl = "{{ route('contract.exportExpired') }}";
      const params = [];

      if (month) params.push(`month=${month}`);
      if (year) params.push(`year=${year}`);

      // Append query parameters to the URL
      if (params.length) {
        exportUrl += `?${params.join('&')}`;
      }

      // Update the export button's href attribute
      $('.btn-success').attr('href', exportUrl);
    });

    // Reset filters to current month and year
    $('#reset-filters').on('click', function() {
      // Reset month and year dropdowns to current values
      const now = new Date();
      const defaultMonth = now.getMonth() + 1; // JavaScript months are 0-based
      const defaultYear = now.getFullYear();

      $('#month').val(defaultMonth);
      $('#year').val(defaultYear);

      // Reload the DataTable with the default values (current month and year)
      table.ajax.reload();

      // Reset the export URL
      let exportUrl = "{{ route('contract.exportExpired') }}";
      const params = [
        `month=${defaultMonth}`,
        `year=${defaultYear}`
      ];

      exportUrl += `?${params.join('&')}`;

      // Update the export button's href attribute
      $('.btn-success').attr('href', exportUrl);
    });


  });
</script>
@endpush
