<?php
namespace App\Http\Requests\Employee\PersonalData;

use Illuminate\Foundation\Http\FormRequest;

class StoreFamilyDetailRequest extends FormRequest
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
            'employee_id' => ['required', 'integer', 'exists:employees,id'],
            'relation' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'in:LAKI-LAKI,PEREMPUAN'], // Enum for gender validation
            'name' => ['required', 'string', 'max:255'],
            'education' => ['nullable', 'string', 'max:255'], // Can be nullable if it's optional
            'job' => ['nullable', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'min:10', 'max:15', 'regex:/^[0-9]+$/'], // Only numbers allowed
            'address' => ['required', 'string', 'max:500'],
            'dob_family' => ['required', 'date', 'before:today'], // Valid date and must be in the past
            'is_in_kk' => ['nullable', 'boolean'], // Valid date and must be in the past
        ];
    }

    public function messages() : array
    {
        return [
            'employee_id.required' => 'ID karyawan wajib diisi.',
            'employee_id.integer' => 'ID karyawan harus berupa angka.',
            'employee_id.exists' => 'ID karyawan tidak ditemukan di database.',

            'relation.required' => 'Hubungan keluarga wajib diisi.',
            'relation.string' => 'Hubungan keluarga harus berupa teks.',
            'relation.max' => 'Hubungan keluarga maksimal 255 karakter.',

            'gender.required' => 'Jenis kelamin wajib diisi.',
            'gender.in' => 'Jenis kelamin harus diisi dengan "laki-laki" atau "perempuan".',

            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama maksimal 255 karakter.',

            'education.string' => 'Pendidikan terakhir harus berupa teks.',
            'education.max' => 'Pendidikan terakhir maksimal 255 karakter.',

            'job.string' => 'Pekerjaan terakhir harus berupa teks.',
            'job.max' => 'Pekerjaan terakhir maksimal 255 karakter.',

            'phone_number.required' => 'Nomor telepon wajib diisi.',
            'phone_number.string' => 'Nomor telepon harus berupa teks.',
            'phone_number.min' => 'Nomor telepon minimal 10 karakter.',
            'phone_number.max' => 'Nomor telepon maksimal 15 karakter.',
            'phone_number.regex' => 'Nomor telepon hanya boleh terdiri dari angka.',

            'address.required' => 'Alamat wajib diisi.',
            'address.string' => 'Alamat harus berupa teks.',
            'address.max' => 'Alamat maksimal 500 karakter.',

            'dob.required' => 'Tanggal lahir wajib diisi.',
            'dob.date' => 'Tanggal lahir harus berupa tanggal yang valid.',
            'dob.before' => 'Tanggal lahir harus sebelum hari ini.',
        ];
    }

}
