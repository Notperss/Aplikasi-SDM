<?php

namespace App\Http\Controllers\Employee\PersonalData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Employee\PersonalData\EmployeeDuty;

class EmployeeDutyController extends Controller
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
            'name_duty' => 'required|string|max:255',
            'date_duty' => 'required|date',
            'location' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf',
        ], [
            'name_duty.required' => 'Nama Dinas Tugas wajib di isi',
            'date_duty.required' => 'Tanggal Tugas wajib di isi',
            'location.required' => 'Lokasi wajib di isi',
            'file.mimes' => 'File harus pdf.',
        ]);


        $data = $request->all();

        if ($request->hasFile('file')) {
            $file = $request->file('file'); // Get the file from the request
            $extension = $file->getClientOriginalExtension(); // Get the file extension
            $file_name = 'file_dinas_tugas_' . $request['name'] . '_' . time() . '.' . $extension; // Construct the file name
            $data['file'] = $file->storeAs('files/employee/file_dinas_tugas', $file_name, 'public_local'); // Store the file

        }

        EmployeeDuty::create($data);
        return redirect()->back()->with('success', 'Data has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeDuty $employeeDuty)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeDuty $employeeDuty)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployeeDuty $employeeDuty)
    {
        $request->validate([
            'name_duty' => 'required|string|max:255',
            'date_duty' => 'required|date',
            'location' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf',
        ], [
            'name_duty.required' => 'Nama Dinas Tugas wajib di isi',
            'date_duty.required' => 'Tanggal Tugas wajib di isi',
            'location.required' => 'Lokasi wajib di isi',
            'file.mimes' => 'File harus pdf.',
        ]);

        $data = $request->all();

        $path_file = $employeeDuty->file;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $file_name = 'file_dinas_tugas_' . $data['name'] . '_' . time() . '.' . $extension; // Construct the file name
            $data['file'] = $file->storeAs('files/employee/file_dinas_tugas', $file_name, 'public_local'); // Store the file
            // delete sertifikat
            if ($path_file != null || $path_file != '') {
                Storage::disk('public_local')->delete($path_file);
            }
        } else {
            $data['file'] = $path_file;
        }

        $employeeDuty->update($data);


        return redirect()->back()->with('success', 'Data has been created successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeDuty $employeeDuty)
    {
        $employeeDuty->delete();

        return redirect()->back()->with('success', 'Data has been deleted successfully!.');
    }
}
