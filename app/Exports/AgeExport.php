<?php

namespace App\Exports;

use App\Models\WorkUnit\Directorate;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class AgeExport implements FromView
{
    public function view() : View
    {
        $directorates = Directorate::with(['divisions.positions.level', 'divisions.positions.employee'])->get();

        return view('pages.dashboard.table.export.ageExport', compact('directorates'));
    }
}
