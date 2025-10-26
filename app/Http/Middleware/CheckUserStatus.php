<?php

namespace App\Http\Middleware;

use App\Enums\UserStatus;
use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user() ?? Filament::auth()->user();
        $routeName = $request->route()?->getName();
        $pendingRoute = 'filament.admin.pages.pending';
        $blockedRoute = 'filament.admin.pages.blocked';

        if ($user) {
            // If pending, force them onto pending page only
            if ($user->status === UserStatus::PENDING->value) {
                if ($routeName !== $pendingRoute) {
                    return redirect()->route($pendingRoute);
                }
            }

            // If blocked, force them onto blocked page only
            if ($user->status === UserStatus::BLOCKED->value) {
                if ($routeName !== $blockedRoute) {
                    return redirect()->route($blockedRoute);
                }
            }

            // If active, stop them from accessing pending or blocked
            if ($user->status === UserStatus::ACTIVE->value) {
                if ($routeName === $pendingRoute || $routeName === $blockedRoute) {
                    return redirect()->route('filament.admin.pages.dashboard'); // dashboard or homepage
                }
            }
        }

        return $next($request);
    }
}
