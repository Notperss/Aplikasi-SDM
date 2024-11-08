<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class StoreContractRequest extends FormRequest
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

            'nik_employee' => 'required|string|max:20', // or adjust max length based on requirements
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date', // checks that end date is after or same as start date
            'duration' => 'required|integer|min:1', // assuming duration is in number of days or months
            'contract_number' => 'required|integer|min:1', // assuming this is a numeric sequence
            'description' => 'nullable|string|max:500', // optional field with max character limit
            'file' => 'nullable|file|mimes:pdf|max:2048', // optional file with size limit
        ];
    }
    public function messages()
    {
        return [

            'nik_employee.required' => 'NIK Karyawan wajib diisi.',
            'start_date.required' => 'Tanggal mulai wajib diisi.',
            'end_date.required' => 'Tanggal selesai wajib diisi.',
            'end_date.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai.',
            'duration.required' => 'Durasi wajib diisi.',
            'contract_number.required' => 'Nomor kontrak wajib diisi.',
            'file.mimes' => 'File harus berformat PDF, DOC, atau DOCX.',
            'file.max' => 'File tidak boleh lebih dari 2MB.',
        ];
    }
}
