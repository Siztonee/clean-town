<?php

namespace App\Http\Controllers\Auth;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\UserLoginRequest;

class LoginController extends Controller
{
    public function index(): \Inertia\Response
    {
        return Inertia::render('Auth/Login');
    }

    public function store(UserLoginRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if(Auth::attempt($validated)) {
            return redirect()->route('home.index');
        } else {
            return back();
        }
    }
}
