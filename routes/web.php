<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\FAQController;
use App\Http\Controllers\Admin\EventsController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TeamMembersController;

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

Route::prefix('admin')->group(function() {
    Route::get('', [DashboardController::class, 'index'])->name('admin.dashboard.index');

    Route::get('/events', [EventsController::class, 'index'])->name('admin.events.index');
    Route::post('/events', [EventsController::class, 'store'])->name('admin.events.store');

    Route::get('/gallery', [GalleryController::class, 'index'])->name('admin.gallery.index');
    Route::post('/gallery', [GalleryController::class, 'store'])->name('admin.gallery.store');

    Route::get('/team-members', [TeamMembersController::class, 'index'])->name('admin.teammembers.index');
    Route::post('/team-members', [TeamMembersController::class, 'store'])->name('admin.teammembers.store');

    Route::get('/faq', [FAQController::class, 'index'])->name('admin.faq.index');
    Route::post('/faq', [FAQController::class, 'store'])->name('admin.faq.store');
});

