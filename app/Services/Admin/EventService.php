<?php
namespace App\Services\Admin;

use Illuminate\Http\UploadedFile;
use App\Models\Event;

class EventService
{
    protected function storeImage(UploadedFile $image): string
    {
        return $image->store('events', 'public');
    }

    public function createEvent(array $data, ?UploadedFile $image = null): Event
    {
        if (!$image) {
            return abort(403);
        }

        $data['image'] = $this->storeImage($image);

        return Event::create($data);
    }

    public function updateEvent(Event $event, array $data, ?UploadedFile $image = null): bool
    {
        if ($image) {
            $data['image'] = $this->storeImage($image);
        }

        return $event->update($data);
    }

    public function deleteEvent(Event $event): bool
    {
        return $event->delete();
    }
}