@extends('layouts.app')

@section('content')
<div class="content-body agreement1-body">

        <h3>@lang('home/agreement1.agreement_with_conditions_title')</h3>
    <div class="agreement-container">
        <div id="crumbs">
            <ul>
                <li><span>@lang('home/agreement1.agreement_with_conditions')</span></li>
                <li><span>@lang('home/agreement1.personal_information')</span></li>
                <li><span>@lang('home/agreement1.pay_in')</span></li>
            </ul>
        </div>
        <article>
            @lang('home/agreement1.readme_big_text')
        </article>
      <a target="_blank" class="white-book-link" href="{{ asset('files/cp_whitepaper_en.pdf') }}">
        @lang('app.white_book')
      </a>
        <div class="btn-container">
            <form id="agreement1Form" method="POST" action="{{ route('goToAgreement2') }}">
                {{ csrf_field() }}
                <div class="agrement1-btn-container">
                    <button class="reusable-btn approve-btn" type="submit">@lang('home/agreement1.agreed_confirm')</button>
                    <a class="another-option-btn" href="{{ route('logout') }}">@lang('home/agreement1.other')</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="{{ asset('js/noBackButton.js') }}"></script>

@endsection