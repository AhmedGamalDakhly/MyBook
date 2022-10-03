<?php

namespace App\Http\Middleware;

use App\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UserActivityStatus
{
    /**
     * Handle an incoming request. (Track and Update Activity Status of the user)
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        // used to know the status of the user (Active or Not Active) by using cache
        $userID=Auth::user()['id'];
        if (Auth::check()) {
            $expiresAt = Carbon::now()->addMinutes(1); // keep as active user  for 1 min
            Cache::put('user-is-online-' . $userID, true, $expiresAt);
            User::where('id', $userID)->update(['last_seen' => (new \DateTime())]);//save time  when the user  last seen
        }
        return $next($request);
    }

}
