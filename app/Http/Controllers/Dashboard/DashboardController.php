<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Employee\Contract;
use App\Models\Employee\Employee;
use App\Models\Position\Position;
use App\Models\WorkUnit\Division;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\WorkUnit\Directorate;
use Illuminate\Support\Facades\Auth;
use App\Models\ManagementAccess\Company;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $companyId = Auth::user()->company_id;
        $isSuperAdmin = Auth::user()->hasRole('super-admin');

        $directorates = Directorate::when(! $isSuperAdmin, function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->get();

        $nextMonthEnd = Carbon::now()->endOfMonth()->addMonths(2); // End of next month
        $today = Carbon::now();

        $contracts = Contract::when(! $isSuperAdmin, function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->orderBy('end_date', 'desc');

        $contractsIncoming = $contracts->whereBetween('end_date', [$today, $nextMonthEnd])
            ->get();

        $contractsExpired = Contract::with('employee.position.division')->when(! $isSuperAdmin, function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })
            ->whereHas('employee', function ($query) {
                $query->whereNull('date_leaving'); // Only active employees
            })
            ->when($request->filled('month'), function ($query) use ($request) {
                $query->whereMonth('end_date', $request->month);
            })
            ->when($request->filled('year'), function ($query) use ($request) {
                $query->whereYear('end_date', $request->year ?? now()->year);
            })
            ->orderBy('employee_id', 'asc')
            ->orderBy('end_date', 'asc');

        if (request()->ajax()) {
            return DataTables::of($contractsExpired)
                ->addIndexColumn()
                ->addColumn('contract', function ($contract) {
                    // Fetch the latest contract for the employee
                    $latestContract = $contract->where('employee_id', $contract->employee_id) // Adjust the field if necessary
                        ->orderBy('start_date', 'desc')
                        ->first();

                    if ($contract->id === $latestContract->id) {
                        if ($latestContract->end_date <= now()) {
                            $button = '<button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-form-add-contract'.$contract->employee->id.'">
                <i class="bi bi-plus-lg"></i> Kontrak
            </button>';

                        } else {
                            return '<p><small>Kontrak<br>berjalan</small></p>';
                        }
                    } else {
                        // For all other contracts, show the message that the contract has been renewed
                        return '<p><small>Kontrak<br>diperbarui</small></p>';
                    }

                    $modal = view('pages.employee.personal-data.form.employee-contract.modal-create', [
                        'contract' => $contract // Pass the contract data to the modal view
                    ])->render();

                    return $button.$modal;
                })
                ->addColumn('pk', function ($contract) {
                    // Check if the contract has a related contractKpi
                    if ($contract->contractKpi) {
                        // Display the grade
                        $html = $contract->contractKpi->grade.'<br>';

                        // Check if contract recommendation exists
                        if ($contract->contractKpi->contract_recommendation) {
                            $html .= '<span class="badge bg-success">Kontrak Di Perpanjang</span>';
                        } else {
                            $html .= '<span class="badge bg-danger">Kontrak tidak diperpanjang</span>';
                        }

                        return $html;
                    } else {
                        // If contractKpi doesn't exist, show the button to add a KPI
                        $html = '<button type="button" class="btn btn-sm btn-primary " data-bs-toggle="modal" data-bs-target="#modal-form-add-kpi'.$contract->employee->id.'">
                    <i class="bi bi-plus-lg"></i> PK
                 </button>';

                        // Include the modal HTML content for creating a new KPI
                        $html .= view('pages.employee.personal-data.form.kpi.modal-create', [
                            'contract' => $contract // Pass the contract data to the modal view
                        ])->render();

                        return $html;
                    }
                })

                ->rawColumns(['pk', 'contract'])
                ->toJson();
        }

        $divisions = Division::when(! $isSuperAdmin, function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->get();

        $companies = Company::with('directorates')->when(! $isSuperAdmin, function ($query) use ($companyId) {
            $query->where('id', $companyId);
        })->orderBy('name', 'asc')->get();

        $currentYear = date('Y');
        $employeeActiveData = [];
        $employeeNonActiveData = [];
        $monthlyEmployeeData = [];
        // Fetch employee data per month for the current year
        for ($month = 1; $month <= 12; $month++) {
            $employeeActiveData[] = DB::table('employees')->when(! $isSuperAdmin, function ($query) use ($companyId) {
                $query->where('employees.company_id', $companyId);
            })->where('employees.employee_status', 'AKTIF')->join('positions', 'employees.position_id', '=', 'positions.id')
                ->whereYear('employees.date_joining', $currentYear)
                ->whereMonth('employees.date_joining', $month)
                ->count();

            $employeeNonActiveData[] = DB::table('employees')->when(! $isSuperAdmin, function ($query) use ($companyId) {
                $query->where('employees.company_id', $companyId);
            })->where('employees.employee_status', '!=', 'AKTIF')->join('positions', 'employees.position_id', '=', 'positions.id')
                ->whereYear('employees.date_leaving', $currentYear)
                ->whereMonth('employees.date_leaving', $month)
                ->count();

            $employeeCount = DB::table('employees')
                ->when(! $isSuperAdmin, function ($query) use ($companyId) {
                    $query->where('company_id', $companyId);
                })
                ->where(function ($query) use ($currentYear, $month) {
                    $query->whereYear('date_joining', '<', $currentYear)
                        ->orWhere(function ($query) use ($currentYear, $month) {
                            $query->whereYear('date_joining', '=', $currentYear)
                                ->whereMonth('date_joining', '<=', $month);
                        });
                })
                ->where(function ($query) use ($currentYear, $month) {
                    $query->whereNull('date_leaving')
                        ->orWhere(function ($query) use ($currentYear, $month) {
                            $query->whereYear('date_leaving', '>', $currentYear)
                                ->orWhere(function ($query) use ($currentYear, $month) {
                                    $query->whereYear('date_leaving', '=', $currentYear)
                                        ->whereMonth('date_leaving', '>=', $month);
                                });
                        });
                })
                ->count();

            $monthlyEmployeeData[] = $employeeCount;


            // $employeeNonActiveData[] = DB::table('employees')->when(! $isSuperAdmin, function ($query) use ($companyId) {
            //     $query->where('company_id', $companyId);
            // })->where('employee_status', '!=', 'AKTIF')
            //     ->whereYear('date_joining', $currentYear)
            //     ->whereMonth('date_joining', $month)
            //     ->count();
        }
        // Get the current month and year
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Get the requested month and year from the input, or default to current month and year
        $selectedMonth = $request->input('month', $currentMonth);
        $selectedYear = $request->input('year', $currentYear);

        // Base query for employee career approvals
        $query = DB::table('approvals')
            ->join('employee_careers', 'approvals.employee_career_id', '=', 'employee_careers.id')
            ->where('approvals.is_approve', 1);

        // Prepare the data array
        $dataPerMonth = [
            // 'karyawan_baru' => $query->clone()
            //     ->whereNotNull('selected_candidate_id')
            //     ->whereMonth('employee_careers.start_date', $selectedMonth)
            //     ->whereYear('employee_careers.start_date', $selectedYear)
            //     ->when(! auth()->user()->hasRole('super-admin'), function ($q) use ($companyId) {
            //         return $q->where('approvals.company_id', $companyId);
            //     })
            //     ->count(),
            'karyawan_baru' => DB::table('approvals')
                ->whereNotNull('selected_candidate_id')
                ->where('is_approve', 1)
                ->whereMonth('created_at', $selectedMonth)
                ->whereYear('created_at', $selectedYear)
                ->when(! auth()->user()->hasRole('super-admin'), function ($q) use ($companyId) {
                    return $q->where('company_id', $companyId);
                })
                ->count(),
            'buka_verifikasi' => DB::table('approvals')
                ->whereNotNull('employee_id')
                ->where('is_approve', 1)
                ->whereMonth('created_at', $selectedMonth)
                ->whereYear('created_at', $selectedYear)
                ->when(! auth()->user()->hasRole('super-admin'), function ($q) use ($companyId) {
                    return $q->where('company_id', $companyId);
                })
                ->count(),
            'categories' => [
                'Promosi' => 'PROMOSI',
                'Demosi' => 'DEMOSI',
                'Restruktur Organisasi' => 'RESTRUKTUR ORGANISASI',
                'Mutasi' => 'MUTASI',
                'Rotasi' => 'ROTASI',
                'Pensiun' => 'PENSIUN',
                'Resign' => 'RESIGN',
                'Non-Aktif' => 'NON-AKTIF',
            ],
        ];

        // Calculate counts for each category
        foreach ($dataPerMonth['categories'] as $key => $type) {
            $dataPerMonth['categories'][$key] = $query->clone()
                ->where('employee_careers.type', $type)
                ->whereMonth('employee_careers.start_date', $selectedMonth)
                ->whereYear('employee_careers.start_date', $selectedYear)
                ->when(! auth()->user()->hasRole('super-admin'), function ($q) use ($companyId) {
                    return $q->where('approvals.company_id', $companyId);
                })
                ->count();
        }

        // Prepare data for per year
        $dataPerYear = [
            // 'karyawan_baru' => $query->clone()
            //     ->whereNotNull('selected_candidate_id')
            //     ->whereYear('employee_careers.start_date', $selectedYear)
            //     ->when(! auth()->user()->hasRole('super-admin'), function ($q) use ($companyId) {
            //         return $q->where('approvals.company_id', $companyId);
            //     })
            //     ->count(),
            'karyawan_baru' => DB::table('approvals')
                ->whereNotNull('selected_candidate_id')
                ->where('is_approve', 1)
                ->whereYear('created_at', $selectedYear)
                ->when(! auth()->user()->hasRole('super-admin'), function ($q) use ($companyId) {
                    return $q->where('company_id', $companyId);
                })
                ->count(),
            'buka_verifikasi' => DB::table('approvals')
                ->whereNotNull('employee_id')
                ->where('is_approve', 1)
                ->whereYear('created_at', $selectedYear)
                ->when(! auth()->user()->hasRole('super-admin'), function ($q) use ($companyId) {
                    return $q->where('company_id', $companyId);
                })
                ->count(),
            'categories' => [
                'Promosi' => 'PROMOSI',
                'Demosi' => 'DEMOSI',
                'Restruktur Organisasi' => 'RESTRUKTUR ORGANISASI',
                'Mutasi' => 'MUTASI',
                'Rotasi' => 'ROTASI',
                'Pensiun' => 'PENSIUN',
                'Resign' => 'RESIGN',
                'Non-Aktif' => 'NON-AKTIF',
            ],
        ];

        // Calculate counts for each category for the year
        foreach ($dataPerYear['categories'] as $key => $type) {
            $dataPerYear['categories'][$key] = $query->clone()
                ->where('employee_careers.type', $type)
                ->whereYear('employee_careers.start_date', $selectedYear)
                ->when(! auth()->user()->hasRole('super-admin'), function ($q) use ($companyId) {
                    return $q->where('approvals.company_id', $companyId);
                })
                ->count();
        }

        $employees = Employee::when(! $isSuperAdmin, function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        });

        // Count all active employees
        $allActiveEmployee = (clone $employees)
            ->where('employee_status', 'AKTIF')
            ->count();

        // Count active employees added this month
        $activePermonth = (clone $employees)
            ->where('employee_status', 'AKTIF')
            ->whereMonth('created_at', now()->month)
            ->count();

        // Count non-active employees added this month
        $nonActivePermonth = (clone $employees)
            ->where('employee_status', '!=', 'AKTIF')
            ->whereMonth('created_at', now()->month)
            ->count();

        // Count active employees added this year
        $activePeryear = (clone $employees)
            ->where('employee_status', 'AKTIF')
            ->whereYear('created_at', now()->year)
            ->count();

        // Count non-active employees added this year
        $nonActivePeryear = (clone $employees)
            ->where('employee_status', '!=', 'AKTIF')
            ->whereYear('created_at', now()->year)
            ->count();

        // Count employees retiring this year
        $retirementCount = (clone $employees)
            ->where('employee_status', 'AKTIF')
            ->get() // Retrieve as a collection
            ->filter(function ($employee) {
                $retirementDate = Carbon::parse($employee->dob)->addYears(55)->addMonths(3);
                return $retirementDate->year === now()->year;
            })
            ->count();



        return view('pages.dashboard.index', compact(
            'dataPerMonth',
            'dataPerYear',
            'employees',
            'directorates',
            'divisions',
            'companies',
            'employeeActiveData',
            'employeeNonActiveData',
            'monthlyEmployeeData',
            'contractsIncoming',
            'contractsExpired',
            'selectedMonth',
            'selectedYear',

            // 'empl',

            'allActiveEmployee',
            'activePermonth',
            'nonActivePermonth',
            'activePeryear',
            'nonActivePeryear',
            'retirementCount',
        ));
    }

    // search kontrak di dashboard, print candidate

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort(404);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort(404);
    }

    public function getEmployeeChartData($year)
    {
        $companyId = Auth::user()->company_id;
        $isSuperAdmin = Auth::user()->hasRole('super-admin');

        $employeeActiveData = [];
        $employeeNonActiveData = [];
        $monthlyEmployeeData = [];

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
                ->whereYear('date_leaving', $year)
                ->whereMonth('date_leaving', $month)
                ->count();

            $employeeCount = DB::table('employees')
                ->when(! $isSuperAdmin, function ($query) use ($companyId) {
                    $query->where('company_id', $companyId);
                })
                ->where(function ($query) use ($year, $month) {
                    $query->whereYear('date_joining', '<', $year)
                        ->orWhere(function ($query) use ($year, $month) {
                            $query->whereYear('date_joining', '=', $year)
                                ->whereMonth('date_joining', '<=', $month);
                        });
                })
                ->where(function ($query) use ($year, $month) {
                    $query->whereNull('date_leaving')
                        ->orWhere(function ($query) use ($year, $month) {
                            $query->whereYear('date_leaving', '>', $year)
                                ->orWhere(function ($query) use ($year, $month) {
                                    $query->whereYear('date_leaving', '=', $year)
                                        ->whereMonth('date_leaving', '>=', $month);
                                });
                        });
                })
                ->count();

            $monthlyEmployeeData[] = $employeeCount;
        }


        return response()->json([
            'employeeActiveData' => $employeeActiveData,
            'employeeNonActiveData' => $employeeNonActiveData,
            'monthlyEmployeeData' => $monthlyEmployeeData,
        ]);
    }

    public function getDivisionEmployee($id)
    {
        $divisionId = Division::findOrFail($id);

        $positions = Position::with('level')->whereHas('employee', function ($query) {
            $query
                ->where('employee_status', 'AKTIF')
                ->when(! Auth::user()->hasRole('super-admin'), function ($query) {
                    $query->where('company_id', Auth::user()->company_id);
                });
        })->where('division_id', $id)
            ->join('levels', 'positions.level_id', '=', 'levels.id') // Join the levels table
            ->orderBy('levels.id', 'asc') // Order by the levels.name
            ->select('positions.*') // Select only position columns to avoid ambiguity
            ->get();

        return view('pages.dashboard.employeesDivision', compact('positions', 'divisionId'));
    }

    public function employee()
    {
        $companyId = Auth::user()->company_id;
        $isSuperAdmin = Auth::user()->hasRole('super-admin');

        $directorates = Directorate::when(! $isSuperAdmin, function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->get();
        return view('pages.dashboard.table.employee-categories', compact('directorates'));
    }

    public function gender()
    {
        $companyId = Auth::user()->company_id;
        $isSuperAdmin = Auth::user()->hasRole('super-admin');

        $directorates = Directorate::when(! $isSuperAdmin, function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->get();
        return view('pages.dashboard.table.gender', compact('directorates'));
    }

    public function educational()
    {
        $companyId = Auth::user()->company_id;
        $isSuperAdmin = Auth::user()->hasRole('super-admin');

        $directorates = Directorate::when(! $isSuperAdmin, function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->get();
        return view('pages.dashboard.table.educational', compact('directorates'));
    }

    public function position()
    {
        $companyId = Auth::user()->company_id;
        $isSuperAdmin = Auth::user()->hasRole('super-admin');

        $directorates = Directorate::when(! $isSuperAdmin, function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->get();
        return view('pages.dashboard.table.position', compact('directorates'));
    }

    public function age()
    {
        $companyId = Auth::user()->company_id;
        $isSuperAdmin = Auth::user()->hasRole('super-admin');

        $directorates = Directorate::when(! $isSuperAdmin, function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->get();
        return view('pages.dashboard.table.age', compact('directorates'));
    }

    public function religion()
    {
        $companyId = Auth::user()->company_id;
        $isSuperAdmin = Auth::user()->hasRole('super-admin');

        $directorates = Directorate::when(! $isSuperAdmin, function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->get();
        return view('pages.dashboard.table.religion', compact('directorates'));
    }

}
