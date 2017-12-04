<?php

namespace App\Http\Controllers\Auth;

use App\Traits\ChangeUserFieldTrait;
use App\User;
use App\Http\Controllers\Controller;
use App\UserHistoryFields;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use ReCaptcha\ReCaptcha;
use App\Traits\CaptchaTrait;
use Mail;
use GuzzleHttp\Client;
use App\Traits\RemoteHistoryTrait;


use Illuminate\Support\Facades\URL;

class ChangeEmailController extends Controller
{
  use CaptchaTrait, ChangeUserFieldTrait,RemoteHistoryTrait;
  /*
  |--------------------------------------------------------------------------
  | Register Controller
  |--------------------------------------------------------------------------
  |
  | This controller handles the registration of new users as well as their
  | validation and creation. By default this controller uses a trait to
  | provide this functionality without requiring any additional code.
  |
  */

  use RegistersUsers;

  /**
   * Where to redirect users after registration.
   *
   * @var string
   */
  protected $redirectTo = '/home';

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('valid');

  }

  protected function change_email_history_make($old_email, $new_email){
    $chm = [
      'change_email_old' => $old_email,
      'change_email_new' => $new_email,
      'change_email_at' => Carbon::now(),
    ];
    if($old_email && $new_email){
      UserHistoryFields::where('user_id', Auth::id())->update($chm);
      $this->remote_history($chm, 'change email', null);
    }
  }

  /**
   * Get a validator for an incoming registration request.
   *
   * @param  array $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  protected function validator(array $data)
  {
    return Validator::make($data, [
      'email1' => 'required|string|email|min:7|max:255',
      'email2' => 'required|string|email|min:7|max:255',
      'password' => 'required|string|min:3|max:1024',
      'g-recaptcha-response' => 'required',
    ]);
  }

  /**
   * Create a new user instance after a valid registration.
   *
   * @param  array $data
   * @return \App\User
   */
  public function change_email()
  {
    return view('home.change_email');
  }

  public function reset_email(Request $request)
  {

    $input = $request->all();
    $validator = $this->validator($input);
    $user = $request->user();
    $possible_user = User::where('email', $input['email2'])->first();
    $passwordIsVerified = password_verify($request['password'], $user->password);

    if ($validator->fails()) {
      return response()->json(['validation_error'=>$validator->errors()]);
    }

    if ($user->email != $input['email1']) {
      return response()->json(['not_your_email'=>Lang::get('controller/changeEmail.not_yours')]);
    }

    if (trim(strtolower($input['email1'])) == trim(strtolower($input['email2']))) {
      return response()->json(['not_equal'=>Lang::get('controller/changeEmail.not_equal')]);

    }
    if (!$passwordIsVerified) {
      return response()->json(['pwd_not_match'=>Lang::get('controller/changeEmail.pwd_not_match')]);
    }
    if (!$user || $possible_user) {
      return response()->json(['is_taken'=>Lang::get('controller/changeEmail.is_taken')]);
    }

    $user->email = $input['email2'];
    $user->save();

    $this->change_email_history_make($input['email1'], $input['email2']);
    return response()->json(['status', Lang::get('controller/changeEmail.success')]);

  }
}
