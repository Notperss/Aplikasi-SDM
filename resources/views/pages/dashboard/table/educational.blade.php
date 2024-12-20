<div class="col-12">
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="d-flex justify-content-between align-items-center">
          <h4 class="card-title">Pendidikan</h4>
          <a href="{{ url('/export-educational') }}" class="btn btn-sm btn-success">Export</a>
        </div>

        <div class="col-md-12">
          <table class="table table-sm table-bordered" style="font-size: 80%">
            <thead>
              <tr>
                <th style="width: 25%">Unit Kerja</th>
                <th style="width: 5%">SD</th>
                <th style="width: 5%">SMP</th>
                <th style="width: 5%">SMA</th>
                <th style="width: 5%">MA</th>
                <th style="width: 5%">MTS</th>
                <th style="width: 5%">SMK</th>
                <th style="width: 5%">D-1</th>
                <th style="width: 5%">D-2</th>
                <th style="width: 5%">D-3</th>
                <th style="width: 5%">D-4</th>
                <th style="width: 5%">S-1</th>
                <th style="width: 5%">S-2</th>
                <th style="width: 5%">S-3</th>
              </tr>
            </thead>
            <tbody>
              @php
                // $groupedDirectorates = $directorates->groupBy('is_non');
                $groupedDirectorates = $directorates->groupBy('is_non')->sortKeysUsing(function ($key1, $key2) {
                    $order = [1, 2]; // Define the desired order for is_non
                    $index1 = array_search($key1, $order) !== false ? array_search($key1, $order) : count($order);
                    $index2 = array_search($key2, $order) !== false ? array_search($key2, $order) : count($order);
                    return $index1 <=> $index2;
                });

                $grandTotals = [
                    'SD' => 0,
                    'SMP' => 0,
                    'SMA' => 0,
                    'MA' => 0,
                    'MTS' => 0,
                    'SMK' => 0,
                    'D-1' => 0,
                    'D-2' => 0,
                    'D-3' => 0,
                    'D-4' => 0,
                    'S-1' => 0,
                    'S-2' => 0,
                    'S-3' => 0,
                ];
              @endphp

              @forelse ($groupedDirectorates as $isNon => $directoratesGroup)
                <tr>
                  <td colspan="14" class="text-bold-500 text-center">
                    {{ $isNon == 1 ? 'DIREKTORAT' : ($isNon == 2 ? 'NON-DIREKTORAT' : 'LAIN-LAIN') }}
                  </td>
                </tr>
                @foreach ($directoratesGroup as $directorate)
                  @php
                    $educationCounts = [
                        'SD' => 0,
                        'SMP' => 0,
                        'SMA' => 0,
                        'MA' => 0,
                        'MTS' => 0,
                        'SMK' => 0,
                        'D-1' => 0,
                        'D-2' => 0,
                        'D-3' => 0,
                        'D-4' => 0,
                        'S-1' => 0,
                        'S-2' => 0,
                        'S-3' => 0,
                    ];

                    foreach ($directorate->divisions as $division) {
                        foreach ($division->positions as $position) {
                            if ($position->employee && $position->employee->employee_status === 'AKTIF') {
                                $education = $position->employee->last_educational ?? null;
                                if (isset($educationCounts[$education])) {
                                    $educationCounts[$education]++;
                                    $grandTotals[$education]++;
                                }
                            }
                        }
                    }
                  @endphp
                  <tr>
                    <td class="text-bold-500">{{ $directorate->name }}</td>
                    <td>{{ $educationCounts['SD'] }}</td>
                    <td>{{ $educationCounts['SMP'] }}</td>
                    <td>{{ $educationCounts['SMA'] }}</td>
                    <td>{{ $educationCounts['MA'] }}</td>
                    <td>{{ $educationCounts['MTS'] }}</td>
                    <td>{{ $educationCounts['SMK'] }}</td>
                    <td>{{ $educationCounts['D-1'] }}</td>
                    <td>{{ $educationCounts['D-2'] }}</td>
                    <td>{{ $educationCounts['D-3'] }}</td>
                    <td>{{ $educationCounts['D-4'] }}</td>
                    <td>{{ $educationCounts['S-1'] }}</td>
                    <td>{{ $educationCounts['S-2'] }}</td>
                    <td>{{ $educationCounts['S-3'] }}</td>
                  </tr>
                @endforeach
              @empty
                <tr>
                  <td class="text-bold-500 text-center" colspan="13">No data available in table</td>
                </tr>
              @endforelse

              <tr>
                <td class="text-bold-500 text-center">Total</td>
                <td>{{ $grandTotals['SD'] }}</td>
                <td>{{ $grandTotals['SMP'] }}</td>
                <td>{{ $grandTotals['SMA'] }}</td>
                <td>{{ $grandTotals['MA'] }}</td>
                <td>{{ $grandTotals['MTS'] }}</td>
                <td>{{ $grandTotals['SMK'] }}</td>
                <td>{{ $grandTotals['D-1'] }}</td>
                <td>{{ $grandTotals['D-2'] }}</td>
                <td>{{ $grandTotals['D-3'] }}</td>
                <td>{{ $grandTotals['D-4'] }}</td>
                <td>{{ $grandTotals['S-1'] }}</td>
                <td>{{ $grandTotals['S-2'] }}</td>
                <td>{{ $grandTotals['S-3'] }}</td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="col-md-12">
          <h3>OFFICE</h3>
          <table class="table table-sm table-bordered" style="font-size: 80%">
            <thead>
              <tr>
                <th style="width: 25%">Unit Kerja</th>
                <th style="width: 5%">SD</th>
                <th style="width: 5%">SMP</th>
                <th style="width: 5%">SMA</th>
                <th style="width: 5%">MA</th>
                <th style="width: 5%">MTS</th>
                <th style="width: 5%">SMK</th>
                <th style="width: 5%">D-1</th>
                <th style="width: 5%">D-2</th>
                <th style="width: 5%">D-3</th>
                <th style="width: 5%">D-4</th>
                <th style="width: 5%">S-1</th>
                <th style="width: 5%">S-2</th>
                <th style="width: 5%">S-3</th>
              </tr>
            </thead>
            <tbody>
              @php
                // $groupedDirectorates = $directorates->groupBy('is_non');

                $groupedDirectorates = $directorates->groupBy('is_non')->sortKeysUsing(function ($key1, $key2) {
                    $order = [1, 2]; // Define the desired order for is_non
                    $index1 = array_search($key1, $order) !== false ? array_search($key1, $order) : count($order);
                    $index2 = array_search($key2, $order) !== false ? array_search($key2, $order) : count($order);
                    return $index1 <=> $index2;
                });
                $grandTotals = [
                    'SD' => 0,
                    'SMP' => 0,
                    'SMA' => 0,
                    'MA' => 0,
                    'MTS' => 0,
                    'SMK' => 0,
                    'D-1' => 0,
                    'D-2' => 0,
                    'D-3' => 0,
                    'D-4' => 0,
                    'S-1' => 0,
                    'S-2' => 0,
                    'S-3' => 0,
                ];
              @endphp

              @forelse ($groupedDirectorates as $isNon => $directoratesGroup)
                <tr>
                  <td colspan="14" class="text-bold-500 text-center">
                    {{ $isNon == 1 ? 'DIREKTORAT' : ($isNon == 2 ? 'NON-DIREKTORAT' : 'LAIN-LAIN') }}
                  </td>
                </tr>
                @foreach ($directoratesGroup as $directorate)
                  @php
                    $educationCounts = [
                        'SD' => 0,
                        'SMP' => 0,
                        'SMA' => 0,
                        'MA' => 0,
                        'MTS' => 0,
                        'SMK' => 0,
                        'D-1' => 0,
                        'D-2' => 0,
                        'D-3' => 0,
                        'D-4' => 0,
                        'S-1' => 0,
                        'S-2' => 0,
                        'S-3' => 0,
                    ];

                    foreach ($directorate->divisions as $division) {
                        foreach ($division->positions as $position) {
                            if (
                                $position->employee &&
                                $position->employee->employee_status === 'AKTIF' &&
                                $position->employee->employeeCategory->name === 'OFFICE'
                            ) {
                                $education = $position->employee->last_educational ?? null;
                                if (isset($educationCounts[$education])) {
                                    $educationCounts[$education]++;
                                    $grandTotals[$education]++;
                                }
                            }
                        }
                    }
                  @endphp
                  <tr>
                    <td class="text-bold-500">{{ $directorate->name }}</td>
                    <td>{{ $educationCounts['SD'] }}</td>
                    <td>{{ $educationCounts['SMP'] }}</td>
                    <td>{{ $educationCounts['SMA'] }}</td>
                    <td>{{ $educationCounts['MA'] }}</td>
                    <td>{{ $educationCounts['MTS'] }}</td>
                    <td>{{ $educationCounts['SMK'] }}</td>
                    <td>{{ $educationCounts['D-1'] }}</td>
                    <td>{{ $educationCounts['D-2'] }}</td>
                    <td>{{ $educationCounts['D-3'] }}</td>
                    <td>{{ $educationCounts['D-4'] }}</td>
                    <td>{{ $educationCounts['S-1'] }}</td>
                    <td>{{ $educationCounts['S-2'] }}</td>
                    <td>{{ $educationCounts['S-3'] }}</td>
                  </tr>
                @endforeach
              @empty
                <tr>
                  <td class="text-bold-500 text-center" colspan="13">No data available in table</td>
                </tr>
              @endforelse

              <tr>
                <td class="text-bold-500 text-center">Total</td>
                <td>{{ $grandTotals['SD'] }}</td>
                <td>{{ $grandTotals['SMP'] }}</td>
                <td>{{ $grandTotals['SMA'] }}</td>
                <td>{{ $grandTotals['MA'] }}</td>
                <td>{{ $grandTotals['MTS'] }}</td>
                <td>{{ $grandTotals['SMK'] }}</td>
                <td>{{ $grandTotals['D-1'] }}</td>
                <td>{{ $grandTotals['D-2'] }}</td>
                <td>{{ $grandTotals['D-3'] }}</td>
                <td>{{ $grandTotals['D-4'] }}</td>
                <td>{{ $grandTotals['S-1'] }}</td>
                <td>{{ $grandTotals['S-2'] }}</td>
                <td>{{ $grandTotals['S-3'] }}</td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="col-md-12">
          <h3>NON-OFFICE</h3>
          <table class="table table-sm table-bordered" style="font-size: 80%">
            <thead>
              <tr>
                <th style="width: 25%">Unit Kerja</th>
                <th style="width: 5%">SD</th>
                <th style="width: 5%">SMP</th>
                <th style="width: 5%">SMA</th>
                <th style="width: 5%">MA</th>
                <th style="width: 5%">MTS</th>
                <th style="width: 5%">SMK</th>
                <th style="width: 5%">D-1</th>
                <th style="width: 5%">D-2</th>
                <th style="width: 5%">D-3</th>
                <th style="width: 5%">D-4</th>
                <th style="width: 5%">S-1</th>
                <th style="width: 5%">S-2</th>
                <th style="width: 5%">S-3</th>
              </tr>
            </thead>
            <tbody>
              @php
                // $groupedDirectorates = $directorates->groupBy('is_non');

                $groupedDirectorates = $directorates->groupBy('is_non')->sortKeysUsing(function ($key1, $key2) {
                    $order = [1, 2]; // Define the desired order for is_non
                    $index1 = array_search($key1, $order) !== false ? array_search($key1, $order) : count($order);
                    $index2 = array_search($key2, $order) !== false ? array_search($key2, $order) : count($order);
                    return $index1 <=> $index2;
                });
                $grandTotals = [
                    'SD' => 0,
                    'SMP' => 0,
                    'SMA' => 0,
                    'MA' => 0,
                    'MTS' => 0,
                    'SMK' => 0,
                    'D-1' => 0,
                    'D-2' => 0,
                    'D-3' => 0,
                    'D-4' => 0,
                    'S-1' => 0,
                    'S-2' => 0,
                    'S-3' => 0,
                ];
              @endphp

              @forelse ($groupedDirectorates as $isNon => $directoratesGroup)
                <tr>
                  <td colspan="14" class="text-bold-500 text-center">
                    {{ $isNon == 1 ? 'DIREKTORAT' : ($isNon == 2 ? 'NON-DIREKTORAT' : 'LAIN-LAIN') }}
                  </td>
                </tr>
                @foreach ($directoratesGroup as $directorate)
                  @php
                    $educationCounts = [
                        'SD' => 0,
                        'SMP' => 0,
                        'SMA' => 0,
                        'MA' => 0,
                        'MTS' => 0,
                        'SMK' => 0,
                        'D-1' => 0,
                        'D-2' => 0,
                        'D-3' => 0,
                        'D-4' => 0,
                        'S-1' => 0,
                        'S-2' => 0,
                        'S-3' => 0,
                    ];

                    foreach ($directorate->divisions as $division) {
                        foreach ($division->positions as $position) {
                            if (
                                $position->employee &&
                                $position->employee->employee_status === 'AKTIF' &&
                                $position->employee->employeeCategory->name === 'NON-OFFICE'
                            ) {
                                $education = $position->employee->last_educational ?? null;
                                if (isset($educationCounts[$education])) {
                                    $educationCounts[$education]++;
                                    $grandTotals[$education]++;
                                }
                            }
                        }
                    }
                  @endphp
                  <tr>
                    <td class="text-bold-500">{{ $directorate->name }}</td>
                    <td>{{ $educationCounts['SD'] }}</td>
                    <td>{{ $educationCounts['SMP'] }}</td>
                    <td>{{ $educationCounts['SMA'] }}</td>
                    <td>{{ $educationCounts['MA'] }}</td>
                    <td>{{ $educationCounts['MTS'] }}</td>
                    <td>{{ $educationCounts['SMK'] }}</td>
                    <td>{{ $educationCounts['D-1'] }}</td>
                    <td>{{ $educationCounts['D-2'] }}</td>
                    <td>{{ $educationCounts['D-3'] }}</td>
                    <td>{{ $educationCounts['D-4'] }}</td>
                    <td>{{ $educationCounts['S-1'] }}</td>
                    <td>{{ $educationCounts['S-2'] }}</td>
                    <td>{{ $educationCounts['S-3'] }}</td>
                  </tr>
                @endforeach
              @empty
                <tr>
                  <td class="text-bold-500 text-center" colspan="13">No data available in table</td>
                </tr>
              @endforelse

              <tr>
                <td class="text-bold-500 text-center">Total</td>
                <td>{{ $grandTotals['SD'] }}</td>
                <td>{{ $grandTotals['SMP'] }}</td>
                <td>{{ $grandTotals['SMA'] }}</td>
                <td>{{ $grandTotals['MA'] }}</td>
                <td>{{ $grandTotals['MTS'] }}</td>
                <td>{{ $grandTotals['SMK'] }}</td>
                <td>{{ $grandTotals['D-1'] }}</td>
                <td>{{ $grandTotals['D-2'] }}</td>
                <td>{{ $grandTotals['D-3'] }}</td>
                <td>{{ $grandTotals['D-4'] }}</td>
                <td>{{ $grandTotals['S-1'] }}</td>
                <td>{{ $grandTotals['S-2'] }}</td>
                <td>{{ $grandTotals['S-3'] }}</td>
              </tr>
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>
</div>
