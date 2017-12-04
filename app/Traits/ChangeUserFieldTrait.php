<?php namespace App\Traits;


use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Lang;

trait ChangeUserFieldTrait
{

  public function sendNewEmail($data, $timeout, $key, $data_old = null)
  {

    for ($i = 0; $i < 3; $i++) {
      $api_key = "6jbnone8wamhti3m7duz5wjypxki8mhua9853mdo";
      $email_from_name = 'Example Support';
      $email_from_email = 'info@cryptob2b.io';
      $email_to = ($data_old) ? $data_old['email'] : $data['email'];
      $email_body = ($key == 'email') ?
          (($data_old) ?
              view('mails/change_email_confirmation', ['email' => $data[$key]]) :
              view('mails/change_email_confirmation', ['email' => null])) :
          (($key == 'password') ?
              view('mails/change_password_confirmation') :
              view('mails/reset_password_confirmation', ['email' => $data['email'], 'token' => $data['remember_token']]));
      $email_subject = ($key == 'email') ? 'New email at example.cryptob2b.io' : (($key == 'password') ? 'New password at zabercoin.co.za' : 'Reset password at example.cryptob2b.io');
      $list_id = 11766981;
      $request = [
        'api_key' => $api_key,
        'sender_name' => $email_from_name,
        'sender_email' => $email_from_email,
        'subject' => $email_subject,
        'body[0]' => $email_body,
        'list_id' => $list_id,
        'email[0]' => $email_to,
      ];

      // Устанавливаем соединение
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
      curl_setopt($ch, CURLOPT_URL, 'https://api.unisender.com:443/en/api/sendEmail?format=json');

      $result = curl_exec($ch);

      if ($result) {
        // Раскодируем ответ API-сервера
        $jsonObj = json_decode($result);

        if (null === $jsonObj) {
          // Ошибка в полученном ответе
          Log::info('Invalid JSON');

        } elseif (!empty($jsonObj->error)) {
          // Ошибка отправки сообщения
          Log::info('An error occured: ' . $jsonObj->error . ' | code: ' . $jsonObj->code);
        } else {
          // Сообщение успешно отправлено
          Log::info('Email message is sent. Message id ' . $jsonObj->result[0]->id);
        }

        return $jsonObj;

      } else {

        $timeout *= 3;
        $response = $this->sendNewEmail($data, $timeout, $key, $data_old);
      }

      if ($i == 2) {
        // Ошибка соединения с API-сервером$answer = 'API access error';
        Log::info('API access error');
        return null;
      }
    }
  }

}