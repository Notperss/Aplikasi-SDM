<table>
  <thead>
    <tr>
      <th style="width: 5;">#</th>
      <th style="width: 30;">NIK</th>
      <th style="width: 30;">Nama</th>
      <th style="width: 30;">Tugas/Dinas</th>
      <th style="width: 30;">Tgl Mulai</th>
      <th style="width: 30;">Tgl Selesai</th>
      <th style="width: 30;">Lokasi</th>
      <th style="width: 30;">Keterangan</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($dutys as $index => $duty)
      <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $duty->employee->nik ?? '-' }}</td>
        <td>{{ $duty->employee->name ?? '-' }}</td>
        <td>{{ $duty->name_duty ?? '-' }}</td>
        <td>{{ $duty->start_date ? Carbon\Carbon::parse($duty->start_date)->format('d-m-Y') : '-' }}</td>
        <td>{{ $duty->end_date ? Carbon\Carbon::parse($duty->end_date)->format('d-m-Y') : '-' }}</td>
        <td>{{ $duty->location ?? '-' }}</td>
        <td>{{ $duty->description }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
