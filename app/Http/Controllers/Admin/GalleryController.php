<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GalleryController extends Controller
{
    public function index(): \Inertia\Response
    {
        return Inertia::render('Admin/Gallery');
    }
}
