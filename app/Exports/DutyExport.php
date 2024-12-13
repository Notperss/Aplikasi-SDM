<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Employee\PersonalData\EmployeeDuty;

class DutyExport implements FromView
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * Export the data using a view.
     *
     * @return View
     */
    public function view() : View
    {
        $query = EmployeeDuty::query()->when(! Auth::user()->hasRole('super-admin'), function ($query) {
            $query->where('company_id', Auth::user()->company_id);
        });

        // Apply date range filter if provided
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('end_date', [$this->startDate, $this->endDate]);
        }

        return view('pages.employee.duty.export', [
            'dutys' => $query->get(),
        ]);
    }
}
