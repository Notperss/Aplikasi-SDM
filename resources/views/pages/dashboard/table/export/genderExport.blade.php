<table>
  <thead>
    <tr>
      <th style="width: 30; background-color: #b5b5b5b5">Directorate</th>
      <th style="width: 30; background-color: #b5b5b5b5">Division</th>
      <th style="width: 30; background-color: #b5b5b5b5">Total Karyawan</th>
      <th style="width: 20; background-color: #b5b5b5b5">Male Employees</th>
      <th style="width: 20; background-color: #b5b5b5b5">Female Employees</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($directorates as $directorate)
      @php
        $total = 0;
        $totalMale = 0;
        $totalFemale = 0;
      @endphp
      <tr>
        <td colspan="4" style="font-weight: bold; text-align: center;">
          {{ $directorate->name }}
        </td>
      </tr>
      @foreach ($directorate->divisions as $division)
        @php
          $totalCount = $division->positions->sum(function ($position) {
              return optional($position->employee)->employee_status === 'AKTIF' ? 1 : 0;
          });
          $maleCount = $division->positions->sum(function ($position) {
              return optional($position->employee)->employee_status === 'AKTIF' &&
                  optional($position->employee)->gender === 'LAKI-LAKI'
                  ? 1
                  : 0;
          });

          $femaleCount = $division->positions->sum(function ($position) {
              return optional($position->employee)->employee_status === 'AKTIF' &&
                  optional($position->employee)->gender === 'PEREMPUAN'
                  ? 1
                  : 0;
          });

          $total += $totalCount;
          $totalMale += $maleCount;
          $totalFemale += $femaleCount;

        @endphp
        <tr>
          <td></td>
          <td>{{ $division->name }}</td>
          <td>{{ $totalCount }}</td>
          <td>{{ $maleCount }}</td>
          <td>{{ $femaleCount }}</td>
        </tr>
      @endforeach
      <tr>
        <td>Total {{ $directorate->name }}</td>
        <td></td>
        <td>{{ $total }}</td>
        <td>{{ $totalMale }}</td>
        <td>{{ $totalFemale }}</td>
      </tr>
    @endforeach
  </tbody>
</table>

<table>
  <thead>
    <tr>
      <th style="width: 30; background-color: #b5b5b5b5">Unit Kerja</th>
      <th style="width: 10;background-color: #b5b5b5b5">Total Karyawan</th>
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
        <th style="background-color: #d0fbff9d">{{ $category }}</th>
        <th style="background-color: #b5b5b5b5">LAKI-LAKI</th>
        <th style="background-color: #b5b5b5b5">PEREMPUAN</th>
      @endforeach
    </tr>
  </thead>
  <tbody>
    @php
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
        <td colspan="{{ 2 + $uniqueCategories->count() * 2 }}" style="font-weight: bold; text-align: left;">
          {{ $isNon == 1 ? 'DIREKTORAT' : ($isNon == 2 ? 'NON-DIREKTORAT' : 'LAIN-LAIN') }}
        </td>
      </tr>

      @php
        $totalCounts = [];
        foreach ($uniqueCategories as $category) {
            $totalCounts[$category] = ['total' => 0, 'laki' => 0, 'perempuan' => 0];
        }
      @endphp

      @foreach ($directoratesGroup as $directorate)
        @php
          // Initialize counts for this directorate
          $categoryCounts = [];
          foreach ($uniqueCategories as $category) {
              $categoryCounts[$category] = ['total' => 0, 'laki' => 0, 'perempuan' => 0];
          }

          // Count employees per category and gender
          foreach ($directorate->divisions as $division) {
              foreach ($division->positions as $position) {
                  $employee = $position->employee;
                  if ($employee && $employee->employee_status === 'AKTIF') {
                      $categoryName = optional($employee->employeeCategory)->name;
                      if ($categoryName && isset($categoryCounts[$categoryName])) {
                          $categoryCounts[$categoryName]['total']++;
                          if ($employee->gender == 'LAKI-LAKI') {
                              $categoryCounts[$categoryName]['laki']++;
                          } elseif ($employee->gender == 'PEREMPUAN') {
                              $categoryCounts[$categoryName]['perempuan']++;
                          }
                          // Update the total counts
                          $totalCounts[$categoryName]['total']++;
                          if ($employee->gender == 'LAKI-LAKI') {
                              $totalCounts[$categoryName]['laki']++;
                          } elseif ($employee->gender == 'PEREMPUAN') {
                              $totalCounts[$categoryName]['perempuan']++;
                          }
                      }
                  }
              }
          }
        @endphp
        <tr>
          <td class="text-bold-500">{{ $directorate->name }}</td>
          <td class="text-bold-500">{{ array_sum(array_column($categoryCounts, 'total')) }}</td>
          @foreach ($uniqueCategories as $category)
            <td>{{ $categoryCounts[$category]['total'] }}</td>
            <td>{{ $categoryCounts[$category]['laki'] }}</td>
            <td>{{ $categoryCounts[$category]['perempuan'] }}</td>
          @endforeach
        </tr>
      @endforeach

      <!-- Total Row -->
      <tr>
        <td class="text-bold-500 text-center" style="background-color: #c4baba">Total :</td>
        <td class="text-bold-500">{{ array_sum(array_column($totalCounts, 'total')) }}</td>
        @foreach ($uniqueCategories as $category)
          <td class="text-bold-500">{{ $totalCounts[$category]['total'] }}</td>
          <td class="text-bold-500">{{ $totalCounts[$category]['laki'] }}</td>
          <td class="text-bold-500">{{ $totalCounts[$category]['perempuan'] }}</td>
        @endforeach
      </tr>
    @empty
      <tr>
        <td class="text-bold-500 text-center" colspan="{{ 2 + $uniqueCategories->count() * 2 }}">
          No data available in table
        </td>
      </tr>
    @endforelse
  </tbody>
</table>

<table>
  <thead>
    <tr>
      <th style="width: 30; background-color: #b5b5b5b5">Directorate</th>
      <th style="width: 30;background-color: #b5b5b5b5">Division</th>
      <th style="width: 30;background-color: #b5b5b5b5">NIK</th>
      <th style="width: 30;background-color: #b5b5b5b5">Nama Karyawan</th>
      <th style="width: 30;background-color: #b5b5b5b5">Jabatan</th>
      <th style="width: 30;background-color: #b5b5b5b5">Kategori Karyawan</th>
      <th style="width: 30;background-color: #b5b5b5b5">Jenis Kelamin</th>
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
                          'position' => $position->name,
                          'category' => optional($employee->employeeCategory)->name,
                          'gender' => $employee->gender,
                      ];
                  }
              }
          }
      }

      // Sort the employees array by gender (assuming you want 'LAKI-LAKI' first)
      usort($employees, function ($a, $b) {
          return $a['gender'] <=> $b['gender'];
      });
    @endphp

    @foreach ($employees as $employee)
      <tr>
        <td>{{ $employee['directorate'] }}</td>
        <td>{{ $employee['division'] }}</td>
        <td>{{ $employee['nik'] }}</td>
        <td>{{ $employee['name'] }}</td>
        <td>{{ $employee['position'] }}</td>
        <td>{{ $employee['category'] }}</td>
        <td>{{ $employee['gender'] }}</td>
      </tr>
    @endforeach
  </tbody>
</table>



{{-- <table>
  <thead>
    <tr>
     
      <th>Directorate</th>
      <th>Division</th>
      <th>Employee Name</th>
      <th>Gender</th>
      <th>Position</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($directorates as $directorate)
      @foreach ($directorate->divisions as $division)
        @foreach ($division->positions as $index => $position)
          @if ($position->employee && $position->employee->employee_status === 'AKTIF' && $position->employee->gender !== null)
            <!-- Check if gender is not null -->
            <tr>
             
              <td>{{ $directorate->name }}</td>
              <td>{{ $division->name }}</td>
              <td>{{ $position->employee->name }}</td>
              <td>{{ $position->employee->gender }}</td>
              <td>{{ $position->name }}</td>
            </tr>
          @endif
        @endforeach
      @endforeach
    @endforeach


  </tbody>
</table> --}}