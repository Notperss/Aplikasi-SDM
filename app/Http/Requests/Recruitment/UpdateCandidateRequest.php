<?php

namespace App\Http\Requests\Recruitment;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCandidateRequest extends FormRequest
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
            'name' => ['required', 'string'],
            // 'email' => ['required', 'string', 'email', Rule::unique('candidates')->ignore($this->candidate)],
            'email' => ['nullable', 'string', 'email', Rule::unique('candidates')->ignore($this->candidate)],
            'phone_number' => ['nullable',],
            'ktp_address' => ['nullable', 'string'],
            'current_address' => ['nullable', 'string'],
            'ktp_number' => ['nullable', 'digits:16', Rule::unique('candidates')->ignore($this->candidate)],
            'kk_number' => ['nullable', 'digits:16', Rule::unique('candidates')->ignore($this->candidate)],
            // 'npwp_number' => [
            //     'nullable',
            //     // 'digits:16',
            //     // 'regex:/^\d{2}\.\d{3}\.\d{3}\.\d{1}-\d{3}\.\d{3}$/',
            //     Rule::unique('candidates')->ignore($this->candidate),
            // ],
            'religion' => ['nullable', 'string'],
            'nationality' => ['nullable', 'string'],

            'last_educational' => 'nullable',
            'study' => 'nullable',
            'marital_status' => 'nullable',

            // 'height' => ['nullable', 'integer'],
            // 'weight' => ['nullable', 'integer'],
            'pob' => ['nullable', 'string'],
            'dob' => ['nullable', 'date', 'before:today'],
            'gender' => ['nullable', 'string', 'in:LAKI-LAKI,PEREMPUAN'],
            'date_applied' => ['nullable', 'date'],
            'photo' => 'image|mimes:jpg,jpeg,png|max:512',

            'paspor_number' => ['nullable', Rule::unique('candidates')->ignore($this->candidate)],

            $validateFile = 'mimes:pdf|max:512',

            'file_kk' => $validateFile,
            'file_ktp' => $validateFile,
            'file_cv' => $validateFile,
            'file_skck' => $validateFile,
            'file_ijazah' => $validateFile,
            'file_sertifikat' => $validateFile,
            'file_vaksin' => $validateFile,
            'file_surat_sehat' => $validateFile,

            'file_sim_a' => 'mimes:jpg,jpeg,png,pdf|max:512',
            'file_sim_b' => 'mimes:jpg,jpeg,png,pdf|max:512',
            'file_sim_c' => 'mimes:jpg,jpeg,png,pdf|max:512',
        ];
    }

    public function messages() : array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',

            'email.required' => 'Email wajib diisi.',
            'email.string' => 'Email harus berupa teks.',
            'email.email' => 'Format email tidak valid.',

            'phone_number.required' => 'Nomor telepon wajib diisi.',
            'phone_number.integer' => 'Nomor telepon harus berupa angka.',

            'ktp_address.required' => 'Alamat KTP wajib diisi.',
            'ktp_address.string' => 'Alamat KTP harus berupa teks.',

            'last_educational.required' => 'Pendidikan Terakhir ini wajib diisi.',
            'study.required' => 'Jurusan wajib diisi.',

            'marital_status.required' => 'Status Perkawinan wajib diisi.',

            'current_address.required' => 'Alamat Domisili wajib diisi.',
            'current_address.string' => 'Alamat saat ini harus berupa teks.',

            'npwp_number.required' => 'Nomor NPWP wajib diisi.',
            'npwp_number.integer' => 'Nomor NPWP harus berupa angka.',
            // 'npwp_number.regex' => 'Format Nomor NPWP tidak valid. Harus dalam format 99.999.999.9-999.999.',
            'npwp_number.digits' => 'Nomor KTP harus terdiri dari 16 digit angka.',
            'npwp_number.unique' => 'Nomor NPWP sudah terdaftar.',


            'ktp_number.required' => 'Nomor KTP wajib diisi.',
            'ktp_number.integer' => 'Nomor KTP harus berupa angka.',
            'ktp_number.digits' => 'Nomor KTP harus terdiri dari 16 digit angka.',
            'ktp_number.unique' => 'Nomor NPWP sudah terdaftar.',

            'kk_number.required' => 'Nomor KK wajib diisi.',
            'kk_number.integer' => 'Nomor KK harus berupa angka.',
            'kk_number.digits' => 'Nomor KK harus terdiri dari 16 digit angka.',
            'kk_number.unique' => 'Nomor NPWP sudah terdaftar.',

            'religion.required' => 'Agama wajib diisi.',
            'religion.string' => 'Agama harus berupa teks.',

            'nationality.required' => 'Kewarganegaraan wajib diisi.',
            'nationality.string' => 'Kewarganegaraan harus berupa teks.',

            'height.required' => 'Tinggi badan wajib diisi.',
            'height.integer' => 'Tinggi badan harus berupa angka.',

            'weight.required' => 'Berat badan wajib diisi.',
            'weight.integer' => 'Berat badan harus berupa angka.',

            'pob.required' => 'Tempat lahir wajib diisi.',
            'pob.string' => 'Tempat lahir harus berupa teks.',

            'dob.required' => 'Tanggal lahir wajib diisi.',
            'dob.date' => 'Tanggal lahir harus berupa format tanggal yang valid.',
            'dob.before' => 'Tanggal lahir harus sebelum hari ini.',

            'gender.required' => 'Jenis kelamin wajib diisi.',
            'gender.string' => 'Jenis kelamin harus berupa teks.',
            'gender.in' => 'Jenis kelamin harus salah satu dari: laki-laki, atau perempuan.',

            'date_applied.date' => 'Tanggal diterapkan harus berupa format tanggal yang valid.',

            'photo.required' => 'File gambar wajib diunggah.',
            'photo.image' => 'File harus berupa gambar.',
            'photo.mimes' => 'Ekstensi file harus berupa jpg, jpeg, atau png.',
            'photo.max' => 'Ukuran file maksimal adalah 500KB.',

            'file_kk.mimes' => 'Ekstensi file KK harus berupa pdf.',
            'file_kk.max' => 'Ukuran file KK maksimal adalah 500KB.',

            'file_ktp.mimes' => 'Ekstensi file KTP harus berupa pdf.',
            'file_ktp.max' => 'Ukuran file KTP maksimal adalah 500KB.',

            'file_skck.mimes' => 'Ekstensi file SKCK harus berupa pdf.',
            'file_skck.max' => 'Ukuran file SKCK maksimal adalah 500KB.',

            'file_cv.mimes' => 'Ekstensi file CV harus berupa pdf.',
            'file_cv.max' => 'Ukuran file CV maksimal adalah 500KB.',
            'file_cv.required' => 'File CV wajib diunggah.',

            'paspor_number.unique' => 'Nomor paspor sudah terdaftar.',
            'paspor_number.max_digits' => 'Nomor paspor tidak boleh lebih dari 10 digit.',
            'paspor_number.min_digits' => 'Nomor paspor tidak boleh kurang dari 6 digit.',

            'file_sim_a.mimes' => 'Ekstensi file harus berupa jpg, jpeg,png, atau pdf.',
            'file_sim_a.max' => 'Ukuran file maksimal adalah 500KB.',

            'file_sim_b.mimes' => 'Ekstensi file harus berupa jpg, jpeg,png, atau pdf.',
            'file_sim_b.max' => 'Ukuran file maksimal adalah 500KB.',

            'file_sim_c.mimes' => 'Ekstensi file harus berupa jpg, jpeg,png, atau pdf.',
            'file_sim_c.max' => 'Ukuran file maksimal adalah 500KB.',
        ];
    }
}
