<?php
/*
Plugin Name: WordPress Stripe Thai
Plugin URI: 
Description: particles4dev@gmail.com
Author: Le Thanh
Author URI: 
COntributors: 
Version: 1.1
*/
 
/**********************************
* constants and globals
**********************************/
 
if(!defined('STRIPE_BASE_URL')) {
	define('STRIPE_BASE_URL', plugin_dir_url(__FILE__));
}
if(!defined('STRIPE_BASE_DIR')) {
	define('STRIPE_BASE_DIR', dirname(__FILE__));
}
 
$stripe_options = get_option('stripe_settings');
 
/*******************************************
* plugin text domain for translations
*******************************************/
 
load_plugin_textdomain( 'pippin_stripe', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
 
/**********************************
* includes
**********************************/
 
if(is_admin()) {
	// load admin includes
	include(STRIPE_BASE_DIR . '/includes/settings.php');
} else {
	// load front-end includes
	include(STRIPE_BASE_DIR . '/includes/scripts.php');
	include(STRIPE_BASE_DIR . '/includes/shortcodes.php');
	include(STRIPE_BASE_DIR . '/includes/process-payment.php');	
}