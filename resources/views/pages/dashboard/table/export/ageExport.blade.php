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

        <div class="col-md-12">
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
        </div>

        {{-- <div class="col-md-12">
          <h3>OFFICE</h3>
          <table class="table table-sm table-bordered" style="font-size: 80%">
            <thead>
              <tr>
                <th style="width: 50; background-color: #b5b5b5b5">Unit Kerja</th>
                <th style="width: 20; background-color: #b5b5b5b5">Total Karyawan</th>
                <th style="width: 10; background-color: #b5b5b5b5">&lt; 20</th>
                <th style="width: 10; background-color: #b5b5b5b5">20-25</th>
                <th style="width: 10; background-color: #b5b5b5b5">25-35</th>
                <th style="width: 10; background-color: #b5b5b5b5">35-50</th>
                <th style="width: 10; background-color: #b5b5b5b5">&gt; 50</th>
              </tr>
            </thead>
            <tbody>
              @php
                $totals = [
                    'employees' => 0,
                    'below20' => 0,
                    '2025' => 0,
                    '2535' => 0,
                    '3550' => 0,
                    'above50' => 0,
                ];

                $groupedDirectorates = $directorates
                    ->groupBy('is_non')
                    ->sortKeysUsing(fn($a, $b) => [1, 2] <=> [$a, $b]);
              @endphp

              @forelse ($groupedDirectorates as $isNon => $directoratesGroup)
                <tr>
                  <td colspan="7" class="text-bold-500 text-center"
                    style="font-weight: bold; background-color: #969696b5">
                    {{ $isNon == 1 ? 'DIREKTORAT' : ($isNon == 2 ? 'NON-DIREKTORAT' : 'LAIN-LAIN') }}
                  </td>
                </tr>

                @foreach ($directoratesGroup as $directorate)
                  <tr>
                    <td class="text-bold-500" style="font-weight: bold;" colspan="7">{{ $directorate->name }}</td>
                  </tr>

                  @foreach ($directorate->divisions as $division)
                    @php
                      $counts = [
                          'total' => 0,
                          'below20' => 0,
                          '2025' => 0,
                          '2535' => 0,
                          '3550' => 0,
                          'above50' => 0,
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

                              if ($age < 20) {
                                  $counts['below20']++;
                              } elseif ($age < 25) {
                                  $counts['2025']++;
                              } elseif ($age < 35) {
                                  $counts['2535']++;
                              } elseif ($age < 50) {
                                  $counts['3550']++;
                              } else {
                                  $counts['above50']++;
                              }

                              $totals['below20'] += $age < 20 ? 1 : 0;
                              $totals['2025'] += $age >= 20 && $age < 25 ? 1 : 0;
                              $totals['2535'] += $age >= 25 && $age < 35 ? 1 : 0;
                              $totals['3550'] += $age >= 35 && $age < 50 ? 1 : 0;
                              $totals['above50'] += $age >= 50 ? 1 : 0;
                          }
                      }
                    @endphp

                    <tr>
                      <td class="pl-4">{{ $division->name }}</td>
                      <td>{{ $counts['total'] }}</td>
                      <td>{{ $counts['below20'] }}</td>
                      <td>{{ $counts['2025'] }}</td>
                      <td>{{ $counts['2535'] }}</td>
                      <td>{{ $counts['3550'] }}</td>
                      <td>{{ $counts['above50'] }}</td>
                    </tr>
                  @endforeach
                @endforeach
              @empty
                <tr>
                  <td colspan="7" class="text-center">No data available in table</td>
                </tr>
              @endforelse

              <tr class="table-primary">
                <td class="text-bold-500 text-center">TOTAL</td>
                <td>{{ $totals['employees'] }}</td>
                <td>{{ $totals['below20'] }}</td>
                <td>{{ $totals['2025'] }}</td>
                <td>{{ $totals['2535'] }}</td>
                <td>{{ $totals['3550'] }}</td>
                <td>{{ $totals['above50'] }}</td>
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
                <th style="width: 10; background-color: #b5b5b5b5">&lt; 20</th>
                <th style="width: 10; background-color: #b5b5b5b5">20-25</th>
                <th style="width: 10; background-color: #b5b5b5b5">25-35</th>
                <th style="width: 10; background-color: #b5b5b5b5">35-50</th>
                <th style="width: 10; background-color: #b5b5b5b5">&gt; 50</th>
              </tr>
            </thead>
            <tbody>
              @php
                $totals = [
                    'employees' => 0,
                    'below20' => 0,
                    '2025' => 0,
                    '2535' => 0,
                    '3550' => 0,
                    'above50' => 0,
                ];

                $groupedDirectorates = $directorates
                    ->groupBy('is_non')
                    ->sortKeysUsing(fn($a, $b) => [1, 2] <=> [$a, $b]);
              @endphp

              @forelse ($groupedDirectorates as $isNon => $directoratesGroup)
                <tr>
                  <td colspan="7" class="text-bold-500 text-center"
                    style="font-weight: bold; background-color: #969696b5">
                    {{ $isNon == 1 ? 'DIREKTORAT' : ($isNon == 2 ? 'NON-DIREKTORAT' : 'LAIN-LAIN') }}
                  </td>
                </tr>

                @foreach ($directoratesGroup as $directorate)
                  <tr>
                    <td class="text-bold-500" style="font-weight: bold;" colspan="7">{{ $directorate->name }}</td>
                  </tr>

                  @foreach ($directorate->divisions as $division)
                    @php
                      $counts = [
                          'total' => 0,
                          'below20' => 0,
                          '2025' => 0,
                          '2535' => 0,
                          '3550' => 0,
                          'above50' => 0,
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

                              if ($age < 20) {
                                  $counts['below20']++;
                              } elseif ($age < 25) {
                                  $counts['2025']++;
                              } elseif ($age < 35) {
                                  $counts['2535']++;
                              } elseif ($age < 50) {
                                  $counts['3550']++;
                              } else {
                                  $counts['above50']++;
                              }

                              $totals['below20'] += $age < 20 ? 1 : 0;
                              $totals['2025'] += $age >= 20 && $age < 25 ? 1 : 0;
                              $totals['2535'] += $age >= 25 && $age < 35 ? 1 : 0;
                              $totals['3550'] += $age >= 35 && $age < 50 ? 1 : 0;
                              $totals['above50'] += $age >= 50 ? 1 : 0;
                          }
                      }
                    @endphp

                    <tr>
                      <td class="pl-4">{{ $division->name }}</td>
                      <td>{{ $counts['total'] }}</td>
                      <td>{{ $counts['below20'] }}</td>
                      <td>{{ $counts['2025'] }}</td>
                      <td>{{ $counts['2535'] }}</td>
                      <td>{{ $counts['3550'] }}</td>
                      <td>{{ $counts['above50'] }}</td>
                    </tr>
                  @endforeach
                @endforeach
              @empty
                <tr>
                  <td colspan="7" class="text-center">No data available in table</td>
                </tr>
              @endforelse

              <tr class="table-primary">
                <td class="text-bold-500 text-center">TOTAL</td>
                <td>{{ $totals['employees'] }}</td>
                <td>{{ $totals['below20'] }}</td>
                <td>{{ $totals['2025'] }}</td>
                <td>{{ $totals['2535'] }}</td>
                <td>{{ $totals['3550'] }}</td>
                <td>{{ $totals['above50'] }}</td>
              </tr>
            </tbody>
          </table>
        </div> --}}


        {{-- <div class="col-md-12">
          <h3>OFFICE</h3>
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

                    // $office = $position->employee->employeeCategory->name === 'OFFICE';

                    $totalCount = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->employeeCategory->name === 'OFFICE'
                                ? 1
                                : 0,
                        ),
                    );

                    $below20 = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            Carbon::parse(optional($position->employee)->dob)->age < 20 &&
                            $position->employee->employeeCategory->name === 'OFFICE'
                                ? 1
                                : 0,
                        ),
                    );

                    $age2025 = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->employeeCategory->name === 'OFFICE' &&
                            Carbon::parse(optional($position->employee)->dob)->age >= 20 &&
                            Carbon::parse(optional($position->employee)->dob)->age < 25
                                ? 1
                                : 0,
                        ),
                    );

                    $age2535 = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->employeeCategory->name === 'OFFICE' &&
                            Carbon::parse(optional($position->employee)->dob)->age >= 25 &&
                            Carbon::parse(optional($position->employee)->dob)->age < 35
                                ? 1
                                : 0,
                        ),
                    );

                    $age3550 = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->employeeCategory->name === 'OFFICE' &&
                            Carbon::parse(optional($position->employee)->dob)->age >= 35 &&
                            Carbon::parse(optional($position->employee)->dob)->age < 50
                                ? 1
                                : 0,
                        ),
                    );

                    $up50 = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->employeeCategory->name === 'OFFICE' &&
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
        </div>

        <div class="col-md-12">
          <h3>NON-OFFICE</h3>
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

                    // $office = $position->employee->employeeCategory->name === 'OFFICE';

                    $totalCount = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->employeeCategory->name === 'NON-OFFICE'
                                ? 1
                                : 0,
                        ),
                    );

                    $below20 = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            Carbon::parse(optional($position->employee)->dob)->age < 20 &&
                            $position->employee->employeeCategory->name === 'NON-OFFICE'
                                ? 1
                                : 0,
                        ),
                    );

                    $age2025 = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->employeeCategory->name === 'NON-OFFICE' &&
                            Carbon::parse(optional($position->employee)->dob)->age >= 20 &&
                            Carbon::parse(optional($position->employee)->dob)->age < 25
                                ? 1
                                : 0,
                        ),
                    );

                    $age2535 = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->employeeCategory->name === 'NON-OFFICE' &&
                            Carbon::parse(optional($position->employee)->dob)->age >= 25 &&
                            Carbon::parse(optional($position->employee)->dob)->age < 35
                                ? 1
                                : 0,
                        ),
                    );

                    $age3550 = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->employeeCategory->name === 'NON-OFFICE' &&
                            Carbon::parse(optional($position->employee)->dob)->age >= 35 &&
                            Carbon::parse(optional($position->employee)->dob)->age < 50
                                ? 1
                                : 0,
                        ),
                    );

                    $up50 = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->employeeCategory->name === 'NON-OFFICE' &&
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

        {{-- keterangan seminar,ganti text card dashboard,print candidate, modif seleksi, --}}
