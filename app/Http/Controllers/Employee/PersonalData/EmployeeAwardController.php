<?php

namespace App\Http\Controllers\Employee\PersonalData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Employee\PersonalData\EmployeeAward;

class EmployeeAwardController extends Controller
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
            'name_award' => 'required|string',
            'date_award' => 'required|date',
            'file_award' => 'nullable|file|mimes:pdf',
        ], [
            'name_award.required' => 'Nama Penghargaan wajib di isi',
            'date_award.required' => 'Tanggal Penghargaan wajib di isi',
            'file_award.mimes' => 'File harus pdf.',
        ]);

        $data = $request->all();

        if ($request->hasFile('file_award')) {
            $file = $request->file('file_award'); // Get the file from the request
            $extension = $file->getClientOriginalExtension(); // Get the file extension
            $file_name = 'file_award_' . $request['name'] . '_' . time() . '.' . $extension; // Construct the file name
            $data['file_award'] = $file->storeAs('files/employee/file_award', $file_name, 'public_local'); // Store the file

        }

        EmployeeAward::create($data);
        return redirect()->back()->with('success', 'Data has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeAward $employeeAward)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeAward $employeeAward)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployeeAward $employeeAward)
    {
        $request->validate([
            'name_award' => 'required|string',
            'date_award' => 'required|date',
            'file_award' => 'nullable|file|mimes:pdf',
        ], [
            'name_award.required' => 'Nama Penghargaan wajib di isi',
            'date_award.required' => 'Tanggal Penghargaan wajib di isi',
            'file_award.mimes' => 'File harus pdf.',
        ]);

        $data = $request->all();

        $path_file = $employeeAward->file;

        if ($request->hasFile('file_award')) {
            $file = $request->file('file_award');
            $extension = $file->getClientOriginalExtension();
            $file_name = 'file_award_' . $request['name'] . '_' . time() . '.' . $extension; // Construct the file name
            $data['file_award'] = $file->storeAs('files/employee/file_award', $file_name, 'public_local'); // Store the file
            // delete sertifikat
            if ($path_file != null || $path_file != '') {
                Storage::disk('public_local')->delete($path_file);
            }
        } else {
            $data['file_award'] = $path_file;
        }

        $employeeAward->update($data);


        return redirect()->back()->with('success', 'Data has been created successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeAward $employeeAward)
    {
        $employeeAward->delete();

        return redirect()->back()->with('success', 'Data has been deleted successfully!.');
    }
}
