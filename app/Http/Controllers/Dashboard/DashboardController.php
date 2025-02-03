<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Approval\Approval;
use App\Models\Employee\Contract;
use App\Models\Employee\Employee;
use App\Models\Position\Position;
use App\Models\WorkUnit\Division;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\WorkUnit\Directorate;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmployeePerMonthExport;
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
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $selectedMonth = $request->input('month', $currentMonth);
        $selectedYear = $request->input('year', $currentYear);

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

        // $currentYear = date('Y');
        $employeeActiveData = [];
        $employeeNonActiveData = [];
        $monthlyEmployeeData = [];

        // Fetch employee data per month for the current year
        for ($month = 1; $month <= 12; $month++) {
            $employeeActive = DB::table('employees')->when(! $isSuperAdmin, function ($query) use ($companyId) {
                $query->where('employees.company_id', $companyId);
            })->where('employees.employee_status', 'AKTIF')->join('positions', 'employees.position_id', '=', 'positions.id')
                ->whereYear('employees.date_joining', $selectedYear)
                ->whereMonth('employees.date_joining', $month)
                ->count();

            $employeeNonActive = DB::table('employees')->when(! $isSuperAdmin, function ($query) use ($companyId) {
                $query->where('employees.company_id', $companyId);
            })->where('employees.employee_status', '!=', 'AKTIF')->join('positions', 'employees.position_id', '=', 'positions.id')
                ->whereYear('employees.date_leaving', $selectedYear)
                ->whereMonth('employees.date_leaving', $month)
                ->count();

            // if ($selectedYear != $currentYear) {
            //     $employeeCount = DB::table('employees')
            //         ->when(! $isSuperAdmin, function ($query) use ($companyId) {
            //             $query->where('company_id', $companyId);
            //         })
            //         ->where(function ($query) use ($selectedYear, $month) {
            //             $query->whereYear('date_joining', '<', $selectedYear)
            //                 ->orWhere(function ($query) use ($selectedYear, $month) {
            //                     $query->whereYear('date_joining', '=', $selectedYear)
            //                         ->whereMonth('date_joining', '<=', $month);
            //                 });
            //         })
            //         ->where(function ($query) use ($selectedYear, $month) {
            //             $query->whereNull('date_leaving')
            //                 ->orWhere(function ($query) use ($selectedYear, $month) {
            //                     $query->whereYear('date_leaving', '>', $selectedYear)
            //                         ->orWhere(function ($query) use ($selectedYear, $month) {
            //                             $query->whereYear('date_leaving', '=', $selectedYear)
            //                                 ->whereMonth('date_leaving', '>=', $month);
            //                         });
            //                 });
            //         })
            //         ->count();
            // } else {

            //     if ($month <= $currentMonth) {
            //         $employeeCount = DB::table('employees')
            //             ->when(! $isSuperAdmin, function ($query) use ($companyId) {
            //                 $query->where('company_id', $companyId);
            //             })
            //             ->where(function ($query) use ($selectedYear, $month) {
            //                 $query->whereYear('date_joining', '<', $selectedYear)
            //                     ->orWhere(function ($query) use ($selectedYear, $month) {
            //                         $query->whereYear('date_joining', '=', $selectedYear)
            //                             ->whereMonth('date_joining', '<=', $month);
            //                     });
            //             })
            //             ->where(function ($query) use ($selectedYear, $month) {
            //                 $query->whereNull('date_leaving')
            //                     ->orWhere(function ($query) use ($selectedYear, $month) {
            //                         $query->whereYear('date_leaving', '>', $selectedYear)
            //                             ->orWhere(function ($query) use ($selectedYear, $month) {
            //                                 $query->whereYear('date_leaving', '=', $selectedYear)
            //                                     ->whereMonth('date_leaving', '>=', $month);
            //                             });
            //                     });
            //             })
            //             ->count();
            //     } else {
            //         $employeeCount = 0; // Default value for future months
            //     }
            // }


            $employeeCount = 0; // Default value for future months

            if ($selectedYear != $currentYear || ($selectedYear == $currentYear && $month <= $currentMonth)) {
                $employeeCount = DB::table('employees')
                    ->when(! $isSuperAdmin, function ($query) use ($companyId) {
                        $query->where('company_id', $companyId);
                    })
                    ->where(function ($query) use ($selectedYear, $month) {
                        $query->whereYear('date_joining', '<', $selectedYear)
                            ->orWhere(function ($query) use ($selectedYear, $month) {
                                $query->whereYear('date_joining', '=', $selectedYear)
                                    ->whereMonth('date_joining', '<=', $month);
                            });
                    })
                    ->where(function ($query) use ($selectedYear, $month) {
                        $query->whereNull('date_leaving')
                            ->orWhere(function ($query) use ($selectedYear, $month) {
                                $query->whereYear('date_leaving', '>', $selectedYear)
                                    ->orWhere(function ($query) use ($selectedYear, $month) {
                                        $query->whereYear('date_leaving', '=', $selectedYear)
                                            ->whereMonth('date_leaving', '>=', $month);
                                    });
                            });
                    })
                    ->count();
            }

            $employeeActiveData[] = $employeeActive;
            $employeeNonActiveData[] = $employeeNonActive;
            $monthlyEmployeeData[] = $employeeCount - $employeeNonActive;
            // $monthlyEmployeeData[] = ($employeeCount + $employeeActive) - $employeeNonActive;
            $monthlyEmployeeActive[$month] = $employeeCount - $employeeNonActive;
            $employeeIn[$month] = $employeeActive;
            $employeeOut[$month] = $employeeNonActive;

            // $employeeNonActiveData[] = DB::table('employees')->when(! $isSuperAdmin, function ($query) use ($companyId) {
            //     $query->where('company_id', $companyId);
            // })->where('employee_status', '!=', 'AKTIF')
            //     ->whereYear('date_joining', $currentYear)
            //     ->whereMonth('date_joining', $month)
            //     ->count();
        }
        // Get the current month and year


        // Get the requested month and year from the input, or default to current month and year


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
                'PROMOSI' => 'PROMOSI',
                'DEMOSI' => 'DEMOSI',
                'ROTASI' => 'ROTASI',
                'PENUGASAN' => 'PENUGASAN',
                'RESTRUKTUR ORGANISASI' => 'RESTRUKTUR ORGANISASI',
                'PENSIUN' => 'PENSIUN',
                'RESIGN' => 'RESIGN',
                'NON-AKTIF' => 'NON-AKTIF',
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
                'PROMOSI' => 'PROMOSI',
                'DEMOSI' => 'DEMOSI',
                'ROTASI' => 'ROTASI',
                'PENUGASAN' => 'PENUGASAN',
                'RESTRUKTUR ORGANISASI' => 'RESTRUKTUR ORGANISASI',
                'PENSIUN' => 'PENSIUN',
                'RESIGN' => 'RESIGN',
                'NON-AKTIF' => 'NON-AKTIF',
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
            ->whereMonth('date_joining', now()->month)
            ->whereYear('date_joining', now()->year)

            ->count();

        // Count non-active employees added this month
        $nonActivePermonth = (clone $employees)
            ->where('employee_status', '!=', 'AKTIF')
            ->whereMonth('date_leaving', now()->month)
            ->whereYear('date_leaving', now()->year)

            ->count();

        // Count active employees added this year
        $activePeryear = (clone $employees)
            ->where('employee_status', 'AKTIF')
            ->whereYear('date_joining', now()->year)
            ->count();

        // Count non-active employees added this year
        $nonActivePeryear = (clone $employees)
            ->where('employee_status', '!=', 'AKTIF')
            ->whereYear('date_leaving', now()->year)
            ->count();

        // Count employees retiring this year
        $retirementCount = (clone $employees)
            ->where('employee_status', 'AKTIF')
            ->get() // Retrieve as a collection
            ->filter(function ($employee) {
                $retirementDate = Carbon::parse($employee->dob)->addYears(55);
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
            'monthlyEmployeeActive',
            'employeeIn',
            'employeeOut',
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
            $employeeActive = DB::table('employees')->when(! $isSuperAdmin, function ($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })->where('employee_status', 'AKTIF')
                ->whereYear('date_joining', $year)
                ->whereMonth('date_joining', $month)
                ->count();

            $employeeNonActive = DB::table('employees')->when(! $isSuperAdmin, function ($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })->where('employee_status', '!=', 'AKTIF')
                ->whereYear('date_leaving', $year)
                ->whereMonth('date_leaving', $month)
                ->count();

            if ($year != now()->year) {

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
            } else {

                if ($month <= now()->month) {
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
                } else {
                    $employeeCount = 0; // Default value for future months
                }
            }

            $employeeActiveData[] = $employeeActive;
            $employeeNonActiveData[] = $employeeNonActive;
            // $monthlyEmployeeData[] = ($employeeCount + $employeeActive) - $employeeNonActive;
            $monthlyEmployeeData[] = $employeeCount - $employeeNonActive;
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

    public function employeeCategory()
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

    public function employeeInOut(Request $request)
    {

        // dd($request->status);

        if ($request->status === 'retirement') {
            $employees = Employee::when(! Auth::user()->hasRole('super-admin'), function ($query) {
                $query->where('company_id', Auth::user()->company_id);
            })->where('employee_status', 'AKTIF')
                ->get() // Retrieve as a collection
                ->filter(function ($employee) {
                    $retirementDate = Carbon::parse($employee->dob)->addYears(55);
                    return $retirementDate->year === now()->year;
                });
        } else {
            $employees = Employee::when(! Auth::user()->hasRole('super-admin'), function ($query) {
                $query->where('company_id', Auth::user()->company_id);
            })
                ->when($request->status, function ($q) use ($request) {
                    if ($request->status === 'employeeIn') {
                        $q->where('employee_status', 'AKTIF')
                            ->whereYear('date_joining', now()->year)
                            ->when($request->isMonth, function ($q) {
                                $q->whereMonth('date_joining', now()->month);
                            });
                    } else {
                        $q->where('employee_status', '!=', 'AKTIF')
                            ->whereYear('date_leaving', now()->year)
                            ->when($request->isMonth, function ($q) {
                                $q->whereMonth('date_leaving', now()->month);
                            });
                    }
                })
                ->get();
        }

        return view('pages.dashboard.employee.employees', compact('employees'));
    }

    public function approvalLog(Request $request)
    {

        // dd($request->all());
        // Get the current month and year if not provided
        // $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        // $selectedMonth = $request->input('month', $currentMonth);
        $selectedYear = $request->input('year', $currentYear);

        // Determine the query conditions
        $approvalQuery = Approval::query();

        $type = $request->type;

        if (! in_array($request->type, ['KARYAWAN BARU', 'BUKA VERIFIKASI'])) {
            $approvalQuery->join('employee_careers', 'approvals.employee_career_id', '=', 'employee_careers.id')
                ->where('employee_careers.type', $type)
                // ->whereMonth('employee_careers.start_date', $selectedMonth)
                ->whereYear('employee_careers.start_date', $selectedYear);
        } else {
            // Check if selected_candidate_id is not null
            if ($request->type === 'KARYAWAN BARU') {
                $approvalQuery->whereNotNull('selected_candidate_id')
                    ->where('is_approve', 1)
                    // ->whereMonth('created_at', $selectedMonth)
                    ->whereYear('created_at', $selectedYear);
            } elseif ($request->type === 'BUKA VERIFIKASI') {
                // If no selected_candidate_id, check for employee_id
                $approvalQuery->whereNotNull('employee_id')
                    ->where('is_approve', 1)
                    // ->whereMonth('created_at', $selectedMonth)
                    ->whereYear('created_at', $selectedYear);
            }
        }

        // Apply company restriction for non-super-admin users
        if (! Auth::user()->hasRole('super-admin')) {
            $approvalQuery->where('company_id', Auth::user()->company_id);
        }

        // Execute the query
        $approvals = $approvalQuery->get();

        // Return the view with data
        return view('pages.dashboard.approval.log-approval', compact('approvals', 'type'));
    }

    public function employeeDataPerMonth(Request $request)
    {
        $companyId = Auth::user()->company_id;
        $isSuperAdmin = Auth::user()->hasRole('super-admin');
        // Get the current month and year if not provided
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $selectedMonth = $request->input('month', $currentMonth);
        $selectedYear = $request->input('year', $currentYear);

        // Fetch employee data per month for the current year
        for ($month = 1; $month <= 12; $month++) {
            // $employeeActive = DB::table('employees')->when(! $isSuperAdmin, function ($query) use ($companyId) {
            //     $query->where('employees.company_id', $companyId);
            // })->where('employees.employee_status', 'AKTIF')->join('positions', 'employees.position_id', '=', 'positions.id')
            //     ->whereYear('employees.date_joining', $selectedYear)
            //     ->whereMonth('employees.date_joining', $month)
            //     ->get();

            // $employeeNonActive = DB::table('employees')->when(! $isSuperAdmin, function ($query) use ($companyId) {
            //     $query->where('employees.company_id', $companyId);
            // })->where('employees.employee_status', '!=', 'AKTIF')->join('positions', 'employees.position_id', '=', 'positions.id')
            //     ->whereYear('employees.date_leaving', $selectedYear)
            //     ->whereMonth('employees.date_leaving', $month)
            //     ->get();

            $employees = collect();

            if ($selectedYear != $currentYear || ($selectedYear == $currentYear && $selectedMonth <= $currentMonth)) {
                $employees = Employee::with('employeePhotos')
                    ->when(! $isSuperAdmin, function ($query) use ($companyId) {
                        $query->where('company_id', $companyId);
                    })
                    ->where(function ($query) use ($selectedYear, $selectedMonth) {
                        $query->whereYear('date_joining', '<', $selectedYear)
                            ->orWhere(function ($query) use ($selectedYear, $selectedMonth) {
                                $query->whereYear('date_joining', '=', $selectedYear)
                                    ->whereMonth('date_joining', '<=', $selectedMonth);
                            });
                    })
                    ->where(function ($query) use ($selectedYear, $selectedMonth) {
                        $query->whereNull('date_leaving')
                            ->orWhere(function ($query) use ($selectedYear, $selectedMonth) {
                                $query->whereYear('date_leaving', '>', $selectedYear)
                                    ->orWhere(function ($query) use ($selectedYear, $selectedMonth) {
                                        $query->whereYear('date_leaving', '=', $selectedYear)
                                            ->whereMonth('date_leaving', '>=', $selectedMonth);
                                    });
                            });
                    })
                    ->get();
            }

            if ($request->has('export')) {
                return Excel::download(new EmployeePerMonthExport($employees, $selectedMonth, $selectedYear), 'employee-per-month.xlsx');
            }


            // if (request()->ajax()) {
            //     return DataTables::of($employees)
            //         ->addIndexColumn()
            //         ->editColumn('photo', function ($item) {
            //             $mainPhoto = $item->employeePhotos->where('main_photo', true)->first();

            //             if ($mainPhoto) {
            //                 return '
            //     <div class="fixed-frame">
            //         <img src="'.asset('storage/'.$mainPhoto->file_path).'" data-fancybox alt="Icon User"
            //         class="framed-image" style="cursor: pointer">
            //     </div>';
            //             } else {
            //                 return 'No Image';
            //             }
            //         })->editColumn('employeeCategory', function ($item) {
            //             $categoryName = $item->employeeCategory->name ?? '-';
            //             $levelId = $item->position->level->id ?? '-';

            //             $badgeColors = [
            //                 1 => 'bg-light-primary',
            //                 2 => 'bg-light-success',
            //                 3 => 'bg-light-warning',
            //                 4 => 'bg-light-danger',
            //                 5 => 'bg-light-info',
            //             ];

            //             $badgeClass = $badgeColors[$levelId] ?? 'badge-secondary';

            //             if (in_array($levelId, [1, 2, 3, 4, 5])) {
            //                 return '<span>'.$categoryName.'</span><br>
            //     <span class="badge '.$badgeClass.'">'.$item->position->level->name.'</span>';
            //             }

            //             return '<span>'.$categoryName.'</span>';

            //         })->editColumn('position', function ($item) {
            //             return $item->position->name ?? '-';
            //         })->editColumn('division', function ($item) {
            //             return $item->position->division->name ?? '-';
            //         })->editColumn('is_verified', function ($item) {
            //             // Initialize variables
            //             $verified = '-';
            //             // Determine verification badge
            //             if ($item->is_verified == 0) {
            //                 $verified = '<span class="badge bg-danger">Unverified</span> <br>';
            //             } elseif ($item->is_verified == 1) {
            //                 $verified = '<span class="badge bg-success">Verified</span> <br>';
            //             }

            //             // Return the concatenated result
            //             return $verified;
            //         })
            //         ->rawColumns(['action', 'photo', 'is_verified', 'employeeCategory', 'employee_nik'])
            //         ->toJson();
            // }

        }

        return view('pages.dashboard.employee.employee-per-month',
            compact(
                'employees',
                'selectedMonth',
                'selectedYear',
            ));

    }

    public function getEmployeesByLevelAndDivision(Request $request)
    {
        $levelName = $request->query('level_name');
        $divisionId = $request->query('division_id');

        $employees = Employee::where('employee_status', 'AKTIF')->whereHas('position.level', function ($query) use ($levelName) {
            $query->where('name', $levelName);
        })
            ->whereHas('position.division', function ($query) use ($divisionId) {
                $query->where('id', $divisionId);
            })
            ->with('position', 'position.level', 'position.division', 'employeeCategory')
            ->get();

        return response()->json($employees);
    }
}
