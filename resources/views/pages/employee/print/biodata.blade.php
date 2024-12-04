<div style="font-family: Arial, sans-serif;  align-items: center; justify-content: center;">
  <h2 style="text-align: center;">Data Karyawan</h2>

  <div style="display: flex; margin-top: 20px; margin-left: 20px">
    <!-- Photo Section -->
    <div style="margin-right: 20px;">
      <img src="{{ asset($mainPhoto ? 'storage/' . $mainPhoto->file_path : 'storage/img/2.jpg') }}" alt="Employeehoto"
        style="width: 150px;  object-fit: cover; border: 1px solid #ddd; border-radius: 5px;">
    </div>

    <!-- Biodata Details -->
    <div>
      <table style="border-collapse: collapse; text-align: left;">
        <tr>
          <td><strong>Nama</strong></td>
          <td><strong>:</strong></td>
          <td>{{ $employee->name }}</td>
        </tr>
        <tr>
          <td><strong>NIK</strong></td>
          <td><strong>:</strong></td>
          <td>{{ $employee->nik }}</td>
        </tr>
        <tr>
          <td><strong>Jabatan</strong></td>
          <td><strong>:</strong></td>
          <td>{{ $employee->position->name ?? '' }}</td>
        </tr>
        <tr>
          <td><strong>Level</strong></td>
          <td><strong>:</strong></td>
          <td>{{ $employee->position->level->name ?? '' }}</td>
        </tr>
        <tr>
          <td><strong>Unit Kerja</strong></td>
          <td><strong>:</strong></td>
          <td>{{ $employee->position->division->name ?? '' }}</td>
        </tr>
        <tr>
          <td><strong>Tanggal Lahir</strong></td>
          <td><strong>:</strong></td>
          <td>{{ Carbon\Carbon::parse($employee->dob)->translatedFormat('d M Y') }}</td>
        </tr>
        <tr>
          <td><strong>Usia</strong></td>
          <td><strong>:</strong></td>
          <td>{{ Carbon\Carbon::parse($employee->dob)->age }} Tahun</td>
        </tr>
        <tr>
          <td><strong>Tanggal Bekerja</strong></td>
          <td><strong>:</strong></td>
          <td>{{ Carbon\Carbon::parse($employee->date_joining)->translatedFormat('d M Y') }}</td>
        </tr>
        <tr>
          <td><strong>Masa Kerja</strong></td>
          <td><strong>:</strong></td>
          <td>
            @php
              $dateJoining = Carbon\Carbon::parse($employee->date_joining);
              $masaKerja = $dateJoining->diff(Carbon\Carbon::now());
            @endphp
            {{ $masaKerja->y }} tahun {{ $masaKerja->m }} bulan
          </td>
        </tr>

        <tr>
          <td><strong>Status Karyawan</strong></td>
          <td><strong>:</strong></td>
          <td>{{ $employee->employee_status }}</td>
        </tr>
        <tr>
          <td><strong>Jenis Kelamin</strong></td>
          <td><strong>:</strong></td>
          <td>{{ $employee->gender }}</td>
        </tr>
        <tr>
          <td><strong>Status Pernikahan</strong></td>
          <td><strong>:</strong></td>
          <td>{{ $employee->marital_status }}</td>
        </tr>
      </table>
    </div>

  </div>

  <div style="font-family: Arial, sans-serif; margin-top: 10px; margin-right: 10px; margin-left: 10px;">

    <table style="width: 100%; border-collapse: collapse; margin-top: 10px; text-align: left; font-size: 14px;">
      <thead>
      </thead>
      <tr>
        <th colspan="4" style="border: 1px solid #ddd; background-color: #969696; text-align: center">
          Pendidikan</th>
      </tr>
      <tr>
        <th style="padding: 5px; border: 1px solid #ddd; background-color: #cfcece; text-align: center">Tingkat
          Pendidikan</th>
        <th style="padding: 5px; border: 1px solid #ddd; background-color: #cfcece; text-align: center">Institusi</th>
        <th style="padding: 5px; border: 1px solid #ddd; background-color: #cfcece; text-align: center">Bidang Studi
        </th>
        <th style="padding: 5px; border: 1px solid #ddd; background-color: #cfcece; text-align: center">Tahun Lulus</th>
      </tr>
      <tbody>
        @php
          // Filter educational histories by specific levels
          $educational = $employee->educationalHistories->whereIn('school_level', ['S-1', 'S-2', 'S-3']);

          // If no matches are found, get the latest educational history
          if ($educational->isEmpty()) {
              $educational = collect([$employee->educationalHistories->sortByDesc('year_to')->first()]);
          }
        @endphp
        @foreach ($educational as $education)
          <tr>
            <td style="padding: 5px; border: 1px solid #ddd;">{{ $education->school_level ?? '' }}</td>
            <td style="padding: 5px; border: 1px solid #ddd;">{{ $education->school_name ?? '' }}</td>
            <td style="padding: 5px; border: 1px solid #ddd;">{{ $education->study ?? '' }}</td>
            <td style="padding: 5px; border: 1px solid #ddd;">{{ $education->year_to ?? '' }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <table style="width: 100%; border-collapse: collapse; margin-top: 10px; text-align: left; font-size: 14px;">
      <thead>
      </thead>
      <tr>
        <th colspan="4" style="border: 1px solid #ddd; background-color: #969696; text-align: center">
          Riwayat Pangkat / Jabatan
        </th>
      </tr>
      <tr>
        <th style="padding: 5px; border: 1px solid #ddd; background-color: #cfcece; text-align: center">
          Efektif Tanggal</th>
        <th style="padding: 5px; border: 1px solid #ddd; background-color: #cfcece; text-align: center">Jabatan</th>
        <th style="padding: 5px; border: 1px solid #ddd; background-color: #cfcece; text-align: center">Penempatan
        </th>
      </tr>
      <tbody>
        @foreach ($employee->employeeCareers->where('is_approve', 1) as $career)
          <tr>
            <td style="border: 1px solid #ddd;">

              {{ Carbon\Carbon::parse($career->start_date)->translatedFormat('d M Y') }} -
              @if ($career->end_date)
                {{ Carbon\Carbon::parse($career->end_date)->translatedFormat('l, d F Y') }}
              @else
                Sekarang
              @endif
            </td>
            <td style="border: 1px solid #ddd;">{{ $career->position->name ?? '' }}</td>
            <td style="border: 1px solid #ddd;">{{ $career->placement ?? '' }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <table style="width: 100%; border-collapse: collapse; margin-top: 10px; text-align: left; font-size: 14px;">
      <thead>
      </thead>
      <tr>
        <th colspan="4" style="border: 1px solid #ddd; background-color: #969696; text-align: center">
          Pendidikan Non Formal: Kursus/Pelatihan
        </th>
      </tr>
      <tr>
        <th style="padding: 5px; border: 1px solid #ddd; background-color: #cfcece; text-align: center">
          Pelatihan/Seminar
        </th>
        <th style="padding: 5px; border: 1px solid #ddd; background-color: #cfcece; text-align: center">
          Penyelenggara
        </th>
        <th style="padding: 5px; border: 1px solid #ddd; background-color: #cfcece; text-align: center">
          Tempat/Kota
        </th>
        <th style="padding: 5px; border: 1px solid #ddd; background-color: #cfcece; text-align: center">
          Tahun
        </th>
      </tr>
      <tbody>
        @foreach ($employee->TrainingAttendeds as $training)
          {{-- <tr>
            <td style="border: 1px solid #ddd;">
              {{ Carbon\Carbon::parse($career->start_date)->translatedFormat('d M Y') }} -
              @if ($career->end_date)
                {{ Carbon\Carbon::parse($career->end_date)->translatedFormat('l, d F Y') }}
              @else
                Sekarang
              @endif
            </td>
            <td style="border: 1px solid #ddd;">{{ $career->position->name }}</td>
            <td style="border: 1px solid #ddd;">{{ $career->placement }}</td>
            <td style="border: 1px solid #ddd;">{{ $career->placement }}</td>
          </tr> --}}

          <tr>
            <td style="border: 1px solid #ddd;">{{ $training->training_name }}</td>
            <td style="border: 1px solid #ddd;">{{ $training->organizer_name }}</td>
            <td style="border: 1px solid #ddd;">{{ $training->city }}</td>
            <td style="border: 1px solid #ddd;">{{ $training->year }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>

  </div>

</div>
