<?php

namespace App\Http\Controllers\Recruitment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Recruitment\Candidate;
use Illuminate\Support\Facades\Storage;
use App\Models\Recruitment\FamilyDetail;
use App\Models\Recruitment\EmploymentHistory;
use App\Models\Recruitment\EducationalHistory;
use App\Models\Recruitment\LanguageProficiency;
use App\Http\Requests\Recruitment\StoreCandidateRequest;
use App\Http\Requests\Recruitment\UpdateCandidateRequest;
use App\Models\Recruitment\CandidateDocument;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $candidates = Candidate::latest()->get();
        return view('pages.recruitment.candidate.index', compact('candidates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.recruitment.candidate.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCandidateRequest $request)
    {
        $data = $request->all();
        // upload process here
        if ($request->hasFile('photo')) {
            $extension = $data['photo']->getClientOriginalExtension();
            $data['photo'] = $request->file('photo')->storeAs('Foto Kandidat', 'kandidat' . '_' . $data['name'] . '_' . time() . '.' . $extension, 'public_local');
        }
        $candidate = Candidate::create($data);

        return redirect()->route('additional-details', $candidate)->with('success', 'Candidate has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Candidate $candidate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Candidate $candidate)
    {
        return view('pages.recruitment.candidate.edit', compact('candidate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCandidateRequest $request, Candidate $candidate)
    {
        $data = $request->all();
        $path_photo = $candidate->photo;

        // upload
        if ($request->hasFile('photo')) {
            $extension = $data['photo']->getClientOriginalExtension();
            $data['photo'] = $request->file('photo')->storeAs('Foto Kandidat', 'kandidat' . '_' . $data['name'] . '_' . time() . '.' . $extension, 'public_local');
            // delete photo
            if ($path_photo != null || $path_photo != '') {
                Storage::disk('public_local')->delete($path_photo);
            }
        } else {
            $data['photo'] = $path_photo;
        }
        $candidate->update($data);
        return redirect()->route('candidate.index')->with('success', 'Candidate has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Candidate $candidate)
    {
        $candidate->delete();

        return back()->with('success', 'Candidate has been deleted successfully!');
    }
    public function additionalDetails(Candidate $candidate)
    {
        $familyDetails = FamilyDetail::where('candidate_id', $candidate->id)->get();
        $employmentHistories = EmploymentHistory::where('candidate_id', $candidate->id)->get();
        $educationalHistories = EducationalHistory::where('candidate_id', operator: $candidate->id)->get();
        $languageProficiencies = LanguageProficiency::where('candidate_id', $candidate->id)->get();
        $candidateDocuments = CandidateDocument::where('candidate_id', $candidate->id)->get();

        return view('pages.recruitment.candidate.additional-details',
            compact(
                'candidate',
                'familyDetails',
                'employmentHistories',
                'educationalHistories',
                'languageProficiencies',
                'candidateDocuments',
            ));
    }

    public function uploadDocument(Request $request, $candidate)
    {
        // Validate the PDF and other fields
        $data = $request->validate([
            'file' => 'mimes:pdf|max:512', // Max file size: 2MB
            'type_document' => 'required|max:255', // Type of document
            'candidate_id' => 'required|exists:candidates,id', // Ensure candidate exists
            'candidate_name' => 'required|max:255', // Candidate name
        ], [
            'file.mimes' => 'File harus berupa PDF.',
            'file.max' => 'Ukuran file maksimal adalah 500KB.',
        ]);

        // Fetch the existing document (if any)
        $candidateDocument = CandidateDocument::where('candidate_id', $candidate)
            ->where('type_document', $data['type_document'])
            ->first();

        $path_file = $candidateDocument ? $candidateDocument->file : null; // Get the existing file path if it exists

        // Check if a new file is uploaded
        if ($request->hasFile('file')) {
            $extension = $request->file('file')->getClientOriginalExtension();
            $filename = $data['type_document'] . '_' . $data['candidate_name'] . '_' . time() . '.' . $extension;

            // Upload and store the new file in the 'kandidat_[type_document]' directory using the 'public_local' disk
            $data['file'] = $request->file('file')->storeAs('kandidat_' . $data['type_document'], $filename, 'public_local');

            // If the old file exists, delete it
            if ($path_file) {
                Storage::disk('public_local')->delete($path_file);
            }

            // Set the new file path in the data array
            $path_file = $data['file'];
        }

        // Check if the document exists; if it does, update; if not, create a new document
        if ($candidateDocument) {
            $candidateDocument->update([
                'file' => $path_file, // Update with the new file path
                'type_document' => $data['type_document'],
                'candidate_name' => $data['candidate_name'],
            ]);
        } else {
            // If the document does not exist, create a new entry
            CandidateDocument::create([
                'candidate_id' => $candidate,
                'file' => $path_file,
                'type_document' => $data['type_document'],
                'candidate_name' => $data['candidate_name'],
            ]);
        }

        // Return success message
        return back()->with('success', 'Candidate document has been uploaded or updated successfully!');
    }
}
