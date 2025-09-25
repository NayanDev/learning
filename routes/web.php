<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
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
});