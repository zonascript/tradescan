@extends('layouts.app')

@section('content')

  <div class="content-body email-body">
    <h3>@lang('home/password_recovery_send_email.pwd_recovery_title')</h3>
    <form id="emailForm" method="POST" action="{{ route('password.email') }}">
      {{ csrf_field() }}

      <label for="email" class="email-label">@lang('home/password_recovery_send_email.email_label')</label>
      <input type="text" name="email" class="my-input email-input">
      <div class="error-message error-message0">
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
      <button type="submit" class="login-btn reusable-btn">@lang('home/password_recovery_send_email.send_btn')</button>
      <div class="reg-on-log">
        <a class="register-on-login" href="{{ route('register') }}"> @lang('home/login.register_btn') </a>
        <a class="register-on-login" href="{{ route('login') }}"> @lang('home/login.login_btn') </a>
      </div>

    </form>

    @if (session('errors'))
      @if (session('errors')->first('not_confirmed_resend'))
        <span class="help-block" style="width: 265px">
        <i class="fa fa-exclamation-circle fa-lg"
           aria-hidden="true"></i>&nbsp{{ session('errors')->first('not_confirmed_resend') }}
      </span>
      @endif
      @if (session('errors')->first('smth_went_wrong'))
        <span class="help-block" style="width: 265px">
        <i class="fa fa-exclamation-circle fa-lg"
           aria-hidden="true"></i>&nbsp{{ session('errors')->first('smth_went_wrong') }}
      </span>
      @endif
      @if (session('errors')->first('invalid_send_mail'))
        <span class="help-block" style="width: 265px">
        <i class="fa fa-exclamation-circle fa-lg"
           aria-hidden="true"></i>&nbsp{{ session('errors')->first('invalid_send_mail') }}
      </span>
      @endif
      @if (session('errors')->first('reset_limit_exceeded'))
        <span class="help-block" style="width: 265px">
        <i class="fa fa-exclamation-circle fa-lg"
           aria-hidden="true"></i>&nbsp{{ session('errors')->first('reset_limit_exceeded') }}
      </span>
      @endif
      @if (session('errors')->first('error_while_registration'))
        <span class="help-block" style="width: 265px">
            <i class="fa fa-exclamation-circle fa-lg"
               aria-hidden="true"></i>&nbsp{{ session('errors')->first('error_while_registration') }}
          </span>
      @endif
      @if (session('errors')->first('user_not_found'))
        <span class="help-block" style="width: 265px">
            <i class="fa fa-exclamation-circle fa-lg"
               aria-hidden="true"></i>&nbsp{{ session('errors')->first('user_not_found') }}
          </span>
      @endif
    @endif

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
      $('.help-block-please-wait').show();
      $(this).find("button[type='submit']").prop('disabled', true);
    });
  </script>
@endsection