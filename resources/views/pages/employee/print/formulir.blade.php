<div style="padding: 20px; font-family: Arial, sans-serif; border: 1px solid #ddd; border-radius: 5px;">
  <table style="width: 100%; border-collapse: collapse; margin-bottom: 5px; font-family: Arial, sans-serif;">
    <!-- Header Section -->
    <tr>
      <td style="width: 20%; text-align: center; border: 1px solid #ddd; padding: 10px;">
        <img src="{{ asset('storage/' . $employee->company->logo) }}" alt="Company Logo"
          style="width: 50px; object-fit: contain;">
      </td>
      <td
        style="width: 60%; text-align: center; font-size: 18px; font-weight: bold; border: 1px solid #ddd; padding: 10px; background-color: #c7c3c3;">
        FORMULIR PEMUTAKHIRAN DATA KARYAWAN
      </td>
      <td rowspan="2" style="width: 20%; text-align: center; border: 1px solid #ddd; padding: 10px;">
        <img src="{{ asset('storage/' . $employee->photo) }}" alt="Employee Photo"
          style="width: 100px; object-fit: cover; border-radius: 5px;">
      </td>
    </tr>

    <!-- Personal Data Section -->
    <tr>
      <td colspan="2" style="border: 1px solid #ddd;">
        <table style="width: 100%; border-collapse: collapse;">
          <tr>
            <td style="width: 30%; font-weight: bold; ">Nama Lengkap</td>
            <td style="width: 3%; ">:</td>
            <td style="width: 67%; ">{{ $employee->name }}</td>
          </tr>
          <tr>
            <td style="font-weight: bold; ">NIK</td>
            <td>:</td>
            <td style="">{{ $employee->nik }}</td>
          </tr>
          <tr>
            <td style="font-weight: bold; ">Jabatan</td>
            <td>:</td>
            <td style="">{{ $employee->position->name ?? '-' }}</td>
            {{-- <td style="">{{ Carbon\Carbon::parse($employee->dob)->translatedFormat('d M Y') }}</td> --}}
          </tr>
          <tr>
            <td style="font-weight: bold; ">Unit Kerja</td>
            <td>:</td>
            <td style="">{{ $employee->position->division->name ?? '' }}</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>


  <!-- Informasi Data Personal -->
  <table style="width: 100%; border-collapse: collapse; margin-bottom: 5px;">
    <thead>
      <tr>
        <th colspan="4" style=" text-align: left; border: 1px solid #ddd; background-color: #c7c3c3;">
          Informasi Data Personal
        </th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="border: 1px solid #ddd; width: 20%;"><strong>Tempat, Tanggal Lahir</strong></td>
        <td style="border: 1px solid #ddd;">: {{ $employee->pob }},
          {{ Carbon\Carbon::parse($employee->dob)->translatedFormat('d M Y') }}
          ({{ Carbon\Carbon::parse($employee->dob)->age }} Tahun)</td>
        <td style="border: 1px solid #ddd; width: 15%;"><strong>Jenis Kelamin</strong></td>
        <td style="border: 1px solid #ddd;">: {{ $employee->gender }}</td>
      </tr>
      <tr>
        <td style="border: 1px solid #ddd;"><strong>Agama</strong></td>
        <td style="border: 1px solid #ddd;">: {{ $employee->religion ?? '' }}</td>
        <td style="border: 1px solid #ddd;"><strong>Suku Bangsa</strong></td>
        <td style="border: 1px solid #ddd;">: {{ $employee->ethnic ?? '' }}</td>
      </tr>
      <tr>
        <td style="border: 1px solid #ddd;"><strong>Golongan Darah</strong></td>
        <td style="border: 1px solid #ddd;">: {{ $employee->blood_type ?? '' }} </td>
        <td style="border: 1px solid #ddd;"><strong>No. KTP</strong></td>
        <td style="border: 1px solid #ddd;">: {{ $employee->ktp_number ?? '' }} </td>
      </tr>
      <tr>
        {{-- <td style="border: 1px solid #ddd;"><strong>Jenis Kelamin</strong></td>
        <td style="border: 1px solid #ddd;">: {{ $employee->gender }}</td> --}}
        <td style="border: 1px solid #ddd;"><strong>Email</strong></td>
        <td style="border: 1px solid #ddd;">: {{ $employee->email }}</td>
        <td style="border: 1px solid #ddd;"><strong>No. KK</strong></td>
        <td style="border: 1px solid #ddd;">: {{ $employee->kk_number }} </td>
      </tr>
      <tr>
        <td style="border: 1px solid #ddd;"><strong>No. Telepon</strong></td>
        <td style="border: 1px solid #ddd;">: {{ $employee->phone_number1 }} /
          {{ $employee->phone_number2 }}</td>

        <td style="border: 1px solid #ddd;"><strong>NPWP</strong></td>
        <td style="border: 1px solid #ddd;">: {{ $employee->npwp_number }}</td>
      </tr>
      {{-- <tr>
        <td style="border: 1px solid #ddd;"><strong>No. Telepon</strong></td>
        <td style="border: 1px solid #ddd;" colspan="3">: {{ $employee->phone_number1 }} /
          {{ $employee->phone_number2 }}</td>
      </tr> --}}
      <tr>
        <td style="border: 1px solid #ddd;"><strong>Alamat KTP</strong></td>
        <td style="border: 1px solid #ddd;" colspan="3">: {{ $employee->ktp_address }}</td>
      </tr>
      <tr>
        <td style="border: 1px solid #ddd;"><strong>Alamat Domisili</strong></td>
        <td style="border: 1px solid #ddd;" colspan="3">: {{ $employee->current_address }}</td>
      </tr>
    </tbody>
  </table>

  <!-- Informasi Pendidikan -->
  <table style="width: 100%; border-collapse: collapse; margin-bottom: 5px;">
    <thead>
      <tr>
        <th colspan="4" style="text-align: left; border: 1px solid #ddd; background-color: #c7c3c3;">
          Informasi Pendidikan
        </th>
      </tr>
      <tr>
        <th style="border: 1px solid #ddd;">Jenjang</th>
        <th style="border: 1px solid #ddd;">Nama Sekolah/Universitas</th>
        <th style="border: 1px solid #ddd;">Bidang Studi</th>
        <th style="border: 1px solid #ddd;">Tahun Lulus</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($employee->educationalHistories as $education)
        <tr>
          <td style="border: 1px solid #ddd;">{{ $education->school_level ?? '' }}</td>
          <td style="border: 1px solid #ddd;">{{ $education->school_name ?? '' }}</td>
          <td style="border: 1px solid #ddd;">{{ $education->study ?? '' }}</td>
          <td style="border: 1px solid #ddd;">{{ $education->year_to ?? '' }}</td>
        </tr>
      @empty
        <td class="text-bold-500" style="text-align: center" colspan="4">-</td>
      @endforelse
    </tbody>
  </table>

  <!-- Informasi Keluarga -->
  <table style="width: 100%; border-collapse: collapse; margin-bottom: 5px;">
    <thead>
      <tr>
        <th colspan="5" style=" text-align: left; border: 1px solid #ddd; background-color: #c7c3c3;">
          Informasi Keluarga
        </th>
      </tr>
      <tr>
        <th colspan="5" style=" text-align: left; border: 1px solid #ddd; background-color: #ffffff;">
          Status Perkawinan : {{ $employee->marital_status }}
        </th>
      </tr>
      <tr>
        <th style="border: 1px solid #ddd;">Nama</th>
        <th style="border: 1px solid #ddd; width: 7%">L/P</th>
        <th style="border: 1px solid #ddd;">Hubungan</th>
        <th style="border: 1px solid #ddd;">Tanggal Lahir</th>
        <th style="border: 1px solid #ddd;">Pekerjaan</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($employee->familyDetails as $family)
        <tr>
          <td style="border: 1px solid #ddd;">{{ $family->name }}</td>
          <td style="border: 1px solid #ddd;">
            @if ($family->gender == 'LAKI-LAKI')
              <span>L</span>
            @elseif ($family->gender == 'PEREMPUAN')
              <span>P</span>
            @else
              -
            @endif
          </td>
          <td style="border: 1px solid #ddd;">{{ $family->relationship }}</td>
          <td style="border: 1px solid #ddd;">
            {{ Carbon\Carbon::parse($family->dob)->translatedFormat('d M Y') }}
          </td>
          <td style="border: 1px solid #ddd;">{{ $family->occupation }}</td>
        </tr>
      @empty
        <td class="text-bold-500" style="text-align: center" colspan="4">-</td>
      @endforelse
    </tbody>
  </table>

  <!-- Pengalaman Kerja -->
  <table style="width: 100%; border-collapse: collapse; margin-bottom: 5px;">
    <thead>
      <tr>
        <th colspan="4" style=" text-align: left; border: 1px solid #ddd; background-color: #c7c3c3;">
          Pengalaman Kerja
        </th>
      </tr>
      <tr>
        <th style="border: 1px solid #ddd;">Perusahaan</th>
        <th style="border: 1px solid #ddd;">Posisi</th>
        <th style="border: 1px solid #ddd;">Tahun Masuk</th>
        <th style="border: 1px solid #ddd;">Tahun Keluar</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($employee->jobHistories as $job)
        <tr>
          <td style="border: 1px solid #ddd;">{{ $job->company_name }}</td>
          <td style="border: 1px solid #ddd;">{{ $job->position }}</td>
          <td style="border: 1px solid #ddd;">{{ $job->year_from }}</td>
          <td style="border: 1px solid #ddd;">{{ $job->year_to }}</td>
        </tr>
      @empty
        <td class="text-bold-500" style="text-align: center" colspan="4">-</td>
      @endforelse
    </tbody>
  </table>

  <!-- Informasi Kontak Darurat -->
  <table style="width: 100%; border-collapse: collapse;">
    <thead>
      <tr>
        <th colspan="3" style=" text-align: left; border: 1px solid #ddd; background-color: #c7c3c3;">
          Informasi Kontak Darurat
        </th>
      </tr>
      <tr>
        <th style="border: 1px solid #ddd;">Nama</th>
        <th style="border: 1px solid #ddd;">Hubungan</th>
        <th style="border: 1px solid #ddd;">No. Telepon</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="border: 1px solid #ddd;">{{ 'nama blablablab' }}</td>
        <td style="border: 1px solid #ddd;">{{ 'saudara' }}</td>
        <td style="border: 1px solid #ddd;">{{ '0867824638764' }}</td>
      </tr>
      {{-- @foreach ($employee->emergencyContacts as $contact)
        <tr>
          <td style="border: 1px solid #ddd;">{{ $contact->name }}</td>
          <td style="border: 1px solid #ddd;">{{ $contact->relationship }}</td>
          <td style="border: 1px solid #ddd;">{{ $contact->phone }}</td>
        </tr>
      @endforeach --}}
    </tbody>

  </table>

  <table
    style="width: 100%; border-collapse: collapse; margin-top: 20px; font-family: Arial, sans-serif; border: 1px solid #ddd;">
    <tr>
      <td style="padding: 20px; text-align: left;">
        <p>Formulir data karyawan ini telah diisi sesuai dengan data yang sebenarnya. <br>
          Jakarta,
        </p>

        <div style="margin-top: 60px; text-align: left; line-height: 1;">
          <p style="margin: 0; font-weight: bold;">{{ $employee->name }}</p>
          <div style="border-bottom: 1px solid #000; width: 200px;"></div>
          <p style="margin: 0;">{{ $employee->nik }}</p>
        </div>

        <p><small>Catatan: <br>
            - Mohon dilengkapi Fotokopi dokumen pendukung apabila ada perubahan / tambahan data
          </small></p>

      </td>
    </tr>
  </table>


</div>
