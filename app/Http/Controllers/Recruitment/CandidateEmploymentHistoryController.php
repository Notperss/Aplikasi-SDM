<?php

namespace App\Http\Controllers\Recruitment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Recruitment\CandidateEmploymentHistory;
use App\Http\Requests\Recruitment\StoreCandidateEmploymentHistoryRequest;
use App\Http\Requests\Recruitment\UpdateCandidateEmploymentHistoryRequest;

class CandidateEmploymentHistoryController extends Controller
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
    public function store(StoreCandidateEmploymentHistoryRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('file')) {
            $file = $request->file('file'); // Get the file from the request
            $extension = $file->getClientOriginalExtension(); // Get the file extension
            $file_name = 'file_paklaring_' . $data['name'] . '_' . time() . '.' . $extension; // Construct the file name
            $data['file'] = $file->storeAs('files/candidate/file_paklaring', $file_name, 'public_local'); // Store the file

        }
        CandidateEmploymentHistory::create($data);
        return redirect()->back()->with('success', 'Data has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(CandidateEmploymentHistory $candidateEmploymentHistory)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CandidateEmploymentHistory $candidateEmploymentHistory)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCandidateEmploymentHistoryRequest $request, CandidateEmploymentHistory $candidateEmploymentHistory)
    {
        $data = $request->all();
        $path_file = $candidateEmploymentHistory->file;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $file_name = 'file_paklaring_' . $data['name'] . '_' . time() . '.' . $extension; // Construct the file name
            $data['file'] = $file->storeAs('files/candidate/file_paklaring', $file_name, 'public_local'); // Store the file
            // delete ijazah
            if ($path_file != null || $path_file != '') {
                Storage::disk('public_local')->delete($path_file);
            }
        } else {
            $data['file'] = $path_file;
        }
        $candidateEmploymentHistory->update($data);
        return redirect()->back()->with('success', 'Data has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CandidateEmploymentHistory $candidateEmploymentHistory)
    {
        $path_file = $candidateEmploymentHistory->file;

        if ($path_file != null || $path_file != '') {
            Storage::disk('public_local')->delete($path_file);
        }
        $candidateEmploymentHistory->delete();
        return redirect()->back()->with('success', 'Data has been deleted successfully!');
    }
}
