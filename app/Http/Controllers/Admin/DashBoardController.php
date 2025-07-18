<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashBoardController extends Controller
{
    public function index(): \Inertia\Response
    {
        return Inertia::render('Admin/Dashboard');
    }
}
