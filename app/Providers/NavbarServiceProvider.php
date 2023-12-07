<?php

namespace App\Providers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class NavbarServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot():void
    {
        // // Retrieve the data for the navbar view
        // $userId = Auth::id();

        // // Retrieve the data for the navbar view based on the user ID
        // // $notifications = Notification::where('user_id', $userId)->orderBy('created_at', 'desc')->take(5)->get();
        // // $notificationsCount = Notification::where('user_id', $userId)->count();
        // $notifications = Notification::orderBy('created_at', 'desc')->take(5)->get();
        // $notificationsCount = Notification::count();

        // // Share the data with the navbar view
        // View::composer('backend.layouts.navbar', function ($view) use ($userId, $notifications, $notificationsCount) {
        //     $view->with(compact('userId','notifications', 'notificationsCount'));
        // });
    }
}
