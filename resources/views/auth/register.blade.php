@extends('layouts.user')

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
            <div class="error-message error-message0 email">
                @if ($errors->has('email'))
                    <i class='fa fa-exclamation-circle fa-lg' aria-hidden='true'></i>&nbsp{{ $errors->first('email') }}
                @endif
            </div>
            <label for="password" class="password-label">@lang('home/register.create_password')</label>
            <input type="password" name="password" class="my-input password-input">
            <div class="error-message error-message1 password">
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
          <div class="error-message error-message3 captcha-block g-recaptcha-response">
            @if ($errors->has('captcha'))
              <i class='fa fa-exclamation-circle fa-lg' aria-hidden='true'></i>&nbsp{{ $errors->first('captcha') }}
            @endif
          </div>
            <button type="submit" class="register-btn login-btn reusable-btn">  @lang('home/register.register_btn')  </button>
               <a class="register-on-login" href="{{ route('login') }}"> @lang('home/login.login_btn') </a>

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
        </form>

    </div>
    <br><br><br><br><br>
@endsection
@section('script')
  <script>
//    $('#registerForm').on('submit', function(){
//	    	$('.help-block-please-wait').show();
//	    $(this).find("button[type='submit']").prop('disabled',true);
//    });

  </script>
@endsection