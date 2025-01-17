<table class="table" id="example" style="font-size: 80%">
  <thead>
    <tr>
      <th scope="col" style="width: 5%">#</th>
      <th scope="col"></th>
      <th scope="col">NIK</th>
      <th scope="col">Nama</th>
      <th scope="col">Jabatan</th>
      <th scope="col">No. Kontrak</th>
      <th scope="col">Tgl Mulai</th>
      <th scope="col">Tgl Berakhir</th>
      <th scope="col">Durasi</th>
      <th scope="col">Kontrak Ke- </th>
      <th scope="col">Divisi</th>
      <th scope="col" class="text-center">PK</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    @foreach ($contractsExpired as $contract)
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
          {{ $contract->employee->position->name ?? 'N/A' }}
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
        <td class="text-center">
          @if ($contract->contractKpi)
            {{ $contract->contractKpi->grade }} <br>
            @if ($contract->contractKpi->contract_recommendation)
              <span class="badge bg-success">Kontrak Di Perpanjang</span>
            @else
              <span class="badge bg-danger">Kontrak tidak diperpanjang</span>
            @endif
          @else
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
              data-bs-target="#modal-form-add-kpi">
              <i class="bi bi-plus-lg"></i>
              PK
            </button>
            @include('pages.employee.personal-data.form.kpi.modal-create')
          @endif
        </td>
        <td>
          @php
            // Fetch the latest contract for the employee
            $latestContract = $contract
                ->where('employee_id', $contract->employee->id)
                ->orderBy('start_date', 'desc')
                ->first();
          @endphp

          @if ($latestContract && $latestContract->start_date >= now())
            {{-- @if ($latestContract->start_date > now()) --}}
            <p>Kontrak diperbarui</p>
          @else
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
              data-bs-target="#modal-form-add-contract">
              <i class="bi bi-plus-lg"></i>
              Kontrak
            </button>
            @include('pages.employee.personal-data.form.employee-contract.modal-create')
          @endif

        </td>

        {{-- </tr>
    @empty
      <tr>
        <td class="text-center" colspan="13">No data available in table</td>
      </tr> --}}
    @endforeach
  </tbody>
</table>

@push('after-script')
  <script>
    $('#example').DataTable({
      "order": [],
      "paging": true,
      "lengthMenu": [
        [5, 10, 25, 50, 100, -1],
        [5, 10, 25, 50, 100, "All"]
      ],
      "pageLength": 10
    });
  </script>
@endpush
