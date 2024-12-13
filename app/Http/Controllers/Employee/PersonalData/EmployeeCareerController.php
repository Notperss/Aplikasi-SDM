<?php

namespace App\Http\Controllers\Employee\PersonalData;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Approval\Approval;
use App\Models\Employee\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Employee\PersonalData\EmployeeCareer;

class EmployeeCareerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'position_id' => 'nullable|exists:positions,id',
            'placement' => 'nullable|string|max:255',
            'type' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'description' => 'nullable',
        ], [
            'employee_id.required' => 'Karyawan harus dipilih.',
            'employee_id.exists' => 'Karyawan yang dipilih tidak valid.',
            'position_id.exists' => 'Posisi yang dipilih tidak valid.',
            'placement.string' => 'Penempatan harus berupa teks.',
            'placement.max' => 'Penempatan tidak boleh lebih dari 255 karakter.',
            'type.required' => 'Jenis harus diisi.',
            'type.string' => 'Jenis harus berupa teks.',
            'type.max' => 'Jenis tidak boleh lebih dari 255 karakter.',
            'start_date.required' => 'Tanggal mulai harus diisi.',
            'start_date.date' => 'Tanggal mulai harus berupa format tanggal yang valid.',
            'end_date.date' => 'Tanggal selesai harus berupa format tanggal yang valid.',
            'description.string' => 'Deskripsi harus berupa teks.',
        ]);

        $data = $request->all();

        if ($request->hasFile('file_career')) {
            $file = $request->file('file_career'); // Get the file from the request
            $extension = $file->getClientOriginalExtension(); // Get the file extension
            $file_name = 'file_career_' . $request['name'] . '_' . time() . '.' . $extension; // Construct the file name
            $data['file_career'] = $file->storeAs('files/employee/file_career', $file_name, 'public_local'); // Store the file
        }

        // $employee = Employee::findOrFail($request->employee_id);

        // $employee->update([
        //     'position_id' => $request->position_id,
        // ]);

        $employeeCareer = EmployeeCareer::create($data);

        if ($employeeCareer) {
            Approval::create([
                'company_id' => $employeeCareer->employee->company_id,
                'selected_candidate_id' => null,
                'employee_career_id' => $employeeCareer->id,
                'position_id' => $employeeCareer->position_id,
                'is_approve' => null,
                'description' => $employeeCareer->type,
            ]);
        }

        // Redirect back with success message
        return redirect()->back()->with('success', 'Data has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeCareer $employeeCareer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeCareer $employeeCareer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployeeCareer $employeeCareer)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'position_id' => 'nullable|exists:positions,id',
            'placement' => 'nullable|string|max:255',
            'type' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'description' => 'nullable',
        ], [
            'employee_id.required' => 'Karyawan harus dipilih.',
            'employee_id.exists' => 'Karyawan yang dipilih tidak valid.',
            'position_id.exists' => 'Posisi yang dipilih tidak valid.',
            'placement.string' => 'Penempatan harus berupa teks.',
            'placement.max' => 'Penempatan tidak boleh lebih dari 255 karakter.',
            'type.required' => 'Jenis harus diisi.',
            'type.string' => 'Jenis harus berupa teks.',
            'type.max' => 'Jenis tidak boleh lebih dari 255 karakter.',
            'start_date.required' => 'Tanggal mulai harus diisi.',
            'start_date.date' => 'Tanggal mulai harus berupa format tanggal yang valid.',
            'end_date.date' => 'Tanggal selesai harus berupa format tanggal yang valid.',
            'description.string' => 'Deskripsi harus berupa teks.',
        ]);

        $data = $request->all();

        $path_file = $employeeCareer->file;

        if ($request->hasFile('file')) {
            $file = $request->file('file_career'); // Get the file from the request
            $extension = $file->getClientOriginalExtension(); // Get the file extension
            $file_name = 'file_career_' . $request['name'] . '_' . time() . '.' . $extension; // Construct the file name
            $data['file_career'] = $file->storeAs('files/employee/file_career', $file_name, 'public_local'); // Store the file
            // delete sertifikat
            if ($path_file != null || $path_file != '') {
                Storage::disk('public_local')->delete($path_file);
            }
        } else {
            $data['file'] = $path_file;
        }

        if ($employeeCareer->position_id) {
            $employeeCareer->approval->update([
                // 'selected_candidate_id' => null,
                // 'employee_career_id' => $employeeCareer->id,
                'position_id' => $data['position_id'],
                // 'is_approve' => null,
            ]);
        }

        // $employee = Employee::findOrFail($employeeCareer->employee_id);

        // $employee->update([
        //     'position_id' => $request->position_id,
        // ]);

        $employeeCareer->update($data);

        return redirect()->back()->with('success', 'Data has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeCareer $employeeCareer)
    {
        // Count the number of career records for the employee
        $careerCount = EmployeeCareer::where('employee_id', $employeeCareer->employee_id)->count();

        // If there is only one record or none, prevent deletion
        if ($careerCount <= 1) {
            return redirect()->back()->with('error', 'Cannot delete the last career record for this employee.');
        }

        $path_file = $employeeCareer->file;

        if ($path_file != null || $path_file != '') {
            Storage::disk('public_local')->delete($path_file);
        }

        $employeeCareer->delete();

        $employee = Employee::findOrFail($employeeCareer->employee_id);

        $latestPositionId = EmployeeCareer::where('employee_id', $employeeCareer->employee_id)
            ->latest('created_at')
            ->value('position_id');

        $employee->update([
            'position_id' => $latestPositionId,
        ]);

        return redirect()->back()->with('success', 'Data has been deleted successfully!');
    }

    public function indexApproval()
    {

        // when(! Auth::user()->hasRole('super-admin'), function ($query) {
        //     $query->where('company_id', Auth::user()->company_id);
        // })

        $employeeCareers = EmployeeCareer::with('position', 'employee')->whereHas('employee', function ($query) {
            $query->when(! Auth::user()->hasRole('super-admin'), function ($query) {
                $query->where('company_id', Auth::user()->company_id);
            });
        })->orderBy('created_at', 'desc');

        if (request()->ajax()) {
            return DataTables::of($employeeCareers)
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
                                action="' . route('updateApprovalStatus', $item->id) . '"
                                method="POST" style="display: none;">
                                ' . csrf_field() . '
                                ' . method_field('patch') . '
                                <input type="hidden" name="is_approve" value="1"> <!-- Approve value -->
                            </form>
                            <!-- Reject Form -->
                            <form id="rejectForm_' . $item->id . '"
                                action="' . route('updateApprovalStatus', $item->id) . '"
                                method="POST" style="display: none;">
                                ' . csrf_field() . '
                                ' . method_field('patch') . '
                                <input type="hidden" name="is_approve" value="0"> <!-- Reject value -->
                            </form>
                        </div>
                    </div>
                </div>
                ';
                })

                ->editColumn('start_date', function ($item) {
                    return '' . Carbon::parse($item->start_date)->translatedFormat('l, d F Y') . '';
                })->editColumn('end_date', function ($item) {
                    return '' . Carbon::parse($item->end_date)->translatedFormat('l, d F Y') . '';
                })->editColumn('employee.name', function ($item) {
                    return '<a href="' . route('employee.show', $item->employee_id) . '" target="_blank">' . $item->employee->name . '</a>';
                })->editColumn('is_approve', function ($item) {
                    if ($item->is_approve) {
                        return '<span class="badge bg-success">Disetujui</span>';
                    } elseif ($item->is_approve === false) {
                        return '<span class="badge bg-danger">Ditolak</span>';
                    } else {
                        return '<span class="badge bg-secondary">Pending</span>';
                    }
                })->editColumn('file', function ($item) {
                    if ($item->file_career) {
                        return '<a class="btn btn-sm btn-primary" href="' . asset('storage/' . $item->file_career) . '" target="_blank" > Lihat </a>';
                    } else {
                        return '<span> - </span>';
                    }
                })

                ->rawColumns(['action', 'employee.name', 'is_approve', 'file'])
                ->toJson();
        }

        return view('pages.approval.index', compact('employeeCareers'));


    }

    public function updateApprovalStatus(Request $request, $id)
    {

        $employeeCareer = EmployeeCareer::findOrFail($id);

        if ($request->has('is_approve')) {
            $employeeCareer->is_approve = $request->input('is_approve');

            if ($request->input('is_approve') == 1) {
                Employee::where('id', $employeeCareer->employee_id)
                    ->update(['position_id' => $employeeCareer->position_id]);

                // Find the newest start_date from the employee's career
                $newestCareer = EmployeeCareer::where('employee_id', $employeeCareer->employee_id)
                    ->where('id', '!=', $employeeCareer->id)
                    ->where('is_approve', true)
                    ->orderBy('start_date', 'desc')
                    ->first();

                // Update the end_date of the current employee career
                if ($newestCareer) {
                    $newestCareer->update([
                        'end_date' => $employeeCareer->start_date,
                    ]);
                }
            } elseif ($request->input('is_approve') == 0) {
                if (is_null($employeeCareer->type)) {
                    $employeeCareer->employee->update([
                        'employee_status' => 'NON-AKTIF',
                        'date_leaving' => now(),
                    ]);
                }
            }

            $employeeCareer->save();

            $message = $employeeCareer->is_approve ? 'Career approved.' : 'Career rejected.';
            return redirect()->back()->with('success', $message);
        }

        return redirect()->back()->with('error', 'Invalid request. Approval status is missing.');
    }
}