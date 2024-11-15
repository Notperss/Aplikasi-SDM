<?php

namespace App\Http\Controllers\Employee\PersonalData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Employee\PersonalData\EmployeeKpi;

class EmployeeKpiController extends Controller
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
            'year' => 'required|integer',
            'grade' => 'required',
            'contract_recommendation' => 'required|boolean',
            'file' => 'nullable|file|mimes:pdf',
        ], [
            'year.required' => 'Tahun wajib di isi',
            'grade.required' => 'Nilai wajib di isi',
            'contract_recommendation.required' => 'Kontrak Rekomendasi wajib di isi',
            'file.mimes' => 'File harus pdf.',
        ]);


        $data = $request->all();

        if ($request->hasFile('file')) {
            $file = $request->file('file'); // Get the file from the request
            $extension = $file->getClientOriginalExtension(); // Get the file extension
            $file_name = 'file_kpi_' . $request['name'] . '_' . time() . '.' . $extension; // Construct the file name
            $data['file'] = $file->storeAs('files/employee/file_kpi', $file_name, 'public_local'); // Store the file

        }

        EmployeeKpi::create($data);
        return redirect()->back()->with('success', 'Data has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeKpi $employeeKpi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeKpi $employeeKpi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployeeKpi $employeeKpi)
    {
        $request->validate([
            'year' => 'required|integer',
            'grade' => 'required',
            'contract_recommendation' => 'required|boolean',
            'file' => 'nullable|file|mimes:pdf',
        ], [
            'year.required' => 'Tahun wajib di isi',
            'grade.required' => 'Nilai wajib di isi',
            'contract_recommendation.required' => 'Kontrak Rekomendasi wajib di isi',
            'file.mimes' => 'File harus pdf.',
        ]);


        $data = $request->all();

        $path_file = $employeeKpi->file;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $file_name = 'file_kpi_' . $data['name'] . '_' . time() . '.' . $extension; // Construct the file name
            $data['file'] = $file->storeAs('files/employee/file_kpi', $file_name, 'public_local'); // Store the file
            // delete sertifikat
            if ($path_file != null || $path_file != '') {
                Storage::disk('public_local')->delete($path_file);
            }
        } else {
            $data['file'] = $path_file;
        }

        $employeeKpi->update($data);


        return redirect()->back()->with('success', 'Data has been created successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeKpi $employeeKpi)
    {
        $employeeKpi->delete();

        return redirect()->back()->with('success', 'Data has been deleted successfully!.');
    }
}
