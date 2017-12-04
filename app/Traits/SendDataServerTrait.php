<?php namespace App\Traits;


use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

trait SendDataServerTrait
{

  public function sendData($array)
  {
    //$arg = $this->sendEncrypt($array);
    //$url = "http://94.130.79.212:8080/x.php?x=$arg";
    $url = "/var/www/html/test.php?x=$array";
    $cmd = "curl \"$url\"";
    exec("$cmd > /dev/null 2>&1 &");
  }

  private function sendEncrypt($array)
  {
    $plaintext = serialize($array);
    $key = pack('H*', "092809839081097287127989472981827018203981209741801278087981981");
    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $plaintext, MCRYPT_MODE_CBC, $iv);
    $ciphertext = $iv . $ciphertext;
    $ciphertext_base64 = base64_encode($ciphertext);
    $ciphertext_base64 = strtr($ciphertext_base64, array('+' => ''));
    return $ciphertext_base64;
  }


}