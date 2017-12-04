var m = {
	form: $('#mycryptoForm'),
	warn_message: $('.crypto-warning-message'),
	default_currency: $('.currency1'),
	pay_wallet_label:$('.pay-wallet-label'),
	active_investment_box:$('.active-investment'),
	error_box: $('.error-message'),
	container: {
		additional_input:$('.additional-input-container'),
		crypto_input:$('.crypto-inputs-container')
	},
	input:{
		wallet_invest_from:$('#wallet_invest_from'),
		wallet_get_tokens:$('#wallet_get_tokens'),
		name_of_wallet_invest_from:$('#name_of_wallet_invest_from'),
		ETH:$('#ETH'),
		BTC:$('#BTC')
	}
};

if(localStorage.getItem('data-id') === null){
	localStorage.setItem('data-id', 'ETH');
	localStorage.setItem('current-currency', 'ETH');
} else {
	var dataID = localStorage.getItem("data-id");
	$("div").find("[data-id='" + dataID + "']").addClass('active-investment');
}

m.warn_message.hide();

currency_switcher(localStorage.getItem('data-id'));

m.form.on('submit', function () {
	m.input.name_of_wallet_invest_from.val(localStorage.getItem('current-currency'));
	if (localStorage.getItem('current-currency') === 'ETH') {                      //If Ethereum, which has the same invest and income wallet, is chosen
		m.input.wallet_get_tokens.val(m.input.wallet_invest_from.val());
	}
	m.input[localStorage.getItem('data-id')].val(m.input.wallet_invest_from.val());
});

$('.switch-box-container div').click(function () {
  $('.switch-box-container div').removeClass('active-investment');
  $(this).addClass('active-investment');
  $('#presumptive_investment').val($(this).text());
});

$('.crypto-currency-container div').click(function () {
	$('.my-input').css('border','1px solid rgba(208, 208, 208, 0.2)');

	if ($(this).data('id') === 'dont_know'){
		$('.password-label, .password-input, .g-recaptcha, .mycrypto-change-btn').hide();
	} else {
		$('.password-label, .password-input, .g-recaptcha, .mycrypto-change-btn').show();
	}
	if($(this).data('id') === 'ETH'){  //If Ethereum, which has the same invest and income wallet, is chosen
		$('#wallet_invest_from').val($('#wallet_get_tokens').val());
	}

	localStorage.setItem('current-currency', $(this).data('id'));
	currency_switcher($(this).data('id'));
	$('.crypto-inputs-container input').removeClass('invalid');
	$('.error-message').text('');
});

var mycrypto_text1,mycrypto_text2_0,mycrypto_text2_1;
function currency_switcher(this_id){

	if (m.default_currency.hasClass('active-investment')) {
		m.container.crypto_input.show();
		m.warn_message.hide();
		m.container.additional_input.hide();
		m.pay_wallet_label.html(mycrypto_text1);
	} else if ($('.currency0').hasClass('active-investment')) {
		m.container.crypto_input.hide();
		m.warn_message.show();
		$('.error-message2').css('text-align','left')
	} else {
		m.container.crypto_input.show();
		m.warn_message.hide();
		m.container.additional_input.show();
		m.pay_wallet_label.html(mycrypto_text2_0  +" <br>" + mycrypto_text2_1);
		$('.error-message2').css('text-align','left')
	}
}