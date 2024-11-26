<table class="table" id="table10" style="font-size: 80%">
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
</table>
