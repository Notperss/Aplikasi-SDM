{{-- <table>
  <thead>
    <tr>
      <th style="width: 50;">Unit Kerja</th>
      @php
        // Collect unique levels
        $uniqueLevels = collect();
        foreach ($directorates as $directorate) {
            foreach ($directorate->divisions as $division) {
                foreach ($division->positions as $position) {
                    if ($position->employee && $position->employee->employee_status === 'AKTIF') {
                        $levelName = optional($position->level)->name ?? null;
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
        <th style="width: 20;">{{ $level }}</th>
      @endforeach
    </tr>
  </thead>
  <tbody>
    @php
      // Group and sort directorates by is_non
      $groupedDirectorates = $directorates->groupBy('is_non')->sortKeysUsing(function ($key1, $key2) {
          $order = [1, 2]; // Define the desired order for is_non
          return array_search($key1, $order) <=> array_search($key2, $order);
      });
    @endphp

    @forelse ($groupedDirectorates as $isNon => $directoratesGroup)
      <tr>
        <td class="text-center font-weight-bold"
          style="background-color: #979797; font-weight: bold; text-align: center;">
          {{ $isNon == 1 ? 'DIREKTORAT' : ($isNon == 2 ? 'NON-DIREKTORAT' : 'LAIN-LAIN') }}
        </td>
      </tr>

      @php
        // Initialize total counts for all levels
        $totalCounts = array_fill_keys($uniqueLevels->toArray(), 0);
      @endphp

      @foreach ($directoratesGroup as $directorate)
        <tr>
          <td style=" font-weight: bold; text-align: left;">
            {{ $directorate->name }}
          </td>
        </tr>

        @php
          // Initialize counts for this directorate
          $divisionTotalCounts = array_fill_keys($uniqueLevels->toArray(), 0);
        @endphp

        @foreach ($directorate->divisions as $division)
          @php
            // Initialize counts for this division
            $levelCounts = array_fill_keys($uniqueLevels->toArray(), 0);

            // Count positions by level
            foreach ($division->positions as $position) {
                if ($position->employee && $position->employee->employee_status === 'AKTIF') {
                    // Check if employee exists
                    $levelName = optional($position->level)->name ?? null;
                    if ($levelName && isset($levelCounts[$levelName])) {
                        $levelCounts[$levelName]++;
                        $divisionTotalCounts[$levelName]++;
                        $totalCounts[$levelName]++;
                    }
                }
            }
          @endphp

          <tr>
            <td>{{ $division->name }}</td>
            @foreach ($uniqueLevels as $level)
              <td>{{ $levelCounts[$level] }}</td>
            @endforeach
          </tr>
        @endforeach

        <!-- Division Total Row -->
        <tr>
          <td style=" font-weight: bold; text-align: left;">Total ({{ $directorate->name }}):</td>
          @foreach ($uniqueLevels as $level)
            <td style=" font-weight: bold;">{{ $divisionTotalCounts[$level] }}</td>
          @endforeach
        </tr>
      @endforeach

      <!-- Directorate Total Row -->
      <tr>
        <td style=" font-weight: bold; text-align: left;">Total Semua:</td>
        @foreach ($uniqueLevels as $level)
          <td style=" font-weight: bold; ">{{ $totalCounts[$level] }}</td>
        @endforeach
      </tr>
    @empty
      <tr>
        <td colspan="{{ 1 + $uniqueLevels->count() }}" class="text-center font-weight-bold">
          No data available
        </td>
      </tr>
    @endforelse
  </tbody>
</table> --}}

<table>
  <thead>
    <tr>
      <th style="width: 50;">Unit Kerja</th>
      @php
        // Collect unique levels with id
        $uniqueLevels = collect();
        foreach ($directorates as $directorate) {
            foreach ($directorate->divisions as $division) {
                foreach ($division->positions as $position) {
                    if ($position->employee && $position->employee->employee_status === 'AKTIF') {
                        $level = optional($position->level);
                        if ($level) {
                            $uniqueLevels->push(['id' => $level->id, 'name' => $level->name]);
                        }
                    }
                }
            }
        }

        // Sort levels by id and extract only names
        $uniqueLevels = $uniqueLevels->unique('id')->sortBy('id')->pluck('name');
      @endphp

      @foreach ($uniqueLevels as $level)
        <th style="width: 20;">{{ $level }}</th>
      @endforeach
    </tr>
  </thead>
  <tbody>
    @php
      // Group and sort directorates by is_non
      $groupedDirectorates = $directorates->groupBy('is_non')->sortKeysUsing(function ($key1, $key2) {
          $order = [1, 2]; // Define the desired order for is_non
          return array_search($key1, $order) <=> array_search($key2, $order);
      });
    @endphp

    @forelse ($groupedDirectorates as $isNon => $directoratesGroup)
      <tr>
        <td class="text-center font-weight-bold">

        </td>
      </tr>
      <tr>
        <td class="text-center font-weight-bold"
          style="background-color: #979797; font-weight: bold; text-align: center;">
          {{ $isNon == 1 ? 'DIREKTORAT' : ($isNon == 2 ? 'NON-DIREKTORAT' : 'LAIN-LAIN') }}
        </td>
      </tr>

      @php
        // Initialize total counts for all levels
        $totalCounts = array_fill_keys($uniqueLevels->toArray(), 0);
      @endphp

      @foreach ($directoratesGroup as $directorate)
        <tr>
          <td style=" font-weight: bold; text-align: left;">
            {{ $directorate->name }}
          </td>
        </tr>

        @php
          // Initialize counts for this directorate
          $divisionTotalCounts = array_fill_keys($uniqueLevels->toArray(), 0);
        @endphp

        @foreach ($directorate->divisions as $division)
          @php
            // Initialize counts for this division
            $levelCounts = array_fill_keys($uniqueLevels->toArray(), 0);

            // Count positions by level
            foreach ($division->positions as $position) {
                if ($position->employee && $position->employee->employee_status === 'AKTIF') {
                    $levelName = optional($position->level)->name ?? null;
                    if ($levelName && isset($levelCounts[$levelName])) {
                        $levelCounts[$levelName]++;
                        $divisionTotalCounts[$levelName]++;
                        $totalCounts[$levelName]++;
                    }
                }
            }
          @endphp

          <tr>
            <td>{{ $division->name }}</td>
            @foreach ($uniqueLevels as $level)
              <td>{{ $levelCounts[$level] }}</td>
            @endforeach
          </tr>
        @endforeach

        <!-- Division Total Row -->
        <tr>
          <td style=" font-weight: bold; text-align: left; background-color: #c2b9b9;">Total ({{ $directorate->name }}):
          </td>
          @foreach ($uniqueLevels as $level)
            <td style=" font-weight: bold; background-color: #c2b9b9;">{{ $divisionTotalCounts[$level] }}</td>
          @endforeach
        </tr>
      @endforeach

      <!-- Directorate Total Row -->
      <tr>
        <td style=" font-weight: bold; text-align: left; background-color: #979797;">Total Semua:</td>
        @foreach ($uniqueLevels as $level)
          <td style=" font-weight: bold; background-color: #979797;">{{ $totalCounts[$level] }}</td>
        @endforeach
      </tr>
    @empty
      <tr>
        <td colspan="{{ 1 + $uniqueLevels->count() }}" class="text-center font-weight-bold">
          No data available
        </td>
      </tr>
    @endforelse
  </tbody>
</table>

@php
  $uniqueLevels = collect();
  $uniqueCategories = collect();

  foreach ($directorates as $directorate) {
      foreach ($directorate->divisions as $division) {
          foreach ($division->positions as $position) {
              if ($position->employee && $position->employee->employee_status === 'AKTIF') {
                  $category = optional($position->employee->employeeCategory)->name;
                  $level = optional($position)->level;

                  if ($category) {
                      $uniqueCategories->push($category);
                  }
                  if ($level) {
                      $uniqueLevels->push($level);
                  }
              }
          }
      }
  }

  // Sort and filter unique levels and categories
  $uniqueLevels = $uniqueLevels->unique('id')->sortBy('id');
  $uniqueCategories = $uniqueCategories->unique()->sort();
@endphp

@foreach ($uniqueCategories as $category)
  <div class="col-md-12">
    <h3>{{ strtoupper($category) }}</h3>

    <table class="table table-sm table-bordered" style="font-size: 80%">
      <thead>
        <tr>
          <th class="text-center">Unit Kerja</th>
          <th class="text-center">Divisi</th>

          @foreach ($uniqueLevels as $level)
            <th class="text-center">{{ $level->name }}</th>
          @endforeach
        </tr>
      </thead>
      <tbody>
        @php
          $totalCounts = array_fill_keys($uniqueLevels->pluck('name')->toArray(), 0);
        @endphp

        @foreach ($directorates as $directorate)
          @php
            $directorateTotalCounts = array_fill_keys($uniqueLevels->pluck('name')->toArray(), 0);
          @endphp

          @foreach ($directorate->divisions as $division)
            @php
              $levelCounts = array_fill_keys($uniqueLevels->pluck('name')->toArray(), 0);

              foreach ($division->positions as $position) {
                  if (
                      $position->employee &&
                      $position->employee->employee_status === 'AKTIF' &&
                      optional($position->employee->employeeCategory)->name === $category
                  ) {
                      $level = optional($position)->level;
                      if ($level && isset($levelCounts[$level->name])) {
                          $levelCounts[$level->name]++;
                          $directorateTotalCounts[$level->name]++;
                          $totalCounts[$level->name]++;
                      }
                  }
              }
            @endphp

            <tr>
              <td class="font-weight-bold">{{ $directorate->name }}</td>
              <td>{{ $division->name }}</td>

              @foreach ($uniqueLevels as $level)
                <td class="text-center">{{ $levelCounts[$level->name] }}</td>
              @endforeach
            </tr>
          @endforeach

          <!-- Total per Director -->
          <tr>
            <td class="font-weight-bold text-center bg-light" colspan="2" style="background-color: #c2b9b9;">Total
              ({{ $directorate->name }})
              :</td>

            @foreach ($uniqueLevels as $level)
              <td class="font-weight-bold text-center bg-light" style="background-color: #c2b9b9;">
                {{ $directorateTotalCounts[$level->name] }}
              </td>
            @endforeach
          </tr>
        @endforeach

        <!-- Grand Total -->
        <tr>
          <td class="font-weight-bold text-center" colspan="2" style="background-color: #979797;">Total Semua :</td>

          @foreach ($uniqueLevels as $level)
            <td class="font-weight-bold text-center" style="background-color: #979797;">
              {{ $totalCounts[$level->name] }}
            </td>
          @endforeach
        </tr>
      </tbody>
    </table>
  </div>
@endforeach



{{-- <table>
  <tr>
    <td style="font-size: 24px; background-color: #a5a4a4">OFFICE</td>
  </tr>
  <thead>
    <tr>
      <th style="width: 50;">Unit Kerja</th>
      @php
        // Collect unique levels
        $uniqueLevels = collect();
        foreach ($directorates as $directorate) {
            foreach ($directorate->divisions as $division) {
                foreach ($division->positions as $position) {
                    if (
                        $position->employee &&
                        $position->employee->employee_status === 'AKTIF' &&
                        $position->employee->employeeCategory->name === 'OFFICE'
                    ) {
                        $levelName = optional($position->level)->name ?? null;
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
        <th style="width: 20;">{{ $level }}</th>
      @endforeach
    </tr>
  </thead>
  <tbody>
    @php
      // Group and sort directorates by is_non
      $groupedDirectorates = $directorates->groupBy('is_non')->sortKeysUsing(function ($key1, $key2) {
          $order = [1, 2]; // Define the desired order for is_non
          return array_search($key1, $order) <=> array_search($key2, $order);
      });
    @endphp

    @forelse ($groupedDirectorates as $isNon => $directoratesGroup)
      <tr>
        <td class="text-center font-weight-bold"
          style="background-color: #979797; font-weight: bold; text-align: center;">
          {{ $isNon == 1 ? 'DIREKTORAT' : ($isNon == 2 ? 'NON-DIREKTORAT' : 'LAIN-LAIN') }}
        </td>
      </tr>

      @php
        // Initialize total counts for all levels
        $totalCounts = array_fill_keys($uniqueLevels->toArray(), 0);
      @endphp

      @foreach ($directoratesGroup as $directorate)
        <tr>
          <td style=" font-weight: bold; text-align: left;">
            {{ $directorate->name }}
          </td>
        </tr>

        @php
          // Initialize counts for this directorate
          $divisionTotalCounts = array_fill_keys($uniqueLevels->toArray(), 0);
        @endphp

        @foreach ($directorate->divisions as $division)
          @php
            // Initialize counts for this division
            $levelCounts = array_fill_keys($uniqueLevels->toArray(), 0);

            // Count positions by level
            foreach ($division->positions as $position) {
                if (
                    $position->employee &&
                    $position->employee->employee_status === 'AKTIF' &&
                    $position->employee->employeeCategory->name === 'OFFICE'
                ) {
                    // Check if employee exists
                    $levelName = optional($position->level)->name ?? null;
                    if ($levelName && isset($levelCounts[$levelName])) {
                        $levelCounts[$levelName]++;
                        $divisionTotalCounts[$levelName]++;
                        $totalCounts[$levelName]++;
                    }
                }
            }
          @endphp

          <tr>
            <td>{{ $division->name }}</td>
            @foreach ($uniqueLevels as $level)
              <td>{{ $levelCounts[$level] }}</td>
            @endforeach
          </tr>
        @endforeach

        <!-- Division Total Row -->
        <tr>
          <td style=" font-weight: bold; text-align: left;">Total ({{ $directorate->name }}):</td>
          @foreach ($uniqueLevels as $level)
            <td style=" font-weight: bold;">{{ $divisionTotalCounts[$level] }}</td>
          @endforeach
        </tr>
      @endforeach

      <!-- Directorate Total Row -->
      <tr>
        <td style=" font-weight: bold; text-align: left;">Total Semua:</td>
        @foreach ($uniqueLevels as $level)
          <td style=" font-weight: bold; ">{{ $totalCounts[$level] }}</td>
        @endforeach
      </tr>
    @empty
      <tr>
        <td colspan="{{ 1 + $uniqueLevels->count() }}" class="text-center font-weight-bold">
          No data available
        </td>
      </tr>
    @endforelse
  </tbody>
</table>

<table>
  <tr>
    <td style="font-size: 24px; background-color: #a5a4a4">NON-OFFICE</td>
  </tr>
  <thead>
    <tr>
      <th style="width: 50;">Unit Kerja</th>
      @php
        // Collect unique levels
        $uniqueLevels = collect();
        foreach ($directorates as $directorate) {
            foreach ($directorate->divisions as $division) {
                foreach ($division->positions as $position) {
                    if (
                        $position->employee &&
                        $position->employee->employee_status === 'AKTIF' &&
                        $position->employee->employeeCategory->name === 'NON-OFFICE'
                    ) {
                        $levelName = optional($position->level)->name ?? null;
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
        <th style="width: 20;">{{ $level }}</th>
      @endforeach
    </tr>
  </thead>
  <tbody>
    @php
      // Group and sort directorates by is_non
      $groupedDirectorates = $directorates->groupBy('is_non')->sortKeysUsing(function ($key1, $key2) {
          $order = [1, 2]; // Define the desired order for is_non
          return array_search($key1, $order) <=> array_search($key2, $order);
      });
    @endphp

    @forelse ($groupedDirectorates as $isNon => $directoratesGroup)
      <tr>
        <td class="text-center font-weight-bold"
          style="background-color: #979797; font-weight: bold; text-align: center;">
          {{ $isNon == 1 ? 'DIREKTORAT' : ($isNon == 2 ? 'NON-DIREKTORAT' : 'LAIN-LAIN') }}
        </td>
      </tr>

      @php
        // Initialize total counts for all levels
        $totalCounts = array_fill_keys($uniqueLevels->toArray(), 0);
      @endphp

      @foreach ($directoratesGroup as $directorate)
        <tr>
          <td style=" font-weight: bold; text-align: left;">
            {{ $directorate->name }}
          </td>
        </tr>

        @php
          // Initialize counts for this directorate
          $divisionTotalCounts = array_fill_keys($uniqueLevels->toArray(), 0);
        @endphp

        @foreach ($directorate->divisions as $division)
          @php
            // Initialize counts for this division
            $levelCounts = array_fill_keys($uniqueLevels->toArray(), 0);

            // Count positions by level
            foreach ($division->positions as $position) {
                if (
                    $position->employee &&
                    $position->employee->employee_status === 'AKTIF' &&
                    $position->employee->employeeCategory->name === 'NON-OFFICE'
                ) {
                    // Check if employee exists
                    $levelName = optional($position->level)->name ?? null;
                    if ($levelName && isset($levelCounts[$levelName])) {
                        $levelCounts[$levelName]++;
                        $divisionTotalCounts[$levelName]++;
                        $totalCounts[$levelName]++;
                    }
                }
            }
          @endphp

          <tr>
            <td>{{ $division->name }}</td>
            @foreach ($uniqueLevels as $level)
              <td>{{ $levelCounts[$level] }}</td>
            @endforeach
          </tr>
        @endforeach

        <!-- Division Total Row -->
        <tr>
          <td style=" font-weight: bold; text-align: left;">Total ({{ $directorate->name }}):</td>
          @foreach ($uniqueLevels as $level)
            <td style=" font-weight: bold;">{{ $divisionTotalCounts[$level] }}</td>
          @endforeach
        </tr>
      @endforeach

      <!-- Directorate Total Row -->
      <tr>
        <td style=" font-weight: bold; text-align: left;">Total Semua:</td>
        @foreach ($uniqueLevels as $level)
          <td style=" font-weight: bold; ">{{ $totalCounts[$level] }}</td>
        @endforeach
      </tr>
    @empty
      <tr>
        <td colspan="{{ 1 + $uniqueLevels->count() }}" class="text-center font-weight-bold">
          No data available
        </td>
      </tr>
    @endforelse
  </tbody>
</table> --}}

<table>
  <thead>
    <tr>
      <th style="width: 50; background-color: #b5b5b5b5">Directorate</th>
      <th style="width: 30;background-color: #b5b5b5b5">Division</th>
      <th style="width: 30;background-color: #b5b5b5b5">NIK</th>
      <th style="width: 30;background-color: #b5b5b5b5">Nama Karyawan</th>
      <th style="width: 30;background-color: #b5b5b5b5">Level Jabatan</th>
      <th style="width: 30;background-color: #b5b5b5b5">Jabatan</th>
      <th style="width: 30;background-color: #b5b5b5b5">Kategori Karyawan</th>
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
                      ];
                  }
              }
          }
      }

      // Sort the employees array by gender (assuming you want 'LAKI-LAKI' first)
      usort($employees, function ($a, $b) {
          return $a['level'] <=> $b['level'];
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
      </tr>
    @endforeach
  </tbody>
</table>
