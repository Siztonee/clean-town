<?php
namespace App\Services;

use App\Models\User;
use App\Models\Event;
use App\Models\EventMember;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class EventMemberService
{
    public function store($userId, $eventId): JsonResponse
    {
        DB::beginTransaction();

        try {
            $user = User::findOrFail($userId);
            $event = Event::findOrFail($eventId);

            if (EventMember::where('user_id', $userId)->where('event_id', $eventId)->exists()) {
                throw new \Exception('User is already a member of this event');
            }

            EventMember::create([
                'user_id' => $userId, 
                'event_id' => $eventId
            ]);
            
            DB::commit();

            return response()->json(['message' => 'Success'], 201);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['error' => 'User or Event not found'], 404);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }


    public function destroy($userId, $eventId): JsonResponse
    {
        DB::beginTransaction();

        try {
            $user = User::findOrFail($userId);
            $event = Event::findOrFail($eventId);
            $eventMember = EventMember::where('user_id', $userId)->where('event_id', $eventId);

            if (!$eventMember->exists()) {
                throw new \Exception('User is not a member of this event');
            }

            $eventMember->delete();

            DB::commit();

            return response()->json(['message' => 'Success'], 201);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['error' => 'User or Event not found'], 404);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}