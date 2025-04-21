<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is logged in as a vendor
        if (Auth::check() && Auth::user() instanceof \App\Models\VendorDetail) {
            return $next($request);
        }

        // Redirect to the login page if the user is not logged in
        return redirect()->route('vendorlogin.auth.dashboard');
    }
}
