<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Position\LevelController;
use App\Http\Controllers\Recruitment\SkillController;
use App\Http\Controllers\WorkUnit\DivisionController;
use App\Http\Controllers\Position\AllowanceController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Employee\EmployeeCategoryController;
use App\Http\Controllers\WorkUnit\DepartmentController;
use App\Http\Controllers\WorkUnit\DirectorateController;
use App\Http\Controllers\ManagementAccess\RoleController;
use App\Http\Controllers\ManagementAccess\UserController;
use App\Http\Controllers\Recruitment\CandidateController;
use App\Http\Controllers\ManagementAccess\RouteController;
use App\Http\Controllers\ManagementAccess\CompanyController;
use App\Http\Controllers\Recruitment\FamilyDetailController;
use App\Http\Controllers\ManagementAccess\MenuItemController;
use App\Http\Controllers\ManagementAccess\MenuGroupController;
use App\Http\Controllers\ManagementAccess\PermissionController;
use App\Http\Controllers\Position\PositionController;
use App\Http\Controllers\Recruitment\TrainingAttendedController;
use App\Http\Controllers\Recruitment\EmploymentHistoryController;
use App\Http\Controllers\Recruitment\EducationalHistoryController;
use App\Http\Controllers\Recruitment\LanguageProficiencyController;
use App\Http\Controllers\WorkUnit\SectionController;

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
    Route::resource('candidate', CandidateController::class);
    Route::prefix('candidate')->group(function () {
        Route::get('additional-details/{candidate}', [CandidateController::class, 'additionalDetails'])->name('additional-details');
        Route::post('/upload/{candidate}', [CandidateController::class, 'uploadDocument'])->name('upload.document');
    });
    Route::resource('familyDetails', FamilyDetailController::class);
    Route::resource('employmentHistory', EmploymentHistoryController::class);
    Route::resource('educationalHistory', EducationalHistoryController::class);
    Route::resource('languageProficiency', LanguageProficiencyController::class);
    Route::resource('trainingAttended', TrainingAttendedController::class);
    Route::resource('skill', SkillController::class);

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
    Route::resource('employeeCategory', EmployeeCategoryController::class)->only('index', 'store', 'update', 'destroy');


});


require __DIR__ . '/auth.php';
