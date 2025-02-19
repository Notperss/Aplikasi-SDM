<table>
  <thead>
    {{-- <tr>
      <th colspan="13" scope="col" style="text-align: center;">SPKWT BERAKHIR</th>
    </tr>

    <tr>
      <th colspan="13" scope="col" style="text-align: center;">
        PERIODE:
        {{ Carbon\Carbon::parse($selectedYear . '-' . $selectedMonth . '-01')->translatedFormat('F') }}
        {{ $selectedYear }}
      </th>
    </tr> --}}

    <tr>
      <th scope="col" style="background: #7ae4fe; font-weight:bold;width: 5;text-align: center;">#</th>
      <th scope="col" style="background: #7ae4fe; font-weight:bold; width: 30;text-align: center;">NO. KONTRAK</th>
      <th scope="col" style="background: #7ae4fe; font-weight:bold; width: 15;text-align: center;">NIK</th>
      <th scope="col" style="background: #7ae4fe; font-weight:bold; width: 30;text-align: center;">NAMA</th>
      <th scope="col" style="background: #7ae4fe; font-weight:bold; width: 20;text-align: center;">USIA</th>
      <th scope="col" style="background: #7ae4fe; font-weight:bold; width: 27;text-align: center;">TEMPAT, TANGGAL
        LAHIR</th>
      <th scope="col" style="background: #7ae4fe; font-weight:bold; width: 30;text-align: center;">ALAMAT</th>
      <th scope="col" style="background: #7ae4fe; font-weight:bold; width: 20;text-align: center;">JABATAN</th>
      <th scope="col" style="background: #7ae4fe; font-weight:bold; width: 30;text-align: center;">DIVISI</th>
      <th scope="col" style="background: #7ae4fe; font-weight:bold; width: 20;text-align: center;">TMT MASUK KERJA
      </th>
      <th scope="col" style="background: #7ae4fe; font-weight:bold; width: 15;text-align: center;">DURASI</th>
      <th scope="col" style="background: #7ae4fe; font-weight:bold; width: 15;text-align: center;">KONTRAK KE</th>
      <th scope="col" style="background: #7ae4fe; font-weight:bold; width: 20;text-align: center;">TANGGAL MULAI
      </th>
      <th scope="col" style="background: #7ae4fe; font-weight:bold; width: 20;text-align: center;">TANGGAL AKHIR
      </th>
      <th scope="col" style="background: #7ae4fe; font-weight:bold; width: 7;text-align: center;">PK
      </th>
      <th scope="col" style="background: #7ae4fe; font-weight:bold; width: 30;text-align: center;">REKOMENDASI
        KONTRAK</th>
      <th scope="col" style="background: #7ae4fe; font-weight:bold; width: 30;text-align: center;">AKUMULASI MASA
        KERJA</th>
      {{-- <th scope="col" style="background: #7ae4fe; font-weight:bold; width: 30;text-align: center;">AKUMULASI MASA
        KERJA</th> --}}
    </tr>
  </thead>
  <tbody>
    @php
      $contractsByDivision = $contracts->groupBy('employee.position.division.name');
    @endphp

    @foreach ($contractsByDivision as $division => $contracts)
      <tr>
        <td colspan="15" style="font-weight: 600" class="float-left">{{ $loop->iteration }}.
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

            // $accumulatedDurationInMonths = $contract
            //     ->where('employee_id', $contract->employee->id)
            //     ->whereYear('end_date', '<=', $selectedYear) // Include only contracts up to the current one
            //     ->whereMonth('end_date', '<=', $selectedMonth) // Include only contracts up to the current one
            //     ->sum('duration');

            // Convert months to years and months
            // $years = intdiv($accumulatedDurationInMonths, 12); // Full years
            // $months = $accumulatedDurationInMonths % 12; // Remaining months

            // // Format as "X Tahun Y Bulan"
            // $accumulatedDuration = ($years > 0 ? $years . ' Tahun ' : '') . ($months > 0 ? $months . ' Bulan' : '');

          @endphp
          <td>{{ $contract->employee->name }}</td>
          <td>{{ $ageYears }} Tahun, {{ $ageMonths }} Bulan</td>
          <td>{{ $contract->employee->pob }},
            {{ Carbon\Carbon::parse($contract->employee->dob)->translatedFormat('d-m-Y') }}</td>
          <td>{{ $contract->employee->current_address }}</td>
          <td>{{ $contract->employee->position->name }}</td>
          <td>{{ $contract->employee->position->division->name }}</td>
          <td>{{ Carbon\Carbon::parse($contract->employee->date_joining)->translatedFormat('d-m-Y') }}</td>
          <td style="text-align: center">{{ $contract->duration }}</td>
          <td style="text-align: center">{{ $contract->contract_sequence_number }}</td>
          <td>
            {{ Carbon\Carbon::parse($contract->start_date)->translatedFormat('d-m-Y') }}</td>
          <td>
            {{ Carbon\Carbon::parse($contract->end_date)->translatedFormat('d-m-Y') }}</td>
          <td>{{ $contract->contractKpi->grade ?? '-' }}</td>
          @if (isset($contract->contractKpi->contract_recommendation) && $contract->contractKpi->contract_recommendation == 1)
            <td style="background-color: #86e07b"> Kontrak Diperpanjang</td>
          @elseif(isset($contract->contractKpi->contract_recommendation) && $contract->contractKpi->contract_recommendation == 0)
            <td style="background-color: #dc6a6a"> Kontrak Tidak Diperpanjang</td>
          @else
            <td>-</td>
          @endif
          @php
            $accumulatedDurationInMonths = $contract
                ->where('employee_id', $contract->employee->id)
                ->where('contract_sequence_number', '<=', $contract->contract_sequence_number) // Include only contracts up to the current one
                // ->whereMonth('end_date', '<=', $contract->end_date) // Include only contracts up to the current one
                ->sum('duration');

            $years = intdiv($accumulatedDurationInMonths, 12); // Full years
            $months = $accumulatedDurationInMonths % 12; // Remaining months

            // Format as "X Tahun Y Bulan"
            $accumulatedDuration = ($years > 0 ? $years . ' Tahun ' : '') . ($months > 0 ? $months . ' Bulan' : '');

          @endphp

          <td>{{ $accumulatedDuration }}</td>


        </tr>
      @endforeach
    @endforeach
  </tbody>
</table>
