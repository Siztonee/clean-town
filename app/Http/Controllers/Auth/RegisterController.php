<?php

namespace App\Http\Controllers\Auth;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function index(): \Inertia\Responce
    {
        return Inertia::render('Auth/Register');
    }
}
