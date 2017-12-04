@extends('layouts.app')

@section('content')

  <div class="content-body email-body">
    <h3>@lang('home/password_recovery_send_email.pwd_recovery_title')</h3>
    <form id="emailForm" method="POST" action="{{ route('password.email') }}">
      {{ csrf_field() }}

      <label for="email" class="email-label">@lang('home/password_recovery_send_email.email_label')</label>
      <input type="text" name="email" class="my-input email-input">
      <div class="error-message error-message0 email">
        @if ($errors->has('email'))
          <i class='fa fa-exclamation-circle fa-lg' aria-hidden='true'></i>&nbsp{{ $errors->first('email') }}
        @endif
      </div>

      <div class="success-sent help-block-please-wait">
        <div class="spinner">
          <div class="rect1"></div>
          <div class="rect2"></div>
          <div class="rect3"></div>
          <div class="rect4"></div>
          <div class="rect5"></div>
        </div>
        <p>@lang('home/register.please_w8')</p>
      </div>
      @if (session('status'))
        <div class="success-sent">
          <i class='fa fa-exclamation-circle fa-2x' aria-hidden='true'></i>
          <p>{{ session('status') }}</p>
        </div>
      @endif


      <div class="g-recaptcha" data-theme="dark" data-sitekey="{{ env('RE_CAP_SITE') }}"></div>
      <div class="error-message error-message3 captcha-block g-recaptcha-response">
        @if ($errors->has('captcha'))
          <i class='fa fa-exclamation-circle fa-lg' aria-hidden='true'></i>&nbsp{{ $errors->first('captcha') }}
        @endif
      </div>
      <button type="submit" class="login-btn reusable-btn">@lang('home/password_recovery_send_email.send_btn')</button>
      <div class="reg-on-log">
        <a class="register-on-login" href="{{ route('register') }}"> @lang('home/login.register_btn') </a>
        <a class="register-on-login" href="{{ route('login') }}"> @lang('home/login.login_btn') </a>
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
                  invalid_send_reset_mail">
        @if ($errors->has('not_confirmed_resend')
         or $errors->has('smth_went_wrong')
          or $errors->has('invalid_send_mail')
           or $errors->has('reset_limit_exceeded')
            or $errors->has('invalid_post_service')
             or $errors->has('error_while_registration')
              or $errors->has('user_not_found')
                or $errors->has('invalid_send_reset_mail') )
          <i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i>&nbsp
        @endif
      </div>

    </form>

    @if ($errors->has('captcha'))
      <span class="help-block captcha-block">
          <i class='fa fa-exclamation-circle fa-lg' aria-hidden='true'></i>&nbsp{{ $errors->first('captcha') }}
      </span>
    @endif
  </div>
@endsection
@section('script')
  <script>
    $('#emailForm').on('submit', function () {
//      $('.help-block-please-wait').show();

    });
  </script>
@endsection