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
use Illuminate\Support\Facades\Validator;


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
    $validator = Validator::make($request->all(),
      [
        'email' => 'required|email|min:7|max:255',
        'g-recaptcha-response' => 'required'
      ]);

    if ($validator->fails()) {
      return response()->json(['validation_error'=>$validator->errors()]);
    }

    $user = User::where('email', $request['email'])->first();
    if (!$user) {
      return response()->json(['user_not_found' => trans('auth.not_found')]);
    }
    if ($user->confirmed == 0) {

      $reg = new RegisterController();
      if ($user->reg_attempts == 5) {
        return response()->json(['reg_limit_exceeded' => trans('home/register.reg_limit_exceeded')]);
      }
      $reg->thisConfirmationEmailSend($user, 3);
      $user->reg_attempts++;
      $user->save();

      return response()->json(['not_confirmed_resend' => trans('auth.not_confirmed_resend')]);
    }

    $request->session()->put('reset_password_email', $request['email']);
    if($user->reset_attempts == 5) {
      return response()->json(['reset_limit_exceeded' => trans('home/register.reset_limit_exceeded')]);
    }
      $response = $this->sendNewEmail($user, 3, 'reset_pwd', null);
      if (!$response or empty($response->result)) {
        return response()->json(['invalid_send_reset_mail' => trans('auth.invalid_send_reset_mail')]);
      }
      $user->reset_attempts++;
      $user->save();

    return response()->json(['reset_pwd' => trans('home/mails.reset_pwd_msg')]);
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
