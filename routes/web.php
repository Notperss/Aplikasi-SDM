<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\ManagementAccess\RoleController;
use App\Http\Controllers\ManagementAccess\UserController;
use App\Http\Controllers\ManagementAccess\RouteController;
use App\Http\Controllers\ManagementAccess\MenuItemController;
use App\Http\Controllers\ManagementAccess\MenuGroupController;
use App\Http\Controllers\ManagementAccess\PermissionController;
use App\Http\Controllers\Recruitment\CandidateController;
use App\Http\Controllers\Recruitment\EducationalHistoryController;
use App\Http\Controllers\Recruitment\EmploymentHistoryController;
use App\Http\Controllers\Recruitment\FamilyDetailController;
use App\Http\Controllers\Recruitment\LanguageProficiencyController;
use App\Http\Controllers\Recruitment\SkillController;
use App\Http\Controllers\Recruitment\TrainingAttendedController;

Route::permanentRedirect('/', '/login');

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


});


require __DIR__ . '/auth.php';
