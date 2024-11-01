<?php
/*
	* functions.php
*/
add_action( 'plugins_loaded', 'ca_facebook_feed_plus_load_textdomain' );
function ca_facebook_feed_plus_load_textdomain() {
    load_plugin_textdomain( 'ca-facebook-feed-plus', false, dirname( plugin_basename( __DIR__ ) ) . '/languages' );
}

/**
 * Flush rewrite rules for custom post type archive on single activation
 *
 * @since    0.0.1
 * Process Plugin Install
 */
function ca_facebook_feed_plus_install() {
	
}

/*
	* ca_facebook_feed_plus_deactivate
	* Process Plugin deactivation
*/

function ca_facebook_feed_plus_deactivate() {

}