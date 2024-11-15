<?php

namespace App\Imports;

use DateTime;
use App\Models\Employee\Contract;
use App\Models\Employee\Employee;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;

class ImportContract implements ToModel, WithStartRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function startRow() : int
    {
        return 2; // This will start reading from the second row (index 1).
    }
    public function model(array $row)
    {

        $employee = Employee::where('nik', $row[1])->first();

        if ($employee) {
            $employeeId = $employee->id;
        } else {
            return redirect()->back()->with('error', "Employee with NIK number {$row[1]} not found.");
        }

        // $start_date = ! empty($row[3]) ? DateTime::createFromFormat('d/m/Y', $row[3]) : null;
        // $end_date = ! empty($row[4]) ? DateTime::createFromFormat('d/m/Y', $row[4]) : null;

        $start_date = ! empty($row[2]) && is_string($row[2]) ? DateTime::createFromFormat('d/m/Y', $row[2]) : null;
        $end_date = ! empty($row[3]) && is_string($row[3]) ? DateTime::createFromFormat('d/m/Y', $row[3]) : null;


        return new Contract([
            'company_id' => ! empty($row[10]) ? $row[10] : Auth::user()->company_id,
            'employee_id' => $employeeId,
            'contract_number' => ! empty($row[0]) ? $row[0] : null,
            'nik_employee' => ! empty($row[1]) ? $row[1] : '',
            'start_date' => $start_date ? $start_date->format('Y-m-d') : '',
            'end_date' => $end_date ? $end_date->format('Y-m-d') : '',
            'duration' => ! empty($row[4]) ? $row[4] : '',
            'contract_sequence_number' => ! empty($row[5]) ? $row[5] : '',
            'description' => ! empty($row[6]) ? $row[6] : '',
        ]);
    }

    public function rules() : array
    {
        return [
            '10' => 'nullable|exists:companies,id', // company_id should exist in companies table
            // '1' => 'nullable|exists:employees,id', // employee_id should exist in employees table
            '0' => 'required|string|max:50|unique:contracts,contract_number', // contract_number should be a string with max 50 characters
            '1' => 'required|exists:employees,nik', // nik_employee should be a string
            '2' => 'required|date_format:d/m/Y', // start_date should follow the given format
            '3' => 'required|date_format:d/m/Y', // end_date should be after or equal to start_date
            '4' => 'nullable|integer|min:1', // duration should be an integer and at least 1
            '5' => 'required|integer|min:1', // contract_sequence_number should be an integer and at least 1
            '6' => 'nullable|max:255', // description should be a string with max 255 characters
        ];
    }

    public function customValidationMessages() : array
    {
        return [
            '0.required' => 'Contract Number is required.',
            '0.unique' => 'Contract Number already exist.',
            '1.required' => 'NIK Employee is required.',
            '1.exists' => 'The NIK Employee does not exist.',
            '2.required' => 'Tanggal Mulai is required.',
            '2.date_format' => 'Start Date should be in the format dd/mm/yyyy.',
            '3.required' => 'Tanggal Selesai is required.',
            '3.date_format' => 'End Date should be in the format dd/mm/yyyy.',
            // '4.after_or_equal' => 'End Date should be after or equal to Start Date.',
            '4.integer' => 'Duration must be an integer.',
            '5.required' => 'kontrak Ke- is required.',
            '5.integer' => 'kontrak Ke- must be an integer.',
        ];
    }


}
