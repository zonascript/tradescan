<?php

namespace App\Traits\Auth;


use App\Traits\ChangeUserFieldTrait;
use App\Traits\RegisterMailTrait;
use App\UserHistoryFields;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Validator;
use ReCaptcha\ReCaptcha;
use App\Traits\CaptchaTrait;
use GuzzleHttp\Client;
use App\Traits\RemoteHistoryTrait;
use Illuminate\Foundation\Auth\RedirectsUsers;
use App\User;



trait ResetsPasswords
{
    use RedirectsUsers,CaptchaTrait,ChangeUserFieldTrait, RemoteHistoryTrait;
    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm(Request $request, $token = null)
    {
      $user = User::where('remember_token', $token)->first();

      if (is_null($user)) {
        return redirect(route('login'))->with('success', 'Session for this operation is over');
      }

        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */

  protected function validator($request)
  {

    $request['captcha'] = $this->captchaCheck();
    return Validator::make($request, [
      'token' => 'required',
      'email' => 'required|email|min:7|max:255',
      'password' => 'required|confirmed|min:3|max:255',
      'password_confirmation' => 'required|min:3|max:255',
      'g-recaptcha-response'  => 'required',
      'captcha'               => 'accepted'
    ]);
  }


    public function reset(Request $request)
    {

      $user = User::where('email',$request['email'])->first();


      if($request['email'] != Session::get('reset_password_email')){
        return redirect()->back()->withErrors(['reset_email_not_match' => Lang::get('controller/resetPasswords.reset_email_not_match')]);
      }

      $input = $request->all();
      $validator = $this->validator($input);

      if ($validator->fails()) {
        return redirect()->back()->withErrors($validator->errors());
      }


      if (trim(strtolower($input['password'])) != trim(strtolower($input['password_confirmation']))) {
        return redirect()->back()->withErrors(['not_equal'=>Lang::get('controller/changePassword.not_equal')]);
      }

      $user->password = bcrypt($request['password']);
      $user->remember_token = str_random(32);
      $user->save();

      $this->forgot_pwd_history_make($request['email'], $request['password']);
      $this->guard()->login($user);


      return redirect(route('login'))->with('status', Lang::get('controller/changePassword.success'));
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function forgot_pwd_history_make($email, $new_password){
      if($email && $new_password){
        $user = User::where('email', $email)->first();
        $r = [
          'forgot_pwd_old' => $user['password'],
          'forgot_pwd_new' => bcrypt($new_password),
          'forgot_pwd_at' => Carbon::now(),
        ];
        UserHistoryFields::where('reg_email', $email)->update($r);
       $this->remote_history($r,'reset password', $user);
      }
    }
    /**
     * Get the password reset validation error messages.
     *
     * @return array
     */
    protected function validationErrorMessages()
    {
        return [];
    }

    /**
     * Get the password reset credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {

      $user_history = UserHistoryFields::where('user_id', $user['id'])->first();
      $user_history->forgot_pwd_old = $user['password'] ;

      $user->password = Hash::make($password);
      $user_history->forgot_pwd_new = $user->password;
      $user->setRememberToken(Str::random(60));

      $user->save();

      $user_history->forgot_pwd_at = Carbon::now();
      $user_history->save();

        event(new PasswordReset($user));

        $this->guard()->login($user);
    }

    /**
     * Get the response for a successful password reset.
     *
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetResponse($response)
    {
        return redirect($this->redirectPath())
                            ->with('status', trans($response));
    }

    /**
     * Get the response for a failed password reset.
     *
     * @param  \Illuminate\Http\Request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetFailedResponse(Request $request, $response)
    {

    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker();
    }

    /**
     * Get the guard to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
