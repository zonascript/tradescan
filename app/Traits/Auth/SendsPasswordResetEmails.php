<?php

namespace App\Traits\Auth;


use App\Http\Controllers\Auth\RegisterController;
use App\Traits\ChangeUserFieldTrait;
use App\Traits\RegisterMailTrait;
use App\Traits\ResetMailTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use ReCaptcha\ReCaptcha;
use App\Traits\CaptchaTrait;
use App\User;

trait SendsPasswordResetEmails
{
  use CaptchaTrait, RegisterMailTrait, ChangeUserFieldTrait;

  /**
   * Display the form to request a password reset link.
   *
   * @return \Illuminate\Http\Response
   */
  public function showLinkRequestForm()
  {
    return view('auth.passwords.email');
  }

  /**
   * Send a reset link to the given user.
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
   */
  public function sendResetLinkEmail(Request $request)
  {
    $this->validateEmail($request);

    $user = User::where('email', $request['email'])->first();
    if (!$user) {
      return redirect()->back()->withErrors(['user_not_found' => trans('auth.not_found')]);
    }
    if ($user->confirmed == 0) {

      $reg = new RegisterController();
      if ($user->reg_attempts == 5) {
        return redirect('/')->withErrors(['reg_limit_exceeded' => trans('home/register.reg_limit_exceeded')]);
      }
      $reg->thisConfirmationEmailSend($user, 3);
      $user->reg_attempts++;
      $user->save();

      return redirect()->back()->withErrors(['not_confirmed_resend' => trans('auth.not_confirmed_resend')]);
    }

    $request->session()->put('reset_password_email', $request['email']);
    if($user->reset_attempts == 5) {
      return redirect('/')->withErrors(['reset_limit_exceeded' => trans('home/register.reset_limit_exceeded')]);
    }
      $response = $this->sendNewEmail($user, 3, 'reset_pwd', null);
      if (!$response or empty($response->result)) {
        return redirect()->back()->withErrors(['invalid_send_reset_mail' => Lang::get('auth.invalid_send_reset_mail')]);
      }
      $user->reset_attempts++;
      $user->save();

    return redirect('/')->with('reset_pwd', Lang::get('home/mails.reset_pwd_msg'));;
  }

  /**
   * Validate the email for the given request.
   *
   * @param \Illuminate\Http\Request $request
   * @return void
   */
  protected function validateEmail(Request $request)
  {
    $request['captcha'] = $this->captchaCheck();
    $this->validate($request, [
      'email' => 'required|email|min:7|max:255',
      'g-recaptcha-response' => 'required',
      'captcha' => 'accepted'
    ]);
  }

  /**
   * Get the response for a successful password reset link.
   *
   * @param  string $response
   * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
   */
  protected function sendResetLinkResponse($response)
  {

    return back()->with('status', trans($response));
  }

  /**
   * Get the response for a failed password reset link.
   *
   * @param  \Illuminate\Http\Request
   * @param  string $response
   * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
   */
  protected function sendResetLinkFailedResponse(Request $request, $response)
  {
    return back()->withErrors(
      ['email' => trans($response)]
    );
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
}
