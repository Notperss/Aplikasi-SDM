<?php

namespace App\Http\Controllers\Employee\PersonalData;

use Illuminate\Http\Request;
use App\Models\Employee\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Employee\PersonalData\EmployeeKpi;
use App\Models\Employee\PersonalData\EmployeeTrainingAttended;

class EmployeeKpiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employeeKpi = EmployeeKpi::with('employee')
            ->when(! Auth::user()->hasRole('super-admin'), function ($query) {
                $query->whereHas('employee', function ($query) {
                    $query->where('company_id', Auth::user()->company_id);
                });
            })
            ->latest();

        if (request()->ajax()) {
            return DataTables::of($employeeKpi)
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
                        
                            <a class="dropdown-item" href="' . route('employeeKpi.edit', $item) . '">Edit</a>
                            
                            <button class="dropdown-item" onclick="deleteKpi(' . $item->id . ')">Hapus</button>
                            <form id="deleteKpiForm_' . $item->id . '"
                                  action="' . route('employeeKpi.destroy', $item->id) . '"
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
                })->editColumn('contract_recommendation', function ($item) {
                    if ($item->contract_recommendation) {
                        return '<span class="badge bg-primary">Kontrak Diperpanjang</span>';
                    } else {
                        return '<span class="badge bg-danger">Kontrak Tidak Diperpanjang</span>';
                    }
                })->rawColumns(['action', 'file', 'contract_recommendation'])
                ->toJson();
        }

        // $employees = Employee::where('employee_status', 'AKTIF')->where('is_verified', true)->orderBy('name', 'asc')->get();
        $employees = Employee::with('position', 'position.division')->where('employee_status', 'AKTIF')->orderBy('name', 'asc')->get();

        return view('pages.employee.kpi.index', compact('employeeKpi', 'employees'));
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
            'year' => 'required|integer',
            'grade' => 'required',
            'contract_recommendation' => 'required|boolean',
            'file' => 'nullable|file|mimes:pdf',
            'employees' => $request->has('employees') ? 'required|array' : 'nullable',
            'employees.*' => 'exists:employees,id', // Validate employee IDs exist in the database
        ], [
            'year.required' => 'Tahun wajib di isi',
            'grade.required' => 'Nilai wajib di isi',
            'contract_recommendation.required' => 'Kontrak Rekomendasi wajib di isi',
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
                $file_name = 'file_kpi_' . time() . '.' . $extension; // Generate a unique file name
                $file_path = $file->storeAs('files/employee/file_kpi', $file_name, 'public_local');
            }

            if ($request->employees) {
                // Loop through employees to create training records
                foreach ($request->employees as $employeeData) {
                    // Ensure employeeData is the employee ID
                    $employeeId = $employeeData['id'];

                    // Create the training record for each employee
                    EmployeeKpi::create([
                        'employee_id' => $employeeId, // Use employee ID
                        'year' => $request->year,
                        'grade' => $request->grade,
                        'contract_recommendation' => $request->contract_recommendation,
                        'file' => $file_path, // Attach file path if the certificate is uploaded
                    ]);
                }
            } else {
                // Create the training record for each employee
                EmployeeKpi::create([
                    'employee_id' => $request->employee_id, // Use employee ID
                    'year' => $request->year,
                    'grade' => $request->grade,
                    'contract_recommendation' => $request->contract_recommendation,
                    'file' => $file_path, // Attach file path if the certificate is uploaded
                ]);
            }

            // Commit the transaction
            DB::commit();

            // Redirect with a success message
            return redirect()->back()
                ->with('success', 'Data KPI Karyawan berhasil ditambahkan.');
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
    public function show(EmployeeKpi $employeeKpi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeKpi $employeeKpi)
    {
        return view('pages.employee.kpi.edit', compact('employeeKpi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployeeKpi $employeeKpi)
    {
        $request->validate([
            'year' => 'required|integer',
            'grade' => 'required',
            'contract_recommendation' => 'required|boolean',
            'file' => 'nullable|file|mimes:pdf',
        ], [
            'year.required' => 'Tahun wajib di isi',
            'grade.required' => 'Nilai wajib di isi',
            'contract_recommendation.required' => 'Kontrak Rekomendasi wajib di isi',
            'file.mimes' => 'File harus pdf.',
        ]);


        $data = $request->all();

        $path_file = $employeeKpi->file;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $file_name = 'file_kpi_' . time() . '.' . $extension; // Construct the file name
            $data['file'] = $file->storeAs('files/employee/file_kpi', $file_name, 'public_local'); // Store the file
            // delete sertifikat
            if ($path_file != null || $path_file != '') {
                Storage::disk('public_local')->delete($path_file);
            }
        } else {
            $data['file'] = $path_file;
        }

        $employeeKpi->update($data);


        return redirect()->back()->with('success', 'Data has been created successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeKpi $employeeKpi)
    {
        $path_file = $employeeKpi->file;

        if ($path_file != null || $path_file != '') {
            Storage::disk('public_local')->delete($path_file);
        }

        $employeeKpi->delete();

        return redirect()->back()->with('success', 'Data has been deleted successfully!.');
    }
}
