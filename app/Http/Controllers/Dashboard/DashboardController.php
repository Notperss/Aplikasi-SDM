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
use Illuminate\Support\Facades\Auth;
use App\Models\ManagementAccess\Company;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companyId = Auth::user()->company_id;
        $isSuperAdmin = Auth::user()->hasRole('super-admin');

        // $employees = Employee::all();


        // $nextMonthStart = Carbon::now()->startOfMonth()->addMonth(); // Start of next month
        $nextMonthEnd = Carbon::now()->endOfMonth()->addMonth(); // End of next month
        $today = Carbon::now();

        $contracts = Contract::when(! $isSuperAdmin, function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->orderBy('end_date', 'desc');

        $contractsIncoming = $contracts->whereBetween('end_date', [$today, $nextMonthEnd])
            ->get();

        $contractsExpired = Contract::with('employee')->when(! $isSuperAdmin, function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })
            // ->where('end_date', '<', $today) // Only contracts with an end date before today
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
                $query->where('company_id', $companyId);
            })->where('employee_status', 'AKTIF')
                ->whereYear('date_joining', $currentYear)
                ->whereMonth('date_joining', $month)
                ->count();
            $employeeNonActiveData[] = DB::table('employees')->when(! $isSuperAdmin, function ($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })->where('employee_status', '!=', 'AKTIF')
                ->whereYear('date_joining', $currentYear)
                ->whereMonth('date_joining', $month)
                ->count();
        }

        return view('pages.dashboard.index', compact(
            // 'employees',
            'divisions',
            'companies',
            'employeeActiveData',
            'employeeNonActiveData',
            'contractsIncoming',
            'contractsExpired',
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

        $positions = Position::wherehas('employee')->where('division_id', $id)->get();

        return view('pages.dashboard.employeesDivision', compact('positions', 'divisionId'));
    }
}
