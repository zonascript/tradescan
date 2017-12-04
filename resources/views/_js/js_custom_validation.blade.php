  {{--<script>--}}
	  {{--var form = $('form');--}}

	  {{--form.on('submit',function(e){--}}
		  {{--e.preventDefault();--}}
{{--//		  var _token = $("input[name='_token']").val();--}}
{{--//		  var wallet_invest_from = $("input[name='wallet_invest_from']").val();--}}
{{--//		  var name = localStorage.getItem('current-currency');--}}
{{--//		  var wallet_get_tokens = $("input[name='wallet_get_tokens']").val();--}}
{{--//		  var pwd = $("input[name='password']").val();--}}
{{--//		  var c_response = grecaptcha.getResponse();--}}
{{--//--}}
{{--//		  var data = {--}}
{{--//			  _token:_token,--}}
{{--//			  wallet_invest_from:wallet_invest_from,--}}
{{--//			  name_of_wallet_invest_from:name,--}}
{{--//			  wallet_get_tokens:wallet_get_tokens,--}}
{{--//			  password:pwd,--}}
{{--//			  'g-recaptcha-response':c_response--}}
{{--//		  };--}}
{{--//--}}
{{--//		  data[localStorage.getItem('current-currency')] = wallet_invest_from;--}}
{{--//--}}
{{--//		  if(localStorage.getItem('current-currency') === 'ETH'){--}}
{{--//			  data.wallet_get_tokens = wallet_invest_from;--}}
{{--//		  }--}}

		  {{--$.ajax({--}}
			  {{--url: form.attr("action"),--}}
			  {{--type: form.attr("method"),--}}
			  {{--data: form.serialize(),--}}
			  {{--dataType: "json",--}}
			  {{--success: function(data) {--}}
				  {{--if(!$.isEmptyObject(data.error)){--}}
					  {{--if (data.error['g-recaptcha-response']){--}}
						  {{--data.error['g-recaptcha-response'] = ['{{ __('validation.accepted') }}'];--}}
					  {{--}--}}
					  {{--$.each( data.error, function( key, value ) {--}}
						  {{--console.log(key, value);--}}
						  {{--if($(".error-message."+key).prev().hasClass('my-input')){--}}
							  {{--$(".error-message."+key).prev().css({'border':'1px solid #ff443a'});--}}
						  {{--}--}}
						  {{--$(".error-message."+key).html('<i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i>&nbsp'+value[0]);--}}
					  {{--});--}}
				  {{--} else {--}}

					  {{--console.log('else');--}}
					  {{--localStorage.setItem('wallet_msg','{{ __('controller/mycrypto.message_1') }}');--}}
					  {{--var redirect_url = '{{ route('root') }}' + '/home';--}}
					  {{--window.location.replace(redirect_url);--}}
				  {{--}--}}

			  {{--},--}}
        {{--error: function(data){--}}

	        {{--console.log(data.errors);--}}
        {{--}--}}
		  {{--});--}}

	  {{--});--}}

  {{--</script>--}}
