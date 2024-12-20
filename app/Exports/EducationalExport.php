<?php
namespace App\Exports;

use App\Models\WorkUnit\Directorate;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EducationalExport implements FromView, WithHeadings
{
    public function view() : \Illuminate\View\View
    {
        // Get the directorates and their divisions
        $directorates = Directorate::with(['divisions.positions.employee'])->get();

        // Pass the data to the view
        return view('pages.dashboard.table.export.educationalExport', compact('directorates'));
    }

    public function headings() : array
    {
        return [
            'Directorate',
            'Division',
            'SD',
            'SMP',
            'SMA',
            'MA',
            'SMK',
            'D-1',
            'D-2',
            'D-3',
            'D-4',
            'S-1',
            'S-2',
            'S-3',
        ];
    }
}
