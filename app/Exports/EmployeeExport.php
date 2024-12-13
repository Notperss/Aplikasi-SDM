<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Employee\Employee;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class EmployeeExport implements FromView, WithColumnFormatting
{
    protected $startDate;
    protected $endDate;
    protected $employeeStatus;

    public function __construct($startDate, $endDate, $employeeStatus)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->employeeStatus = $employeeStatus;
    }

    public function view() : View
    {
        $employees = Employee::with('employeeCategory', 'employeeCareers')
            ->when(! Auth::user()->hasRole('super-admin'), function ($query) {
                $query->where('company_id', Auth::user()->company_id);
            })
            ->when($this->employeeStatus, function ($query) {
                if ($this->employeeStatus === 'NONAKTIF') {
                    $query->where('employee_status', '!=', 'AKTIF');
                } else {
                    $query->where('employee_status', $this->employeeStatus);
                }
            })
            ->when($this->startDate && $this->endDate, function ($query) {
                $query->whereBetween('date_joining', [$this->startDate, $this->endDate]);
            })
            ->whereNotNull('nik')
            ->latest()
            ->get();

        return view('pages.employee.export', compact('employees'));
    }

    public function columnFormats() : array
    {
        return [
            'K' => NumberFormat::FORMAT_NUMBER, // Adjust the column (e.g., 'A') for the numeric data
            'L' => NumberFormat::FORMAT_NUMBER,
            'M' => NumberFormat::FORMAT_NUMBER,
            'N' => NumberFormat::FORMAT_NUMBER,
            'O' => NumberFormat::FORMAT_NUMBER,
            'P' => NumberFormat::FORMAT_NUMBER,
            'U' => NumberFormat::FORMAT_NUMBER,
            'V' => NumberFormat::FORMAT_NUMBER,
            // Add other columns as needed
        ];
    }

}
