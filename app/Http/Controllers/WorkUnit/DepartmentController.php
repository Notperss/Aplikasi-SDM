<?php

namespace App\Http\Controllers\WorkUnit;

use Illuminate\Http\Request;
use App\Models\WorkUnit\Division;
use App\Models\WorkUnit\Department;
use App\Http\Controllers\Controller;
use App\Models\WorkUnit\Directorate;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companyId = Auth::user()->company_id;
        $departments = Department::where('company_id', $companyId)->latest()->get();
        $divisions = Division::where('company_id', $companyId)->orderBy('name', 'asc')->get();
        $directorates = Directorate::where('company_id', $companyId)->orderBy('name', 'asc')->get();

        return view('pages.work-unit.department.index', compact('divisions', 'directorates', 'departments'));
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
        Department::create($requestData);

        return redirect()->back()->with('success', 'Data has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
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
        $department->update($requestData);

        return redirect()->back()->with('success', 'Data has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->back()->with('success', 'Data has been deleted successfully!');
    }

    public function getDivisions(Request $request)
    {
        $directorateId = $request->input('directorate_id');
        $divisions = Division::where('directorate_id', $directorateId)->get();
        return response()->json($divisions);
    }
}
