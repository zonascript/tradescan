// function replaceValidationUI( form ) {
// 	// Suppress the default bubbles
// 	form.addEventListener( "invalid", function( event ) {
// 		event.preventDefault();
// 	}, true );
// 	// Support Safari, iOS Safari, and the Android browser—each of which do not prevent
// 	// form submissions by default
// 	form.addEventListener( "submit", function( event ) {
// 		if ( !this.checkValidity() ) {
// 			event.preventDefault();
// 		}
// 	});
// 	var submitButton = form.querySelector( "button:not([type=button]), input[type=submit]" );
// 	submitButton.addEventListener( "click", function( event ) {
// 		invalidFields = form.querySelectorAll( ":invalid" );
// 		var myInput = document.getElementsByClassName('my-input');
// 		for ( var i = 0; i < invalidFields.length; i++ ) {
// 			var className = invalidFields[i].className;
// 			var subClass = " invalid";
// 			if ( invalidFields.length > 0 && className.indexOf(subClass) === -1) {
// 				invalidFields[i].className += " invalid";
// 			}
// 		}
// 		$('input:invalid').each(function (index) {
// 			$(this).next('.error-message').html("<i class='fa fa-exclamation-circle fa-lg' aria-hidden='true'></i>"+"&nbsp"+invalidFields[index].validationMessage);
// 		});
//
// 	});
// }
//
// // Replace the validation UI for all forms
// var forms = document.querySelectorAll( "form" );
// for ( var i = 0; i < forms.length; i++ ) {
// 	replaceValidationUI( forms[ i ] );
// }
//
// var myInput = $('.my-input');
//
// $('.error-message').each(function(){
// 	if($(this).text().length > 0){
// 		$(this).prev('.my-input').css({'border':'1px solid #ff443a'});
// 	}
// });
//
//
// myInput.on('input', function () {
// 	var index = myInput.index($(this));
// 		if($(this).is(':valid')){
// 			$('.error-message'+index).text('');
// 			$('.captcha-block').text('');
// 			$(this).css({'border':'solid 1px rgba(208, 208, 208, 0.2)'});
// 		}
// 	if($(this).value == ''){
// 		$(this).css({'border':'solid 1px rgba(208, 208, 208, 0.2)'});
// 	}
// });
//
// if($('.error-message0').text().length > 200) {
// 	$('.error-messageX').text($('.error-message0').text());
// 	$('.error-message0').text('')
// }
//
//
