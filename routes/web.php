<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\FAQBoardController;
use App\Http\Controllers\Admin\DashBoardController;
use App\Http\Controllers\Admin\StatsBoardController;
use App\Http\Controllers\Admin\EventsBoardController;
use App\Http\Controllers\Admin\GalleryBoardController;
use App\Http\Controllers\Admin\HistoryBoardController;
use App\Http\Controllers\Admin\TeamMembersBoardController;

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/events', [EventsController::class, 'index']);
Route::get('/events/{event}', [EventsController::class, 'show']);
Route::post('/events/{event}/join', [EventsController::class, 'store']);
Route::delete('/events/{event}/leave', [EventsController::class, 'destory']);
Route::get('/gallery', [GalleryController::class, 'index']);
Route::get('/about', [AboutController::class, 'index']);


Route::get('/register', [RegisterController::class, 'index'])->name('register.index');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::get('/login', [LoginController::class, 'index'])->name('login.index');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');


Route::prefix('admin')->group(function() {
    Route::get('', [DashBoardController::class, 'index'])->name('admin.dashboard.index');
    Route::resource('/events', EventsBoardController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('/gallery', GalleryBoardController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('/team-members', TeamMembersBoardController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('/faq', FAQBoardController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('/stats', StatsBoardController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('/history', HistoryBoardController::class)->only(['index', 'store', 'update', 'destroy']);
});

