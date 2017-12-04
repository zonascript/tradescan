@extends('layouts.app')

@section('content')

  <div class="content-body reset-body">
    <h3>@lang('home/password_recovery_fields.creating_new_pwd_title')</h3>
    <form id="resetForm" method="POST" action="{{ route('password.request') }}">
      {{ csrf_field() }}
      <input type="hidden" name="token" value="{{ $token }}">
      <label for="email" class="email-label">@lang('home/login.email_label')</label>
      <input type="text" name="email" class="my-input email-input" value="{{ Session::get('reset_password_email')}}">

      <div class="error-message error-message0">

        @if (session('errors'))
          @if ($errors->has('email'))
            <i class='fa fa-exclamation-circle fa-lg' aria-hidden='true'></i>&nbsp{{ $errors->first('email') }}
          @endif
          @if (session('errors')->first('reset_email_not_match'))
            <i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i>&nbsp{{ session('errors')->first('reset_email_not_match') }}
          @endif
        @endif

      </div>

      <label for="password" class="password-label">@lang('home/change_password.new_pwd')</label>
      <input type="password" name="password" class="my-input password-input">

      <div class="error-message error-message1">
        @if ($errors->has('password'))
          <i class='fa fa-exclamation-circle fa-lg' aria-hidden='true'></i>&nbsp{{ $errors->first('password') }}
        @endif
      </div>
      <label for="password_confirmation" class="password-label">@lang('home/password_recovery_fields.confirm_new_password')</label>
      <input type="password" name="password_confirmation" class="my-input password-input">

      <div class="error-message error-message2">
        @if ($errors->has('password_confirmation'))
          <i class='fa fa-exclamation-circle fa-lg' aria-hidden='true'></i>&nbsp{{ $errors->first('password_confirmation') }}
        @endif
      </div>

      <div class="g-recaptcha" data-theme="dark" data-sitekey="{{ env('RE_CAP_SITE') }}"></div>
      <button type="submit" class="login-btn reusable-btn">  @lang('home/password_recovery_fields.confirm_n_enter_btn')  </button>
    </form>
    @if ($status = Session::get('status'))
      <span class="help-block">
            {{ $status }}
        </span>
    @endif
    @if ($errors->has('captcha'))
      <span class="help-block captcha-block">
          <i class='fa fa-exclamation-circle fa-lg' aria-hidden='true'></i>&nbsp{{ $errors->first('captcha') }}
      </span>
    @endif
  </div>
  <br><br><br><br><br>
@endsection
