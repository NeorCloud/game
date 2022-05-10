<?php

namespace App\Domains\Games\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckGamesPermission
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
        if (!$request->user()->can('admin.access.games'))
            return redirect()->back()->withFlashDanger(__('You do not have access to do that.'));
        return $next($request);
    }
}
