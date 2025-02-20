<?php

namespace App\Http\Controllers\FolderDivision;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\FolderDivision\BoxNumber;

class BoxNumberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $boxNumbers = BoxNumber::where('company_id', Auth::user()->company_id)->latest()->get();

        return view('pages.folder-division.box-number.index', compact('boxNumbers'));
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
            'box_number' => 'required|string|max:255',
            'description' => 'nullable',
        ], [
            // Custom error messages
            'box_number.required' => 'Nomor Box wajib diisi.',
            'box_number.max' => 'Nomor Box tidak boleh lebih dari 255 karakter.',
        ]);
        $company_id = Auth::user()->company_id;
        $requestData = array_merge($request->all(), ['company_id' => $company_id]);
        BoxNumber::create($requestData);

        return redirect()->back()->with('success', 'Data has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(BoxNumber $boxNumber)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BoxNumber $boxNumber)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BoxNumber $boxNumber)
    {
        // Validation rules
        $request->validate([
            'box_number' => 'required|string|max:255',
            'description' => 'nullable',
        ], [
            // Custom error messages
            'box_number.required' => 'Nomor Box wajib diisi.',
            'box_number.max' => 'Nomor Box tidak boleh lebih dari 255 karakter.',
        ]);
        $boxNumber->update($request->all());
        return redirect()->back()->with('success', 'Data has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BoxNumber $boxNumber)
    {
        $boxNumber->delete();
        return redirect()->back()->with('success', 'Data has been deleted successfully!');
    }
}
