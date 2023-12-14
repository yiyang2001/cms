<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyAdminApproval
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->verified_by_admin == 0 && auth()->user()->ic_document == null && auth()->user()->driving_license_document == null) {
            return redirect()->route('my-profile')->with('warning', 'Please upload your IC and driving license documents for verification. We appreciate your patience during this process.');
        }
        else if (auth()->check() && auth()->user()->verified_by_admin == 0) {
            return redirect()->route('my-profile')->with('warning', 'Your account is awaiting admin approval for verification. We appreciate your patience during this process.');
        }
        else if (auth()->check() && auth()->user()->verified_by_admin == 2) {
            return redirect()->route('my-profile')->with('error', 'Your account has been rejected by admin. Please contact admin for more information.');
        }
        return $next($request);
    }
}
