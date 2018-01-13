<?php

namespace Kluverp\Pcmn\Middleware;

use Closure;
use Kluverp\Pcmn\Models\User;

class Pcmn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // check if we can login by using session
        if ($user = User::bySession()) {
            view()->share('user', $user);
            return $next($request);
        }

        // if we have a remember_me token try using that
        if ($token = $request->cookie('remember_token')) {
            if ($user = User::byToken($token)) {
                view()->share('user', $user);
                return $next($request);
            }
        }

        // in all other cases, we redirect the user back to login
        return redirect()->route('pcmn.auth.login');
    }
}
