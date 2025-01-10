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

        {{-- <div class="col-md-12">
          <table class="table table-sm table-bordered" style="font-size: 80%">
            <thead>
              <tr>
                <th style="width: 50; background-color: #b5b5b5b5">Unit Kerja</th>
                <th style="width: 20; background-color: #b5b5b5b5">Total Karyawan</th>
                <th style="width: 10; background-color: #b5b5b5b5">Islam</th>
                <th style="width: 10; background-color: #b5b5b5b5">Kristen</th>
                <th style="width: 10; background-color: #b5b5b5b5">Katolik</th>
                <th style="width: 10; background-color: #b5b5b5b5">Hindu</th>
                <th style="width: 10; background-color: #b5b5b5b5">Buddha</th>
                <th style="width: 10; background-color: #b5b5b5b5">Konghucu</th>
                <th style="width: 10; background-color: #b5b5b5b5">Dan Lain-lain</th>
              </tr>
            </thead>
            <tbody>
              @php
                use Carbon\Carbon;
                $totals = [
                    'employees' => 0,
                    'islam' => 0,
                    'kristen' => 0,
                    'katolik' => 0,
                    'hindu' => 0,
                    'buddha' => 0,
                    'konghucu' => 0,
                    'dll' => 0,
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
                          'employees' => 0,
                          'islam' => 0,
                          'kristen' => 0,
                          'katolik' => 0,
                          'hindu' => 0,
                          'buddha' => 0,
                          'konghucu' => 0,
                          'dll' => 0,
                      ];

                      foreach ($division->positions as $position) {
                          $employee = $position->employee;
                          if ($employee && $employee->employee_status === 'AKTIF') {
                              $religion = $employee->religion;

                              $counts['total']++;

                              $totals['employees']++;

                              if ($religion == 'Islam') {
                                  $counts['islam']++;
                              } elseif ($religion == 'Kristen') {
                                  $counts['kristen']++;
                              } elseif ($religion == 'Katolik') {
                                  $counts['katolik']++;
                              } elseif ($religion == 'Hindu') {
                                  $counts['hindu']++;
                              } elseif ($religion == 'Buddha') {
                                  $counts['buddha']++;
                              } elseif ($religion == 'Konghucu') {
                                  $counts['konghucu']++;
                              } elseif ($religion == 'Dan Lain-lain') {
                                  $counts['dll']++;
                              }

                              $totals['islam'] += $religion == 'Islam' ? 1 : 0;
                              $totals['kristen'] += $religion == 'Kristen' ? 1 : 0;
                              $totals['katolik'] += $religion == 'Katolik' ? 1 : 0;
                              $totals['hindu'] += $religion == 'Hindu' ? 1 : 0;
                              $totals['buddha'] += $religion == 'Buddha' ? 1 : 0;
                              $totals['konghucu'] += $religion == 'Konghucu' ? 1 : 0;
                              $totals['dll'] += $religion == 'Dan Lain-lain' ? 1 : 0;
                          }
                      }
                    @endphp

                    <tr>
                      <td class="pl-4">{{ $division->name }}</td>
                      <td>{{ $counts['total'] }}</td>
                      <td>{{ $counts['islam'] }}</td>
                      <td>{{ $counts['kristen'] }}</td>
                      <td>{{ $counts['katolik'] }}</td>
                      <td>{{ $counts['hindu'] }}</td>
                      <td>{{ $counts['buddha'] }}</td>
                      <td>{{ $counts['konghucu'] }}</td>
                      <td>{{ $counts['dll'] }}</td>
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
                <td>{{ $totals['islam'] }}</td>
                <td>{{ $totals['kristen'] }}</td>
                <td>{{ $totals['katolik'] }}</td>
                <td>{{ $totals['hindu'] }}</td>
                <td>{{ $totals['buddha'] }}</td>
                <td>{{ $totals['konghucu'] }}</td>
                <td>{{ $totals['dll'] }}</td>
              </tr>
            </tbody>
          </table>
        </div> --}}

        @php
          function countByReligion($positions)
          {
              $counts = [
                  'total' => 0,
                  'islam' => 0,
                  'kristen' => 0,
                  'katolik' => 0,
                  'hindu' => 0,
                  'buddha' => 0,
                  'konghucu' => 0,
                  'dll' => 0,
              ];

              foreach ($positions as $position) {
                  $employee = $position->employee;
                  if ($employee && $employee->employee_status === 'AKTIF') {
                      $religion = $employee->religion;

                      $counts['total']++;
                      $counts[strtolower($religion) ?? 'dll']++;
                  }
              }

              return $counts;
          }
        @endphp

        <div class="col-md-12">
          <table class="table table-sm table-bordered table-striped" style="font-size: 80%">
            <thead class="thead-light">
              <tr>
                <th style="width: 50; background-color: #b5b5b5b5">Unit Kerja</th>
                <th style="width: 20; background-color: #b5b5b5b5">Total Karyawan</th>
                <th style="width: 10; background-color: #b5b5b5b5">Islam</th>
                <th style="width: 10; background-color: #b5b5b5b5">Kristen</th>
                <th style="width: 10; background-color: #b5b5b5b5">Katolik</th>
                <th style="width: 10; background-color: #b5b5b5b5">Hindu</th>
                <th style="width: 10; background-color: #b5b5b5b5">Buddha</th>
                <th style="width: 10; background-color: #b5b5b5b5">Konghucu</th>
                <th style="width: 10; background-color: #b5b5b5b5">Dan Lain-lain</th>
              </tr>
            </thead>
            <tbody>
              @php
                use Carbon\Carbon;
                $totals = [
                    'employees' => 0,
                    'islam' => 0,
                    'kristen' => 0,
                    'katolik' => 0,
                    'hindu' => 0,
                    'buddha' => 0,
                    'konghucu' => 0,
                    'dll' => 0,
                ];

                $groupedDirectorates = $directorates->groupBy('is_non')->sortKeys();
              @endphp

              @forelse ($groupedDirectorates as $isNon => $directoratesGroup)
                <tr>
                  <td colspan="9" class="text-bold-500 text-center"
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
                      $counts = countByReligion($division->positions);
                    @endphp

                    <tr>
                      <td class="pl-4">{{ $division->name }}</td>
                      <td>{{ $counts['total'] }}</td>
                      <td>{{ $counts['islam'] }}</td>
                      <td>{{ $counts['kristen'] }}</td>
                      <td>{{ $counts['katolik'] }}</td>
                      <td>{{ $counts['hindu'] }}</td>
                      <td>{{ $counts['buddha'] }}</td>
                      <td>{{ $counts['konghucu'] }}</td>
                      <td>{{ $counts['dll'] }}</td>
                    </tr>

                    @php
                      $totals['employees'] += $counts['total'];
                      $totals['islam'] += $counts['islam'];
                      $totals['kristen'] += $counts['kristen'];
                      $totals['katolik'] += $counts['katolik'];
                      $totals['hindu'] += $counts['hindu'];
                      $totals['buddha'] += $counts['buddha'];
                      $totals['konghucu'] += $counts['konghucu'];
                      $totals['dll'] += $counts['dll'];
                    @endphp
                  @endforeach
                @endforeach
              @empty
                <tr>
                  <td colspan="7" class="text-center">No data available in table</td>
                </tr>
              @endforelse

              <tr class="table-primary font-weight-bold">
                <td class="text-center">TOTAL</td>
                <td>{{ $totals['employees'] }}</td>
                <td>{{ $totals['islam'] }}</td>
                <td>{{ $totals['kristen'] }}</td>
                <td>{{ $totals['katolik'] }}</td>
                <td>{{ $totals['hindu'] }}</td>
                <td>{{ $totals['buddha'] }}</td>
                <td>{{ $totals['konghucu'] }}</td>
                <td>{{ $totals['dll'] }}</td>
              </tr>
            </tbody>
          </table>
        </div>

        @php
          function countByReligionOffice($positions)
          {
              $counts = [
                  'total' => 0,
                  'islam' => 0,
                  'kristen' => 0,
                  'katolik' => 0,
                  'hindu' => 0,
                  'buddha' => 0,
                  'konghucu' => 0,
                  'dll' => 0,
              ];

              foreach ($positions as $position) {
                  $employee = $position->employee;
                  if (
                      $employee &&
                      $employee->employee_status === 'AKTIF' &&
                      $employee->employeeCategory->name === 'OFFICE'
                  ) {
                      $religion = $employee->religion;

                      $counts['total']++;
                      $counts[strtolower($religion) ?? 'dll']++;
                  }
              }

              return $counts;
          }
        @endphp

        <div class="col-md-12">
          <h3>OFFICE</h3>
          <table class="table table-sm table-bordered table-striped" style="font-size: 80%">
            <thead class="thead-light">
              <tr>
                <th style="width: 50; background-color: #b5b5b5b5">Unit Kerja</th>
                <th style="width: 20; background-color: #b5b5b5b5">Total Karyawan</th>
                <th style="width: 10; background-color: #b5b5b5b5">Islam</th>
                <th style="width: 10; background-color: #b5b5b5b5">Kristen</th>
                <th style="width: 10; background-color: #b5b5b5b5">Katolik</th>
                <th style="width: 10; background-color: #b5b5b5b5">Hindu</th>
                <th style="width: 10; background-color: #b5b5b5b5">Buddha</th>
                <th style="width: 10; background-color: #b5b5b5b5">Konghucu</th>
                <th style="width: 10; background-color: #b5b5b5b5">Dan Lain-lain</th>
              </tr>
            </thead>
            <tbody>
              @php
                $totals = [
                    'employees' => 0,
                    'islam' => 0,
                    'kristen' => 0,
                    'katolik' => 0,
                    'hindu' => 0,
                    'buddha' => 0,
                    'konghucu' => 0,
                    'dll' => 0,
                ];

                $groupedDirectorates = $directorates->groupBy('is_non')->sortKeys();
              @endphp

              @forelse ($groupedDirectorates as $isNon => $directoratesGroup)
                <tr>
                  <td colspan="9" class="text-bold-500 text-center"
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
                      $counts = countByReligionOffice($division->positions);
                    @endphp

                    <tr>
                      <td class="pl-4">{{ $division->name }}</td>
                      <td>{{ $counts['total'] }}</td>
                      <td>{{ $counts['islam'] }}</td>
                      <td>{{ $counts['kristen'] }}</td>
                      <td>{{ $counts['katolik'] }}</td>
                      <td>{{ $counts['hindu'] }}</td>
                      <td>{{ $counts['buddha'] }}</td>
                      <td>{{ $counts['konghucu'] }}</td>
                      <td>{{ $counts['dll'] }}</td>
                    </tr>

                    @php
                      $totals['employees'] += $counts['total'];
                      $totals['islam'] += $counts['islam'];
                      $totals['kristen'] += $counts['kristen'];
                      $totals['katolik'] += $counts['katolik'];
                      $totals['hindu'] += $counts['hindu'];
                      $totals['buddha'] += $counts['buddha'];
                      $totals['konghucu'] += $counts['konghucu'];
                      $totals['dll'] += $counts['dll'];
                    @endphp
                  @endforeach
                @endforeach
              @empty
                <tr>
                  <td colspan="7" class="text-center">No data available in table</td>
                </tr>
              @endforelse

              <tr class="table-primary font-weight-bold">
                <td class="text-center">TOTAL</td>
                <td>{{ $totals['employees'] }}</td>
                <td>{{ $totals['islam'] }}</td>
                <td>{{ $totals['kristen'] }}</td>
                <td>{{ $totals['katolik'] }}</td>
                <td>{{ $totals['hindu'] }}</td>
                <td>{{ $totals['buddha'] }}</td>
                <td>{{ $totals['konghucu'] }}</td>
                <td>{{ $totals['dll'] }}</td>
              </tr>
            </tbody>
          </table>
        </div>

        @php
          function countByReligionNonOffice($positions)
          {
              $counts = [
                  'total' => 0,
                  'islam' => 0,
                  'kristen' => 0,
                  'katolik' => 0,
                  'hindu' => 0,
                  'buddha' => 0,
                  'konghucu' => 0,
                  'dll' => 0,
              ];

              foreach ($positions as $position) {
                  $employee = $position->employee;
                  if (
                      $employee &&
                      $employee->employee_status === 'AKTIF' &&
                      $employee->employeeCategory->name === 'NON-OFFICE'
                  ) {
                      $religion = $employee->religion;

                      $counts['total']++;
                      $counts[strtolower($religion) ?? 'dll']++;
                  }
              }

              return $counts;
          }
        @endphp

        <div class="col-md-12">
          <h3>NON-OFFICE</h3>
          <table class="table table-sm table-bordered table-striped" style="font-size: 80%">
            <thead class="thead-light">
              <tr>
                <th style="width: 50; background-color: #b5b5b5b5">Unit Kerja</th>
                <th style="width: 20; background-color: #b5b5b5b5">Total Karyawan</th>
                <th style="width: 10; background-color: #b5b5b5b5">Islam</th>
                <th style="width: 10; background-color: #b5b5b5b5">Kristen</th>
                <th style="width: 10; background-color: #b5b5b5b5">Katolik</th>
                <th style="width: 10; background-color: #b5b5b5b5">Hindu</th>
                <th style="width: 10; background-color: #b5b5b5b5">Buddha</th>
                <th style="width: 10; background-color: #b5b5b5b5">Konghucu</th>
                <th style="width: 10; background-color: #b5b5b5b5">Dan Lain-lain</th>
              </tr>
            </thead>
            <tbody>
              @php
                $totals = [
                    'employees' => 0,
                    'islam' => 0,
                    'kristen' => 0,
                    'katolik' => 0,
                    'hindu' => 0,
                    'buddha' => 0,
                    'konghucu' => 0,
                    'dll' => 0,
                ];

                $groupedDirectorates = $directorates->groupBy('is_non')->sortKeys();
              @endphp

              @forelse ($groupedDirectorates as $isNon => $directoratesGroup)
                <tr>
                  <td colspan="9" class="text-bold-500 text-center"
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
                      $counts = countByReligionNonOffice($division->positions);
                    @endphp

                    <tr>
                      <td class="pl-4">{{ $division->name }}</td>
                      <td>{{ $counts['total'] }}</td>
                      <td>{{ $counts['islam'] }}</td>
                      <td>{{ $counts['kristen'] }}</td>
                      <td>{{ $counts['katolik'] }}</td>
                      <td>{{ $counts['hindu'] }}</td>
                      <td>{{ $counts['buddha'] }}</td>
                      <td>{{ $counts['konghucu'] }}</td>
                      <td>{{ $counts['dll'] }}</td>
                    </tr>

                    @php
                      $totals['employees'] += $counts['total'];
                      $totals['islam'] += $counts['islam'];
                      $totals['kristen'] += $counts['kristen'];
                      $totals['katolik'] += $counts['katolik'];
                      $totals['hindu'] += $counts['hindu'];
                      $totals['buddha'] += $counts['buddha'];
                      $totals['konghucu'] += $counts['konghucu'];
                      $totals['dll'] += $counts['dll'];
                    @endphp
                  @endforeach
                @endforeach
              @empty
                <tr>
                  <td colspan="7" class="text-center">No data available in table</td>
                </tr>
              @endforelse

              <tr class="table-primary font-weight-bold">
                <td class="text-center">TOTAL</td>
                <td>{{ $totals['employees'] }}</td>
                <td>{{ $totals['islam'] }}</td>
                <td>{{ $totals['kristen'] }}</td>
                <td>{{ $totals['katolik'] }}</td>
                <td>{{ $totals['hindu'] }}</td>
                <td>{{ $totals['buddha'] }}</td>
                <td>{{ $totals['konghucu'] }}</td>
                <td>{{ $totals['dll'] }}</td>
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
                <th style="width: 10; background-color: #b5b5b5b5">Islam</th>
                <th style="width: 10; background-color: #b5b5b5b5">Kristen</th>
                <th style="width: 10; background-color: #b5b5b5b5">Katolik</th>
                <th style="width: 10; background-color: #b5b5b5b5">Hindu</th>
                <th style="width: 10; background-color: #b5b5b5b5">Buddha</th>
                <th style="width: 10; background-color: #b5b5b5b5">Konghucu</th>
                <th style="width: 10; background-color: #b5b5b5b5">Dan Lain-lain</th>
              </tr>
            </thead>
            <tbody>
              @php
                $totals = [
                    'employees' => 0,
                    'islam' => 0,
                    'kristen' => 0,
                    'katolik' => 0,
                    'hindu' => 0,
                    'buddha' => 0,
                    'konghucu' => 0,
                    'dll' => 0,
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
                          'employees' => 0,
                          'islam' => 0,
                          'kristen' => 0,
                          'katolik' => 0,
                          'hindu' => 0,
                          'buddha' => 0,
                          'konghucu' => 0,
                          'dll' => 0,
                      ];

                      foreach ($division->positions as $position) {
                          $employee = $position->employee;
                          if (
                              $employee &&
                              $employee->employee_status === 'AKTIF' &&
                              $employee->employeeCategory->name === 'OFFICE'
                          ) {
                              $religion = $employee->religion;

                              $counts['total']++;
                              $totals['employees']++;

                              if ($religion == 'Islam') {
                                  $counts['islam']++;
                              } elseif ($religion == 'Kristen') {
                                  $counts['kristen']++;
                              } elseif ($religion == 'Katolik') {
                                  $counts['katolik']++;
                              } elseif ($religion == 'Hindu') {
                                  $counts['hindu']++;
                              } elseif ($religion == 'Buddha') {
                                  $counts['buddha']++;
                              } elseif ($religion == 'Konghucu') {
                                  $counts['konghucu']++;
                              } elseif ($religion == 'Dan Lain-lain') {
                                  $counts['dll']++;
                              }

                              $totals['islam'] += $religion == 'Islam' ? 1 : 0;
                              $totals['kristen'] += $religion == 'Kristen' ? 1 : 0;
                              $totals['katolik'] += $religion == 'Katolik' ? 1 : 0;
                              $totals['hindu'] += $religion == 'Hindu' ? 1 : 0;
                              $totals['buddha'] += $religion == 'Buddha' ? 1 : 0;
                              $totals['konghucu'] += $religion == 'Konghucu' ? 1 : 0;
                              $totals['dll'] += $religion == 'Dan Lain-lain' ? 1 : 0;
                          }
                      }
                    @endphp

                    <tr>
                      <td class="pl-4">{{ $division->name }}</td>
                      <td>{{ $counts['total'] }}</td>
                      <td>{{ $counts['islam'] }}</td>
                      <td>{{ $counts['kristen'] }}</td>
                      <td>{{ $counts['katolik'] }}</td>
                      <td>{{ $counts['hindu'] }}</td>
                      <td>{{ $counts['buddha'] }}</td>
                      <td>{{ $counts['konghucu'] }}</td>
                      <td>{{ $counts['dll'] }}</td>
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
                <td>{{ $totals['islam'] }}</td>
                <td>{{ $totals['kristen'] }}</td>
                <td>{{ $totals['katolik'] }}</td>
                <td>{{ $totals['hindu'] }}</td>
                <td>{{ $totals['buddha'] }}</td>
                <td>{{ $totals['konghucu'] }}</td>
                <td>{{ $totals['dll'] }}</td>
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
                <th style="width: 10; background-color: #b5b5b5b5">Islam</th>
                <th style="width: 10; background-color: #b5b5b5b5">Kristen</th>
                <th style="width: 10; background-color: #b5b5b5b5">Katolik</th>
                <th style="width: 10; background-color: #b5b5b5b5">Hindu</th>
                <th style="width: 10; background-color: #b5b5b5b5">Buddha</th>
                <th style="width: 10; background-color: #b5b5b5b5">Konghucu</th>
                <th style="width: 10; background-color: #b5b5b5b5">Dan Lain-lain</th>
              </tr>
            </thead>
            <tbody>
              @php
                $totals = [
                    'employees' => 0,
                    'islam' => 0,
                    'kristen' => 0,
                    'katolik' => 0,
                    'hindu' => 0,
                    'buddha' => 0,
                    'konghucu' => 0,
                    'dll' => 0,
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
                          'employees' => 0,
                          'islam' => 0,
                          'kristen' => 0,
                          'katolik' => 0,
                          'hindu' => 0,
                          'buddha' => 0,
                          'konghucu' => 0,
                          'dll' => 0,
                      ];

                      foreach ($division->positions as $position) {
                          $employee = $position->employee;
                          if (
                              $employee &&
                              $employee->employee_status === 'AKTIF' &&
                              $employee->employeeCategory->name === 'NON-OFFICE'
                          ) {
                              $religion = $employee->religion;

                              $counts['total']++;
                              $totals['employees']++;

                              if ($religion == 'Islam') {
                                  $counts['islam']++;
                              } elseif ($religion == 'Kristen') {
                                  $counts['kristen']++;
                              } elseif ($religion == 'Katolik') {
                                  $counts['katolik']++;
                              } elseif ($religion == 'Hindu') {
                                  $counts['hindu']++;
                              } elseif ($religion == 'Buddha') {
                                  $counts['buddha']++;
                              } elseif ($religion == 'Konghucu') {
                                  $counts['konghucu']++;
                              } elseif ($religion == 'Dan Lain-lain') {
                                  $counts['dll']++;
                              }

                              $totals['islam'] += $religion == 'Islam' ? 1 : 0;
                              $totals['kristen'] += $religion == 'Kristen' ? 1 : 0;
                              $totals['katolik'] += $religion == 'Katolik' ? 1 : 0;
                              $totals['hindu'] += $religion == 'Hindu' ? 1 : 0;
                              $totals['buddha'] += $religion == 'Buddha' ? 1 : 0;
                              $totals['konghucu'] += $religion == 'Konghucu' ? 1 : 0;
                              $totals['dll'] += $religion == 'Dan Lain-lain' ? 1 : 0;
                          }
                      }
                    @endphp

                    <tr>
                      <td class="pl-4">{{ $division->name }}</td>
                      <td>{{ $counts['total'] }}</td>
                      <td>{{ $counts['islam'] }}</td>
                      <td>{{ $counts['kristen'] }}</td>
                      <td>{{ $counts['katolik'] }}</td>
                      <td>{{ $counts['hindu'] }}</td>
                      <td>{{ $counts['buddha'] }}</td>
                      <td>{{ $counts['konghucu'] }}</td>
                      <td>{{ $counts['dll'] }}</td>
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
                <td>{{ $totals['islam'] }}</td>
                <td>{{ $totals['kristen'] }}</td>
                <td>{{ $totals['katolik'] }}</td>
                <td>{{ $totals['hindu'] }}</td>
                <td>{{ $totals['buddha'] }}</td>
                <td>{{ $totals['konghucu'] }}</td>
                <td>{{ $totals['dll'] }}</td>
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
              <th style="background-color: #b5b5b5b5">Agama</th>
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
                                  'religion' => $employee->religion,
                              ];
                          }
                      }
                  }
              }

              // Sort the employees array by gender (assuming you want 'LAKI-LAKI' first)
              usort($employees, function ($a, $b) {
                  return $a['religion'] <=> $b['religion'];
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
                <td>{{ $employee['religion'] }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
