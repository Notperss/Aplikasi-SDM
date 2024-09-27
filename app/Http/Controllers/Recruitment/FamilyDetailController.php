<?php

namespace App\Http\Controllers\Recruitment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Recruitment\StoreFamilyDetailRequest;
use App\Models\Recruitment\FamilyDetail;
use Illuminate\Http\Request;

class FamilyDetailController extends Controller
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
    public function store(StoreFamilyDetailRequest $request)
    {
        // dd($request->all());
        FamilyDetail::create($request->all());
        return redirect()->back()->with('success', 'Data has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(FamilyDetail $familyDetail)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FamilyDetail $familyDetail)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FamilyDetail $familyDetail)
    {
        $familyDetail->update($request->all());
        return redirect()->back()->with('success', 'Data has been updated successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FamilyDetail $familyDetail)
    {
        $familyDetail->delete();
        return redirect()->back()->with('success', 'Data has been deleted successfully!');
    }
}
