<?php

namespace App\Http\Controllers\Recruitment;

use Illuminate\Http\Request;
use App\Models\Position\Position;
use App\Http\Controllers\Controller;
use App\Models\Recruitment\Candidate;
use App\Models\Recruitment\Selection;
use Illuminate\Support\Facades\Storage;
use App\Models\Recruitment\SelectedCandidate;

class SelectedCandidateController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SelectedCandidate $selectedCandidate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SelectedCandidate $selectedCandidate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SelectedCandidate $selectedCandidate)
    {
        $data = $request->validate([
            // 'result_selection' => 'required|boolean', // Assuming result_selection is a boolean (1/0)
            'position_id' => 'nullable|exists:positions,id', // Assuming result_selection is a boolean (1/0)
            'description' => 'nullable', // Assuming result_selection is a boolean (1/0)
            'file_selected_candidate' => 'nullable|mimes:pdf,jpeg,jpg,png|max:2048', // Assuming result_selection is a boolean (1/0)
        ]);

        $path_file = $selectedCandidate->file_selected_candidate;
        $candidate = Candidate::find($selectedCandidate->candidate_id);

        if ($request->hasFile('file_selected_candidate')) {
            $file = $request->file('file_selected_candidate');
            $extension = $file->getClientOriginalExtension();
            $file_name = 'file_result_candidate_' . $candidate->name . '_' . time() . '.' . $extension; // Construct the file name
            $data['file_selected_candidate'] = $file->storeAs('files/selection/file_selected_candidate', $file_name, 'public_local'); // Store the file
            // delete file
            if ($path_file != null || $path_file != '') {
                Storage::disk('public_local')->delete($path_file);
            }
        } else {
            $data['file_selected_candidate'] = $path_file;
        }
        $selectedCandidate->update($data);

        $candidate->update([
            'is_hire' => $data['position_id'] ? true : false,
        ]);
        return redirect()->back()->with('success', 'Data has been updated successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SelectedCandidate $selectedCandidate)
    {
        $candidate = Candidate::find($selectedCandidate->candidate_id);
        if ($candidate) {
            $candidate->is_selection = 0;
            $candidate->save();
        }

        // $path_file = $selectedCandidate->file_selected_candidate;
        // if ($path_file != null || $path_file != '') {
        //     Storage::disk('public_local')->delete($path_file);
        // }

        $selectedCandidate->forceDelete();

        return redirect()->back()->with('success', 'Remove selected candidate successfully.');
    }

    public function addCandidate(Request $request, $selection)
    {
        //edit selection
        $selectedCandidate = $request->input('selected_candidate');

        $candidate = Candidate::find($selectedCandidate);
        if ($candidate) {
            $candidate->is_selection = 1;
            $candidate->save();
        }

        SelectedCandidate::create([
            'candidate_id' => $selectedCandidate,
            'selection_id' => $selection,
        ]);

        return redirect()->back()->with('success', 'Candidate selected successfully.');
    }

    public function resultSelection(Selection $selection)
    {
        $selectedCandidates = $selection->selectedCandidates()->orderBy('position_id', 'desc')->get();
        $selectedPositions = $selection->selectedPositions()->whereDoesntHave('selectedCandidates')->get();
        // $selectedPositions = $selection->selectedPositions()
        //     ->leftJoin('selected_candidates', 'positions.id', '=', 'selected_candidates.position_id')
        //     ->whereNull('selected_candidates.position_id')
        //     ->select('positions.*') // Select the columns you need from the 'positions' table
        //     ->get();


        return view('pages.recruitment.selection.result-selection', compact('selection', 'selectedPositions', 'selectedCandidates'));
    }
}
