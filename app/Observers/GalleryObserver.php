<?php

namespace App\Observers;

use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;

class GalleryObserver
{
    /**
     * Handle the Gallery "created" event.
     */
    public function deleted(Gallery $gallery): void
    {
        if ($event->preview) {
            $previewPath = parse_url($event->preview, PHP_URL_PATH);
            $previewPath = str_replace('/storage/', '', $previewPath);
            Storage::disk('public')->delete($previewPath);
        }
    }

    /**
     * Handle the Gallery "updated" event.
     */
    public function updated(Gallery $gallery): void
    {
        if ($gallery->isDirty('preview') && $gallery->getOriginal('preview')) {
            $oldPreview = parse_url($gallery->getOriginal('preview'), PHP_URL_PATH);
            $oldPreview = str_replace('/storage/', '', $oldPreview);
            Storage::disk('public')->delete($oldPreview);
        }
    }
}
