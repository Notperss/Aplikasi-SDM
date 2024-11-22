<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee\EmployeeCategory;

class EmployeeCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employeeCategories = EmployeeCategory::when(! Auth::user()->hasRole('super-admin'), function ($query) {
            $query->where('company_id', Auth::user()->company_id);
        })->latest()->get();

        // if (! Auth::user()->hasRole('super-admin')) {
        //     $employeeCategories->where('company_id', Auth::user()->company_id);
        // }

        return view('pages.employee.employee-category.index', compact('employeeCategories', ));
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
            'name.required' => 'Tunjangan wajib diisi.',
            'name.max' => 'Tunjangan tidak boleh lebih dari 255 karakter.',
        ]);
        $company_id = Auth::user()->company_id;
        $requestData = array_merge($request->all(), ['company_id' => $company_id]);
        employeeCategory::create($requestData);

        return redirect()->back()->with('success', 'Data has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeCategory $employeeCategory)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeCategory $employeeCategory)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployeeCategory $employeeCategory)
    {
        // Validation rules
        $request->validate([
            'name' => 'required|string|max:255',
        ], [
            // Custom error messages
            'name.required' => 'Tunjangan wajib diisi.',
            'name.max' => 'Tunjangan tidak boleh lebih dari 255 karakter.',
        ]);
        $employeeCategory->update($request->all());
        return redirect()->back()->with('success', 'Data has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeCategory $employeeCategory)
    {
        $employeeCategory->delete();
        return redirect()->back()->with('success', 'Data has been deleted successfully!');
    }
}
