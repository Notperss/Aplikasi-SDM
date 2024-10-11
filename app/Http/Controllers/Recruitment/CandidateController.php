<?php

namespace App\Http\Controllers\Recruitment;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Recruitment\Candidate;
use Illuminate\Support\Facades\Storage;
use App\Models\Recruitment\CandidateSkill;
use App\Models\Recruitment\CandidateDocument;
use App\Models\Recruitment\CandidateFamilyDetail;
use App\Models\Recruitment\CandidateTrainingAttended;
use App\Models\Recruitment\CandidateEmploymentHistory;
use App\Models\Recruitment\CandidateEducationalHistory;
use App\Http\Requests\Recruitment\StoreCandidateRequest;
use App\Models\Recruitment\CandidateLanguageProficiency;
use App\Http\Requests\Recruitment\UpdateCandidateRequest;
use App\Models\Recruitment\CandidateSocialPlatform;

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

        // $fileFields = ['photo', 'file_cv', 'file_ktp', 'file_kk', 'file_skck'];
        // // upload process here
        // foreach ($fileFields as $fileField) {
        //     if ($request->hasFile($fileField)) {
        //         $extension = $data[$fileField]->getClientOriginalExtension();
        //         $data[$fileField] = $request->file($fileField)->storeAs('files/' . $fileFields, $fileFields . '_' . $data['name'] . '_' . time() . '.' . $extension, 'public_local');
        //     }
        // }

        $file_fields = [
            'photo',
            'file_cv',
            'file_ktp',
            'file_kk',
            'file_skck',
            'file_vaksin',
            'file_surat_sehat',
            'file_sim_a',
            'file_sim_b',
            'file_sim_c',
        ];

        foreach ($file_fields as $file_field) {
            if ($request->hasFile($file_field)) {
                $file = $request->file($file_field); // Get the file
                $extension = $file->getClientOriginalExtension(); // Get file extension
                $file_name = $file_field . '_' . $data['name'] . '_' . time() . '.' . $extension; // Construct the file name
                $data[$file_field] = $file->storeAs('files/candidate/' . $file_field, $file_name, 'public_local'); // Store the file
            }
        }


        $candidate = Candidate::create($data);

        // return redirect()->route('additional-details', $candidate)->with('success', 'Candidate has been created successfully!');
        return redirect()->route('candidate.show', $candidate)->with('success', 'Candidate has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Candidate $candidate)
    {
        return view('pages.recruitment.candidate.show', compact('candidate', ));
        // $dob = Carbon::parse($candidate->dob);
        // $ageInYears = $dob->age;
        // $ageInMonths = $dob->diffInMonths(Carbon::now()) % 12; // Modulo to get remaining months
        // return view('pages.recruitment.candidate.show', compact('candidate', 'ageInYears', 'ageInMonths'));
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

        // upload
        // if ($request->hasFile('photo')) {
        //     $extension = $data['photo']->getClientOriginalExtension();
        //     $data['photo'] = $request->file('photo')->storeAs('kandidat_foto', 'foto' . '_' . $data['name'] . '_' . time() . '.' . $extension, 'public_local');
        //     // delete photo
        //     if ($path_photo != null || $path_photo != '') {
        //         Storage::disk('public_local')->delete($path_photo);
        //     }
        // } else {
        //     $data['photo'] = $path_photo;
        // }

        $file_fields = [
            'photo',
            'file_cv',
            'file_ktp',
            'file_kk',
            'file_skck',
            'file_vaksin',
            'file_surat_sehat',
            'file_sim_a',
            'file_sim_b',
            'file_sim_c',
        ];

        foreach ($file_fields as $file_field) {
            $path_file = $candidate->$file_field;

            if ($request->hasFile($file_field)) {
                $file = $request->file($file_field);
                $extension = $file->getClientOriginalExtension();
                $file_name = $file_field . '_' . $data['name'] . '_' . time() . '.' . $extension;

                $data[$file_field] = $file->storeAs('files/candidate/' . $file_field, $file_name, 'public_local');

                if (! empty($path_file)) {
                    Storage::disk('public_local')->delete($path_file);
                }
            } else {
                $data[$file_field] = $path_file;
            }
        }

        $candidate->update($data);
        return redirect()->back()->with('success', 'Candidate has been updated successfully!');
        // return redirect()->route('candidate.index')->with('success', 'Candidate has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Candidate $candidate)
    {
        $file_fields = [
            'photo',
            'file_cv',
            'file_ktp',
            'file_kk',
            'file_skck',
            'file_vaksin',
            'file_surat_sehat',
            'file_sim_a',
            'file_sim_b',
            'file_sim_c',
        ];

        foreach ($file_fields as $file_field) {
            $file_path = $candidate->$file_field;

            if (! empty($file_path)) {
                Storage::disk('public_local')->delete($file_path);
            }
        }

        $candidate->delete();

        return back()->with('success', 'Candidate has been deleted successfully!');
    }


    public function additionalDetails(Candidate $candidate)
    {
        $familyDetails = CandidateFamilyDetail::where('candidate_id', $candidate->id)->get();
        $employmentHistories = CandidateEmploymentHistory::where('candidate_id', $candidate->id)->get();
        $educationalHistories = CandidateEducationalHistory::where('candidate_id', operator: $candidate->id)->get();
        $languageProficiencies = CandidateLanguageProficiency::where('candidate_id', $candidate->id)->get();
        $trainingAttendeds = CandidateTrainingAttended::where('candidate_id', $candidate->id)->get();
        $skills = CandidateSkill::where('candidate_id', $candidate->id)->get();
        $socialPlatforms = CandidateSocialPlatform::where('candidate_id', $candidate->id)->get();
        // $candidateDocuments = CandidateDocument::where('candidate_id', $candidate->id)->get();
        $ijazahDocuments = CandidateDocument::where('candidate_id', $candidate->id)->where('type_document', 'ijazah')->get();
        $ktpDocuments = CandidateDocument::where('candidate_id', $candidate->id)->where('type_document', 'ktp')->get();
        $skckDocuments = CandidateDocument::where('candidate_id', $candidate->id)->where('type_document', 'skck')->get();
        $aktaDocuments = CandidateDocument::where('candidate_id', $candidate->id)->where('type_document', 'akta-kk')->get();
        $cvDocuments = CandidateDocument::where('candidate_id', $candidate->id)->where('type_document', 'CV')->get();

        return view('pages.recruitment.candidate.additional-details',
            compact(
                'candidate',
                'familyDetails',
                'employmentHistories',
                'educationalHistories',
                'languageProficiencies',
                'trainingAttendeds',
                'skills',
                'socialPlatforms',
                'ijazahDocuments',
                'ktpDocuments',
                'skckDocuments',
                'aktaDocuments',
                'cvDocuments',
                // 'candidateDocuments',
            ));
    }

    public function uploadDocument(Request $request, $candidate)
    {
        // Validate the PDF and other fields
        $data = $request->validate([
            'file' => 'mimes:pdf|max:512', // Max file size: 2MB
            'type_document' => 'required|max:255', // Type of document
            // 'candidate_id' => 'required|exists:candidates,id', // Ensure candidate exists
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
                // 'candidate_name' => $data['candidate_name'],
            ]);
        } else {
            // If the document does not exist, create a new entry
            CandidateDocument::create([
                'candidate_id' => $candidate,
                'file' => $path_file,
                'type_document' => $data['type_document'],
                // 'candidate_name' => $data['candidate_name'],
            ]);
        }

        // Return success message
        return back()->with('success', 'Candidate document has been uploaded or updated successfully!');
    }
}
