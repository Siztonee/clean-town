<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Services\GalleryService;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\GalleryStoreRequest;
use App\Http\Requests\GalleryUpdateRequest;

class GalleryController extends Controller
{
    public function __construct(
        private GalleryService $galleryService
    ) {}

    public function index(): \Inertia\Response
    {
        return Inertia::render('Admin/Gallery', [
            'galleries' => Gallery::with('items')->get()
        ]);
    }

    public function store(GalleryStoreRequest $request): RedirectResponse 
    {
        $validated = $request->validated();
        $this->galleryService->createGallery($validated, $request->file('preview'));

        return back();
    }
    
    public function update(Gallery $gallery, GalleryUpdateRequest $request): RedirectResponse 
    {
        $validated = $request->validated();
        $this->galleryService->updateGallery($gallery, $validated, $request->file('preview'));

        return back();
    }
        
    public function destroy(Gallery $gallery): RedirectResponse 
    {
        $this->galleryService->deleteGallery($gallery);
        return back();
    }
}
