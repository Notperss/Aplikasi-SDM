<?php

namespace App\Exports;

use App\Models\Employee\Contract;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class ContractExport implements FromView
{
    protected $startDate;
    protected $endDate;
    protected $filterType;

    public function __construct($startDate, $endDate, $filterType)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->filterType = $filterType;
    }

    public function view() : View
    {
        $query = Contract::query()->when(! Auth::user()->hasRole('super-admin'), function ($query) {
            $query->where('company_id', Auth::user()->company_id);
        })->orderBy('employee_id', 'asc')->orderBy('contract_sequence_number', 'asc');

        // Apply date range filter
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('end_date', [$this->startDate, $this->endDate]);
        }

        // Apply additional filters
        if ($this->filterType) {
            $currentDate = now();
            switch ($this->filterType) {
                case 'before_end':
                    $query->where('end_date', '>', $currentDate);
                    break;

                case 'incoming_end':
                    $query->whereBetween('end_date', [$currentDate, $currentDate->copy()->addDays(60)]);
                    break;

                case 'ended':
                    $query->where('end_date', '<', $currentDate);
                    break;
            }
        }

        $contracts = $query->get();

        // Return the view with the filtered data
        return view('pages.employee.contract.export', [
            'contracts' => $contracts,
        ]);
    }
}
