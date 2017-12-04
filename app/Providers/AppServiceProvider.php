<?php

namespace App\Providers;

use App\UserWalletFields;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      error_reporting(0);
      Schema::defaultStringLength(191);
      Validator::extend('unique_wallet', function($attribute, $value, $parameters, $validator) {
          $query = UserWalletFields::select('*');
          $columns = ['wallet_get_tokens', 'wallet_invest_from', 'ETH', 'BTC'];
          foreach ($columns as $column)
          {
            $query->orWhere($column, '=', $value);
          }
          $overlap = $query->count();
          if ($overlap < 1) {
            return true;
          } else {
            return false;
          }
      });
      Validator::extend('unique_wallet_update', function($attribute, $value, $parameters, $validator) {
        $query = DB::select("SELECT 
            SUM(
            INSTR(
            LOWER(    CONCAT_WS(\";\", `wallet_get_tokens`,`ETH`,`BTC`)   ), 
            LOWER(\"".$value."\")
                )
                 ) found
            FROM `user_wallet_fields` WHERE user_id<>".Auth::id());
        if ($query[0]->found < 1) {
          return true;
        } else {
          return false;
        }
      });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
