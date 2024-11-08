<?php

namespace App\Http\Controllers\Employee\PersonalData;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Employee\PersonalData\EmployeeLanguageProficiency;
use App\Http\Requests\Employee\PersonalData\StoreLanguageProficiencyRequest;
use App\Http\Requests\Employee\PersonalData\UpdateLanguageProficiencyRequest;

class EmployeeLanguageProficiencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort(404);
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
    public function store(StoreLanguageProficiencyRequest $request)
    {
        EmployeeLanguageProficiency::create($request->all());
        return redirect()->back()->with('success', 'Data has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeLanguageProficiency $employeeLanguageProficiency)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeLanguageProficiency $employeeLanguageProficiency)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLanguageProficiencyRequest $request, EmployeeLanguageProficiency $employeeLanguageProficiency)
    {
        $employeeLanguageProficiency->update($request->all());
        return redirect()->back()->with('success', 'Data has been updated successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeLanguageProficiency $employeeLanguageProficiency)
    {
        $employeeLanguageProficiency->delete();
        return redirect()->back()->with('success', 'Data has been deleted successfully!');
    }
}
