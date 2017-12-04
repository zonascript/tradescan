@extends('layouts.app')

@section('content')
  <div class="content-body welcome-body">
    <h3>@lang('app.my_prof_crowd')</h3>
    <div class="wrapper">
      @if ($status = Session::get('status'))
        <span class="home-status-message">
            {{ $status }}
        </span>
      @endif
      <div class="sign_in"><a href="{{ route('login') }}" >@lang('app.sign_in')</a></div>
      <div class="divider"></div>
      <div class="sign_up"><a href="{{ route('register') }}" >@lang('app.sign_up')</a></div>
    </div>
      @if (Session::has('reset_pwd'))
              <span class="help-block" style="color:#1fcc1f; width: 265px">
          <i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i>&nbsp{{Session::get('reset_pwd') }}
        </span>
      @endif
    @if (session('errors'))
      @if (session('errors')->first('reg_limit_exceeded'))
        <span class="help-block" style="width: 265px">
        <i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i>&nbsp{{ session('errors')->first('reg_limit_exceeded') }}
      </span>
      @endif
        @if (session('errors')->first('reset_limit_exceeded'))
          <span class="help-block" style="width: 265px">
        <i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i>&nbsp{{ session('errors')->first('reset_limit_exceeded') }}
      </span>
        @endif
      @endif


  </div>
@endsection