  <script>

	  var form = $('form');
	  var myInput = $('.my-input');
	  myInput.on('input', function () {
		  var index = myInput.index($(this));
		  if($(this).is(':valid')){
			  $('.error-message'+index).text('');
			  $('.captcha-block').text('');
			  $(this).css({'border':'solid 1px #d0d0d033'});
		  }
		  if($(this).value == ''){
			  $(this).css({'border':'solid 1px #d0d0d033'});
		  }
	  });

	  form.on('submit',function(e){
		  if (!(/agreement1/i.test(form[0].baseURI)) && !(/agreement2/i.test(form[0].baseURI))){
			  e.preventDefault();
      }
		  console.log((/agreement1/i.test(form[0].baseURI)) || (/agreement2/i.test(form[0].baseURI)));
		  myInput.css({'border':'solid 1px #d0d0d033'});
		  $(".error-message").html('');

		  $.ajax({
			  url: form.attr("action"),
			  type: form.attr("method"),
			  data: form.serialize(),
			  dataType: "json",
			  success: function(data) {
				  console.log(data);
			  	switch(true){
            case !$.isEmptyObject(data.validation_error):
	            if (data.validation_error['g-recaptcha-response']){
		            data.validation_error['g-recaptcha-response'] = ['{{ __('validation.accepted') }}'];
	            }
	            $.each( data.validation_error, function( key, value ) {
		            if($(".error-message."+key).prev().hasClass('my-input')){
			            $(".error-message."+key).prev().css({'border':'1px solid #ff443a'});
		            }
		            $(".error-message."+key).html('<i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i>&nbsp'+value[0]);
	            });
            	break;
					  case !$.isEmptyObject(data.not_your_email):
					  case !$.isEmptyObject(data.not_equal):
					  case !$.isEmptyObject(data.pwd_not_match):
					  case !$.isEmptyObject(data.is_taken):
					  case !$.isEmptyObject(data.failed):
					  case !$.isEmptyObject(data.reg_limit_exceeded):
					  case !$.isEmptyObject(data.reset_limit_exceeded):
					  case !$.isEmptyObject(data.not_confirmed_resend):
					  case !$.isEmptyObject(data.invalid_post_service):
					  case !$.isEmptyObject(data.smth_went_wrong):
					  case !$.isEmptyObject(data.user_not_found):
					  case !$.isEmptyObject(data.invalid_send_mail):
					  case !$.isEmptyObject(data.invalid_send_reset_mail):
					  case !$.isEmptyObject(data.reset_email_not_match):
						  $.each( data, function( key, value ) {
                $(".error-message."+key).prev().css({'border':'1px solid #ff443a'});
							  $(".error-message."+key).html('<i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i>&nbsp'+value);
						  });
						  break;
					  case !$.isEmptyObject(data.reset_pwd):
					  	localStorage.setItem('reset_pwd', data.reset_pwd );
						  $('.help-block-please-wait').show();
						  $("button[type='submit']").prop('disabled', true);
						  var redirect_url = '{{ route('root') }}' + '/';
						  window.location.replace(redirect_url);resend
						  break;
					  case !$.isEmptyObject(data.resend):
						  localStorage.setItem('resend', data.resend );
						  $('.help-block-please-wait').show();
						  $("button[type='submit']").prop('disabled', true);
						  var redirect_url = '{{ route('root') }}' + '/';
						  window.location.replace(redirect_url);
						  break;
					  case !$.isEmptyObject(data.success_register):
						  $('.help-block-please-wait').show();
						  $("button[type='submit']").prop('disabled', true);
						  var redirect_url = '{{ route('root') }}' + '/successRegister';
						  window.location.replace(redirect_url);
						  break;

            default:
	            $('.help-block-please-wait').show();
	            $("button[type='submit']").prop('disabled', true);
	            localStorage.setItem('wallet_msg','{{ __('controller/mycrypto.message_1') }}');
	            var redirect_url = '{{ route('root') }}' + '/home';
	            window.location.replace(redirect_url);
            	break;
          }

			  },
        error: function(data){
	        console.log(data.errors);
        }
		  });

	  });

  </script>
