<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GalleryController extends Controller
{
    public function index(): \Inertia\Response
    {
        $perPage = 2; 
        
        $galleries = Gallery::orderBy('created_at', 'desc')
            ->paginate($perPage);
        
        return Inertia::render('Gallery/Index', [
            'galleries' => $galleries
        ]);
    }

    public function show(int $gallery_id): \Inertia\Response
    {
        $gallery = Gallery::findOrFail($gallery_id);

        return Inertia::render('Gallery/Show', [
            'gallery' => $gallery,
            'gallery_items' => $gallery->items
        ]);
    }
}
