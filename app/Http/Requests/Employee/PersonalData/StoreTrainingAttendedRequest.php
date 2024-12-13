<?php

namespace App\Http\Requests\Employee\PersonalData;

use Illuminate\Foundation\Http\FormRequest;

class StoreTrainingAttendedRequest extends FormRequest
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
        if ($this->has('employees')) {
            // Decode the JSON string into an array
            $employees = json_decode($this->input('employees'), true);

            // Replace the 'employees' input with the decoded array for validation
            $this->merge([
                'employees' => $employees,
            ]);
        }
        return [
            'employee_id' => 'nullable|exists:employees,id',
            'training_name' => 'required|string|max:255',
            'organizer_name' => 'required|string|max:255',
            // 'year' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'city' => 'nullable|max:255',
            'file_sertifikat' => 'nullable|mimes:pdf,jpeg,jpg,png|max:2048',
            'employees' => $this->has('employees') ? 'required|array' : 'nullable',
            'employees.*' => 'exists:employees,id', // Validate employee IDs exist in the database
        ];
    }

    public function messages() : array
    {
        return [
            'employee_id.required' => 'ID karyawan wajib diisi.',
            'employee_id.exists' => 'karyawan yang dipilih tidak ditemukan.',
            'training_name.required' => 'Nama pelatihan wajib diisi.',
            'organizer_name.required' => 'Nama penyelenggara wajib diisi.',
            'year.required' => 'Tahun pelatihan wajib diisi.',
            'year.digits' => 'Tahun harus terdiri dari 4 angka.',
            'year.min' => 'Tahun harus lebih besar dari 1900.',
            'year.max' => 'Tahun tidak boleh lebih dari tahun ini.',
            'city.max' => 'Tempat/Kota terlalu panjang.',
            'file_sertifikat.mimes' => 'File sertifikat harus berupa PDF, JPEG, JPG, atau PNG.',
            'file_sertifikat.max' => 'Ukuran file sertifikat tidak boleh lebih dari 2MB.',
        ];
    }
}
