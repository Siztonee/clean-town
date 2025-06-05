<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::get('/events', function () {
    return Inertia::render('Events/Index');
});

Route::get('/gallery', function () {
    return Inertia::render('Gallery/Index');
});

Route::get('/about', function () {
    return Inertia::render('About/Index');
});

Route::get('/admin', function () {
    return Inertia::render('Admin/Dashboard');
});