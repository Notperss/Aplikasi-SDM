<?php

namespace App\Http\Controllers\Recruitment;

use Illuminate\Http\Request;
use App\Models\Position\Position;
use App\Http\Controllers\Controller;
use App\Models\Recruitment\Candidate;
use App\Models\Recruitment\Selection;
use Illuminate\Support\Facades\Storage;
use App\Models\Recruitment\SelectedCandidate;
use App\Http\Requests\Recruitment\StoreSelectedCandidateRequest;
use App\Http\Requests\Recruitment\UpdateSelectedCandidateRequest;

class SelectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $selections = Selection::latest()->get();
        $positions = Position::orderBy('name', 'asc')->get();
        $candidates = Candidate::where('is_hire', false)->where('is_selection', false)->orderBy('name', 'asc')->get();
        // Get all soft-deleted selections
        $softDeletedSelections = Selection::onlyTrashed()->with('selectedCandidates')->get();

        return view('pages.recruitment.selection.index', compact('selections', 'positions', 'candidates', 'softDeletedSelections'));
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
    public function store(StoreSelectedCandidateRequest $request)
    {
        // dd($request->all());
        $data = $request->all();

        if ($request->hasFile('file_selection')) {
            $file = $request->file('file_selection'); // Get the file from the request
            $extension = $file->getClientOriginalExtension(); // Get the file extension
            $file_name = 'file_selection_' . $data['start_selection'] . '_' . time() . '.' . $extension; // Construct the file name
            $data['file_selection'] = $file->storeAs('files/file_selection', $file_name, 'public_local'); // Store the file

        }

        $selection = Selection::create($data);

        foreach ($data['candidates'] as $candidateData) {
            SelectedCandidate::create([
                'candidate_id' => $candidateData['id'],
                'selection_id' => $selection->id,
            ]);

            $candidate = Candidate::find($candidateData['id']);
            if ($candidate) {
                $candidate->is_selection = 1;
                $candidate->save();
            }
        }

        return redirect()->back()->with('success', 'Data has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Selection $selection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Selection $selection)
    {
        $positions = Position::orderBy('name', 'asc')->get();
        $candidates = Candidate::where('is_hire', false)->where('is_selection', false)->orderBy('name', 'asc')->get();

        return view('pages.recruitment.selection.edit', compact('selection', 'positions', 'candidates'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSelectedCandidateRequest $request, Selection $selection)
    {
        $data = $request->all();
        $path_selection = $selection->file_selection;

        if ($request->hasFile('file_selection')) {
            $file = $request->file('file_selection');
            $extension = $file->getClientOriginalExtension();
            $file_name = 'file_selection_' . $data['name'] . '_' . time() . '.' . $extension; // Construct the file name
            $data['file_selection'] = $file->storeAs('files/file_selection', $file_name, 'public_local'); // Store the file
            // delete selection
            if ($path_selection != null || $path_selection != '') {
                Storage::disk('public_local')->delete($path_selection);
            }
        } else {
            $data['file_selection'] = $path_selection;
        }
        $selection->update($data);
        return redirect()->back()->with('success', 'Data has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Selection $selection)
    {
        try {
            $selectedCandidates = $selection->selectedCandidates;

            foreach ($selectedCandidates as $selectedCandidate) {
                $candidate = Candidate::find($selectedCandidate->candidate_id);
                if ($candidate) {
                    $candidate->is_selection = 0;
                    $candidate->save();
                }
            }

            // Delete related records (SelectedCandidates)
            $selection->selectedCandidates()->delete(); // Assuming Selection hasMany SelectedCandidates

            $selection->delete();

            return redirect()->back()->with('success', 'Selection and related candidates have been deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete the selection.');
        }
    }

    // public function storeCandidate(Request $request, $selection)
    // {
    //     $selectedCandidate = $request->input('selected_candidate');

    //     $candidate = Candidate::find($selectedCandidate);
    //     if ($candidate) {
    //         $candidate->is_selection = 1;
    //         $candidate->save();
    //     }

    //     SelectedCandidate::create([
    //         'candidate_id' => $selectedCandidate,
    //         'selection_id' => $selection,
    //     ]);

    //     return redirect()->back()->with('success', 'Candidate selected successfully.');
    // }

    // public function destroyCandidate(SelectedCandidate $selectedCandidate)
    // {
    //     $candidate = Candidate::find($selectedCandidate->candidate_id);
    //     if ($candidate) {
    //         $candidate->is_selection = 0;
    //         $candidate->save();
    //     }

    //     $selectedCandidate->forceDelete();

    //     return redirect()->back()->with('success', 'Remove selected candidate successfully.');
    // }



    public function restore($id)
    {
        $selection = Selection::onlyTrashed()->with('selectedCandidates')->findOrFail($id);

        $selection->restore();

        $selection->selectedCandidates()->onlyTrashed()->restore();

        return redirect()->back()->with('success', 'Selection and related candidates have been restored successfully.');
    }

}
