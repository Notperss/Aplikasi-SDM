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

        {{-- <div class="col-md-12">
          <table class="table table-sm table-bordered" style="font-size: 80%">
            <thead>
              <tr>
                <th class="text-center">Unit Kerja</th>
                @php
                  $uniqueLevels = collect();
                  foreach ($directorates as $directorate) {
                      foreach ($directorate->divisions as $division) {
                          foreach ($division->positions as $position) {
                              if ($position->employee && $position->employee->employee_status === 'AKTIF') {
                                  // Ensure the position has an employee
                                  $level = optional($position)->level;
                                  if ($level) {
                                      $uniqueLevels->push($level);
                                  }
                              }
                          }
                      }
                  }
                  // Remove duplicates and sort by id
                  $uniqueLevels = $uniqueLevels->unique('id')->sortBy('id');
                @endphp

                @foreach ($uniqueLevels as $level)
                  <th>{{ $level->name }}</th>
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
                      <td class="text-center">{{ $levelCounts[$level] }}</td>
                    @endforeach
                  </tr>
                @endforeach

                <!-- Total Row -->
                <tr>
                  <td class="font-weight-bold text-center">Total :</td>
                  @foreach ($uniqueLevels as $level)
                    <td class="font-weight-bold text-center">{{ $totalCounts[$level] }}</td>
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
          <table class="table table-sm table-bordered" style="font-size: 80%">
            <thead>
              <tr>
                <th class="text-center">Unit Kerja</th>
                @php
                  $uniqueLevels = collect();
                  foreach ($directorates as $directorate) {
                      foreach ($directorate->divisions as $division) {
                          foreach ($division->positions as $position) {
                              if ($position->employee && $position->employee->employee_status === 'AKTIF') {
                                  // Ensure the position has an employee
                                  $level = optional($position)->level;
                                  if ($level) {
                                      $uniqueLevels->push($level);
                                  }
                              }
                          }
                      }
                  }
                  // Remove duplicates and sort by id
                  $uniqueLevels = $uniqueLevels->unique('id')->sortBy('id');
                @endphp

                @foreach ($uniqueLevels as $level)
                  <th>{{ $level->name }}</th>
                @endforeach
              </tr>
            </thead>
            <tbody>
              @php
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
                  $totalCounts = array_fill_keys($uniqueLevels->pluck('name')->toArray(), 0);
                @endphp

                {{-- @foreach ($directoratesGroup as $directorate)
                  @php
                    $levelCounts = array_fill_keys($uniqueLevels->pluck('name')->toArray(), 0);

                    foreach ($directorate->divisions as $division) {
                        foreach ($division->positions as $position) {
                            if ($position->employee && $position->employee->employee_status === 'AKTIF') {
                                // Ensure the position has an employee
                                $level = optional($position)->level;
                                if ($level && isset($levelCounts[$level->name])) {
                                    $levelCounts[$level->name]++;
                                    $totalCounts[$level->name]++;
                                }
                            }
                        }
                    }
                  @endphp

                  <tr>
                    <td class="font-weight-bold">{{ $directorate->name }}</td>
                    @foreach ($uniqueLevels as $level)
                      <td class="text-center"> <a data-bs-toggle="modal"
                          data-bs-target="#modal-employee-position-{{ $position->level->id }}"
                          class="btn btn-sm btn-icon btn-secondary text-white">
                          {{ $levelCounts[$level->name] }}</a>

                        <!-- Modals add menu -->
                        <div id="modal-employee-position-{{ $position->level->id }}" class="modal fade" tabindex="-1"
                          aria-labelledby="modal-employee-position-{{ $position->level->id }}-label" aria-hidden="true"
                          style="display: none;">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="modal-employee-position-{{ $position->level->id }}-label">
                                  Edit Data Dinas/Tugas
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                              </div>

                              <div class="card-body">
                                <div class="row justify-content-center">
                                  <div class="col-md-12">
                                    <table class="table table-striped" id="table1" style="font-size: 85%">
                                      <thead>
                                        <tr>
                                          <th>#</th>
                                          <th></th>
                                          <th>NIK</th>
                                          <th>Nama</th>
                                          <th>Jabatan</th>
                                          <th>Kategori Karyawan</th>
                                          <th>Status</th>
                                          <th></th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @foreach ($position as $pos)
                                          <tr>
                                            <td>
                                              {{ $loop->iteration }}
                                            </td>
                                          </tr>
                                        @endforeach
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                              </div>

                              <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary ">Save</button>
                              </div>


                            </div><!-- /.modal-content -->
                          </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
                      </td>

                      <td class="text-center">{{ $levelCounts[$level->name] }}</td>
                    @endforeach
                  </tr>
                @endforeach --}}

                @foreach ($directoratesGroup as $directorate)
                  @php
                    $levelCounts = array_fill_keys($uniqueLevels->pluck('name')->toArray(), 0);

                    foreach ($directorate->divisions as $division) {
                        foreach ($division->positions as $position) {
                            if ($position->employee && $position->employee->employee_status === 'AKTIF') {
                                $level = optional($position)->level;
                                if ($level && isset($levelCounts[$level->name])) {
                                    $levelCounts[$level->name]++;
                                    $totalCounts[$level->name]++;
                                }
                            }
                        }
                    }
                  @endphp

                  <tr>
                    <td class="font-weight-bold">{{ $directorate->name }}</td>
                    @foreach ($uniqueLevels as $level)
                      <td class="text-center">
                        <a data-bs-toggle="modal"
                          data-bs-target="#modal-employee-position-{{ $directorate->id }}-{{ $level->id }}"
                          class="btn btn-sm btn-icon btn-secondary text-white">
                          {{ $levelCounts[$level->name] }}
                        </a>

                        <!-- Modal for Level within Directorate -->
                        <div id="modal-employee-position-{{ $directorate->id }}-{{ $level->id }}" class="modal fade"
                          tabindex="-1"
                          aria-labelledby="modal-employee-position-{{ $directorate->id }}-{{ $level->id }}-label"
                          aria-hidden="true">
                          <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title"
                                  id="modal-employee-position-{{ $directorate->id }}-{{ $level->id }}-label">
                                  {{ $level->name }} - {{ $directorate->name }}
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                  aria-label="Close"></button>
                              </div>

                              <div class="card-body">
                                <div class="row justify-content-center">
                                  <div class="col-md-12">
                                    <table class="table table-striped dataTable" id="table2r" style="font-size: 85%">
                                      <thead>
                                        <tr>
                                          <th>#</th>
                                          <th>NIK</th>
                                          <th>Nama</th>
                                          <th>Level</th>
                                          <th>Jabatan</th>
                                          <th>Kategori Karyawan</th>
                                          <th>Divisi</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @php
                                          $filteredPositions = $directorate->divisions->flatMap(function (
                                              $division,
                                          ) use ($level) {
                                              return $division->positions->filter(function ($position) use ($level) {
                                                  return optional($position->level)->id === $level->id &&
                                                      optional($position->employee)->employee_status === 'AKTIF';
                                              });
                                          });
                                        @endphp

                                        @foreach ($filteredPositions as $pos)
                                          <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $pos->employee->nik }}</td>
                                            <td>{{ $pos->employee->name }}</td>
                                            <td>{{ $pos->level->name }}</td>
                                            <td>{{ $pos->name }}</td>
                                            <td>{{ $pos->employee->employeeCategory->name }}</td>
                                            <td>{{ $pos->division->name }}</td>
                                          </tr>
                                        @endforeach
                                      </tbody>
                                    </table>

                                  </div>
                                </div>
                              </div>

                              <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </td>
                    @endforeach
                  </tr>
                @endforeach

                <!-- Total Row -->
                <tr>
                  <td class="font-weight-bold text-center">Total :</td>
                  @foreach ($uniqueLevels as $level)
                    <td class="font-weight-bold text-center">{{ $totalCounts[$level->name] }}</td>
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
          <table class="table table-sm table-bordered" style="font-size: 80%">
            <thead>
              <tr>
                <th class="text-center">Unit Kerja</th>
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
                                  $level = optional($position)->level;
                                  if ($level) {
                                      $uniqueLevels->push($level);
                                  }
                              }
                          }
                      }
                  }
                  // Remove duplicates and sort by id
                  $uniqueLevels = $uniqueLevels->unique('id')->sortBy('id');
                @endphp

                @foreach ($uniqueLevels as $level)
                  <th>{{ $level->name }}</th>
                @endforeach
              </tr>
            </thead>
            <tbody>
              @php
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
                  $totalCounts = array_fill_keys($uniqueLevels->pluck('name')->toArray(), 0);
                @endphp

                @foreach ($directoratesGroup as $directorate)
                  @php
                    $levelCounts = array_fill_keys($uniqueLevels->pluck('name')->toArray(), 0);

                    foreach ($directorate->divisions as $division) {
                        foreach ($division->positions as $position) {
                            if (
                                $position->employee &&
                                $position->employee->employee_status === 'AKTIF' &&
                                $position->employee->employeeCategory->name === 'OFFICE'
                            ) {
                                // Ensure the position has an employee
                                $level = optional($position)->level;
                                if ($level && isset($levelCounts[$level->name])) {
                                    $levelCounts[$level->name]++;
                                    $totalCounts[$level->name]++;
                                }
                            }
                        }
                    }
                  @endphp

                  <tr>
                    <td class="font-weight-bold">{{ $directorate->name }}</td>
                    @foreach ($uniqueLevels as $level)
                      <td class="text-center">{{ $levelCounts[$level->name] }}</td>
                    @endforeach
                  </tr>
                @endforeach

                <!-- Total Row -->
                <tr>
                  <td class="font-weight-bold text-center">Total :</td>
                  @foreach ($uniqueLevels as $level)
                    <td class="font-weight-bold text-center">{{ $totalCounts[$level->name] }}</td>
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
          <h3>NON-OFFICE</h3>
          <table class="table table-sm table-bordered" style="font-size: 80%">
            <thead>
              <tr>
                <th class="text-center">Unit Kerja</th>
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
                                  $level = optional($position)->level;
                                  if ($level) {
                                      $uniqueLevels->push($level);
                                  }
                              }
                          }
                      }
                  }
                  // Remove duplicates and sort by id
                  $uniqueLevels = $uniqueLevels->unique('id')->sortBy('id');
                @endphp

                @foreach ($uniqueLevels as $level)
                  <th>{{ $level->name }}</th>
                @endforeach
              </tr>
            </thead>
            <tbody>
              @php
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
                  $totalCounts = array_fill_keys($uniqueLevels->pluck('name')->toArray(), 0);
                @endphp

                @foreach ($directoratesGroup as $directorate)
                  @php
                    $levelCounts = array_fill_keys($uniqueLevels->pluck('name')->toArray(), 0);

                    foreach ($directorate->divisions as $division) {
                        foreach ($division->positions as $position) {
                            if (
                                $position->employee &&
                                $position->employee->employee_status === 'AKTIF' &&
                                $position->employee->employeeCategory->name === 'NON-OFFICE'
                            ) {
                                // Ensure the position has an employee
                                $level = optional($position)->level;
                                if ($level && isset($levelCounts[$level->name])) {
                                    $levelCounts[$level->name]++;
                                    $totalCounts[$level->name]++;
                                }
                            }
                        }
                    }
                  @endphp

                  <tr>
                    <td class="font-weight-bold">{{ $directorate->name }}</td>
                    @foreach ($uniqueLevels as $level)
                      <td class="text-center">{{ $levelCounts[$level->name] }}</td>
                    @endforeach
                  </tr>
                @endforeach

                <!-- Total Row -->
                <tr>
                  <td class="font-weight-bold text-center">Total :</td>
                  @foreach ($uniqueLevels as $level)
                    <td class="font-weight-bold text-center">{{ $totalCounts[$level->name] }}</td>
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

      </div>
    </div>
  </div>
</div>
