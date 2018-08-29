<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Student;

class ReportController extends Controller
{
    public function index()
    {
        $events = Event::latest()->get();
        return view('reports.index', compact('events'));
    }

    public function attendance(Event $event)
    {
        return view('reports.event', compact('event'));
    }

    public function attendees(Event $event)
    {
        $list = $event->attendances()->select('student_id')
        ->distinct()
        ->pluck('student_id');
        $attendees = Student::whereIn('id', $list)->get();

        return response()->json($attendees);
    }

    public function record(Event $event, Student $student)
    {
        $attendances = $student->attendances()->where('event_id', $event->id)->get();

        return response()->json([
            'student' => $student,
            'attendances' => $attendances
        ]);
    }
}
