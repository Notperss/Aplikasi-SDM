<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Employee\PersonalData\Attendance;

class AttendanceExport implements FromView
{
    public function view() : View
    {
        $selectedYear = request('year', Carbon::now()->year);
        $selectedMonth = request('month', Carbon::now()->month);

        $nik = request('nik');
        $employeeName = request('name');

        // Validate year and month inputs
        request()->validate([
            'year' => 'nullable|integer|min:2015|max:' . Carbon::now()->year,
            'month' => 'nullable|integer|min:1|max:12',
        ]);

        $employeeAttendances = Attendance::query()
            ->when($selectedMonth, fn ($query) => $query->whereMonth('date', $selectedMonth))
            ->when($selectedYear, fn ($query) => $query->whereYear('date', $selectedYear))
            ->when($nik, fn ($query) => $query->where('nik', $nik)) // Fixed condition
            ->get();

        // $employeeName = $employeeAttendances->first()?->employee->name ?? 'Unknown';

        return view('pages.employee.personal-data.form.employee-attendance.export', compact('employeeAttendances', 'selectedYear', 'selectedMonth', 'employeeName', 'nik'));
    }
}
