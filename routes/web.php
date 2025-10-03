<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\WorkshopController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TrainingAnalystController;
use App\Http\Controllers\TrainingDetailController;
use App\Http\Controllers\TrainingNeedController;
use App\Http\Controllers\TrainingNeedParticipantController;
use App\Http\Controllers\TrainingScheduleController;
use App\Http\Controllers\TrainingUnplannedController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'authenticate'])->middleware('web');
Route::get('/', [AuthController::class, 'login'])->name('login')->middleware('web');

Route::group(['middleware' => ['web', 'auth']], function () {
    // Route Users
    Route::resource('user', UserController::class);
    Route::get('user-api', [UserController::class, 'indexApi'])->name('user.listapi');

    // Route Department
    // Route::resource('department', DepartmentController::class);
    // Route::get('department-api', [DepartmentController::class, 'indexApi'])->name('department.listapi');
    // Route::get('department-export-pdf-default', [DepartmentController::class, 'exportPdf'])->name('department.export-pdf-default');
    // Route::get('department-export-excel-default', [DepartmentController::class, 'exportExcel'])->name('department.export-excel-default');
    // Route::post('department-import-excel-default', [DepartmentController::class, 'importExcel'])->name('department.import-excel-default');

    // Route Employee
    // Route::resource('employee', EmployeeController::class);
    // Route::get('employee-api', [EmployeeController::class, 'indexApi'])->name('employee.listapi');
    // Route::get('employee-export-pdf-default', [EmployeeController::class, 'exportPdf'])->name('employee.export-pdf-default');
    // Route::get('employee-export-excel-default', [EmployeeController::class, 'exportExcel'])->name('employee.export-excel-default');
    // Route::post('employee-import-excel-default', [EmployeeController::class, 'importExcel'])->name('employee.import-excel-default');

    // Route Workshop
    Route::resource('workshop', WorkshopController::class);
    Route::get('workshop-api', [WorkshopController::class, 'indexApi'])->name('workshop.listapi');
    Route::get('workshop-export-pdf-default', [WorkshopController::class, 'exportPdf'])->name('workshop.export-pdf-default');
    Route::get('workshop-export-excel-default', [WorkshopController::class, 'exportExcel'])->name('workshop.export-excel-default');
    Route::post('workshop-import-excel-default', [WorkshopController::class, 'importExcel'])->name('workshop.import-excel-default');

    // Route Training
    Route::resource('training', TrainingController::class);
    Route::get('training-api', [TrainingController::class, 'indexApi'])->name('training.listapi');
    Route::get('training-export-pdf-default', [TrainingController::class, 'exportPdf'])->name('training.export-pdf-default');
    Route::get('training-export-excel-default', [TrainingController::class, 'exportExcel'])->name('training.export-excel-default');
    Route::post('training-import-excel-default', [TrainingController::class, 'importExcel'])->name('training.import-excel-default');

    // Route Training Details
    Route::resource('training-detail', TrainingDetailController::class);
    Route::get('training-detail-api', [TrainingDetailController::class, 'indexApi'])->name('training-detail.listapi');
    Route::get('training-detail-export-pdf-default', [TrainingDetailController::class, 'exportPdf'])->name('training-detail.export-pdf-default');
    Route::get('training-detail-export-excel-default', [TrainingDetailController::class, 'exportExcel'])->name('training-detail.export-excel-default');
    Route::post('training-detail-import-excel-default', [TrainingDetailController::class, 'importExcel'])->name('training-detail.import-excel-default');

    // Route Training Analyst
    Route::resource('training-analyst', TrainingAnalystController::class);
    Route::get('training-analyst-api', [TrainingAnalystController::class, 'indexApi'])->name('training-analyst.listapi');
    Route::get('training-analyst-export-pdf-default', [TrainingAnalystController::class, 'exportPdf'])->name('training-analyst.export-pdf-default');
    Route::get('training-analyst-export-excel-default', [TrainingAnalystController::class, 'exportExcel'])->name('training-analyst.export-excel-default');
    Route::post('training-analyst-import-excel-default', [TrainingAnalystController::class, 'importExcel'])->name('training-analyst.import-excel-default');
    // Route Custome in Training Analyst 
    Route::post('training-analyst/save-all', [TrainingAnalystController::class, 'saveAll'])->name('training-analyst.saveAll');
    Route::get('training-analyst-pdf', [TrainingAnalystController::class, 'generatePDF'])->name('training-analyst.pdf');
    Route::get('training-analyst-form', [TrainingAnalystController::class, 'trainingForm'])->name('training-analyst.form');

    // Route Training Needs
    Route::resource('training-need', TrainingNeedController::class);
    Route::get('training-need-api', [TrainingNeedController::class, 'indexApi'])->name('training-need.listapi');
    Route::get('training-need-export-pdf-default', [TrainingNeedController::class, 'exportPdf'])->name('training-need.export-pdf-default');
    Route::get('training-need-export-excel-default', [TrainingNeedController::class, 'exportExcel'])->name('training-need.export-excel-default');
    Route::post('training-need-import-excel-default', [TrainingNeedController::class, 'importExcel'])->name('training-need.import-excel-default');

    // Route Training Needs Participant
    Route::resource('training-need-participant', TrainingNeedParticipantController::class);
    Route::get('training-need-participant-api', [TrainingNeedParticipantController::class, 'indexApi'])->name('training-need-participant.listapi');
    Route::get('training-need-participant-export-pdf-default', [TrainingNeedParticipantController::class, 'exportPdf'])->name('training-need-participant.export-pdf-default');
    Route::get('training-need-participant-export-excel-default', [TrainingNeedParticipantController::class, 'exportExcel'])->name('training-need-participant.export-excel-default');
    Route::post('training-need-participant-import-excel-default', [TrainingNeedParticipantController::class, 'importExcel'])->name('training-need-participant.import-excel-default');

    // Route Training Schedule
    Route::resource('training-schedule', TrainingScheduleController::class);
    Route::get('training-schedule-api', [TrainingScheduleController::class, 'indexApi'])->name('training-schedule.listapi');
    Route::get('training-schedule-export-pdf-default', [TrainingScheduleController::class, 'exportPdf'])->name('training-schedule.export-pdf-default');
    Route::get('training-schedule-export-excel-default', [TrainingScheduleController::class, 'exportExcel'])->name('training-schedule.export-excel-default');
    Route::post('training-schedule-import-excel-default', [TrainingScheduleController::class, 'importExcel'])->name('training-schedule.import-excel-default');

    // Route Training Unplanned
    Route::resource('training-unplanned', TrainingUnplannedController::class);
    Route::get('training-unplanned-api', [TrainingUnplannedController::class, 'indexApi'])->name('training-unplanned.listapi');
    Route::get('training-unplanned-export-pdf-default', [TrainingUnplannedController::class, 'exportPdf'])->name('training-unplanned.export-pdf-default');
    Route::get('training-unplanned-export-excel-default', [TrainingUnplannedController::class, 'exportExcel'])->name('training-unplanned.export-excel-default');
    Route::post('training-unplanned-import-excel-default', [TrainingUnplannedController::class, 'importExcel'])->name('training-unplanned.import-excel-default');
});
