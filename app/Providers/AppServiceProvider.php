<?php

namespace App\Providers;

use App\LibraryClasses\ChatManager\ChatManager;
use App\Room;
use App\Tag;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ChatManager::class, function() {
            return new ChatManager();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $rooms = Room::all();
        $tags = Tag::with('rooms')->get();
        View::share('rooms', $rooms);
        View::share('tags', $tags);
    }
}
