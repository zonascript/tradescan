@extends('layouts.app')

@section('content')

  <div class="content-body change-email-body mycrypto-body">
    <h3>@lang('home/change_password.edit_pwd')</h3>
    <form id="changeEmailForm" method="POST" action="{{ route('renew_password') }}">
      {{ csrf_field() }}
      <label for="email" class="email-label">@lang('home/change_email.current_email')</label>
      <input type="email" name="email" class="my-input email-input">

      <div class="error-message error-message0 email not_your_email">
        @if ($errors->has('email'))
          <i class='fa fa-exclamation-circle fa-lg' aria-hidden='true'></i>&nbsp{{ $errors->first('email') }}
        @endif
        @if (session('errors'))
          @if (session('errors')->first('not_yours'))
            <i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i>&nbsp{{ session('errors')->first('not_yours') }}
          @endif
        @endif
      </div>

      <label for="password1" class="email-label">@lang('home/change_password.cur_pwd')</label>
      <input id="password1" type="password" class="my-input" name="password1">

      <div class="error-message error-message1 password1 pwd_not_match not_equal">
        @if ($errors->has('password1'))
          <i class='fa fa-exclamation-circle fa-lg' aria-hidden='true'></i>&nbsp{{ $errors->first('password1') }}
        @endif
        @if (session('errors'))
          @if (session('errors')->first('not_equal'))
            <i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i>&nbsp{{ session('errors')->first('not_equal') }}
          @endif
          @if (session('errors')->first('pwd_not_match'))
            <i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i>&nbsp{{ session('errors')->first('pwd_not_match') }}
          @endif
        @endif
      </div>

      <label for="password2" class="email-label">@lang('home/change_password.new_pwd')</label>
      <input id="password2" type="password" class="my-input" name="password2">

      <div class="error-message error-message2 password2 not_equal">
        @if ($errors->has('password2'))
          <i class='fa fa-exclamation-circle fa-lg' aria-hidden='true'></i>&nbsp{{ $errors->first('password2') }}
        @endif
        @if (session('errors'))
          @if (session('errors')->first('not_equal'))
            <i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i>&nbsp{{ session('errors')->first('not_equal') }}
          @endif
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
      <span class="help-block captcha-block">
              <i class='fa fa-exclamation-circle fa-lg' aria-hidden='true'></i>&nbsp{{ $errors->first('captcha') }}
          </span>
    @endif
    @if ($status = Session::get('status'))
      <span class="help-block">
            {{ $status }}
        </span>
    @endif
  </div>
  <br><br><br><br><br>
@endsection
