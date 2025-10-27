<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\WorkshopController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\NeedWorkshopController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\TrainingAnalystController;
use App\Http\Controllers\TrainingDetailController;
use App\Http\Controllers\TrainingNeedController;
use App\Http\Controllers\TrainingNeedParticipantController;
use App\Http\Controllers\TrainingScheduleController;
use App\Http\Controllers\TrainingUnplannedController;
use App\Http\Controllers\Unplane_participantController;
use App\Http\Controllers\Unplane_workshopController;
use Illuminate\Support\Facades\Route;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\BarcodeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeTestController;
use App\Http\Controllers\EventAnswerController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\MateriLogController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\TrainingNewEmployeeController;
use App\Http\Controllers\TrainingNewParticipantController;
use App\Http\Controllers\TrainingUnplanParticipantController;
use App\Http\Controllers\UserAnswerController;

Route::post('login', [AuthController::class, 'authenticate'])->middleware('web');
Route::get('/', [AuthController::class, 'login'])->name('login')->middleware('web');

// Test generate PDF
Route::get('/nayy', function () {
    $data = [
        'nama' => 'Nayantaka',
        'tanggal' => now()->format('d M Y'),
    ];

    $pdf = Pdf::loadView('pdf.surat_perintah_pelatihan', $data)
        ->setPaper('A4', 'portrait');

    return $pdf->stream('surat-perintah-pelatihan.pdf');
});

Route::get('/test-new-employee', [TrainingNewEmployeeController::class, 'testNewEmployee'])->name('test.new.employee');
Route::get('/api/questions', [QuestionController::class, 'getQuestionsForTest'])->name('api.questions');
Route::post('/api/submit-test', [QuestionController::class, 'submitTest'])->name('api.submit-test');

Route::group(['middleware' => ['web', 'auth']], function () {
    // Route Users
    Route::resource('user', UserController::class);
    Route::get('user-api', [UserController::class, 'indexApi'])->name('user.listapi');
    Route::get('my-account', [UserController::class, 'profile']);
    Route::post('update-profile', [UserController::class, 'updateProfile']);

    // Route Dashboard
    Route::resource('dashboard', DashboardController::class);
    Route::get('dashboard-api', [DashboardController::class, 'indexApi'])->name('dashboard.listapi');
    Route::get('dashboard-export-pdf-default', [DashboardController::class, 'exportPdf'])->name('dashboard.export-pdf-default');
    Route::get('dashboard-export-excel-default', [DashboardController::class, 'exportExcel'])->name('dashboard.export-excel-default');
    Route::post('dashboard-import-excel-default', [DashboardController::class, 'importExcel'])->name('dashboard.import-excel-default');

    // Route Employee (API)
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
    // Route Custome in Training
    Route::post('training/{id}', [TrainingController::class, 'approve'])->name('training.approve');

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
    Route::post('training-analyst/{id}', [TrainingAnalystController::class, 'approve'])->name('training.approve');

    // Route Training Needs
    Route::resource('training-need', TrainingNeedController::class);
    Route::get('training-need-api', [TrainingNeedController::class, 'indexApi'])->name('training-need.listapi');
    Route::get('training-need-export-pdf-default', [TrainingNeedController::class, 'exportPdf'])->name('training-need.export-pdf-default');
    Route::get('training-need-export-excel-default', [TrainingNeedController::class, 'exportExcel'])->name('training-need.export-excel-default');
    Route::post('training-need-import-excel-default', [TrainingNeedController::class, 'importExcel'])->name('training-need.import-excel-default');
    // Custome Route Training Needs
    Route::get('participant-ajax', [TrainingNeedController::class, 'participantAjax']);
    Route::get('training-need-pdf', [TrainingNeedController::class, 'generatePDF'])->name('training-need.pdf');
    Route::post('training-need/{id}', [TrainingNeedController::class, 'approve'])->name('training.approve');

    // Route Training Need Workshops
    Route::resource('need-workshop', NeedWorkshopController::class);
    Route::get('need-workshop-api', [NeedWorkshopController::class, 'indexApi'])->name('need-workshop.listapi');
    Route::get('need-workshop-export-pdf-default', [NeedWorkshopController::class, 'exportPdf'])->name('need-workshop.export-pdf-default');
    Route::get('need-workshop-export-excel-default', [NeedWorkshopController::class, 'exportExcel'])->name('need-workshop.export-excel-default');
    Route::post('need-workshop-import-excel-default', [NeedWorkshopController::class, 'importExcel'])->name('need-workshop.import-excel-default');

    // Route Training Need Participant
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
    // Custome Route Schedule
    Route::get('training-schedule-pdf', [TrainingScheduleController::class, 'generatePDF'])->name('training-schedule.pdf');

    // Route Training Unplanned
    Route::resource('training-unplanned', TrainingUnplannedController::class);
    Route::get('training-unplanned-api', [TrainingUnplannedController::class, 'indexApi'])->name('training-unplanned.listapi');
    Route::get('training-unplanned-export-pdf-default', [TrainingUnplannedController::class, 'exportPdf'])->name('training-unplanned.export-pdf-default');
    Route::get('training-unplanned-export-excel-default', [TrainingUnplannedController::class, 'exportExcel'])->name('training-unplanned.export-excel-default');
    Route::post('training-unplanned-import-excel-default', [TrainingUnplannedController::class, 'importExcel'])->name('training-unplanned.import-excel-default');

    // Route Training Unplanned Participants
    Route::resource('training-unplan-participant', TrainingUnplanParticipantController::class);
    Route::get('training-unplan-participant-api', [TrainingUnplanParticipantController::class, 'indexApi'])->name('training-unplan-participant.listapi');
    Route::get('training-unplan-participant-export-pdf-default', [TrainingUnplanParticipantController::class, 'exportPdf'])->name('training-unplan-participant.export-pdf-default');
    Route::get('training-unplan-participant-export-excel-default', [TrainingUnplanParticipantController::class, 'exportExcel'])->name('training-unplan-participant.export-excel-default');
    Route::post('training-unplan-participant-import-excel-default', [TrainingUnplanParticipantController::class, 'importExcel'])->name('training-unplan-participant.import-excel-default');

    // Route Events
    Route::resource('event', EventController::class);
    Route::get('event-api', [EventController::class, 'indexApi'])->name('event.listapi');
    Route::get('event-export-pdf-default', [EventController::class, 'exportPdf'])->name('event.export-pdf-default');
    Route::get('event-export-excel-default', [EventController::class, 'exportExcel'])->name('event.export-excel-default');
    Route::post('event-import-excel-default', [EventController::class, 'importExcel'])->name('event.import-excel-default');

    // Route Participants
    Route::resource('participant', ParticipantController::class);
    Route::get('participant-api', [ParticipantController::class, 'indexApi'])->name('participant.listapi');
    Route::get('participant-export-pdf-default', [ParticipantController::class, 'exportPdf'])->name('participant.export-pdf-default');
    Route::get('participant-export-excel-default', [ParticipantController::class, 'exportExcel'])->name('participant.export-excel-default');
    Route::post('participant-import-excel-default', [ParticipantController::class, 'importExcel'])->name('participant.import-excel-default');
    // Custom Route Participant
    Route::post('participant-generate-user/{event_id}', [ParticipantController::class, 'generateUser'])->name('participant.generate.user');
    Route::get('participant-attendance', [ParticipantController::class, 'attendance'])->name('participant.attendance');
    Route::post('participant-attendance/{token}', [ParticipantController::class, 'attendanceForm'])->name('participant.attendance.form');
    Route::post('participant-attendance-ready/', [ParticipantController::class, 'attendanceFormReady'])->name('participant.attendance.form.ready');
    Route::get('participant-spl-pdf', [ParticipantController::class, 'splpdf'])->name('participant.spl.pdf');
    Route::get('participant-present-pdf', [ParticipantController::class, 'presentpdf'])->name('participant.present.pdf');

    // Route Barcode Generator
    Route::get('/set-event/{id}', function ($id) {
        session(['event_id' => $id]);
        return redirect('/barcode-event');
    })->name('set.event');
    Route::get('/barcode-event', [BarcodeController::class, 'index']);

    // Route Barcode Generator
    Route::get('/set-test/{id}', function ($id) {
        session(['test_id' => $id]);
        return redirect('/barcode-test');
    })->name('set.test');
    Route::get('/barcode-test', [BarcodeController::class, 'testEmployee']);

    // Route Materi
    Route::resource('materi', MateriController::class);
    Route::get('materi-api', [MateriController::class, 'indexApi'])->name('materi.listapi');
    Route::get('materi-export-pdf-default', [MateriController::class, 'exportPdf'])->name('materi.export-pdf-default');
    Route::get('materi-export-excel-default', [MateriController::class, 'exportExcel'])->name('materi.export-excel-default');
    Route::post('materi-import-excel-default', [MateriController::class, 'importExcel'])->name('materi.import-excel-default');
    // Custom Route Materi
    Route::get('/set-materi/{id}', function ($id) {
        session(['materi_id' => $id]);
        return redirect('/materi-view');
    })->name('set.materi');
    Route::get('materi-view', [MateriController::class, 'viewMateri'])->name('materi.view');

    // Route Materi Logs
    Route::resource('materi-log', MateriLogController::class);
    Route::get('materi-log-api', [MateriLogController::class, 'indexApi'])->name('materi-log.listapi');
    Route::get('materi-log-export-pdf-default', [MateriLogController::class, 'exportPdf'])->name('materi-log.export-pdf-default');
    Route::get('materi-log-export-excel-default', [MateriLogController::class, 'exportExcel'])->name('materi-log.export-excel-default');
    Route::post('materi-log-import-excel-default', [MateriLogController::class, 'importExcel'])->name('materi-log.import-excel-default');
    // Custom Route Materi Logs
    Route::post('/materi/download/count', [MateriLogController::class, 'countDownload'])
        ->name('materi.download.count');
    Route::post('/api/materi-log', [MateriLogController::class, 'countLog']);

    // Route Training New Employee
    Route::resource('training-new-employee', TrainingNewEmployeeController::class);
    Route::get('training-new-employee-api', [TrainingNewEmployeeController::class, 'indexApi'])->name('training-new-employee.listapi');
    Route::get('training-new-employee-export-pdf-default', [TrainingNewEmployeeController::class, 'exportPdf'])->name('training-new-employee.export-pdf-default');
    Route::get('training-new-employee-export-excel-default', [TrainingNewEmployeeController::class, 'exportExcel'])->name('training-new-employee.export-excel-default');
    Route::post('training-new-employee-import-excel-default', [TrainingNewEmployeeController::class, 'importExcel'])->name('training-new-employee.import-excel-default');

    // Route Training New Participant
    Route::resource('training-new-participant', TrainingNewParticipantController::class);
    Route::get('training-new-participant-api', [TrainingNewParticipantController::class, 'indexApi'])->name('training-new-participant.listapi');
    Route::get('training-new-participant-export-pdf-default', [TrainingNewParticipantController::class, 'exportPdf'])->name('training-new-participant.export-pdf-default');
    Route::get('training-new-participant-export-excel-default', [TrainingNewParticipantController::class, 'exportExcel'])->name('training-new-participant.export-excel-default');
    Route::post('training-new-participant-import-excel-default', [TrainingNewParticipantController::class, 'importExcel'])->name('training-new-participant.import-excel-default');

    // Route Employee Test
    Route::resource('employee-test', EmployeeTestController::class);
    Route::get('employee-test-api', [EmployeeTestController::class, 'indexApi'])->name('employee-test.listapi');
    Route::get('employee-test-export-pdf-default', [EmployeeTestController::class, 'exportPdf'])->name('employee-test.export-pdf-default');
    Route::get('employee-test-export-excel-default', [EmployeeTestController::class, 'exportExcel'])->name('employee-test.export-excel-default');
    Route::post('employee-test-import-excel-default', [EmployeeTestController::class, 'importExcel'])->name('employee-test.import-excel-default');

    // Route Question
    Route::resource('question', QuestionController::class);
    Route::get('question-api', [QuestionController::class, 'indexApi'])->name('question.listapi');
    Route::get('question-export-pdf-default', [QuestionController::class, 'exportPdf'])->name('question.export-pdf-default');
    Route::get('question-export-excel-default', [QuestionController::class, 'exportExcel'])->name('question.export-excel-default');
    Route::post('question-import-excel-default', [QuestionController::class, 'importExcel'])->name('question.import-excel-default');

    // Route Answer
    Route::resource('answer', AnswerController::class);
    Route::get('answer-api', [AnswerController::class, 'indexApi'])->name('answer.listapi');
    Route::get('answer-export-pdf-default', [AnswerController::class, 'exportPdf'])->name('answer.export-pdf-default');
    Route::get('answer-export-excel-default', [AnswerController::class, 'exportExcel'])->name('answer.export-excel-default');
    Route::post('answer-import-excel-default', [AnswerController::class, 'importExcel'])->name('answer.import-excel-default');

    // Route User Answer
    Route::resource('user-answer', UserAnswerController::class);
    Route::get('user-answer-api', [UserAnswerController::class, 'indexApi'])->name('user-answer.listapi');
    Route::get('user-answer-export-pdf-default', [UserAnswerController::class, 'exportPdf'])->name('user-answer.export-pdf-default');
    Route::get('user-answer-export-excel-default', [UserAnswerController::class, 'exportExcel'])->name('user-answer.export-excel-default');
    Route::post('user-answer-import-excel-default', [UserAnswerController::class, 'importExcel'])->name('user-answer.import-excel-default');

    // Route Event Answer
    Route::resource('event-answer', EventAnswerController::class);
    Route::get('event-answer-api', [EventAnswerController::class, 'indexApi'])->name('event-answer.listapi');
    Route::get('event-answer-export-pdf-default', [EventAnswerController::class, 'exportPdf'])->name('event-answer.export-pdf-default');
    Route::get('event-answer-export-excel-default', [EventAnswerController::class, 'exportExcel'])->name('event-answer.export-excel-default');
    Route::post('event-answer-import-excel-default', [EventAnswerController::class, 'importExcel'])->name('event-answer.import-excel-default');


});
