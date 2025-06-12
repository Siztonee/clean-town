<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Event;
use App\Models\EventMember;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\EventMemberService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class EventsController extends Controller
{
    public function __construct(
        private EventMemberService $eventMemberService
    ) {}

    public function index(): \Inertia\Response
    {
        return Inertia::render('Events/Index', [
            'events' => Event::withCount('members')->get()
        ]);
    }

    public function show(Event $event): \Inertia\Response
    {
        return Inertia::render('Events/Show', [
            'event' => $event->loadCount('members'),
            'initialMembership' => EventMember::where('user_id', Auth::id())->where('event_id', $event->id)->exists()
        ]);
    }

    public function store($event_id, Request $request): RedirectResponse
    {
        $this->eventMemberService->store($request->user()->id, $event_id);
        return back();
    }

    public function destroy($event_id, Request $request): RedirectResponse
    {
        $this->eventMemberService->destroy($request->user()->id, $event_id);
        return back();
    }
}
