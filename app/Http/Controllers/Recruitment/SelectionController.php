<?php

namespace App\Http\Controllers\Recruitment;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Approval\Approval;
use App\Models\Position\Position;
use App\Models\WorkUnit\Division;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Recruitment\Candidate;
use App\Models\Recruitment\Selection;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Recruitment\HistorySelection;
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

        $companyId = Auth::user()->company_id;
        $isSuperAdmin = Auth::user()->hasRole('super-admin');

        $selections = Selection::latest()->when(! $isSuperAdmin, function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->get();

        $divisions = Division::orderBy('name', 'asc')->when(! $isSuperAdmin, function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->get();

        $positions = Position::whereDoesntHave('selectedPositions', function ($query) {
            $query->where('is_finished', false);
        })->whereDoesntHave('selectedCandidates', function ($query) {
            $query->where('is_hire', null);
        })->whereDoesntHave('selectedCandidates', function ($query) {
            $query->where('is_approve', null);
        })->whereDoesntHave('employee', function ($query) {
            $query->where('date_leaving', null);
        })->latest()
            ->when(! $isSuperAdmin, function ($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })->get();

        $candidates = Candidate::where('is_hire', false)->where('is_selection', false)
            ->when(! $isSuperAdmin, function ($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })->orderBy('name', 'asc');

        $softDeletedSelections = Selection::onlyTrashed()->with('selectedCandidates')->get();

        if (request()->ajax()) {

            $filters = [
                'name' => 'name',
                // 'dob' => 'dob',
                'gender' => 'gender',
                // 'phone_number' => 'phone_number',
                // 'applied_position' => 'applied_position',
                // 'last_educational' => 'last_educational',
                'study' => 'study',
                'disability' => 'disability',
                // 'marital_status' => 'marital_status',
                'tag' => 'tag',
            ];

            // Handle the age filter
            if ($request->filled('age')) {
                $ageFilter = $request->age;

                if ($ageFilter === '<20') {
                    // Age less than 20
                    $startDate = Carbon::now()->subYears(20)->startOfYear();
                    $candidates->where('dob', '>', $startDate);
                } elseif ($ageFilter === '>50') {
                    // Age greater than 50
                    $endDate = Carbon::now()->subYears(50)->endOfYear();
                    $candidates->where('dob', '<', $endDate);
                } elseif (preg_match('/^(\d+)-(\d+)$/', $ageFilter, $matches)) {
                    // Age range (e.g., 20-25)
                    $startAge = (int) $matches[1];
                    $endAge = (int) $matches[2];

                    $startDate = Carbon::now()->subYears($endAge + 1)->startOfYear();
                    $endDate = Carbon::now()->subYears($startAge)->endOfYear();

                    $candidates->whereBetween('dob', [$startDate, $endDate]);
                }
            }

            if ($request->filled('marital_status')) {
                $candidates->where('marital_status', 'like', $request->marital_status);
            }

            if ($request->filled('seleksi')) {
                $candidates = $candidates->withCount('selectedCandidates') // Preload the count of selectedCandidates
                    ->having('selected_candidates_count', '=', $request->seleksi); // Filter based on count
            }

            if ($request->filled('last_educational')) {
                $candidates->where('last_educational', 'like', $request->last_educational);
            }

            foreach ($filters as $requestKey => $dbColumn) {
                if ($request->filled($requestKey)) {
                    $candidates->where($dbColumn, 'like', '%'.$request->$requestKey.'%');
                }
            }


            return DataTables::of($candidates)
                ->addIndexColumn()
                ->addColumn('action', function ($item) {
                    return '
                             <div class="btn-group mb-1">
                              <button class="btn btn-sm btn-primary pilih-candidate" data-id="'.$item->id.'"
                                data-name="'.$item->name.'" data-email="'.$item->email.'"
                                data-phone="'.$item->phone_number.'" data-education="'.$item->last_educational.'" data-study="'.$item->study.'">
                                Pilih
                              </button>
                            </div>
                        ';
                })
                ->editColumn('photo', function ($item) {
                    return $item->photo
                        ? '<div class="fixed-frame">
                                <img src="'.asset('storage/'.$item->photo).'" data-fancybox alt="Icon User" class="framed-image" style="cursor: pointer">
                            </div>'
                        : 'No Image';
                })->editColumn('age', function ($item) {
                    if ($item->dob) {
                        $dob = Carbon::parse($item->dob);
                        $now = Carbon::now();

                        // Calculate the difference
                        $ageYears = $dob->age;
                        $ageMonths = $dob->diffInMonths($now) % 12; // Get the remaining months after years
    
                        return $ageYears.' Tahun '.$ageMonths.' Bulan';
                    }
                    return 'N/A'; // Return 'N/A' if dob is not available
                })->editColumn('selectionCount', function ($item) {

                    return '<a href="'.route('selection.getCandidateHistory', $item->id).'">'.$item->selectedCandidates->count().'</a>';
                })
                ->rawColumns(['action', 'photo', 'age', 'selectionCount'])
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

        if ($request->hasFile('file_selection')) {
            $file = $request->file('file_selection'); // Get the file from the request
            $extension = $file->getClientOriginalExtension(); // Get the file extension
            $file_name = 'file_selection_'.$data['name'].'_'.time().'.'.$extension; // Construct the file name
            $data['file_selection'] = $file->storeAs('files/selection/file_selection', $file_name, 'public_local'); // Store the file
        }

        if ($request->hasFile('file_fptk')) {
            $file = $request->file('file_fptk'); // Get the file from the request
            $extension = $file->getClientOriginalExtension(); // Get the file extension
            $file_name = 'file_fptk_'.$data['name'].'_'.time().'.'.$extension; // Construct the file name
            $data['file_fptk'] = $file->storeAs('files/fptk/file_fptk', $file_name, 'public_local'); // Store the file
        }

        $requestData = array_merge($data, [
            'company_id' => $company_id,
        ]);

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
        $companyId = Auth::user()->company_id;
        $isSuperAdmin = Auth::user()->hasRole('super-admin');


        $selectedPositionIds = $selection->selectedPositions->pluck('id')->toArray();
        $positions = Position::when(! $isSuperAdmin, function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->whereDoesntHave('selectedPositions')
            ->orWhereIn('id', $selectedPositionIds)
            ->orderBy('name', 'asc')
            ->get();


        $divisions = Division::when(! $isSuperAdmin, function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->orderBy('name', 'asc')->get();

        $candidates = Candidate::when(! $isSuperAdmin, function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->where('is_hire', false)->where('is_selection', false)->orderBy('name', 'asc')->get();

        $dataCount = $selection->selectedCandidates()->count();

        return view('pages.recruitment.selection.edit', compact('selection', 'positions', 'candidates', 'selectedPositionIds', 'dataCount', 'divisions'));
        // return view('pages.recruitment.selection.edit', compact('selection', 'positions', 'candidates', 'dataCount', 'divisions'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSelectedCandidateRequest $request, Selection $selection)
    {
        $data = $request->except('position_id');
        $path_selection = $selection->file_selection;
        $path_fptk = $selection->file_fptk;

        if ($request->hasFile('file_selection')) {
            $file = $request->file('file_selection');
            $extension = $file->getClientOriginalExtension();
            $file_name = 'file_selection_'.$data['name'].'_'.time().'.'.$extension; // Construct the file name
            $data['file_selection'] = $file->storeAs('files/selection/file_selection', $file_name, 'public_local'); // Store the file
            // delete selection
            if ($path_selection != null || $path_selection != '') {
                Storage::disk('public_local')->delete($path_selection);
            }
        } else {
            $data['file_selection'] = $path_selection;
        }

        if ($request->hasFile('file_fptk')) {
            $file = $request->file('file_fptk');
            $extension = $file->getClientOriginalExtension();
            $file_name = 'file_fptk_'.$data['name'].'_'.time().'.'.$extension; // Construct the file name
            $data['file_fptk'] = $file->storeAs('files/fptk/file_fptk', $file_name, 'public_local'); // Store the file
            // delete fptk
            if ($path_fptk != null || $path_fptk != '') {
                Storage::disk('public_local')->delete($path_fptk);
            }
        } else {
            $data['file_fptk'] = $path_fptk;
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
        $request->validate([
            'selected_option' => 'required',
            'file_selection' => 'nullable|mimes:pdf|max:2048',
        ], [
            'selected_option.required' => 'Wajib diisi.',
            'file_selection.mimes' => 'File seleksi harus berupa PDF.',
            'file_selection.max' => 'Ukuran file seleksi tidak boleh lebih dari 2MB.',
        ]);

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

        $path_selection = $selection->file_selection;

        if ($request->hasFile('file_selection')) {
            $file = $request->file('file_selection');
            $extension = $file->getClientOriginalExtension();
            $file_name = 'file_selection_'.time().'.'.$extension; // Construct the file name
            $new_file_path = $file->storeAs('files/file_selection', $file_name, 'public_local'); // Store the file

            // Delete the old file if it exists
            if (! empty($path_selection)) {
                Storage::disk('public_local')->delete($path_selection);
            }

            // Update the file path
            $path_selection = $new_file_path;
        }

        // Update the selection status
        $selection->update([
            'status' => $request->selected_option,
            'file_selection' => $path_selection, // Use the updated file path or keep the old one
            'is_finished' => true,
            'is_approve' => 1,
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
        $companyId = Auth::user()->company_id;
        $isSuperAdmin = Auth::user()->hasRole('super-admin');

        $candidates = Candidate::where('is_hire', false)->where('is_selection', false)
            ->when(! $isSuperAdmin, function ($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })->orderBy('name', 'asc');

        if (request()->ajax()) {

            $filters = [
                'name' => 'name',
                // 'dob' => 'dob',
                'gender' => 'gender',
                // 'phone_number' => 'phone_number',
                // 'applied_position' => 'applied_position',
                // 'last_educational' => 'last_educational',
                'study' => 'study',
                'disability' => 'disability',
                // 'marital_status' => 'marital_status',
                'tag' => 'tag',
            ];

            // Handle the age filter
            // if ($request->filled('age')) {
            //     $age = (int) $request->age; // Get the age from the request
            //     $startDate = Carbon::now()->subYears($age + 1)->startOfYear(); // Start of the year for the age
            //     $endDate = Carbon::now()->subYears($age)->endOfYear(); // End of the year for the age
            //     $candidates->whereBetween('dob', [$startDate, $endDate]);
            // }

            // Handle the age filter
            if ($request->filled('age')) {
                $ageFilter = $request->age;

                if ($ageFilter === '<20') {
                    // Age less than 20
                    $startDate = Carbon::now()->subYears(20)->startOfYear();
                    $candidates->where('dob', '>', $startDate);
                } elseif ($ageFilter === '>50') {
                    // Age greater than 50
                    $endDate = Carbon::now()->subYears(50)->endOfYear();
                    $candidates->where('dob', '<', $endDate);
                } elseif (preg_match('/^(\d+)-(\d+)$/', $ageFilter, $matches)) {
                    // Age range (e.g., 20-25)
                    $startAge = (int) $matches[1];
                    $endAge = (int) $matches[2];

                    $startDate = Carbon::now()->subYears($endAge + 1)->startOfYear();
                    $endDate = Carbon::now()->subYears($startAge)->endOfYear();

                    $candidates->whereBetween('dob', [$startDate, $endDate]);
                }
            }

            if ($request->filled('marital_status')) {
                $candidates->where('marital_status', 'like', $request->marital_status);
            }

            if ($request->filled('last_educational')) {
                $candidates->where('last_educational', 'like', $request->last_educational);
            }

            foreach ($filters as $requestKey => $dbColumn) {
                if ($request->filled($requestKey)) {
                    $candidates->where($dbColumn, 'like', '%'.$request->$requestKey.'%');
                }
            }


            return DataTables::of($candidates)
                ->addIndexColumn()
                ->addColumn('action', function ($item) {
                    return '
                        <div class="btn-group mb-1">
                            <button type="button" class="btn btn-sm btn-primary"
                                    onclick="addCandidate('.$item->id.', \''.$item->name.'\')">
                                Pilih
                            </button>
                        </div>
                        ';
                })
                ->editColumn('photo', function ($item) {
                    if ($item->photo) {
                        return ' <div class="fixed-frame">
                    <img src="'.asset('storage/'.$item->photo).'" data-fancybox alt="Icon User"
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
    
                        return $ageYears.' Tahun '.$ageMonths.' Bulan';
                    }
                    return 'N/A'; // Return 'N/A' if dob is not available
                })->editColumn('selectionCount', function ($item) {

                    return '<a href="'.route('selection.getCandidateHistory', $item->id).'" target="_blank">'.$item->selectedCandidates->count().'</a>';
                })
                ->rawColumns(['action', 'photo', 'selectionCount'])
                ->toJson();
        }
    }

    public function updateApprovalStatus(Request $request, $id)
    {
        $request->validate([
            'is_approve' => 'required|in:0,1,2,3',
        ]);

        $selection = Selection::findOrFail($id);

        DB::transaction(function () use ($selection, $request) {
            $selection->is_approve = $request->input('is_approve');
            $selection->save();

            if ($selection->is_approve == 3) {
                foreach ($selection->selectedCandidates as $selectedCandidate) {
                    if ($selectedCandidate->position_id && $selectedCandidate->is_approve === null) {
                        Approval::create([
                            'company_id' => $selection->company_id,
                            'selected_candidate_id' => $selectedCandidate->id,
                            'employee_career_id' => null,
                            'position_id' => $selectedCandidate->position_id,
                            'is_approve' => null,
                            'description' => 'Karyawan Baru',
                        ]);
                    }
                }
            } elseif ($selection->is_approve == 0) {
                foreach ($selection->selectedCandidates as $selectedCandidate) {
                    $selectedCandidate->update([
                        'is_approve' => 0,
                        'is_hire' => 0,
                    ]);

                    Candidate::where('id', $selectedCandidate->candidate_id)
                        ->update(['is_selection' => 0, 'is_hire' => 0]);
                }
            }
        });

        $message = $selection->is_approve ? 'Selection successfully approved.' : 'Selection successfully rejected.';

        return redirect()->back()->with('success', $message);
    }


    public function getCandidateHistory($id)
    {
        $candidate = Candidate::findOrFail($id);

        return view('pages.recruitment.selection.candidate-history-selection', compact('candidate'));
    }

    // public function storeHistory(Request $request, $selection)
    // {
    //     $request->validate([
    //         'date' => 'required|date',
    //         'name' => 'required|string|max:255',
    //         'description' => 'nullable|',
    //     ], [
    //         'name.required' => 'Proses wajib diisi.',
    //         'date.required' => 'Tanggal wajib diisi.',
    //         'name.string' => 'Proses harus berupa teks.',
    //         'name.max' => 'Proses tidak boleh lebih dari 255 karakter.',
    //     ]);


    //     $requestData = array_merge($request->all(), [
    //         'selection_id' => $selection,
    //     ]);

    //     HistorySelection::create($requestData);

    //     // Redirect back with success message
    //     return redirect()->back()->with('success', 'Data has been created successfully!');

    // }
    // public function deleteHistory()
    // {
    //     // $candidateSkill->delete();
    //     // return redirect()->back()->with('success', 'Data has been deleted successfully!');

    // }

}
