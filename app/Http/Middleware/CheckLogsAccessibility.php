<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckLogsAccessibility
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->can('admin.access.logs')) {
            return $next($request);
        }

        return redirect()->route('admin.dashboard')->withFlashDanger(__('You do not have access to do that.'));
    }
}
