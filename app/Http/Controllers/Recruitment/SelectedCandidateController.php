<?php

namespace App\Http\Controllers\Recruitment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Recruitment\Candidate;
use App\Models\Recruitment\SelectedCandidate;
use App\Models\Recruitment\Selection;

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
        // $selectedCandidate = $request->input('selected_candidate');

        // $candidate = Candidate::find($selectedCandidate);
        // if ($candidate) {
        //     $candidate->is_selection = 1;
        //     $candidate->save();
        // }

        // SelectedCandidate::create([
        //     'candidate_id' => $selectedCandidate,
        //     'selection_id' => $selection,
        // ]);

        return redirect()->back()->with('success', 'Candidate selected successfully.');
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
        //
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

        $selectedCandidate->forceDelete();

        return redirect()->back()->with('success', 'Remove selected candidate successfully.');
    }

    public function addCandidate(Request $request, $selection)
    {
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
        // $positions = Position::orderBy('name', 'asc')->get();
        // $selection = Selection::orderBy('name', 'asc')->get();
        // $candidates = Candidate::where('is_hire', false)->where('is_selection', false)->orderBy('name', 'asc')->get();


        return view('pages.recruitment.selection.result-selection', compact('selection'));
    }
}
