<?php

namespace App\Http\Controllers\Recruitment;

use App\Http\Controllers\Controller;
use App\Models\Recruitment\HistorySelection;
use Illuminate\Http\Request;

class HistorySelectionController extends Controller
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
    public function store(Request $request, $selection)
    {
        $request->validate([
            'date' => 'required|date',
            'name_process' => 'required|string|max:255',
            'description' => 'nullable|',
        ], [
            'name_process.required' => 'Proses wajib diisi.',
            'date.required' => 'Tanggal wajib diisi.',
            'name_process.string' => 'Proses harus berupa teks.',
            'name_process.max' => 'Proses tidak boleh lebih dari 255 karakter.',
        ]);


        $requestData = array_merge($request->all(), [
            'selection_id' => $selection,
        ]);

        HistorySelection::create($requestData);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Data has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(HistorySelection $historySelection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HistorySelection $historySelection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HistorySelection $historySelection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HistorySelection $historySelection)
    {
        $historySelection->delete();
        return redirect()->back()->with('success', 'Data has been deleted successfully!');
    }
}
