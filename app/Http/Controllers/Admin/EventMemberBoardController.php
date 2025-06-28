<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Event;
use App\Models\EventMember;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Services\Admin\EventMemberService;
use App\Http\Requests\Admin\EventMemberStoreRequest;

class EventMemberBoardController extends Controller
{
    public function __construct(
        private EventMemberService $eventMemberService
    ) {}

    public function index(Event $event): \Inertia\Response
    {
        return Inertia::render('Admin/EventMembers', [
            'event' => $event->only('id', 'title'),
            'event_members' => $event->users
        ]);
    }

    public function store(int $event_id, EventMemberStoreRequest $request): RedirectResponse 
    {
        $this->eventMemberService->createEventMember($event_id, $request->user_id);

        return back();
    }
        
    public function destroy(int $member_id): RedirectResponse 
    {
        $this->eventMemberService->deleteEventMember($member_id);
        
        return back();
    }
}
