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

        $data = url('participant-attendance') . '?token=' . $event->token; // Data yang ingin dibuat barcode
        return view('backend.idev.barcode', compact('data'));
    }

    public function testEmployee()
    {
        $testId = session('test_id');

        if (!$testId) {
            return redirect('/')->with('error', 'Test ID tidak ditemukan.');
        }

        $newEmployee = TrainingNewEmployee::findOrFail($testId);

        $data = url('test-new-employee') . '?token=' . $newEmployee->token; // Data yang ingin dibuat barcode
        return view('backend.idev.test_barcode', compact('data'));
    }

    public function testEventQuestion()
    {
        $eventId = session('event_id');

        if (!$eventId) {
            return redirect('/')->with('error', 'Event ID tidak ditemukan.');
        }

        $event = Event::findOrFail($eventId);

        $data = url('test-event-question') . '?token=' . $event->token; // Data yang ingin dibuat barcode
        return view('backend.idev.event_question_barcode', compact('data'));
    }
}
