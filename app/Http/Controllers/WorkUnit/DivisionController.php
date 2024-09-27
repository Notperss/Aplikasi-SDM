<?php

namespace App\Http\Controllers\WorkUnit;

use App\Http\Controllers\Controller;
use App\Models\WorkUnit\Directorate;
use App\Models\WorkUnit\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companyId = Auth::user()->company_id;
        $divisions = Division::where('company_id', $companyId)->latest()->get();
        $directorates = Directorate::where('company_id', $companyId)->orderBy('name', 'asc')->get();

        return view('pages.work-unit.division.index', compact('divisions', 'directorates'));
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
        ], [
            // Custom error messages
            'name.required' => 'Nama wajib diisi.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
        ]);
        $company_id = Auth::user()->company_id;
        $requestData = array_merge($request->all(), ['company_id' => $company_id]);
        Division::create($requestData);

        return redirect()->back()->with('success', 'Data has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Division $division)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Division $division)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Division $division)
    {
        // Validation rules
        $request->validate([
            'name' => 'required|string|max:255',
        ], [
            // Custom error messages
            'name.required' => 'Nama wajib diisi.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
        ]);
        $division->update($request->all());
        return redirect()->back()->with('success', 'Data has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Division $division)
    {
        $division->delete();
        return redirect()->back()->with('success', 'Data has been deleted successfully!');
    }
}
