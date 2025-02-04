<?php

namespace App\Http\Controllers\Recruitment;

use Illuminate\Http\Request;
use App\Models\Position\Position;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
            $file_name = 'file_result_candidate_'.$candidate->name.'_'.time().'.'.$extension; // Construct the file name
            $data['file_selected_candidate'] = $file->storeAs('files/selection/file_selected_candidate', $file_name, 'public_local'); // Store the file
            // delete file
            if ($path_file != null || $path_file != '') {
                Storage::disk('public_local')->delete($path_file);
            }
        } else {
            $data['file_selected_candidate'] = $path_file;
        }

        $selectedCandidate->is_approve = null;
        $selectedCandidate->is_hire = null;

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

        $selectedPositions = $selection->selectedPositions()
            ->where('selection_id', $selection->id)
            ->whereDoesntHave('selectedCandidates', function ($query) use ($selection) {
                $query->where('selection_id', $selection->id);
            })
            ->get();


        // $selectedPositions = $selection->selectedPositions()
        //     ->leftJoin('selected_candidates', 'positions.id', '=', 'selected_candidates.position_id')
        //     ->whereNull('selected_candidates.position_id')
        //     ->select('positions.*') // Select the columns you need from the 'positions' table
        //     ->get();


        return view('pages.recruitment.selection.result-selection', compact('selection', 'selectedPositions', 'selectedCandidates'));
    }

    public function hiredCandidates()
    {
        // $queryCandidate = Candidate::latest();

        // $candidates = $queryCandidate
        //     ->where('is_hire', true)
        //     ->whereHas('selectedCandidates.selection', function ($query) {
        //         $query->where('is_finished', true)->where('status', 'Ada Pemenang');  // Filter based on finished selections
        //     })
        //     ->get();

        $isSuperAdmin = Auth::user()->hasRole('super-admin');

        $selectedCandidates = SelectedCandidate::with(['candidate', 'selection'])
            ->whereNotNull('position_id')
            ->whereHas('selection', function ($query) use ($isSuperAdmin) {
                if (! $isSuperAdmin) {
                    $query->where('company_id', Auth::user()->company_id);
                }
                $query->where('is_finished', true)
                    ->where('status', true)
                    ->where('is_approve', 3);
            })
            ->orderBy('is_approve', 'desc')
            ->orderBy('created_at', 'asc')
            ->get();


        return view('pages.recruitment.selection.hired-candidate', compact('selectedCandidates'));

    }

    // Method to handle approval of a selection
    // public function approve($id)
    // {
    //     // Find the selection by ID
    //     $selection = SelectedCandidate::findOrFail($id);

    //     // Update the status to approved (you can adjust the logic based on your requirements)
    //     // $selection->status = 'approved';  // Set the approved status
    //     $selection->is_approve = true;   // Set the selection as finished
    //     $selection->save();

    //     // Redirect back with a success message
    //     return redirect()->back()->with('success', 'Kandidat telah disetujui.');
    // }

    // // Method to handle rejection of a selection
    // public function reject($id)
    // {
    //     // Find the selection by ID
    //     $selection = SelectedCandidate::findOrFail($id);

    //     // Update the status to rejected (you can adjust the logic based on your requirements)
    //     // $selection->status = 'rejected';  // Set the rejected status
    //     $selection->position_id = null;   // Set the selection as finished
    //     $selection->is_approve = false;   // Set the selection as finished
    //     $selection->save();

    //     // Redirect back with a success message
    //     return redirect()->back()->with('success', 'Kandidat telah ditolak.');
    // }


    // public function updateApprovalStatus(Request $request, $id)
    // {
    //     // Find the candidate by ID
    //     $selectedCandidate = SelectedCandidate::findOrFail($id);

    //     // Check the is_approve value and update the candidate status
    //     if ($request->has('is_approve')) {
    //         $selectedCandidate->is_approve = $request->input('is_approve');

    //         Candidate::where('id', $selectedCandidate->candidate_id)
    //             ->update(['is_selection' => 1, 'is_hire' => 1]);

    //         if ($selectedCandidate->is_approve == 0) {
    //             $selectedCandidate->is_hire = 0;

    //             Candidate::where('id', $selectedCandidate->candidate_id)
    //                 ->update(['is_selection' => 0, 'is_hire' => 0]);
    //         } else {
    //             $selectedCandidate->is_hire = null;
    //         }

    //         $selectedCandidate->save();

    //         // Set a success message based on the approval status
    //         $message = $selectedCandidate->is_approve ? 'Candidate approved.' : 'Candidate rejected.';
    //         return redirect()->back()->with('success', $message);
    //     }
    //     // // Check the is_approve value and update the candidate status
    //     // if ($request->has('is_hire')) {
    //     //     $selectedCandidate->is_hire = $request->input('is_hire');
    //     //     $selectedCandidate->save();

    //     //     // Set a success message based on the approval status
    //     //     $message = $selectedCandidate->is_hire ? 'Candidate approved.' : 'Candidate rejected.';
    //     //     return redirect()->back()->with('success', $message);
    //     // }

    //     return redirect()->back()->with('error', 'Invalid request. Approval status is missing.');
    // }


    public function followUpSelection(Selection $selection)
    {

        $companyId = Auth::user()->company_id;
        $isSuperAdmin = Auth::user()->hasRole('super-admin');


        $selectedPositionIds = $selection->selectedPositions
            // ->filter(function ($position) {
            //     return ! $position->employee; // Pastikan posisi tidak memiliki karyawan
            // })
            ->pluck('id')
            ->toArray();

        $positions = Position::when(! $isSuperAdmin, function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })
            ->where(function ($query) use ($selectedPositionIds) {
                $query->whereDoesntHave('selectedPositions')
                    ->whereDoesntHave('employee')
                    ->orWhereIn('id', $selectedPositionIds);
            })
            ->orderBy('name', 'asc')
            ->get();




        $selectedCandidates = $selection->selectedCandidates()
            ->where('is_approve', null)
            ->orderBy('position_id', 'desc')->get();

        $selectedPositions = $selection->selectedPositions()
            ->where('selection_id', $selection->id)
            ->whereDoesntHave('employee')

            ->whereDoesntHave('selectedCandidates', function ($query) use ($selection) {
                $query->where('selection_id', $selection->id);
            })
            ->get();


        // $selectedPositions = $selection->selectedPositions()
        //     ->leftJoin('selected_candidates', 'positions.id', '=', 'selected_candidates.position_id')
        //     ->whereNull('selected_candidates.position_id')
        //     ->select('positions.*') // Select the columns you need from the 'positions' table
        //     ->get();


        return view('pages.recruitment.selection.follow-up-selection',
            compact(
                'selection',
                'positions',
                'selectedPositionIds',
                'selectedPositions',
                'selectedCandidates'));
    }
}
