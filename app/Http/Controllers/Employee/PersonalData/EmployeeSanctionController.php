<?php

namespace App\Http\Controllers\Employee\PersonalData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Employee\PersonalData\EmployeeSanction;

class EmployeeSanctionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'sanction_name' => 'nullable|string|max:255',
            'sanction_category' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
        ], [
            'employee_id.required' => 'Karyawan harus dipilih.',
            'employee_id.exists' => 'Karyawan yang dipilih tidak valid.',
            'sanction_name.string' => 'Penempatan harus berupa teks.',
            'sanction_name.max' => 'Penempatan tidak boleh lebih dari 255 karakter.',
            'sanction_category.string' => 'Penempatan harus berupa teks.',
            'sanction_category.max' => 'Penempatan tidak boleh lebih dari 255 karakter.',
            'start_date.required' => 'Tanggal mulai harus diisi.',
            'start_date.date' => 'Tanggal mulai harus berupa format tanggal yang valid.',
            'end_date.date' => 'Tanggal selesai harus berupa format tanggal yang valid.',
            'description.string' => 'Deskripsi harus berupa teks.',
        ]);

        $data = $request->all();

        if ($request->hasFile('file_sanction')) {
            $file = $request->file('file_sanction'); // Get the file from the request
            $extension = $file->getClientOriginalExtension(); // Get the file extension
            $file_name = 'file_sanction_'.$request['name'].'_'.time().'.'.$extension; // Construct the file name
            $data['file_sanction'] = $file->storeAs('files/employee/file_sanction', $file_name, 'public_local'); // Store the file
        }

        // $employee = Employee::findOrFail($request->employee_id);

        // $employee->update([
        //     'position_id' => $request->position_id,
        // ]);

        EmployeeSanction::create($data);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Data has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeSanction $employeeSanction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeSanction $employeeSanction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployeeSanction $employeeSanction)
    {
        $request->validate([
            // 'employee_id' => 'required|exists:employees,id',
            'sanction_name' => 'nullable|string|max:255',
            'sanction_category' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
        ], [
            'employee_id.required' => 'Karyawan harus dipilih.',
            'employee_id.exists' => 'Karyawan yang dipilih tidak valid.',
            'sanction_name.string' => 'Penempatan harus berupa teks.',
            'sanction_name.max' => 'Penempatan tidak boleh lebih dari 255 karakter.',
            'sanction_category.string' => 'Penempatan harus berupa teks.',
            'sanction_category.max' => 'Penempatan tidak boleh lebih dari 255 karakter.',
            'start_date.required' => 'Tanggal mulai harus diisi.',
            'start_date.date' => 'Tanggal mulai harus berupa format tanggal yang valid.',
            'end_date.date' => 'Tanggal selesai harus berupa format tanggal yang valid.',
            'description.string' => 'Deskripsi harus berupa teks.',
        ]);

        $data = $request->all();

        $path_file = $employeeSanction->file_sanction;

        if ($request->hasFile('file_sanction')) {
            $file = $request->file('file_sanction'); // Get the file from the request
            $extension = $file->getClientOriginalExtension(); // Get the file extension
            $file_name = 'file_sanction_'.$request['name'].'_'.time().'.'.$extension; // Construct the file name
            $data['file_sanction'] = $file->storeAs('files/employee/file_sanction', $file_name, 'public_local'); // Store the file
            // delete sertifikat
            if ($path_file != null || $path_file != '') {
                Storage::disk('public_local')->delete($path_file);
            }
        } else {
            $data['file_sanction'] = $path_file;
        }

        $employeeSanction->update($data);

        return redirect()->back()->with('success', 'Data has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeSanction $employeeSanction)
    {
        $path_file = $employeeSanction->file_sanction;

        if ($path_file != null || $path_file != '') {
            Storage::disk('public_local')->delete($path_file);
        }
        $employeeSanction->delete();
        return redirect()->back()->with('success', 'Data has been deleted successfully!');
    }
}
