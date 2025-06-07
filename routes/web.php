<?php

use Inertia\Inertia;
use App\Models\Event;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\FAQController;
use App\Http\Controllers\Admin\EventsController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TeamMembersController;

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::get('/events', function () {
    return Inertia::render('Events/Index', [
        'events' => Event::all()
    ]);
});

Route::get('/gallery', function () {
    return Inertia::render('Gallery/Index');
});

Route::get('/about', function () {
    return Inertia::render('About/Index');
});

Route::prefix('admin')->group(function() {
    Route::get('', [DashboardController::class, 'index'])->name('admin.dashboard.index');
    Route::resource('/events', EventsController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('/gallery', GalleryController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('/team-members', TeamMembersController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('/faq', FAQController::class)->only(['index', 'store', 'update', 'destroy']);
});

