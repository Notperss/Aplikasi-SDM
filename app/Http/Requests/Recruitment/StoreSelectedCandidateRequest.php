<?php

namespace App\Http\Requests\Recruitment;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\PositionExistsAndSelectionNotFinished;

class StoreSelectedCandidateRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna diizinkan untuk membuat permintaan ini.
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Aturan validasi yang berlaku untuk permintaan ini.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules() : array
    {
        if ($this->has('candidates')) {
            // Decode the JSON string into an array
            $candidates = json_decode($this->input('candidates'), true);

            // Replace the 'candidates' input with the decoded array for validation
            $this->merge([
                'candidates' => $candidates,
            ]);
        }

        return [
            'name' => 'required|string', // Validate that the array of candidates exists and isn't empty
            'fptk_number' => 'required|string', // Validate that the array of candidates exists and isn't empty
            'candidates' => 'required|array|min:1', // Validate that the array of candidates exists and isn't empty
            'candidates.*.id' => 'required|exists:candidates,id', // Ensure each candidate ID exists in the database
            'division_id' => 'required|exists:divisions,id', // Ensure each candidate ID exists in the database
            'position_id' => ['required', 'exists:positions,id', new PositionExistsAndSelectionNotFinished],
            'interviewer' => 'required|string', // Memastikan ID kandidat ada di database
            'start_selection' => 'nullable|date', // Memastikan ID kandidat ada di database
            'end_selection' => 'nullable|date', // Memastikan ID kandidat ada di database
            'file_selection' => 'mimes:pdf|max:512',

        ];
    }

    /**
     * Pesan kesalahan untuk aturan validasi yang telah ditentukan.
     *
     * @return array<string, string>
     */
    public function messages() : array
    {
        return [
            'candidates.required' => 'Silakan pilih setidaknya satu kandidat.',
            'candidates.*.id.required' => 'Setiap kandidat harus memiliki ID.',
            'candidates.array' => 'Data kandidat harus berupa array.',
            'candidates.*.id.exists' => 'Kandidat yang dipilih tidak ada dalam database.',

            'name.required' => 'Nama Seleksi wajib diisi.',
            'position_id.required' => 'Posisi wajib diisi.',
            'position_id.exists' => 'Posisi yang dipilih tidak valid atau tidak ada dalam database.',

            'interviewer.required' => 'Nama pewawancara wajib diisi.',
            'interviewer.string' => 'Nama pewawancara harus berupa teks yang valid.',

            'start_selection.required' => 'Tanggal mulai seleksi wajib diisi.',
            'start_selection.date' => 'Tanggal mulai seleksi harus berupa tanggal yang valid.',

            'end_selection.date' => 'Tanggal selesai seleksi harus berupa tanggal yang valid.',

            'file_selection.mimes' => 'File seleksi harus berupa PDF.',
            'file_selection.max' => 'Ukuran file seleksi tidak boleh lebih dari 500KB.',
        ];
    }
}
