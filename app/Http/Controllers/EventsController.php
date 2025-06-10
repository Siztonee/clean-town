<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class EventsController extends Controller
{
    public function index(): \Inertia\Response
    {
        return Inertia::render('Events/Index', [
            'events' => Event::withCount('members')->get()
        ]);
    }

    public function show(Event $event): \Inertia\Response
    {
        return Inertia::render('Events/Show', [
            'event' => $event->loadCount('members')
        ]);
    }

    public function store(Event $event, Request $request): RedirectResponse
    {
        dd($event);
    }

    public function destroy(Event $event, Request $request): RedirectResponse
    {
        dd($request);
    }
}
