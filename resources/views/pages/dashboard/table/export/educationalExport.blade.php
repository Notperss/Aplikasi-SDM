<table>
  <thead>
    <tr>
      <th style="width: 30; background-color: #bfbfbf">Directorate</th>
      <th style="width: 30; background-color: #bfbfbf">Division</th>
      <th style="width: 6; background-color: #bfbfbf">SD</th>
      <th style="width: 6; background-color: #bfbfbf">SMP</th>
      <th style="width: 6; background-color: #bfbfbf">SMA</th>
      <th style="width: 6; background-color: #bfbfbf">MA</th>
      <th style="width: 6; background-color: #bfbfbf">MTS</th>
      <th style="width: 6; background-color: #bfbfbf">SMK</th>
      <th style="width: 6; background-color: #bfbfbf">D-1</th>
      <th style="width: 6; background-color: #bfbfbf">D-2</th>
      <th style="width: 6; background-color: #bfbfbf">D-3</th>
      <th style="width: 6; background-color: #bfbfbf">D-4</th>
      <th style="width: 6; background-color: #bfbfbf">S-1</th>
      <th style="width: 6; background-color: #bfbfbf">S-2</th>
      <th style="width: 6; background-color: #bfbfbf">S-3</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($directorates as $directorate)
      <tr>
        <td colspan="14" style="font-weight: bold; text-align: left;">
          {{ $directorate->name }}
        </td>
      </tr>

      @php
        $totalEducationCounts = [
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

      @foreach ($directorate->divisions as $division)
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

          // Count employees based on education level
          foreach ($division->positions as $position) {
              if ($position->employee && $position->employee->employee_status === 'AKTIF') {
                  $educationLevel = $position->employee->last_educational;
                  if (array_key_exists($educationLevel, $educationCounts)) {
                      $educationCounts[$educationLevel]++;
                      $totalEducationCounts[$educationLevel]++;
                  }
              }
          }
        @endphp

        <tr>
          <td></td>
          <td>{{ $division->name }}</td>
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

      <!-- Total row for Directorate -->
      <tr>
        <td colspan="2" style="font-weight: bold; text-align: right;">Total :</td>
        <td>{{ $totalEducationCounts['SD'] }}</td>
        <td>{{ $totalEducationCounts['SMP'] }}</td>
        <td>{{ $totalEducationCounts['SMA'] }}</td>
        <td>{{ $totalEducationCounts['MA'] }}</td>
        <td>{{ $totalEducationCounts['MTS'] }}</td>
        <td>{{ $totalEducationCounts['SMK'] }}</td>
        <td>{{ $totalEducationCounts['D-1'] }}</td>
        <td>{{ $totalEducationCounts['D-2'] }}</td>
        <td>{{ $totalEducationCounts['D-3'] }}</td>
        <td>{{ $totalEducationCounts['D-4'] }}</td>
        <td>{{ $totalEducationCounts['S-1'] }}</td>
        <td>{{ $totalEducationCounts['S-2'] }}</td>
        <td>{{ $totalEducationCounts['S-3'] }}</td>
      </tr>
    @endforeach
  </tbody>
</table>

<table>
  <tr>
    <td style="font-size: 24px; background-color: #a5a4a4">OFFICE</td>
  </tr>
  <thead>
    <tr>
      <th style="width: 30; background-color: #bfbfbf">Directorate</th>
      <th style="width: 30; background-color: #bfbfbf">Division</th>
      <th style="width: 6; background-color: #bfbfbf">SD</th>
      <th style="width: 6; background-color: #bfbfbf">SMP</th>
      <th style="width: 6; background-color: #bfbfbf">SMA</th>
      <th style="width: 6; background-color: #bfbfbf">MA</th>
      <th style="width: 6; background-color: #bfbfbf">MTS</th>
      <th style="width: 6; background-color: #bfbfbf">SMK</th>
      <th style="width: 6; background-color: #bfbfbf">D-1</th>
      <th style="width: 6; background-color: #bfbfbf">D-2</th>
      <th style="width: 6; background-color: #bfbfbf">D-3</th>
      <th style="width: 6; background-color: #bfbfbf">D-4</th>
      <th style="width: 6; background-color: #bfbfbf">S-1</th>
      <th style="width: 6; background-color: #bfbfbf">S-2</th>
      <th style="width: 6; background-color: #bfbfbf">S-3</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($directorates as $directorate)
      <tr>
        <td colspan="14" style="font-weight: bold; text-align: left;">
          {{ $directorate->name }}
        </td>
      </tr>

      @php
        $totalEducationCounts = [
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

      @foreach ($directorate->divisions as $division)
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

          // Count employees based on education level
          foreach ($division->positions as $position) {
              if (
                  $position->employee &&
                  $position->employee->employee_status === 'AKTIF' &&
                  $position->employee->employeeCategory->name === 'OFFICE'
              ) {
                  $educationLevel = $position->employee->last_educational;
                  if (array_key_exists($educationLevel, $educationCounts)) {
                      $educationCounts[$educationLevel]++;
                      $totalEducationCounts[$educationLevel]++;
                  }
              }
          }
        @endphp

        <tr>
          <td></td>
          <td>{{ $division->name }}</td>
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

      <!-- Total row for Directorate -->
      <tr>
        <td colspan="2" style="font-weight: bold; text-align: right;">Total :</td>
        <td>{{ $totalEducationCounts['SD'] }}</td>
        <td>{{ $totalEducationCounts['SMP'] }}</td>
        <td>{{ $totalEducationCounts['SMA'] }}</td>
        <td>{{ $totalEducationCounts['MA'] }}</td>
        <td>{{ $totalEducationCounts['MTS'] }}</td>
        <td>{{ $totalEducationCounts['SMK'] }}</td>
        <td>{{ $totalEducationCounts['D-1'] }}</td>
        <td>{{ $totalEducationCounts['D-2'] }}</td>
        <td>{{ $totalEducationCounts['D-3'] }}</td>
        <td>{{ $totalEducationCounts['D-4'] }}</td>
        <td>{{ $totalEducationCounts['S-1'] }}</td>
        <td>{{ $totalEducationCounts['S-2'] }}</td>
        <td>{{ $totalEducationCounts['S-3'] }}</td>
      </tr>
    @endforeach
  </tbody>
</table>

<table>
  <tr>
    <td style="font-size: 24px; background-color: #a5a4a4">NON-OFFICE</td>
  </tr>
  <thead>
    <tr>
      <th style="width: 30; background-color: #bfbfbf">Directorate</th>
      <th style="width: 30; background-color: #bfbfbf">Division</th>
      <th style="width: 6; background-color: #bfbfbf">SD</th>
      <th style="width: 6; background-color: #bfbfbf">SMP</th>
      <th style="width: 6; background-color: #bfbfbf">SMA</th>
      <th style="width: 6; background-color: #bfbfbf">MA</th>
      <th style="width: 6; background-color: #bfbfbf">MTS</th>
      <th style="width: 6; background-color: #bfbfbf">SMK</th>
      <th style="width: 6; background-color: #bfbfbf">D-1</th>
      <th style="width: 6; background-color: #bfbfbf">D-2</th>
      <th style="width: 6; background-color: #bfbfbf">D-3</th>
      <th style="width: 6; background-color: #bfbfbf">D-4</th>
      <th style="width: 6; background-color: #bfbfbf">S-1</th>
      <th style="width: 6; background-color: #bfbfbf">S-2</th>
      <th style="width: 6; background-color: #bfbfbf">S-3</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($directorates as $directorate)
      <tr>
        <td colspan="14" style="font-weight: bold; text-align: left;">
          {{ $directorate->name }}
        </td>
      </tr>

      @php
        $totalEducationCounts = [
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

      @foreach ($directorate->divisions as $division)
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

          // Count employees based on education level
          foreach ($division->positions as $position) {
              if (
                  $position->employee &&
                  $position->employee->employee_status === 'AKTIF' &&
                  $position->employee->employeeCategory->name === 'NON-OFFICE'
              ) {
                  $educationLevel = $position->employee->last_educational;
                  if (array_key_exists($educationLevel, $educationCounts)) {
                      $educationCounts[$educationLevel]++;
                      $totalEducationCounts[$educationLevel]++;
                  }
              }
          }
        @endphp

        <tr>
          <td></td>
          <td>{{ $division->name }}</td>
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

      <!-- Total row for Directorate -->
      <tr>
        <td colspan="2" style="font-weight: bold; text-align: right;">Total :</td>
        <td>{{ $totalEducationCounts['SD'] }}</td>
        <td>{{ $totalEducationCounts['SMP'] }}</td>
        <td>{{ $totalEducationCounts['SMA'] }}</td>
        <td>{{ $totalEducationCounts['MA'] }}</td>
        <td>{{ $totalEducationCounts['MTS'] }}</td>
        <td>{{ $totalEducationCounts['SMK'] }}</td>
        <td>{{ $totalEducationCounts['D-1'] }}</td>
        <td>{{ $totalEducationCounts['D-2'] }}</td>
        <td>{{ $totalEducationCounts['D-3'] }}</td>
        <td>{{ $totalEducationCounts['D-4'] }}</td>
        <td>{{ $totalEducationCounts['S-1'] }}</td>
        <td>{{ $totalEducationCounts['S-2'] }}</td>
        <td>{{ $totalEducationCounts['S-3'] }}</td>
      </tr>
    @endforeach
  </tbody>
</table>

<table>
  <thead>
    <tr>
      <th style="width: 30; background-color: #b5b5b5b5">Directorate</th>
      <th style="width: 30;background-color: #b5b5b5b5">Division</th>
      <th style="width: 10;background-color: #b5b5b5b5">NIK</th>
      <th style="width: 10;background-color: #b5b5b5b5">Nama Karyawan</th>
      <th style="width: 10;background-color: #b5b5b5b5">Jabatan</th>
      <th style="width: 10;background-color: #b5b5b5b5">Kategori Karyawan</th>
      <th style="width: 10;background-color: #b5b5b5b5">Pendidikan Terakhir</th>
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
                          'last_educational' => $employee->last_educational,
                      ];
                  }
              }
          }
      }

      // Sort the employees array by gender (assuming you want 'LAKI-LAKI' first)
      usort($employees, function ($a, $b) {
          return $a['last_educational'] <=> $b['last_educational'];
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
        <td>{{ $employee['last_educational'] }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
