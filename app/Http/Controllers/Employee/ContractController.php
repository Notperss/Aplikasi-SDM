<?php

namespace App\Http\Controllers\Employee;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Imports\ImportContract;
use App\Models\Employee\Contract;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Employee\StoreContractRequest;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contracts = Contract::with('employee')->where('company_id', Auth::user()->company_id)->latest();


        if (request()->ajax()) {
            return DataTables::of($contracts)
                ->addIndexColumn()
                ->addColumn('action', function ($item) {
                    return '
                    <div class="btn-group mb-1">
                  <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle me-1" type="button" id="dropdownMenuButton"
                      data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                     
                     <a class="dropdown-item" href="' . route('contract.edit', $item) . '">
                     Edit
                    </a>
                        <button class="dropdown-item" onclick=" showSweetAlert(' . $item->id . ') ">Hapus</button>
                        <form id="deleteForm_' . $item->id . '"
                          action="' . route('contract.destroy', $item->id) . '" method="POST">
                          ' . method_field('delete') . csrf_field() . '
                        </form>
                    </div>
                  </div>
                </div>

                    ';

                })->editColumn('start_date', function ($item) {
                    return '' . Carbon::parse($item->start_date)->translatedFormat('l, d F Y') . '';
                })->editColumn('end_date', function ($item) {
                    return '' . Carbon::parse($item->end_date)->translatedFormat('l, d F Y') . '';
                })->editColumn('name_employee', function ($item) {
                    return $item->employee->name;
                })->editColumn('file', function ($item) {
                    if ($item->file) {
                        return '<a class="btn btn-sm btn-primary" href="' . asset('storage/' . $item->file) . '" target="_blank" > Lihat </a>';
                    } else {
                        return '<span> - </span>';
                    }
                })
                ->rawColumns(['name_employee', 'file'])
                ->toJson();
        }

        return view('pages.employee.contract.index', compact('contracts'));
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
    public function store(StoreContractRequest $request)
    {
        $data = $request->all();
        $company_id = Auth::user()->company_id;

        if ($request->hasFile('file')) {
            $file = $request->file('file'); // Get the file from the request
            $extension = $file->getClientOriginalExtension(); // Get the file extension
            $file_name = 'file_kontrak' . time() . '.' . $extension; // Construct the file name
            $data['file'] = $file->storeAs('files/employee/file_kontrak', $file_name, 'public_local'); // Store the file
        }

        $requestData = array_merge($data, ['company_id' => $company_id]);

        Contract::create($requestData);

        return redirect()->back()->with('success', 'Data has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contract $contract)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contract $contract)
    {
        return view('pages.employee.contract.edit', compact('contract'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreContractRequest $request, Contract $contract)
    {
        $data = $request->all();
        $path_file = $contract->file;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $file_name = 'file_kontrak' . time() . '.' . $extension; // Construct the file name
            $data['file'] = $file->storeAs('files/employee/file_kontrak', $file_name, 'public_local'); // Store the file
            // delete file
            if ($path_file != null || $path_file != '') {
                Storage::disk('public_local')->delete($path_file);
            }
        } else {
            $data['file'] = $path_file;
        }
        $contract->update($data);
        return redirect()->back()->with('success', 'Data has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contract $contract)
    {
        $path_file = $contract->file;

        if ($path_file != null || $path_file != '') {
            Storage::disk('public_local')->delete($path_file);
        }
        $contract->delete();

        return redirect()->back()->with('success', 'Data has been deleted successfully!');
    }

    public function importContract(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx',
        ], [
            'file.required' => 'File tidak boleh kosong.',
            'file.mimes' => 'Extension Harus csv,xls,xlsx',
        ]);

        Excel::import(new ImportContract, $request->file);

        if ($request->hasFile('file')) {
            $file = $request->file('file'); // Get the file
            $extension = $file->getClientOriginalExtension(); // Get the file extension
            $file_name = 'file_import_contract_' . date('H-i-s_d-m-Y') . '.' . $extension;


            // Store the file and get the storage path
            $file_path = $file->storeAs('files/import/contract', $file_name, 'public_local');
        }

        // Use the stored path in the Excel import

        return redirect()->back()->with('success', 'Imported successfully!');

    }

    public function lockContract($id)
    {

        $contract = Contract::findOrFail($id);

        if ($contract) {
            if ($contract->is_lock) {
                $contract->is_lock = false;
                $message = 'Kontrak Terbuka!';
            } else {
                $contract->is_lock = true;
                $message = 'Kontrak Terkunci!';
            }

            // dd($contract->is_lock);

            $contract->save();
            return redirect()->back()->with('success', $message);
        } else {
            return redirect()->back()->with('error', 'Gagal Melakukan Eksekusi!');
        }


    }
}
