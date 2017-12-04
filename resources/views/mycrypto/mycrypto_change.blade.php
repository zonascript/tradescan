@extends('layouts.app')

@section('content')
  <div class="content-body mycrypto-body">
    <h3>@lang('home/mycrypto.my_crypto_wallet')</h3>

      <form id="mycryptoForm" method="POST" action="{{ route('update_wallet_data') }}">
        {{ csrf_field() }}
        <p class="invest-amount">@lang('home/mycrypto.what_currency')</p>
        <div class="switch-box-container crypto-currency-container">
          <div class="currency1" data-id="ETH">Ethereum (ETH)</div>
          <div class="currency2" data-id="BTC">Bitcoin (BTC)</div>
          {{--<div class="currency3" data-id="DASH">DASH</div>--}}
          {{--<div class="currency4" data-id="XMR">Monero (XMR)</div>--}}
          {{--<div class="currency5" data-id="LTC">Litecoin (LTC)</div>--}}
          {{--<div class="currency6" data-id="XRP">Ripple (XRP)</div>--}}
          {{--<div class="currency7" data-id="Fiat">@lang('home/mycrypto.fiat')</div>--}}
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
              <label for="wallet_get_tokens" class="get-token-wallet">@lang('home/mycrypto.enter_ethereum_get_tokens') @lang('home/mycrypto.exch_not_allowed')
                </label>
              <input id="wallet_get_tokens" type="text" class="my-input" name="wallet_get_tokens" data-inputmask="9(9)9999">
              <div class="error-message error-message1 wallet_get_tokens">
                @if ($errors->has('wallet_get_tokens'))
                  <i class='fa fa-exclamation-circle fa-lg' aria-hidden='true'></i>&nbsp{{ $errors->first('wallet_get_tokens') }}
                @endif
              </div>
            </div>
            <label for="password" class="password-label">@lang('home/login.pwd_label')</label>
            <input type="password" name="password" class="my-input password-input">
            <div class="error-message error-message2 password">
              @if ($errors->has('password'))
                <i class='fa fa-exclamation-circle fa-lg' aria-hidden='true'></i>&nbsp{{ $errors->first('password') }}
              @endif
            </div>
            <div class="g-recaptcha" data-theme="dark" data-sitekey="{{ env('RE_CAP_SITE') }}"></div>

            <div class="error-message error-message3 captcha-block g-recaptcha-response">
              @if ($errors->has('captcha'))
                <i class='fa fa-exclamation-circle fa-lg' aria-hidden='true'></i>&nbsp{{ $errors->first('captcha') }}
              @endif
            </div>

          </div>

          <p class="crypto-warning-message">@lang('home/mycrypto.dont_know_message')</p>
        <div class="mycrypto-btn-container">
          <button type="submit" class="reusable-btn mycrypto-change-btn">@lang('home/home.change_btn')</button>
          <a href="{{ route('home') }}" type="submit" class="reusable-btn mycrypto-cancel-btn">@lang('home/mycrypto.cancel_btn')</a>
        </div>
       <input type="hidden" name="name_of_wallet_invest_from" id="name_of_wallet_invest_from">
       <input type="hidden" name="ETH" id="ETH">
       <input type="hidden" name="BTC" id="BTC">
       {{--<input type="hidden" name="DASH" id="DASH">--}}
       {{--<input type="hidden" name="XMR" id="XMR">--}}
       {{--<input type="hidden" name="LTC" id="LTC">--}}
       {{--<input type="hidden" name="ZEC" id="ZEC">--}}
       {{--<input type="hidden" name="Fiat" id="Fiat">--}}
      </form>
    </div>
  <br> <br> <br> <br> <br>
  <br> <br> <br> <br> <br>
@endsection

@section('script')
  <script>

    $('#wallet_invest_from').val('{{ $walletFields['wallet_invest_from'] }}');
    $('#wallet_get_tokens').val('{{ $walletFields['wallet_get_tokens'] }}');

    $('.password-label, .password-input, .g-recaptcha, .mycrypto-change-btn').hide();

    $('#wallet_invest_from').on('input', function(){
	    $('.password-label, .password-input, .g-recaptcha, .mycrypto-change-btn').show();
    });
    $('#wallet_get_tokens').on('input', function(){
	    $('.password-label, .password-input, .g-recaptcha, .mycrypto-change-btn').show();
    });


	  $(document).ready(function() {

		  $('.crypto-currency-container div').click(function () {

			  $.get("/current_wallets", function(data) {
				  $('#wallet_invest_from').val(data.data[localStorage.getItem('current-currency')]);
				  $('#wallet_get_tokens').val('{{ $walletFields['wallet_get_tokens'] }}');
			  });

			  if($(this).data('id') === localStorage.getItem('data-id') && $(this).data('id') !== 'dont_know'){

				  $('#wallet_invest_from').val('{{ $walletFields['wallet_invest_from'] }}');
				  $('#wallet_get_tokens').val('{{ $walletFields['wallet_get_tokens'] }}');
				  $('.password-label, .password-input, .g-recaptcha, .mycrypto-change-btn').hide();
			  }
		  });



		  var form = $("#mycryptoForm");

		  $('button[type="submit"]').click(function(e){
			  e.preventDefault();
			  var _token = $("input[name='_token']").val();
			  var wallet_invest_from = $("input[name='wallet_invest_from']").val();
			  var name = localStorage.getItem('current-currency');
			  var wallet_get_tokens = $("input[name='wallet_get_tokens']").val();
			  var pwd = $("input[name='password']").val();
        var c_response = grecaptcha.getResponse();

			  var data = {
				  _token:_token,
				  wallet_invest_from:wallet_invest_from,
				  name_of_wallet_invest_from:name,
				  wallet_get_tokens:wallet_get_tokens,
				  password:pwd,
				  'g-recaptcha-response':c_response
			  };

			  data[localStorage.getItem('current-currency')] = wallet_invest_from;

			  if(localStorage.getItem('current-currency') === 'ETH'){
				  data.wallet_get_tokens = wallet_invest_from;
			  }

			  $.ajax({
				  url: form.attr("action"),
				  type: form.attr("method"),
				  data: data, //$('#myForm').serialize(),
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
						  localStorage.setItem('wallet_msg','{{ __('controller/mycrypto.message_1') }}');
						  var redirect_url = '{{ route('root') }}' + '/home';
						  window.location.replace(redirect_url);
					  }

				  }
			  });
		  });

	  });

  </script>
@endsection
