<?php

namespace App\Http\Controllers;

use App\Models\Event;
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
}
