<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ShareNotifications
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $notifications = $user ? $user->notifications()->orderBy('created_at', 'desc')->take(5)->get() : [];
        $notificationsCount = $user ? $user->unreadNotifications()->count() : 0;
    
        view()->share('notifications', $notifications);
        view()->share('notificationsCount', $notificationsCount);
    
        return $next($request);
    }
}
