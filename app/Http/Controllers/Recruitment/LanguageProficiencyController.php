<?php

namespace App\Http\Controllers\Recruitment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Recruitment\StoreLanguageProficiencyRequest;
use App\Http\Requests\Recruitment\UpdateLanguageProficiencyRequest;
use App\Models\Recruitment\LanguageProficiency;
use Illuminate\Http\Request;

class LanguageProficiencyController extends Controller
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
    public function store(StoreLanguageProficiencyRequest $request)
    {
        LanguageProficiency::create($request->all());
        return redirect()->back()->with('success', 'Data has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(LanguageProficiency $languageProficiency)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LanguageProficiency $languageProficiency)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLanguageProficiencyRequest $request, LanguageProficiency $languageProficiency)
    {
        $languageProficiency->update($request->all());
        return redirect()->back()->with('success', 'Data has been updated successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LanguageProficiency $languageProficiency)
    {
        $languageProficiency->delete();
        return redirect()->back()->with('success', 'Data has been deleted successfully!');
    }
}
