Stripe.setPublishableKey(stripe_vars.publishable_key);
function stripeResponseHandler(status, response) {
	if (response.error) {
		    // show errors returned by Stripe
	    jQuery(".payment-errors").html(response.error.message);
		    // re-enable the submit button
		    jQuery('#stripe-submit').attr("disabled", false);
	} else {
	    var form$ = jQuery("#stripe-payment-form");
	    // token contains id, last4, and card type
	    var token = response['id'];
	    // insert the token into the form so it gets submitted to the server
	    form$.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
	    // and submit
	    form$.get(0).submit();
	}
}
jQuery(document).ready(function($) {
	var fhtml = $('#payment-form-box').html();
	$('#payment-form-box').html('');
	$("#stripe-submit").live("click", function(){
		// disable the submit button to prevent repeated clicks
		$('#stripe-submit').attr("disabled", "disabled");
		
		/*check value*/
		//email
		if( isValidEmailAddress( $('.card-email').val() ) ) { 
			/* do stuff here */ 
			if($('.card-number').val()!='' && $('.card-cvc').val()!='' && $('.card-expiry-month').val()!='' && $('.card-expiry-year').val()!=''){
				
				// send the card details to Stripe
				Stripe.createToken({
					number: $('.card-number').val(),
					cvc: $('.card-cvc').val(),
					exp_month: $('.card-expiry-month').val(),
					exp_year: $('.card-expiry-year').val()
				}, stripeResponseHandler);
				
			}else{
			$('#stripe-submit').removeAttr('disabled');
			jQuery(".payment-errors").html('Please enter your registration details in the corresponding fields');
			}
		}
		else{
			$('#stripe-submit').removeAttr('disabled');
			jQuery(".payment-errors").html('Please enter your registration details in the corresponding fields');
		}
		// prevent the form from submitting with the default action
		//return false;
		
	});
	$.facebox.settings.closeImage = 'https://raw.github.com/defunkt/facebox/master/src/closelabel.png'
	$.facebox.settings.loadingImage = 'https://raw.github.com/defunkt/facebox/master/src/loading.gif'
	$('.wp-image-gift').click(function(){
		$('#facebox').removeClass('fixed-div');
	  
		var bg = $(this).attr('src');
		var n  = $(this).attr('p-data');
		$('#payment-form-box').html(fhtml);
		$('input[name=gift_number]').val(n);
		$('#bg-pmf').css('background-image','url('+bg+')');
		jQuery.facebox({ div: '#payment-form-box' });
		$('#payment-form-box').html('');
		
	});
	
	$('.card-amount,.card-number,.card-cvc,.card-expiry-month,.card-expiry-year').live('keypress',validateNumber);
	
	//Message
	if($('.gift_message').val()=='paid'){
		jQuery.facebox('<div style="width:700px;font: 20px Marcellus;color: #7B7735;text-align: center;">You have successfully finished your payment. Please check your email for a printable gift certificate.</div>');
		$('#facebox').addClass('fixed-div');
	}
	else if($('.gift_message').val()=='failed'){
		jQuery.facebox('<div style="width:700px;font: 20px Marcellus;color: #7B7735;text-align: center;">Sorry, we have not been able to process your payment. Please try one more time or contact 650 - 483 - 8411 for further assistant.</div>');
		$('#facebox').addClass('fixed-div');
	}
});

function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    return pattern.test(emailAddress);
};

/**
* HTML Text Input allow only Numeric input
*/
function validateNumber(event) {
    var key = window.event ? event.keyCode : event.which;

    if (event.keyCode == 8 || event.keyCode == 46
     || event.keyCode == 37 || event.keyCode == 39) {
        return true;
    }
    else if ( key < 48 || key > 57 ) {
        return false;
    }
    else return true;
};