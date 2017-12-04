<?php

namespace App\Http\Controllers;

use App\User;
use App\UserInformation;
use App\UserPersonalField;
use App\UserPersonalFields;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Traits\CaptchaTrait;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\UserWalletFields;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
class HomeController extends Controller
{
  use CaptchaTrait;
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
      $this->middleware('valid');

  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  protected function get_period($time){

    if($time >= env('PRE_ICO_START') && $time < env('PRE_ICO_END')){
      return 'pre_ico';
    } else if($time >= env('ICO_START') && $time < env('ICO_END')) {
      return 'ico';
    } else {
      return 'out';
    }

  }

  protected function get_currency_name($currency){
    switch($currency) {
      case 'ETH': $currency = 'Ethereum';
        break;
      case 'BTC': $currency = 'Bitcoin';
        break;
    }
    return $currency;
  }

  protected function get_wallet_data($data){

    @include '../../ICOpayscript/src/search.php';

    if($data['wallet_invest_from'] == $data['wallet_get_tokens']){
      return collect(searchTx(array(
        array('eth',$data['wallet_get_tokens']),
        array('token',$data['wallet_get_tokens']),
      )))->sortByDesc('time');
    }

    return collect(searchTx(array(
      array(strtolower($data['name_of_wallet_invest_from']),$data['wallet_invest_from']),
      array('eth',$data['wallet_get_tokens']),
      array('token',$data['wallet_get_tokens']),
    )))->sortByDesc('time');

  }

  protected function get_widget_data(){

    @include '../../ICOpayscript/json/widget.conf';
    @include '../widget_data.conf';

    if($widget_data && $widget){
      $widget_data['invested'] = round($widget['raiseUSD']);
      $widget_data['invest_cap'] = $widget['hardcapUSD'];
      $widget_data['currencies'][0]['value'] = round($widget['ETH']);
      $widget_data['currencies'][1]['value'] = round($widget['BTC'],2);
      $widget_data['crypto_progress_percents'] = round($widget['percent'],1).'%';
      return json_encode($widget_data);
    }

  }

  public function index()
  {
    Session::forget('reset_password_email');
    $data = array();
    $time = is_numeric(Input::get('time')) ? Input::get('time') : time();
    $walletFields = UserWalletFields::where('user_id', Auth::id())->first();

    if($walletFields){
      $walletFields['full_name_of_wallet_invest_from'] = $this->get_currency_name($walletFields['name_of_wallet_invest_from']);
      $data['walletFields'] = $walletFields;
    }

    @$data['widget_data'] = $this->get_widget_data();
    @$data['transactions'] = $this->get_wallet_data($walletFields);
    $data['walletFields'] = null;
    $data['period'] = $this->get_period($time);
    $data['time'] = $time;

    if($walletFields){
      $walletFields['full_name_of_wallet_invest_from'] = $this->get_currency_name($walletFields['name_of_wallet_invest_from']);
      $data['walletFields'] = $walletFields;
    }


    return view('home.home')->with('data', $data);
  }
}
