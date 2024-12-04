<?php

namespace App\Http\Controllers\Employee;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Exports\AttendanceExport;
use App\Models\Employee\Employee;
use App\Models\Position\Position;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Recruitment\Candidate;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Employee\EmployeeCategory;
use App\Models\Recruitment\SelectedCandidate;
use App\Models\Employee\PersonalData\Attendance;
use App\Models\Employee\PersonalData\EmployeePhoto;
use App\Models\Employee\PersonalData\EmployeeSkill;
use App\Http\Requests\Employee\StoreEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Http\Requests\Employee\UpdateNewEmployeeRequest;
use App\Models\Employee\PersonalData\EmployeeJobHistory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Employee\PersonalData\EmployeeFamilyDetail;
use App\Models\Employee\PersonalData\EmployeeSocialPlatform;
use App\Models\Employee\PersonalData\EmployeeTrainingAttended;
use App\Models\Employee\PersonalData\EmployeeEducationalHistory;
use App\Models\Employee\PersonalData\EmployeeLanguageProficiency;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::with('employeeCategory')->when(! Auth::user()->hasRole('super-admin'), function ($query) {
            $query->where('company_id', Auth::user()->company_id);
        })->where('employee_status', 'AKTIF')->whereNotNull('nik')->latest();

        // if (! Auth::user()->hasRole('super-admin')) {
        //     $employees->where('company_id', Auth::user()->company_id);
        // }

        if (request()->ajax()) {
            return DataTables::of($employees)
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
                        
                            <a class="dropdown-item" href="' . route('employee.show', $item) . '">' . ($item->is_verified ? 'Lihat' : 'Edit') . '</a>
                            <button class="dropdown-item" onclick=" showSweetAlert(' . $item->id . ') " ' . ($item->is_verified ? 'hidden' : '') . '>Hapus</button>
                            <form id="deleteForm_' . $item->id . '"
                            action="' . route('employee.destroy', $item->id) . '" method="POST">
                            ' . method_field('delete') . csrf_field() . '
                            </form>
                        </div>
                    </div>
                </div>
                    ';
                })->editColumn('photo', function ($item) {
                    $mainPhoto = $item->employeePhotos->where('main_photo', true)->first();

                    if ($mainPhoto) {
                        return '
                <div class="fixed-frame">
                    <img src="' . asset('storage/' . $mainPhoto->file_path) . '" data-fancybox alt="Icon User"
                    class="framed-image" style="cursor: pointer">
                </div>';
                    } else {
                        return 'No Image';
                    }
                })->editColumn('created_at', function ($item) {
                    return '' . Carbon::parse($item->created_at)->translatedFormat('d F Y') . '';
                })->editColumn('employeeCategory', function ($item) {
                    return $item->employeeCategory->name ?? '-';
                })->editColumn('position', function ($item) {
                    return $item->position->name ?? '-';
                })->editColumn('division', function ($item) {
                    return $item->position->division->name ?? '-';
                })->editColumn('is_verified', function ($item) {
                    if ($item->is_verified == 0) {
                        return '<span class="badge bg-danger">Unverified</span>';
                    } elseif ($item->is_verified == 1) {
                        return '<span class="badge bg-success">Verified</span>';
                    } else {
                        return '-';
                    }
                })
                ->rawColumns(['action', 'photo', 'is_verified', 'employeeCategory'])
                ->toJson();
        }


        return view('pages.employee.index', compact('employees'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $positions = Position::whereDoesntHave('selectedPositions', function ($query) {
            $query->where('is_finished', false);
        })->whereDoesntHave('selectedCandidates', function ($query) {
            $query->where('is_hire', null);
        })->whereDoesntHave('selectedCandidates', function ($query) {
            $query->where('is_approve', null);
        })->whereDoesntHave('employee', function ($query) {
            $query->where('date_leaving', null);
        })->latest()
            ->get();

        $employeeCategories = EmployeeCategory::orderBy('name', 'asc')->get();

        return view('pages.employee.create', compact('positions', 'employeeCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        $data = $request->except('is_hire', 'position_id');

        // dd($request->position_id);

        $company_id = Auth::user()->company_id;

        $file_fields = [
            'photo',
            'file_cv',
            'file_ktp',
            'file_ijazah',
            'file_kk',
            'file_skck',
            'file_vaksin',
            'file_surat_sehat',
            'file_sertifikat',
            'file_sim_a',
            'file_sim_b',
            'file_sim_c',
        ];

        foreach ($file_fields as $file_field) {
            if ($request->hasFile($file_field)) {
                $file = $request->file($file_field); // Get the file
                $extension = $file->getClientOriginalExtension(); // Get file extension
                $file_name = $file_field . '_' . $data['name'] . '_' . time() . '.' . $extension; // Construct the file name
                $data[$file_field] = $file->storeAs('files/employee/' . $file_field, $file_name, 'public_local'); // Store the file
            }
        }

        $requestData = array_merge($data, [
            'company_id' => $company_id,
        ]);

        $employeeData = Arr::except($requestData, ['photo']);

        $employee = Employee::create($employeeData);

        if ($employee) {
            $careerData = [
                'employee_id' => $employee->id,
                'position_id' => $request->position_id ?? null,
                'start_date' => $employee->date_joining ?? now(),
                'placement' => $employee->position->division->name ?? null,
                'type' => null,
                'description' => 'Karyawan Baru' ?? null,
            ];

            $employee->employeeCareers()->create($careerData);

            $employee->employeePhotos()->create([
                'file_path' => $data['photo'],
                'main_photo' => true,
            ]);
        }


        return redirect()->route('employee.index')->with('success', 'Data has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        $selectedPositionId = $employee->position_id;

        $positions = Position::whereDoesntHave('selectedPositions', function ($query) {
            $query->where('is_finished', false);
        })->whereDoesntHave('selectedCandidates', function ($query) {
            $query->where('is_hire', null);
        })->whereDoesntHave('selectedCandidates', function ($query) {
            $query->where('is_approve', null);
        })->whereDoesntHave('employee', function ($query) {
            $query->where('date_leaving', null);
        })->OrWhere('id', $selectedPositionId)
            ->latest()
            ->get();

        $employeeCategories = EmployeeCategory::orderBy('name', 'asc')->get();

        $retirementDate = Carbon::parse($employee->dob)->addYears(55)->addMonths(3);

        $currentDate = Carbon::now();
        $diff = $currentDate->diff($retirementDate);

        $remainingYears = $diff->y;  // Whole years
        $remainingMonths = $diff->m; // Remaining months after whole years

        return view('pages.employee.show', compact(
            'positions',
            'employeeCategories',
            'employee',
            'retirementDate',
            'remainingYears',
            'remainingMonths',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $selectedPositionId = $employee->position_id;

        $positions = Position::whereDoesntHave('selectedPositions', function ($query) {
            $query->where('is_finished', false);
        })->whereDoesntHave('selectedCandidates', function ($query) {
            $query->where('is_hire', null);
        })->whereDoesntHave('selectedCandidates', function ($query) {
            $query->where('is_approve', null);
        })->whereDoesntHave('employee', function ($query) {
            $query->where('date_leaving', null);
        })->OrWhere('id', $selectedPositionId)
            ->latest()
            ->get();

        $employeeCategories = EmployeeCategory::orderBy('name', 'asc')->get();

        return view('pages.employee.edit', compact('positions', 'employeeCategories', 'employee', 'selectedPositionId'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $data = $request->all();

        $file_fields = [
            'photo',
            'file_cv',
            'file_ktp',
            'file_ijazah',
            'file_kk',
            'file_skck',
            'file_vaksin',
            'file_surat_sehat',
            'file_sertifikat',
            'file_sim_a',
            'file_sim_b',
            'file_sim_c',
        ];

        foreach ($file_fields as $file_field) {
            $path_file = $employee->$file_field;

            if ($request->hasFile($file_field)) {
                $file = $request->file($file_field);
                $extension = $file->getClientOriginalExtension();
                $file_name = $file_field . '_' . $data['name'] . '_' . time() . '.' . $extension;

                $data[$file_field] = $file->storeAs('files/employee/' . $file_field, $file_name, 'public_local');

                if (! empty($path_file)) {
                    Storage::disk('public_local')->delete($path_file);
                }
            } else {
                $data[$file_field] = $path_file;
            }
        }

        $employee->update($data);
        return redirect()->back()->with('success', 'Employee has been updated successfully!');
        // return redirect()->route('employee.index')->with('success', 'Employee has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->back()->with('success', 'Data has been deleted successfully!');
    }

    public function newEmployee($id)
    {
        try {
            $decrypt = decrypt($id);
            $selectedCandidate = SelectedCandidate::findOrFail($decrypt);
        } catch (DecryptException $e) {
            abort(404, 'Invalid payload');
        } catch (ModelNotFoundException $e) {
            abort(404, 'Selected candidate not found');
        }

        $candidate = Candidate::find($selectedCandidate->candidate_id);

        if (! $candidate->employee) {
            Employee::create([
                // "nik" => 000000,

                'position_id' => null,
                'date_joining' => now(),
                'candidate_id' => $candidate->id,
                "company_id" => $candidate->company_id ?? null,
                "name" => $candidate->name ?? null,
                // "photo" => $candidate->photo ?? null,
                "email" => $candidate->email ?? null,
                "phone_number1" => $candidate->phone_number ?? null,
                "ktp_address" => $candidate->ktp_address ?? null,
                "current_address" => $candidate->current_address ?? null,
                "npwp_number" => $candidate->npwp_number ?? null,
                "ktp_number" => $candidate->ktp_number ?? null,
                "kk_number" => $candidate->kk_number ?? null,
                "religion" => $candidate->religion ?? null,
                "nationality" => $candidate->nationality ?? null,
                "height" => $candidate->height ?? null,
                "weight" => $candidate->weight ?? null,
                "dob" => $candidate->dob ?? null,
                "pob" => $candidate->pob ?? null,
                "gender" => $candidate->gender ?? null,
                "date_applied" => $candidate->date_applied ?? null,
                "file_cv" => $candidate->file_cv ?? null,
                "file_kk" => $candidate->file_kk ?? null,
                "file_ktp" => $candidate->file_ktp ?? null,
                "file_skck" => $candidate->file_skck ?? null,
                "blood_type" => $candidate->blood_type ?? null,
                "ethnic" => $candidate->ethnic ?? null,
                "candidate_from" => $candidate->candidate_from ?? null,
                "applied_position" => $candidate->applied_position ?? null,
                "recommended_position" => $candidate->recommended_position ?? null,
                "marital_status" => $candidate->marital_status ?? null,
                "paspor_number" => $candidate->paspor_number ?? null,
                "file_vaksin" => $candidate->file_vaksin ?? null,
                "file_surat_sehat" => $candidate->file_surat_sehat ?? null,
                "longitude_ktp" => $candidate->longitude_ktp ?? null,
                "latitude_ktp" => $candidate->latitude_ktp ?? null,
                "longitude_domisili" => $candidate->longitude_domisili ?? null,
                "latitude_domisili" => $candidate->latitude_domisili ?? null,
                "sim_a" => $candidate->sim_a ?? null,
                "expired_sim_a" => $candidate->expired_sim_a ?? null,
                "file_sim_a" => $candidate->file_sim_a ?? null,
                "sim_b" => $candidate->sim_b ?? null,
                "expired_sim_b" => $candidate->expired_sim_b ?? null,
                "file_sim_b" => $candidate->file_sim_b ?? null,
                "sim_c" => $candidate->sim_c ?? null,
                "expired_sim_c" => $candidate->expired_sim_c ?? null,
                "file_sim_c" => $candidate->file_sim_c ?? null,
                "last_educational" => $candidate->last_educational ?? null,
                "study" => $candidate->study ?? null,
                "file_sertifikat" => $candidate->file_sertifikat ?? null,
                "file_ijazah" => $candidate->file_ijazah ?? null,
                "reference" => $candidate->reference ?? null,
                "disability" => $candidate->disability ?? null,
                // "is_hire" => $candidate->is_hire ?? null,
                // "is_selection" => $candidate->is_selection ?? null,
                "tag" => $candidate->tag ?? null,
                "glasses" => $candidate->glasses ?? null,
                "zipcode_ktp" => $candidate->zipcode_ktp ?? null,
            ]);

        }

        $positions = Position::where('id', $selectedCandidate->position_id)->latest()->get();

        $employeeCategories = EmployeeCategory::latest()->get();

        return view('pages.employee.new-employee', compact('selectedCandidate', 'candidate', 'positions', 'employeeCategories'));
    }

    public function updateNewEmployee(UpdateNewEmployeeRequest $request, $id)
    {
        $data = $request->all();

        $selectedCandidate = SelectedCandidate::findOrFail($id);

        $selectedCandidate->is_hire = 1;

        $selectedCandidate->save();

        $candidate = $selectedCandidate->candidate;

        if ($candidate->employee) {
            $careerData = [
                'employee_id' => $candidate->employee->id,
                'position_id' => $selectedCandidate->position_id ?? null,
                'start_date' => $data['date_joining'] ?? now(),
                'placement' => $selectedCandidate->position->division->name ?? null,
                'type' => null,
                'description' => 'Karyawan Baru' ?? null,
            ];

            $candidate->employee->employeeCareers()->create($careerData);

            $candidate->employee->employeePhotos()->create([
                'file_path' => $candidate->photo,
                'main_photo' => true,
            ]);

            $candidate->employee->update($data);

            return redirect()->route('employee.index')->with('success', 'Employee data updated successfully.');
        } else {
            return redirect()->route('employee.index')->with('error', 'Employee record not found for the given candidate.');
        }
    }
    public function getEmployeeChartData($year)
    {
        $companyId = Auth::user()->company_id;
        $isSuperAdmin = Auth::user()->hasRole('super-admin');

        $employeeActiveData = [];
        $employeeNonActiveData = [];

        // Populate example data or fetch from database (you would replace this part)
        for ($month = 1; $month <= 12; $month++) {
            $employeeActiveData[] = DB::table('employees')->when(! $isSuperAdmin, function ($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })->where('employee_status', 'AKTIF')
                ->whereYear('date_joining', $year)
                ->whereMonth('date_joining', $month)
                ->count();

            $employeeNonActiveData[] = DB::table('employees')->when(! $isSuperAdmin, function ($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })->where('employee_status', '!=', 'AKTIF')
                ->whereYear('date_joining', $year)
                ->whereMonth('date_joining', $month)
                ->count();
        }
        return response()->json([
            'employeeActiveData' => $employeeActiveData,
            'employeeNonActiveData' => $employeeNonActiveData,
        ]);
    }

    public function getEmployeeAttendances(Request $request)
    {
        $month = $request->get('month', date('n'));
        $year = $request->get('year', date('Y'));
        $nik = $request->nik;

        $employeeAttendances = Attendance::query()
            ->when($month, fn ($query) => $query->whereMonth('date', $month))
            ->when($year, fn ($query) => $query->whereYear('date', $year))
            ->when($nik, fn ($query) => $query->where('nik', $nik)) // Fixed condition
            ->get();

        // $employeeName = $employeeAttendances->first()?->employee->name ?? 'Unknown';

        return view('pages.employee.personal-data.form.employee-attendance.employee-attendance', compact('employeeAttendances', ));
    }

    public function attendanceExport()
    {
        return Excel::download(
            new AttendanceExport,
            'absensi_' . request('name', 'unknown') . '_' . request('year', now()->year) . '_' . request('month', now()->month) . '.xlsx'
        );
    }

    // public function uploadPhoto(Request $request)
    // {
    //     $request->validate([
    //         'employee_id' => 'required|exists:employees,id',
    //         'position_id' => 'nullable|exists:positions,id',
    //         'company_id' => 'nullable|exists:companies,id',
    //         'main_photo' => 'nullable|boolean', // Ensure it's a boolean value
    //         'file_path' => 'required|file|max:5120', // Allow any file type with max size 5MB
    //     ], [
    //         'employee_id.required' => 'Karyawan harus dipilih.',
    //         'employee_id.exists' => 'Karyawan yang dipilih tidak valid.',
    //         'position_id.exists' => 'Posisi yang dipilih tidak valid.',
    //         'company_id.required' => 'Perusahaan harus dipilih.',
    //         'company_id.exists' => 'Perusahaan yang dipilih tidak valid.',
    //         'main_photo.boolean' => 'Foto utama harus berupa nilai boolean.',
    //         'file_path.file' => 'File harus berupa file yang valid.',
    //         'file_path.max' => 'Ukuran file tidak boleh lebih dari 5MB.',
    //     ]);

    //     $data = $request->all();

    //     if ($request->hasFile('file_path')) {
    //         $file = $request->file('file_path'); // Get the file from the request
    //         $extension = $file->getClientOriginalExtension(); // Get the file extension
    //         $file_name = 'file_path_' . $request['name'] . '_' . time() . '.' . $extension; // Construct the file name
    //         $data['file_path'] = $file->storeAs('files/employee/file_path', $file_name, 'public_local'); // Store the file
    //     }

    //     EmployeePhoto::create($data);

    //     // Redirect back with success message
    //     return redirect()->back()->with('success', 'Data has been created successfully!');
    // }

}
