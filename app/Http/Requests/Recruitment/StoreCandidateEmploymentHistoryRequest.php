<?php

namespace App\Http\Requests\Recruitment;

use Illuminate\Foundation\Http\FormRequest;

class StoreCandidateEmploymentHistoryRequest extends FormRequest
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
            'candidate_id' => 'required|integer|exists:candidates,id',
            'company_name' => 'required|string|max:255',
            'company_type' => 'string|max:100',
            'direct_supervisor' => 'string|max:255',
            // 'address' => 'required|string|max:255',
            // 'phone_number' => 'required|string|max:15',
            'year_from' => 'required|integer|min:1900|max:' . date('Y'),
            'year_to' => 'nullable|integer|min:1900|max:' . date('Y'),
            'position' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
            'reason' => 'required|string|max:255',
            'job_description' => 'string|max:1000',
            'file' => 'mimes:pdf|max:512',
        ];
    }

    public function messages() : array
    {
        return [
            // Candidate ID
            'candidate_id.required' => 'ID Kandidat wajib diisi.',
            'candidate_id.integer' => 'ID Kandidat harus berupa angka.',
            'candidate_id.exists' => 'ID Kandidat harus ada di dalam tabel kandidat.',

            // Company Information
            'company_name.required' => 'Nama perusahaan wajib diisi.',
            'company_name.max' => 'Nama perusahaan tidak boleh lebih dari 255 karakter.',
            'company_type.required' => 'Tipe perusahaan wajib diisi.',
            'company_type.max' => 'Tipe perusahaan tidak boleh lebih dari 100 karakter.',
            'direct_supervisor.required' => 'Supervisor langsung wajib diisi.',

            // Address & Contact Information
            // 'address.required' => 'Alamat perusahaan wajib diisi.',
            // 'phone_number.required' => 'Nomor telepon wajib diisi.',
            // 'phone_number.max' => 'Nomor telepon tidak boleh lebih dari 15 karakter.',

            // Employment Dates
            'year_from.required' => 'Tahun masuk wajib diisi.',
            'year_from.min' => 'Tahun masuk tidak boleh sebelum 1900.',
            'year_from.max' => 'Tahun masuk tidak boleh melebihi tahun sekarang.',
            'year_to.min' => 'Tahun keluar tidak boleh sebelum 1900.',
            'year_to.max' => 'Tahun keluar tidak boleh melebihi tahun sekarang.',

            // Job Position & Salary
            'position.required' => 'Posisi wajib diisi.',
            'salary.required' => 'Gaji wajib diisi.',
            'salary.numeric' => 'Gaji harus berupa angka.',
            'salary.min' => 'Gaji minimal adalah 0.',

            // Reason for Leaving & Job Description
            'reason.required' => 'Alasan keluar wajib diisi.',
            'job_description.required' => 'Deskripsi pekerjaan wajib diisi.',

            'file.mimes' => 'Ekstensi file harus berupa pdf.',
            'file.max' => 'Ukuran file maksimal adalah 500KB.',
        ];
    }

}
