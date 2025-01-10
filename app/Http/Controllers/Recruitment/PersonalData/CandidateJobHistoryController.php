<?php

namespace App\Http\Controllers\Recruitment\PersonalData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Recruitment\PersonalData\CandidateJobHistory;

class CandidateJobHistoryController extends Controller
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
        $data = $request->all();

        if ($request->hasFile('file')) {
            $file = $request->file('file'); // Get the file from the request
            $extension = $file->getClientOriginalExtension(); // Get the file extension
            $file_name = 'file_paklaring_'.$data['name'].'_'.time().'.'.$extension; // Construct the file name
            $data['file'] = $file->storeAs('files/employee/file_paklaring', $file_name, 'public_local'); // Store the file

        }
        CandidateJobHistory::create($data);
        return redirect()->back()->with('success', 'Data has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(CandidateJobHistory $candidateJobHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CandidateJobHistory $candidateJobHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CandidateJobHistory $candidateJobHistory)
    {
        $data = $request->all();
        $path_file = $candidateJobHistory->file;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $file_name = 'file_paklaring_'.$data['name'].'_'.time().'.'.$extension; // Construct the file name
            $data['file'] = $file->storeAs('files/candidate/file_paklaring', $file_name, 'public_local'); // Store the file
            // delete ijazah
            if ($path_file != null || $path_file != '') {
                Storage::disk('public_local')->delete($path_file);
            }
        } else {
            $data['file'] = $path_file;
        }
        $candidateJobHistory->update($data);
        return redirect()->back()->with('success', 'Data has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CandidateJobHistory $candidateJobHistory)
    {
        $path_file = $candidateJobHistory->file;

        if ($path_file != null || $path_file != '') {
            Storage::disk('public_local')->delete($path_file);
        }
        $candidateJobHistory->delete();
        return redirect()->back()->with('success', 'Data has been deleted successfully!');
    }
}
