<table>
  <thead>
    <tr>
      <th style="width: 5;">#</th>
      <th style="width: 30;">NIK</th>
      <th style="width: 30;">Nama Lengkap</th>
      <th style="width: 30;">Jabatan</th>
      <th style="width: 30;">Divisi</th>
      <th style="width: 30;">Status</th>
      <th style="width: 30;">Dibuat</th>
      {{-- <th></th> --}}
    </tr>
  </thead>
  <tbody>
    @foreach ($approvals as $approval)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>
          {{ $approval->employeeCareer->employee->nik ?? ($approval->employee->nik ?? '-') }}
        </td>
        <td>
          @if ($approval->employeeCareer && $approval->employeeCareer->employee)
            {{ $approval->employeeCareer->employee->name }}
          @elseif ($approval->selectedCandidate && $approval->selectedCandidate->candidate)
            {{ $approval->selectedCandidate->candidate->name }}
          @else
            - <!-- Default fallback if no employee or candidate exists -->
          @endif
        </td>
        <td>
          {{ $approval->position_id ? $approval->position->name : $approval->employeeCareer->employee->position->name }}
        </td>
        <td>
          {{ $approval->position_id ? $approval->position->division->name : $approval->employeeCareer->employee->position->division->name }}
        </td>
        <td>
          @php
            $status =
                '<span class="badge bg-primary mb-1">' . ($approval->type ?? $approval->description) . '</span> - ';

            if ($approval->is_approve === 1) {
                $appr = '<span class="badge bg-success">Disetujui</span>';
            } elseif ($approval->is_approve === 0) {
                $appr = '<span class="badge bg-danger">Ditolak</span>';
            } else {
                $appr = '<span class="badge bg-secondary">Pending</span>';
            }
          @endphp
          {!! $status . $appr !!}
        </td>
        <td>
          {{ $approval->created_at ? Carbon\Carbon::parse($approval->created_at)->translatedFormat('d-m-Y') : '-' }}
        </td>
      </tr>
    @endforeach

  </tbody>
</table>
