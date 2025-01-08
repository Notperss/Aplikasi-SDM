<?php

namespace App\Http\Requests\Employee\PersonalData;

use Illuminate\Foundation\Http\FormRequest;

class StoreEducationalHistoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'school_level' => 'required|string|max:100',
            'school_name' => 'required|string|max:255',
            'study' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'year_from' => 'required|integer|min:1900|max:'.date('Y'),
            'year_to' => 'nullable|integer|min:1900|max:'.date('Y'),
            'gpa' => 'nullable|numeric|min:0',
            'file_ijazah' => 'mimes:pdf|max:512',

        ];
    }

    public function messages(): array
    {
        return [
            // School Information
            'school_level.required' => 'jenjang pendidikan wajib diisi.',
            'school_level.max' => 'Tingkat pendidikan tidak boleh lebih dari 100 karakter.',
            'school_name.required' => 'Nama Institut wajib diisi.',
            'school_name.max' => 'Nama Institut tidak boleh lebih dari 255 karakter.',

            // Study
            'study.required' => 'Jurusan wajib diisi.',
            'study.max' => 'Jurusan tidak boleh lebih dari 255 karakter.',

            // Education Years
            'year_from.required' => 'Tahun masuk wajib diisi.',
            'year_from.min' => 'Tahun masuk tidak boleh sebelum 1900.',
            'year_from.max' => 'Tahun masuk tidak boleh melebihi tahun sekarang.',
            'year_to.min' => 'Tahun selesai tidak boleh sebelum 1900.',
            'year_to.max' => 'Tahun selesai tidak boleh melebihi tahun sekarang.',

            // GPA
            'gpa.numeric' => 'GPA harus berupa angka.',
            'gpa.min' => 'GPA minimal adalah 0.',
            'gpa.max' => 'GPA tidak boleh lebih dari 4.0.',

            'file_ijazah.mimes' => 'Ekstensi file ijazah harus berupa pdf.',
            'file_ijazah.max' => 'Ukuran file ijazah maksimal adalah 500KB.',
        ];
    }

}
