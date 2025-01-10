<div class="col-12">
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="d-flex justify-content-between align-items-center">
          <h4 class="card-title">Usia Karyawan</h4>
          <a href="{{ url('/export-ages') }}" class="btn btn-sm btn-success">Export</a>
        </div>

        <!-- Table for Age Distribution -->
        {{-- <div class="col-md-12">
          <table class="table table-sm table-bordered" style="font-size: 80%">
            <thead>
              <tr>
                <th>Unit Kerja</th>
                <th>Total Karyawan</th>
                <th>
                  < 25</th>
                <th>25-30</th>
                <th>30-35</th>
                <th>35-40</th>
                <th>40-45</th>
                <th>> 45</th>
              </tr>
            </thead>
            <tbody>
              @php
                use Carbon\Carbon;

                // Group and order the directorates
                $groupedDirectorates = $directorates->groupBy('is_non')->sortKeysUsing(function ($key1, $key2) {
                    $order = [1, 2]; // Define the desired order for is_non
                    $index1 = array_search($key1, $order) !== false ? array_search($key1, $order) : count($order);
                    $index2 = array_search($key2, $order) !== false ? array_search($key2, $order) : count($order);
                    return $index1 <=> $index2;
                });
              @endphp

              @forelse ($groupedDirectorates as $isNon => $directoratesGroup)
                <tr>
                  <td colspan="7" class="text-bold-500 text-center">
                    {{ $isNon == 1 ? 'DIREKTORAT' : ($isNon == 2 ? 'NON-DIREKTORAT' : 'LAIN-LAIN') }}
                  </td>
                </tr>

                @foreach ($directoratesGroup as $directorate)
                  @php
                    $totalCount = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' ? 1 : 0,
                        ),
                    );

                    $below25 = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            Carbon::parse(optional($position->employee)->dob)->age < 25
                                ? 1
                                : 0,
                        ),
                    );

                    $age2530 = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            Carbon::parse(optional($position->employee)->dob)->age >= 20 &&
                            Carbon::parse(optional($position->employee)->dob)->age < 25
                                ? 1
                                : 0,
                        ),
                    );

                    $age3540 = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            Carbon::parse(optional($position->employee)->dob)->age >= 25 &&
                            Carbon::parse(optional($position->employee)->dob)->age < 35
                                ? 1
                                : 0,
                        ),
                    );

                   $age4045 = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            Carbon::parse(optional($position->employee)->dob)->age >= 35 &&
                            Carbon::parse(optional($position->employee)->dob)->age < 50
                                ? 1
                                : 0,
                        ),
                    );

                    $up50 = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            Carbon::parse(optional($position->employee)->dob)->age >= 50
                                ? 1
                                : 0,
                        ),
                    );
                  @endphp

                  <tr>
                    <td class="text-bold-500">{{ $directorate->name }}</td>
                    <td>{{ $totalCount }}</td>
                    <td>{{ $below25 }}</td>
                    <td>{{ $age2530 }}</td>
                    <td>{{ $age3540 }}</td>
                    <td>{{$age4045 }}</td>
                    <td>{{ $up50 }}</td>
                  </tr>
                @endforeach
              @empty
                <tr>
                  <td class="text-bold-500 text-center" colspan="7">No data available in table</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div> --}}

        <div class="col-md-12">
          <table class="table table-sm table-bordered" style="font-size: 80%">
            <thead>
              <tr>
                <th class="text-center">Unit Kerja</th>
                <th class="text-center">Total Karyawan</th>
                <th class="text-center">
                  < 25</th>
                <th class="text-center">25-30</th>
                <th class="text-center">30-35</th>
                <th class="text-center">35-40</th>
                <th class="text-center">40-45</th>
                <th class="text-center">> 45</th>
              </tr>
            </thead>
            <tbody>
              @php
                use Carbon\Carbon;

                $totalEmployees = 0;
                $totalBelow25 = 0;
                $total2530 = 0;
                $total3035 = 0;
                $total3540 = 0;
                $total4045 = 0;
                $totalAbove45 = 0;

                // Group and order the directorates
                $groupedDirectorates = $directorates->groupBy('is_non')->sortKeysUsing(function ($key1, $key2) {
                    $order = [1, 2]; // Define the desired order for is_non
                    $index1 = array_search($key1, $order) !== false ? array_search($key1, $order) : count($order);
                    $index2 = array_search($key2, $order) !== false ? array_search($key2, $order) : count($order);
                    return $index1 <=> $index2;
                });
              @endphp

              @forelse ($groupedDirectorates as $isNon => $directoratesGroup)
                <tr>
                  <td colspan="7" class="text-bold-500 text-center">
                    {{ $isNon == 1 ? 'DIREKTORAT' : ($isNon == 2 ? 'NON-DIREKTORAT' : 'LAIN-LAIN') }}
                  </td>
                </tr>

                @foreach ($directoratesGroup as $directorate)
                  @php
                    $totalCount = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' ? 1 : 0,
                        ),
                    );

                    $below25 = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            Carbon::parse(optional($position->employee)->dob)->age < 25
                                ? 1
                                : 0,
                        ),
                    );

                    $age2530 = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            Carbon::parse(optional($position->employee)->dob)->age >= 25 &&
                            Carbon::parse(optional($position->employee)->dob)->age < 30
                                ? 1
                                : 0,
                        ),
                    );

                    $age3035 = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            Carbon::parse(optional($position->employee)->dob)->age >= 30 &&
                            Carbon::parse(optional($position->employee)->dob)->age < 35
                                ? 1
                                : 0,
                        ),
                    );

                    $age3540 = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            Carbon::parse(optional($position->employee)->dob)->age >= 35 &&
                            Carbon::parse(optional($position->employee)->dob)->age < 40
                                ? 1
                                : 0,
                        ),
                    );

                    $age4045 = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            Carbon::parse(optional($position->employee)->dob)->age >= 40 &&
                            Carbon::parse(optional($position->employee)->dob)->age < 45
                                ? 1
                                : 0,
                        ),
                    );

                    $up45 = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            Carbon::parse(optional($position->employee)->dob)->age >= 45
                                ? 1
                                : 0,
                        ),
                    );

                    // Add to totals
                    $totalEmployees += $totalCount;
                    $totalBelow25 += $below25;
                    $total2530 += $age2530;
                    $total3035 += $age3035;
                    $total3540 += $age3540;
                    $total4045 += $age4045;
                    $totalAbove45 += $up45;
                  @endphp

                  <tr>
                    <td class="text-bold-500">{{ $directorate->name }}</td>
                    <td class="text-center">{{ $totalCount }}</td>
                    <td class="text-center">{{ $below25 }}</td>
                    <td class="text-center">{{ $age2530 }}</td>
                    <td class="text-center">{{ $age3035 }}</td>
                    <td class="text-center">{{ $age3540 }}</td>
                    <td class="text-center">{{ $age4045 }}</td>
                    <td class="text-center">{{ $up45 }}</td>
                  </tr>
                @endforeach
              @empty
                <tr>
                  <td class="text-bold-500 text-center" colspan="7">No data available in table</td>
                </tr>
              @endforelse

              <!-- Totals Row -->
              <tr class="table-primary">
                <td class="text-bold-500 text-center">TOTAL</td>
                <td class="text-center">{{ $totalEmployees }}</td>
                <td class="text-center">{{ $totalBelow25 }}</td>
                <td class="text-center">{{ $total2530 }}</td>
                <td class="text-center">{{ $total3035 }}</td>
                <td class="text-center">{{ $total3540 }}</td>
                <td class="text-center">{{ $total4045 }}</td>
                <td class="text-center">{{ $totalAbove45 }}</td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="col-md-12">
          <h3>OFFICE</h3>
          <table class="table table-sm table-bordered" style="font-size: 80%">
            <thead>
              <tr>
                <th class="text-center">Unit Kerja</th>
                <th class="text-center">Total Karyawan</th>
                <th class="text-center">
                  < 25</th>
                <th class="text-center">25-30</th>
                <th class="text-center">30-35</th>
                <th class="text-center">35-40</th>
                <th class="text-center">40-45</th>
                <th class="text-center">> 45</th>
              </tr>
            </thead>
            <tbody>
              @php
                $totalEmployees = 0;
                $totalBelow25 = 0;
                $total2530 = 0;
                $total3035 = 0;
                $total3540 = 0;
                $total4045 = 0;
                $totalAbove45 = 0;

                // Group and order the directorates
                $groupedDirectorates = $directorates->groupBy('is_non')->sortKeysUsing(function ($key1, $key2) {
                    $order = [1, 2]; // Define the desired order for is_non
                    $index1 = array_search($key1, $order) !== false ? array_search($key1, $order) : count($order);
                    $index2 = array_search($key2, $order) !== false ? array_search($key2, $order) : count($order);
                    return $index1 <=> $index2;
                });
              @endphp

              @forelse ($groupedDirectorates as $isNon => $directoratesGroup)
                <tr>
                  <td colspan="7" class="text-bold-500 text-center">
                    {{ $isNon == 1 ? 'DIREKTORAT' : ($isNon == 2 ? 'NON-DIREKTORAT' : 'LAIN-LAIN') }}
                  </td>
                </tr>

                @foreach ($directoratesGroup as $directorate)
                  @php

                    // $office = $position->employee->employeeCategory->name === 'OFFICE';

                    $totalCount = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->employeeCategory->name === 'OFFICE'
                                ? 1
                                : 0,
                        ),
                    );

                    $below25 = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            Carbon::parse(optional($position->employee)->dob)->age < 25 &&
                            $position->employee->employeeCategory->name === 'OFFICE'
                                ? 1
                                : 0,
                        ),
                    );

                    $age2530 = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->employeeCategory->name === 'OFFICE' &&
                            Carbon::parse(optional($position->employee)->dob)->age >= 25 &&
                            Carbon::parse(optional($position->employee)->dob)->age < 30
                                ? 1
                                : 0,
                        ),
                    );

                    $age3035 = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->employeeCategory->name === 'OFFICE' &&
                            Carbon::parse(optional($position->employee)->dob)->age >= 30 &&
                            Carbon::parse(optional($position->employee)->dob)->age < 35
                                ? 1
                                : 0,
                        ),
                    );

                    $age3540 = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->employeeCategory->name === 'OFFICE' &&
                            Carbon::parse(optional($position->employee)->dob)->age >= 35 &&
                            Carbon::parse(optional($position->employee)->dob)->age < 40
                                ? 1
                                : 0,
                        ),
                    );

                    $age4045 = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->employeeCategory->name === 'OFFICE' &&
                            Carbon::parse(optional($position->employee)->dob)->age >= 40 &&
                            Carbon::parse(optional($position->employee)->dob)->age < 45
                                ? 1
                                : 0,
                        ),
                    );

                    $up45 = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->employeeCategory->name === 'OFFICE' &&
                            Carbon::parse(optional($position->employee)->dob)->age >= 45
                                ? 1
                                : 0,
                        ),
                    );

                    // Add to totals
                    $totalEmployees += $totalCount;
                    $totalBelow25 += $below25;
                    $total2530 += $age2530;
                    $total3035 += $age3035;
                    $total3540 += $age3540;
                    $total4045 += $age4045;
                    $totalAbove45 += $up45;
                  @endphp

                  <tr>
                    <td class="text-bold-500">{{ $directorate->name }}</td>
                    <td class="text-center">{{ $totalCount }}</td>
                    <td class="text-center">{{ $below25 }}</td>
                    <td class="text-center">{{ $age2530 }}</td>
                    <td class="text-center">{{ $age3035 }}</td>
                    <td class="text-center">{{ $age3540 }}</td>
                    <td class="text-center">{{ $age4045 }}</td>
                    <td class="text-center">{{ $up45 }}</td>
                  </tr>
                @endforeach
              @empty
                <tr>
                  <td class="text-bold-500 text-center" colspan="7">No data available in table</td>
                </tr>
              @endforelse

              <!-- Totals Row -->
              <tr class="table-primary">
                <td class="text-bold-500 text-center">TOTAL</td>
                <td class="text-center">{{ $totalEmployees }}</td>
                <td class="text-center">{{ $totalBelow25 }}</td>
                <td class="text-center">{{ $total2530 }}</td>
                <td class="text-center">{{ $total3035 }}</td>
                <td class="text-center">{{ $total3540 }}</td>
                <td class="text-center">{{ $total4045 }}</td>
                <td class="text-center">{{ $totalAbove45 }}</td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="col-md-12">
          <h3>NON-OFFICE</h3>
          <table class="table table-sm table-bordered" style="font-size: 80%">
            <thead>
              <tr>
                <th class="text-center">Unit Kerja</th>
                <th class="text-center">Total Karyawan</th>
                <th class="text-center">
                  < 25</th>
                <th class="text-center">25-30</th>
                <th class="text-center">30-35</th>
                <th class="text-center">35-40</th>
                <th class="text-center">40-45</th>
                <th class="text-center">> 45</th>
              </tr>
            </thead>
            <tbody>
              @php
                $totalEmployees = 0;
                $totalBelow25 = 0;
                $total2530 = 0;
                $total3035 = 0;
                $total3540 = 0;
                $total4045 = 0;
                $totalAbove45 = 0;

                // Group and order the directorates
                $groupedDirectorates = $directorates->groupBy('is_non')->sortKeysUsing(function ($key1, $key2) {
                    $order = [1, 2]; // Define the desired order for is_non
                    $index1 = array_search($key1, $order) !== false ? array_search($key1, $order) : count($order);
                    $index2 = array_search($key2, $order) !== false ? array_search($key2, $order) : count($order);
                    return $index1 <=> $index2;
                });
              @endphp

              @forelse ($groupedDirectorates as $isNon => $directoratesGroup)
                <tr>
                  <td colspan="7" class="text-bold-500 text-center">
                    {{ $isNon == 1 ? 'DIREKTORAT' : ($isNon == 2 ? 'NON-DIREKTORAT' : 'LAIN-LAIN') }}
                  </td>
                </tr>

                @foreach ($directoratesGroup as $directorate)
                  @php

                    // $office = $position->employee->employeeCategory->name === 'OFFICE';

                    $totalCount = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->employeeCategory->name === 'NON-OFFICE'
                                ? 1
                                : 0,
                        ),
                    );

                    $below25 = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            Carbon::parse(optional($position->employee)->dob)->age < 25 &&
                            $position->employee->employeeCategory->name === 'NON-OFFICE'
                                ? 1
                                : 0,
                        ),
                    );

                    $age2530 = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->employeeCategory->name === 'NON-OFFICE' &&
                            Carbon::parse(optional($position->employee)->dob)->age >= 25 &&
                            Carbon::parse(optional($position->employee)->dob)->age < 30
                                ? 1
                                : 0,
                        ),
                    );

                    $age3035 = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->employeeCategory->name === 'NON-OFFICE' &&
                            Carbon::parse(optional($position->employee)->dob)->age >= 30 &&
                            Carbon::parse(optional($position->employee)->dob)->age < 35
                                ? 1
                                : 0,
                        ),
                    );

                    $age3540 = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->employeeCategory->name === 'NON-OFFICE' &&
                            Carbon::parse(optional($position->employee)->dob)->age >= 35 &&
                            Carbon::parse(optional($position->employee)->dob)->age < 40
                                ? 1
                                : 0,
                        ),
                    );

                    $age4045 = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->employeeCategory->name === 'NON-OFFICE' &&
                            Carbon::parse(optional($position->employee)->dob)->age >= 40 &&
                            Carbon::parse(optional($position->employee)->dob)->age < 45
                                ? 1
                                : 0,
                        ),
                    );

                    $up45 = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->employeeCategory->name === 'NON-OFFICE' &&
                            Carbon::parse(optional($position->employee)->dob)->age >= 45
                                ? 1
                                : 0,
                        ),
                    );

                    // Add to totals
                    $totalEmployees += $totalCount;
                    $totalBelow25 += $below25;
                    $total2530 += $age2530;
                    $total3035 += $age3035;
                    $total3540 += $age3540;
                    $total4045 += $age4045;
                    $totalAbove45 += $up45;
                  @endphp

                  <tr>
                    <td class="text-bold-500">{{ $directorate->name }}</td>
                    <td class="text-center">{{ $totalCount }}</td>
                    <td class="text-center">{{ $below25 }}</td>
                    <td class="text-center">{{ $age2530 }}</td>
                    <td class="text-center">{{ $age3540 }}</td>
                    <td class="text-center">{{ $age4045 }}</td>
                    <td class="text-center">{{ $up45 }}</td>
                  </tr>
                @endforeach
              @empty
                <tr>
                  <td class="text-bold-500 text-center" colspan="7">No data available in table</td>
                </tr>
              @endforelse

              <!-- Totals Row -->
              <tr class="table-primary">
                <td class="text-bold-500 text-center">TOTAL</td>
                <td class="text-center">{{ $totalEmployees }}</td>
                <td class="text-center">{{ $totalBelow25 }}</td>
                <td class="text-center">{{ $total2530 }}</td>
                <td class="text-center">{{ $total3035 }}</td>
                <td class="text-center">{{ $total3540 }}</td>
                <td class="text-center">{{ $total4045 }}</td>
                <td class="text-center">{{ $totalAbove45 }}</td>
              </tr>
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>
</div>
