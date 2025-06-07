<?php

namespace App\Providers;

use App\Models\Event;
use App\Models\Gallery;
use App\Models\TeamMember;
use App\Observers\EventObserver;
use App\Observers\GalleryObserver;
use App\Observers\TeamMemberObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::observe(EventObserver::class);
        Gallery::observe(GalleryObserver::class);
        TeamMember::observe(TeamMemberObserver::class);
    }
}
