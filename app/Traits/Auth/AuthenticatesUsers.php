<?php

namespace App\Traits\Auth;

use App\Http\Controllers\Auth\RegisterController;
use App\Traits\RegisterMailTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use ReCaptcha\ReCaptcha;
use App\Traits\CaptchaTrait;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;


trait AuthenticatesUsers
{
    use RedirectsUsers, ThrottlesLogins, CaptchaTrait, RegisterMailTrait;

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(),
        [
          $this->username() => 'required|string|email|min:7',
          'password' => 'required|string|min:3|max:1024',
          'g-recaptcha-response'  => 'required'
        ]);

        if ($validator->fails()) {
          return response()->json(['validation_error'=>$validator->errors()]);
        }

        $current_user = User::where('email',$request['email']) -> first();

        if (!$current_user){
          return response()->json(['failed'=>trans('auth.failed')]);
        } else {
          $passwordIsVerified = password_verify( $request['password'], $current_user->password );
        }

        if (!$passwordIsVerified){
          return response()->json(['pwd_not_match'=>trans('controller/changeEmail.pwd_not_match')]);
        }

        if( $current_user && $passwordIsVerified && $current_user->confirmed == 0 ){
          $reg = new RegisterController();
          if( $current_user->reg_attempts == 5){
            return response()->json(['reg_limit_exceeded' => trans('home/register.reg_limit_exceeded')]);
          }
          $reg->thisConfirmationEmailSend($current_user, 3);
          $current_user->reg_attempts++;
          $current_user->save();
          return response()->json(['not_confirmed_resend' => trans('auth.not_confirmed_resend')]);
        }

        $request['token'] = $current_user->token;
        $this->guard()->login($current_user);
        return response()->json(['status', trans('controller/changePassword.success')]);
    }


    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        //
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws ValidationException
     */

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
