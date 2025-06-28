<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\EventsController;
use App\Http\Middleware\IsAdminMiddleware;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\FAQBoardController;
use App\Http\Controllers\Admin\DashBoardController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Admin\StatsBoardController;
use App\Http\Controllers\Admin\EventsBoardController;
use App\Http\Controllers\Admin\GalleryBoardController;
use App\Http\Controllers\Admin\HistoryBoardController;
use App\Http\Controllers\Admin\EventMemberBoardController;
use App\Http\Controllers\Admin\GalleryItemBoardController;
use App\Http\Controllers\Admin\TeamMembersBoardController;


Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/events', [EventsController::class, 'index'])->name('events');
Route::get('/events/{event}', [EventsController::class, 'show']);
Route::post('/events/{event_id}/join', [EventsController::class, 'store'])->middleware('auth');
Route::delete('/events/{event}/leave', [EventsController::class, 'destroy'])->middleware('auth');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
Route::get('/gallery/{gallery_id}', [GalleryController::class, 'show']);
Route::get('/about', [AboutController::class, 'index']);


Route::middleware(['guest'])->group(function () {
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
    Route::get('/login/google/redirect', [GoogleAuthController::class, 'redirect'])->name('auth.google.redirect');
    Route::get('/login/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');
});



Route::prefix('admin')->middleware(['auth', IsAdminMiddleware::class])->group(function() {
    Route::get('', [DashBoardController::class, 'index'])->name('admin.dashboard.index');
    Route::get('/users/search', [UserController::class, 'search'])->name('admin.users.search');
    Route::resource('/events', EventsBoardController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::prefix('/event/{event}')->group(function () {
        Route::get('/', [EventMemberBoardController::class, 'index'])->name('event.members.index');
        Route::post('/', [EventMemberBoardController::class, 'store'])->name('event.members.store');
        Route::delete('/{member}', [EventMemberBoardController::class, 'destroy'])->name('event.members.destroy');
    });
    Route::resource('/galleries', GalleryBoardController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::prefix('/gallery/{gallery}')->group(function () {
        Route::get('/', [GalleryItemBoardController::class, 'index'])->name('gallery.items.index');
        Route::post('/', [GalleryItemBoardController::class, 'store'])->name('gallery.items.store');
        Route::delete('/{media}', [GalleryItemBoardController::class, 'destroy'])->name('gallery.items.destroy');
    });
    Route::resource('/team-members', TeamMembersBoardController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('/faq', FAQBoardController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('/stats', StatsBoardController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('/history', HistoryBoardController::class)->only(['index', 'store', 'update', 'destroy']);
});

