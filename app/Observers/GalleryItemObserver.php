<?php

namespace App\Observers;

use App\Models\GalleryItem;
use Illuminate\Support\Facades\Storage;

class GalleryItemObserver
{
    /**
     * Handle the GalleryItem "updated" event.
     */
    public function updated(GalleryItem $galleryItem): void
    {
        if ($galleryItem->isDirty('path') && $galleryItem->getOriginal('path')) {
            $oldPath = parse_url($galleryItem->getOriginal('path'), PHP_URL_PATH);
            $oldPath = str_replace('/storage/', '', $oldPath);
            Storage::disk('public')->delete($oldPath);
        }
    }

    /**
     * Handle the GalleryItem "deleted" event.
     */
    public function deleted(GalleryItem $galleryItem): void
    {
        if ($galleryItem->path) {
            $path = parse_url($galleryItem->path, PHP_URL_PATH);
            $path = str_replace('/storage/', '', $path);
            Storage::disk('public')->delete($path);
        }
    }
}
