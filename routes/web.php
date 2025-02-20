<?php

use App\Exports\AgeExport;
use Illuminate\Http\Request;
use App\Exports\GenderExport;
use App\Exports\PositionExport;
use App\Exports\ReligionExport;
use App\Exports\ApprovalLogExport;
use App\Exports\EducationalExport;
use App\Exports\EmployeeInOutExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use App\Exports\DivisionEmployeeExport;
use App\Exports\EmployeeCategoryExport;
use App\Exports\EmployeeRetirementExport;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Position\LevelController;
use App\Http\Controllers\WorkUnit\SectionController;
use App\Http\Controllers\Approval\ApprovalController;
use App\Http\Controllers\Employee\ContractController;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\Position\PositionController;
use App\Http\Controllers\WorkUnit\DivisionController;
use App\Http\Controllers\Position\AllowanceController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\WorkUnit\DepartmentController;
use App\Http\Controllers\WorkUnit\DirectorateController;
use App\Http\Controllers\ManagementAccess\RoleController;
use App\Http\Controllers\ManagementAccess\UserController;
use App\Http\Controllers\Recruitment\CandidateController;
use App\Http\Controllers\Recruitment\SelectionController;
use App\Http\Controllers\ManagementAccess\RouteController;
use App\Http\Controllers\ManagementAccess\CompanyController;
use App\Http\Controllers\Employee\EmployeeCategoryController;
use App\Http\Controllers\ManagementAccess\MenuItemController;
use App\Http\Controllers\ManagementAccess\MenuGroupController;
use App\Http\Controllers\ManagementAccess\PermissionController;
use App\Http\Controllers\Recruitment\HistorySelectionController;
use App\Http\Controllers\FolderDivision\FolderDivisionController;
use App\Http\Controllers\Recruitment\SelectedCandidateController;
use App\Http\Controllers\Employee\PersonalData\EmployeeKpiController;
use App\Http\Controllers\Employee\PersonalData\EmployeeDutyController;
use App\Http\Controllers\Employee\PersonalData\EmployeeAwardController;
use App\Http\Controllers\Employee\PersonalData\EmployeePhotoController;
use App\Http\Controllers\Employee\PersonalData\EmployeeSkillController;
use App\Http\Controllers\Employee\PersonalData\EmployeeCareerController;
use App\Http\Controllers\Employee\PersonalData\EmployeeSanctionController;
use App\Http\Controllers\Employee\PersonalData\EmployeeJobHistoryController;
use App\Http\Controllers\Employee\PersonalData\EmployeeFamilyDetailController;
use App\Http\Controllers\Employee\PersonalData\EmployeeSocialPlatformController;
use App\Http\Controllers\Recruitment\PersonalData\CandidateJobHistoryController;
use App\Http\Controllers\Employee\PersonalData\EmployeeTrainingAttendedController;
use App\Http\Controllers\Employee\PersonalData\EmployeeEducationalHistoryController;
use App\Http\Controllers\Employee\PersonalData\EmployeeLanguageProficiencyController;
use App\Http\Controllers\FolderDivision\BoxNumberController;

// Route::permanentRedirect('/', '/login');

Route::get('/', function () {
    // cek apakah sudah login atau belum
    if (Auth::user() != null) {
        return redirect()->intended('/dashboard');
    }
    return view('auth.login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['middleware' => ['web', 'auth', 'role:super-admin', 'verified',]], function () {
    Route::resource('user', UserController::class)->only('index', 'store', 'update', 'destroy');
    Route::resource('route', RouteController::class)->only('index', 'store', 'update', 'destroy');
    Route::resource('permission', PermissionController::class)->only('index', 'store', 'update', 'destroy');
    Route::resource('role', RoleController::class)->only('index', 'store', 'update', 'destroy');
    Route::resource('menu', MenuGroupController::class)->only('index', 'store', 'update', 'destroy');
    Route::resource('menu.item', MenuItemController::class)->only('index', 'store', 'update', 'destroy');
    Route::resource('company', CompanyController::class)->only('index', 'store', 'update', 'destroy');
});

Route::group(['middleware' => ['web', 'auth', 'verified',]], function () {
    Route::resource('dashboard', DashboardController::class)->only('index', );
    Route::get('division/{id}', [DashboardController::class, 'getDivisionEmployee'])->name('getDivisionEmployee');
    // Route::get('/filter-data-approvals', [DashboardController::class, 'filterData'])->name('filter.approval');
    Route::get('/employee-chart-data/{year}', [DashboardController::class, 'getEmployeeChartData'])->name('employee-chart-data');

    Route::get('/dashboard/employee-category', [DashboardController::class, 'employeeCategory'])->name('dashboard.employeeCategory');
    Route::get('/dashboard/employee-gender', [DashboardController::class, 'gender'])->name('dashboard.gender');
    Route::get('/dashboard/employee-educational', [DashboardController::class, 'educational'])->name('dashboard.educational');
    Route::get('/dashboard/employee-level-position', [DashboardController::class, 'position'])->name('dashboard.position');
    Route::get('/dashboard/employee-age', [DashboardController::class, 'age'])->name('dashboard.age');
    Route::get('/dashboard/employee-religion', [DashboardController::class, 'religion'])->name('dashboard.religion');

    Route::get('/approval/log', [DashboardController::class, 'approvalLog'])->name('approval.log');


    Route::get('/employee-in-out', [DashboardController::class, 'employeeInOut'])->name('employeeInOut');
    Route::get('/employee-retirement', [DashboardController::class, 'employeeRetirement'])->name('employeeRetirement');
    Route::get('/employee-in-per-month', [DashboardController::class, 'employeeDataPerMonth'])->name('employeeDataPerMonth');

    // Route::get('/employees-by-level', [DashboardController::class, 'getEmployeesByLevel']);
    Route::get('/employees-by-level-and-division', [DashboardController::class, 'getEmployeesByLevelAndDivision'])->name('getEmployeesByLevelAndDivision');


    // Route::get('/employee-out-per-month', [DashboardController::class, 'employeeOutMonth'])->name('employeeOutMonth');
    // Route::get('/employee-out-per-year', [DashboardController::class, 'employeeOutYear'])->name('employeeOutYear');
    // Route::get('/employee-in-per-year', [DashboardController::class, 'employeeInYear'])->name('employeeInYear');
    // Route::get('/employee-retirement', [DashboardController::class, 'employeeRetirement'])->name('employeeRetirement');


    Route::resource('activity-log', ActivityLogController::class)->only('index');

    Route::resource('candidate', CandidateController::class);
    Route::prefix('candidate')->group(function () {
        Route::get('additional-details/{candidate}', [CandidateController::class, 'additionalDetails'])->name('additional-details');
        Route::post('/upload/{candidate}', [CandidateController::class, 'uploadDocument'])->name('upload.document');
        Route::post('/export-candidates', [CandidateController::class, 'export'])->name('export.candidates');
    });

    Route::resource('selection', SelectionController::class)->except('create');
    Route::patch('/selection/{id}/restore', [SelectionController::class, 'restore'])->name('selection.restore');
    Route::patch('selection/{selection}/close', [SelectionController::class, 'closeSelection'])->name('selection.close');
    Route::get('get-candidate', [SelectionController::class, 'getCandidate'])->name('selection.getCandidate');
    Route::get('candidate-history-selection/{id}', [SelectionController::class, 'getCandidateHistory'])->name('selection.getCandidateHistory');

    Route::patch('/selection/{id}/update-approval', [SelectionController::class, 'updateApprovalStatus'])->name('selection.updateApprovalStatus');

    Route::resource('selectedCandidate', SelectedCandidateController::class)->only('store', 'show', 'edit', 'update', 'destroy');
    Route::post('/selection/store/{selection}', [SelectedCandidateController::class, 'addCandidate'])->name('selectedCandidate.addCandidate');
    Route::get('selected-candidate/{selection}/selection-result', [SelectedCandidateController::class, 'resultSelection'])->name('selectedCandidate.resultSelection');
    Route::get('follow-up-candidate/{selection}/selection-result', [SelectedCandidateController::class, 'followUpSelection'])->name('followUpSelection');
    Route::get('/hired-candidates', [SelectedCandidateController::class, 'hiredCandidates'])->name('selectedCandidate.hiredCandidates');
    // Route::patch('/selectedCandidate/approve/{id}', [SelectedCandidateController::class, 'approve'])->name('selectedCandidate.approve');
    // Route::patch('/selectedCandidate/reject/{id}', [SelectedCandidateController::class, 'reject'])->name('selectedCandidate.reject');

    Route::resource('candidateJobHistory', CandidateJobHistoryController::class)->only('store', 'update', 'destroy');


    Route::patch('/selected-candidate/{id}/update-approval', [SelectedCandidateController::class, 'updateApprovalStatus'])->name('selectedCandidate.updateApprovalStatus');

    Route::resource('historySelection', HistorySelectionController::class)->only('edit', 'update', 'destroy');
    Route::post('store-history/{selection}', [HistorySelectionController::class, 'store'])->name('historySelection.store');

    // Route::post('/selection/store-candidate/{selection}', [SelectionController::class, 'storeCandidate'])->name('selection.storeCandidate');
    // Route::delete('/selection/destroy-candidate/{selectedCandidate}', [SelectionController::class, 'destroyCandidate'])->name('selection.destroyCandidate');

    Route::resource('employeeFamilyDetail', EmployeeFamilyDetailController::class)->only('store', 'update', 'destroy');
    Route::resource('employeeJobHistory', EmployeeJobHistoryController::class)->only('store', 'update', 'destroy');
    Route::resource('employeeEducationalHistory', EmployeeEducationalHistoryController::class)->only('store', 'update', 'destroy');
    Route::resource('employeeLanguageProficiency', EmployeeLanguageProficiencyController::class)->only('store', 'update', 'destroy');
    Route::resource('employeeTrainingAttended', EmployeeTrainingAttendedController::class)->only('index', 'edit', 'store', 'update', 'destroy');
    Route::get('employeeTrainingAttended/export', [EmployeeTrainingAttendedController::class, 'trainingExport'])->name('employeeTrainingAttended.export');

    Route::resource('employeeSkill', EmployeeSkillController::class)->only('store', 'update', 'destroy');
    Route::resource('employeeSocialPlatform', EmployeeSocialPlatformController::class)->only('store', 'update', 'destroy');
    Route::resource('employeeKpi', EmployeeKpiController::class)->only('index', 'edit', 'store', 'update', 'destroy');
    Route::get('employeeKpi/export', [EmployeeKpiController::class, 'kpiExport'])->name('employeeKpi.export');

    Route::resource('employeeDuty', EmployeeDutyController::class)->only('index', 'edit', 'store', 'update', 'destroy');
    Route::get('employeeDuty/export', [EmployeeDutyController::class, 'dutyExport'])->name('employeeDuty.export');

    Route::resource('employeeCareer', EmployeeCareerController::class)->only('store', 'update', 'destroy');
    Route::resource('employeeAward', EmployeeAwardController::class)->only('index', 'edit', 'store', 'update', 'destroy');
    Route::get('employeeAward/export', [EmployeeAwardController::class, 'awardExport'])->name('employeeAward.export');

    Route::resource('employeePhoto', EmployeePhotoController::class)->only('store', 'update', 'destroy');
    Route::resource('employeeSanction', EmployeeSanctionController::class)->only('store', 'update', 'destroy');

    Route::get('approval-list', [EmployeeCareerController::class, 'indexApproval'])->name('indexApproval');
    Route::patch('/{id}/update-approval', [EmployeeCareerController::class, 'updateApprovalStatus'])->name('updateApprovalStatus');
    Route::get('/export-employees', [EmployeeController::class, 'exportEmployees'])->name('employee.export');



    //workUnit
    Route::resource('directorate', DirectorateController::class)->only('index', 'store', 'update', 'destroy');
    Route::resource('division', DivisionController::class)->only('index', 'store', 'update', 'destroy');
    Route::resource('department', DepartmentController::class)->only('index', 'store', 'update', 'destroy', 'getDivisions');
    Route::get('get-divisions', [DepartmentController::class, 'getDivisions'])->name('getDivisions');
    Route::resource('section', SectionController::class)->only('index', 'store', 'update', 'destroy', 'getDepartments');
    Route::get('get-departments', [SectionController::class, 'getDepartments'])->name('getDepartments');

    //position
    Route::resource('level', LevelController::class)->only('index', 'store', 'update', 'destroy', );
    Route::resource('allowance', AllowanceController::class)->only('index', 'store', 'update', 'destroy', );
    Route::resource('position', PositionController::class)->only('index', 'edit', 'store', 'update', 'destroy');
    Route::get('add-allowances/{position}', [PositionController::class, 'addAllowances'])->name('addAllowances');
    Route::get('get-sections', [PositionController::class, 'getSections'])->name('getSections');
    Route::put('/positions/{position}', [PositionController::class, 'positionAllowance'])->name('positionAllowance');

    //Employee
    Route::resource('employee', EmployeeController::class);
    Route::get('/new-employee/{id}', [EmployeeController::class, 'newEmployee'])->name('employee.newEmployee');
    Route::put('/update-new-employee/{id}', [EmployeeController::class, 'updateNewEmployee'])->name('employee.updateNewEmployee');
    Route::get('/employee-attendance', [EmployeeController::class, 'getEmployeeAttendances'])->name('employee.attendances');
    Route::get('export-attendance', [EmployeeController::class, 'attendanceExport'])->name('export.attendanceEmployee');
    Route::post('upload-photo', [EmployeeController::class, 'uploadPhoto'])->name('employee.uploadPhoto');
    Route::patch('/employee/{employee}/verified', [EmployeeController::class, 'verify'])->name('employee.verified');
    Route::patch('/employee/{employee}/unverified', [EmployeeController::class, 'unverified'])->name('employee.unverified');



    Route::resource('employeeCategory', EmployeeCategoryController::class)->only('index', 'store', 'update', 'destroy');
    Route::resource('contract', ContractController::class)->only('index', 'store', 'edit', 'update', 'destroy');
    Route::post('import-contract', [ContractController::class, 'importContract'])->name('contract.import');
    Route::put('lock-contract/{id}', [ContractController::class, 'lockContract'])->name('contract.lock');
    Route::get('export-contract-expired', [ContractController::class, 'contractExportExpired'])->name('contract.exportExpired');
    Route::get('export-contract', [ContractController::class, 'contractExport'])->name('contract.export');

    Route::get('/contracts/expired', [ContractController::class, 'getExpiredContracts'])->name('contracts.expired');

    Route::resource('approval', ApprovalController::class)->only('index', 'store', 'update', 'destroy', );
    Route::get('/form-update-status/{id}', [ApprovalController::class, 'formUpdateStatus'])->name('approval.formUpdateStatus');
    Route::put('/update-status/{id}', [ApprovalController::class, 'updateStatus'])->name('approval.updateStatus');
    Route::get('/new-employee-index', [ApprovalController::class, 'newEmployeeIndex'])->name('approval.newEmployeeIndex');


    Route::get('/export-gender', function () {
        $directorates = App\Models\WorkUnit\Directorate::with('divisions.positions.employee')->get();
        return Excel::download(new GenderExport($directorates), 'JenisKelaminExport.xlsx');
    });

    Route::get('/export-employees-categories', function () {
        return Excel::download(new EmployeeCategoryExport(), 'KategoriKaryawanExport.xlsx');
    });

    Route::get('/export-positions', function () {
        return Excel::download(new PositionExport(), 'JabatanExport.xlsx');
    });

    Route::get('/export-ages', function () {
        return Excel::download(new AgeExport(), 'UsiaExport.xlsx');
    });

    Route::get('/export-religions', function () {
        return Excel::download(new ReligionExport(), 'AgamaExport.xlsx');
    });

    Route::get('/export-employee-in-out', function (Request $request) {
        return Excel::download(new EmployeeInOutExport($request), 'EmployeeInOutExport.xlsx');
    });

    Route::get('/export-division-employee/{id}', function ($id) {
        return Excel::download(new DivisionEmployeeExport($id), 'DivisionEmployeeExport.xlsx');
    });

    Route::get('/export-educational', function () {
        $directorates = App\Models\WorkUnit\Directorate::with(['divisions.positions.employee'])->get();
        return Excel::download(new EducationalExport($directorates), 'educationExport.xlsx');
    });

    Route::get('/export-approval-log', function (Request $request) {
        $type = $request->input('type');
        $year = $request->input('year', now()->year);

        return Excel::download(new ApprovalLogExport($type, $year), 'ApprovalLogExport.xlsx');
    })->name('export.approvalLog');

    Route::get('/export-retirement', function () {
        $status = request('status');
        $additionalYears = $status === 'Karyawan Yang Akan Pensiun' ? 3 : 0;

        return Excel::download(new EmployeeRetirementExport($additionalYears), 'masa_pensiun.xlsx');
    })->name('exportRetirement');

    // Route::get('/export-positions', function () {
    //     $directorates = App\Models\WorkUnit\Directorate::with(['divisions.positions.employee'])->get();
    //     return Excel::download(new PositionExport($directorates), 'educationExport.xlsx');
    // });
    Route::resource('folder', FolderDivisionController::class);

    Route::controller(FolderDivisionController::class)->group(function () {
        Route::post('/folder/form', 'form_upload')->name('folder.form_upload');
        Route::post('/folder/upload', 'upload')->name('folder.upload');
        Route::delete('/folder/{id}/delete_file', 'delete_file')->name('folder.delete_file');
        Route::get('/lock-folder/{id}', 'lockFolder')->name('lockFolder');
        Route::get('/lock-folder-file/{id}', 'lockFolderFile')->name('lockFolderFile');
        Route::put('/move/{id}', 'moveFile')->name('folder.moveFile');
        // Route::get('/send-mail', 'sendMails')->name('sendMails');
    });

    Route::resource('boxNumber', BoxNumberController::class)->except('index');
    Route::get('/box-number', [BoxNumberController::class, 'index'])->name('boxNumber.index');
});


require __DIR__.'/auth.php';
