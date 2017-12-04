<?php

namespace App\Http\Controllers\Auth\StepValidation;

use App\Http\Controllers\Controller;

class Agreement2Controller extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('agreement2');
  }

  public function agreement2()
  {
      return view('auth.agreement2');
  }

}
