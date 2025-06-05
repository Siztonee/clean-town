<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventsController extends Controller
{
    public function index(): \Inertia\Response
    {
        return Inertia::render('Admin/Events');
    }

    public function store()
    {
        return 0;
    }
}
