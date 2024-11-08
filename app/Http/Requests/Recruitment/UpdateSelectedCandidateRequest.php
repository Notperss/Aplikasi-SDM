<?php

namespace App\Http\Requests\Recruitment;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\PositionExistsAndSelectionNotFinished;

class UpdateSelectedCandidateRequest extends FormRequest
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
            // 'candidates' => 'required|array|min:1', // Validate that the array of candidates exists and isn't empty
            // 'candidates.*.id' => 'required|exists:candidates,id', // Ensure each candidate ID exists in the database
            'name' => 'required|string', // Memastikan ID kandidat ada di database
            'fptk_number' => 'required|string', // Validate that the array of candidates exists and isn't empty
            // 'position_id' => ['required', 'exists:positions,id', new PositionExistsAndSelectionNotFinished],
            'position_id' => ['required', 'exists:positions,id'],
            'division_id' => 'required|exists:divisions,id', // Memastikan ID kandidat ada di database
            'interviewer' => 'required|string', // Memastikan ID kandidat ada di database
            'start_selection' => 'nullable|date', // Memastikan ID kandidat ada di database
            'end_selection' => 'nullable|date',
            'file_selection' => 'mimes:pdf|max:512',

        ];
    }

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
