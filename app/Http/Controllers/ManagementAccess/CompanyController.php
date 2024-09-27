<?php

namespace App\Http\Controllers\ManagementAccess;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ManagementAccess\StoreCompanyRequest;
use App\Http\Requests\ManagementAccess\UpdateCompanyRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\ManagementAccess\Company;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::latest()->get();
        return view('management-access.company.index', compact('companies'));
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
    public function store(StoreCompanyRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $file_name = 'logo_' . $data['name'] . '_' . time() . '.' . $extension;
            $data['logo'] = $file->storeAs('files/logo', $file_name, 'public_local');

        }
        Company::create($data);
        return redirect()->back()->with('success', 'Data has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $data = $request->all();
        $path_logo = $company->logo;

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $file_name = 'logo_' . $data['name'] . '_' . time() . '.' . $extension; // Construct the file name
            $data['logo'] = $file->storeAs('files/logo', $file_name, 'public_local'); // Store the file
            // delete old file
            if ($path_logo != null || $path_logo != '') {
                Storage::disk('public_local')->delete($path_logo);
            }
        } else {
            $data['file'] = $path_logo;
        }
        $company->update($data);
        return redirect()->back()->with('success', 'Data has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        // $path_logo = $company->logo;

        // if ($path_logo != null || $path_logo != '') {
        //     Storage::disk('public_local')->delete($path_logo);
        // }
        $company->delete();
        return redirect()->back()->with('success', 'Data has been deleted successfully!');
    }
}
