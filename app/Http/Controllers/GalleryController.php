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
        return Inertia::render('Gallery/Index', [
            'galleries' => Gallery::all()
        ]);
    }
}
