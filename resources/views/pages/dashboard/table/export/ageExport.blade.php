        {{-- <div class="col-md-12">
          <table class="table table-sm table-bordered" style="font-size: 80%">
            <thead>
              <tr>
                <th style="width: 50; background-color: #b5b5b5b5">Unit Kerja</th>
                <th style="width: 20; background-color: #b5b5b5b5">Total Karyawan</th>
                <th style="width:10; background-color: #b5b5b5b5">
                  < 20</th>
                <th style="width:10; background-color: #b5b5b5b5">20-25</th>
                <th style="width:10; background-color: #b5b5b5b5">25-35</th>
                <th style="width:10; background-color: #b5b5b5b5">35-50</th>
                <th style="width: 10; background-color: #b5b5b5b5">> 50</th>
              </tr>
            </thead>
            <tbody>
              @php
                use Carbon\Carbon;

                $totalEmployees = 0;
                $totalBelow20 = 0;
                $total2025 = 0;
                $total2535 = 0;
                $total3550 = 0;
                $totalAbove50 = 0;

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

                    $below20 = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            Carbon::parse(optional($position->employee)->dob)->age < 20
                                ? 1
                                : 0,
                        ),
                    );

                    $age2025 = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            Carbon::parse(optional($position->employee)->dob)->age >= 20 &&
                            Carbon::parse(optional($position->employee)->dob)->age < 25
                                ? 1
                                : 0,
                        ),
                    );

                    $age2535 = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            Carbon::parse(optional($position->employee)->dob)->age >= 25 &&
                            Carbon::parse(optional($position->employee)->dob)->age < 35
                                ? 1
                                : 0,
                        ),
                    );

                    $age3550 = $directorate->divisions->sum(
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

                    // Add to totals
                    $totalEmployees += $totalCount;
                    $totalBelow20 += $below20;
                    $total2025 += $age2025;
                    $total2535 += $age2535;
                    $total3550 += $age3550;
                    $totalAbove50 += $up50;
                  @endphp

                  <tr>
                    <td class="text-bold-500">{{ $directorate->name }}</td>
                    <td>{{ $totalCount }}</td>
                    <td>{{ $below20 }}</td>
                    <td>{{ $age2025 }}</td>
                    <td>{{ $age2535 }}</td>
                    <td>{{ $age3550 }}</td>
                    <td>{{ $up50 }}</td>
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
                <td>{{ $totalEmployees }}</td>
                <td>{{ $totalBelow20 }}</td>
                <td>{{ $total2025 }}</td>
                <td>{{ $total2535 }}</td>
                <td>{{ $total3550 }}</td>
                <td>{{ $totalAbove50 }}</td>
              </tr>
            </tbody>
          </table>
        </div> --}}

        <div class="col-md-12">
          <table class="table table-sm table-bordered" style="font-size: 80%">
            <thead>
              <tr>
                <th style="width: 50; background-color: #b5b5b5b5">Unit Kerja</th>
                <th style="width: 20; background-color: #b5b5b5b5">Total Karyawan</th>
                <th style="width: 10; background-color: #b5b5b5b5">&lt; 25</th>
                <th style="width: 10; background-color: #b5b5b5b5">25-30</th>
                <th style="width: 10; background-color: #b5b5b5b5">30-35</th>
                <th style="width: 10; background-color: #b5b5b5b5">35-40</th>
                <th style="width: 10; background-color: #b5b5b5b5">40-45</th>
                <th style="width: 10; background-color: #b5b5b5b5">&gt; 45</th>
              </tr>
            </thead>
            <tbody>
              @php
                use Carbon\Carbon;
                $totals = [
                    'employees' => 0,
                    'below25' => 0,
                    '2530' => 0,
                    '3035' => 0,
                    '3540' => 0,
                    '4045' => 0,
                    'above45' => 0,
                ];

                $groupedDirectorates = $directorates
                    ->groupBy('is_non')
                    ->sortKeysUsing(fn($a, $b) => [1, 2] <=> [$a, $b]);
              @endphp

              @forelse ($groupedDirectorates as $isNon => $directoratesGroup)
                <tr>
                  <td colspan="8" class="text-bold-500 text-center"
                    style="font-weight: bold; background-color: #969696b5">
                    {{ $isNon == 1 ? 'DIREKTORAT' : ($isNon == 2 ? 'NON-DIREKTORAT' : 'LAIN-LAIN') }}
                  </td>
                </tr>

                @foreach ($directoratesGroup as $directorate)
                  <tr>
                    <td class="text-bold-500" style="font-weight: bold;" colspan="8">{{ $directorate->name }}</td>
                  </tr>

                  @foreach ($directorate->divisions as $division)
                    @php
                      $counts = [
                          'employees' => 0,
                          'total' => 0,
                          'below25' => 0,
                          '2530' => 0,
                          '3035' => 0,
                          '3540' => 0,
                          '4045' => 0,
                          'above45' => 0,
                      ];

                      foreach ($division->positions as $position) {
                          $employee = $position->employee;
                          if ($employee && $employee->employee_status === 'AKTIF') {
                              $age = $employee->dob ? Carbon::parse($employee->dob)->age : null;

                              $counts['total']++;
                              $totals['employees']++;

                              if ($age < 25) {
                                  $counts['below25']++;
                              } elseif ($age < 30) {
                                  $counts['2530']++;
                              } elseif ($age < 35) {
                                  $counts['3035']++;
                              } elseif ($age < 40) {
                                  $counts['3540']++;
                              } elseif ($age < 45) {
                                  $counts['4045']++;
                              } else {
                                  $counts['above45']++;
                              }

                              $totals['below25'] += $age < 25 ? 1 : 0;
                              $totals['2530'] += $age >= 25 && $age < 30 ? 1 : 0;
                              $totals['3035'] += $age >= 30 && $age < 35 ? 1 : 0;
                              $totals['3540'] += $age >= 35 && $age < 40 ? 1 : 0;
                              $totals['4045'] += $age >= 40 && $age < 45 ? 1 : 0;
                              $totals['above45'] += $age >= 45 ? 1 : 0;
                          }
                      }
                    @endphp

                    <tr>
                      <td class="pl-4">{{ $division->name }}</td>
                      <td>{{ $counts['total'] }}</td>
                      <td>{{ $counts['below25'] }}</td>
                      <td>{{ $counts['2530'] }}</td>
                      <td>{{ $counts['3035'] }}</td>
                      <td>{{ $counts['3540'] }}</td>
                      <td>{{ $counts['4045'] }}</td>
                      <td>{{ $counts['above45'] }}</td>
                    </tr>
                  @endforeach
                @endforeach
              @empty
                <tr>
                  <td colspan="8" class="text-center">No data available in table</td>
                </tr>
              @endforelse

              <tr class="table-primary">
                <td class="text-bold-500 text-center">TOTAL</td>
                <td>{{ $totals['employees'] }}</td>
                <td>{{ $totals['below25'] }}</td>
                <td>{{ $totals['2530'] }}</td>
                <td>{{ $totals['3035'] }}</td>
                <td>{{ $totals['3540'] }}</td>
                <td>{{ $totals['4045'] }}</td>
                <td>{{ $totals['above45'] }}</td>
              </tr>
            </tbody>
          </table>
        </div>

        @php
          // Group employees by category
          $employeeCategories = collect();

          foreach ($directorates as $directorate) {
              foreach ($directorate->divisions as $division) {
                  foreach ($division->positions as $position) {
                      if ($position->employee && $position->employee->employee_status === 'AKTIF') {
                          $category = optional($position->employee->employeeCategory)->name;
                          if ($category) {
                              $employeeCategories->push($category);
                          }
                      }
                  }
              }
          }

          $employeeCategories = $employeeCategories->unique()->sort();
        @endphp

        @foreach ($employeeCategories as $category)
          <div class="col-md-12">
            <h2>{{ strtoupper($category) }}</h2>

            @foreach ($directorates as $directorate)
              @php
                // Count total employees in the directorate under the current category
                $totalDirectorateEmployees = 0;
              @endphp

              @foreach ($directorate->divisions as $division)
                @php
                  // Count employees in the division under the category
                  $totalCount = $division->positions->sum(
                      fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                      optional($position->employee->employeeCategory)->name === $category
                          ? 1
                          : 0,
                  );

                  if ($totalCount > 0) {
                      $totalDirectorateEmployees += $totalCount;
                  }
                @endphp
              @endforeach

              @if ($totalDirectorateEmployees > 0)
                <h4 style="background-color: #969696b5">{{ $directorate->name }}</h4>
                <table class="table table-sm table-bordered" style="font-size: 80%">
                  <thead>
                    <tr>
                      <th class="text-center">Divisi</th>
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
                    @endphp

                    @foreach ($directorate->divisions as $division)
                      @php
                        $totalCount = $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            optional($position->employee->employeeCategory)->name === $category
                                ? 1
                                : 0,
                        );

                        if ($totalCount == 0) {
                            continue; // Skip division if no employees in this category
                        }

                        $below25 = $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            optional($position->employee->employeeCategory)->name === $category &&
                            Carbon::parse(optional($position->employee)->dob)->age < 25
                                ? 1
                                : 0,
                        );

                        $age2530 = $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            optional($position->employee->employeeCategory)->name === $category &&
                            Carbon::parse(optional($position->employee)->dob)->age >= 25 &&
                            Carbon::parse(optional($position->employee)->dob)->age < 30
                                ? 1
                                : 0,
                        );

                        $age3035 = $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            optional($position->employee->employeeCategory)->name === $category &&
                            Carbon::parse(optional($position->employee)->dob)->age >= 30 &&
                            Carbon::parse(optional($position->employee)->dob)->age < 35
                                ? 1
                                : 0,
                        );

                        $age3540 = $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            optional($position->employee->employeeCategory)->name === $category &&
                            Carbon::parse(optional($position->employee)->dob)->age >= 35 &&
                            Carbon::parse(optional($position->employee)->dob)->age < 40
                                ? 1
                                : 0,
                        );

                        $age4045 = $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            optional($position->employee->employeeCategory)->name === $category &&
                            Carbon::parse(optional($position->employee)->dob)->age >= 40 &&
                            Carbon::parse(optional($position->employee)->dob)->age < 45
                                ? 1
                                : 0,
                        );

                        $up45 = $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            optional($position->employee->employeeCategory)->name === $category &&
                            Carbon::parse(optional($position->employee)->dob)->age >= 45
                                ? 1
                                : 0,
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
                        <td class="text-bold-500">{{ $division->name }}</td>
                        <td class="text-center">{{ $totalCount }}</td>
                        <td class="text-center">{{ $below25 }}</td>
                        <td class="text-center">{{ $age2530 }}</td>
                        <td class="text-center">{{ $age3035 }}</td>
                        <td class="text-center">{{ $age3540 }}</td>
                        <td class="text-center">{{ $age4045 }}</td>
                        <td class="text-center">{{ $up45 }}</td>
                      </tr>
                    @endforeach

                    <!-- Totals Row -->
                    <tr class="table-primary">
                      <td class="text-bold-500 text-center" style="background-color: #969696b5">TOTAL</td>
                      <td class="text-center" style="background-color: #969696b5">{{ $totalEmployees }}</td>
                      <td class="text-center" style="background-color: #969696b5">{{ $totalBelow25 }}</td>
                      <td class="text-center" style="background-color: #969696b5">{{ $total2530 }}</td>
                      <td class="text-center" style="background-color: #969696b5">{{ $total3035 }}</td>
                      <td class="text-center" style="background-color: #969696b5">{{ $total3540 }}</td>
                      <td class="text-center" style="background-color: #969696b5">{{ $total4045 }}</td>
                      <td class="text-center" style="background-color: #969696b5">{{ $totalAbove45 }}</td>
                    </tr>
                  </tbody>
                </table>
              @endif
            @endforeach
          </div>
        @endforeach



        {{-- <div class="col-md-12">
          <h3>OFFICE</h3>
          <table class="table table-sm table-bordered" style="font-size: 80%">
            <thead>
              <tr>
                <th style="width: 50; background-color: #b5b5b5b5">Unit Kerja</th>
                <th style="width: 20; background-color: #b5b5b5b5">Total Karyawan</th>
                <th style="width: 10; background-color: #b5b5b5b5">&lt; 25</th>
                <th style="width: 10; background-color: #b5b5b5b5">25-30</th>
                <th style="width: 10; background-color: #b5b5b5b5">30-35</th>
                <th style="width: 10; background-color: #b5b5b5b5">35-40</th>
                <th style="width: 10; background-color: #b5b5b5b5">40-45</th>
                <th style="width: 10; background-color: #b5b5b5b5">&gt; 45</th>
              </tr>
            </thead>
            <tbody>
              @php
                $totals = [
                    'employees' => 0,
                    'below25' => 0,
                    '2530' => 0,
                    '3035' => 0,
                    '3540' => 0,
                    '4045' => 0,
                    'above45' => 0,
                ];

                $groupedDirectorates = $directorates
                    ->groupBy('is_non')
                    ->sortKeysUsing(fn($a, $b) => [1, 2] <=> [$a, $b]);
              @endphp

              @forelse ($groupedDirectorates as $isNon => $directoratesGroup)
                <tr>
                  <td colspan="8" class="text-bold-500 text-center"
                    style="font-weight: bold; background-color: #969696b5">
                    {{ $isNon == 1 ? 'DIREKTORAT' : ($isNon == 2 ? 'NON-DIREKTORAT' : 'LAIN-LAIN') }}
                  </td>
                </tr>

                @foreach ($directoratesGroup as $directorate)
                  <tr>
                    <td class="text-bold-500" style="font-weight: bold;" colspan="8">{{ $directorate->name }}</td>
                  </tr>

                  @foreach ($directorate->divisions as $division)
                    @php
                      $counts = [
                          'employees' => 0,
                          'total' => 0,
                          'below25' => 0,
                          '2530' => 0,
                          '3035' => 0,
                          '3540' => 0,
                          '4045' => 0,
                          'above45' => 0,
                      ];

                      foreach ($division->positions as $position) {
                          $employee = $position->employee;
                          if (
                              $employee &&
                              $employee->employee_status === 'AKTIF' &&
                              $employee->employeeCategory->name === 'OFFICE'
                          ) {
                              $age = $employee->dob ? Carbon::parse($employee->dob)->age : null;

                              $counts['total']++;
                              $totals['employees']++;

                              if ($age < 25) {
                                  $counts['below25']++;
                              } elseif ($age < 30) {
                                  $counts['2530']++;
                              } elseif ($age < 35) {
                                  $counts['3035']++;
                              } elseif ($age < 40) {
                                  $counts['3540']++;
                              } elseif ($age < 45) {
                                  $counts['4045']++;
                              } else {
                                  $counts['above45']++;
                              }

                              $totals['below25'] += $age < 25 ? 1 : 0;
                              $totals['2530'] += $age >= 25 && $age < 30 ? 1 : 0;
                              $totals['3035'] += $age >= 30 && $age < 35 ? 1 : 0;
                              $totals['3540'] += $age >= 35 && $age < 40 ? 1 : 0;
                              $totals['4045'] += $age >= 40 && $age < 45 ? 1 : 0;
                              $totals['above45'] += $age >= 45 ? 1 : 0;
                          }
                      }
                    @endphp

                    <tr>
                      <td class="pl-4">{{ $division->name }}</td>
                      <td>{{ $counts['total'] }}</td>
                      <td>{{ $counts['below25'] }}</td>
                      <td>{{ $counts['2530'] }}</td>
                      <td>{{ $counts['3035'] }}</td>
                      <td>{{ $counts['3540'] }}</td>
                      <td>{{ $counts['4045'] }}</td>
                      <td>{{ $counts['above45'] }}</td>
                    </tr>
                  @endforeach
                @endforeach
              @empty
                <tr>
                  <td colspan="8" class="text-center">No data available in table</td>
                </tr>
              @endforelse

              <tr class="table-primary">
                <td class="text-bold-500 text-center">TOTAL</td>
                <td>{{ $totals['employees'] }}</td>
                <td>{{ $totals['below25'] }}</td>
                <td>{{ $totals['2530'] }}</td>
                <td>{{ $totals['3035'] }}</td>
                <td>{{ $totals['3540'] }}</td>
                <td>{{ $totals['4045'] }}</td>
                <td>{{ $totals['above45'] }}</td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="col-md-12">
          <h3>NON-OFFICE</h3>
          <table class="table table-sm table-bordered" style="font-size: 80%">
            <thead>
              <tr>
                <th style="width: 50; background-color: #b5b5b5b5">Unit Kerja</th>
                <th style="width: 20; background-color: #b5b5b5b5">Total Karyawan</th>
                <th style="width: 10; background-color: #b5b5b5b5">&lt; 25</th>
                <th style="width: 10; background-color: #b5b5b5b5">25-30</th>
                <th style="width: 10; background-color: #b5b5b5b5">30-35</th>
                <th style="width: 10; background-color: #b5b5b5b5">35-40</th>
                <th style="width: 10; background-color: #b5b5b5b5">40-45</th>
                <th style="width: 10; background-color: #b5b5b5b5">&gt; 45</th>
              </tr>
            </thead>
            <tbody>
              @php
                $totals = [
                    'employees' => 0,
                    'below25' => 0,
                    '2530' => 0,
                    '3035' => 0,
                    '3540' => 0,
                    '4045' => 0,
                    'above45' => 0,
                ];

                $groupedDirectorates = $directorates
                    ->groupBy('is_non')
                    ->sortKeysUsing(fn($a, $b) => [1, 2] <=> [$a, $b]);
              @endphp

              @forelse ($groupedDirectorates as $isNon => $directoratesGroup)
                <tr>
                  <td colspan="8" class="text-bold-500 text-center"
                    style="font-weight: bold; background-color: #969696b5">
                    {{ $isNon == 1 ? 'DIREKTORAT' : ($isNon == 2 ? 'NON-DIREKTORAT' : 'LAIN-LAIN') }}
                  </td>
                </tr>

                @foreach ($directoratesGroup as $directorate)
                  <tr>
                    <td class="text-bold-500" style="font-weight: bold;" colspan="8">{{ $directorate->name }}</td>
                  </tr>

                  @foreach ($directorate->divisions as $division)
                    @php
                      $counts = [
                          'employees' => 0,
                          'total' => 0,
                          'below25' => 0,
                          '2530' => 0,
                          '3035' => 0,
                          '3540' => 0,
                          '4045' => 0,
                          'above45' => 0,
                      ];

                      foreach ($division->positions as $position) {
                          $employee = $position->employee;
                          if (
                              $employee &&
                              $employee->employee_status === 'AKTIF' &&
                              $employee->employeeCategory->name === 'NON-OFFICE'
                          ) {
                              $age = $employee->dob ? Carbon::parse($employee->dob)->age : null;

                              $counts['total']++;
                              $totals['employees']++;

                              if ($age < 25) {
                                  $counts['below25']++;
                              } elseif ($age < 30) {
                                  $counts['2530']++;
                              } elseif ($age < 35) {
                                  $counts['3035']++;
                              } elseif ($age < 40) {
                                  $counts['3540']++;
                              } elseif ($age < 45) {
                                  $counts['4045']++;
                              } else {
                                  $counts['above45']++;
                              }

                              $totals['below25'] += $age < 25 ? 1 : 0;
                              $totals['2530'] += $age >= 25 && $age < 30 ? 1 : 0;
                              $totals['3035'] += $age >= 30 && $age < 35 ? 1 : 0;
                              $totals['3540'] += $age >= 35 && $age < 40 ? 1 : 0;
                              $totals['4045'] += $age >= 40 && $age < 45 ? 1 : 0;
                              $totals['above45'] += $age >= 45 ? 1 : 0;
                          }
                      }
                    @endphp

                    <tr>
                      <td class="pl-4">{{ $division->name }}</td>
                      <td>{{ $counts['total'] }}</td>
                      <td>{{ $counts['below25'] }}</td>
                      <td>{{ $counts['2530'] }}</td>
                      <td>{{ $counts['3035'] }}</td>
                      <td>{{ $counts['3540'] }}</td>
                      <td>{{ $counts['4045'] }}</td>
                      <td>{{ $counts['above45'] }}</td>
                    </tr>
                  @endforeach
                @endforeach
              @empty
                <tr>
                  <td colspan="8" class="text-center">No data available in table</td>
                </tr>
              @endforelse

              <tr class="table-primary">
                <td class="text-bold-500 text-center">TOTAL</td>
                <td>{{ $totals['employees'] }}</td>
                <td>{{ $totals['below25'] }}</td>
                <td>{{ $totals['2530'] }}</td>
                <td>{{ $totals['3035'] }}</td>
                <td>{{ $totals['3540'] }}</td>
                <td>{{ $totals['4045'] }}</td>
                <td>{{ $totals['above45'] }}</td>
              </tr>
            </tbody>
          </table>
        </div> --}}


        <table>
          <thead>
            <tr>
              <th style=" background-color: #b5b5b5b5">Directorate</th>
              <th style="background-color: #b5b5b5b5">Division</th>
              <th style="background-color: #b5b5b5b5">NIK</th>
              <th style="background-color: #b5b5b5b5">Nama Karyawan</th>
              <th style="background-color: #b5b5b5b5">Level Jabatan</th>
              <th style="background-color: #b5b5b5b5">Jabatan</th>
              <th style="background-color: #b5b5b5b5">Kategori Karyawan</th>
              <th style="background-color: #b5b5b5b5">Tanggal Lahir</th>
              <th style="background-color: #b5b5b5b5">Usia</th>
            </tr>
          </thead>
          <tbody>
            @php
              // Collect all employees in an array
              $employees = [];
              foreach ($directorates as $directorate) {
                  foreach ($directorate->divisions as $division) {
                      foreach ($division->positions as $position) {
                          $employee = $position->employee;
                          if ($employee && $employee->employee_status === 'AKTIF') {
                              $employees[] = [
                                  'directorate' => $directorate->name,
                                  'division' => $division->name,
                                  'nik' => $employee->nik,
                                  'name' => $employee->name,
                                  'level' => $position->level->name,
                                  'position' => $position->name,
                                  'category' => optional($employee->employeeCategory)->name,
                                  'dob' => Carbon::parse($employee->dob)->translatedFormat('d-m-Y'),
                                  'age' => Carbon::parse($employee->dob)->age,
                              ];
                          }
                      }
                  }
              }

              // Sort the employees array by gender (assuming you want 'LAKI-LAKI' first)
              usort($employees, function ($a, $b) {
                  return $a['age'] <=> $b['age'];
              });
            @endphp

            @foreach ($employees as $employee)
              <tr>
                <td>{{ $employee['directorate'] }}</td>
                <td>{{ $employee['division'] }}</td>
                <td>{{ $employee['nik'] }}</td>
                <td>{{ $employee['name'] }}</td>
                <td>{{ $employee['level'] }}</td>
                <td>{{ $employee['position'] }}</td>
                <td>{{ $employee['category'] }}</td>
                <td>{{ $employee['dob'] }}</td>
                <td>{{ $employee['age'] }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>

        {{-- <table>
          <tr>
            <td colspan="9" style="font-size: 18px; background-color: #a5a4a4; text-align: center">Usia Diatas 50
              Tahun</td>
          </tr>
          <thead>
            <tr>
              <th style=" background-color: #b5b5b5b5">Directorate</th>
              <th style="background-color: #b5b5b5b5">Division</th>
              <th style="background-color: #b5b5b5b5">NIK</th>
              <th style="background-color: #b5b5b5b5">Nama Karyawan</th>
              <th style="background-color: #b5b5b5b5">Level Jabatan</th>
              <th style="background-color: #b5b5b5b5">Jabatan</th>
              <th style="background-color: #b5b5b5b5">Kategori Karyawan</th>
              <th style="background-color: #b5b5b5b5">Tanggal Lahir</th>
              <th style="background-color: #b5b5b5b5">Usia</th>
            </tr>
          </thead>
          <tbody>
            @php
              // Collect all employees in an array
              $employees = [];
              foreach ($directorates as $directorate) {
                  foreach ($directorate->divisions as $division) {
                      foreach ($division->positions as $position) {
                          $employee = $position->employee;
                          if (
                              $employee &&
                              $employee->employee_status === 'AKTIF' &&
                              Carbon::parse(optional($position->employee)->dob)->age >= 50
                          ) {
                              $employees[] = [
                                  'directorate' => $directorate->name,
                                  'division' => $division->name,
                                  'nik' => $employee->nik,
                                  'name' => $employee->name,
                                  'level' => $position->level->name,
                                  'position' => $position->name,
                                  'category' => optional($employee->employeeCategory)->name,
                                  'dob' => Carbon::parse($employee->dob)->translatedFormat('d-m-Y'),
                                  'age' => Carbon::parse($employee->dob)->age,
                              ];
                          }
                      }
                  }
              }

              // Sort the employees array by gender (assuming you want 'LAKI-LAKI' first)
              usort($employees, function ($a, $b) {
                  return $a['age'] <=> $b['age'];
              });
            @endphp

            @foreach ($employees as $employee)
              <tr>
                <td>{{ $employee['directorate'] }}</td>
                <td>{{ $employee['division'] }}</td>
                <td>{{ $employee['nik'] }}</td>
                <td>{{ $employee['name'] }}</td>
                <td>{{ $employee['level'] }}</td>
                <td>{{ $employee['position'] }}</td>
                <td>{{ $employee['category'] }}</td>
                <td>{{ $employee['dob'] }}</td>
                <td>{{ $employee['age'] }}</td>
              </tr>
            @endforeach
          </tbody>
        </table> --}}

        <table>
          <tr>
            <td colspan="10" style="font-size: 18px; background-color: #a5a4a4; text-align: center">Karyawan yang akan
              ber-usia 55 tahun Ini ( {{ now()->year }} )
            </td>
          </tr>
          <thead>
            <tr>
              <th style=" background-color: #b5b5b5b5">No.</th>
              <th style=" background-color: #b5b5b5b5">Directorate</th>
              <th style="background-color: #b5b5b5b5">Division</th>
              <th style="background-color: #b5b5b5b5">NIK</th>
              <th style="background-color: #b5b5b5b5">Nama Karyawan</th>
              <th style="background-color: #b5b5b5b5">Level Jabatan</th>
              <th style="background-color: #b5b5b5b5">Jabatan</th>
              <th style="background-color: #b5b5b5b5">Kategori Karyawan</th>
              <th style="background-color: #b5b5b5b5">Tanggal Lahir</th>
              <th style="background-color: #b5b5b5b5">Usia</th>
            </tr>
          </thead>
          <tbody>
            @php
              // Collect all employees in an array
              $employees = [];
              foreach ($directorates as $directorate) {
                  foreach ($directorate->divisions as $division) {
                      foreach ($division->positions as $position) {
                          $employee = $position->employee;
                          if (
                              $employee &&
                              $employee->employee_status === 'AKTIF' &&
                              Carbon::parse(optional($position->employee)->dob)->year === now()->year - 55
                          ) {
                              $employees[] = [
                                  'directorate' => $directorate->name,
                                  'division' => $division->name,
                                  'nik' => $employee->nik,
                                  'name' => $employee->name,
                                  'level' => $position->level->name,
                                  'position' => $position->name,
                                  'category' => optional($employee->employeeCategory)->name,
                                  'dob' => Carbon::parse($employee->dob)->translatedFormat('d-m-Y'),
                                  'age' => Carbon::parse($employee->dob)->age,
                              ];
                          }
                      }
                  }
              }

              // Sort the employees array by gender (assuming you want 'LAKI-LAKI' first)
              usort($employees, function ($a, $b) {
                  return $a['age'] <=> $b['age'];
              });
            @endphp

            @foreach ($employees as $employee)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $employee['directorate'] }}</td>
                <td>{{ $employee['division'] }}</td>
                <td>{{ $employee['nik'] }}</td>
                <td>{{ $employee['name'] }}</td>
                <td>{{ $employee['level'] }}</td>
                <td>{{ $employee['position'] }}</td>
                <td>{{ $employee['category'] }}</td>
                <td>{{ $employee['dob'] }}</td>
                <td>{{ $employee['age'] }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>

        <table>
          <tr>
            <td colspan="10" style="font-size: 18px; background-color: #a5a4a4; text-align: center">Karyawan Usia
              Diatas 55 Tahun
            </td>
          </tr>
          <thead>
            <tr>
              <th style=" background-color: #b5b5b5b5">No.</th>
              <th style=" background-color: #b5b5b5b5">Directorate</th>
              <th style="background-color: #b5b5b5b5">Division</th>
              <th style="background-color: #b5b5b5b5">NIK</th>
              <th style="background-color: #b5b5b5b5">Nama Karyawan</th>
              <th style="background-color: #b5b5b5b5">Level Jabatan</th>
              <th style="background-color: #b5b5b5b5">Jabatan</th>
              <th style="background-color: #b5b5b5b5">Kategori Karyawan</th>
              <th style="background-color: #b5b5b5b5">Tanggal Lahir</th>
              <th style="background-color: #b5b5b5b5">Usia</th>
            </tr>
          </thead>
          <tbody>
            @php
              // Collect all employees in an array
              $employees = [];
              foreach ($directorates as $directorate) {
                  foreach ($directorate->divisions as $division) {
                      foreach ($division->positions as $position) {
                          $employee = $position->employee;
                          if (
                              $employee &&
                              $employee->employee_status === 'AKTIF' &&
                              Carbon::parse(optional($position->employee)->dob)->age >= 55
                          ) {
                              $employees[] = [
                                  'directorate' => $directorate->name,
                                  'division' => $division->name,
                                  'nik' => $employee->nik,
                                  'name' => $employee->name,
                                  'level' => $position->level->name,
                                  'position' => $position->name,
                                  'category' => optional($employee->employeeCategory)->name,
                                  'dob' => Carbon::parse($employee->dob)->translatedFormat('d-m-Y'),
                                  'age' => Carbon::parse($employee->dob)->age,
                              ];
                          }
                      }
                  }
              }

              // Sort the employees array by gender (assuming you want 'LAKI-LAKI' first)
              usort($employees, function ($a, $b) {
                  return $a['age'] <=> $b['age'];
              });
            @endphp

            @foreach ($employees as $employee)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $employee['directorate'] }}</td>
                <td>{{ $employee['division'] }}</td>
                <td>{{ $employee['nik'] }}</td>
                <td>{{ $employee['name'] }}</td>
                <td>{{ $employee['level'] }}</td>
                <td>{{ $employee['position'] }}</td>
                <td>{{ $employee['category'] }}</td>
                <td>{{ $employee['dob'] }}</td>
                <td>{{ $employee['age'] }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
