{{-- <table class="table" id="table10" style="font-size: 80%">
  <thead>
    <tr>
      <th scope="col" style="width: 5%">#</th>
      <th scope="col"></th>
      <th scope="col">NIK</th>
      <th scope="col">Nama</th>
      <th scope="col">No. Kontrak</th>
      <th scope="col">Tgl Mulai</th>
      <th scope="col">Tgl Berakhir</th>
      <th scope="col">Durasi</th>
      <th scope="col">Kontrak Ke- </th>
      <th scope="col">Divisi</th>
    </tr>
  </thead>
  <tbody>
    @forelse ($contractsExpired as $contract)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>
          @if ($contract->employee->photo)
            <div class="fixed-frame">
              <img src="{{ asset('storage/' . $contract->employee->photo) }}" data-fancybox alt="Icon User"
                class="framed-image" style="cursor: pointer">
            </div>
          @else
            <div class="fixed-frame">
              No Image
            </div>
          @endif
        </td>
        <td>
          {{ $contract->employee->nik ?? 'N/A' }}
        </td>
        <td>
          {{ $contract->employee->name ?? 'N/A' }}
        </td>
        <td>
          {{ $contract->contract_number ?? 'N/A' }}
        </td>
        <td>
          {{ Carbon\Carbon::parse($contract->start_date)->translatedFormat('d-m-Y') ?? 'N/A' }}
        </td>
        <td>
          {{ Carbon\Carbon::parse($contract->end_date)->translatedFormat('d-m-Y') ?? 'N/A' }}
        </td>
        <td>
          {{ $contract->duration ?? 'N/A' }} Bulan
        </td>
        <td>
          {{ $contract->contract_sequence_number ?? 'N/A' }}
        </td>
        <td>{{ $contract->employee->position->division->code ?? 'N/A' }}</td>

      </tr>
    @empty
      <tr>
        <td class="text-center" colspan="10">No data available in table</td>
      </tr>
    @endforelse
  </tbody>
</table> --}}

<div class="table-responsive">
  <table class="table table-sm" style="font-size: 80%" style="margin: 0;">
    <thead>
      <tr>
        <th>#</th>
        <th>Check In Time</th>
        <th>Check Out Time</th>
        <th>Clock In</th>
        <th>Clock Out</th>
        <th>Working Type</th>
        <th>Status</th>
        <th>Late</th>
        <th>Date</th>
        <th>Working Hours</th>
      </tr>
    </thead>
    <tbody>
      {{-- @php
        $filteredAttendances = $employee->employeeAttendances->filter(function ($attendance) {
            $selectedMonth = request('month');
            $selectedYear = request('year');

            return $attendance->check_in_time &&
                Carbon\Carbon::parse($attendance->check_in_time)->month == $selectedMonth &&
                Carbon\Carbon::parse($attendance->check_in_time)->year == $selectedYear;
        });
      @endphp --}}

      @forelse ($employeeAttendances as $employeeAttendance)
        <tr>
          <td class="text-bold-500">{{ $loop->iteration }}</td>
          <td class="text-bold-500">{{ $employeeAttendance->check_in_time }}</td>
          <td class="text-bold-500">{{ $employeeAttendance->check_out_time }}</td>
          <td class="text-bold-500">{{ $employeeAttendance->clock_in }}</td>
          <td class="text-bold-500">{{ $employeeAttendance->clock_out }}</td>
          <td class="text-bold-500">{{ $employeeAttendance->working_type }}</td>
          <td class="text-bold-500">{{ $employeeAttendance->status }}</td>
          <td class="text-bold-500">{{ $employeeAttendance->late }}</td>
          <td class="text-bold-500">{{ Carbon\Carbon::parse($employeeAttendance->date)->translatedFormat('d-m-Y') }}
          </td>
          <td class="text-bold-500">{{ $employeeAttendance->working_hours }}</td>
        </tr>
      @empty
        <tr>
          <td class="text-bold-500 text-center" colspan="10">No data available in table</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
