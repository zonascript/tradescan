<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
  public function handle($request, Closure $next, $guard = null)
  {

    if (Auth::guard($guard)->check()) {
      return redirect('/home');
    }

    $token = Input::get('code');
    $host = Input::get('host');

    if ($request->has(['c', 'email', 'code', 'host'])) {
          return redirect(route('confirmation', ['token' => $token, 'host' => $host]));
    }
    return $next($request);
  }
}
