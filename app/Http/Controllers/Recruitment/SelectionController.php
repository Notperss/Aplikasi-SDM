<?php

namespace App\Http\Controllers\Recruitment;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Position\Position;
use App\Models\WorkUnit\Division;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Recruitment\Candidate;
use App\Models\Recruitment\Selection;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Recruitment\SelectedCandidate;
use App\Http\Requests\Recruitment\StoreSelectedCandidateRequest;
use App\Http\Requests\Recruitment\UpdateSelectedCandidateRequest;

class SelectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $selections = Selection::latest()->get();
        $divisions = Division::orderBy('name', 'asc')->get();
        // $latestSelection = Selection::latest()->first();

        $positions = Position::whereDoesntHave('selectedPositions', function ($query) {
            $query->where('is_finished', false);
        })->whereDoesntHave('selectedCandidates', function ($query) {
            $query->where('is_hire', null);
        })->whereDoesntHave('selectedCandidates', function ($query) {
            $query->where('is_approve', null);
        })->whereDoesntHave('employee', function ($query) {
            $query->where('date_leaving', null);
        })

            ->latest()->get();

        $candidates = Candidate::where('is_hire', false)->where('is_selection', false)->orderBy('name', 'asc');
        $softDeletedSelections = Selection::onlyTrashed()->with('selectedCandidates')->get();

        if (request()->ajax()) {

            $filters = [
                'name' => 'name',
                // 'dob' => 'dob',
                'gender' => 'gender',
                'phone_number' => 'phone_number',
                'applied_position' => 'applied_position',
                // 'last_educational' => 'last_educational',
                'study' => 'study',
                'disability' => 'disability',
                // 'marital_status' => 'marital_status',
                'tag' => 'tag',
            ];

            // Handle the age filter
            if ($request->filled('age')) {
                $age = (int) $request->age; // Get the age from the request
                $startDate = Carbon::now()->subYears($age + 1)->startOfYear(); // Start of the year for the age
                $endDate = Carbon::now()->subYears($age)->endOfYear(); // End of the year for the age
                $candidates->whereBetween('dob', [$startDate, $endDate]);
            }

            if ($request->filled('marital_status')) {
                $candidates->where('marital_status', 'like', $request->marital_status);
            }

            if ($request->filled('last_educational')) {
                $candidates->where('last_educational', 'like', $request->last_educational);
            }

            foreach ($filters as $requestKey => $dbColumn) {
                if ($request->filled($requestKey)) {
                    $candidates->where($dbColumn, 'like', '%' . $request->$requestKey . '%');
                }
            }


            return DataTables::of($candidates)
                ->addIndexColumn()
                ->addColumn('action', function ($item) {
                    return '
                             <div class="btn-group mb-1">
                              <button class="btn btn-sm btn-primary pilih-candidate" data-id="' . $item->id . '"
                                data-name="' . $item->name . '" data-email="' . $item->email . '"
                                data-phone="' . $item->phone_number . '">
                                Pilih
                              </button>
                            </div>
                        ';
                })
                ->editColumn('photo', function ($item) {
                    if ($item->photo) {
                        return ' <div class="fixed-frame">
                    <img src="' . asset('storage/' . $item->photo) . '" data-fancybox alt="Icon User"
                      class="framed-image" style="cursor: pointer">
                  </div>';
                    } else {
                        return 'No Image';
                    }
                })->editColumn('age', function ($item) {
                    if ($item->dob) {
                        $dob = Carbon::parse($item->dob);
                        $now = Carbon::now();

                        // Calculate the difference
                        $ageYears = $dob->age;
                        $ageMonths = $dob->diffInMonths($now) % 12; // Get the remaining months after years
    
                        return $ageYears . ' Tahun ' . $ageMonths . ' Bulan';
                    }
                    return 'N/A'; // Return 'N/A' if dob is not available
                })
                ->rawColumns(['action', 'photo', ''])
                ->toJson();
        }

        return view('pages.recruitment.selection.index', compact('selections', 'divisions', 'positions', 'candidates', 'softDeletedSelections'));
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
        $data = $request->except('position_id');

        $company_id = Auth::user()->company_id;

        $requestData = array_merge($data, [
            'company_id' => $company_id,
        ]);


        if ($request->hasFile('file_selection')) {
            $file = $request->file('file_selection'); // Get the file from the request
            $extension = $file->getClientOriginalExtension(); // Get the file extension
            $file_name = 'file_selection_' . $data['name'] . '_' . time() . '.' . $extension; // Construct the file name
            $data['file_selection'] = $file->storeAs('files/selection/file_selection', $file_name, 'public_local'); // Store the file
        }

        $selection = Selection::create($requestData);

        $selection->selectedPositions()->sync($request->input('position_id'));

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

        return redirect()->route('selection.index')->with('success', 'Data has been created successfully!');
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
        // $selectedPositionIds = $selection->selectedPositions->pluck('id')->toArray();
        // $positions = Position::whereDoesntHave('selectedPositions')
        //     ->orWhereIn('id', $selectedPositionIds)
        //     ->orderBy('name', 'asc')
        //     ->get();

        $positions = Position::latest()->get();

        $divisions = Division::orderBy('name', 'asc')->get();

        $candidates = Candidate::where('is_hire', false)->where('is_selection', false)->orderBy('name', 'asc')->get();
        $dataCount = $selection->selectedCandidates()->count();
        // return view('pages.recruitment.selection.edit', compact('selection', 'positions', 'candidates', 'selectedPositionIds', 'dataCount', 'divisions'));
        return view('pages.recruitment.selection.edit', compact('selection', 'positions', 'candidates', 'dataCount', 'divisions'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSelectedCandidateRequest $request, Selection $selection)
    {
        $data = $request->except('position_id');
        $path_selection = $selection->file_selection;

        if ($request->hasFile('file_selection')) {
            $file = $request->file('file_selection');
            $extension = $file->getClientOriginalExtension();
            $file_name = 'file_selection_' . $data['name'] . '_' . time() . '.' . $extension; // Construct the file name
            $data['file_selection'] = $file->storeAs('files/selection/file_selection', $file_name, 'public_local'); // Store the file
            // delete selection
            if ($path_selection != null || $path_selection != '') {
                Storage::disk('public_local')->delete($path_selection);
            }
        } else {
            $data['file_selection'] = $path_selection;
        }
        $selection->update($data);
        $selection->selectedPositions()->sync($request->input('position_id') ?? []);

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
                    $candidate->is_hire = 0;
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

    // public function closeSelection(Selection $selection, Request $request)
    // {

    //     $selectedCandidates = $selection->selectedCandidates;

    //     if ($selection) {

    //         if ($request->selected_option == 'Ada Pemenang') {
    //             // Check if any of the selected positions still have candidates assigned
    //             $positionsWithCandidates = $selection->selectedPositions()->whereDoesntHave('selectedCandidates')->exists();

    //             if ($positionsWithCandidates) {
    //                 // If positions are still assigned to candidates, return an error
    //                 return redirect()->route('selection.index')->with('error', 'Some positions are not still assigned to candidates. Please resolve this before closing the selection.');
    //             }

    //             foreach ($selectedCandidates as $selectedCandidate) {
    //                 $candidate = Candidate::find($selectedCandidate->candidate_id);
    //                 if ($candidate->is_hire == 0) {
    //                     $candidate->is_selection = 0;
    //                 } elseif ($candidate->is_hire == 1) {
    //                     $candidate->is_selection = 1;
    //                 }
    //                 $candidate->save();
    //             }
    //         } else {
    //             foreach ($selectedCandidates as $selectedCandidate) {
    //                 $candidate = Candidate::find($selectedCandidate->candidate_id);
    //                 if ($candidate) {
    //                     $candidate->is_selection = 0;
    //                     $candidate->is_hire = 0;
    //                     $candidate->save();
    //                 }

    //                 $selectedCandidate->update([
    //                     'position_id' => null,
    //                 ]);
    //             }
    //         }

    //         $selection->update([
    //             'status' => $request->selected_option,
    //             'is_finished' => true,
    //         ]);




    //         return redirect()->route('selection.index')->with('success', 'Selection has closed.');
    //     } else {
    //         return redirect()->route('selection.index')->with('error', 'Selection has failed to close.');
    //     }

    // }

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


    public function closeSelection(Selection $selection, Request $request)
    {
        // Check if the selection exists
        if (! $selection) {
            return redirect()->route('selection.index')->with('error', 'Selection has failed to close.');
        }

        $selectedCandidates = $selection->selectedCandidates;

        // $unapprovedCandidates = $selectedCandidates->filter(function ($candidate) {
        //     return $candidate->position_id && ! $candidate->is_approve; // Assuming 'approved' is a boolean attribute
        // });

        // Check for the winning option and positions with candidates
        if ($request->selected_option == 1) {
            // if ($selection->selectedPositions()->whereDoesntHave('selectedCandidates')->exists()) {
            //     return redirect()->back()->with('error', 'Some positions are still not assigned to candidates. Please resolve this before closing the selection.');
            // }

            // if ($unapprovedCandidates->isNotEmpty()) {
            //     // Handle the validation failure (e.g., throw a validation exception or return a message)
            //     return back()->withErrors(['selectedCandidates' => 'Some candidates with a position are not approved.']);
            // }

            // Update candidate selection status
            foreach ($selectedCandidates as $selectedCandidate) {
                $candidate = Candidate::find($selectedCandidate->candidate_id);
                if ($candidate) {
                    $candidate->is_selection = 0;
                    $candidate->save();
                }
            }
        } else {
            // if no winner
            foreach ($selectedCandidates as $selectedCandidate) {
                $candidate = Candidate::find($selectedCandidate->candidate_id);
                if ($candidate) {
                    $candidate->is_selection = 0;
                    $candidate->is_hire = 0;
                    $candidate->save();
                }

                // Clear the position ID for selected candidates
                $selectedCandidate->update(['position_id' => null]);
            }
        }

        // Update selection status
        $selection->update([
            'status' => $request->selected_option,
            'is_finished' => true,
        ]);

        return redirect()->route('selection.index')->with('success', 'Selection has closed.');
    }

    public function restore($id)
    {
        $selection = Selection::onlyTrashed()->with('selectedCandidates')->findOrFail($id);

        $selection->restore();

        $selection->selectedCandidates()->onlyTrashed()->restore();

        return redirect()->back()->with('success', 'Selection and related candidates have been restored successfully.');
    }

    public function getCandidate(Request $request)
    {
        $candidates = Candidate::where('is_hire', false)->where('is_selection', false)->orderBy('name', 'asc');

        if (request()->ajax()) {

            $filters = [
                'name' => 'name',
                // 'dob' => 'dob',
                'gender' => 'gender',
                'phone_number' => 'phone_number',
                'applied_position' => 'applied_position',
                // 'last_educational' => 'last_educational',
                'study' => 'study',
                'disability' => 'disability',
                // 'marital_status' => 'marital_status',
                'tag' => 'tag',
            ];

            // Handle the age filter
            if ($request->filled('age')) {
                $age = (int) $request->age; // Get the age from the request
                $startDate = Carbon::now()->subYears($age + 1)->startOfYear(); // Start of the year for the age
                $endDate = Carbon::now()->subYears($age)->endOfYear(); // End of the year for the age
                $candidates->whereBetween('dob', [$startDate, $endDate]);
            }

            if ($request->filled('marital_status')) {
                $candidates->where('marital_status', 'like', $request->marital_status);
            }

            if ($request->filled('last_educational')) {
                $candidates->where('last_educational', 'like', $request->last_educational);
            }

            foreach ($filters as $requestKey => $dbColumn) {
                if ($request->filled($requestKey)) {
                    $candidates->where($dbColumn, 'like', '%' . $request->$requestKey . '%');
                }
            }


            return DataTables::of($candidates)
                ->addIndexColumn()
                ->addColumn('action', function ($item) {
                    return '
                        <div class="btn-group mb-1">
                            <button type="button" class="btn btn-sm btn-primary"
                                    onclick="addCandidate(' . $item->id . ', \'' . $item->name . '\')">
                                Pilih
                            </button>
                        </div>
                        ';
                })
                ->editColumn('photo', function ($item) {
                    if ($item->photo) {
                        return ' <div class="fixed-frame">
                    <img src="' . asset('storage/' . $item->photo) . '" data-fancybox alt="Icon User"
                      class="framed-image" style="cursor: pointer">
                  </div>';
                    } else {
                        return 'No Image';
                    }
                })->editColumn('age', function ($item) {
                    if ($item->dob) {
                        $dob = Carbon::parse($item->dob);
                        $now = Carbon::now();

                        // Calculate the difference
                        $ageYears = $dob->age;
                        $ageMonths = $dob->diffInMonths($now) % 12; // Get the remaining months after years
    
                        return $ageYears . ' Tahun ' . $ageMonths . ' Bulan';
                    }
                    return 'N/A'; // Return 'N/A' if dob is not available
                })
                ->rawColumns(['action', 'photo', ''])
                ->toJson();
        }
    }

    public function updateApprovalStatus(Request $request, $id)
    {
        $selection = Selection::findOrFail($id);

        if ($request->has('is_approve')) {
            $selection->is_approve = $request->input('is_approve');
            $selection->save();

            if ($selection->is_approve == 0) {
                // Reset selected candidates and their main candidate records if rejected
                foreach ($selection->selectedCandidates as $selectedCandidate) {
                    if ($selectedCandidate->position_id) {
                        $selectedCandidate->is_approve = 0;
                        $selectedCandidate->is_hire = 0;
                        $selectedCandidate->save();
                    }

                    Candidate::where('id', $selectedCandidate->candidate_id)
                        ->update(['is_selection' => 0, 'is_hire' => 0]);
                }
            }

            $message = $selection->is_approve ? 'Selection approved.' : 'Selection rejected.';
            return redirect()->back()->with('success', $message);
        }

        return redirect()->back()->with('error', 'Invalid request. Approval status is missing.');
    }

}
