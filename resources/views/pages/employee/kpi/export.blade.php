<table>
  <thead>
    <tr>
      <th style="width: 5;">#</th>
      <th style="width: 30;">NIK</th>
      <th style="width: 30;">Nama</th>
      <th style="width: 30;">Nomor Kontrak</th>
      <th style="width: 30;">Nilai</th>
      <th style="width: 30;">Rekomendasi Kontrak</th>
      <th style="width: 30;">Tanggal Kpi</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($kpis as $index => $kpi)
      <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $kpi->employee->nik ?? '-' }}</td>
        <td>{{ $kpi->employee->name ?? '-' }}</td>
        <td>{{ $kpi->contract->contract_number ?? '-' }}</td>
        <td>{{ $kpi->grade }}</td>
        @if ($kpi->contract_recommendation)
          <td style="background-color: #86e07b"> Kontrak Diperpanjang</td>
        @else
          <td style="background-color: #dc6a6a"> Kontrak Tidak Diperpanjang</td>
        @endif
        <td>{{ \Carbon\Carbon::parse($kpi->kpi_date)->format('d-m-Y') }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
