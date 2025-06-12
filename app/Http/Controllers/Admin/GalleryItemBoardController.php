<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Gallery;
use App\Models\GalleryItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Services\Admin\GalleryItemService;
use App\Http\Requests\Admin\GalleryItemStoreRequest;
use App\Http\Requests\Admin\GalleryItemUpdateRequest;

class GalleryItemBoardController extends Controller
{
    public function __construct(
        private GalleryItemService $galleryItemService
    ) {}

    public function index($gallery_id): \Inertia\Response
    {
        $gallery = Gallery::findOrFail($gallery_id);

        return Inertia::render('Admin/GalleryItem', [
            'gallery' => $gallery,
            'gallery_items' => GalleryItem::all()
        ]);
    }

    public function store($gallery_id, GalleryItemStoreRequest $request): RedirectResponse 
    {
        $this->galleryItemService->createGalleryItem($gallery_id, $request->file('files'));

        return back();
    }
        
    public function destroy(int $gallery_id, int $media_id): RedirectResponse 
    {
        $this->galleryItemService->deleteGalleryItem($media_id);
        return back();
    }
}
