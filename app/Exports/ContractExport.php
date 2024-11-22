<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Employee\Contract;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class ContractExport implements FromView
{
    public function view() : View
    {
        $companyId = Auth::user()->company_id;
        $isSuperAdmin = Auth::user()->hasRole('super-admin');

        $selectedYear = request('year', Carbon::now()->year);
        $selectedMonth = request('month', Carbon::now()->month);

        // Validate year and month inputs
        request()->validate([
            'year' => 'nullable|integer|min:2015|max:' . Carbon::now()->year,
            'month' => 'nullable|integer|min:1|max:12',
        ]);

        $contractsExpired = Contract::with(['employee.position.division'])
            ->when(! $isSuperAdmin, function ($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })
            ->whereYear('end_date', $selectedYear)
            ->whereMonth('end_date', $selectedMonth)
            ->whereHas('employee', function ($query) {
                $query->whereNull('date_leaving');
            })
            ->orderBy('end_date', 'asc')
            ->get();

        return view('pages.employee.contract.export', compact('contractsExpired', 'selectedYear', 'selectedMonth'));
    }
}
