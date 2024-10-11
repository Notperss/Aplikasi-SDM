<?php

namespace App\Http\Controllers\Recruitment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Recruitment\StoreCandidateFamilyDetailRequest;
use App\Http\Requests\Recruitment\UpdateCandidateFamilyDetailRequest;
use App\Models\Recruitment\CandidateFamilyDetail;
use Illuminate\Http\Request;

class CandidateFamilyDetailController extends Controller
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
    public function store(StoreCandidateFamilyDetailRequest $request)
    {
        CandidateFamilyDetail::create($request->all());
        return redirect()->back()->with('success', 'Data has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(CandidateFamilyDetail $candidateFamilyDetail)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CandidateFamilyDetail $candidateFamilyDetail)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCandidateFamilyDetailRequest $request, CandidateFamilyDetail $candidateFamilyDetail)
    {
        // Get the validated data from the request
        $validatedData = $request->validated();
        $validatedData['is_in_kk'] = $request->input('is_in_kk_edit');

        if ($validatedData['is_in_kk'] == 0) {
            $validatedData['is_bpjs'] = 0;
        } else {
            $validatedData['is_bpjs'] = $request->input('is_bpjs', 0);
        }

        $candidateFamilyDetail->update($validatedData);
        return redirect()->back()->with('success', 'Data has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CandidateFamilyDetail $candidateFamilyDetail)
    {
        $candidateFamilyDetail->delete();
        return redirect()->back()->with('success', 'Data has been deleted successfully!');
    }
}
