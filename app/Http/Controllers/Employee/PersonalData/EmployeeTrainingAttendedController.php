<?php

namespace App\Http\Controllers\Employee\PersonalData;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Exports\TrainingExport;
use App\Models\Employee\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Employee\PersonalData\EmployeeTrainingAttended;
use App\Http\Requests\Employee\PersonalData\StoreTrainingAttendedRequest;
use App\Http\Requests\Employee\PersonalData\UpdateTrainingAttendedRequest;


class EmployeeTrainingAttendedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $employeeTrainingAttended = EmployeeTrainingAttended::with('employee')
            ->when(! Auth::user()->hasRole('super-admin'), function ($query) {
                $query->whereHas('employee', function ($query) {
                    $query->where('company_id', Auth::user()->company_id);
                });
            })
            ->where('is_certificated', 0)
            ->latest();

        if ($request->filled(['start_date', 'end_date'])) {
            $employeeTrainingAttended->whereBetween('end_date', [$request->start_date, $request->end_date]);
        }


        if (request()->ajax()) {
            return DataTables::of($employeeTrainingAttended)
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
                        
                            <a class="dropdown-item" href="'.route('employeeTrainingAttended.edit', $item).'">Edit</a>
                            
                            <button class="dropdown-item" onclick="deleteTrainingAttend('.$item->id.')">Hapus</button>
                            <form id="deleteTrainingAttendForm_'.$item->id.'"
                                action="'.route('employeeTrainingAttended.destroy', $item->id).'"
                                method="POST">
                                '.method_field('delete').csrf_field().'
                            </form>
                        </div>
                    </div>
                </div>
            ';
                })->editColumn('file', function ($item) {
                    if ($item->file_sertifikat) {
                        return '<a class="btn btn-sm btn-primary" href="'.asset('storage/'.$item->file_sertifikat).'" target="_blank" > Lihat </a>';
                    } else {
                        return '<span> - </span>';
                    }
                })->editColumn('start_date', function ($item) {
                    return $item->start_date ? Carbon::parse($item->start_date)->translatedFormat('d-m-Y') : ' ';
                })->editColumn('end_date', function ($item) {
                    return $item->end_date ? Carbon::parse($item->end_date)->translatedFormat('d-m-Y') : ' ';
                })
                ->rawColumns(['action', 'file', 'start_date', 'end_date'])
                ->toJson();
        }

        // dd($request->all());

        // $employees = Employee::where('employee_status', 'AKTIF')->where('is_verified', true)->orderBy('name', 'asc')->get();
        $employees = Employee::with('position', 'position.division')->where('employee_status', 'AKTIF')->orderBy('name', 'asc')->get();

        return view('pages.employee.training-attended.index', compact('employeeTrainingAttended', 'employees'));
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
    public function store(StoreTrainingAttendedRequest $request)
    {

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Handle file upload for certificate (if present)
            $file_path = null;  // Initialize file path variable

            if ($request->hasFile('file_sertifikat')) {
                $file = $request->file('file_sertifikat');
                $extension = $file->getClientOriginalExtension();
                $file_name = 'file_sertifikat_pelatihan_'.time().'.'.$extension; // Generate a unique file name
                $file_path = $file->storeAs('files/employee/file_sertifikat_pelatihan', $file_name, 'public_local');
            }

            if ($request->employees) {
                // Loop through employees to create training records
                foreach ($request->employees as $employeeData) {
                    // Ensure employeeData is the employee ID
                    $employeeId = $employeeData['id'];

                    // Create the training record for each employee
                    EmployeeTrainingAttended::create([
                        'employee_id' => $employeeId, // Use employee ID
                        'training_name' => $request->training_name,
                        'organizer_name' => $request->organizer_name,
                        'city' => $request->city,
                        'expired_certificate_date' => $request->expired_certificate_date,
                        'start_date' => $request->start_date,
                        'end_date' => $request->end_date,
                        'file_sertifikat' => $file_path, // Attach file path if the certificate is uploaded
                        'is_certificated' => $request->is_certificated ?? 0, // Attach file path if the certificate is uploaded
                    ]);
                }
            } else {
                // Create the training record for each employee
                EmployeeTrainingAttended::create([
                    'employee_id' => $request->employee_id, // Use employee ID
                    'training_name' => $request->training_name,
                    'organizer_name' => $request->organizer_name,
                    'city' => $request->city,
                    'expired_certificate_date' => $request->expired_certificate_date,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'file_sertifikat' => $file_path, // Attach file path if the certificate is uploaded
                    'is_certificated' => $request->is_certificated ?? 0, // Attach file path if the certificate is uploaded
                ]);
            }

            // Commit the transaction
            DB::commit();

            // Redirect with a success message
            return redirect()->back()
                ->with('success', 'Data seminar/pelatihan berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Rollback the transaction if something goes wrong
            DB::rollback();

            // Log the error for debugging
            Log::error('Error storing training: '.$e->getMessage());

            // Redirect back with an error message
            return redirect()->back()
                ->withInput($request->all())
                ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeTrainingAttended $employeeTrainingAttended)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeTrainingAttended $employeeTrainingAttended)
    {
        return view('pages.employee.training-attended.edit', compact('employeeTrainingAttended'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTrainingAttendedRequest $request, EmployeeTrainingAttended $employeeTrainingAttended)
    {
        $data = $request->all();
        $path_sertifikat = $employeeTrainingAttended->file_sertifikat;

        if ($request->hasFile('file_sertifikat')) {
            $file = $request->file('file_sertifikat');
            $extension = $file->getClientOriginalExtension();
            $file_name = 'file_sertifikat_pelatihan_'.time().'.'.$extension; // Construct the file name
            $data['file_sertifikat'] = $file->storeAs('files/employee/file_sertifikat_pelatihan', $file_name, 'public_local'); // Store the file
            // delete sertifikat
            if ($path_sertifikat != null || $path_sertifikat != '') {
                Storage::disk('public_local')->delete($path_sertifikat);
            }
        } else {
            $data['file_sertifikat'] = $path_sertifikat;
        }
        $employeeTrainingAttended->update($data);
        return redirect()->back()->with('success', 'Data has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeTrainingAttended $employeeTrainingAttended)
    {
        $path_sertifikat = $employeeTrainingAttended->file_sertifikat;

        if ($path_sertifikat != null || $path_sertifikat != '') {
            Storage::disk('public_local')->delete($path_sertifikat);
        }
        $employeeTrainingAttended->delete();
        return redirect()->back()->with('success', 'Data has been deleted successfully!');
    }

    public function trainingExport(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        return Excel::download(new TrainingExport($startDate, $endDate), 'TrainingExports.xlsx');


    }
}
