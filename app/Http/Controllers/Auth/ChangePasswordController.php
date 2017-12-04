<?php

namespace App\Http\Controllers\Auth;

use App\Traits\ChangeUserFieldTrait;
use App\User;
use App\Http\Controllers\Controller;
use App\UserHistoryFields;
use Carbon\Carbon;
use Illuminate\Foundation\PackageManifest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use ReCaptcha\ReCaptcha;
use App\Traits\CaptchaTrait;
use \Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use GuzzleHttp\Client;
use App\Traits\RemoteHistoryTrait;


class ChangePasswordController extends Controller
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

  /**
   * Get a validator for an incoming registration request.
   *
   * @param  array $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  protected function validator(array $data)
  {
    $data['captcha'] = $this->captchaCheck();
    return Validator::make($data, [
      'email' => 'required|string|email|min:7|max:255',
      'password1' => 'required|string|min:3|max:1024',
      'password2' => 'required|string|min:3|max:1024',
      'captcha' => 'accepted',
      'g-recaptcha-response' => 'required'

    ]);
  }

  /**
   * Create a new user instance after a valid registration.
   *
   * @param  array $data
   * @return \App\User
   */
  public function change_password()
  {

    return view('home.change_password');
  }

  protected function change_pwd_history_make($old_pwd, $new_pwd){
    $chp = [
      'change_pwd_old' => bcrypt($old_pwd),
      'change_pwd_new' => bcrypt($new_pwd),
      'change_pwd_at' => Carbon::now(),
    ];
    
    if($old_pwd && $new_pwd){
      UserHistoryFields::where('user_id', Auth::id())->update($chp);
      $this->remote_history($chp, 'change password', null);
    }
  }
  public function renew_password(Request $request)
  {
    $input = $request->all();
    $validator = $this->validator($input);
    $user = $request->user();
    $passwordIsVerified = password_verify($request['password1'], $user->password);

    if (strlen($user->password) < 15) {
      return redirect(route('logout'));
    }
    
    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator->errors());
    }

    if (!$passwordIsVerified) {
      return redirect()->back()->withErrors(['pwd_not_match'=>Lang::get('controller/changeEmail.pwd_not_match')]);
    }

    if ($input['email'] != $user->email && strlen($user->email) > 6) {
      return redirect()->back()->withErrors(['not_yours'=>Lang::get('controller/changeEmail.not_yours')]);
    }

    if (trim(strtolower($input['password1'])) == trim(strtolower($input['password2']))) {
      return redirect()->back()->withErrors(['not_equal'=>Lang::get('controller/changePassword.not_equal')]);
    }

    $data = [
      'password' => $input['password2'],
      'email' => $user->email
    ];
    $request->user()->fill([
      'password' => bcrypt($request['password2'])
    ])->save();

    $this->change_pwd_history_make($input['password1'], $input['password2']);
    return redirect(route('home'))->with('status', Lang::get('controller/changePassword.success'));
  }
}

