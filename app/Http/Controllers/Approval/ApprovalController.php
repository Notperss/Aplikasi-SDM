<?php

namespace App\Http\Controllers\Approval;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Approval\Approval;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $approvals = Approval::with('selectedCandidate', 'employeeCareer')->orderBy('created_at', 'desc');

        if (request()->ajax()) {
            return DataTables::of($approvals)
                ->addIndexColumn()
                ->addColumn('action', function ($item) {
                    return '
                <div class="btn-group mb-1" ' . ($item->is_approve === null ? '' : 'hidden') . '>

                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle me-1" type="button" id="dropdownMenuButton' . $item->id . '"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $item->id . '">
                            <button class="dropdown-item"
                                    onclick="confirmAction(\'approve\', \'Apakah Anda yakin ingin menyetujui?\', ' . $item->id . ')">
                                Approve
                            </button>
                            <button class="dropdown-item"
                                    onclick="confirmAction(\'reject\', \'Apakah Anda yakin ingin menolak?\', ' . $item->id . ')">
                                Reject
                            </button>
                            <!-- Approve Form -->
                            <form id="approveForm_' . $item->id . '"
                                action="' . route('approval.update', $item->id) . '"
                                method="POST" style="display: none;">
                                ' . csrf_field() . '
                                ' . method_field('patch') . '
                                <input type="hidden" name="is_approve" value="1"> <!-- Approve value -->
                            </form>
                            <!-- Reject Form -->
                            <form id="rejectForm_' . $item->id . '"
                                action="' . route('approval.update', $item->id) . '"
                                method="POST" style="display: none;">
                                ' . csrf_field() . '
                                ' . method_field('patch') . '
                                <input type="hidden" name="is_approve" value="0"> <!-- Reject value -->
                            </form>
                        </div>
                    </div>
                </div>
                ';
                    // })
    
                    // ->editColumn('start_date', function ($item) {
                    //     return '' . Carbon::parse($item->start_date)->translatedFormat('l, d F Y') . '';
                    // })->editColumn('end_date', function ($item) {
                    //     return '' . Carbon::parse($item->end_date)->translatedFormat('l, d F Y') . '';
                    // })->editColumn('employee.name', function ($item) {
                    //     return '<a href="' . route('employee.show', $item->employee_id) . '" target="_blank">' . $item->employee->name . '</a>';
                })->editColumn('is_approve', function ($item) {
                    if ($item->is_approve) {
                        return '<span class="badge bg-success">Disetujui</span>';
                    } elseif ($item->is_approve === false) {
                        return '<span class="badge bg-danger">Ditolak</span>';
                    } else {
                        return '<span class="badge bg-secondary">Pending</span>';
                    }
                    // })->editColumn('file', function ($item) {
                    //     if ($item->file_career) {
                    //         return '<a class="btn btn-sm btn-primary" href="' . asset('storage/' . $item->file_career) . '" target="_blank" > Lihat </a>';
                    //     } else {
                    //         return '<span> - </span>';
                    //     }
                })

                ->rawColumns(['action', 'employee.name', 'is_approve', 'file'])
                ->toJson();
        }

        return view('pages.approval.index', compact('approvals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Approval $approval)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Approval $approval)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Approval $approval)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Approval $approval)
    {
        //
    }
}
