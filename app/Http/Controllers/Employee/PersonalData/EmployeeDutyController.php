<?php

namespace App\Http\Controllers\Employee\PersonalData;

use Carbon\Carbon;
use App\Exports\DutyExport;
use Illuminate\Http\Request;
use App\Models\Employee\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Employee\PersonalData\EmployeeDuty;

class EmployeeDutyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $employeeDuty = EmployeeDuty::with('employee')
            ->when(! Auth::user()->hasRole('super-admin'), function ($query) {
                $query->whereHas('employee', function ($query) {
                    $query->where('company_id', Auth::user()->company_id);
                });
            })
            ->latest();

        if ($request->filled(['start_date', 'end_date'])) {
            $employeeDuty->whereBetween('end_date', [$request->start_date, $request->end_date]);
        }

        if (request()->ajax()) {
            return DataTables::of($employeeDuty)
                ->addIndexColumn()
                ->addColumn('action', function ($item) {
                    return '
                <div class="btn-group mb-1">
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle me-1" type="button" id="dropdownMenuButton"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        
                            <a class="dropdown-item" href="' . route('employeeDuty.edit', $item) . '">Edit</a>
                            
                            <button class="dropdown-item" onclick="deleteDuty(' . $item->id . ')">Hapus</button>
                            <form id="deleteDutyForm_' . $item->id . '"
                                  action="' . route('employeeDuty.destroy', $item->id) . '"
                                  method="POST">
                                ' . method_field('delete') . csrf_field() . '
                            </form>
                        </div>
                    </div>
                </div>
            ';
                })->editColumn('file', function ($item) {
                    if ($item->file) {
                        return '<a class="btn btn-sm btn-primary" href="' . asset('storage/' . $item->file) . '" target="_blank" > Lihat </a>';
                    } else {
                        return '<span> - </span>';
                    }
                })->editColumn('start_date', function ($item) {
                    return '' . $item->start_date ? Carbon::parse($item->start_date)->translatedFormat('d M Y') : '-' . '';
                })->editColumn('end_date', function ($item) {
                    return '' . $item->end_date ? Carbon::parse($item->end_date)->translatedFormat('d M Y') : '-' . '';
                })->rawColumns(['action', 'file',])
                ->toJson();
        }

        // $employees = Employee::where('employee_status', 'AKTIF')->where('is_verified', true)->orderBy('name', 'asc')->get();
        $employees = Employee::with('position', 'position.division')->where('employee_status', 'AKTIF')->orderBy('name', 'asc')->get();

        return view('pages.employee.duty.index', compact('employeeDuty', 'employees'));
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
        if ($request->has('employees')) {
            // Decode the JSON string into an array
            $employees = json_decode($request->input('employees'), true);

            // Replace the 'employees' input with the decoded array for validation
            $request->merge([
                'employees' => $employees,
            ]);
        }

        $request->validate([
            'name_duty' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'location' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf',
            'employees' => $request->has('employees') ? 'required|array' : 'nullable',
            'employees.*' => 'exists:employees,id', // Validate employee IDs exist in the database
        ], [
            'name_duty.required' => 'Nama Dinas Tugas wajib di isi',
            'start_date.required' => 'Tanggal Tugas wajib di isi',
            'location.required' => 'Lokasi wajib di isi',
            'file.mimes' => 'File harus pdf.',
        ]);

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Handle file upload for certificate (if present)
            $file_path = null;  // Initialize file path variable

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $extension = $file->getClientOriginalExtension();
                $file_name = 'file_dinas_' . time() . '.' . $extension; // Generate a unique file name
                $file_path = $file->storeAs('files/employee/file_dinas', $file_name, 'public_local');
            }

            if ($request->employees) {
                // Loop through employees to create training records
                foreach ($request->employees as $employeeData) {
                    // Ensure employeeData is the employee ID
                    $employeeId = $employeeData['id'];

                    EmployeeDuty::create([
                        'employee_id' => $employeeId, // Use employee ID
                        'name_duty' => $request->name_duty,
                        'start_date' => $request->start_date,
                        'end_date' => $request->end_date,
                        'location' => $request->location,
                        'description' => $request->description,
                        'file' => $file_path, // Attach file path if the certificate is uploaded
                    ]);
                }
            } else {
                // Create the training record for each employee
                EmployeeDuty::create([
                    'employee_id' => $request->employee_id, // Use employee ID
                    'name_duty' => $request->name_duty,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'location' => $request->location,
                    'description' => $request->description,
                    'file' => $file_path, // Attach file path if the certificate is uploaded
                ]);
            }

            // Commit the transaction
            DB::commit();

            // Redirect with a success message
            return redirect()->back()
                ->with('success', 'Data Dinas/Tugas Karyawan berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Rollback the transaction if something goes wrong
            DB::rollback();

            // Log the error for debugging
            Log::error('Error storing training: ' . $e->getMessage());

            // Redirect back with an error message
            return redirect()->back()
                ->withInput($request->all())
                ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeDuty $employeeDuty)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeDuty $employeeDuty)
    {
        return view('pages.employee.duty.edit', compact('employeeDuty'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployeeDuty $employeeDuty)
    {
        $request->validate([
            'name_duty' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'location' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf',
        ], [
            'name_duty.required' => 'Nama Dinas Tugas wajib di isi',
            'start_date.required' => 'Tanggal Tugas wajib di isi',
            'location.required' => 'Lokasi wajib di isi',
            'file.mimes' => 'File harus pdf.',
        ]);

        $data = $request->all();

        $path_file = $employeeDuty->file;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $file_name = 'file_dinas_' . time() . '.' . $extension; // Construct the file name
            $data['file'] = $file->storeAs('files/employee/file_dinas', $file_name, 'public_local'); // Store the file
            // delete sertifikat
            if ($path_file != null || $path_file != '') {
                Storage::disk('public_local')->delete($path_file);
            }
        } else {
            $data['file'] = $path_file;
        }

        $employeeDuty->update($data);


        return redirect()->back()->with('success', 'Data has been created successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeDuty $employeeDuty)
    {
        $path_file = $employeeDuty->file;

        if ($path_file != null || $path_file != '') {
            Storage::disk('public_local')->delete($path_file);
        }

        $employeeDuty->delete();

        return redirect()->back()->with('success', 'Data has been deleted successfully!.');
    }

    public function dutyExport(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        return Excel::download(new DutyExport($startDate, $endDate), 'DinasExport.xlsx');


    }
}
