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
    $c = Input::get('c');
    $token = Input::get('code');
    $email = Input::get('email');
    $host = Input::get('host');
    $user = User::where('email', $email) -> first();
    if ($request->has(['c', 'email', 'code', 'host'])) {
      if($user){
        if($token != $user->token || $c != 'reg'){
          return redirect('/');
        } else {
          return redirect(route('confirmation', ['token' => $token, 'host' => $host]));
        }
      }
    }
    return $next($request);
  }
}
