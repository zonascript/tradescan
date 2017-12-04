@extends('layouts.app')

@section('content')
    <div class="content-body register-body">
        <h3>@lang('home/register.registration')</h3>
        <form id="registerForm" method="POST" action="{{ route('register') }}">
            {{ csrf_field() }}
            <label for="email" class="email-label">@lang('home/register.type_your_email')</label>
            <input type="text" name="email" class="my-input email-input">
            @if ($success = Session::get('success'))
                <span class="success-sent help-block-success">
               <i class='fa fa-exclamation-circle fa-2x' aria-hidden='true'></i>
                  <p>{{ $success }}</p>
             </span>
            @endif
            <div class="error-message error-message0">
                @if ($errors->has('email'))
                    <i class='fa fa-exclamation-circle fa-lg' aria-hidden='true'></i>&nbsp{{ $errors->first('email') }}
                @endif
            </div>
            <label for="password" class="password-label">@lang('home/register.create_password')</label>
            <input type="password" name="password" class="my-input password-input">
            <div class="error-message error-message1">
              @if ($errors->has('password'))
                <i class='fa fa-exclamation-circle fa-lg' aria-hidden='true'></i>&nbsp{{ $errors->first('password') }}
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
            <div class="g-recaptcha" data-theme="dark" data-sitekey="{{ env('RE_CAP_SITE') }}"></div>
            <button type="submit" class="register-btn login-btn reusable-btn">  @lang('home/register.register_btn')  </button>
               <a class="register-on-login" href="{{ route('login') }}"> @lang('home/login.login_btn') </a>
        </form>

    @if (session('errors'))
      @if (session('errors')->first('not_confirmed_resend'))
        <span class="help-block" style="width: 265px">
          <i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i>&nbsp{{ session('errors')->first('not_confirmed_resend') }}
        </span>
      @endif
        @if (session('errors')->first('invalid_post_service'))
          <span class="help-block" style="width: 265px">
            <i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i>&nbsp{{ session('errors')->first('invalid_post_service') }}
          </span>
        @endif
        @if (session('errors')->first('smth_went_wrong'))
          <span class="help-block">
            <i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i>&nbsp{{ session('errors')->first('smth_went_wrong') }}
          </span>
        @endif
        @if (session('errors')->first('error_occured'))
          <span class="help-block" style="width: 265px">
            <i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i>&nbsp{{ session('errors')->first('error_occured') }}
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
@section('script')
  <script>
    $('#registerForm').on('submit', function(){
	    	$('.help-block-please-wait').show();
	    $(this).find("button[type='submit']").prop('disabled',true);
    });

  </script>
@endsection