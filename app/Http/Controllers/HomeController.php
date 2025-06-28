<?php

namespace App\Http\Controllers;

use App\Models\Stat;
use Inertia\Inertia;
use App\Models\Event;
use App\Models\Gallery;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Home/Index', [
            'stats' => Stat::all(),
            'upcomingEvents' => Event::withCount('members')->orderBy('starts_at', 'DESC')->take(3)->get(),
            'recentGalleries' => Gallery::orderBy('date', 'DESC')->take(3)->get(),
        ]);
    }
}
