<table>
  <thead>
    <tr>
      <th style="width: 15;">NIK</th>
      <th style="width: 30;">Nama Lengkap</th>
      <th style="width: 30;">Tempat Lahir</th>
      <th style="width: 15;">Tanggal Lahir</th>
      <th style="width: 30;">Jenis Kelamin</th>
      <th style="width: 20;">Kategori Karyawan</th>
      <th style="width: 30;">Status Karyawan</th>
      <th style="width: 30;">Level</th>
      <th style="width: 30;">Jabatan</th>
      <th style="width: 30;">Divisi</th>

      <th style="width: 15;">TMT Masuk</th>
      <th style="width: 30;">No.Kontrak</th>
      <th style="width: 30;">Tgl Awal Kontrak</th>
      <th style="width: 30;">Tgl Akhir Kontrak</th>
      <th style="width: 15;">Durasi</th>
      <th style="width: 15;">Kontrak Ke-</th>

      <th style="width: 15;">TMT Keluar</th>

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
      <th style="width: 15;">Agama</th>
      <th style="width: 30;">Kewarganegaraan</th>
      <th style="width: 15;">Suku Bangsa</th>
      <th style="width: 15;">Gol. Darah</th>
      <th style="width: 30;">Pendidikan Terakhir</th>
      <th style="width: 30;">Jurusan Pendidikan</th>
      <th style="width: 30;">Alamat KTP</th>
      <th style="width: 15;">Kode Pos KTP</th>
      <th style="width: 30;">Alamat Domisili</th>
      <th style="width: 30;">SIM A</th>
      <th style="width: 30;">SIM B</th>
      <th style="width: 30;">SIM C</th>
      <th style="width: 30;">Akumulasi Masa Kerja</th>
      <th style="width: 30;">Masa Pensiun</th>
      <th style="width: 30;">Sisa Tahun Menuju pensiun</th>
      <th style="width: 30;">Keterangan Keluar</th>
      <th style="width: 5;"></th>
      <th style="width: 20;">Pendidikan Terakhir</th>
      <th style="width: 30;">Jurusan</th>
      <th style="width: 30;">Institusi/Nama Sekolah</th>
      <th style="width: 30;">Tempat</th>
      <th style="width: 15;">GPA/NEM</th>
      <th style="width: 15;">Tahun Masuk</th>
      <th style="width: 15;">Tahun Keluar</th>
      <th style="width: 15;">Lulus/Tidak</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($positions as $position)
      @php

        $retirementDate = \Carbon\Carbon::parse($position->employee->dob)->addYears(55);
        // ->addMonths(3);

        $currentDate = \Carbon\Carbon::now();
        $diff = $currentDate->diff($retirementDate);

        $remainingYears = $diff->y; // Whole years
        $remainingMonths = $diff->m; // Remaining months after whole years

      @endphp
      <tr>
        <td>{{ $position->employee->nik ?? '-' }}</td>
        <td>{{ $position->employee->name ?? '-' }}</td>
        <td>{{ $position->employee->pob ?? '-' }}</td>
        <td>{{ $position->employee->dob ? \Carbon\Carbon::parse($position->employee->dob)->format('d-m-Y') : '' }}</td>
        <td>{{ $position->employee->gender ?? '-' }}</td>
        <td>{{ $position->employee->employeeCategory->name ?? '-' }}</td>
        <td>{{ $position->employee->employee_status ?? '-' }}</td>
        <td>{{ $position->employee->position->level->name ?? '-' }}</td>
        <td>{{ $position->employee->position->name ?? '-' }}</td>
        <td>{{ $position->employee->position->division->name ?? '-' }}</td>

        <td>
          {{ $position->employee->date_joining ? \Carbon\Carbon::parse($position->employee->date_joining)->format('d-m-Y') : '-' }}
        </td>
        <td>{{ $position->employee->contracts->first()->contract_number ?? '-' }}</td>
        <td>{{ $position->employee->contracts->first()->start_date ?? '-' }}</td>
        <td>{{ $position->employee->contracts->first()->end_date ?? '-' }}</td>
        <td>{{ $position->employee->contracts->first()->duration ?? '-' }}</td>
        <td>{{ $position->employee->contracts->first()->contract_sequence_number ?? '-' }}</td>

        <td>
          {{ $position->employee->date_leaving ? \Carbon\Carbon::parse($position->employee->date_leaving)->format('d-m-Y') : '-' }}
        </td>

        <td>{{ $position->employee->work_relationship ?? '-' }}</td>
        <td>{{ $position->employee->work_status ?? '-' }}</td>
        <td>{{ $position->employee->ktp_number ?? '-' }}</td>
        <td>{{ $position->employee->kk_number ?? '-' }}</td>
        <td>{{ $position->employee->paspor_number ?? '-' }}</td>
        <td>{{ $position->employee->npwp_number ?? '-' }}</td>
        <td>{{ $position->employee->bpjs_kesehatan_number ?? '-' }}</td>
        <td>{{ $position->employee->bpjs_naker_number ?? '-' }}</td>
        <td>
          @if ($position->employee->glasses)
            Iya
          @else
            Tidak
          @endif
        </td>
        <td>{{ $position->employee->candidate_from ?? '-' }}</td>
        <td>{{ $position->employee->reference ?? '-' }}</td>
        <td>{{ $position->employee->email ?? '-' }}</td>
        <td>{{ $position->employee->phone_number1 ?? '-' }}</td>
        <td>{{ $position->employee->phone_number2 ?? '-' }}</td>
        <td>{{ $position->employee->marital_status ?? '-' }}</td>
        <td>{{ $position->employee->religion ?? '-' }}</td>
        <td>{{ $position->employee->nationality ?? '-' }}</td>
        <td>{{ $position->employee->ethnic ?? '-' }}</td>
        <td>{{ $position->employee->blood_type ?? '-' }}</td>
        <td>{{ $position->employee->last_educational ?? '-' }}</td>
        <td>{{ $position->employee->study ?? '-' }}</td>
        <td>{{ $position->employee->ktp_address ?? '-' }}</td>
        <td>{{ $position->employee->zipcode_ktp ?? '-' }}</td>
        <td>{{ $position->employee->current_address ?? '-' }}</td>
        <td>{{ $position->employee->sim_a ?? '-' }}</td>
        <td>{{ $position->employee->sim_b ?? '-' }}</td>
        <td>{{ $position->employee->sim_c ?? '-' }}</td>
        <td>{{ $position->employee->accumulatedWorkTenure() ?? '-' }}</td>
        <td>{{ $retirementDate->translatedFormat('l, d F Y') }}</td>
        <td>{{ $remainingYears }} tahun {{ $remainingMonths }} bulan</td>
        <td>
          @foreach ($position->employee->employeeCareers as $career)
            @if (in_array($career->type, ['NON-AKTIF', 'PENSIUN', 'RESIGN', null]) &&
                    $position->employee->employee_status != 'AKTIF')
              {{ $career->description }},
            @endif
          @endforeach
        </td>
        <td></td>
        <td>{{ $position->employee->educationalHistories->first()->school_level ?? '-' }}</td>
        <td>{{ $position->employee->educationalHistories->first()->study ?? '-' }}</td>
        <td>{{ $position->employee->educationalHistories->first()->school_name ?? '-' }}</td>
        <td>{{ $position->employee->educationalHistories->first()->city ?? '-' }}</td>
        <td>{{ $position->employee->educationalHistories->first()->gpa ?? '-' }}</td>
        <td>{{ $position->employee->educationalHistories->first()->year_from ?? '-' }}</td>
        <td>{{ $position->employee->educationalHistories->first()->year_to ?? '-' }}</td>
        <td>{{ $position->employee->educationalHistories->first()->graduate ?? '-' }}</td>

      </tr>
    @endforeach
  </tbody>
</table>
