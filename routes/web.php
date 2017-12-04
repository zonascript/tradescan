<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' =>  ['guest']], function(){

  Route::get('/', function () {
    return view('welcome');
  })->name('root');

});

Auth::routes();

Route::any('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/change_email', 'Auth\ChangeEmailController@change_email')->name('change_email');
Route::get('/change_password', 'Auth\ChangePasswordController@change_password')->name('change_password');
Route::get('/mycrypto', 'MycryptoController@mycrypto')->name('mycrypto');
Route::get('/current_wallets', 'MycryptoController@current_wallets')->name('current_wallets');
Route::get('/resend', 'Auth\RegisterController@resend')->name('resend');
Route::get('/users/confirmation/{token}', 'Auth\RegisterController@confirmation')->name('confirmation');


Route::post('/goToAgreement2', 'Auth\StepValidation\AgreementController@goToAgreement2')->name('goToAgreement2');
Route::post('/reset_email', 'Auth\ChangeEmailController@reset_email')->name('reset_email');
Route::post('/renew_password', 'Auth\ChangePasswordController@renew_password')->name('renew_password');
Route::post('/store_personal_data', 'Auth\StepValidation\AgreementController@store_personal_data')->name('store_personal_data');
Route::post('/update_wallet_data', 'MycryptoController@update_wallet_data')->name('update_wallet_data');
Route::post('/store_wallet_data', 'MycryptoController@store_wallet_data')->name('store_wallet_data');



Route::group(['middleware' =>  ['agreement1']], function(){
  Route::get('/agreement1', 'Auth\StepValidation\Agreement1Controller@agreement1')->name('agreement1');
});

Route::group(['middleware' =>  ['agreement2']], function(){
  Route::get('/agreement2', 'Auth\StepValidation\Agreement2Controller@agreement2')->name('agreement2');
});

Route::group(['middleware' =>  ['notConfirmed']], function() {
  Route::get('/successRegister', 'Auth\RegisterController@successRegister')->name('successRegister');
});

Route::get('lang/{lang}', ['as'=>'lang.switch', 'uses'=>'LanguageController@switchLang']);