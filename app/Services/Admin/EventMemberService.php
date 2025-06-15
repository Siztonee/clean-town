<?php
namespace App\Services\Admin;

use App\Models\EventMember;

class EventMemberService
{
    public function createEventMember(int $event_id, int $user_id): EventMember
    {
        return EventMember::create([
            'event_id' => $event_id,
            'user_id' => $user_id
        ]);
    }

    public function deleteEventMember(int $member_id): bool
    {
        $eventMember = EventMember::findOrFail($member_id);
        return $eventMember->delete();
    }
}