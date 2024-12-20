<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class GenderExport implements FromView
{
    protected $directorates;

    public function __construct($directorates)
    {
        $this->directorates = $directorates;
    }

    public function view() : View
    {
        return view('pages.dashboard.table.export.genderExport', [
            'directorates' => $this->directorates,
        ]);
    }
}
