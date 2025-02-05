<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Employee\Employee;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class EmployeeInOutExport implements FromView
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        // if ($this->request->status === 'retirement') {
        //     $employees = Employee::when(! Auth::user()->hasRole('super-admin'), function ($query) {
        //         $query->where('company_id', Auth::user()->company_id);
        //     })->where('employee_status', 'AKTIF')
        //         ->get() // Retrieve as a collection
        //         ->filter(function ($employee) {
        //             $retirementDate = Carbon::parse($employee->dob)->addYears(55);
        //             return $retirementDate->year === now()->year;
        //         });
        // } else {

        $employees = Employee::when(! Auth::user()->hasRole('super-admin'), function ($query) {
            $query->where('company_id', Auth::user()->company_id);
        })
            ->when($this->request->status, function ($q) {
                if ($this->request->status === 'Karyawan Masuk') {
                    $q->where('employee_status', 'AKTIF')
                        ->whereYear('date_joining', now()->year)
                        ->when($this->request->isMonth, function ($q) {
                            $q->whereMonth('date_joining', now()->month);
                        });
                } else {
                    $q->where('employee_status', '!=', 'AKTIF')
                        ->whereYear('date_leaving', now()->year)
                        ->when($this->request->isMonth, function ($q) {
                            $q->whereMonth('date_leaving', now()->month);
                        });
                }
            })
            ->get();
        // }

        return view('pages.employee.export', compact('employees'));
    }
}
