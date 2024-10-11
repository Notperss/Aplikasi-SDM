<?php

namespace App\Http\Controllers\Recruitment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Recruitment\StoreCandidateLanguageProficiencyRequest;
use App\Http\Requests\Recruitment\UpdateCandidateLanguageProficiencyRequest;
use App\Models\Recruitment\CandidateLanguageProficiency;
use Illuminate\Http\Request;

class CandidateLanguageProficiencyController extends Controller
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
    public function store(StoreCandidateLanguageProficiencyRequest $request)
    {
        CandidateLanguageProficiency::create($request->all());
        return redirect()->back()->with('success', 'Data has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(CandidateLanguageProficiency $candidateLanguageProficiency)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CandidateLanguageProficiency $candidateLanguageProficiency)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCandidateLanguageProficiencyRequest $request, CandidateLanguageProficiency $candidateLanguageProficiency)
    {
        $candidateLanguageProficiency->update($request->all());
        return redirect()->back()->with('success', 'Data has been updated successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CandidateLanguageProficiency $candidateLanguageProficiency)
    {
        $candidateLanguageProficiency->delete();
        return redirect()->back()->with('success', 'Data has been deleted successfully!');
    }
}
