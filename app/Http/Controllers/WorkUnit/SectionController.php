<?php

namespace App\Http\Controllers\WorkUnit;

use Illuminate\Http\Request;
use App\Models\WorkUnit\Section;
use App\Models\WorkUnit\Division;
use App\Models\WorkUnit\Department;
use App\Http\Controllers\Controller;
use App\Models\WorkUnit\Directorate;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companyId = Auth::user()->company_id;
        $sections = Section::where('sections.company_id', $companyId)
            ->join('departments', 'sections.department_id', '=', 'departments.id') // Join the levels table
            ->join('divisions', 'departments.division_id', '=', 'divisions.id') // Join the divisions table
            ->join('directorates', 'divisions.directorate_id', '=', 'directorates.id') // Join the directorates table via divisions
            ->orderBy('directorates.name', 'asc') // Order by the directorates.name
            ->orderBy('divisions.name', 'asc') // Then order by the divisions.name
            ->orderBy('departments.name', 'asc') // Order by the departments.name
            ->with(['department', 'department.division', 'department.division.directorate']) // Eager load the relationships
            ->select('sections.*') // Select positions columns only
            ->get();


        $departments = Department::where('company_id', $companyId)->orderBy('name', 'asc')->get();
        $divisions = Division::where('company_id', $companyId)->orderBy('name', 'asc')->get();
        $directorates = Directorate::where('company_id', $companyId)->orderBy('name', 'asc')->get();

        return view('pages.work-unit.section.index', compact('divisions', 'directorates', 'sections', 'departments'));
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
        ], [
            // Custom error messages
            'name.required' => 'Nama wajib diisi.',
            'directorate_id.required' => 'Direktorat wajib diisi.',
            'division_id.required' => 'Divisi wajib diisi.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
        ]);
        $company_id = Auth::user()->company_id;
        $requestData = array_merge($request->all(), ['company_id' => $company_id]);
        Section::create($requestData);

        return redirect()->back()->with('success', 'Data has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Section $section)
    {
        // Validation rules
        $request->validate([
            'name' => 'required|string|max:255',
            'directorate_id' => 'required',
            'division_id' => 'required',
        ], [
            // Custom error messages
            'name.required' => 'Nama wajib diisi.',
            'directorate_id.required' => 'Direktorat wajib diisi.',
            'division_id.required' => 'Divisi wajib diisi.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
        ]);
        $company_id = Auth::user()->company_id;
        $requestData = array_merge($request->all(), ['company_id' => $company_id]);
        $section->update($requestData);

        return redirect()->back()->with('success', 'Data has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {
        $section->delete();
        return redirect()->back()->with('success', 'Data has been deleted successfully!');
    }

    public function getDepartments(Request $request)
    {
        $divisionId = $request->input('division_id');
        $departments = Department::where('division_id', $divisionId)->get();
        return response()->json($departments);
    }
}
