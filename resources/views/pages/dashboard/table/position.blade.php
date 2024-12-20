<div class="col-12">
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4 class="card-title">Level Jabatan</h4>
          <a href="{{ url('/export-positions') }}" class="btn btn-sm btn-success">Export</a>
        </div>

        {{-- <div class="col-md-12">
          <table class="table table-sm table-bordered text-center" style="font-size: 80%">
            <thead>
              <tr>
                <th>Unit Kerja</th>
                @php
                  $uniqueLevels = collect();
                  foreach ($directorates as $directorate) {
                      foreach ($directorate->divisions as $division) {
                          foreach ($division->positions as $position) {
                              $levelName = optional($position)->level->name ?? null;
                              if ($levelName) {
                                  $uniqueLevels->push($levelName);
                              }
                          }
                      }
                  }
                  $uniqueLevels = $uniqueLevels->unique();
                @endphp

                @foreach ($uniqueLevels as $level)
                  <th>{{ $level }}</th>
                @endforeach
              </tr>
            </thead>
            <tbody>
              @php
                $groupedDirectorates = $directorates->groupBy('is_non');
              @endphp

              @forelse ($groupedDirectorates as $isNon => $directoratesGroup)
                <tr>
                  <td colspan="{{ 1 + $uniqueLevels->count() }}" class="font-weight-bold text-center">
                    {{ $isNon ? 'DIREKTORAT' : 'NON-DIREKTORAT' }}
                  </td>
                </tr>

                @php
                  $totalCounts = array_fill_keys($uniqueLevels->toArray(), 0);
                @endphp

                @foreach ($directoratesGroup as $directorate)
                  @php
                    $levelCounts = array_fill_keys($uniqueLevels->toArray(), 0);

                    foreach ($directorate->divisions as $division) {
                        foreach ($division->positions as $position) {
                            $levelName = optional($position)->level->name ?? null;
                            if ($levelName && isset($levelCounts[$levelName])) {
                                $levelCounts[$levelName]++;
                                $totalCounts[$levelName]++;
                            }
                        }
                    }
                  @endphp

                  <tr>
                    <td class="font-weight-bold">{{ $directorate->name }}</td>
                    @foreach ($uniqueLevels as $level)
                      <td>{{ $levelCounts[$level] }}</td>
                    @endforeach
                  </tr>
                @endforeach

                <!-- Total Row -->
                <tr>
                  <td class="font-weight-bold text-center">Total :</td>
                  @foreach ($uniqueLevels as $level)
                    <td class="font-weight-bold">{{ $totalCounts[$level] }}</td>
                  @endforeach
                </tr>
              @empty
                <tr>
                  <td colspan="{{ 1 + $uniqueLevels->count() }}" class="font-weight-bold text-center">
                    No data available in table
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div> --}}

        <div class="col-md-12">
          <table class="table table-sm table-bordered text-center" style="font-size: 80%">
            <thead>
              <tr>
                <th>Unit Kerja</th>
                @php
                  $uniqueLevels = collect();
                  foreach ($directorates as $directorate) {
                      foreach ($directorate->divisions as $division) {
                          foreach ($division->positions as $position) {
                              if ($position->employee && $position->employee->employee_status === 'AKTIF') {
                                  // Ensure the position has an employee
                                  $levelName = optional($position)->level->name ?? null;
                                  if ($levelName) {
                                      $uniqueLevels->push($levelName);
                                  }
                              }
                          }
                      }
                  }
                  $uniqueLevels = $uniqueLevels->unique();
                @endphp

                @foreach ($uniqueLevels as $level)
                  <th>{{ $level }}</th>
                @endforeach
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
              @endphp

              @forelse ($groupedDirectorates as $isNon => $directoratesGroup)
                <tr>
                  <td colspan="{{ 1 + $uniqueLevels->count() }}" class="font-weight-bold text-center">
                    {{ $isNon == 1 ? 'DIREKTORAT' : ($isNon == 2 ? 'NON-DIREKTORAT' : 'LAIN-LAIN') }}
                  </td>
                </tr>

                @php
                  $totalCounts = array_fill_keys($uniqueLevels->toArray(), 0);
                @endphp

                @foreach ($directoratesGroup as $directorate)
                  @php
                    $levelCounts = array_fill_keys($uniqueLevels->toArray(), 0);

                    foreach ($directorate->divisions as $division) {
                        foreach ($division->positions as $position) {
                            if ($position->employee && $position->employee->employee_status === 'AKTIF') {
                                // Ensure the position has an employee
                                $levelName = optional($position)->level->name ?? null;
                                if ($levelName && isset($levelCounts[$levelName])) {
                                    $levelCounts[$levelName]++;
                                    $totalCounts[$levelName]++;
                                }
                            }
                        }
                    }
                  @endphp

                  <tr>
                    <td class="font-weight-bold">{{ $directorate->name }}</td>
                    @foreach ($uniqueLevels as $level)
                      <td>{{ $levelCounts[$level] }}</td>
                    @endforeach
                  </tr>
                @endforeach

                <!-- Total Row -->
                <tr>
                  <td class="font-weight-bold text-center">Total :</td>
                  @foreach ($uniqueLevels as $level)
                    <td class="font-weight-bold">{{ $totalCounts[$level] }}</td>
                  @endforeach
                </tr>
              @empty
                <tr>
                  <td colspan="{{ 1 + $uniqueLevels->count() }}" class="font-weight-bold text-center">
                    No data available in table
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="col-md-12">
          <h3>OFFICE</h3>
          <table class="table table-sm table-bordered text-center" style="font-size: 80%">
            <thead>
              <tr>
                <th>Unit Kerja</th>
                @php
                  $uniqueLevels = collect();
                  foreach ($directorates as $directorate) {
                      foreach ($directorate->divisions as $division) {
                          foreach ($division->positions as $position) {
                              if (
                                  $position->employee &&
                                  $position->employee->employee_status === 'AKTIF' &&
                                  $position->employee->employeeCategory->name === 'OFFICE'
                              ) {
                                  // Ensure the position has an employee
                                  $levelName = optional($position)->level->name ?? null;
                                  if ($levelName) {
                                      $uniqueLevels->push($levelName);
                                  }
                              }
                          }
                      }
                  }
                  $uniqueLevels = $uniqueLevels->unique();
                @endphp

                @forelse ($uniqueLevels as $level)
                  <th>{{ $level }}</th>
                @empty
                  <th class="font-weight-bold">-</th>
                @endforelse
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
              @endphp

              @forelse ($groupedDirectorates as $isNon => $directoratesGroup)
                <tr>
                  <td colspan="{{ 1 + $uniqueLevels->count() }}" class="font-weight-bold text-center">
                    {{ $isNon == 1 ? 'DIREKTORAT' : ($isNon == 2 ? 'NON-DIREKTORAT' : 'LAIN-LAIN') }}
                  </td>
                </tr>

                @php
                  $totalCounts = array_fill_keys($uniqueLevels->toArray(), 0);
                @endphp

                @foreach ($directoratesGroup as $directorate)
                  @php
                    $levelCounts = array_fill_keys($uniqueLevels->toArray(), 0);

                    foreach ($directorate->divisions as $division) {
                        foreach ($division->positions as $position) {
                            if (
                                $position->employee &&
                                $position->employee->employee_status === 'AKTIF' &&
                                $position->employee->employeeCategory->name === 'OFFICE'
                            ) {
                                // Ensure the position has an employee
                                $levelName = optional($position)->level->name ?? null;
                                if ($levelName && isset($levelCounts[$levelName])) {
                                    $levelCounts[$levelName]++;
                                    $totalCounts[$levelName]++;
                                }
                            }
                        }
                    }
                  @endphp

                  <tr>
                    <td class="font-weight-bold">{{ $directorate->name }}</td>
                    @forelse ($uniqueLevels as $level)
                      <td>{{ $levelCounts[$level] }}</td>
                    @empty
                      <td class="font-weight-bold">-</td>
                    @endforelse
                  </tr>
                @endforeach

                <!-- Total Row -->
                <tr>
                  <td class="font-weight-bold text-center">Total :</td>
                  @forelse ($uniqueLevels as $level)
                    <td class="font-weight-bold">{{ $totalCounts[$level] }}</td>
                  @empty
                    <td class="font-weight-bold">-</td>
                  @endforelse
                </tr>
              @empty
                <tr>
                  <td colspan="{{ 1 + $uniqueLevels->count() }}" class="font-weight-bold text-center">
                    No data available in table
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="col-md-12">
          <h3>NON-OFFICE</h3>
          <table class="table table-sm table-bordered text-center" style="font-size: 80%">
            <thead>
              <tr>
                <th>Unit Kerja</th>
                @php
                  $uniqueLevels = collect();
                  foreach ($directorates as $directorate) {
                      foreach ($directorate->divisions as $division) {
                          foreach ($division->positions as $position) {
                              if (
                                  $position->employee &&
                                  $position->employee->employee_status === 'AKTIF' &&
                                  $position->employee->employeeCategory->name === 'NON-OFFICE'
                              ) {
                                  // Ensure the position has an employee
                                  $levelName = optional($position)->level->name ?? null;
                                  if ($levelName) {
                                      $uniqueLevels->push($levelName);
                                  }
                              }
                          }
                      }
                  }
                  $uniqueLevels = $uniqueLevels->unique();
                @endphp

                @forelse ($uniqueLevels as $level)
                  <th>{{ $level }}</th>
                @empty
                  <th class="font-weight-bold">-</th>
                @endforelse
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
              @endphp

              @forelse ($groupedDirectorates as $isNon => $directoratesGroup)
                <tr>
                  <td colspan="{{ 1 + $uniqueLevels->count() }}" class="font-weight-bold text-center">
                    {{ $isNon == 1 ? 'DIREKTORAT' : ($isNon == 2 ? 'NON-DIREKTORAT' : 'LAIN-LAIN') }}
                  </td>
                </tr>

                @php
                  $totalCounts = array_fill_keys($uniqueLevels->toArray(), 0);
                @endphp

                @foreach ($directoratesGroup as $directorate)
                  @php
                    $levelCounts = array_fill_keys($uniqueLevels->toArray(), 0);

                    foreach ($directorate->divisions as $division) {
                        foreach ($division->positions as $position) {
                            if (
                                $position->employee &&
                                $position->employee->employee_status === 'AKTIF' &&
                                $position->employee->employeeCategory->name === 'NON-OFFICE'
                            ) {
                                // Ensure the position has an employee
                                $levelName = optional($position)->level->name ?? null;
                                if ($levelName && isset($levelCounts[$levelName])) {
                                    $levelCounts[$levelName]++;
                                    $totalCounts[$levelName]++;
                                }
                            }
                        }
                    }
                  @endphp

                  <tr>
                    <td class="font-weight-bold">{{ $directorate->name }}</td>
                    @forelse ($uniqueLevels as $level)
                      <td>{{ $levelCounts[$level] }}</td>
                    @empty
                      <td class="font-weight-bold">-</td>
                    @endforelse
                  </tr>
                @endforeach

                <!-- Total Row -->
                <tr>
                  <td class="font-weight-bold text-center">Total :</td>
                  @forelse ($uniqueLevels as $level)
                    <td class="font-weight-bold">{{ $totalCounts[$level] }}</td>
                  @empty
                    <td class="font-weight-bold">-</td>
                  @endforelse
                </tr>
              @empty
                <tr>
                  <td colspan="{{ 1 + $uniqueLevels->count() }}" class="font-weight-bold text-center">
                    No data available in table
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>


      </div>
    </div>
  </div>
</div>
