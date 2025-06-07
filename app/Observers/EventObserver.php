<?php

namespace App\Observers;

use App\Models\Event;
use Illuminate\Support\Facades\Storage;

class EventObserver
{
    /**
     * Handle the Event "updated" event.
     */
    public function updated(Event $event): void
    {
        if ($event->isDirty('image') && $event->getOriginal('image')) {
            $oldImage = parse_url($event->getOriginal('image'), PHP_URL_PATH);
            $oldImage = str_replace('/storage/', '', $oldImage);
            Storage::disk('public')->delete($oldImage);
        }
    }

    /**
     * Handle the Event "deleted" event.
     */
    public function deleted(Event $event): void
    {
        if ($event->image) {
            $imagePath = parse_url($event->image, PHP_URL_PATH);
            $imagePath = str_replace('/storage/', '', $imagePath);
            Storage::disk('public')->delete($imagePath);
        }
    }
}
