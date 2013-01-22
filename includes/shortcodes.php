<?php
function pippin_stripe_payment_form() {
	global $stripe_options;
	$r = '
	<style>
      	/**
	* fix gift certificate
	*/
	table.form-table{
	width: auto;
	margin-bottom: 0px;
	}
	table.form-table tr{
	border-bottom:0px;
	}
	table.form-table th,table.form-table td{
	background: none;
	padding: 0px 15px;
	border-bottom: none;
	}
	table.form-table input,table.form-table textarea{
	margin: 0;
	color: #4E4635;
	background-color: white;
	width: auto;
	padding: 5px;
	}
	#facebox .popup{
	display:block;
	}
	#facebox .popup .content {
	margin-right: 0px;
	float: none;
	}
	</style>
	';
	
	$r .= '
	<div class="bottom" style="width: 730px;float:right;text-align: center;"">
		<div style="margin: 0 auto; width: auto; height: auto; display: inline-block;">';
		for($i=1;$i<=$stripe_options['gifts_quantity'];$i++){
			if(isset($stripe_options['gift'.$i.'_image'])&&$stripe_options['gift'.$i.'_image'] != ''){
				$r .= '<div style="cursor:pointer;margin-right: 20px;width:159px;float:left;">';  
				$r .= '<img class="wp-image-gift alignleft" p-data="'.$i.'" style="" title="Gift Certificate" alt="Gift Certificate" src="'.$stripe_options['gift'.$i.'_image'].'" width="159" height="108" />';
				$r .= '<b style="font: 20px Marcellus;color: #E2A939;">'.$stripe_options['gift'.$i.'_title'].'</b>';
				$r .= '</div>'; 
			}

		}
		
		$r .= '</div><div style="margin: 0 auto; font: 20px Marcellus; color: #7b7735; clear: both;">Order a Printable Gift Certificate Online Now</div>
	
	<div id="payment-form-box" style="display:none;">
	<div id="bg-pmf" style="position:relative;width:720px;height:540px;background: white url(http://127.0.0.1/wordpress/wp-content/uploads/2012/12/giftcard.JPG.jpg) no-repeat left top;">
		<div style="position:absolute;right:0px;bottom:10px;width:455px;"> 
		<form action="" method="POST" id="stripe-payment-form">
		
			<table class="form-table" style="float:right;margin-right:0px;">
				<tbody>
					<tr valign="top">	
						<th scope="row" valign="top">
							Email
						</th>
						<td>
							<input type="text" size="20" autocomplete="off" name="card-email" class="card-email required"/>*
						</td>
					</tr>
  
					<tr valign="top">	
						<th scope="row" valign="top">
							To
						</th>
						<td>
							<input type="text" size="20" autocomplete="off" name="card-to" class="card-to"/>
						</td>
					</tr>

					<tr valign="top">	
						<th scope="row" valign="top">
							From
						</th>
						<td>
							<input type="text" size="20" autocomplete="off" name="card-from" class="card-from"/>
						</td>
					</tr>

					<tr valign="top">	
						<th scope="row" valign="top">
						Amount
						</th>
						<td>
							<input type="text" size="20" autocomplete="off" name="card-amount" class="card-amount" value="100"/>$
						</td>
					</tr>
					
					<tr valign="top">	
						<th scope="row" valign="top">
						Note
						</th>
						<td>
							<textarea autocomplete="off" name="card-note" class="card-note" style="width:174px;height:56px;"></textarea>
						</td>
					</tr>

					<tr valign="top">	
						<th scope="row" valign="top">
							Card Number
						</th>
						<td>
							<input type="text" size="20" autocomplete="off" class="card-number required"/>*
						</td>
					</tr>					
				
					<tr valign="top">	
						<th scope="row" valign="top">
							CVC
						</th>
						<td>
							<input type="text" size="4" autocomplete="off" class="card-cvc required"/>*
						</td>
					</tr>					
				
					<tr valign="top">	
						<th scope="row" valign="top">
							Expiration (MM/YY)
						</th>
						<td>
							<input type="text" size="2" class="card-expiry-month required"/>
							<span> / </span>
							<input type="text" size="4" class="card-expiry-year required"/>*
						</td>
					</tr>	
					<tr valign="top">	
						<th scope="row" valign="top">
							* Required
						</th>
					</tr>
				</tbody>
			</table>
			<input type="hidden" name="action" value="stripe"/>
			<input type="hidden" name="gift_number" value="1"/>
			<input type="hidden" name="redirect" value="'. get_permalink() .'"/>
			<input type="hidden" name="stripe_nonce" value="'. wp_create_nonce('stripe-nonce') .'"/>
			<button type="submit" style="display:none;"></button>
		</form>
		
			<table class="form-table" style="float:right;margin-right:0px;width:365px;">
				<tbody>
					<tr valign="top">	
						<th scope="row" valign="top">
							<div class="payment-errors" style="color:red;font-weight: bold;vertical-align: top;"></div>
						</th>
					</tr>
					<tr valign="top">	
						<th scope="row" valign="top">
							<button type="submit" id="stripe-submit" style="">Submit Payment</button>
						</th>
					</tr>
				</tbody>
			</table>  
		</div> 
	</div>  
	</div> 
	


</div>';

	$p = (isset($_GET['payment']))?$_GET['payment']:"" ;
	$r .= '<input type="hidden" name="gift_message" class="gift_message" value="'.$p.'"/>';	
		

return $r;
}
add_shortcode('payment_form', 'pippin_stripe_payment_form');
