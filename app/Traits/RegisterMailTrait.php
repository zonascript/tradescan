<?php namespace App\Traits;


use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Lang;

trait RegisterMailTrait
{

  public function sendConfirmationEmail($data, $timeout)
  {

    $api_key = "6jbnone8wamhti3m7duz5wjypxki8mhua9853mdo";
    $user_email = $data['email']; // юзер
    $user_lists = "11766981"; // не менять
    $user_ip = $_SERVER['REMOTE_ADDR'] == '127.0.0.1' ? '163.172.200.3' : $_SERVER['REMOTE_ADDR']; // ип юзера
    $user_tag = urlencode("SignInAPI"); //не менять

    $POST = array(
      'api_key' => $api_key,
      'list_ids' => $user_lists,
      'fields[email]' => $user_email,
      'fields[code]' => $data['token'], // передать токен для регистрации
      'fields[host]' => "$_SERVER[HTTP_HOST]", // передать host для редиректа
      'fields[code2]' => $data['ip_token'], // сгенерить код такой длины и записать в базу, просто так, на будущее (включить ИП юзера)
      'request_ip' => $user_ip,
      'tags' => $user_tag,
      'double_optin' => 0,
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $POST);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_URL, 'https://api.unisender.com:443/en/api/subscribe?format=json');

    $result = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $jsonObj = json_decode($result);

    $obj = ['result' => $result, 'jsonObj' => $jsonObj, 'code' => $code, 'input' => $POST];
      return $obj;

    }

}