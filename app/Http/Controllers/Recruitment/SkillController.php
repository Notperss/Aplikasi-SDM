<?php

namespace App\Http\Controllers\Recruitment;

use App\Http\Controllers\Controller;
use App\Models\Recruitment\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
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
        // Define validation rules
        $request->validate([
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama keterampilan wajib diisi.',
            'name.string' => 'Nama keterampilan harus berupa teks.',
            'name.max' => 'Nama keterampilan tidak boleh lebih dari 255 karakter.',
        ]);

        // Create the new skill record
        Skill::create($request->all());

        // Redirect back with success message
        return redirect()->back()->with('success', 'Data has been created successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Skill $skill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Skill $skill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Skill $skill)
    {
        // Define validation rules
        $request->validate([
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama keterampilan wajib diisi.',
            'name.string' => 'Nama keterampilan harus berupa teks.',
            'name.max' => 'Nama keterampilan tidak boleh lebih dari 255 karakter.',
        ]);

        $skill->update($request->all());
        return redirect()->back()->with('success', 'Data has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skill $skill)
    {
        $skill->delete();
        return redirect()->back()->with('success', 'Data has been deleted successfully!');
    }
}
