<?php

namespace App\Http\Controllers\Employee;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Exports\EmployeeExport;
use App\Exports\AttendanceExport;
use App\Models\Approval\Approval;
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
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $employees = Employee::with('employeeCategory', 'position.division', 'position.level')
            ->when(! Auth::user()->hasRole('super-admin'), function ($query) {
                $query->where('employees.company_id', Auth::user()->company_id);
            })
            ->when($request->filled(['employee_status']), function ($query) use ($request) {
                if ($request->employee_status === 'NONAKTIF') {
                    $query->where('employee_status', '!=', 'AKTIF');
                } else {
                    $query->where('employee_status', $request->employee_status);
                }
            })
            ->when($request->filled(['start_date', 'end_date']), function ($query) use ($request) {
                $startDate = $request->start_date;
                $endDate = $request->end_date;

                if ($request->employee_status === 'NONAKTIF') {
                    // Filter by date_leaving for non-active employees
                    $query->whereBetween('date_leaving', [$startDate, $endDate]);
                } elseif ($request->employee_status === 'AKTIF') {
                    // Filter by date_joining for active employees
                    $query->whereBetween('date_joining', [$startDate, $endDate]);
                } else {
                    // Filter for both active and non-active employees
                    $query->where(function ($subQuery) use ($startDate, $endDate) {
                        $subQuery->whereBetween('date_joining', [$startDate, $endDate])
                            ->orWhereBetween('date_leaving', [$startDate, $endDate]);
                    });
                }
            })

            ->whereNotNull('nik')
            ->join('positions', 'employees.position_id', '=', 'positions.id') // Join positions
            ->join('divisions', 'positions.division_id', '=', 'divisions.id') // Join divisions
            ->join('levels', 'positions.level_id', '=', 'levels.id') // Join levels
            ->orderBy('divisions.name', 'asc') // Then order by division name
            ->orderBy('levels.id', 'asc') // Order by level name
            ->select('employees.*') // Select employees columns to avoid ambiguity
        ;



        // if (! Auth::user()->hasRole('super-admin')) {
        //     $employees->where('company_id', Auth::user()->company_id);
        // }

        if (request()->ajax()) {
            return DataTables::of($employees)
                ->addIndexColumn()
                ->addColumn('action', function ($item) {
                    $verifiedRoute = route('employee.verified', $item);
                    $unverifiedRoute = route('employee.unverified', $item);
                    $showRoute = route('employee.show', $item);
                    $deleteRoute = route('employee.destroy', $item);

                    $isVerified = $item->is_verified;
                    $deleteFormId = "deleteForm_{$item->id}";
                    $canVerify = auth()->user()->can('employee.verified'); // Check user roles
    
                    return '
        <div class="btn-group mb-1">
            <div class="dropdown">
                <button class="btn btn-sm btn-primary dropdown-toggle me-1" type="button" id="dropdownMenuButton"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bi bi-three-dots-vertical"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    '.($canVerify ? '
                    <!-- Verified Form -->
                    <form id="verifiedForm_'.$item->id.'" action="'.$verifiedRoute.'" method="POST" style="display: none;">
                        '.csrf_field().method_field('PATCH').'
                    </form>
                    <a class="dropdown-item" href="javascript:void(0);"
                    onclick="if(confirm(\'Are you sure you want to verify this employee?\')) {
                     document.getElementById(\'verifiedForm_'.$item->id.'\').submit();
                    }"
                    '.($isVerified ? 'hidden' : '').'>Verified</a>
                    ' : '').'

                    <!-- Unverified Form -->
                    <form id="unverifiedForm_'.$item->id.'" action="'.$unverifiedRoute.'" method="POST" style="display: none;">
                        '.csrf_field().method_field('PATCH').'
                    </form>
                    <a class="dropdown-item" href="javascript:void(0);"
                        onclick="if(confirm(\'Are you sure you want to Unverify this employee?\'))
                        {document.getElementById(\'unverifiedForm_'.$item->id.'\').submit();}"
                        '.(! $isVerified
                        ? 'hidden'
                        : ($item->approvals->where('description', 'Buka Verifikasi')->whereNull('is_approve')->first()
                            ? 'hidden'
                            : '')).'
                        >Unverified</a>
                    
                    <!-- View/Edit -->
                    <a class="dropdown-item" href="'.$showRoute.'">'.($isVerified ? 'Lihat' : 'Edit').'</a>

                    <!-- Delete -->
                    '.(! $isVerified ? '
                    <button class="dropdown-item" onclick="showSweetAlert('.$item->id.')">Hapus</button>
                    <form id="'.$deleteFormId.'" action="'.$deleteRoute.'" method="POST" style="display: none;">
                        '.csrf_field().method_field('DELETE').'
                    </form>' : '').'
                </div>
            </div>
        </div>';
                })
                ->editColumn('photo', function ($item) {
                    $mainPhoto = $item->employeePhotos->where('main_photo', true)->first();

                    if ($mainPhoto) {
                        return '
                <div class="fixed-frame">
                    <img src="'.asset('storage/'.$mainPhoto->file_path).'" data-fancybox alt="Icon User"
                    class="framed-image" style="cursor: pointer">
                </div>';
                    } else {
                        return 'No Image';
                    }
                    // })->editColumn('created_at', function ($item) {
                    //     return ''.Carbon::parse($item->created_at)->translatedFormat('d F Y').'';
                })->editColumn('employeeCategory', function ($item) {
                    $categoryName = $item->employeeCategory->name ?? '-';
                    $levelId = $item->position->level->id ?? '-';

                    $badgeColors = [
                        1 => 'bg-light-primary',
                        2 => 'bg-light-success',
                        3 => 'bg-light-warning',
                        4 => 'bg-light-danger',
                        5 => 'bg-light-info',
                    ];

                    $badgeClass = $badgeColors[$levelId] ?? 'badge-secondary';

                    if (in_array($levelId, [1, 2, 3, 4, 5])) {
                        return '<span>'.$categoryName.'</span><br>
                <span class="badge '.$badgeClass.'">'.$item->position->level->name.'</span>';
                    }

                    return '<span>'.$categoryName.'</span>';

                    // })->editColumn('position', function ($item) {
                    //     return $item->position->name ?? '-';
                    // })->editColumn('division', function ($item) {
                    //     return $item->position->division->name ?? '-';
                })->editColumn('is_verified', function ($item) {
                    // Initialize variables
                    $verified = '-';
                    $isRequest = '';
                    $latestContract = '';

                    // Determine verification badge
                    if ($item->is_verified == 0) {
                        $verified = '<span class="badge bg-danger">Unverified</span> <br>';
                    } elseif ($item->is_verified == 1) {
                        $verified = '<span class="badge bg-success">Verified</span> <br>';
                    }

                    // Check for 'Buka Verifikasi' approval request
                    if ($item->approvals->where('description', 'Buka Verifikasi')->whereNull('is_approve')->first()) {
                        $isRequest = '<span class="badge bg-secondary">Request Pending</span> <br>';
                    }

                    if ($item->contracts && $item->contracts->isNotEmpty()) {
                        $latestContractData = $item->contracts->first();
                        $contractSequence = $latestContractData->contract_sequence_number ?? '-';

                        // Calculate days until contract expiration
                        $contractEndDate = $latestContractData->end_date; // Assuming `end_date` exists in your contract model
                        $dateExpired = $contractEndDate ? Carbon::parse($contractEndDate)->translatedFormat('d-m-Y') : '-';
                        $daysToExpire = $contractEndDate ? floor(now()->diffInDays(Carbon::parse($contractEndDate), false)) : null;

                        $daysToExpireText = $daysToExpire !== null
                            ? ($daysToExpire > 0
                                ? "$daysToExpire hari menuju kontrak habis"
                                : "Kontrak sudah habis")
                            : "Tanggal akhir kontrak tidak tersedia";

                        $color = $daysToExpire !== null
                            ? ($daysToExpire > 0
                                ? "secondary"
                                : "light-danger")
                            : "Tanggal akhir kontrak tidak tersedia";

                        $latestContract = '<small><span class="badge bg-light-dark">Kontrak Ke - '.$contractSequence.'</span></small> <br>
                        '.'<small><span class="badge bg-'.$color.'">'.$daysToExpireText.'</span></small><br>
                           <small><span class="badge bg-light-secondary">'.$dateExpired.'</span></small>';
                    }

                    // Return the concatenated result
                    return $verified.$isRequest.$latestContract;
                })->editColumn('employee_nik', function ($item) {
                    $dateJoining = Carbon::parse($item->date_joining);
                    $masaKerja = $dateJoining->diff(Carbon::now());
                    $dob = Carbon::parse($item->dob);
                    $age = $dob->diff(Carbon::now());
                    return '<span class="badge bg-light-primary" style="font-size: 110%">'.$item->nik.'</span>
                    <br><small>Tgl Lahir : '.Carbon::parse($item->dob)->translatedFormat('d-m-Y').'</small>
                    <br><small>Usia : '.$age->y.' tahun </small>
                    <br><small>Status : '.$item->marital_status.'</small>
                    <br><small>Masa Kerja : </small>
                    <br><small class="badge bg-light-info">'.$masaKerja->y.' tahun '.$masaKerja->m.' bulan '.$masaKerja->d.' hari</small>';
                })
                ->rawColumns(['action', 'photo', 'is_verified', 'employeeCategory', 'employee_nik'])
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
        $data = $request->except('is_hire', );

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
                $file_name = $file_field.'_'.$data['name'].'_'.time().'.'.$extension; // Construct the file name
                $data[$file_field] = $file->storeAs('files/employee/'.$file_field, $file_name, 'public_local'); // Store the file
            }
        }

        $requestData = array_merge($data, [
            'company_id' => $company_id,
        ]);

        $employeeData = Arr::except($requestData, ['photo']);

        $employee = Employee::create($employeeData);

        if ($employee) {
            Approval::create([
                'company_id' => $employee->company_id,

                // 'selected_candidate_id' =>null,
                // 'employee_career_id' => null,
                'employee_id' => $employee->id,
                'position_id' => $employee->position_id,
                'description' => 'Karyawan Baru',
                'is_approve' => null,
            ]);
        }

        if ($employee) {
            $careerData = [
                'employee_id' => $employee->id,
                'position_id' => $request->position_id ?? null,
                'start_date' => $employee->date_joining ?? now(),
                'placement' => $employee->position->division->name ?? null,
                'type' => null,
                'is_approve' => 1,
                'description' => 'Karyawan Baru' ?? null,
            ];

            $employee->employeeCareers()->create($careerData);

            if (isset($data['photo'])) {
                $employee->employeePhotos()->create([
                    'file_path' => $data['photo'],
                    'main_photo' => true,
                ]);
            }

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

        // $retirementDate = Carbon::parse($employee->dob)->addYears(55)->addMonths(3);
        $retirementDate = Carbon::parse($employee->dob)->addYears(55);

        $currentDate = Carbon::now();
        $diff = $currentDate->diff($retirementDate);

        $remainingYears = $diff->invert ? 0 : $diff->y;  // Whole years (set to 0 if the date has passed)
        $remainingMonths = $diff->invert ? 0 : $diff->m; // Remaining months after whole years (set to 0 if the date has passed)

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
                $file_name = $file_field.'_'.$data['name'].'_'.time().'.'.$extension;

                $data[$file_field] = $file->storeAs('files/employee/'.$file_field, $file_name, 'public_local');

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
        if (! $candidate) {
            return redirect()->back()->with('error', 'Candidate not found.');
        }

        // if (Employee::where('candidate_id', $candidate->id)->exists()) {
        //     return redirect()->back()->with('error', 'This candidate is already an employee.');
        // }


        if (! $candidate->employee) {
            $employee = Employee::create([
                'position_id' => $selectedCandidate->position_id,
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

        // dd($candidate->employee);

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
                'is_approve' => true,
            ];

            $candidate->employee->employeeCareers()->create($careerData);

            if ($candidate->photo) {
                $candidate->employee->employeePhotos()->create([
                    'file_path' => $candidate->photo,
                    'main_photo' => true,
                ]);
            }

            if ($candidate->jobHistories) {
                foreach ($candidate->jobHistories as $jobHistory) {
                    $jobHistoryData = [
                        'employee_id' => $candidate->employee->id,
                        'company_name' => $jobHistory->company_name,
                        'city' => $jobHistory->city,
                        'period' => $jobHistory->period,
                        'position' => $jobHistory->position,
                        'reason' => $jobHistory->reason,
                        'job_description' => $jobHistory->job_description,
                    ];

                    EmployeeJobHistory::create($jobHistoryData);
                }
            }

            $candidate->employee->update($data);

            return redirect()->route('employee.index')->with('success', 'Employee data updated successfully.');
        } else {
            return redirect()->route('employee.index')->with('error', 'Employee record not found for the given candidate.');
        }
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
            'absensi_'.request('name', 'unknown').'_'.request('year', now()->year).'_'.request('month', now()->month).'.xlsx'
        );
    }

    public function verify(Employee $employee, Request $request)
    {
        if ($employee->is_verified) {
            return redirect()->back()->with('error', 'Employee is already verified.');
        }

        $employee->update(['is_verified' => true]);

        return redirect()->back()->with('success', 'Employee has been successfully verified.');
    }

    public function unverified(Employee $employee, Request $request)
    {
        if (! $employee->is_verified) {
            return redirect()->back()->with('error', 'Employee is already verified.');
        }

        // $employee->update(['is_verified' => false]);

        if ($employee) {
            Approval::create([
                // 'selected_candidate_id' =>null,
                'company_id' => $employee->company_id,
                'employee_id' => $employee->id,
                'position_id' => $employee->position_id,
                'description' => 'Buka Verifikasi',
                'is_approve' => null,
            ]);
        }

        return redirect()->back()->with('success', 'Request to unverified employee has been successfully submitted.');
    }

    public function exportEmployees(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $employeeStatus = $request->get('employee_status');

        return Excel::download(new EmployeeExport($startDate, $endDate, $employeeStatus), 'employees.xlsx');
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
