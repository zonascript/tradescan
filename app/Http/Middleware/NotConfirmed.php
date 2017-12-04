<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;

class NotConfirmed
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
    $user = User::where('email', Session::get('this_email')) -> first();

    if(!$user){
      return redirect('/')->withErrors(['error_while_registration' => Lang::get('auth.error_while_registration')]);
    }
    return $next($request);
  }
}
