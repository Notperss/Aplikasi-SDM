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

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $companyId = Auth::user()->company_id;
        $isSuperAdmin = Auth::user()->hasRole('super-admin');

        // $employees = Employee::all();
        $directorates = Directorate::when(! $isSuperAdmin, function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->get();

        // $nextMonthStart = Carbon::now()->startOfMonth()->addMonth(); // Start of next month
        $nextMonthEnd = Carbon::now()->endOfMonth()->addMonths(2); // End of next month
        $today = Carbon::now();


        $contracts = Contract::when(! $isSuperAdmin, function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->orderBy('end_date', 'desc');

        $employees = Employee::when(! $isSuperAdmin, function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->orderBy('end_date', 'desc');

        $contractsIncoming = $contracts->whereBetween('end_date', [$today, $nextMonthEnd])
            ->get();

        $contractsExpired = Contract::with('employee')->when(! $isSuperAdmin, function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })
            ->where('end_date', '<', $today) // Only contracts with an end date before today
            ->whereYear('end_date', Carbon::now()->year)
            ->whereMonth('end_date', Carbon::now()->month)
            ->whereHas('employee', function ($query) {
                $query->whereNull('date_leaving'); // Only active employees
            })
            ->orderBy('employee_id', 'asc')
            ->orderBy('end_date', 'asc')
            ->get();

        $divisions = Division::when(! $isSuperAdmin, function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->get();

        $companies = Company::with('directorates')->when(! $isSuperAdmin, function ($query) use ($companyId) {
            $query->where('id', $companyId);
        })->orderBy('name', 'asc')->get();

        $currentYear = date('Y');
        $employeeActiveData = [];
        $employeeNonActiveData = [];

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
                ->whereYear('employees.date_joining', $currentYear)
                ->whereMonth('employees.date_joining', $month)
                ->count();


            // $employeeNonActiveData[] = DB::table('employees')->when(! $isSuperAdmin, function ($query) use ($companyId) {
            //     $query->where('company_id', $companyId);
            // })->where('employee_status', '!=', 'AKTIF')
            //     ->whereYear('date_joining', $currentYear)
            //     ->whereMonth('date_joining', $month)
            //     ->count();
        }
        // Get the current month and year
        $currentMonth = Carbon::now()->month; // Default to current month
        $currentYear = Carbon::now()->year;  // Default to current year

        // Get the requested month and year from the input, or default to current month and year
        $selectedMonth = $request->input('month', $currentMonth);
        $selectedYear = $request->input('year', $currentYear);

        // Define the companyId, assuming it's stored in the authenticated user's session
        $companyId = auth()->user()->company_id; // Adjust if needed

        // Base query for employee career approvals
        $query = DB::table('approvals')
            ->join('employee_careers', 'approvals.employee_career_id', '=', 'employee_careers.id')
            ->where('approvals.is_approve', 1);

        // Prepare the data array
        $dataPerMonth = [
            'karyawan_baru' => $query->clone()
                ->whereNotNull('selected_candidate_id')
                ->whereMonth('employee_careers.start_date', $selectedMonth)
                ->whereYear('employee_careers.start_date', $selectedYear)
                ->when(! auth()->user()->hasRole('super-admin'), function ($q) use ($companyId) {
                    return $q->where('approvals.company_id', $companyId);
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
            'karyawan_baru' => $query->clone()
                ->whereNotNull('selected_candidate_id')
                ->whereYear('employee_careers.start_date', $selectedYear)
                ->when(! auth()->user()->hasRole('super-admin'), function ($q) use ($companyId) {
                    return $q->where('approvals.company_id', $companyId);
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
        return view('pages.dashboard.index', compact(
            'dataPerMonth',
            'dataPerYear',
            'employees',
            'directorates',
            'divisions',
            'companies',
            'employeeActiveData',
            'employeeNonActiveData',
            'contractsIncoming',
            'contractsExpired',
            'selectedMonth', 'selectedYear',
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
}
