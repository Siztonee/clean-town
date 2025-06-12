<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Event;
use App\Models\EventMember;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\EventMemberService;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\EventResource;
use Illuminate\Http\RedirectResponse;

class EventsController extends Controller
{
    public function __construct(
        private EventMemberService $eventMemberService
    ) {}

    public function index(Request $request): \Inertia\Response
    {
        $perPage = 2;
        $status = $request->get('status', 'upcoming'); 
        
        $query = Event::withCount('members');
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        $events = $query->paginate($perPage);
        
        $events->appends($request->query());
        
        return Inertia::render('Events/Index', [
            'events' => $events,
            'currentStatus' => $status,
            'filters' => [
                ['label' => 'Все', 'value' => 'all'],
                ['label' => 'Предстоящие', 'value' => 'upcoming'],
                ['label' => 'Текущие', 'value' => 'active'],
                ['label' => 'Завершенные', 'value' => 'completed'],
            ]
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
