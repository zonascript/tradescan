<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserHistoryFields extends Authenticatable
{
  use Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'user_id','reg_email','reg_pwd', 'reg_at', 'forgot_pwd_new','forgot_pwd_old', 'forgot_pwd_at',
    'change_email_new','change_email_old', 'change_email_at','change_pwd_new','change_pwd_old', 'change_pwd_at',
    'add_wallet_currency','add_wallet_number', 'add_wallet_at',
    'change_wallet_currency_new','change_wallet_currency_old', 'change_wallet_number_new', 'change_wallet_number_old','change_wallet_at',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [

  ];

}
