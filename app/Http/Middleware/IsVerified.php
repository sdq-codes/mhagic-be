<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;

class IsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     * @throws AuthorizationException
     */
    public function handle($request, Closure $next)
    {
        // Pre-Middleware Action
        if (!$request->user()->email_verified){
            throw new AuthorizationException('Please Kindly Verify Your Email Address');
        }
        // Post-Middleware Action
        return $next($request);
    }
}
