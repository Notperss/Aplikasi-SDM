<?php

namespace App\Http\Controllers\Employee\PersonalData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Employee\PersonalData\EmployeeTrainingAttended;
use App\Http\Requests\Employee\PersonalData\StoreTrainingAttendedRequest;
use App\Http\Requests\Employee\PersonalData\UpdateTrainingAttendedRequest;


class EmployeeTrainingAttendedController extends Controller
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
    public function store(StoreTrainingAttendedRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('file_sertifikat')) {
            $file = $request->file('file_sertifikat'); // Get the file from the request
            $extension = $file->getClientOriginalExtension(); // Get the file extension
            $file_name = 'file_sertifikat_' . $data['name'] . '_' . time() . '.' . $extension; // Construct the file name
            $data['file_sertifikat'] = $file->storeAs('files/employee/file_sertifikat', $file_name, 'public_local'); // Store the file

        }

        EmployeeTrainingAttended::create($data);
        return redirect()->back()->with('success', 'Data has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeTrainingAttended $employeeTrainingAttended)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeTrainingAttended $employeeTrainingAttended)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTrainingAttendedRequest $request, EmployeeTrainingAttended $employeeTrainingAttended)
    {
        $data = $request->all();
        $path_sertifikat = $employeeTrainingAttended->file_sertifikat;

        if ($request->hasFile('file_sertifikat')) {
            $file = $request->file('file_sertifikat');
            $extension = $file->getClientOriginalExtension();
            $file_name = 'file_sertifikat_' . $data['name'] . '_' . time() . '.' . $extension; // Construct the file name
            $data['file_sertifikat'] = $file->storeAs('files/employee/file_sertifikat', $file_name, 'public_local'); // Store the file
            // delete sertifikat
            if ($path_sertifikat != null || $path_sertifikat != '') {
                Storage::disk('public_local')->delete($path_sertifikat);
            }
        } else {
            $data['file_sertifikat'] = $path_sertifikat;
        }
        $employeeTrainingAttended->update($data);
        return redirect()->back()->with('success', 'Data has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeTrainingAttended $employeeTrainingAttended)
    {
        $path_sertifikat = $employeeTrainingAttended->file_sertifikat;

        if ($path_sertifikat != null || $path_sertifikat != '') {
            Storage::disk('public_local')->delete($path_sertifikat);
        }
        $employeeTrainingAttended->delete();
        return redirect()->back()->with('success', 'Data has been deleted successfully!');
    }
}
