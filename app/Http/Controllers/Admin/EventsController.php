<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\EventStoreRequest;
use App\Http\Requests\EventUpdateRequest;

class EventsController extends Controller
{
    public function index(): \Inertia\Response
    {
        return Inertia::render('Admin/Events', [
            'events' => Event::all()
        ]);
    }

    public function store(EventStoreRequest $request): RedirectResponse 
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
            $validated['image'] = $imagePath;
        }

        Event::create($validated);

        return back();
    }
    
    public function update(Event $event, EventUpdateRequest $request): RedirectResponse 
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }

            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        $event->update($validated);
        return back();
    }
        

    public function destroy(Event $event): RedirectResponse 
    {
        $event->delete();
        return back();
    }
}
