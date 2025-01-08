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
                  < 20</th>
                <th>20-25</th>
                <th>25-35</th>
                <th>35-50</th>
                <th>> 50</th>
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
                  < 20</th>
                <th class="text-center">20-25</th>
                <th class="text-center">25-35</th>
                <th class="text-center">35-50</th>
                <th class="text-center">> 50</th>
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
                    <td class="text-center">{{ $totalCount }}</td>
                    <td class="text-center">{{ $below20 }}</td>
                    <td class="text-center">{{ $age2025 }}</td>
                    <td class="text-center">{{ $age2535 }}</td>
                    <td class="text-center">{{ $age3550 }}</td>
                    <td class="text-center">{{ $up50 }}</td>
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
                <td class="text-center">{{ $totalBelow20 }}</td>
                <td class="text-center">{{ $total2025 }}</td>
                <td class="text-center">{{ $total2535 }}</td>
                <td class="text-center">{{ $total3550 }}</td>
                <td class="text-center">{{ $totalAbove50 }}</td>
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
                  < 20</th>
                <th class="text-center">20-25</th>
                <th class="text-center">25-35</th>
                <th class="text-center">35-50</th>
                <th class="text-center">> 50</th>
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
                    <td class="text-center">{{ $totalCount }}</td>
                    <td class="text-center">{{ $below20 }}</td>
                    <td class="text-center">{{ $age2025 }}</td>
                    <td class="text-center">{{ $age2535 }}</td>
                    <td class="text-center">{{ $age3550 }}</td>
                    <td class="text-center">{{ $up50 }}</td>
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
                <td class="text-center">{{ $totalBelow20 }}</td>
                <td class="text-center">{{ $total2025 }}</td>
                <td class="text-center">{{ $total2535 }}</td>
                <td class="text-center">{{ $total3550 }}</td>
                <td class="text-center">{{ $totalAbove50 }}</td>
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
                  < 20</th>
                <th class="text-center">20-25</th>
                <th class="text-center">25-35</th>
                <th class="text-center">35-50</th>
                <th class="text-center">> 50</th>
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
                    <td class="text-center">{{ $totalCount }}</td>
                    <td class="text-center">{{ $below20 }}</td>
                    <td class="text-center">{{ $age2025 }}</td>
                    <td class="text-center">{{ $age2535 }}</td>
                    <td class="text-center">{{ $age3550 }}</td>
                    <td class="text-center">{{ $up50 }}</td>
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
                <td class="text-center">{{ $totalBelow20 }}</td>
                <td class="text-center">{{ $total2025 }}</td>
                <td class="text-center">{{ $total2535 }}</td>
                <td class="text-center">{{ $total3550 }}</td>
                <td class="text-center">{{ $totalAbove50 }}</td>
              </tr>
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>
</div>
