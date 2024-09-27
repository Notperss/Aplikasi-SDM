<?php

namespace App\Http\Requests\ManagementAccess;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // Image validation
            'description' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Nama perusahaan wajib diisi.',
            'name.max' => 'Nama perusahaan tidak boleh lebih dari 255 karakter.',
            'address.required' => 'Alamat wajib diisi.',
            'address.max' => 'Alamat tidak boleh lebih dari 500 karakter.',
            'logo.image' => 'File logo harus berupa gambar.',
            'logo.mimes' => 'Logo harus berformat: jpg, jpeg, png, gif.',
            'logo.max' => 'Ukuran logo tidak boleh lebih dari 2MB.',
            'description.max' => 'Deskripsi tidak boleh lebih dari 1000 karakter.',
        ];
    }
}
