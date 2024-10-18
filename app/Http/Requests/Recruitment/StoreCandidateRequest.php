<?php

namespace App\Http\Requests\Recruitment;

use Illuminate\Foundation\Http\FormRequest;

class StoreCandidateRequest extends FormRequest
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
            'email' => ['nullable', 'string', 'email', 'unique:candidates,email'],
            // 'email' => ['required', 'string', 'email', 'unique:candidates,email'],
            'phone_number' => ['required',],
            'ktp_address' => ['required', 'string'],
            'current_address' => ['required', 'string'],
            'ktp_number' => ['required', 'digits:16', 'unique:candidates,ktp_number'],
            'kk_number' => ['nullable', 'digits:16', 'unique:candidates,kk_number'],
            // 'npwp_number' => [
            //     'required', 'digits:16',
            //     // 'regex:/^\d{2}\.\d{3}\.\d{3}\.\d{1}-\d{3}\.\d{3}$/',
            //     'unique:candidates,npwp_number',
            // ],

            'last_educational' => 'required',
            'study' => 'required',
            'marital_status' => 'required',

            'photo' => 'image|mimes:jpg,jpeg,png|max:512',
            'religion' => ['nullable', 'string'],
            'nationality' => ['nullable', 'string'],
            // 'height' => ['required', 'integer'],
            // 'weight' => ['required', 'integer'],
            'pob' => ['required', 'string'],
            'dob' => ['required', 'date', 'before:today'],
            'gender' => ['required', 'string', 'in:LAKI-LAKI,PEREMPUAN'],
            'date_applied' => ['nullable', 'date'],

            'paspor_number' => ['nullable', 'unique:candidates,paspor_number'],

            'file_kk' => 'mimes:pdf|max:512',
            'file_ktp' => 'mimes:pdf|max:512',
            'file_cv' => 'mimes:pdf|max:512',
            'file_skck' => 'mimes:pdf|max:512',
            'file_ijazah' => 'mimes:pdf|max:512',
            'file_sertifikat' => 'mimes:pdf|max:512',
            'file_vaksin' => 'mimes:pdf|max:512',
            'file_surat_sehat' => 'mimes:pdf|max:512',

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
