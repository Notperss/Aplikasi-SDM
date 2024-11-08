<?php

namespace App\Http\Requests\Employee;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules() : array
    {

        return [
            'company_id' => 'nullable|integer|exists:companies,id',
            // 'candidate_id' => 'required|integer|exists:candidates,id',
            // 'position_id' => 'nullable|integer|exists:positions,id',
            // 'employee_category_id' => 'required|integer|exists:employee_categories,id',
            // 'employee_status' => 'required|string|max:50',
            // 'work_status' => 'required|string|max:50',
            // 'work_relationship' => 'required|string|max:50',
            // 'date_joining' => 'required|date',
            // 'date_leaving' => 'nullable|date|after:date_joining',
            // 'nik' => 'required|string',

            'name' => 'required|string|max:255',
            'email' => [
                'nullable',
                'string',
                'email',
                Rule::unique('employees', 'email')->ignore($this->employee),
            ],
            'phone_number1' => 'required|string|max:15',
            'ktp_address' => 'required|string|max:255',
            'current_address' => 'required|string|max:255',
            'ktp_number' => ['required', 'digits:16', Rule::unique('employees', 'ktp_number')->ignore($this->employee),],
            'kk_number' => ['nullable', 'digits:16', Rule::unique('employees', 'kk_number')->ignore($this->employee),],
            // 'kk_number' => 'nullable|digits:16|unique:candidates,kk_number',
            'last_educational' => 'required|string|max:100',
            'study' => 'required|string|max:100',
            'marital_status' => 'required|string|max:50',
            'candidate_from' => 'required|string|max:100',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:512',
            'religion' => 'nullable|string|max:50',
            'nationality' => 'nullable|string|max:50',
            'height' => 'nullable|integer|min:0',
            'weight' => 'nullable|integer|min:0',
            'pob' => 'required|string|max:255',
            'dob' => 'required|date|before:today',
            'gender' => 'required|string|in:LAKI-LAKI,PEREMPUAN',
            'blood_type' => 'nullable|string|max:3',


            'bpjs_kesehatan_number' => 'nullable|string|max:20',
            'bpjs_naker_number' => 'nullable|string|max:20',
            'zipcode_ktp' => 'nullable|string|max:10',
            'phone_number2' => 'nullable|string|max:15',
            'npwp_number' => ['nullable', 'string', 'max:20', Rule::unique('employees', 'npwp_number')->ignore($this->employee)],
            'glasses' => 'nullable|boolean',
            'paspor_number' => ['nullable', 'string', Rule::unique('employees', 'paspor_number')->ignore($this->employee)],
            'file_kk' => 'nullable|mimes:pdf|max:512',
            'file_ktp' => 'nullable|mimes:pdf|max:512',
            'file_cv' => 'nullalble|mimes:pdf|max:512',
            'file_skck' => 'nullable|mimes:pdf|max:512',
            'file_ijazah' => 'nullable|mimes:pdf|max:512',
            'file_sertifikat' => 'nullable|mimes:pdf|max:512',
            'file_vaksin' => 'nullable|mimes:pdf|max:512',
            'file_surat_sehat' => 'nullable|mimes:pdf|max:512',
            'longitude_ktp' => 'nullable|numeric',
            'longitude_domisili' => 'nullable|numeric',
            'latitude_ktp' => 'nullable|numeric',
            'latitude_domisili' => 'nullable|numeric',
            'sim_a' => 'nullable|string|max:15',
            'sim_b' => 'nullable|string|max:15',
            'sim_c' => 'nullable|string|max:15',
            'expired_sim_a' => 'nullable|date',
            'expired_sim_b' => 'nullable|date',
            'expired_sim_c' => 'nullable|date',
            'file_sim_a' => 'nullable|mimes:jpg,jpeg,png,pdf|max:512',
            'file_sim_b' => 'nullable|mimes:jpg,jpeg,png,pdf|max:512',
            'file_sim_c' => 'nullable|mimes:jpg,jpeg,png,pdf|max:512',
        ];
    }


    public function messages() : array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'integer' => ':attribute harus berupa angka.',
            'string' => ':attribute harus berupa teks.',
            'email' => ':attribute harus berupa alamat email yang valid.',
            'unique' => ':attribute sudah digunakan.',
            'digits' => ':attribute harus terdiri dari :digits angka.',
            'max' => ':attribute tidak boleh lebih dari :max karakter.',
            'date' => ':attribute harus berupa tanggal yang valid.',
            'before' => ':attribute harus sebelum tanggal saat ini.',
            'image' => ':attribute harus berupa file gambar.',
            'mimes' => ':attribute harus berupa file dengan format: :values.',
            'numeric' => ':attribute harus berupa angka.',
            'boolean' => ':attribute harus bernilai benar atau salah.',
            'in' => ':attribute tidak valid.',
        ];
    }

    public function attributes() : array
    {
        return [
            'nik' => 'NIK',
            'company_id' => 'ID Perusahaan',
            'candidate_id' => 'ID Kandidat',
            'position_id' => 'ID Posisi',
            'employee_category_id' => 'ID Kategori Karyawan',
            'name' => 'Nama',
            'email' => 'Email',
            'phone_number1' => 'Nomor Telepon 1',
            'ktp_address' => 'Alamat KTP',
            'current_address' => 'Alamat Domisili',
            'ktp_number' => 'Nomor KTP',
            'kk_number' => 'Nomor KK',
            'last_educational' => 'Pendidikan Terakhir',
            'study' => 'Jurusan',
            'marital_status' => 'Status Pernikahan',
            'candidate_from' => 'Sumber Kandidat',
            'photo' => 'Foto',
            'religion' => 'Agama',
            'nationality' => 'Kewarganegaraan',
            'height' => 'Tinggi Badan',
            'weight' => 'Berat Badan',
            'pob' => 'Tempat Lahir',
            'dob' => 'Tanggal Lahir',
            'gender' => 'Jenis Kelamin',
            'blood_type' => 'Golongan Darah',
            'employee_status' => 'Status Karyawan',
            'work_status' => 'Status Kerja',
            'work_relationship' => 'Hubungan Kerja',
            'date_joining' => 'Tanggal Bergabung',
            'date_leaving' => 'Tanggal Keluar',
            'bpjs_kesehatan_number' => 'Nomor BPJS Kesehatan',
            'bpjs_naker_number' => 'Nomor BPJS Ketenagakerjaan',
            'zipcode_ktp' => 'Kode Pos KTP',
            'phone_number2' => 'Nomor Telepon 2',
            'npwp_number' => 'Nomor NPWP',
            'glasses' => 'Memakai Kacamata',
            'paspor_number' => 'Nomor Paspor',
            'file_kk' => 'File KK',
            'file_ktp' => 'File KTP',
            'file_cv' => 'File CV',
            'file_skck' => 'File SKCK',
            'file_ijazah' => 'File Ijazah',
            'file_sertifikat' => 'File Sertifikat',
            'file_vaksin' => 'File Vaksin',
            'file_surat_sehat' => 'File Surat Sehat',
            'longitude_ktp' => 'Garis Bujur KTP',
            'longitude_domisili' => 'Garis Bujur Domisili',
            'latitude_ktp' => 'Garis Lintang KTP',
            'latitude_domisili' => 'Garis Lintang Domisili',
            'sim_a' => 'SIM A',
            'sim_b' => 'SIM B',
            'sim_c' => 'SIM C',
            'expired_sim_a' => 'Masa Berlaku SIM A',
            'expired_sim_b' => 'Masa Berlaku SIM B',
            'expired_sim_c' => 'Masa Berlaku SIM C',
            'file_sim_a' => 'File SIM A',
            'file_sim_b' => 'File SIM B',
            'file_sim_c' => 'File SIM C',
        ];
    }
}
