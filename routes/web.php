<?php

use Inertia\Inertia;
use App\Models\Event;
use App\Models\FAQItem;
use App\Models\Gallery;
use App\Models\History;
use App\Models\TeamMember;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\FAQController;
use App\Http\Controllers\Admin\StatsController;
use App\Http\Controllers\Admin\EventsController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\HistoryController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TeamMembersController;

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::get('/events', function () {
    return Inertia::render('Events/Index', [
        'events' => Event::withCount('members')->get()
    ]);
});

Route::get('/events/{event}', function (Event $event) {
    return Inertia::render('Events/Show', [
        'event' => $event->loadCount('members')
    ]);
});

Route::get('/gallery', function () {
    return Inertia::render('Gallery/Index', [
        'galleries' => Gallery::all()
    ]);
});

Route::get('/about', function () {
    return Inertia::render('About/Index', [
        'teamMembers' => TeamMember::all(),
        'faq' => FAQItem::all(),
        'histories' => History::orderBy('date', 'ASC')->get()
    ]);
});


Route::get('/register', [RegisterController::class, 'index']);


Route::prefix('admin')->group(function() {
    Route::get('', [DashboardController::class, 'index'])->name('admin.dashboard.index');
    Route::resource('/events', EventsController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('/gallery', GalleryController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('/team-members', TeamMembersController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('/faq', FAQController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('/stats', StatsController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('/history', HistoryController::class)->only(['index', 'store', 'update', 'destroy']);
});

