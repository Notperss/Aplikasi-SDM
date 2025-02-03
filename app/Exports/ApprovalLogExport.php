<?php

namespace App\Exports;

use App\Models\Approval\Approval;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class ApprovalLogExport implements FromView
{
    protected $type;
    protected $year;

    public function __construct($type, $year)
    {
        $this->type = $type;
        $this->year = $year;
    }

    public function view(): View
    {
        $approvalQuery = Approval::query();

        if (! in_array($this->type, ['KARYAWAN BARU', 'BUKA VERIFIKASI'])) {
            $approvalQuery->join('employee_careers', 'approvals.employee_career_id', '=', 'employee_careers.id')
                ->where('employee_careers.type', $this->type)
                ->whereYear('employee_careers.start_date', $this->year);
        } else {
            if ($this->type === 'KARYAWAN BARU') {
                $approvalQuery->whereNotNull('selected_candidate_id')
                    ->whereYear('created_at', $this->year);
            } elseif ($this->type === 'BUKA VERIFIKASI') {
                $approvalQuery->whereNotNull('employee_id')
                    ->whereYear('created_at', $this->year);
            }
        }

        if (! Auth::user()->hasRole('super-admin')) {
            $approvalQuery->where('company_id', Auth::user()->company_id);
        }

        $approvals = $approvalQuery->get();

        return view('pages.dashboard.approval.employee-log-export', compact('approvals'));
    }
}
