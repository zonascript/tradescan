<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
Use Illuminate\Support\Facades\Log;
use App\User;
class agreement1
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

      $user = User::find(Auth::id());
      switch($user['valid_step']) {
        case 0: return redirect('logout');
          break;
        case 2: return redirect('agreement2');
          break;
        case 3:  return redirect('home');
          break;
      }
        return $next($request);
    }
}
