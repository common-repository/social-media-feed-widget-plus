<?php //if uninstall not called from WordPress exit
if ( ! defined( 'ABSPATH' ) || ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {    exit();	delete_option('ca_facebook_feed_plus_settings');}
