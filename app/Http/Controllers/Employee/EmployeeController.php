<?php

namespace App\Http\Controllers\Employee;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Employee\Employee;
use App\Models\Position\Position;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Recruitment\Candidate;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Employee\EmployeeCategory;
use App\Models\Recruitment\SelectedCandidate;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::latest();

        if (request()->ajax()) {
            return DataTables::of($employees)
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
                      <a class="dropdown-item" href="' . route('employee.edit', $item) . '">Edit</a>
                        <button class="dropdown-item" onclick=" showSweetAlert(' . $item->id . ') ">Hapus</button>
                        <form id="deleteForm_' . $item->id . '"
                          action="' . route('employee.destroy', $item->id) . '" method="POST">
                          ' . method_field('delete') . csrf_field() . '
                        </form>
                    </div>
                  </div>
                </div>
                    ';
                })->editColumn('photo', function ($item) {
                    if ($item->photo) {
                        return ' <div class="fixed-frame">
                    <img src="' . asset('storage/' . $item->photo) . '" data-fancybox alt="Icon User"
                      class="framed-image" style="cursor: pointer">
                  </div>';
                    } else {
                        return 'No Image';
                    }
                })->editColumn('created_at', function ($item) {
                    return '' . Carbon::parse($item->created_at)->translatedFormat('d F Y') . '';
                })
                ->rawColumns(['action', 'photo'])
                ->toJson();
        }


        return view('pages.employee.index', compact('employees'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $positions = Position::orderBy('name', 'asc')->get();
        $employeeCategories = EmployeeCategory::orderBy('name', 'asc')->get();
        return view('pages.employee.create', compact('positions', 'employeeCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->except('is_hire');

        $company_id = Auth::user()->company_id;

        $requestData = array_merge($data, [
            'company_id' => $company_id,
        ]);

        $file_fields = [
            'photo',
            'file_cv',
            'file_ktp',
            'file_ijazah',
            'file_kk',
            'file_skck',
            'file_vaksin',
            'file_surat_sehat',
            'file_sertifikat',
            'file_sim_a',
            'file_sim_b',
            'file_sim_c',
        ];

        foreach ($file_fields as $file_field) {
            if ($request->hasFile($file_field)) {
                $file = $request->file($file_field); // Get the file
                $extension = $file->getClientOriginalExtension(); // Get file extension
                $file_name = $file_field . '_' . $data['name'] . '_' . time() . '.' . $extension; // Construct the file name
                $data[$file_field] = $file->storeAs('files/employee/' . $file_field, $file_name, 'public_local'); // Store the file
            }
        }

        Employee::create($requestData);

        return redirect()->route('employee.index')->with('success', 'Data has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //
    }

    public function newEmployee($id)
    {
        try {
            $decrypt = decrypt($id);
            $selectedCandidate = SelectedCandidate::findOrFail($decrypt);
        } catch (DecryptException $e) {
            abort(404, 'Invalid payload');
        } catch (ModelNotFoundException $e) {
            abort(404, 'Selected candidate not found');
        }

        $candidate = Candidate::find($selectedCandidate->candidate_id);

        // dd($candidate->employee);

        if (! $candidate->employee) {
            Employee::create([
                // "nik" => 000000,

                'position_id' => $selectedCandidate->position_id,
                'date_joining' => now(),

                'candidate_id' => $candidate->id,



                "company_id" => $candidate->company_id ?? null,
                "name" => $candidate->name ?? null,
                "photo" => $candidate->photo ?? null,
                "email" => $candidate->email ?? null,
                "phone_number1" => $candidate->phone_number ?? null,
                "ktp_address" => $candidate->ktp_address ?? null,
                "current_address" => $candidate->current_address ?? null,
                "npwp_number" => $candidate->npwp_number ?? null,
                "ktp_number" => $candidate->ktp_number ?? null,
                "kk_number" => $candidate->kk_number ?? null,
                "religion" => $candidate->religion ?? null,
                "nationality" => $candidate->nationality ?? null,
                "height" => $candidate->height ?? null,
                "weight" => $candidate->weight ?? null,
                "dob" => $candidate->dob ?? null,
                "pob" => $candidate->pob ?? null,
                "gender" => $candidate->gender ?? null,
                "date_applied" => $candidate->date_applied ?? null,
                "file_cv" => $candidate->file_cv ?? null,
                "file_kk" => $candidate->file_kk ?? null,
                "file_ktp" => $candidate->file_ktp ?? null,
                "file_skck" => $candidate->file_skck ?? null,
                "blood_type" => $candidate->blood_type ?? null,
                "ethnic" => $candidate->ethnic ?? null,
                "candidate_from" => $candidate->candidate_from ?? null,
                "applied_position" => $candidate->applied_position ?? null,
                "recommended_position" => $candidate->recommended_position ?? null,
                "marital_status" => $candidate->marital_status ?? null,
                "paspor_number" => $candidate->paspor_number ?? null,
                "file_vaksin" => $candidate->file_vaksin ?? null,
                "file_surat_sehat" => $candidate->file_surat_sehat ?? null,
                "longitude_ktp" => $candidate->longitude_ktp ?? null,
                "latitude_ktp" => $candidate->latitude_ktp ?? null,
                "longitude_domisili" => $candidate->longitude_domisili ?? null,
                "latitude_domisili" => $candidate->latitude_domisili ?? null,
                "sim_a" => $candidate->sim_a ?? null,
                "expired_sim_a" => $candidate->expired_sim_a ?? null,
                "file_sim_a" => $candidate->file_sim_a ?? null,
                "sim_b" => $candidate->sim_b ?? null,
                "expired_sim_b" => $candidate->expired_sim_b ?? null,
                "file_sim_b" => $candidate->file_sim_b ?? null,
                "sim_c" => $candidate->sim_c ?? null,
                "expired_sim_c" => $candidate->expired_sim_c ?? null,
                "file_sim_c" => $candidate->file_sim_c ?? null,
                "last_educational" => $candidate->last_educational ?? null,
                "study" => $candidate->study ?? null,
                "file_sertifikat" => $candidate->file_sertifikat ?? null,
                "file_ijazah" => $candidate->file_ijazah ?? null,
                "reference" => $candidate->reference ?? null,
                "disability" => $candidate->disability ?? null,
                "is_hire" => $candidate->is_hire ?? null,
                "is_selection" => $candidate->is_selection ?? null,
                "tag" => $candidate->tag ?? null,
            ]);

            $selectedCandidate->is_hire = 1;

            $selectedCandidate->save();
        }


        $positions = Position::where('id', $selectedCandidate->position_id)->latest()->get();

        $employeeCategories = EmployeeCategory::latest()->get();

        return view('pages.employee.new-employee', compact('selectedCandidate', 'candidate', 'positions', 'employeeCategories'));
    }
}
