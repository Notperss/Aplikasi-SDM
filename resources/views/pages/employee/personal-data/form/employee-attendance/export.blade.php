<table>
  <thead>
    <tr>
      <th colspan="13" scope="col" style="text-align: center;">
        Absen Karyawan
        {{ $employeeName ?? '-' }} ({{ $nik ?? '-' }})
      </th>

    </tr>

    <tr>
      <th colspan="13" scope="col" style="text-align: center;">
        PERIODE:
        {{ Carbon\Carbon::parse($selectedYear . '-' . $selectedMonth . '-01')->translatedFormat('F') }}
        {{ $selectedYear }}
      </th>
    </tr>
    <tr>
      <th scope="col" style="background: #7ae4fe; font-weight:bold; width: 30;text-align: center;">#</th>
      <th scope="col" style="background: #7ae4fe; font-weight:bold+; width: 30;text-align: center;">NIK</th>
      <th scope="col" style="background: #7ae4fe; font-weight:bold+; width: 30;text-align: center;">Check In Time
      </th>
      <th scope="col" style="background: #7ae4fe; font-weight:bold; width: 30;text-align: center;">Check Out Time
      </th>
      <th scope="col" style="background: #7ae4fe; font-weight:bold; width: 30;text-align: center;">Clock In</th>
      <th scope="col" style="background: #7ae4fe; font-weight:bold; width: 30;text-align: center;">Clock Out</th>
      <th scope="col" style="background: #7ae4fe; font-weight:bold; width: 30;text-align: center;">Working Type</th>
      <th scope="col" style="background: #7ae4fe; font-weight:bold; width: 30;text-align: center;">Status</th>
      <th scope="col" style="background: #7ae4fe; font-weight:bold; width: 30;text-align: center;">Late</th>
      <th scope="col" style="background: #7ae4fe; font-weight:bold; width: 30;text-align: center;">Date</th>
      <th scope="col" style="background: #7ae4fe; font-weight:bold; width: 30;text-align: center;">Working Hours</th>
    </tr>
  </thead>
  {{-- <tbody>
    @php
      $contractsByDivision = $contractsExpired->groupBy('employee.position.division.name');
    @endphp

    @foreach ($contractsByDivision as $division => $contracts)
      <tr>
        <td colspan="13" style="font-weight: 600" class="float-left">{{ $loop->iteration }}.
          {{ $division ?? 'Unknown Division' }}</td>
      </tr>
      @foreach ($contracts as $contract)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $contract->contract_number }}</td>
          <td>{{ $contract->employee->nik }}</td>
          @php
            if ($contract->employee->dob) {
                $dob = Carbon\Carbon::parse($contract->employee->dob);
                $now = Carbon\Carbon::now();

                $ageYears = $dob->age;
                $ageMonths = $dob->diffInMonths($now) % 12;
            }

            $accumulatedDurationInMonths = $contract
                ->where('employee_id', $contract->employee->id)
                ->whereYear('end_date', '<=', $selectedYear) // Include only contracts up to the current one
                ->whereMonth('end_date', '<=', $selectedMonth) // Include only contracts up to the current one
                ->sum('duration');

            // Convert months to years and months
            $years = intdiv($accumulatedDurationInMonths, 12); // Full years
            $months = $accumulatedDurationInMonths % 12; // Remaining months

            // Format as "X Tahun Y Bulan"
            $accumulatedDuration = ($years > 0 ? $years . ' Tahun ' : '') . ($months > 0 ? $months . ' Bulan' : '');

          @endphp
          <td>{{ $contract->employee->name }}</td>
          <td>{{ $ageYears }} Tahun, {{ $ageMonths }} Bulan</td>
          <td>{{ $contract->employee->pob }},
            {{ Carbon\Carbon::parse($contract->employee->dob)->translatedFormat('d-m-Y') }}</td>
          <td>{{ $contract->employee->current_address }}</td>
          <td>{{ $contract->employee->position->name }}</td>
          <td>{{ $contract->employee->position->division->name }}</td>
          <td>{{ Carbon\Carbon::parse($contract->employee->date_joining)->translatedFormat('d-m-Y') }}</td>
          <td>
            {{ Carbon\Carbon::parse($contract->start_date)->translatedFormat('d-m-Y') }} -
            {{ Carbon\Carbon::parse($contract->end_date)->translatedFormat('d-m-Y') }}</td>
          <td>{{ $contract->contract_sequence_number }}</td>
          <td>{{ $accumulatedDuration }}</td>
        </tr>
      @endforeach
    @endforeach
  </tbody> --}}

  @forelse ($employeeAttendances as $employeeAttendance)
    <tr>
      <td class="text-bold-500">{{ $loop->iteration }}</td>
      <td class="text-bold-500">{{ $employeeAttendance->nik }}</td>
      <td class="text-bold-500">{{ $employeeAttendance->check_in_time }}</td>
      <td class="text-bold-500">{{ $employeeAttendance->check_out_time }}</td>
      <td class="text-bold-500">{{ $employeeAttendance->clock_in }}</td>
      <td class="text-bold-500">{{ $employeeAttendance->clock_out }}</td>
      <td class="text-bold-500">{{ $employeeAttendance->working_type }}</td>
      <td class="text-bold-500">{{ $employeeAttendance->status }}</td>
      <td class="text-bold-500">{{ $employeeAttendance->late }}</td>
      <td class="text-bold-500">{{ Carbon\Carbon::parse($employeeAttendance->date)->translatedFormat('d M Y') }}
      </td>
      <td class="text-bold-500">{{ $employeeAttendance->working_hours }}</td>
    </tr>
  @empty
    <tr>
      <td class="text-bold-500 text-center" colspan="10">No data available in table</td>
    </tr>
  @endforelse
</table>
