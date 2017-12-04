<?php

namespace App\Http\Controllers\Auth\StepValidation;

use App\Http\Controllers\Controller;
use App\User;
use App\UserPersonalFields;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
class AgreementController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  protected function create(array $data)
  {
    return UserPersonalFields::create([
      'user_id'=> Auth::id(),
      'name_surname' => $data['name_surname'],
      'telegram' => $data['telegram'],
      'emergency_email' => $data['emergency_email'],
      'permanent_address' => $data['permanent_address'],
      'contact_number' => $data['contact_number'],
      'date_place_birth' => $data['date_place_birth'],
      'nationality' => $data['nationality'],
      'source_of_funds' => $data['source_of_funds'],
      'presumptive_investment' => $data['presumptive_investment'],
    ]);
  }

  public function goToAgreement2()
  {
    $user = User::find(Auth::id());
    $user->valid_step = 2;
    $user->save();
    return redirect(route('agreement2'));
  }

  public function store_personal_data(Request $request)
  {
    $input = $request->all();
    $data = $this->create($input)->toArray();
    if(!$data) {
      return redirect()->back()->with('status', Lang::get('controller/agreement.smth_went_wrong'));
    }

      $user = User::find(Auth::id());
      $user->valid_step = 3;
      $user->valid_at = Carbon::now();
      $user->save();
      return redirect(route('home'));
  }

}
