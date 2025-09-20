<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $routeName = $request->route()?->getName();
        $ignoreRoutes = ['filament.admin.pages.pending', 'filament.admin.pages.blocked'];
        if ($user && !in_array($routeName, $ignoreRoutes)) {
            if ($user->status === 'pending') {
                return redirect()->route('filament.admin.pages.pending');
            }
            if ($user->status === 'blocked') {
                return redirect()->route('filament.admin.pages.blocked');
            }
        }
        return $next($request);
    }
}
