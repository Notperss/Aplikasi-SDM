<?php

namespace App\Http\Controllers\Approval;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Approval\Approval;
use App\Models\Employee\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Recruitment\SelectedCandidate;
use App\Models\Employee\PersonalData\EmployeeCareer;

class ApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $approvals = Approval::with('selectedCandidate', 'employeeCareer', 'position')
            ->when(! Auth::user()->hasRole('super-admin'), function ($query) {
                $query->where('company_id', Auth::user()->company_id);
            })
            ->orderByRaw('CASE WHEN is_approve IS NULL THEN 1 ELSE 0 END DESC') // Prioritize NULL
            // ->orderBy('is_approve', 'desc') // Secondary order for is_approve
            ->orderBy('created_at', 'desc') // Final order by created_at
            ->get();


        if (request()->ajax()) {
            return DataTables::of($approvals)
                ->addIndexColumn()
                ->addColumn('action', function ($item) {
                    $buttons = '';

                    // Role-based button (equivalent to @role)
                    if (auth()->user()->hasAnyRole(['staff', 'ka-si', 'ka-dep', 'super-admin']) && $item->selected_candidate_id && $item->is_approve === 1 && $item->selectedCandidate->is_hire === null) {
                        $url = route('employee.newEmployee', encrypt($item->selected_candidate_id)); // Adjust if necessary
                        $buttons .= '<a class="btn btn-sm btn-info mx-1" title="Tambahkan ke karyawan" href="'.$url.'">
                        <i class="bi bi-person-plus-fill"></i>
                    </a>';
                    }

                    if (auth()->user()->hasAnyRole(['manager', 'super-admin'])) {
                        // Dropdown menu
                        $dropdownHidden = $item->is_approve === null ? '' : 'hidden';
                        $buttons .= '
        <div class="btn-group mb-1" '.$dropdownHidden.'>
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle me-1" type="button" id="dropdownMenuButton'.$item->id.'"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bi bi-three-dots-vertical"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton'.$item->id.'">
                    <button class="dropdown-item"
                            onclick="confirmAction(\'approve\', \'Apakah Anda yakin ingin menyetujui?\', '.$item->id.')">
                        Approve
                    </button>
                    <button class="dropdown-item"
                            onclick="confirmAction(\'reject\', \'Apakah Anda yakin ingin menolak?\', '.$item->id.')">
                        Reject
                    </button>
                    <!-- Approve Form -->
                    <form id="approveForm_'.$item->id.'"
                        action="'.route('approval.update', $item->id).'"
                        method="POST" style="display: none;">
                        '.csrf_field().'
                        '.method_field('patch').'
                        <input type="hidden" name="employee_career_id" value="'.$item->employee_career_id.'">
                        <input type="hidden" name="employee_id" value="'.$item->employee_id.'">
                        <input type="hidden" name="selected_candidate_id" value="'.$item->selected_candidate_id.'">
                        <input type="hidden" name="is_approve" value="1"> <!-- Approve value -->
                    </form>
                    <!-- Reject Form -->
                    <form id="rejectForm_'.$item->id.'"
                        action="'.route('approval.update', $item->id).'"
                        method="POST" style="display: none;">
                        '.csrf_field().'
                        '.method_field('patch').'
                        <input type="hidden" name="employee_career_id" value="'.$item->employee_career_id.'">
                        <input type="hidden" name="employee_id" value="'.$item->employee_id.'">
                        <input type="hidden" name="selected_candidate_id" value="'.$item->selected_candidate_id.'">
                        <input type="hidden" name="is_approve" value="0"> <!-- Reject value -->
                    </form>
                </div>
            </div>
        </div>';
                    }
                    return $buttons;
                })
                ->editColumn('photo', function ($item) {
                    // Determine the photo based on the available relationships
                    $mainPhoto = null;
                    $path_photo = null;

                    if ($item->selected_candidate_id) {
                        $mainPhoto = $item->selectedCandidate->candidate;
                        $path_photo = $mainPhoto->photo ?? null;
                    } elseif ($item->employee_career_id) {
                        $mainPhoto = $item->employeeCareer->employee->employeePhotos->where('main_photo', true)->first();
                        $path_photo = $mainPhoto->file_path ?? null;
                    } elseif ($item->employee_id) {
                        $mainPhoto = $item->employee->employeePhotos->where('main_photo', true)->first();
                        $path_photo = $mainPhoto->file_path ?? null;
                    }

                    // Return image HTML or fallback message
                    if ($path_photo) {
                        return '
            <div class="fixed-frame">
                <img src="'.asset('storage/'.$path_photo).'" data-fancybox alt="User Photo"
                class="framed-image" style="cursor: pointer">
            </div>';
                    }

                    return 'No Image';
                })->editColumn('employee_nik', function ($item) {
                    return $item->employeeCareer->employee->nik
                        ?? $item->employee->nik
                        ?? '<span class="badge bg-secondary">-</span>';
                })->editColumn('employee_position', function ($item) {
                    if ($item->position_id) {
                        return $item->position->name ?? '-';
                    } else {
                        return '<span class="badge bg-secondary">-</span>';
                    }
                })->editColumn('employee_division', function ($item) {
                    if ($item->position_id) {
                        return $item->position->division->name ?? '-';
                    } else {
                        return '<span class="badge bg-secondary">-</span>';
                    }
                })->editColumn('employee_name', function ($item) {
                    return $item->selectedCandidate->candidate->name
                        ?? $item->employeeCareer->employee->name
                        ?? $item->employee->name
                        ?? '<span class="badge bg-secondary">-</span>';
                })
                ->editColumn('is_approve', function ($item) {
                    $status = '<span class="badge bg-primary mb-1">'.$item->description.'</span> <br>';

                    if ($item->is_approve === 1) {
                        $appr = '<span class="badge bg-success">Disetujui</span>';
                    } elseif ($item->is_approve === 0) {
                        $appr = '<span class="badge bg-danger">Ditolak</span>';
                    } else {
                        $appr = '<span class="badge bg-secondary">Pending</span>';
                    }

                    return $status.$appr;

                })->editColumn('created_at', function ($item) {
                    return $item->created_at ? Carbon::parse($item->created_at)->translatedFormat('d-m-Y') : '-';

                })->rawColumns(['action', 'employee_name', 'is_approve', 'employee_nik', 'employee_position', 'employee_division', 'photo'])
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
        // Check if 'is_approve' is present in the request
        if ($request->has('is_approve')) {
            $isApprove = $request->input('is_approve');

            $approval->is_approve = $isApprove;
            $approval->save();

            // Handle approval for EmployeeCareer
            if ($approval->employee_career_id) {
                $employeeCareer = EmployeeCareer::findOrFail($request->employee_career_id);
                $employeeCareer->is_approve = $isApprove;

                if ($isApprove == 1) { // Approval logic

                    if (in_array($employeeCareer->type, ['PENSIUN', 'NON-AKTIF', 'RESIGN'])) {
                        // Update the employee's status and date of leaving
                        Employee::where('id', $employeeCareer->employee_id)
                            ->update([
                                'employee_status' => $employeeCareer->type,
                                'date_leaving' => $employeeCareer->start_date,
                            ]);

                        // Get all careers for the employee
                        $careers = EmployeeCareer::where('employee_id', $employeeCareer->employee_id)->where('cmnp_career', 0)->get();

                        // Update each career
                        foreach ($careers as $career) {
                            $career->update([
                                'cmnp_career' => 1,
                                'placement' => $career->position?->division->name ?? $employeeCareer->position?->division->name ?? '-',
                                'position_name' => $career->position?->name ?? $employeeCareer->position?->name ?? '-',
                            ]);
                        }

                    } else {
                        Employee::where('id', $employeeCareer->employee_id)
                            ->update(['position_id' => $employeeCareer->position_id]);
                    }

                    // Find the most recent approved career
                    $newestCareer = EmployeeCareer::where('employee_id', $employeeCareer->employee_id)
                        ->where('id', '!=', $employeeCareer->id)
                        ->where('is_approve', true)
                        ->orderBy('start_date', 'desc')
                        ->first();

                    // Update the end_date of the previous career
                    if ($newestCareer) {
                        $newestCareer->update([
                            'end_date' => $employeeCareer->start_date,
                        ]);
                    }
                }

                $employeeCareer->save();

                $message = $isApprove == 1 ? 'Career approved.' : 'Career rejected.';
                return redirect()->back()->with('success', $message);
            }

            if ($approval->selected_candidate_id) {
                $selectedCandidate = SelectedCandidate::findOrFail($request->selected_candidate_id);
                $selectedCandidate->is_approve = $isApprove;
                if ($isApprove == 0) {
                    $selectedCandidate->is_hire = $isApprove;
                }
                $selectedCandidate->is_approve = $isApprove;
                $selectedCandidate->save();

                $message = $isApprove == 1 ? 'Candidate approved.' : 'Candidate rejected.';
                return redirect()->back()->with('success', $message);
            }

            if ($approval->employee_id) {
                $employee = employee::findOrFail($request->employee_id);
                if ($isApprove == 1) {
                    $employee->is_verified = false;
                    $employee->employee_status = 'AKTIF';
                }
                $employee->save();

                $message = $isApprove == 1 ? 'Request Unverified approved.' : 'Request Unverified rejected.';
                return redirect()->back()->with('success', $message);
            }

        }

        return redirect()->back()->with('error', 'Invalid request. Approval status is missing.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Approval $approval)
    {
        //
    }
}
