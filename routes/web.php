<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\WorkshopController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'auth']], function () {
    // Route Department
    Route::resource('department', DepartmentController::class);
    Route::get('department-api', [DepartmentController::class, 'indexApi'])->name('department.listapi');
    Route::get('department-export-pdf-default', [DepartmentController::class, 'exportPdf'])->name('department.export-pdf-default');
    Route::get('department-export-excel-default', [DepartmentController::class, 'exportExcel'])->name('department.export-excel-default');
    Route::post('department-import-excel-default', [DepartmentController::class, 'importExcel'])->name('department.import-excel-default');

    // Route Employee
    Route::resource('employee', EmployeeController::class);
    Route::get('employee-api', [EmployeeController::class, 'indexApi'])->name('employee.listapi');
    Route::get('employee-export-pdf-default', [EmployeeController::class, 'exportPdf'])->name('employee.export-pdf-default');
    Route::get('employee-export-excel-default', [EmployeeController::class, 'exportExcel'])->name('employee.export-excel-default');
    Route::post('employee-import-excel-default', [EmployeeController::class, 'importExcel'])->name('employee.import-excel-default');

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
    // Route Export Jadwal Training
    Route::get('training-export-jadwal', [TrainingController::class, 'exporJadwalPdf'])->name('training.export-jadwal-pdf');
});