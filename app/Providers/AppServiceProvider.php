<?php

namespace App\Providers;

use App\Models\Event;
use App\Models\Gallery;
use App\Models\TeamMember;
use App\Models\GalleryItem;
use App\Observers\EventObserver;
use App\Observers\GalleryObserver;
use Illuminate\Support\Facades\URL;
use App\Observers\TeamMemberObserver;
use App\Observers\GalleryItemObserver;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event as EventListen;

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
        if (
            Request::header('X-Forwarded-Proto') === 'https' ||
            env('APP_ENV') !== 'local'
        ) {
            URL::forceScheme('https');
        } 

        Event::observe(EventObserver::class);
        Gallery::observe(GalleryObserver::class);
        GalleryItem::observe(GalleryItemObserver::class);
        TeamMember::observe(TeamMemberObserver::class);     
        
        EventListen::listen(function (\SocialiteProviders\Manager\SocialiteWasCalled $event) {
            $event->extendSocialite('telegram', \SocialiteProviders\Telegram\Provider::class);
        });
        
    }
}
