<?php

namespace App\Exports;

use App\Models\WorkUnit\Directorate;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class EmployeeCategoryExport implements FromView
{
    public function view() : View
    {
        // Fetch data grouped by directorate, including employee categories
        $directorates = Directorate::with([
            'divisions.positions.employee.employeeCategory',
        ])->get();

        return view('pages.dashboard.table.export.employeeCategoryExport', [
            'directorates' => $directorates,
        ]);
    }
}
