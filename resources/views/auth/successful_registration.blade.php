@extends('layouts.app')

@section('content')
  <div class="content-body successful-register-body">
    <div class="resend">
      <p> {!! __('controller/register.pwd_sent') !!}</p>
      <form id="resendForm" method="GET" action="{{ route('resend') }}">
        {{ csrf_field() }}
        <button disabled id="button" class="repass-btn-dis">@lang('home/login.repass_btn')
          <span id="timer">59</span>
        </button>
      </form>
      <span class="help-block-reset-pwd" style="color:lightseagreen; width: 265px"></span>
    </div>
  </div>
  <input type="hidden" name="hidden" class="my-input password-input">
  <div class="error-message
                  error-message4
                  not_confirmed_resend
                  smth_went_wrong
                  invalid_send_mail
                  reset_limit_exceeded
                  invalid_post_service
                  error_while_registration
                  user_not_found
                  invalid_send_reset_mail
                  reg_limit_exceeded
                  error_occured">
    @if ($errors->has('not_confirmed_resend')
     or $errors->has('smth_went_wrong')
      or $errors->has('invalid_send_mail')
       or $errors->has('error_occured')
        or $errors->has('invalid_post_service')
         or $errors->has('error_while_registration')
          or $errors->has('user_not_found')
            or $errors->has('invalid_send_reset_mail')
            or $errors->has('reg_limit_exceeded') )
      <i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i>&nbsp
    @endif
  </div>
@endsection