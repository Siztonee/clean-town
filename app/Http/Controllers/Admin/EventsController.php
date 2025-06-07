<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Services\EventService;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\EventStoreRequest;
use App\Http\Requests\EventUpdateRequest;

class EventsController extends Controller
{
    public function __construct(
        private EventService $eventService
    ) {}

    public function index(): \Inertia\Response
    {
        return Inertia::render('Admin/Events', [
            'events' => Event::all()
        ]);
    }

    public function store(EventStoreRequest $request): RedirectResponse 
    {
        $validated = $request->validated();
        $this->eventService->createEvent($validated, $request->file('image'));

        return back();
    }
    
    public function update(Event $event, EventUpdateRequest $request): RedirectResponse 
    {
        $validated = $request->validated();
        $this->eventService->updateEvent($event, $validated, $request->file('image'));

        return back();
    }
        
    public function destroy(Event $event): RedirectResponse 
    {
        $this->eventService->deleteEvent($event);
        return back();
    }
}
