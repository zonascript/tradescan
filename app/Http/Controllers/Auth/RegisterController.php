<?php

namespace App\Http\Controllers\Auth;

use App\Traits\ChangeUserFieldTrait;
use App\Traits\SendDataServerTrait;
use App\User;
use App\Http\Controllers\Controller;
use App\UserHistoryFields;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Traits\Auth\RegistersUsers;
use phpDocumentor\Reflection\Types\Null_;
use ReCaptcha\ReCaptcha;
use App\Traits\CaptchaTrait;
use App\Traits\RegisterMailTrait;
use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Client;
use App\Traits\RemoteHistoryTrait;


class RegisterController extends Controller
{
  use CaptchaTrait, RegisterMailTrait, ChangeUserFieldTrait, SendDataServerTrait;
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

    use RegistersUsers, RemoteHistoryTrait;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      $this->middleware('guest');

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|string|email|min:7|max:255|unique:users',
            'password' => 'required|alpha_num|min:3||max:255',
            'g-recaptcha-response'  => 'required'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */

    protected function create(array $data)
    {
        $referred_by = Cookie::get('referral');
        return User::create([
            'email' => $data['email'],
            'password' => $data['password'],
            'affiliate_id' => str_random(10),
            'referred_by'   => $referred_by
        ]);
    }
    
    protected function registration_history_make($user){
      $r = [
        'user_id'=> $user->id,
        'reg_email' => $user->email,
        'reg_pwd' => $user->password,
        'reg_at' => Carbon::now()
      ];
      UserHistoryFields::create($r);
     $this->remote_history($r,'registration',null);

    }

    public function successRegister()
    {
      return view('auth.successful_registration');
    }
    public function resend()
    {
      $email = Session::get('this_email');
      $user = User::where('email', $email)->first();

      if($user->reg_attempts == 5){
        return response()->json(['reg_limit_exceeded' => trans('home/register.reg_limit_exceeded')]);
      }
      $this->thisConfirmationEmailSend($user,3);
      $user->reg_attempts++;
      $user->save();
      return response()->json(['resend' => Lang::get('controller/register.pwd_resent')]);
    }

    public function thisConfirmationEmailSend($data, $timeout)
    {
      $regObj = $this->sendConfirmationEmail($data, $timeout);

      for ($i = 0; $i < 4; $i++) {
        $timeout*=3;
        if ($regObj['code'] != 200 || strlen($regObj['result']) < 10 || $regObj['jsonObj'] != json_decode($regObj['result'])) {
          Log::info('Connection failed, trying to reconnect');
          Log::info('Server respond with code: ' . $regObj['code']);
          Log::info('Result of curl operation: ' . $regObj['result']);
          Log::info('Session Id: ' . Session::getId());
          Log::info('Client`s ip: ' . $_SERVER['REMOTE_ADDR']);
          Log::info('Timeout value: ' . $timeout);
          Log::info('Iteration: '.$i);

          if ($i == 3) {
            $data->forceDelete();
            return response()->json(['invalid_post_service' => Lang::get('auth.invalid_post_service')]);
            break;
          } else {
            $regObj = $this->sendConfirmationEmail($data, $timeout);
          }
        } else {
          break;
        }
      }

      if(null === $regObj['jsonObj']) {
        Log::info('An error occured: jsonObj = null');
        $data->forceDelete();
        return response()->json(['smth_went_wrong' => Lang::get('auth.smth_went_wrong')]);
      }

      if(!empty($regObj['jsonObj']->error)) {
        Log::info('An error occured:' . $regObj['jsonObj']->error . ', code: ' . $regObj['code']);
        $data->forceDelete();
        return response()->json(['smth_went_wrong' => Lang::get('auth.smth_went_wrong')]);
      }
    }

    public function confirmation($token, $host){
      $user = User::where('token', $token)->first();
      Log::info($host);
      if (is_null($user)) {
        return redirect(route('login'))->with('success', 'No such user');
      }

      $user->confirmed = 1;
      $user->confirmed_at = Carbon::now();
      $user->save();

      if($host){
        return redirect((isset($_SERVER['HTTPS']) ? "https://" : "http://") . $host.'/login?email='.$user['email'].'&title='.trans('auth.is_correct').'&message='.trans('auth.tnx_confirmed'));
      }
      return redirect(route('login'));
  }


    protected function register(Request $request)
    {
      $input = $request->all();
      $validator = $this->validator($input);
      $user = User::where('email', $input['email'])->first();
      if($user){
        $passwordIsVerified = password_verify($request['password'], $user->password);
        if ($user && $passwordIsVerified && $user->confirmed == 0) {
          if($user->reg_attempts == 5){
            return response()->json(['reg_limit_exceeded' => trans('home/register.reg_limit_exceeded')]);
          }
          $this->thisConfirmationEmailSend($user,3);
          $user->reg_attempts++;
          $user->save();
          return response()->json(['not_confirmed_resend' => Lang::get('auth.not_confirmed_resend')]);
        }
        if ($validator->fails()) {
          return response()->json(['validation_error'=>$validator->errors()]);
        }
      }else{
        if ($validator->fails()) {
          return response()->json(['validation_error'=>$validator->errors()]);
        }
        $data = $this->create($input)->toArray();
        $user = User::find($data['id']);
      }
      $data['token'] = str_random(10);
      $data['ip_token'] = 'ID:'.str_random(10).$_SERVER['REMOTE_ADDR'];
      $user->token = $data['token'];
      $user->remember_token = str_random(32);
      $user->reg_attempts = 1;
      $user->password = bcrypt($data['password']);
      $this->thisConfirmationEmailSend($user,3);
      $request->session()->put('this_email', $data['email']);
      $user->valid_step = 1;
      $user->save();

      $this->registration_history_make($user);
      return response()->json(['success_register' => Lang::get('controller/register.pwd_sent')]);
    }





}
