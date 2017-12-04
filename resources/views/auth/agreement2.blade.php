@extends('layouts.app')

@section('content')
    <div class="content-body agreement2-body">
        <h3>@lang('home/agreement2.personal_information_title')</h3>
        <div class="agreement-container agreement2-container">
            <div id="crumbs">
                <ul>
                  <li><span>@lang('home/agreement1.agreement_with_conditions')</span></li>
                  <li><span>@lang('home/agreement1.personal_information')</span></li>
                  <li><span>@lang('home/agreement1.pay_in')</span></li>
                </ul>
            </div>
            <article>
              @lang('home/agreement2.attention_big_text')
            </article>
            <form class="form-horizontal" method="POST" action="{{ route('store_personal_data') }}">
              {{ csrf_field() }}
              <div class="input-container">
                  <label for="name_surname" class=""> @lang('home/agreement2.name_surname')</label>
                  <input id="nameSurname" type="text" class="" name="name_surname">

                  <label for="telegram" class=""> @lang('home/agreement2.telegram')</label>
                  <input id="telegram" type="text" class="" name="telegram">

                  <label for="emergency_email" class=""> @lang('home/agreement2.extra_email')</label>
                  <input id="emergency_email" type="text" class="" name="emergency_email">

                  <label for="permanent_address" class=""> @lang('home/agreement2.perm_address')</label>
                  <input id="permanent_address" type="text" class="" name="permanent_address">

                  <label for="contact_number" class=""> @lang('home/agreement2.contact_number')</label>
                  <input id="contact_number" type="text" class="" name="contact_number">

                  <label for="date_place_birth" class=""> @lang('home/agreement2.date_place_birth')</label>
                  <input id="date_place_birth" type="text" class="" name="date_place_birth">

                  <label for="nationality" class=""> @lang('home/agreement2.nationality')</label>
                  <input id="nationality" type="text" class="" name="nationality">

                  <label for="source_of_funds" class=""> @lang('home/agreement2.source_of_funds')</label>
                  <input id="source_of_funds" type="text" class="" name="source_of_funds">
              </div>
              <input id="presumptive_investment" type="hidden" class="" name="presumptive_investment">
              <p class="invest-amount"> @lang('home/agreement2.invest_amount')</p>
              <div class="switch-box-container invest-container">
                <div class="invest1">@lang('home/mycrypto.dont_know')</div>
                <div class="invest2">$1000</div>
                <div class="invest3">$1000-$5000</div>
                <div class="invest4">$5k-$10k</div>
                <div class="invest5">$10-$100k</div>
                <div class="invest6"> > $100k </div>
              </div>
              <button type="submit" class="agreement2-btn reusable-btn">@lang('home/mycrypto.save_btn')</button>
            </form>
          </div>
        </div>
    <script src="{{ asset('js/noBackButton.js') }}"></script>
@endsection
