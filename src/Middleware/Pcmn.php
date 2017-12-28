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
        // check if authentication token is set, or show login
        if (!$user = User::bySession(session('pcmn.auth_token'))) {
            return redirect()->to('/');
        }

        // check if authentication token is expired
        if ($user->auth_token_expiration < time()) {
            return redirect()->to('/');
        }

        return $next($request);
    }
}
