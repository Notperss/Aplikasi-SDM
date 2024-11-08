<?php

namespace App\Http\Controllers\Employee\PersonalData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Employee\PersonalData\EmployeeSocialPlatform;

class EmployeeSocialPlatformController extends Controller
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
    public function store(Request $request)
    {
        $request->validate([
            'platform' => 'required|string|max:255',
            'account_name' => 'required|max:255',
        ], [
            'platform.required' => 'Platform wajib diisi.',
            'platform.string' => 'Platform harus berupa teks.',
            'platform.max' => 'Platform tidak boleh lebih dari 255 karakter.',
            'account_name.required' => 'Nama akun wajib diisi.',
            'account_name.string' => 'Nama akun harus berupa teks.',
            'account_name.max' => 'Nama akun tidak boleh lebih dari 255 karakter.',
        ]);

        EmployeeSocialPlatform::create($request->all());
        return redirect()->back()->with('success', 'Data has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeSocialPlatform $employeeSocialPlatform)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeSocialPlatform $employeeSocialPlatform)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployeeSocialPlatform $employeeSocialPlatform)
    {
        $request->validate([
            'platform' => 'required|string|max:255',
            'account_name' => 'required|max:255',
        ], [
            'platform.required' => 'Platform wajib diisi.',
            'platform.string' => 'Platform harus berupa teks.',
            'platform.max' => 'Platform tidak boleh lebih dari 255 karakter.',
            'account_name.required' => 'Nama akun wajib diisi.',
            'account_name.string' => 'Nama akun harus berupa teks.',
            'account_name.max' => 'Nama akun tidak boleh lebih dari 255 karakter.',
        ]);
        $employeeSocialPlatform->update($request->all());
        return redirect()->back()->with('success', 'Data has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeSocialPlatform $employeeSocialPlatform)
    {
        $employeeSocialPlatform->delete();
        return redirect()->back()->with('success', 'Data has been deleted successfully!');
    }
}
