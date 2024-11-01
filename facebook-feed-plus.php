<?php
/*
Plugin Name: Facebook Feed Plus
Plugin URI: http://www.cheekyapps.com/
Description: Display Facebook Page Feeds using Widgets
Version: 1.0.0
Author: Scott Moses 
Author URI: http://www.cheekyapps.com/
Stable tag: 1.0.0
Text Domain: ca-facebook-feed-plus
Domain Path: /languages
*/


if(!defined('__DIR__')) {
    define( 'CA_FACEBOOK_FEED_PLUS_DIR', plugin_dir_url( __FILE__) );
    define( 'CA_FACEBOOK_FEED_PLUS_PATH', dirname( __FILE__) );
} else {
	define( 'CA_FACEBOOK_FEED_PLUS_DIR', WP_PLUGIN_URL.'/'.basename(__DIR__) );
	define( 'CA_FACEBOOK_FEED_PLUS_PATH', WP_PLUGIN_DIR.'/'.basename(__DIR__) );
}
define( 'CA_FACEBOOK_FEED_PLUS_WP_DIR', get_bloginfo('wpurl') );
define( 'CA_FACEBOOK_FEED_PLUS_PLUGIN_NAME', 'F.B. Feed Plus' );
define( 'CA_FACEBOOK_FEED_PLUS_VERSION', '1.0.0' );
define( 'CA_FACEBOOK_FEED_PLUS_SETTINGS', 'ca_facebook_feed_plus_settings' );


include('includes/functions.php');
include('includes/settings.php');
include('includes/widget.php');

register_activation_hook( __FILE__, 'ca_facebook_feed_plus_install' );
register_deactivation_hook( __FILE__, 'ca_facebook_feed_plus_deactivate' );

?>