<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Position\LevelController;
use App\Http\Controllers\WorkUnit\SectionController;
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
use App\Http\Controllers\Recruitment\CandidateSkillController;
use App\Http\Controllers\ManagementAccess\PermissionController;
use App\Http\Controllers\Recruitment\SelectedCandidateController;
use App\Http\Controllers\Recruitment\CandidateFamilyDetailController;
use App\Http\Controllers\Recruitment\CandidateSocialPlatformController;
use App\Http\Controllers\Recruitment\CandidateTrainingAttendedController;
use App\Http\Controllers\Recruitment\CandidateEmploymentHistoryController;
use App\Http\Controllers\Recruitment\CandidateEducationalHistoryController;
use App\Http\Controllers\Recruitment\CandidateLanguageProficiencyController;

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
    Route::resource('activity-log', ActivityLogController::class)->only('index');

    Route::resource('candidate', CandidateController::class);
    Route::prefix('candidate')->group(function () {
        Route::get('additional-details/{candidate}', [CandidateController::class, 'additionalDetails'])->name('additional-details');
        Route::post('/upload/{candidate}', [CandidateController::class, 'uploadDocument'])->name('upload.document');
    });

    Route::resource('selection', SelectionController::class)->only('index', 'edit', 'store', 'update', 'destroy');
    Route::patch('/selection/{id}/restore', [SelectionController::class, 'restore'])->name('selection.restore');
    Route::patch('selection/{selection}/close', [SelectionController::class, 'closeSelection'])->name('selection.close');
    Route::get('get-candidate', [SelectionController::class, 'getCandidate'])->name('selection.getCandidate');

    Route::patch('/selection/{id}/update-approval', [SelectionController::class, 'updateApprovalStatus'])->name('selection.updateApprovalStatus');



    Route::resource('selectedCandidate', SelectedCandidateController::class)->only('store', 'show', 'edit', 'update', 'destroy');
    Route::post('/selection/store/{selection}', [SelectedCandidateController::class, 'addCandidate'])->name('selectedCandidate.addCandidate');
    Route::get('selectedCandidate/{selection}/selection-result', [SelectedCandidateController::class, 'resultSelection'])->name('selectedCandidate.resultSelection');
    Route::get('/hired-candidates', [SelectedCandidateController::class, 'hiredCandidates'])->name('selectedCandidate.hiredCandidates');
    // Route::patch('/selectedCandidate/approve/{id}', [SelectedCandidateController::class, 'approve'])->name('selectedCandidate.approve');
    // Route::patch('/selectedCandidate/reject/{id}', [SelectedCandidateController::class, 'reject'])->name('selectedCandidate.reject');

    Route::patch('/selected-candidate/{id}/update-approval', [SelectedCandidateController::class, 'updateApprovalStatus'])->name('selectedCandidate.updateApprovalStatus');



    // Route::post('/selection/store-candidate/{selection}', [SelectionController::class, 'storeCandidate'])->name('selection.storeCandidate');
    // Route::delete('/selection/destroy-candidate/{selectedCandidate}', [SelectionController::class, 'destroyCandidate'])->name('selection.destroyCandidate');





    Route::resource('candidateFamilyDetail', CandidateFamilyDetailController::class)->only('store', 'update', 'destroy');
    Route::resource('candidateEmploymentHistory', CandidateEmploymentHistoryController::class)->only('store', 'update', 'destroy');
    Route::resource('candidateEducationalHistory', CandidateEducationalHistoryController::class)->only('store', 'update', 'destroy');
    Route::resource('candidateLanguageProficiency', CandidateLanguageProficiencyController::class)->only('store', 'update', 'destroy');
    Route::resource('candidateTrainingAttended', CandidateTrainingAttendedController::class)->only('store', 'update', 'destroy');
    Route::resource('candidateSkill', CandidateSkillController::class)->only('store', 'update', 'destroy');
    Route::resource('candidateSocialPlatform', CandidateSocialPlatformController::class)->only('store', 'update', 'destroy');

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
    Route::resource('position', PositionController::class)->only('index', 'store', 'update', 'destroy', 'getSections', 'positionAllowance');
    Route::get('get-sections', [PositionController::class, 'getSections'])->name('getSections');
    Route::put('/positions/{position}', [PositionController::class, 'positionAllowance'])->name('positionAllowance');

    //Employee
    Route::resource('employee', EmployeeController::class);
    Route::get('/new-employee/{id}', [EmployeeController::class, 'newEmployee'])->name('employee.newEmployee');

    Route::resource('employeeCategory', EmployeeCategoryController::class)->only('index', 'store', 'update', 'destroy');



});


require __DIR__ . '/auth.php';
