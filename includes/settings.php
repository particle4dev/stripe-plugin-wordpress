<?php
add_filter('admin_head','ShowTinyMCE');
function ShowTinyMCE() {
	// conditions here
	wp_enqueue_script( 'common' );
	wp_enqueue_script( 'jquery-color' );
	wp_print_scripts('editor');
	if (function_exists('add_thickbox')) add_thickbox();
	wp_print_scripts('media-upload');
	if (function_exists('wp_tiny_mce')) wp_tiny_mce( false , // true makes the editor "teeny"
	array(
        
	 ));
	wp_admin_css();
	wp_enqueue_script('utils');
	do_action("admin_print_styles-post-php");
	do_action('admin_print_styles');
}
function pippin_stripe_settings_setup() {
	add_options_page('Stripe Settings', 'Stripe Settings', 'manage_options', 'stripe-settings', 'pippin_stripe_render_options_page');
}
add_action('admin_menu', 'pippin_stripe_settings_setup');
 
function pippin_stripe_render_options_page() {
	global $stripe_options;
	?>
	<div class="wrap">
		<h2><?php _e('Stripe Settings', 'pippin_stripe'); ?></h2>
		


<form method="post" action="options.php">
	<div id="content-explorer">
		<ul class="yui-nav">
			<li class="selected"><a href="#">Stripe Settings</a></li>
			<li><a href="#">Email Settings</a></li>			
			<li><a href="#">Custom Gifts</a></li>
			<li><a href="#">Gift Code Option</a></li>
		</ul>
	
		<div class="metabox-holder" style="width:810px;">
			<p class="submit" style="padding: 0;">
				<input type="submit" class="button-primary" value="<?php _e('Save Options', 'mfwp_domain'); ?>" />
			</p>
		</div>
		
		<div class="yui-content">
			<div style="overflow: visible;"><!-- first div for content tabs -->
				



 
			<?php settings_fields('stripe_settings_group'); ?>
 
				
 
			<h3 class="title"><?php _e('API Keys', 'pippin_stripe'); ?></h3>
			<table class="form-table">
				<tbody>
					<tr valign="top">	
						<th scope="row" valign="top">
							<?php _e('Test Mode', 'pippin_stripe'); ?>
						</th>
						<td>
							<input id="stripe_settings[test_mode]" name="stripe_settings[test_mode]" type="checkbox" value="1" <?php checked(1, $stripe_options['test_mode']); ?> />
							<label class="description" for="stripe_settings[test_mode]"><?php _e('Check this to use the plugin in test mode.', 'pippin_stripe'); ?></label>
						</td>
					</tr>
				</tbody>
			</table>
			<table class="form-table">
				<tbody>
					<tr valign="top">	
						<th scope="row" valign="top">
							<?php _e('Live Secret', 'pippin_stripe'); ?>
						</th>
						<td>
							<input id="stripe_settings[live_secret_key]" name="stripe_settings[live_secret_key]" type="text" class="regular-text" value="<?php echo $stripe_options['live_secret_key']; ?>"/>
							<label class="description" for="stripe_settings[live_secret_key]"><?php _e('Paste your live secret key.', 'pippin_stripe'); ?></label>
						</td>
					</tr>
					<tr valign="top">	
						<th scope="row" valign="top">
							<?php _e('Live Publishable', 'pippin_stripe'); ?>
						</th>
						<td>
							<input id="stripe_settings[live_publishable_key]" name="stripe_settings[live_publishable_key]" type="text" class="regular-text" value="<?php echo $stripe_options['live_publishable_key']; ?>"/>
							<label class="description" for="stripe_settings[live_publishable_key]"><?php _e('Paste your live publishable key.', 'pippin_stripe'); ?></label>
						</td>
					</tr>
					<tr valign="top">	
						<th scope="row" valign="top">
							<?php _e('Test Secret', 'pippin_stripe'); ?>
						</th>
						<td>
							<input id="stripe_settings[test_secret_key]" name="stripe_settings[test_secret_key]" type="text" class="regular-text" value="<?php echo $stripe_options['test_secret_key']; ?>"/>
							<label class="description" for="stripe_settings[test_secret_key]"><?php _e('Paste your test secret key.', 'pippin_stripe'); ?></label>
						</td>
					</tr>
					<tr valign="top">	
						<th scope="row" valign="top">
							<?php _e('Test Publishable', 'pippin_stripe'); ?>
						</th>
						<td>
							<input id="stripe_settings[test_publishable_key]" name="stripe_settings[test_publishable_key]" class="regular-text" type="text" value="<?php echo $stripe_options['test_publishable_key']; ?>"/>
							<label class="description" for="stripe_settings[test_publishable_key]"><?php _e('Paste your test publishable key.', 'pippin_stripe'); ?></label>
						</td>
					</tr>
				</tbody>
			</table>	
 
			
 
		




			</div>
			<div><!-- second div for content tabs -->

 
			<?php settings_fields('stripe_settings_group'); ?>

			<h3 class="title"><?php _e('Email Settings', 'pippin_stripe'); ?></h3>
			<table class="form-table">
				<tbody>
					<tr valign="top">	
						<th scope="row" valign="top">
							<?php _e('Phpmailer', 'pippin_stripe'); ?>
						</th>
						<td>
							<input id="stripe_settings[php_mailer]" name="stripe_settings[php_mailer]" type="checkbox" value="1" <?php checked(1, $stripe_options['php_mailer']); ?> />
							<label class="description" for="stripe_settings[php_mailer]"><?php _e('Check this to use phpmailer library.', 'pippin_stripe'); ?></label>
						</td>
					</tr>
				</tbody>
			</table>
			<fieldset style="border: 1px solid #D4D4D4;width:800px;padding:0px 10px 10px 0px;">
			<legend style=""><h3>Phpmailer Library:</h3></legend>
			<table class="form-table">
				<tbody>
					<tr valign="top">	
						<th scope="row" valign="top">
							Username						</th>
						<td>
							<input id="stripe_settings[email_username]" name="stripe_settings[email_username]" type="text" class="regular-text" value="<?php echo $stripe_options['email_username']; ?>">
							<label class="description" for="stripe_settings[email_username]"><?php _e('Required(ex:"me@gmail.com").', 'pippin_stripe'); ?></label>
						</td>
					</tr>
					<tr valign="top">	
						<th scope="row" valign="top">
							Password						</th>
						<td>
							<input id="stripe_settings[email_password]" name="stripe_settings[email_password]" type="password" class="regular-text" value="<?php echo $stripe_options['email_password']; ?>">
							<label class="description" for="stripe_settings[email_password]"><?php _e('Required(ex:"1234567").', 'pippin_stripe'); ?></label>
						</td>
					</tr>
					<tr valign="top">	
						<th scope="row" valign="top">
							Port						</th>
						<td>
							<input id="stripe_settings[email_port]" name="stripe_settings[email_port]" type="text" class="regular-text" value="<?php echo $v=(isset($stripe_options['email_port']))?$stripe_options['email_port']:"465" ; ?>">
							<label class="description" for="stripe_settings[email_port]"><?php _e('Default :"465".', 'pippin_stripe'); ?></label>
						</td>
					</tr>
					<tr valign="top">	
						<th scope="row" valign="top">
							Host						</th>
						<td>
							<input id="stripe_settings[email_host]" name="stripe_settings[email_host]" class="regular-text" type="text" value="<?php echo $v=(isset($stripe_options['email_host']))?$stripe_options['email_host']:"smtp.gmail.com" ; ?>">
							<label class="description" for="stripe_settings[email_host]"><?php _e('Default :"smtp.gmail.com".', 'pippin_stripe'); ?></label>
						</td>
					</tr>
					<tr valign="top">	
						<th scope="row" valign="top">
							SMTPSecure						</th>
						<td>
							<input id="stripe_settings[email_smtpsecure]" name="stripe_settings[email_smtpsecure]" class="regular-text" type="text" value="<?php echo $v=(isset($stripe_options['email_smtpsecure']))?$stripe_options['email_smtpsecure']:"ssl" ; ?>">
							<label class="description" for="stripe_settings[email_smtpsecure]"><?php _e('Default :"ssl".', 'pippin_stripe'); ?></label>
						</td>
					</tr>
				</tbody>
			</table>
			</fieldset>
			<fieldset style="margin-top:20px;border: 1px solid #D4D4D4;width:800px;padding:0px 10px 10px 0px;">
			<legend style=""><h3>Mail Function:</h3></legend>
			<table class="form-table">
				<tbody>
					<tr valign="top">	
						<th scope="row" valign="top">
							Account						</th>
						<td>
							<input id="stripe_settings[email_account]" name="stripe_settings[email_account]" type="text" class="regular-text" value="<?php echo $stripe_options['email_account']; ?>">
							<label class="description" for="stripe_settings[email_account]"><?php _e('Required(ex:"me@gmail.com").', 'pippin_stripe'); ?></label>
						</td>
					</tr>
					
				</tbody>
			</table>
			</fieldset>

			<fieldset style="margin-top:20px;border: 1px solid #D4D4D4;width:800px;padding:10px;">
				<legend style=""><h3>Edit Mail:</h3></legend>
				<?php the_editor($stripe_options['edit_email_content'],$id = 'stripe_settings[edit_email_content]',array("forced_root_block" => false,
																	 "force_br_newlines" => true,
																	 "force_p_newlines" => false,
																	 // Don't remove line breaks
																	  'remove_linebreaks' => false, 
																	  // Convert newline characters to BR tags
																	  'convert_newlines_to_brs' => true ));?>
			</fieldset>
			</div>
			
			<div>
			<!--
			third div for content tabs
			-->			

			<?php settings_fields('stripe_settings_group'); ?>

			<h3 class="title"><?php _e('Custom Gifts', 'pippin_stripe'); ?></h3>	



			<table class="form-table">
				<tbody>
					<tr valign="top">	
						<th scope="row" valign="top" style="width: 30px;">
							<?php _e('Quantity:', 'pippin_stripe'); ?>
						</th>
						<td>
						<input type="text" name="stripe_settings[gifts_quantity]" value="<?php echo $stripe_options['gifts_quantity'] ;?>"  style="width: 80px;margin:10px;margin-top:0px;"/>
						<label class="description" for="stripe_settings[gifts_quantity]"><?php _e('Gifts', 'pippin_stripe'); ?></label>
						</td>
					</tr>
				</tbody>
			</table>

			<div class="metabox-holder" style="width:100%;clear:both; ">

			<?php for($i=1;$i<=$stripe_options['gifts_quantity'];$i++){?>	

				<div class="postbox" style="width:402px;float:left;margin-right:20px;">
					<h3><span><?php _e('Gift #'.$i.' link:', 'pippin_stripe'); ?></span></h3>
					<h4 style="margin:10px;"><?php _e('Preview:', 'pippin_stripe'); ?></h4>
					<img src="<?php echo $stripe_options['gift'.$i.'_image'] ;?>" style="margin:0 10px;width:380px;height:190px;" />
					<h4 style="margin:10px;"><?php _e('Image Path:', 'pippin_stripe'); ?></h4>
					<input type="text" id="stripe_settings[gift<?php echo $i ?>_image]" class="regular-text" name="stripe_settings[gift<?php echo $i ?>_image]" value="<?php echo $v=(isset($stripe_options['gift'.$i.'_image']))?$stripe_options['gift'.$i.'_image']:"" ; ?>"  style="width: 380px;margin:10px;margin-top:0px;"/>
					<h4 style="margin:10px;"><?php _e('Title:', 'pippin_stripe'); ?></h4>
					<input type="text" name="stripe_settings[gift<?php echo $i ?>_title]" value="<?php echo $stripe_options['gift'.$i.'_title'] ;?>"  style="width: 380px;margin:10px;margin-top:0px;"/>
				</div>
			<?php }?>
	

			</div>

			</div>

			<div>
			<!--
			third div for content tabs
			-->
			<h3 class="title"><?php _e('Gift Code Option', 'pippin_stripe'); ?></h3>
			<table class="form-table">
				<tbody>
					<tr valign="top">	
						<th scope="row" valign="top">
							<?php _e('Code', 'pippin_stripe'); ?>
						</th>
						<td>
							<input id="stripe_settings[gift_code]" name="stripe_settings[gift_code]" type="checkbox" value="1" <?php checked(1, $stripe_options['gift_code']); ?> />
							<label class="description" for="stripe_settings[gift_code]"><?php _e('Check this to generate barcode .', 'pippin_stripe'); ?></label>
						</td>
					</tr>
				</tbody>
			</table>
			<div class="metabox-holder" style="width:100%;clear:both; ">

				

				<div class="postbox" style="width:402px;float:left;margin-right:20px;">
					<h3><span>Captcha:</span></h3>
					<h4 style="margin:10px;">Preview:</h4>
					<img src="http://www.thaiartofmassage.com/wp-content/uploads/2012/12/card-gift1356403937.jpg" style="margin:0 10px;width:380px;height:190px;">
					
				</div>
				

				<div class="postbox" style="width:402px;float:left;margin-right:20px;">
					<h3><span>Barcode:</span></h3>
					<h4 style="margin:10px;">Preview:</h4>
					<img src="http://www.thaiartofmassage.com/wp-content/uploads/2012/12/card-gift1356614961.jpg" style="margin:0 10px;width:380px;height:190px;">
					
				</div>
				

			</div>
			</div>

		</div><!-- #yui-content -->
	</div><!-- #content-explorer -->
</form>




	<script type="text/javascript">
	var myTabs = new YAHOO.widget.TabView("content-explorer");
	</script>

	<?php
}
 
function pippin_stripe_register_settings() {
	// creates our settings in the options table
	register_setting('stripe_settings_group', 'stripe_settings');
}
add_action('admin_init', 'pippin_stripe_register_settings');
