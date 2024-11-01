<?php
/*
	* settings.php
*/

function ca_facebook_feed_plus_register_settings_page() {
	add_menu_page(
		esc_html(sprintf(__( '%s', 'ca-facebook-feed-plus' ), CA_FACEBOOK_FEED_PLUS_PLUGIN_NAME)),
		esc_html(sprintf(__( '%s', 'ca-facebook-feed-plus' ), CA_FACEBOOK_FEED_PLUS_PLUGIN_NAME)),
		'manage_options', 
		'ca_facebook_feed_plus_settings', 
		'ca_facebook_feed_plus_settings_page_callback', 
		''
	);
	add_action( 'admin_init', 'ca_facebook_feed_plus_settings_register_callback' );
	
	add_submenu_page( 
		'ca_facebook_feed_plus_settings',
		esc_html(__( 'Waiting List', 'ca-facebook-feed-plus' )),
		esc_html(__( 'Waiting List', 'ca-facebook-feed-plus' )),
		'manage_options', 
		'ca_facebook_feed_plus_premium',
		'ca_facebook_feed_plus_premium_page_callback'
	);
}
add_action( 'admin_menu', 'ca_facebook_feed_plus_register_settings_page' );


/*
	* ca_facebook_feed_plus_settings_page_callback
	* Callback Page for ca_facebook_feed_plus_settings_page_callback
*/

function ca_facebook_feed_plus_settings_register_callback() {
	//register our settings
	register_setting( 'ca-facebook-feed-plus-settings-group', CA_FACEBOOK_FEED_PLUS_SETTINGS);
}

function ca_facebook_feed_plus_settings_page_callback() { 
	do_action( 'add_meta_boxes' );
	$options = get_option(CA_FACEBOOK_FEED_PLUS_SETTINGS);
	wp_enqueue_style( 'ca-facebook-feed-plus-style', CA_FACEBOOK_FEED_PLUS_DIR.'/includes/css/ca-facebook-feed-plus.css', '', CA_FACEBOOK_FEED_PLUS_VERSION, 'all' );
	?>
	<div id="poststuff" class="ca_facebook_feed_plus_wrapper">
		<h2 class="page_title"><?php esc_html(printf(__( '%s Settings', 'ca-facebook-feed-plus' ), CA_FACEBOOK_FEED_PLUS_PLUGIN_NAME)); ?></h2>
		<form id="ca_facebook_feed_plus_form" class="ca_facebook_feed_plus_form" action="options.php" method='post'>
			<?php settings_fields( 'ca-facebook-feed-plus-settings-group' ); ?>
			<?php do_settings_sections( 'ca-facebook-feed-plus-settings-group' ); ?>
			
			<div class="form_field">
				<label for="ca_facebook_feed_plus_form_api_id"><?php esc_html(_e( 'Facebook API ID', 'ca-facebook-feed-plus' )); ?>: </label>
				<input type="text" name="<?php print CA_FACEBOOK_FEED_PLUS_SETTINGS; ?>[api_id]" id="ca_facebook_feed_plus_form_api_id" value="<?php print (isset($options['api_id']) ? $options['api_id'] : '503595753002055'); ?>" />
				<p class="description"><?php esc_html(_e( 'Enter your Facebook App ID.', 'ca-facebook-feed-plus' )); ?></p>
			</div>
			
			<div class="form_field">
				<label for="ca_facebook_feed_plus_form_lang"><?php esc_html(_e( 'Feed Language', 'ca-facebook-feed-plus' )); ?>: </label>
				<input type="text" name="<?php print CA_FACEBOOK_FEED_PLUS_SETTINGS; ?>[lang]" id="ca_facebook_feed_plus_form_lang" value="<?php print (isset($options['lang']) ? $options['lang'] : 'en_US'); ?>" />
				<p class="description"><a target="_blank" href="https://www.facebook.com/translations/FacebookLocales.xml"><?php esc_html(_e( 'Check Facebook supported languages.', 'ca-facebook-feed-plus' )); ?></a></p>
			</div>
			
			
				<!-- Feature currently planned for v1.1 -->
			<div class="form_field">
				<label for="ca_facebook_feed_plus_form_add_animation"><input <?php print (isset($options['add_animation']) ? 'checked' : ''); ?> type="checkbox" name="<?php print CA_FACEBOOK_FEED_PLUS_SETTINGS; ?>[add_animation]" id="ca_facebook_feed_plus_form_add_animation" /> <?php esc_html(_e( 'Enable', 'ca-facebook-feed-plus' )); ?></label>
				<p class="description"><?php esc_html(_e( 'In v1.1, you will be able to add animation to your FB Feed.Please get on our waiting list to be updated about this feature.', 'ca-facebook-feed-plus' )); ?></p>
			</div>
			
			<div class="form_field">
				<?php $animate_to =  (isset($options['animate_to']) ? $options['animate_to'] : 'left'); ?>
				<label for="ca_facebook_feed_plus_form_animate_to"><?php esc_html(_e( 'Expand to', 'ca-facebook-feed-plus' )); ?>: </label> 
				<select name="<?php print CA_FACEBOOK_FEED_PLUS_SETTINGS; ?>[animate_to]" id="ca_facebook_feed_plus_form_animate_to">
					<option <?php print ($animate_to == 'left' ? 'selected' : ''); ?> value="left"><?php esc_html(_e( 'Left', 'ca-facebook-feed-plus' )); ?></option>
					<option <?php print ($animate_to == 'right' ? 'selected' : ''); ?>  value="right"><?php esc_html(_e( 'Right', 'ca-facebook-feed-plus' )); ?></option>
					<option <?php print ($animate_to == 'top' ? 'selected' : ''); ?> value="top"><?php esc_html(_e( 'Top', 'ca-facebook-feed-plus' )); ?></option>
					<option <?php print ($animate_to == 'bottom' ? 'selected' : ''); ?> value="bottom"><?php esc_html(_e( 'bottom', 'ca-facebook-feed-plus' )); ?></option>
				</select>
				<p class="description"><?php esc_html(_e( 'Select where you want the animation to happen. This feature will be in v1.1, please join our mailing list to be updated about this feature.', 'ca-facebook-feed-plus' )); ?></p>
			</div>
			
			<?php submit_button( esc_html(__('Save Settings', 'ca-facebook-feed-plus')), 'primary', 'pm_push_notifications_submit', false, array('id' => 'ca_facebook_feed_plus_submit') ); ?>
		</form>
		<?php do_meta_boxes( 'ca_facebook_feed_plus_settings', 'side', null); ?>
		<div class="clear"></div>
		<div class="full_width_banner">
			<!-- <a target="_blank" href="http://www.cheekyapps.com/easy-to-tweet-waiting-list/"><img src="<?php print CA_FACEBOOK_FEED_PLUS_DIR.'includes/images/banner.jpg';?>" width="900" /></a> -->
		</div>
	</div>
<?php
}

/*
	Add Settings Meta Box
*/

function ca_facebook_feed_plus_register_meta_boxes() {
	add_meta_box( 
		'ca-facebook-feed-plus-settings-meta-box', 
		__( 'Want Cooler Options?', 'ca-facebook-feed-plus' ), 
		'ca_facebook_feed_plus_settings_meta_box_callback', 
		'ca_facebook_feed_plus_settings', 
		'side' );
}
add_action( 'add_meta_boxes', 'ca_facebook_feed_plus_register_meta_boxes' );	

function ca_facebook_feed_plus_settings_meta_box_callback() {
	?>
	<h3 class="text"><?php __( 'Upgrade to Pro and get more Traffic to Your Site!', 'ca-facebook-feed-plus' ); ?></h3>
		<div class="meta-box-banner">
			<a target="_blank" href="http://www.cheekyapps.com/easy-to-tweet-waiting-list/"></a>
		</div>
		<ul>	
			<li><div class="dashicons dashicons-yes"></div> <?php _e( 'More Gorgeous Designs' ); ?></li>
			<li><div class="dashicons dashicons-yes"></div> <?php _e( 'Priority Email Support' ); ?></li>
			<li><div class="dashicons dashicons-yes"></div> <?php _e( 'Access to more cool functions' ); ?></li>
			<li><div class="dashicons dashicons-yes"></div> <?php _e( 'And much more...' ); ?></li>			
		</ul>
		
		<p style="text-align: center;">
			<a class="button button-primary button-large" target="_blank" href="http://www.cheekyapps.com/easy-to-tweet-waiting-list/">Get On The Waiting List</a>
		</p>
	<?php
}

/*
	* ca_facebook_feed_plus_premium_page_callback
*/
function ca_facebook_feed_plus_upgrade_to_premium_menu_js() {
?>
<script type="text/javascript">
	jQuery(document).ready(function ($) {
		jQuery('a[href="admin.php?page=ca_facebook_feed_plus_premium"]')
		.addClass('ca_facebook_feed_plus_premium')
		.attr('target', '_blank')
		.attr('href','http://www.cheekyapps.com/easy-to-tweet-waiting-list/');
	});
</script>
<style>
a.ca_facebook_feed_plus_premium {
	color: #6bbc5b !important;
}
a.ca_facebook_feed_plus_premium:hover {
	color: #7ad368 !important;
}
</style>
<?php 
}
add_action( 'admin_footer', 'ca_facebook_feed_plus_upgrade_to_premium_menu_js');