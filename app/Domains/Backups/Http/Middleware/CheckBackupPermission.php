<?php

namespace App\Domains\Backups\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckBackupPermission
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
        if (! $request->user()->can('admin.access.backups')) {
            return redirect()->back()->withFlashDanger(__('You do not have access to do that.'));
        }

        return $next($request);
    }
}
