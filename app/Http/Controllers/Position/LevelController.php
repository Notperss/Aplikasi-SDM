<?php

namespace App\Http\Controllers\Position;

use Illuminate\Http\Request;
use App\Models\Position\Level;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $levels = Level::where('company_id', Auth::user()->company_id)->latest()->get();

        return view('pages.position.level.index', compact('levels'));
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
        // Validation rules
        $request->validate([
            'name' => 'required|string|max:255',
        ], [
            // Custom error messages
            'name.required' => 'Nama wajib diisi.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
        ]);
        $company_id = Auth::user()->company_id;
        $requestData = array_merge($request->all(), ['company_id' => $company_id]);
        Level::create($requestData);

        return redirect()->back()->with('success', 'Data has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Level $level)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Level $level)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Level $level)
    {
        // Validation rules
        $request->validate([
            'name' => 'required|string|max:255',
        ], [
            // Custom error messages
            'name.required' => 'Nama wajib diisi.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
        ]);
        $level->update($request->all());
        return redirect()->back()->with('success', 'Data has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Level $level)
    {
        $level->delete();
        return redirect()->back()->with('success', 'Data has been deleted successfully!');
    }
}
