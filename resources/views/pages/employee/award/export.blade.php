<table>
  <thead>
    <tr>
      <th style="width: 5;">#</th>
      <th style="width: 30;">NIK</th>
      <th style="width: 30;">Nama</th>
      <th style="width: 30;">Nama Penghargaan</th>
      <th style="width: 30;">Tgl Penghargaan</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($awards as $index => $award)
      <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $award->employee->nik ?? '-' }}</td>
        <td>{{ $award->employee->name ?? '-' }}</td>
        <td>{{ $award->name_award ?? '-' }}</td>
        <td>{{ $award->date_award ? Carbon\Carbon::parse($award->date_award)->format('d-m-Y') : '-' }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
