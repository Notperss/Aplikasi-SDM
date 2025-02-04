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
      <table style="border-collapse: collapse; text-align: left;text-transform: uppercase">
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
          <td>{{ Carbon\Carbon::parse($employee->dob)->translatedFormat('d-m-Y') }}</td>
        </tr>
        <tr>
          <td><strong>Usia</strong></td>
          <td><strong>:</strong></td>
          <td>{{ Carbon\Carbon::parse($employee->dob)->age }} Tahun</td>
        </tr>
        <tr>
          <td><strong>Tanggal Bekerja</strong></td>
          <td><strong>:</strong></td>
          <td>{{ Carbon\Carbon::parse($employee->date_joining)->translatedFormat('d-m-Y') }}</td>
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
          <td>{{ $employee->work_relationship }}</td>
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
        <tr>
          <th colspan="4" style="border: 1px solid #ddd; background-color: #969696; text-align: center">
            Pendidikan</th>
        </tr>
        <tr>
          <th style="padding: 5px; border: 1px solid #ddd; background-color: #cfcece; text-align: center">Tingkat
            Pendidikan</th>
          <th style="padding: 5px; border: 1px solid #ddd; background-color: #cfcece; text-align: center">Institusi/Nama
            Sekolah</th>
          <th style="padding: 5px; border: 1px solid #ddd; background-color: #cfcece; text-align: center">Bidang Studi
          </th>
          <th style="padding: 5px; border: 1px solid #ddd; background-color: #cfcece; text-align: center">Tahun Lulus
          </th>
        </tr>
      </thead>
      <tbody>
        {{-- @php
          // Filter educational histories by specific levels
          $educational = $employee->educationalHistories->whereIn('school_level', ['S-1', 'S-2', 'S-3']);

          // If no matches are found, get the latest educational history
          if ($educational->isEmpty()) {
              $educational = collect([$employee->educationalHistories->sortByDesc('year_to')->first()]);
          }
        @endphp
        @foreach ($educational as $education) --}}
        @foreach ($employee->educationalHistories as $education)
          <tr>
            <td style="padding: 5px; border: 1px solid #ddd;">{{ $education->school_level ?? '' }}
            </td>
            <td style="padding: 5px; border: 1px solid #ddd;">{{ $education->school_name ?? '' }}
            </td>
            <td style="padding: 5px; border: 1px solid #ddd;">{{ $education->study ?? '' }}</td>
            <td style="padding: 5px; border: 1px solid #ddd;text-align: center">
              {{ ucwords(strtolower($education->year_to ?? '')) }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <table style="width: 100%; border-collapse: collapse; margin-top: 10px; text-align: left; font-size: 14px;">
      <thead>
        <tr>
          <th colspan="4" style="border: 1px solid #ddd; background-color: #969696; text-align: center">
            Riwayat Pangkat / Jabatan
          </th>
        </tr>
        <tr>
          <th style="padding: 5px; border: 1px solid #ddd; background-color: #cfcece; text-align: center; ">
            Efektif Tanggal</th>
          <th style="padding: 5px; border: 1px solid #ddd; background-color: #cfcece; text-align: center; ">
            Jabatan</th>
          <th style="padding: 5px; border: 1px solid #ddd; background-color: #cfcece; text-align: center;">
            Penempatan
          </th>
        </tr>
      <tbody>
        @foreach ($employee->employeeCareers->where('is_approve', 1) as $career)
          <tr>
            <td style="border: 1px solid #ddd;">

              {{ Carbon\Carbon::parse($career->start_date)->translatedFormat('d-m-Y') }} -

              @if ($career->position_id)
                {{ $career->end_date ? Carbon\Carbon::parse($career->end_date)->translatedFormat('d-m-Y') : 'Sekarang' }}
              @endif

            </td>
            <td style="border: 1px solid #ddd;">
              {{ ucwords(strtolower($career->position->name ?? ($career->type ?? ''))) }}</td>
            <td style="border: 1px solid #ddd;">
              {{ $career->position_id ? 'Divisi ' . ucwords(strtolower($career->position->division->name ?? ($career->placement ?? ''))) : '-' }}


            </td>
          </tr>
          </thead>
        @endforeach
        <tr>
          <td colspan="4" style="border: 2px solid #ddd; background-color: #969696; text-align: center">
          </td>
        </tr>
        @foreach ($employee->employeeCareers->where('cmnp_career', 1) as $career)
          <tr>
            <td style="border: 1px solid #ddd;">

              {{ Carbon\Carbon::parse($career->start_date)->translatedFormat('d-m-Y') }} -
              {{ $career->end_date ? Carbon\Carbon::parse($career->end_date)->translatedFormat('d-m-Y') : '' }}

            </td>
            {{-- <td style="border: 1px solid #ddd;">{{ $career->position->name ?? ($career->type ?? '') }}</td> --}}
            {{-- <td style="border: 1px solid #ddd;">{{ $career->position_name ?? '' }}</td>
            <td style="border: 1px solid #ddd;">{{ $career->placement ?? ($career->position->division->name ?? '') }} --}}
            <td style="border: 1px solid #ddd;">
              {{ ucwords(strtolower($career->position_name)) }}</td>
            <td style="border: 1px solid #ddd; ">
              {{ ucwords(strtolower($career->placement)) }}
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>


    <table style="width: 100%; border-collapse: collapse; margin-top: 10px; text-align: left; font-size: 14px;">
      <thead>
        <tr>
          <th colspan="5" style="border: 1px solid #ddd; background-color: #969696; text-align: center">
            Pengalaman Kerja
          </th>
        </tr>
        <tr>
          {{-- <th style="padding: 5px; border: 1px solid #ddd; background-color: #cfcece; text-align: center">
          Tanggal Masuk</th>
        <th style="padding: 5px; border: 1px solid #ddd; background-color: #cfcece; text-align: center">
          Tanggal Keluar</th> --}}
          <th style="padding: 5px; border: 1px solid #ddd; background-color: #cfcece; text-align: center">
            Periode</th>
          <th style="padding: 5px; border: 1px solid #ddd; background-color: #cfcece; text-align: center">
            Jabatan</th>
          <th style="padding: 5px; border: 1px solid #ddd; background-color: #cfcece; text-align: center">
            Nama Perusahaan</th>
          {{-- <th style="padding: 5px; border: 1px solid #ddd; background-color: #cfcece; text-align: center">Penempatan
        </th> --}}
        </tr>
      </thead>

      <tbody>
        @foreach ($employee->jobHistories as $employeeJobHistory)
          <tr>
            {{-- <td style="border: 1px solid #ddd;">
              {{ $employeeJobHistory->year_from }}
            </td>
            <td style="border: 1px solid #ddd;">
              {{ $employeeJobHistory->year_to }}
            </td> --}}
            <td style="border: 1px solid #ddd;">{{ $employeeJobHistory->period ?? '' }}</td>
            <td style="border: 1px solid #ddd;">{{ $employeeJobHistory->position ?? '' }}</td>
            <td style="border: 1px solid #ddd;">{{ $employeeJobHistory->company_name }}
            </td>
            {{-- <td style="border: 1px solid #ddd;">{{ $career->position->name ?? ($career->type ?? '') }}</td> --}}
          </tr>
        @endforeach
      </tbody>
    </table>

    <table style="width: 100%; border-collapse: collapse; margin-top: 10px; text-align: left; font-size: 14px;"
      @if ($employee->trainingAttendeds->where('is_certificated', 0)->where('is_printable', 1)->isEmpty()) hidden @endif>
      <thead>
        <tr>
          <th colspan="4" style="border: 1px solid #ddd; background-color: #969696; text-align: center">
            Kursus/Pelatihan
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
          <th style="padding: 5px; border: 1px solid #ddd; background-color: #cfcece; text-align: center; width: 15%">
            Tanggal
          </th>
        </tr>
      </thead>

      <tbody>
        @foreach ($employee->trainingAttendeds->where('is_certificated', 0)->where('is_printable', 1) as $training)
          <tr>
            <td style="border: 1px solid #ddd;">{{ $training->training_name }}</td>
            <td style="border: 1px solid #ddd;">{{ $training->organizer_name }}</td>
            <td style="border: 1px solid #ddd;">{{ $training->city }}</td>
            <td style="border: 1px solid #ddd;">
              {{ $training->start_date ? Carbon\Carbon::parse($training->start_date)->translatedFormat('d-m-Y') : '' }}
              -
              {{ $training->end_date ? Carbon\Carbon::parse($training->end_date)->translatedFormat('d-m-Y') : '' }}
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <table style="width: 100%; border-collapse: collapse; margin-top: 10px; text-align: left; font-size: 14px;"
      @if ($employee->trainingAttendeds->where('is_certificated', 1)->isEmpty()) hidden @endif>

      <thead>
        <tr>
          <th colspan="4" style="border: 1px solid #ddd; background-color: #969696; text-align: center">
            Sertifikasi
          </th>
        </tr>
        <tr>
          <th style="padding: 5px; border: 1px solid #ddd; background-color: #cfcece; text-align: center">
            Nama Sertifikasi
          </th>
          <th style="padding: 5px; border: 1px solid #ddd; background-color: #cfcece; text-align: center">
            Penyelenggara
          </th>
          <th style="padding: 5px; border: 1px solid #ddd; background-color: #cfcece; text-align: center">
            Tempat/Kota
          </th>
          <th style="padding: 5px; border: 1px solid #ddd; background-color: #cfcece; text-align: center; width: 15%">
            Masa Berlaku
          </th>
        </tr>
      </thead>
      <tbody>
        @foreach ($employee->trainingAttendeds->where('is_certificated', 1) as $training)
          <tr>
            <td style="border: 1px solid #ddd;">{{ $training->training_name }}</td>
            <td style="border: 1px solid #ddd;">{{ $training->organizer_name }}</td>
            <td style="border: 1px solid #ddd;">{{ $training->city }}</td>
            <td style="border: 1px solid #ddd;">
              {{ $training->end_date ? Carbon\Carbon::parse($training->end_date)->translatedFormat('d-m-Y') : '' }}
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

  </div>

</div>
