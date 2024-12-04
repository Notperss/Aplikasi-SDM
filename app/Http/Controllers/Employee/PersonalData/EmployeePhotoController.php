<?php

namespace App\Http\Controllers\Employee\PersonalData;

use App\Http\Controllers\Controller;
use App\Models\Employee\Employee;
use App\Models\Employee\PersonalData\EmployeePhoto;
use Illuminate\Http\Request;

class EmployeePhotoController extends Controller
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
            'position_id' => 'nullable|exists:positions,id',
            'company_id' => 'nullable|exists:companies,id',
            'main_photo' => 'nullable|boolean', // Ensure it's a boolean value
            'file_path' => 'required|file|max:5120', // Allow any file type with max size 5MB
        ], [
            'employee_id.required' => 'Karyawan harus dipilih.',
            'employee_id.exists' => 'Karyawan yang dipilih tidak valid.',
            'position_id.exists' => 'Posisi yang dipilih tidak valid.',
            'company_id.required' => 'Perusahaan harus dipilih.',
            'company_id.exists' => 'Perusahaan yang dipilih tidak valid.',
            'main_photo.boolean' => 'Foto utama harus berupa nilai boolean.',
            'file_path.file' => 'File harus berupa file yang valid.',
            'file_path.max' => 'Ukuran file tidak boleh lebih dari 5MB.',
        ]);

        $data = $request->all();

        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path'); // Get the file from the request
            $extension = $file->getClientOriginalExtension(); // Get the file extension
            $file_name = 'photo_' . $request['name'] . '_' . time() . '.' . $extension; // Construct the file name
            $data['file_path'] = $file->storeAs('files/employee', $file_name, 'public_local'); // Store the file
        }

        if (! empty($data['main_photo']) && $data['main_photo']) {
            EmployeePhoto::where('employee_id', $data['employee_id'])->update(['main_photo' => 0]);
        }

        EmployeePhoto::create($data);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Photo has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeePhoto $employeePhoto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeePhoto $employeePhoto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployeePhoto $employeePhoto)
    {
        $employeeId = $employeePhoto->employee_id;

        EmployeePhoto::where('employee_id', $employeeId)->update(['main_photo' => 0]);

        $employeePhoto->update(['main_photo' => 1]);

        // $employee = Employee::findOrFail($employeeId);

        // $employee->update([
        //     'photo' => $employeePhoto->file_path,
        // ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Photo set as Main Photo successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeePhoto $employeePhoto)
    {
        // $employee = Employee::findOrFail($employeePhoto->employee_id);

        // if ($employeePhoto->main_photo) {
        //     $employee->update([
        //         'photo' => null,
        //     ]);

        //     $employeePhoto->update([
        //         'main_photo' => false,
        //     ]);
        // }

        $employeePhoto->delete();
        return redirect()->back()->with('success', 'Photo has been deleted successfully!');

    }
}
