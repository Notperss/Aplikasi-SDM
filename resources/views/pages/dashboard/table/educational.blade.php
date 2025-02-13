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
                {{-- <th style="width: 5%">MA</th>
                <th style="width: 5%">MTS</th>
                <th style="width: 5%">SMK</th> --}}
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
                    // 'MA' => 0,
                    // 'MTS' => 0,
                    // 'SMK' => 0,
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
                        // 'MA' => 0,
                        // 'MTS' => 0,
                        // 'SMK' => 0,
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
                    {{-- <td>{{ $educationCounts['MA'] }}</td>
                    <td>{{ $educationCounts['MTS'] }}</td>
                    <td>{{ $educationCounts['SMK'] }}</td> --}}
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

              <tr class="table-primary">
                <td class="text-bold-500 text-center">Total</td>
                <td>{{ $grandTotals['SD'] }}</td>
                <td>{{ $grandTotals['SMP'] }}</td>
                <td>{{ $grandTotals['SMA'] }}</td>
                {{-- <td>{{ $grandTotals['MA'] }}</td>
                <td>{{ $grandTotals['MTS'] }}</td>
                <td>{{ $grandTotals['SMK'] }}</td> --}}
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

        @php
          // Ambil kategori karyawan unik
          $uniqueCategories = collect();
          foreach ($directorates as $directorate) {
              foreach ($directorate->divisions as $division) {
                  foreach ($division->positions as $position) {
                      $categoryName = optional($position->employee)->employeeCategory->name ?? null;
                      if ($categoryName) {
                          $uniqueCategories->push($categoryName);
                      }
                  }
              }
          }
          $uniqueCategories = $uniqueCategories->unique()->values();
        @endphp

        <div class="col-md-12">
          @foreach ($uniqueCategories as $category)
            <h4 class="text-center mt-4">{{ $category }}</h4>
            <table class="table table-sm table-bordered" style="font-size: 80%">
              <thead>
                <tr>
                  <th rowspan="2" style="width: 20%">Unit Kerja</th>
                  <th colspan="10" class="text-center">Pendidikan</th>
                </tr>
                <tr>
                  <th style="width: 5%">SD</th>
                  <th style="width: 5%">SMP</th>
                  <th style="width: 5%">SMA</th>
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
                  // Kelompokkan direktorat berdasarkan is_non
                  $groupedDirectorates = $directorates->groupBy('is_non')->sortKeysUsing(function ($key1, $key2) {
                      $order = [1, 2];
                      return array_search($key1, $order) <=> array_search($key2, $order);
                  });

                  // Inisialisasi total grand untuk kategori ini
                  $grandTotals = array_fill_keys(
                      ['SD', 'SMP', 'SMA', 'D-1', 'D-2', 'D-3', 'D-4', 'S-1', 'S-2', 'S-3'],
                      0,
                  );
                @endphp

                @forelse ($groupedDirectorates as $isNon => $directoratesGroup)
                  <tr>
                    <td colspan="11" class="text-bold-500 text-center">
                      {{ $isNon == 1 ? 'DIREKTORAT' : ($isNon == 2 ? 'NON-DIREKTORAT' : 'LAIN-LAIN') }}
                    </td>
                  </tr>

                  @foreach ($directoratesGroup as $directorate)
                    @php
                      // Inisialisasi jumlah pendidikan per kategori karyawan untuk direktorat ini
                      $educationCounts = array_fill_keys(
                          ['SD', 'SMP', 'SMA', 'D-1', 'D-2', 'D-3', 'D-4', 'S-1', 'S-2', 'S-3'],
                          0,
                      );

                      // Loop posisi untuk menghitung jumlah pendidikan berdasarkan kategori
                      foreach ($directorate->divisions as $division) {
                          foreach ($division->positions as $position) {
                              if ($position->employee && $position->employee->employee_status === 'AKTIF') {
                                  $empCategory = optional($position->employee->employeeCategory)->name ?? 'Unknown';
                                  $education = $position->employee->last_educational ?? null;

                                  if ($empCategory === $category && isset($educationCounts[$education])) {
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
                    <td class="text-bold-500 text-center" colspan="11">No data available in table</td>
                  </tr>
                @endforelse

                <tr class="table-primary">
                  <td class="text-bold-500 text-center">Total</td>
                  <td>{{ $grandTotals['SD'] }}</td>
                  <td>{{ $grandTotals['SMP'] }}</td>
                  <td>{{ $grandTotals['SMA'] }}</td>
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
          @endforeach
        </div>


        {{-- <div class="col-md-12">
          <table class="table table-sm table-bordered" style="font-size: 80%">
            <thead>
              <tr>
                <th style="width: 50%; text-align: center">Unit Kerja</th>
                <th style="width: 10%; text-align: center">Total Karyawan</th>
                @php
                  // Collect unique employee categories for the table header
                  $uniqueCategories = collect();
                  foreach ($directorates as $directorate) {
                      foreach ($directorate->divisions as $division) {
                          foreach ($division->positions as $position) {
                              $categoryName = optional($position->employee)->employeeCategory->name ?? null;
                              if ($categoryName) {
                                  $uniqueCategories->push($categoryName);
                              }
                          }
                      }
                  }
                  $uniqueCategories = $uniqueCategories->unique();
                @endphp

                @foreach ($uniqueCategories as $category)
                  <th>{{ $category }}</th>
                @endforeach
              </tr>
            </thead>
            <tbody>
            
              @forelse ($groupedDirectorates as $isNon => $directoratesGroup)
                <tr>
                  <td colspan="{{ 2 + $uniqueCategories->count() }}" class="text-bold-500 text-center">
                    {{ $isNon == 1 ? 'DIREKTORAT' : ($isNon == 2 ? 'NON-DIREKTORAT' : 'LAIN-LAIN') }}
                  </td>
                </tr>

                @php
                  $totalCounts = [];
                  foreach ($uniqueCategories as $category) {
                      $totalCounts[$category] = 0;
                  }
                @endphp

                @foreach ($directoratesGroup as $directorate)
                  @php
                    // Initialize counts for this directorate
                    $categoryCounts = [];
                    foreach ($uniqueCategories as $category) {
                        $categoryCounts[$category] = 0;
                    }

                    // Count employees per category
                    foreach ($directorate->divisions as $division) {
                        foreach ($division->positions as $position) {
                            $employee = $position->employee;
                            if ($employee && $employee->employee_status === 'AKTIF') {
                                $categoryName = optional($employee->employeeCategory)->name;
                                if ($categoryName && isset($categoryCounts[$categoryName])) {
                                    $categoryCounts[$categoryName]++;
                                    $totalCounts[$categoryName]++;
                                }
                            }
                        }
                    }
                  @endphp
                  <tr>
                    <td class="text-bold-500">{{ $directorate->name }}</td>
                    <td class="text-bold-500" style="text-align: center">{{ array_sum($categoryCounts) }}</td>
                    @foreach ($uniqueCategories as $category)
                      <td style="text-align: center">{{ $categoryCounts[$category] }}</td>
                    @endforeach
                  </tr>
                @endforeach

                <!-- Total Row -->
                <tr>
                  <td class="text-bold-500 text-center">Total :</td>
                  <td class="text-bold-500 text-center">{{ array_sum($totalCounts) }}</td>
                  @foreach ($uniqueCategories as $category)
                    <td class="text-bold-500 text-center">{{ $totalCounts[$category] }}</td>
                  @endforeach
                </tr>
              @empty
                <tr>
                  <td class="text-bold-500 text-center" colspan="{{ 2 + $uniqueCategories->count() }}">
                    No data available in table
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div> --}}

      </div>
    </div>
  </div>
</div>
