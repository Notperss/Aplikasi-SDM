<?php

namespace App\Http\Controllers\Recruitment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Recruitment\EducationalHistory;
use App\Http\Requests\Recruitment\StoreEducationalHistoryRequest;
use App\Http\Requests\Recruitment\UpdateEducationalHistoryRequest;

class EducationalHistoryController extends Controller
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
    public function store(StoreEducationalHistoryRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('file_ijazah')) {
            $file = $request->file('file_ijazah'); // Get the file from the request
            $extension = $file->getClientOriginalExtension(); // Get the file extension
            $file_name = $data['school_level'] . '_file_ijazah_' . $data['name'] . '_' . time() . '.' . $extension; // Construct the file name
            $data['file_ijazah'] = $file->storeAs('files/file_ijazah', $file_name, 'public_local'); // Store the file

        }

        EducationalHistory::create($data);
        return redirect()->back()->with('success', 'Data has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(EducationalHistory $educationalHistory)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EducationalHistory $educationalHistory)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEducationalHistoryRequest $request, EducationalHistory $educationalHistory)
    {
        $data = $request->all();
        $path_ijazah = $educationalHistory->file_ijazah;

        if ($request->hasFile('file_ijazah')) {
            $file = $request->file('file_ijazah');
            $extension = $file->getClientOriginalExtension();
            $file_name = $data['school_level'] . '_file_ijazah_' . $data['name'] . '_' . time() . '.' . $extension; // Construct the file name
            $data['file_ijazah'] = $file->storeAs('files/file_ijazah', $file_name, 'public_local'); // Store the file
            // delete ijazah
            if ($path_ijazah != null || $path_ijazah != '') {
                Storage::disk('public_local')->delete($path_ijazah);
            }
        } else {
            $data['file_ijazah'] = $path_ijazah;
        }
        $educationalHistory->update($data);
        return redirect()->back()->with('success', 'Data has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EducationalHistory $educationalHistory)
    {
        $path_ijazah = $educationalHistory->file_ijazah;

        if ($path_ijazah != null || $path_ijazah != '') {
            Storage::disk('public_local')->delete($path_ijazah);
        }
        $educationalHistory->delete();
        return redirect()->back()->with('success', 'Data has been deleted successfully!');
    }
}
