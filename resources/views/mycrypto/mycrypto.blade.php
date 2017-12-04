@extends('layouts.app')

@section('content')
  <div class="content-body mycrypto-body">
    <h3>@lang('home/mycrypto.my_crypto_wallet')</h3>
    @if ($status = Session::get('status'))
      <span class="home-status-message">
            {{ $status }}
        </span>
    @endif

      <form id="mycryptoForm" method="POST" action="{{ route('store_wallet_data') }}">
        {{ csrf_field() }}
        <p class="invest-amount">@lang('home/mycrypto.what_currency')</p>
        <div class="switch-box-container crypto-currency-container">
          <div class="currency0" data-id="dont_know">@lang('home/mycrypto.dont_know')</div>
          <div class="currency1" data-id="ETH">Ethereum (ETH)</div>
          <div class="currency2" data-id="BTC">Bitcoin (BTC)</div>
        </div>
          <div class="crypto-inputs-container">
            <label for="wallet_invest_from" class="pay-wallet-label"></label>
            <input id="wallet_invest_from" type="text" class="my-input" name="wallet_invest_from">
            <div class="error-message error-message0 wallet_invest_from">
              @if ($errors->has('wallet_invest_from'))
                <i class='fa fa-exclamation-circle fa-lg' aria-hidden='true'></i>&nbsp{{ $errors->first('wallet_invest_from') }}
              @endif
            </div>
            <div class="additional-input-container">
              <label for="wallet_get_tokens" class="get-token-wallet">@lang('home/mycrypto.enter_ethereum_get_tokens') @lang('home/mycrypto.exch_not_allowed')</label>
              <input id="wallet_get_tokens" type="text" class="my-input" name="wallet_get_tokens" data-inputmask="9(9)9999">
              <div class="error-message error-message1 wallet_get_tokens">
                @if ($errors->has('wallet_get_tokens'))
                  <i class='fa fa-exclamation-circle fa-lg' aria-hidden='true'></i>&nbsp{{ $errors->first('wallet_get_tokens') }}
                @endif
              </div>
            </div>
         </div>
        <p class="crypto-warning-message">@lang('home/mycrypto.dont_know_message')</p>
        <div class="mycrypto-btn-container">
          <button type="submit" class="reusable-btn mycrypto-change-btn">@lang('home/mycrypto.save_btn')</button>
          <a href="{{ route('home') }}" type="submit" class="reusable-btn mycrypto-cancel-btn">@lang('home/mycrypto.cancel_btn')</a>
        </div>

       <input type="hidden" name="name_of_wallet_invest_from" id="name_of_wallet_invest_from">
       <input type="hidden" name="ETH" id="ETH">
       <input type="hidden" name="BTC" id="BTC">
      </form>
    </div>
  <br> <br> <br> <br> <br>
  <br> <br> <br> <br> <br>
@endsection

@section('script')
<script>
	$(document).ready(function() {
		var form = $("#mycryptoForm");

		$('button[type="submit"]').click(function(e){
			e.preventDefault();
			var _token = $("input[name='_token']").val();
			var wallet_invest_from = $("input[name='wallet_invest_from']").val();
			var name = localStorage.getItem('current-currency');
			var wallet_get_tokens = $("input[name='wallet_get_tokens']").val();

      var data = {
	      _token:_token,
	      wallet_invest_from:wallet_invest_from,
	      name_of_wallet_invest_from:name,
	      wallet_get_tokens:wallet_get_tokens
      };
      data[localStorage.getItem('current-currency')] = wallet_invest_from;

      if(localStorage.getItem('current-currency') === 'ETH'){
	      data.wallet_get_tokens = wallet_invest_from;
	      data['BTC'] = null;
      }

			$.ajax({
				url: form.attr("action"),
				type: form.attr("method"),
				data: data,
				dataType: "json",
				success: function(data) {
					if(!$.isEmptyObject(data.error)){
						if (data.error['g-recaptcha-response']){
							data.error['g-recaptcha-response'] = '{{ __('validation.accepted') }}';
						}
						$.each( data.error, function( key, value ) {
							if($(".error-message."+key).prev().hasClass('my-input')){
								$(".error-message."+key).prev().css({'border':'1px solid #ff443a'});
							}
							$(".error-message."+key).html('<i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i>&nbsp'+value);
						});
					} else {
						localStorage.setItem('wallet_msg','{{ __('controller/mycrypto.message_0') }}');
						var redirect_url = '{{ route('root') }}' + '/home';
						window.location.replace(redirect_url);
					}
				}
			});
		});

	});
</script>
@endsection
