@php
  // Collect all unique employee categories across all directorates for AKTIF employees
  $categories = $directorates
      ->flatMap(function ($directorate) {
          return $directorate->divisions->flatMap(function ($division) {
              return $division->positions->map(function ($position) {
                  $employee = $position->employee;
                  return $employee && $employee->employee_status === 'AKTIF'
                      ? optional($employee->employeeCategory)->name
                      : null;
              });
          });
      })
      ->unique()
      ->filter();
@endphp

<table>
  <thead>
    <tr>
      <th style="width: 30; background-color: #b5b5b5b5">Directorate</th>
      <th style="width: 30; background-color: #b5b5b5b5">Division</th>
      <th style="width: 30; background-color: #b5b5b5b5">Total Karyawan</th>
      {{-- <th style="width: 30">Total Positions with Employees</th> --}}
      @foreach ($categories as $category)
        <th style="width: 30; background-color: #b5b5b5b5">{{ $category }}</th>
      @endforeach
    </tr>
  </thead>
  <tbody>
    @php
      $totalCategoryCounts = array_fill_keys($categories->toArray(), 0);
      $totalPositionsWithEmployees = 0;
      $grandTotalEmployees = 0;
    @endphp

    @foreach ($directorates as $directorate)
      <tr>
        <td colspan="{{ 3 + $categories->count() }}" style="font-weight: bold;">{{ $directorate->name }}</td>
      </tr>
      @foreach ($directorate->divisions as $division)
        <tr>
          <td></td>
          <td>{{ $division->name }}</td>
          @php
            // Count positions with employees
            $positionsWithEmployees = $division->positions
                ->filter(function ($position) {
                    return $position->employee !== null && $position->employee->employee_status === 'AKTIF';
                })
                ->count();

            // Count AKTIF employees by category for this division
            $categoryCounts = $division->positions
                ->groupBy(function ($position) {
                    $employee = $position->employee;
                    return $employee && $employee->employee_status === 'AKTIF'
                        ? optional($employee->employeeCategory)->name
                        : null;
                })
                ->map->count();

            // Calculate total employees for this division
            // $totalEmployees = array_sum($categoryCounts->toArray());
            // $grandTotalEmployees += $totalEmployees;

            // Update totals
            $totalPositionsWithEmployees += $positionsWithEmployees;

            foreach ($categories as $category) {
                $totalCategoryCounts[$category] += $categoryCounts[$category] ?? 0;
            }
          @endphp
          <td>{{ $positionsWithEmployees }}</td>
          {{-- <td>{{ $totalEmployees }}</td> --}}

          @foreach ($categories as $category)
            <td>{{ $categoryCounts[$category] ?? 0 }}</td>
          @endforeach
        </tr>
      @endforeach
    @endforeach

    <tr>
      <td colspan="2" style="font-weight: bold; text-align: right;">Total:</td>
      <td style="font-weight: bold;">{{ $totalPositionsWithEmployees }}</td>
      {{-- <td style="font-weight: bold;">{{ $grandTotalEmployees }}</td> --}}
      @foreach ($categories as $category)
        <td style="font-weight: bold;">{{ $totalCategoryCounts[$category] }}</td>
      @endforeach
    </tr>
  </tbody>
</table>

{{-- <table>
  <thead>
    <tr>
      <th style="width: 30;background-color: #b5b5b5b5">Directorate</th>
      <th style="width: 30;background-color: #b5b5b5b5">Division</th>
      <th style="width: 30;background-color: #b5b5b5b5">NIK</th>
      <th style="width: 30;background-color: #b5b5b5b5">Nama Karyawan</th>
      <th style="width: 30;background-color: #b5b5b5b5">Jabatan</th>
      <th style="width: 30;background-color: #b5b5b5b5">Kategori Karyawan</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($directorates as $directorate)
      @foreach ($directorate->divisions as $division)
        @foreach ($division->positions as $position)
          @php
            $employee = $position->employee;
          @endphp
          @if ($employee && $employee->employee_status === 'AKTIF')
            <tr>
              <td>{{ $directorate->name }}</td>
              <td>{{ $division->name }}</td>
              <td>{{ $employee->nik }}</td>
              <td>{{ $employee->name }}</td>
              <td>{{ $position->name }}</td>
              <td>{{ optional($employee->employeeCategory)->name }}</td>
            </tr>
          @endif
        @endforeach
      @endforeach
    @endforeach
  </tbody>
</table> --}}

<table>
  <thead>
    <tr>
      <th style="width: 30;background-color: #b5b5b5b5">Directorate</th>
      <th style="width: 30;background-color: #b5b5b5b5">Division</th>
      <th style="width: 30;background-color: #b5b5b5b5">NIK</th>
      <th style="width: 30;background-color: #b5b5b5b5">Nama Karyawan</th>
      <th style="width: 30;background-color: #b5b5b5b5">Jabatan</th>
      <th style="width: 30;background-color: #b5b5b5b5">Kategori Karyawan</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($directorates as $directorate)
      @foreach ($directorate->divisions as $division)
        @php
          // Collect and sort employees by category
          $sortedEmployees = $division->positions
              ->filter(fn($position) => $position->employee && $position->employee->employee_status === 'AKTIF')
              ->sortBy(fn($position) => optional($position->employee->employeeCategory)->name);
        @endphp

        @foreach ($sortedEmployees as $position)
          @php
            $employee = $position->employee;
          @endphp
          <tr>
            <td>{{ $directorate->name }}</td>
            <td>{{ $division->name }}</td>
            <td>{{ $employee->nik }}</td>
            <td>{{ $employee->name }}</td>
            <td>{{ $position->name }}</td>
            <td>{{ optional($employee->employeeCategory)->name }}</td>
          </tr>
        @endforeach
      @endforeach
    @endforeach
  </tbody>
</table>
