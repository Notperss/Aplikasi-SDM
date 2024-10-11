<?php

namespace App\Http\Controllers\Position;

use Illuminate\Http\Request;
use App\Models\Position\Level;
use App\Models\Position\Allowance;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AllowanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $allowances = Allowance::where('allowances.company_id', Auth::user()->company_id)
            ->join('levels', 'allowances.level_id', '=', 'levels.id') // Join the levels table
            ->orderBy('type', 'asc') // Order by the levels.name
            ->orderBy('natura', 'asc') // Order by the levels.name
            ->orderBy('levels.name', 'asc') // Order by the levels.name
            ->with('level') // Load the level relationship for eager loading
            ->select('allowances.*') // Select positions columns only
            ->get();

        // $allowances = Allowance::where('company_id', Auth::user()->company_id)->latest()->get();
        $levels = Level::where('company_id', Auth::user()->company_id)->latest()->get();

        return view('pages.position.allowance.index', compact('allowances', 'levels'));
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
            'amount' => 'required|int',
            'type' => 'required',
        ], [
            // Custom error messages
            'name.required' => 'Tunjangan wajib diisi.',
            'amount.required' => 'Jumlah wajib diisi.',
            'name.max' => 'Tunjangan tidak boleh lebih dari 255 karakter.',
        ]);
        $company_id = Auth::user()->company_id;
        $requestData = array_merge($request->all(), ['company_id' => $company_id]);
        Allowance::create($requestData);

        return redirect()->back()->with('success', 'Data has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Allowance $allowance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Allowance $allowance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Allowance $allowance)
    {
        // Validation rules
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|int',
            'type' => 'required',
        ], [
            // Custom error messages
            'name.required' => 'Tunjangan wajib diisi.',
            'amount.required' => 'Jumlah wajib diisi.',
            'name.max' => 'Tunjangan tidak boleh lebih dari 255 karakter.',
        ]);
        $allowance->update($request->all());
        return redirect()->back()->with('success', 'Data has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Allowance $allowance)
    {
        $allowance->delete();
        return redirect()->back()->with('success', 'Data has been deleted successfully!');
    }
}
