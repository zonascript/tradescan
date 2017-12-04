<?php

namespace App\Exceptions;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
Use Illuminate\Support\Facades\Log;
use App\User;
use App\UserPersonalFields;
use Illuminate\Http\Response;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {

      $user = User::find(Auth::id());
      $user_fields = UserPersonalFields::where('user_id', $user['id'])->first();
      $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

      $send_obg = [
        'error_message' => '[ '.$exception->getMessage().' ]',
        'code' => 'Code: '.app('Illuminate\Http\Response')->status(),
        'path' => 'Path: '.$exception->getFile(),
        'line' => 'Line: '.$exception->getLine(),
        'url' => 'URL: '.$url,
        'user_id' =>'user_id: '.$user['id'],
        'email' => 'email: '.$user['email'],
        'name' => 'name: '.$user_fields['name_surname'],
        'phone' => 'phone: '.$user_fields['phone'],
        'telegram_login' => 'telegram_login: '.$user_fields['telegram'],
        'country' => 'country: '.$user_fields['country'],
        'ip' => 'ip: '.$_SERVER['REMOTE_ADDR'],
        'user_agent' => 'user_agent: '.$request->header('User-Agent'),
      ];

      $str =  implode("\n",$send_obg);
      $client = new Client();
      if($send_obg['error_message'] != '[ The given data was invalid. ]'){ // If someone didn`t pass the validation process of any form.
        $client->request('POST', 'https://api.telegram.org/bot332505269:AAG7jDDCaYBbAxdpsfinBzSIZJam-yj0rfk/sendmessage', [
          'json' => [
            'chat_id' => env('EMERGENCY_CHAT_ID'),
            'text' => $str,
          ]
        ]);
      }

      return parent::render($request, $exception);
    }
}
