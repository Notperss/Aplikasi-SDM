<?php

namespace App\Http\Controllers\Employee\PersonalData;

use Carbon\Carbon;
use App\Exports\AwardExport;
use Illuminate\Http\Request;
use App\Models\Employee\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Employee\PersonalData\EmployeeAward;

class EmployeeAwardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $employeeAward = EmployeeAward::with('employee')
            ->when(! Auth::user()->hasRole('super-admin'), function ($query) {
                $query->whereHas('employee', function ($query) {
                    $query->where('company_id', Auth::user()->company_id);
                });
            })
            ->latest();

        if ($request->filled(['start_date', 'end_date'])) {
            $employeeAward->whereBetween('date_award', [$request->start_date, $request->end_date]);
        }

        if (request()->ajax()) {
            return DataTables::of($employeeAward)
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
                        
                            <a class="dropdown-item" href="' . route('employeeAward.edit', $item) . '">Edit</a>
                            
                            <button class="dropdown-item" onclick="deleteAward(' . $item->id . ')">Hapus</button>
                            <form id="deleteAwardForm_' . $item->id . '"
                                  action="' . route('employeeAward.destroy', $item->id) . '"
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
                })->editColumn('date_award', function ($item) {
                    return '' . $item->date_award ? Carbon::parse($item->date_award)->translatedFormat('d M Y') : '-' . '';
                })->rawColumns(['action', 'file',])
                ->toJson();
        }

        // $employees = Employee::where('employee_status', 'AKTIF')->where('is_verified', true)->orderBy('name', 'asc')->get();
        $employees = Employee::with('position', 'position.division')->where('employee_status', 'AKTIF')->orderBy('name', 'asc')->get();

        return view('pages.employee.award.index', compact('employeeAward', 'employees'));
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
            'name_award' => 'required|string',
            'date_award' => 'required|date',
            'file_award' => 'nullable|file|mimes:pdf',
            'employees' => $request->has('employees') ? 'required|array' : 'nullable',
            'employees.*' => 'exists:employees,id', // Validate employee IDs exist in the database
        ], [
            'name_award.required' => 'Nama Penghargaan wajib di isi',
            'date_award.required' => 'Tanggal Penghargaan wajib di isi',
            'file_award.mimes' => 'File harus pdf.',
        ]);

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Handle file upload for certificate (if present)
            $file_path = null;  // Initialize file path variable

            if ($request->hasFile('file_award')) {
                $file = $request->file('file_award');
                $extension = $file->getClientOriginalExtension();
                $file_name = 'file_penghargaan_' . time() . '.' . $extension; // Generate a unique file name
                $file_path = $file->storeAs('files/employee/file_penghargaan', $file_name, 'public_local');
            }

            if ($request->employees) {
                // Loop through employees to create training records
                foreach ($request->employees as $employeeData) {
                    // Ensure employeeData is the employee ID
                    $employeeId = $employeeData['id'];

                    EmployeeAward::create([
                        'employee_id' => $employeeId, // Use employee ID
                        'name_award' => $request->name_award,
                        'date_award' => $request->date_award,
                        'file_award' => $file_path, // Attach file path if the certificate is uploaded
                    ]);
                }
            } else {
                // Create the training record for each employee
                EmployeeAward::create([
                    'employee_id' => $request->employee_id, // Use employee ID
                    'name_award' => $request->name_award,
                    'date_award' => $request->date_award,
                    'file_award' => $file_path, // Attach file path if the certificate is uploaded
                ]);
            }

            // Commit the transaction
            DB::commit();

            // Redirect with a success message
            return redirect()->back()
                ->with('success', 'Data Penghargaan Karyawan berhasil ditambahkan.');
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
    public function show(EmployeeAward $employeeAward)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeAward $employeeAward)
    {
        return view('pages.employee.award.edit', compact('employeeAward'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployeeAward $employeeAward)
    {
        $request->validate([
            'name_award' => 'required|string',
            'date_award' => 'required|date',
            'file_award' => 'nullable|file|mimes:pdf',
        ], [
            'name_award.required' => 'Nama Penghargaan wajib di isi',
            'date_award.required' => 'Tanggal Penghargaan wajib di isi',
            'file_award.mimes' => 'File harus pdf.',
        ]);

        $data = $request->all();

        $path_file = $employeeAward->file_award;

        if ($request->hasFile('file_award')) {
            $file = $request->file('file_award');
            $extension = $file->getClientOriginalExtension();
            $file_name = 'file_penghargaan_' . $request['name'] . '_' . time() . '.' . $extension; // Construct the file name
            $data['file_award'] = $file->storeAs('files/employee/file_penghargaan', $file_name, 'public_local'); // Store the file
            // delete sertifikat
            if ($path_file != null || $path_file != '') {
                Storage::disk('public_local')->delete($path_file);
            }
        } else {
            $data['file_award'] = $path_file;
        }

        $employeeAward->update($data);


        return redirect()->back()->with('success', 'Data has been created successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeAward $employeeAward)
    {
        $path_file = $employeeAward->file_award;

        if ($path_file != null || $path_file != '') {
            Storage::disk('public_local')->delete($path_file);
        }

        $employeeAward->delete();

        return redirect()->back()->with('success', 'Data has been deleted successfully!.');
    }

    public function awardExport(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        return Excel::download(new AwardExport($startDate, $endDate), 'PenghargaanExport.xlsx');


    }
}
