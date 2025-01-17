<div class="col-12">
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="d-flex justify-content-between align-items-center">
          <h4 class="card-title">Usia Karyawan</h4>
          <a href="{{ url('/export-religions') }}" class="btn btn-sm btn-success">Export</a>
        </div>

        <div class="col-md-12">
          <table class="table table-sm table-bordered" style="font-size: 80%">
            <thead>
              <tr>
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
                use Carbon\Carbon;

                $totalEmployees = 0;
                $totalIslam = 0;
                $totalKristen = 0;
                $totalKatolik = 0;
                $totalHindu = 0;
                $totalBuddha = 0;
                $totalKonghucu = 0;
                $totalDLL = 0;

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
                  <td colspan="9" class="text-bold-500 text-center">
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

                    $islam = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->religion == 'Islam'
                                ? 1
                                : 0,
                        ),
                    );
                    $kristen = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->religion == 'Kristen'
                                ? 1
                                : 0,
                        ),
                    );
                    $katolik = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->religion == 'Katolik'
                                ? 1
                                : 0,
                        ),
                    );
                    $hindu = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->religion == 'Hindu'
                                ? 1
                                : 0,
                        ),
                    );
                    $buddha = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->religion == 'Buddha'
                                ? 1
                                : 0,
                        ),
                    );
                    $konghucu = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->religion == 'Konghucu'
                                ? 1
                                : 0,
                        ),
                    );
                    $dll = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->religion == 'Dan Lain-lain'
                                ? 1
                                : 0,
                        ),
                    );

                    // Add to totals
                    $totalEmployees += $totalCount;
                    $totalIslam += $islam;
                    $totalKristen += $kristen;
                    $totalKatolik += $katolik;
                    $totalHindu += $hindu;
                    $totalBuddha += $buddha;
                    $totalKonghucu += $konghucu;
                    $totalDLL += $dll;
                  @endphp

                  <tr>
                    <td class="text-bold-500">{{ $directorate->name }}</td>
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
              @empty
                <tr>
                  <td class="text-bold-500 text-center" colspan="9">No data available in table</td>
                </tr>
              @endforelse

              <!-- Totals Row -->
              <tr class="table-primary">
                <td class="text-bold-500 text-center">TOTAL</td>
                <td class="text-center">{{ $totalEmployees }}</td>
                <td class="text-center">{{ $totalIslam }}</td>
                <td class="text-center">{{ $totalKristen }}</td>
                <td class="text-center">{{ $totalKatolik }}</td>
                <td class="text-center">{{ $totalHindu }}</td>
                <td class="text-center">{{ $totalBuddha }}</td>
                <td class="text-center">{{ $totalKonghucu }}</td>
                <td class="text-center">{{ $totalDLL }}</td>
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
                $totalEmployees = 0;
                $totalIslam = 0;
                $totalKristen = 0;
                $totalKatolik = 0;
                $totalHindu = 0;
                $totalBuddha = 0;
                $totalKonghucu = 0;
                $totalDLL = 0;

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
                  <td colspan="9" class="text-bold-500 text-center">
                    {{ $isNon == 1 ? 'DIREKTORAT' : ($isNon == 2 ? 'NON-DIREKTORAT' : 'LAIN-LAIN') }}
                  </td>
                </tr>

                @foreach ($directoratesGroup as $directorate)
                  @php
                    $totalCount = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->employeeCategory->name === 'OFFICE'
                                ? 1
                                : 0,
                        ),
                    );

                    $islam = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->employeeCategory->name === 'OFFICE' &&
                            $position->employee->religion == 'Islam'
                                ? 1
                                : 0,
                        ),
                    );
                    $kristen = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->employeeCategory->name === 'OFFICE' &&
                            $position->employee->religion == 'Kristen'
                                ? 1
                                : 0,
                        ),
                    );
                    $katolik = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->employeeCategory->name === 'OFFICE' &&
                            $position->employee->religion == 'Katolik'
                                ? 1
                                : 0,
                        ),
                    );
                    $hindu = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->employeeCategory->name === 'OFFICE' &&
                            $position->employee->religion == 'Hindu'
                                ? 1
                                : 0,
                        ),
                    );
                    $buddha = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->employeeCategory->name === 'OFFICE' &&
                            $position->employee->religion == 'Buddha'
                                ? 1
                                : 0,
                        ),
                    );
                    $konghucu = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->employeeCategory->name === 'OFFICE' &&
                            $position->employee->religion == 'Konghucu'
                                ? 1
                                : 0,
                        ),
                    );
                    $dll = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->employeeCategory->name === 'OFFICE' &&
                            $position->employee->religion == 'Dan Lain-lain'
                                ? 1
                                : 0,
                        ),
                    );

                    // Add to totals
                    $totalEmployees += $totalCount;
                    $totalIslam += $islam;
                    $totalKristen += $kristen;
                    $totalKatolik += $katolik;
                    $totalHindu += $hindu;
                    $totalBuddha += $buddha;
                    $totalKonghucu += $konghucu;
                    $totalDLL += $dll;
                  @endphp

                  <tr>
                    <td class="text-bold-500">{{ $directorate->name }}</td>
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
              @empty
                <tr>
                  <td class="text-bold-500 text-center" colspan="9">No data available in table</td>
                </tr>
              @endforelse

              <!-- Totals Row -->
              <tr class="table-primary">
                <td class="text-bold-500 text-center">TOTAL</td>
                <td class="text-center">{{ $totalEmployees }}</td>
                <td class="text-center">{{ $totalIslam }}</td>
                <td class="text-center">{{ $totalKristen }}</td>
                <td class="text-center">{{ $totalKatolik }}</td>
                <td class="text-center">{{ $totalHindu }}</td>
                <td class="text-center">{{ $totalBuddha }}</td>
                <td class="text-center">{{ $totalKonghucu }}</td>
                <td class="text-center">{{ $totalDLL }}</td>
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
                $totalEmployees = 0;
                $totalIslam = 0;
                $totalKristen = 0;
                $totalKatolik = 0;
                $totalHindu = 0;
                $totalBuddha = 0;
                $totalKonghucu = 0;
                $totalDLL = 0;

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
                  <td colspan="9" class="text-bold-500 text-center">
                    {{ $isNon == 1 ? 'DIREKTORAT' : ($isNon == 2 ? 'NON-DIREKTORAT' : 'LAIN-LAIN') }}
                  </td>
                </tr>

                @foreach ($directoratesGroup as $directorate)
                  @php
                    $totalCount = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->employeeCategory->name === 'NON-OFFICE'
                                ? 1
                                : 0,
                        ),
                    );

                    $islam = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->employeeCategory->name === 'NON-OFFICE' &&
                            $position->employee->religion == 'Islam'
                                ? 1
                                : 0,
                        ),
                    );
                    $kristen = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->employeeCategory->name === 'NON-OFFICE' &&
                            $position->employee->religion == 'Kristen'
                                ? 1
                                : 0,
                        ),
                    );
                    $katolik = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->employeeCategory->name === 'NON-OFFICE' &&
                            $position->employee->religion == 'Katolik'
                                ? 1
                                : 0,
                        ),
                    );
                    $hindu = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->employeeCategory->name === 'NON-OFFICE' &&
                            $position->employee->religion == 'Hindu'
                                ? 1
                                : 0,
                        ),
                    );
                    $buddha = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->employeeCategory->name === 'NON-OFFICE' &&
                            $position->employee->religion == 'Buddha'
                                ? 1
                                : 0,
                        ),
                    );
                    $konghucu = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->employeeCategory->name === 'NON-OFFICE' &&
                            $position->employee->religion == 'Konghucu'
                                ? 1
                                : 0,
                        ),
                    );
                    $dll = $directorate->divisions->sum(
                        fn($division) => $division->positions->sum(
                            fn($position) => optional($position->employee)->employee_status === 'AKTIF' &&
                            $position->employee->employeeCategory->name === 'NON-OFFICE' &&
                            $position->employee->religion == 'Dan Lain-lain'
                                ? 1
                                : 0,
                        ),
                    );

                    // Add to totals
                    $totalEmployees += $totalCount;
                    $totalIslam += $islam;
                    $totalKristen += $kristen;
                    $totalKatolik += $katolik;
                    $totalHindu += $hindu;
                    $totalBuddha += $buddha;
                    $totalKonghucu += $konghucu;
                    $totalDLL += $dll;
                  @endphp

                  <tr>
                    <td class="text-bold-500">{{ $directorate->name }}</td>
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
              @empty
                <tr>
                  <td class="text-bold-500 text-center" colspan="9">No data available in table</td>
                </tr>
              @endforelse

              <!-- Totals Row -->
              <tr class="table-primary">
                <td class="text-bold-500 text-center">TOTAL</td>
                <td class="text-center">{{ $totalEmployees }}</td>
                <td class="text-center">{{ $totalIslam }}</td>
                <td class="text-center">{{ $totalKristen }}</td>
                <td class="text-center">{{ $totalKatolik }}</td>
                <td class="text-center">{{ $totalHindu }}</td>
                <td class="text-center">{{ $totalBuddha }}</td>
                <td class="text-center">{{ $totalKonghucu }}</td>
                <td class="text-center">{{ $totalDLL }}</td>
              </tr>
            </tbody>
          </table>
        </div>


      </div>
    </div>
  </div>
</div>
