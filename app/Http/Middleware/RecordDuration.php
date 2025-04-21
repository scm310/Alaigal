<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\RouteDuration;

class RecordDuration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Store the start time in the request
        $request->attributes->set('start_time', microtime(true));

        // Pass the request to the next middleware/controller
        return $next($request);
    }

    /**
     * Handle tasks after the response is sent to the browser.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response $response
     * @return void
     */
    public function terminate($request, $response)
    {
        $start_time = $request->attributes->get('start_time');
        $end_time = microtime(true);
        $duration = $end_time - $start_time;

        // Store the duration in the database
        RouteDuration::create([
            'user_id' => Auth::id(),
            'route' => $request->path(),
            'duration' => $duration,
        ]);
    }
}
