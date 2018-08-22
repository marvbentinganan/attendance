<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Carbon\Carbon;

class EventController extends Controller
{
    protected $events;

    public function __construct()
    {
        // Get all Events
        $this->events = Event::latest()->get();
    }

    // Add New Event
    public function store(request $request)
    {
        // Create Event
        $from = Carbon::parse($request->from)->toDateTimeString();
        $to = Carbon::parse($request->to)->toDateTimeString();
        $event = auth()->user()->events()->create([
            'name' => $request->name,
            'slug' => str_slug($request->name, '-'),
            'description' => $request->description,
            'from' => $from,
            'to' => $to
        ]);
        
        // Create Event Controls
        $event->control()->create([
            'from_morning' => $request->from_morning,
            'to_morning' => $request->to_morning,
            'from_afternoon' => $request->from_afternoon,
            'to_afternoon' => $request->to_afternoon,
            'all_day' => false
        ]);

        // Return Response
        return response()->json("New Event Added", 200);
    }

    // Get List of Events
    public function list()
    {
        $events = $this->events;
        return view('events.list', compact('events'));
    }

    // Show an Event
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }
}
