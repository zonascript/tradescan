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
        <span class="help-block-reset-pwd" style="color:lightseagreen; width: 265px"></span>

  </div>
@endsection