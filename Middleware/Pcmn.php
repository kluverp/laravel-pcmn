<?php

namespace Kluverp\Pcmn\Middleware;

use Closure;
use Kluverp\Pcmn\Models\User;

class Pcmn
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
        if(!$user = User::bySession(session('pcmn.auth'))) {
            return redirect()->to('/');
        }

        return $next($request);
    }
}
