<?php

namespace App\Http\Controllers\Recruitment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Recruitment\CandidateTrainingAttended;
use App\Http\Requests\Recruitment\StoreCandidateTrainingAttendedRequest;
use App\Http\Requests\Recruitment\UpdateCandidateTrainingAttendedRequest;

class CandidateTrainingAttendedController extends Controller
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
    public function store(StoreCandidateTrainingAttendedRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('file_sertifikat')) {
            $file = $request->file('file_sertifikat'); // Get the file from the request
            $extension = $file->getClientOriginalExtension(); // Get the file extension
            $file_name = 'file_sertifikat_' . $data['name'] . '_' . time() . '.' . $extension; // Construct the file name
            $data['file_sertifikat'] = $file->storeAs('files/candidate/file_sertifikat', $file_name, 'public_local'); // Store the file

        }

        CandidateTrainingAttended::create($data);
        return redirect()->back()->with('success', 'Data has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(CandidateTrainingAttended $candidateTrainingAttended)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CandidateTrainingAttended $candidateTrainingAttended)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCandidateTrainingAttendedRequest $request, CandidateTrainingAttended $candidateTrainingAttended)
    {
        $data = $request->all();
        $path_sertifikat = $candidateTrainingAttended->file_sertifikat;

        if ($request->hasFile('file_sertifikat')) {
            $file = $request->file('file_sertifikat');
            $extension = $file->getClientOriginalExtension();
            $file_name = 'file_sertifikat_' . $data['name'] . '_' . time() . '.' . $extension; // Construct the file name
            $data['file_sertifikat'] = $file->storeAs('files/candidate/file_sertifikat', $file_name, 'public_local'); // Store the file
            // delete sertifikat
            if ($path_sertifikat != null || $path_sertifikat != '') {
                Storage::disk('public_local')->delete($path_sertifikat);
            }
        } else {
            $data['sertifikat'] = $path_sertifikat;
        }
        $candidateTrainingAttended->update($data);
        return redirect()->back()->with('success', 'Data has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CandidateTrainingAttended $candidateTrainingAttended)
    {
        $path_sertifikat = $candidateTrainingAttended->file_sertifikat;

        if ($path_sertifikat != null || $path_sertifikat != '') {
            Storage::disk('public_local')->delete($path_sertifikat);
        }
        $candidateTrainingAttended->delete();
        return redirect()->back()->with('success', 'Data has been deleted successfully!');
    }
}
