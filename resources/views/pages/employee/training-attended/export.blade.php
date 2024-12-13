<table>
  <thead>
    <tr>
      <th style="width: 5;">#</th>
      <th style="width: 30;">NIK</th>
      <th style="width: 30;">Nama</th>
      <th style="width: 30;">Nama Training</th>
      <th style="width: 30;">Penyelenggara</th>
      <th style="width: 30;">Kota</th>
      <th style="width: 30;">Tanggal Training</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($trainings as $index => $training)
      <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $training->employee->nik ?? '-' }}</td>
        <td>{{ $training->employee->name ?? '-' }}</td>
        <td>{{ $training->training_name }}</td>
        <td>{{ $training->organizer_name }}</td>
        <td>{{ $training->city }}</td>
        <td>{{ \Carbon\Carbon::parse($training->training_date)->format('d-m-Y') }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
