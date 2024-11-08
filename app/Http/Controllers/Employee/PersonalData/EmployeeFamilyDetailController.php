<?php

namespace App\Http\Controllers\Employee\PersonalData;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Employee\PersonalData\EmployeeFamilyDetail;
use App\Http\Requests\Employee\PersonalData\StoreFamilyDetailRequest;
use App\Http\Requests\Employee\PersonalData\UpdateFamilyDetailRequest;

class EmployeeFamilyDetailController extends Controller
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
    public function store(StoreFamilyDetailRequest $request)
    {
        EmployeeFamilyDetail::create($request->all());
        return redirect()->back()->with('success', 'Data has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeFamilyDetail $employeeFamilyDetail)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeFamilyDetail $employeeFamilyDetail)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFamilyDetailRequest $request, EmployeeFamilyDetail $employeeFamilyDetail)
    {
        // Get the validated data from the request
        $validatedData = $request->validated();
        $validatedData['is_in_kk'] = $request->input('is_in_kk_edit');

        if ($validatedData['is_in_kk'] == 0) {
            $validatedData['is_bpjs'] = 0;
        } else {
            $validatedData['is_bpjs'] = $request->input('is_bpjs', 0);
        }

        $employeeFamilyDetail->update($validatedData);
        return redirect()->back()->with('success', 'Data has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeFamilyDetail $employeeFamilyDetail)
    {
        $employeeFamilyDetail->delete();
        return redirect()->back()->with('success', 'Data has been deleted successfully!');
    }
}
