@extends('layouts.app')

@section('content')

  <div class="content-body login-body">
    @if ($success = Session::get('success') && isset($success['title']))
      <h3 style="letter-spacing: 3px; text-transform: none;">{{ $success['title'] }}</h3>
      @else
      <h3>{{__('home/login.welcome') }}</h3>
    @endif
    <form id="loginForm" method="POST" action="{{ route('login') }}">
      {{ csrf_field() }}
      <label for="email" class="email-label">@lang('home/login.email_label')</label>
      <input type="text" name="email" class="my-input email-input " placeholder="example@mail.com" value="{{ $success['email'] }}">
        @if ($success = Session::get('success') && isset($success['message']))
            <span class="success-sent help-block-success">
               <i class='fa fa-exclamation-circle fa-2x' aria-hidden='true'></i>
                  <p>{{ $success['message'] }}</p>
             </span>
        @endif
        <div class="error-message error-message0 email">
        @if ($errors->has('email'))
          <i class='fa fa-exclamation-circle fa-lg' aria-hidden='true'></i>&nbsp{{ $errors->first('email') }}
        @endif
      </div>

      <label for="password" class="password-label ">@lang('home/login.pwd_label')</label>
      <input type="password" name="password" autofocus class="my-input password-input">

      <div class="error-message error-message1 password">
        @if ($errors->has('password'))
          <i class='fa fa-exclamation-circle fa-lg' aria-hidden='true'></i>&nbsp{{ $errors->first('password') }}
        @endif
      </div>
      <div class="g-recaptcha" data-theme="dark" data-sitekey="{{ env('RE_CAP_SITE') }}"></div>

      {{--<div class="error-message error-message3 captcha-block g-recaptcha-response">--}}
        {{--@if ($errors->has('captcha'))--}}
          {{--<i class='fa fa-exclamation-circle fa-lg' aria-hidden='true'></i>&nbsp{{ $errors->first('captcha') }}--}}
        {{--@endif--}}
      {{--</div>--}}
      <button type="submit" class="login-btn reusable-btn">   @lang('home/login.login_btn')  </button>
      <div class="log-forgot">
        <a class="sign-forgot" href="{{ route('register') }}"> @lang('app.sign_up') </a>
        <a class="sign-forgot" href="{{ route('password.request') }}"> @lang('home/login.forgot_pwd')</a>
      </div>
    </form>



      @if (session('errors'))
        @if (session('errors')->first('failed'))
          <span class="help-block" style="width: 265px">
          <i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i>&nbsp{{ session('errors')->first('failed') }}
        </span>
        @endif
        @if (session('errors')->first('not_confirmed_resend'))
          <span class="help-block" style="width: 265px">
        <i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i>&nbsp{{ session('errors')->first('not_confirmed_resend') }}
      </span>
        @endif
        @if (session('errors')->first('error_while_registration'))
          <span class="help-block" style="width: 265px">
            <i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i>&nbsp{{ session('errors')->first('error_while_registration') }}
          </span>
        @endif
      @endif


      @if ($errors->has('captcha'))
        <span class="help-block captcha-block">
              <i class='fa fa-exclamation-circle fa-lg' aria-hidden='true'></i>&nbsp{{ $errors->first('captcha') }}
          </span>
      @endif
  </div>
<br><br><br><br><br>
@endsection
