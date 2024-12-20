<?php

namespace App\Http\Controllers\Position;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Position\Level;
use App\Models\WorkUnit\Section;
use App\Models\Position\Position;
use App\Models\WorkUnit\Division;
use App\Models\Position\Allowance;
use App\Models\WorkUnit\Department;
use App\Http\Controllers\Controller;
use App\Models\WorkUnit\Directorate;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companyId = Auth::user()->company_id;
        $isSuperAdmin = Auth::user()->hasRole('super-admin');

        $positions = Position::when(! $isSuperAdmin, function ($query) use ($companyId) {
            $query->where('positions.company_id', $companyId);
        })
            ->join('levels', 'positions.level_id', '=', 'levels.id') // Join the levels table
            ->join('divisions', 'positions.division_id', '=', 'divisions.id') // Join the divisions table
            ->join('directorates', 'divisions.directorate_id', '=', 'directorates.id') // Join the directorates table via divisions
            ->orderBy('levels.name', 'asc') // Order by the levels.name
            ->orderBy('divisions.name', 'asc') // Then order by the divisions.name
            ->orderBy('directorates.name', 'asc') // Order by the directorates.name
            ->with(['level', 'division', 'division.directorate']) // Eager load the relationships
            ->select('positions.*'); // Select positions columns only;


        $levels = Level::when(! $isSuperAdmin, function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->latest()->get();

        $directorates = Directorate::when(! $isSuperAdmin, function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->latest()->get();

        $divisions = Division::when(! $isSuperAdmin, function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->latest()->get();

        $departments = Department::when(! $isSuperAdmin, function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->latest()->get();

        $sections = Section::when(! $isSuperAdmin, function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->latest()->get();

        $allowances = Allowance::when(! $isSuperAdmin, function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->latest()->get();

        //  <a href="' . route('addAllowances', $position) . '"
        //         class="btn btn-sm btn-icon btn-light-primary" title="tunjangan">
        //         <i class="bi bi-wallet-fill"></i>
        //     </a>

        if (request()->ajax()) {
            return DataTables::of($positions)
                ->addIndexColumn()
                ->addColumn('action', function ($position) {
                    return '
        <div class="d-flex justify-content-end mt-2">
           

            <a href="' . route('position.edit', $position) . '"
                class="btn btn-sm btn-icon btn-secondary text-white mx-2" title="edit">
                <i class="bi bi-pencil-square"></i>
            </a>

            <button class="btn btn-sm btn-light-danger mr-2" onclick="showSweetAlert(\'' . $position->id . '\')"
                title="hapus">
                <i class="bi bi-trash"></i>
            </button>

            <form id="deleteForm_' . $position->id . '" action="' . route('position.destroy', $position->id) . '"
                method="POST" style="display: none;">
                ' . method_field('DELETE') . csrf_field() . '
            </form>
                </div>
            ';
                })

                ->editColumn('department', function ($position) {
                    return $position->department->name ?? '-';
                })
                ->editColumn('section', function ($position) {
                    return $position->section->name ?? '-';
                })

                ->rawColumns(['action',])
                ->toJson();
        }


        // $isSuperAdmin = Auth::user()->hasRole('super-admin');

        // $positions = Position::when(! $isSuperAdmin, function ($query) {
        //     return $query->where('positions.company_id', Auth::user()->company_id);
        // })
        //     ->join('levels', 'positions.level_id', '=', 'levels.id') // Join the levels table
        //     ->join('divisions', 'positions.division_id', '=', 'divisions.id') // Join the divisions table
        //     ->join('directorates', 'divisions.directorate_id', '=', 'directorates.id') // Join the directorates table via divisions
        //     ->orderBy('levels.name', 'asc') // Order by the levels.name
        //     ->orderBy('divisions.name', 'asc') // Then order by the divisions.name
        //     ->orderBy('directorates.name', 'asc') // Order by the directorates.name
        //     ->with(['level', 'division', 'division.directorate']) // Eager load the relationships
        //     ->select('positions.*') // Select positions columns only
        //     ->get();

        // $levels = Level::when(! $isSuperAdmin, function ($query) {
        //     return $query->where('company_id', Auth::user()->company_id);
        // })
        //     ->latest()
        //     ->get();

        // $directorates = Directorate::when(! $isSuperAdmin, function ($query) {
        //     return $query->where('company_id', Auth::user()->company_id);
        // })
        //     ->latest()
        //     ->get();

        // $divisions = Division::when(! $isSuperAdmin, function ($query) {
        //     return $query->where('company_id', Auth::user()->company_id);
        // })
        //     ->latest()
        //     ->get();

        // $departments = Department::when(! $isSuperAdmin, function ($query) {
        //     return $query->where('company_id', Auth::user()->company_id);
        // })
        //     ->latest()
        //     ->get();

        // $sections = Section::when(! $isSuperAdmin, function ($query) {
        //     return $query->where('company_id', Auth::user()->company_id);
        // })
        //     ->latest()
        //     ->get();

        // $allowances = Allowance::when(! $isSuperAdmin, function ($query) {
        //     return $query->where('company_id', Auth::user()->company_id);
        // })
        //     ->latest()
        //     ->get();


        return view('pages.position.position.index',
            compact(
                'positions',
                'levels',
                'directorates',
                'divisions',
                'departments',
                'sections',
                'allowances'
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
        // Validation rules
        $request->validate([
            'name' => 'required|string|max:255',
            'directorate_id' => 'required',
            'division_id' => 'required',
            'level_id' => 'required',
        ], [
            // Custom error messages
            'name.required' => 'Jabatan wajib diisi.',
            'directorate_id.required' => 'Direktorat wajib diisi.',
            'level_id.required' => 'Level wajib diisi.',
            'name.max' => 'Jabatan tidak boleh lebih dari 255 karakter.',
        ]);
        $company_id = Auth::user()->company_id;
        $requestData = array_merge($request->all(), ['company_id' => $company_id]);
        Position::create($requestData);

        return redirect()->back()->with('success', 'Data has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Position $position)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Position $position)
    {

        $companyId = Auth::user()->company_id;
        $isSuperAdmin = Auth::user()->hasRole('super-admin');

        $levels = Level::when(! $isSuperAdmin, function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->latest()->get();
        $directorates = Directorate::when(! $isSuperAdmin, function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->latest()->get();
        $divisions = Division::when(! $isSuperAdmin, function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->latest()->get();
        $departments = Department::when(! $isSuperAdmin, function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->latest()->get();
        $sections = Section::when(! $isSuperAdmin, function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->latest()->get();

        return view('pages.position.position.edit', compact(
            'position',
            'levels',
            'directorates',
            'divisions',
            'departments',
            'sections',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Position $position)
    {
        // Validation rules
        $request->validate([
            'name' => 'required|string|max:255',
            'directorate_id' => 'required',
            'division_id' => 'required',
            'level_id' => 'required',
        ], [
            // Custom error messages
            'name.required' => 'Jabatan wajib diisi.',
            'directorate_id.required' => 'Direktorat wajib diisi.',
            'level_id.required' => 'Level wajib diisi.',
            'name.max' => 'Jabatan tidak boleh lebih dari 255 karakter.',
        ]);

        if ($request->level_id != $position->level_id) {
            // Detach all allowances associated with the position
            $position->allowances()->detach();
        }

        // Update the position with the validated data
        $position->update($request->all());
        return redirect()->route('position.index')->with('success', 'Data has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Position $position)
    {
        $position->delete();
        return redirect()->back()->with('success', 'Data has been deleted successfully!');
    }

    public function getSections(Request $request)
    {
        $departmentId = $request->input('department_id');
        $sections = Section::where('department_id', $departmentId)->get();
        return response()->json($sections);
    }
    public function addAllowances(Position $position)
    {
        $allowances = Allowance::where('company_id', Auth::user()->company_id)->latest()->get();
        return view('pages.position.position.add-allowances', compact('position', 'allowances'));
    }

    public function positionAllowance(Request $request, Position $position)
    {
        // Validate the incoming request, allowing allowance_id to be optional
        $validated = $request->validate([
            'allowance_id' => 'nullable|array', // Allow null if no allowances are selected
            'allowance_id.*' => 'exists:allowances,id', // Ensures each allowance_id exists in the allowances table
        ]);

        // Sync the position's allowances (if allowance_id is null, sync with an empty array)
        $position->allowances()->sync($validated['allowance_id'] ?? []);

        return redirect()->back()->with('success', 'Position allowances updated successfully.');
    }
}
