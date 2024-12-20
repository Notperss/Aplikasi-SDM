<table>
  <thead>
    <tr>
      <th style="width: 30;">NIK</th>
      <th style="width: 30;">Nama Lengkap</th>
      <th style="width: 30;">Tempat, Tanggal Lahir</th>
      <th style="width: 30;">Jenis Kelamin</th>
      <th style="width: 30;">Kategori Karyawan</th>
      <th style="width: 30;">Status Karyawan</th>
      <th style="width: 30;">Jabatan</th>
      <th style="width: 30;">Divisi</th>
      <th style="width: 30;">TMT Masuk</th>
      <th style="width: 30;">TMT Keluar</th>

      <th style="width: 30;">Hubungan Kerja</th>
      <th style="width: 30;">Tipe Waktu Pekerjaan</th>
      <th style="width: 30;">NO. KTP</th>
      <th style="width: 30;">NO. KK</th>
      <th style="width: 30;">NO. Paspor</th>
      <th style="width: 30;">NO. NPWP</th>
      <th style="width: 30;">NO. BPJS Kesehatan</th>
      <th style="width: 30;">NO. BPJS Ketenagakerjaan</th>
      <th style="width: 30;">Kacamata</th>
      <th style="width: 30;">Pelamar Dari</th>
      <th style="width: 30;">Refrensi</th>
      <th style="width: 30;">Email</th>
      <th style="width: 30;">No. Telp1</th>
      <th style="width: 30;">No. Telp2</th>
      <th style="width: 30;">Status Perkawinan</th>
      <th style="width: 30;">Agama</th>
      <th style="width: 30;">Kewarganegaraan</th>
      <th style="width: 30;">Suku Bangsa</th>
      <th style="width: 30;">Gol. Darah</th>
      <th style="width: 30;">Pendidikan Terakhir</th>
      <th style="width: 30;">Jurusan Pendidikan</th>
      <th style="width: 30;">Alamat KTP</th>
      <th style="width: 30;">Kode Pos KTP</th>
      <th style="width: 30;">Alamat Domisili</th>
      <th style="width: 30;">SIM A</th>
      <th style="width: 30;">SIM B</th>
      <th style="width: 30;">SIM C</th>
      <th style="width: 30;">Akumulasi Masa Kerja</th>
      <th style="width: 30;">Masa Pensiun</th>
      <th style="width: 30;">Sisa Tahun Menuju pensiun</th>
      <th style="width: 30;">Keterangan Keluar</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($employees as $employee)
      @php

        $retirementDate = \Carbon\Carbon::parse($employee->dob)
            ->addYears(55)
            ->addMonths(3);

        $currentDate = \Carbon\Carbon::now();
        $diff = $currentDate->diff($retirementDate);

        $remainingYears = $diff->y; // Whole years
        $remainingMonths = $diff->m; // Remaining months after whole years

      @endphp
      <tr>
        <td>{{ $employee->nik ?? '-' }}</td>
        <td>{{ $employee->name ?? '-' }}</td>
        <td>{{ $employee->pob ?? '-' }},
          {{ $employee->dob ? \Carbon\Carbon::parse($employee->dob)->format('d-m-Y') : '' }}</td>
        <td>{{ $employee->gender ?? '-' }}</td>
        <td>{{ $employee->employeeCategory->name ?? '-' }}</td>
        <td>{{ $employee->employee_status ?? '-' }}</td>
        <td>{{ $employee->position->name ?? '-' }}</td>
        <td>{{ $employee->position->division->name ?? '-' }}</td>
        <td>{{ $employee->date_joining ? \Carbon\Carbon::parse($employee->date_joining)->format('d-m-Y') : '-' }}</td>
        <td>{{ $employee->date_leaving ? \Carbon\Carbon::parse($employee->date_leaving)->format('d-m-Y') : '-' }}</td>


        <td>{{ $employee->work_relationship ?? '-' }}</td>
        <td>{{ $employee->work_status ?? '-' }}</td>
        <td>{{ $employee->ktp_number ?? '-' }}</td>
        <td>{{ $employee->kk_number ?? '-' }}</td>
        <td>{{ $employee->paspor_number ?? '-' }}</td>
        <td>{{ $employee->npwp_number ?? '-' }}</td>
        <td>{{ $employee->bpjs_kesehatan_number ?? '-' }}</td>
        <td>{{ $employee->bpjs_naker_number ?? '-' }}</td>
        <td>
          @if ($employee->glasses)
            Iya
          @else
            Tidak
          @endif
        </td>
        <td>{{ $employee->candidate_from ?? '-' }}</td>
        <td>{{ $employee->reference ?? '-' }}</td>
        <td>{{ $employee->email ?? '-' }}</td>
        <td>{{ $employee->phone_number1 ?? '-' }}</td>
        <td>{{ $employee->phone_number2 ?? '-' }}</td>
        <td>{{ $employee->marital_status ?? '-' }}</td>
        <td>{{ $employee->religion ?? '-' }}</td>
        <td>{{ $employee->nationality ?? '-' }}</td>
        <td>{{ $employee->ethnic ?? '-' }}</td>
        <td>{{ $employee->blood_type ?? '-' }}</td>
        <td>{{ $employee->last_educational ?? '-' }}</td>
        <td>{{ $employee->study ?? '-' }}</td>
        <td>{{ $employee->ktp_address ?? '-' }}</td>
        <td>{{ $employee->zipcode_ktp ?? '-' }}</td>
        <td>{{ $employee->current_address ?? '-' }}</td>
        <td>{{ $employee->sim_a ?? '-' }}</td>
        <td>{{ $employee->sim_b ?? '-' }}</td>
        <td>{{ $employee->sim_c ?? '-' }}</td>
        <td>{{ $employee->accumulatedWorkTenure() ?? '-' }}</td>
        <td>{{ $retirementDate->translatedFormat('l, d F Y') }}</td>
        <td>{{ $remainingYears }} tahun {{ $remainingMonths }} bulan</td>
        <td>
          @foreach ($employee->employeeCareers as $career)
            @if (in_array($career->type, ['NON-AKTIF', 'PENSIUN', 'RESIGN', null]) && $employee->employee_status != 'AKTIF')
              {{ $career->description }},
            @endif
          @endforeach
        </td>

      </tr>
    @endforeach
  </tbody>
</table>
