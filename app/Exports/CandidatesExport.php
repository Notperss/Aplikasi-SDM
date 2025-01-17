<?php

namespace App\Exports;

use App\Models\Recruitment\Candidate;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;

class CandidatesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $candidateIds;

    public function __construct(array $candidateIds)
    {
        $this->candidateIds = $candidateIds;
    }

    public function collection()
    {
        return Candidate::whereIn('id', $this->candidateIds)
            ->select(
                // 'id',
                'name',
                'email',
                'phone_number',
                'ktp_address',
                'current_address',
                'ktp_number',
                'kk_number',
                'religion',
                'nationality',
                'pob',
                'dob',
                'gender',
                'date_applied',

                'ethnic', //
                'blood_type',
                'candidate_from', //
                'applied_position', //
                'recommended_position', //
                'marital_status', //

                'last_educational',
                'study',
                'reference',
                'disability',

                'tag',

                'paspor_number',

                'sim_a',
                'expired_sim_a',

                'sim_b',
                'expired_sim_b',

                'sim_c',
                'expired_sim_c',
                'note',
            )
            ->get();
    }

    public function headings(): array
    {
        return [
            'No.',                     // No.
            'Nama',                    // Name
            'Email',                   // Email
            'Nomor Telepon',           // Phone Number
            'Alamat KTP',              // KTP Address
            'Alamat Saat Ini',         // Current Address
            'Nomor KTP',               // KTP Number
            'Nomor KK',                // KK Number
            'Agama',                   // Religion
            'Kewarganegaraan',         // Nationality
            'Tempat Lahir',            // Place of Birth (POB)
            'Tanggal Lahir',           // Date of Birth (DOB)
            'Jenis Kelamin',           // Gender
            'Tanggal Melamar',         // Date Applied
            'Etnis',                   // Ethnic
            'Golongan Darah',          // Blood Type
            'Sumber Kandidat',         // Candidate From
            'Posisi Dilamar',          // Applied Position
            'Posisi Direkomendasikan', // Recommended Position
            'Status Pernikahan',       // Marital Status
            'Pendidikan Terakhir',     // Last Educational
            'Jurusan',                 // Study
            'Referensi',               // Reference
            'Disabilitas',             // Disability
            'Tag',                     // Tag
            'Nomor Paspor',            // Passport Number
            'SIM A',                   // SIM A
            'Masa Berlaku SIM A',      // Expired SIM A
            'SIM B',                   // SIM B
            'Masa Berlaku SIM B',      // Expired SIM B
            'SIM C',                   // SIM C
            'Masa Berlaku SIM C',      // Expired SIM C
            'Catatan',                 // Note
        ];

    }
    public function map($row): array
    {
        static $number = 1; // Static variable to maintain row numbers
        return [
            $number++,        // Increment and display the row number
            $row->name,
            $row->email,
            $row->phone_number,
            $row->ktp_address,
            $row->current_address,
            $row->ktp_number,
            $row->kk_number,
            $row->religion,
            $row->nationality,
            $row->pob,
            $row->dob,
            $row->gender,
            $row->date_applied,
            $row->ethnic,
            $row->blood_type,
            $row->candidate_from,
            $row->applied_position,
            $row->recommended_position,
            $row->marital_status,
            $row->last_educational,
            $row->study,
            $row->reference,
            $row->disability,
            $row->tag,
            $row->paspor_number,
            $row->sim_a,
            $row->expired_sim_a,
            $row->sim_b,
            $row->expired_sim_b,
            $row->sim_c,
            $row->expired_sim_c,
            $row->note,
        ];
    }
}