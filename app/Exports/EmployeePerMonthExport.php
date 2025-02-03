<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EmployeePerMonthExport implements FromView
{
    protected $employees;
    protected $selectedMonth;
    protected $selectedYear;

    public function __construct($employees, $selectedMonth, $selectedYear)
    {
        $this->employees = $employees;
        $this->selectedMonth = $selectedMonth;
        $this->selectedYear = $selectedYear;
    }

    public function view(): View
    {
        return view('pages.employee.export', [
            'employees' => $this->employees,
            'selectedMonth' => $this->selectedMonth,
            'selectedYear' => $this->selectedYear,
        ]);
    }
}
