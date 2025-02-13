        {{-- @php
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
                // use Carbon\Carbon;
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
        </div> --}}

        <table class="table table-sm table-bordered" style="font-size: 80%">
          <thead>
            <tr>
              <th style="width: 30">Unit Kerja</th>
              <th style="width: 30">Total Karyawan</th>
              <th style="width: 30">Islam</th>
              <th style="width: 30">Kristen</th>
              <th style="width: 30">Katolik</th>
              <th style="width: 30">Hindu</th>
              <th style="width: 30">Buddha</th>
              <th style="width: 30">Konghucu</th>
              <th style="width: 30">Dan Lain-Lain</th>
            </tr>
          </thead>
          <tbody>
            @php
              $totals = [
                  'employees' => 0,
                  'Islam' => 0,
                  'Kristen' => 0,
                  'Katolik' => 0,
                  'Hindu' => 0,
                  'Buddha' => 0,
                  'Konghucu' => 0,
                  'Dan Lain-lain' => 0,
              ];

              $groupedDirectorates = $directorates->groupBy('is_non')->sortKeys();
            @endphp

            @foreach ($groupedDirectorates as $isNon => $directoratesGroup)
              <tr>
                <td colspan="9" class="text-bold-500 text-center"
                  style="background-color:#928d8d; font-weight: bold; ">
                  {{ $isNon == 1 ? 'DIREKTORAT' : ($isNon == 2 ? 'NON-DIREKTORAT' : 'LAIN-LAIN') }}
                </td>
              </tr>

              @foreach ($directoratesGroup as $directorate)
                <tr class="table-secondary">
                  <td class="text-bold-500" style="background-color:#cbc6c6;">{{ $directorate->name }}</td>
                  <td colspan="8"></td>
                </tr>

                @foreach ($directorate->divisions as $division)
                  @php
                    $stats = collect(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu', 'Dan Lain-lain'])
                        ->mapWithKeys(
                            fn($religion) => [
                                $religion => $division->positions
                                    ->where('employee.employee_status', 'AKTIF')
                                    ->where('employee.religion', $religion)
                                    ->count(),
                            ],
                        )
                        ->toArray();

                    $totalEmployees = array_sum($stats);
                    $totals['employees'] += $totalEmployees;
                    foreach ($stats as $key => $value) {
                        $totals[$key] += $value;
                    }
                  @endphp

                  <tr>
                    <td class="pl-4">- {{ $division->name }}</td>
                    <td class="text-center">{{ $totalEmployees }}</td>
                    <td class="text-center">{{ $stats['Islam'] }}</td>
                    <td class="text-center">{{ $stats['Kristen'] }}</td>
                    <td class="text-center">{{ $stats['Katolik'] }}</td>
                    <td class="text-center">{{ $stats['Hindu'] }}</td>
                    <td class="text-center">{{ $stats['Buddha'] }}</td>
                    <td class="text-center">{{ $stats['Konghucu'] }}</td>
                    <td class="text-center">{{ $stats['Dan Lain-lain'] }}</td>
                  </tr>
                @endforeach
              @endforeach
            @endforeach

            <!-- Total Row -->
            <tr class="table-primary">
              <td class="text-bold-500 text-center">TOTAL</td>
              <td class="text-center">{{ $totals['employees'] }}</td>
              <td class="text-center">{{ $totals['Islam'] }}</td>
              <td class="text-center">{{ $totals['Kristen'] }}</td>
              <td class="text-center">{{ $totals['Katolik'] }}</td>
              <td class="text-center">{{ $totals['Hindu'] }}</td>
              <td class="text-center">{{ $totals['Buddha'] }}</td>
              <td class="text-center">{{ $totals['Konghucu'] }}</td>
              <td class="text-center">{{ $totals['Dan Lain-lain'] }}</td>
            </tr>
          </tbody>
        </table>


        @php
          $groupedCategories = $directorates
              ->flatMap(fn($d) => $d->divisions)
              ->flatMap(fn($div) => $div->positions)
              ->filter(fn($pos) => optional($pos->employee)->employee_status === 'AKTIF')
              ->groupBy(fn($pos) => optional($pos->employee->employeeCategory)->name);
        @endphp

        @foreach ($groupedCategories as $category => $positions)
          <div class="col-md-12">
            <h3>{{ strtoupper($category) }}</h3>
            <table class="table table-sm table-bordered" style="font-size: 80%">
              <thead>
                <tr>
                  <th class="text-center">Kategori Karyawan</th>
                  <th class="text-center">Unit Kerja</th>
                  <th class="text-center">Total Karyawan</th>
                  <th class="text-center">Islam</th>
                  <th class="text-center">Kristen</th>
                  <th class="text-center">Katolik</th>
                  <th class="text-center">Hindu</th>
                  <th class="text-center">Buddha</th>
                  <th class="text-center">Konghucu</th>
                  <th class="text-center">Dan Lain-Lain</th>
                </tr>
              </thead>
              <tbody>


                @php
                  $totalCategoryCount = 0;
                  $totalIslam = 0;
                  $totalKristen = 0;
                  $totalKatolik = 0;
                  $totalHindu = 0;
                  $totalBuddha = 0;
                  $totalKonghucu = 0;
                  $totalDll = 0;
                @endphp

                @foreach ($positions->groupBy(fn($pos) => optional($pos->division->directorate)->name) as $directorateName => $directoratePositions)
                  <tr class="table-info">
                    <td></td>
                    <td colspan="9" class="text-bold-500 text-center" style="background-color: #d6cece">
                      {{ strtoupper($directorateName) }}</td>
                  </tr>

                  @php
                    $totalDirectorateCount = 0;
                    $dirIslam = 0;
                    $dirKristen = 0;
                    $dirKatolik = 0;
                    $dirHindu = 0;
                    $dirBuddha = 0;
                    $dirKonghucu = 0;
                    $dirDll = 0;
                  @endphp

                  @foreach ($directoratePositions->groupBy(fn($pos) => optional($pos->division)->name) as $divisionName => $positions)
                    @php
                      $totalCount = $positions->count();
                      $islam = $positions->where(fn($pos) => $pos->employee->religion == 'Islam')->count();
                      $kristen = $positions->where(fn($pos) => $pos->employee->religion == 'Kristen')->count();
                      $katolik = $positions->where(fn($pos) => $pos->employee->religion == 'Katolik')->count();
                      $hindu = $positions->where(fn($pos) => $pos->employee->religion == 'Hindu')->count();
                      $buddha = $positions->where(fn($pos) => $pos->employee->religion == 'Buddha')->count();
                      $konghucu = $positions->where(fn($pos) => $pos->employee->religion == 'Konghucu')->count();
                      $dll = $positions->where(fn($pos) => $pos->employee->religion == 'Dan Lain-lain')->count();

                      // Akumulasi total per direktorat
                      $totalDirectorateCount += $totalCount;
                      $dirIslam += $islam;
                      $dirKristen += $kristen;
                      $dirKatolik += $katolik;
                      $dirHindu += $hindu;
                      $dirBuddha += $buddha;
                      $dirKonghucu += $konghucu;
                      $dirDll += $dll;

                      // Akumulasi total per kategori
                      $totalCategoryCount += $totalCount;
                      $totalIslam += $islam;
                      $totalKristen += $kristen;
                      $totalKatolik += $katolik;
                      $totalHindu += $hindu;
                      $totalBuddha += $buddha;
                      $totalKonghucu += $konghucu;
                      $totalDll += $dll;
                    @endphp

                    <tr>
                      <td></td>
                      <td class="text-bold-500">{{ $divisionName }}</td>
                      <td class="text-center">{{ $totalCount }}</td>
                      <td class="text-center">{{ $islam }}</td>
                      <td class="text-center">{{ $kristen }}</td>
                      <td class="text-center">{{ $katolik }}</td>
                      <td class="text-center">{{ $hindu }}</td>
                      <td class="text-center">{{ $buddha }}</td>
                      <td class="text-center">{{ $konghucu }}</td>
                      <td class="text-center">{{ $dll }}</td>
                    </tr>
                  @endforeach

                  <!-- Baris Total Per Direktorat -->
                  <tr class="table-warning">
                    <td></td>
                    <td class="text-bold-500 text-center" style="background-color: #928d8d">TOTAL
                      {{ strtoupper($directorateName) }}</td>
                    <td class="text-center text-bold-500">{{ $totalDirectorateCount }}</td>
                    <td class="text-center text-bold-500">{{ $dirIslam }}</td>
                    <td class="text-center text-bold-500">{{ $dirKristen }}</td>
                    <td class="text-center text-bold-500">{{ $dirKatolik }}</td>
                    <td class="text-center text-bold-500">{{ $dirHindu }}</td>
                    <td class="text-center text-bold-500">{{ $dirBuddha }}</td>
                    <td class="text-center text-bold-500">{{ $dirKonghucu }}</td>
                    <td class="text-center text-bold-500">{{ $dirDll }}</td>
                  </tr>
                @endforeach

                <!-- Baris Total Per Kategori -->
                <tr class="table-danger">
                  <td colspan="2" class="text-bold-500 text-center" style="background-color: #febdbd">TOTAL
                    {{ strtoupper($category) }}</td>
                  <td class="text-center text-bold-500">{{ $totalCategoryCount }}</td>
                  <td class="text-center text-bold-500">{{ $totalIslam }}</td>
                  <td class="text-center text-bold-500">{{ $totalKristen }}</td>
                  <td class="text-center text-bold-500">{{ $totalKatolik }}</td>
                  <td class="text-center text-bold-500">{{ $totalHindu }}</td>
                  <td class="text-center text-bold-500">{{ $totalBuddha }}</td>
                  <td class="text-center text-bold-500">{{ $totalKonghucu }}</td>
                  <td class="text-center text-bold-500">{{ $totalDll }}</td>
                </tr>

              </tbody>
            </table>
          </div>
        @endforeach


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
                                  'dob' => Carbon\Carbon::parse($employee->dob)->translatedFormat('d-m-Y'),
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
