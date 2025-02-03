<?php

namespace App\Exports;

use App\Models\Position\Position;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DivisionEmployeeExport implements FromView
{
    protected $divisionId;

    public function __construct($divisionId)
    {
        $this->divisionId = $divisionId;
    }

    public function view(): View
    {
        // Fetch the positions with employees based on the division ID
        $positions = Position::with('level')
            ->whereHas('employee', function ($query) {
                $query->where('employee_status', 'AKTIF')
                    ->when(! Auth::user()->hasRole('super-admin'), function ($query) {
                        $query->where('company_id', Auth::user()->company_id);
                    });
            })
            ->where('division_id', $this->divisionId)
            ->join('levels', 'positions.level_id', '=', 'levels.id')
            ->select('positions.*', 'levels.name as level_name')
            ->get();


        // Return the Blade view with the data
        return view('pages.dashboard.division-employee-export', compact('positions'));
    }
}
