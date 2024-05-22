<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;

class CheckUserStatus
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        if ($user && !$user->company_id) {
            $activeUntil = $user->active_until ? Carbon::parse($user->active_until) : Carbon::now();
            $currentDateTime = Carbon::now();

            if ($activeUntil && $activeUntil < $currentDateTime) {
                return response()->json([
                    'status' => false,
                    'message' => __('auth.expired'),
                    'code' => 409
                ], 409);
            } 
        }

        return $next($request);
    }
}
