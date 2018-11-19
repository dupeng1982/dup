<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth as AdminAuth;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Factory as Auth;

class AdminAuthMiddleware
{
    /**
     * The authentication factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (AdminAuth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                if ($guard == 'admin') {
                    return redirect()->guest('admin/login');
                } else {
                    return redirect()->guest('login');
                }
            }
        }
        $this->authenticate($guard);
        return $next($request);
    }

    protected function authenticate($guard)
    {
        if (empty($guard)) {
            return $this->auth->authenticate();
        }

        if ($this->auth->guard($guard)->check()) {
            return $this->auth->shouldUse($guard);
        }

        throw new AuthenticationException('Unauthenticated.', $guard);
    }
}
