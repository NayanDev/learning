<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\TrainingNewEmployee;
use Illuminate\Http\Request;

class BarcodeController extends Controller
{
    public function index()
    {
        $eventId = session('event_id');

        if (!$eventId) {
            return redirect('/')->with('error', 'Event ID tidak ditemukan.');
        }

        $event = Event::findOrFail($eventId);

        $data = 'http://lms.test/participant-attendance?token=' . $event->token; // Data yang ingin dibuat barcode
        return view('backend.idev.barcode', compact('data'));
    }

    public function testEmployee()
    {
        $testId = session('test_id');

        if (!$testId) {
            return redirect('/')->with('error', 'Test ID tidak ditemukan.');
        }

        $newEmployee = TrainingNewEmployee::findOrFail($testId);

        $data = 'http://lms.test/test-new-employee?token=' . $newEmployee->token; // Data yang ingin dibuat barcode
        return view('backend.idev.test_barcode', compact('data'));
    }
}
