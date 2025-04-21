<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $permissionId)
    {
        $user = Auth::user();

        // Assuming the role_id in the users table matches the user's role ID
        // and the role_permission table has role_id and permission_id columns
        if ($user && $user->role_id == $permissionId) {
            return $next($request);
        }

        return redirect('/'); // Redirect to home or any other unauthorized page
    }
}
