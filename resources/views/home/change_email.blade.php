@extends('layouts.app')

@section('content')

  <div class="content-body change-email-body mycrypto-body">
    <h3>@lang('home/change_email.change_email')</h3>
    <form id="changeEmailForm" method="POST" action="{{ route('reset_email') }}">
      {{ csrf_field() }}
      <label for="email1" class="email-label">@lang('home/change_email.current_email')</label>
      <input type="text" name="email1" class="my-input email-input">

      <div class="error-message error-message0 email1 not_your_email not_equal">
        @if ($errors->has('email1'))
          <i class='fa fa-exclamation-circle fa-lg' aria-hidden='true'></i>&nbsp{{ $errors->first('email1') }}
        @endif
        @if (session('errors'))
          @if (session('errors')->first('not_yours'))
              <i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i>&nbsp{{ session('errors')->first('not_yours') }}
          @endif
          @if (session('errors')->first('not_equal'))
            <i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i>&nbsp{{ session('errors')->first('not_equal') }}
          @endif
        @endif
      </div>

      <label for="email2" class="email-label">@lang('home/change_email.new_email')</label>
      <input id="email2" type="text" class="my-input" name="email2">

      <div class="error-message error-message1 email2 not_equal is_taken">
        @if ($errors->has('email2'))
          <i class='fa fa-exclamation-circle fa-lg' aria-hidden='true'></i>&nbsp{{ $errors->first('email2') }}
        @endif
        @if (session('errors'))
          @if (session('errors')->first('is_taken'))
              <i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i>&nbsp{{ session('errors')->first('is_taken') }}
          @endif
          @if (session('errors')->first('not_equal'))
            <i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i>&nbsp{{ session('errors')->first('not_equal') }}
          @endif
        @endif
      </div>

      <label for="password" class="email-label">@lang('home/login.pwd_label')</label>
      <input id="password" type="password" class="my-input" name="password">

      <div class="error-message error-message2 password pwd_not_match">
        @if ($errors->has('password'))
          <i class='fa fa-exclamation-circle fa-lg' aria-hidden='true'></i>&nbsp{{ $errors->first('password') }}
        @endif
          @if ($errors->has('pwd_not_match'))
            <i class='fa fa-exclamation-circle fa-lg' aria-hidden='true'></i>&nbsp{{ $errors->first('pwd_not_match') }}
          @endif
      </div>

      <div class="g-recaptcha" data-theme="dark" data-sitekey="{{ env('RE_CAP_SITE') }}"></div>
      <div class="error-message error-message3 captcha-block g-recaptcha-response">
        @if ($errors->has('captcha'))
          <i class='fa fa-exclamation-circle fa-lg' aria-hidden='true'></i>&nbsp{{ $errors->first('captcha') }}
        @endif
      </div>
      <div class="mycrypto-btn-container">
        <button type="submit"
                class="login-btn reusable-btn">  @lang('home/change_password.change_btn') </button>
        <a href="{{ route('home') }}" type="submit"
           class="reusable-btn mycrypto-cancel-btn">@lang('home/mycrypto.cancel_btn')</a>
      </div>
    </form>

    @if (session('errors'))
      @if (session('errors')->first('invalid_post_service'))
        <span class="help-block" style="width: 265px">
            <i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i>&nbsp{{ session('errors')->first('invalid_post_service') }}
          </span>
      @endif
    @endif

    @if ($errors->has('captcha'))
      <span class="help-block captcha-block"><i class='fa fa-exclamation-circle fa-lg' aria-hidden='true'></i>&nbsp{{ $errors->first('captcha') }}</span>
    @endif
    @if ($status = Session::get('status'))
      <span class="help-block">
            {{ $status }}
        </span>
    @endif
  </div>
  <br><br><br><br><br>
@endsection
