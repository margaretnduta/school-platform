<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display all public events
     */
    public function index()
    {
        $events = Event::where('is_public', true)
            ->orderBy('event_date', 'asc')
            ->paginate(12);
        
        return view('events.index', compact('events'));
    }

    /**
     * Display a single event detail
     */
    public function show(Event $event)
    {
        // Check if event is public
        if (!$event->is_public) {
            abort(404);
        }

        return view('events.show', compact('event'));
    }
}
