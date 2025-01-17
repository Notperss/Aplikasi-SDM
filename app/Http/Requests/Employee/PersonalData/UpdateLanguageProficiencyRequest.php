<?php

namespace App\Http\Requests\Employee\PersonalData;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLanguageProficiencyRequest extends FormRequest
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
            'language' => 'required|string|max:100',
            'speaking' => 'required|in:Cukup,Baik,Sangat Baik',
            'listening' => 'required|in:Cukup,Baik,Sangat Baik',
            'writing' => 'required|in:Cukup,Baik,Sangat Baik',
            'reading' => 'required|in:Cukup,Baik,Sangat Baik',
        ];
    }

    public function messages() : array
    {
        return [

            // Language
            'language.required' => 'Bahasa wajib diisi.',
            'language.string' => 'Bahasa harus berupa teks.',
            'language.max' => 'Nama bahasa tidak boleh lebih dari 100 karakter.',

            // Speaking Proficiency
            'speaking.required' => 'Kemampuan berbicara wajib diisi.',
            'speaking.in' => 'Kemampuan berbicara harus berupa "cukup", "baik", atau "sangat baik".',

            // Listening Proficiency
            'listening.required' => 'Kemampuan mendengar wajib diisi.',
            'listening.in' => 'Kemampuan mendengar harus berupa "cukup", "baik", atau "sangat baik".',

            // Writing Proficiency
            'writing.required' => 'Kemampuan menulis wajib diisi.',
            'writing.in' => 'Kemampuan menulis harus berupa "cukup", "baik", atau "sangat baik".',

            // Reading Proficiency
            'reading.required' => 'Kemampuan membaca wajib diisi.',
            'reading.in' => 'Kemampuan membaca harus berupa "cukup", "baik", atau "sangat baik".',
        ];
    }
}
