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
      @if (Session::has('resend'))
        <span class="help-block" style="color:#1fcc1f; width: 265px">
          <i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i>&nbsp{{Session::get('resend') }}
        </span>
      @endif
    </div>
  </div>
  @if (session('errors'))
    @if (session('errors')->first('not_confirmed_resend'))
      <span class="help-block" style="width: 265px">
          <i class="fa fa-exclamation-circle fa-lg"
             aria-hidden="true"></i>&nbsp{{ session('errors')->first('not_confirmed_resend') }}
        </span>
    @endif
    @if (session('errors')->first('invalid_post_service'))
      <span class="help-block" style="width: 265px">
            <i class="fa fa-exclamation-circle fa-lg"
               aria-hidden="true"></i>&nbsp{{ session('errors')->first('invalid_post_service') }}
          </span>
    @endif
    @if (session('errors')->first('smth_went_wrong'))
      <span class="help-block">
            <i class="fa fa-exclamation-circle fa-lg"
               aria-hidden="true"></i>&nbsp{{ session('errors')->first('smth_went_wrong') }}
          </span>
    @endif
    @if (session('errors')->first('error_occured'))
      <span class="help-block" style="width: 265px">
            <i class="fa fa-exclamation-circle fa-lg"
               aria-hidden="true"></i>&nbsp{{ session('errors')->first('error_occured') }}
          </span>

    @endif
  @endif
@endsection