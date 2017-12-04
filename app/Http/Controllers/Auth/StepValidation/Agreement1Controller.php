<?php

namespace App\Http\Controllers\Auth\StepValidation;

use App\Http\Controllers\Controller;

class Agreement1Controller extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('agreement1');
  }

  public function agreement1()
  {
    return view('auth.agreement1');
  }

}
