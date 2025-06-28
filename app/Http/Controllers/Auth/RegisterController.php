<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\UserRegisterRequest;

class RegisterController extends Controller
{
    public function index(): \Inertia\Response
    {
        return Inertia::render('Auth/Register');
    }

    public function store(UserRegisterRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if (User::where('username', $validated['username']) && User::where('phone', $validated['phone'])) {
            User::create($validated);
            return redirect()->route('login');
        } 

        return back();
    }
}
