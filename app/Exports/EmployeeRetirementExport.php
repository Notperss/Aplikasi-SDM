<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Employee\Employee;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class EmployeeRetirementExport implements FromView
{
    protected $additionalYears;

    public function __construct($additionalYears = 0)
    {
        $this->additionalYears = $additionalYears;
    }

    public function view(): View
    {
        $employees = Employee::when(! Auth::user()->hasRole('super-admin'), function ($query) {
            $query->where('company_id', Auth::user()->company_id);
        })
            ->where('employee_status', 'AKTIF')
            ->get()
            ->filter(function ($employee) {
                $retirementDate = Carbon::parse($employee->dob)->addYears(55);
                $currentYear = now()->year;

                return $retirementDate->year <= ($currentYear + $this->additionalYears);
            })
            ->sortByDesc('dob');

        return view('pages.employee.export', compact('employees'));
    }
}
