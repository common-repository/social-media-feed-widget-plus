<?php
/*
	* Widget
	* CaFacebookFeedsPlus
*/


class CaFacebookFeedsPlus extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'ca_facebook_feed_plus_widget', // Base ID
			esc_html(sprintf(__( '%s', 'ca-facebook-feed-plus' ), CA_FACEBOOK_FEED_PLUS_PLUGIN_NAME)), // Name
			array( 'description' => __( 'Shows the user progress', 'ca-facebook-feed-plus' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		wp_register_script( 'script-ca-facebook-feed-plus', CA_FACEBOOK_FEED_PLUS_DIR.'includes/js/ca-facebook-feed-plus.js' , array('jquery'));
        wp_enqueue_script( 'script-ca-facebook-feed-plus' );
		$options = get_option(CA_FACEBOOK_FEED_PLUS_SETTINGS);
		$app_id = (isset($options['api_id']) ? $options['api_id'] : '503595753002055');
		$lang = (isset($options['lang']) ? $options['lang'] : 'en_US');
        $local_variables    =   array('app_id' => $app_id, 'lang' => $lang);
        wp_localize_script( 'script-ca-facebook-feed-plus', 'vars', $local_variables );
		$link = isset( $instance['link'] ) ? $instance['link'] : __( '', 'ca-facebook-feed-plus' );
		$tabs_array = array();
		$tabs = '';
		$tab_timeline =   (isset( $instance['tab_timeline'] ) && !empty($instance['tab_timeline']) ? $tabs_array[] = 'timeline' : '');
		$tab_messages = (isset( $instance['tab_messages'] ) && !empty($instance['tab_messages'])   ? $tabs_array[] = 'messages' : '');
		$tab_events = (isset( $instance['tab_events'] ) && !empty($instance['tab_events']) ? $tabs_array[] = 'events' : '');
		foreach($tabs_array as $tab) {
			$tabs .= ' '.$tab;
		}
		$tabs = trim($tabs);
		$tabs = str_replace(" ", ", ", $tabs);
		$width = isset( $instance['width'] ) ? $instance['width'] : '300';
		$height = isset( $instance['height'] ) ? $instance['height'] : '400';

		$data_small_header = (isset( $instance['data_small_header'] ) && !empty($instance['data_small_header']) ? 'true' : 'false');
		$data_show_cover_photo = (isset( $instance['data_show_cover_photo'] ) && !empty($instance['data_show_cover_photo']) ? 'true' : 'false');
		$data_adopt_container = (isset( $instance['data_adopt_container'] ) && !empty($instance['data_adopt_container']) ? 'true' : 'false');
		$data_show_friends = (isset( $instance['data_show_friends'] )  && !empty($instance['data_show_friends']) ? 'true' : 'false');
		$output = '';
		$output .= '<div id="fb-root"></div>';
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}

		$output .= "
		<div class='fb-page' 
		data-href='{$link}' 
		data-tabs='{$tabs}' 
		data-width='{$width}' 
		data-height='{$height}' 
		data-small-header='{$data_small_header}' 
		data-adapt-container-width='{$data_adopt_container}' 
		data-hide-cover='{$data_show_cover_photo}' 
		data-show-facepile='{$data_show_friends}'>
			<div class='fb-xfbml-parse-ignore'>
				
			</div>
		</div>";
		
		echo $output;
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'New title', 'ca-facebook-feed-plus' );
		$link = ! empty( $instance['link'] ) ? $instance['link'] : __( '', 'ca-facebook-feed-plus' );
		$tab_timeline =   ! empty( $instance['tab_timeline'] ) ? $instance['tab_timeline'] : 'on';
		$tab_messages = ! empty( $instance['tab_messages'] ) ? $instance['tab_messages'] : 'on';
		$tab_events = ! empty( $instance['tab_events'] ) ? $instance['tab_events'] : 'on';
		$width = ! empty( $instance['width'] ) ? $instance['width'] : '300';
		$height = ! empty( $instance['height'] ) ? $instance['height'] : '400';
		
		$data_small_header = ! empty( $instance['data_small_header'] ) ? $instance['data_small_header'] : 'on';
		$data_show_cover_photo = ! empty( $instance['data_show_cover_photo'] ) ? $instance['data_show_cover_photo'] : 'on';
		$data_adopt_container = ! empty( $instance['data_adopt_container'] ) ? $instance['data_adopt_container'] : 'on';
		$data_show_friends = ! empty( $instance['data_show_friends'] ) ? $instance['data_show_friends'] : 'on';
		
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html(_e( 'Title:','ca-facebook-feed-plus' )); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php esc_html(_e( 'Facebook Page Link:','ca-facebook-feed-plus' )); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>">
			<small>
                <?php esc_html(_e( 'Enter Facebook Page link only:','ca-facebook-feed-plus' )); ?>
                <a href="http://www.facebook.com/help/?faq=174987089221178" target="_blank">
                    <?php esc_html(_e( 'Facebook valid pages.:','ca-facebook-feed-plus' )); ?>
                </a>
            </small>
		</p>
		<p>
			<small>
                <?php esc_html(_e( 'Select which Tab you want to display.','ca-facebook-feed-plus' )); ?>
            </small><br />
            <input class="checkbox" type="checkbox" <?php checked($tab_timeline, "on") ?> id="<?php echo $this->get_field_id('tab_timeline'); ?>" name="<?php echo $this->get_field_name('tab_timeline'); ?>" value="on" />
            <label for="<?php echo $this->get_field_id('tab_timeline'); ?>"><?php esc_html(_e( 'Timeline','ca-facebook-feed-plus' )); ?></label>
			
			<input class="checkbox" type="checkbox" <?php checked($tab_messages, "on") ?> id="<?php echo $this->get_field_id('tab_messages'); ?>" name="<?php echo $this->get_field_name('tab_messages'); ?>" />
			<label for="<?php echo $this->get_field_id('tab_messages'); ?>"><?php esc_html(_e( 'Messages','ca-facebook-feed-plus' )); ?></label>
			
			<input class="checkbox" type="checkbox" <?php checked($tab_events, "on") ?> id="<?php echo $this->get_field_id('tab_events'); ?>" name="<?php echo $this->get_field_name('tab_events'); ?>" />
			<label for="<?php echo $this->get_field_id('tab_events'); ?>"><?php esc_html(_e( 'Events','ca-facebook-feed-plus' )); ?></label>
        </p>
		<p>
			<label for="<?php echo $this->get_field_id( 'width' ); ?>"><?php esc_html(_e( 'Width:','ca-facebook-feed-plus' )); ?></label> 
			<input size="5" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" type="text" value="<?php echo esc_attr( $width ); ?>">
			
			<label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php esc_html(_e( 'Height:','ca-facebook-feed-plus' )); ?></label> 
			<input size="5" id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" type="text" value="<?php echo esc_attr( $height ); ?>">
			<br /><small>
                <?php esc_html(_e( 'width: 180px - 500px, height: 70px min','ca-facebook-feed-plus' )); ?>
            </small>
		</p>
		
		<p>
            <input class="checkbox" type="checkbox" <?php checked($data_small_header, "on") ?> id="<?php echo $this->get_field_id('data_small_header'); ?>" name="<?php echo $this->get_field_name('data_small_header'); ?>" />
            <label for="<?php echo $this->get_field_id('data_small_header'); ?>"><?php esc_html(_e( 'Use Small Header','ca-facebook-feed-plus' )); ?></label>
        </p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked($data_show_cover_photo, "on") ?> id="<?php echo $this->get_field_id('data_show_cover_photo'); ?>" name="<?php echo $this->get_field_name('data_show_cover_photo'); ?>" />
			<label for="<?php echo $this->get_field_id('data_show_cover_photo'); ?>"><?php esc_html(_e( 'Hide Cover Photo','ca-facebook-feed-plus' )); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked($data_adopt_container, "on") ?> id="<?php echo $this->get_field_id('data_adopt_container'); ?>" name="<?php echo $this->get_field_name('data_adopt_container'); ?>" />
			<label for="<?php echo $this->get_field_id('data_adopt_container'); ?>"><?php esc_html(_e( 'Adapt to plugin container width','ca-facebook-feed-plus' )); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked($data_show_friends, "on") ?> id="<?php echo $this->get_field_id('data_show_friends'); ?>" name="<?php echo $this->get_field_name('data_show_friends'); ?>" />
			<label for="<?php echo $this->get_field_id('data_show_friends'); ?>"><?php esc_html(_e( 'Show Friend\'s Faces','ca-facebook-feed-plus' )); ?></label>
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['link'] = ( ! empty( $new_instance['link'] ) ) ? strip_tags( $new_instance['link'] ) : '';
		$instance['tab_timeline'] = ( ! empty( $new_instance['tab_timeline'] ) ) ? strip_tags( $new_instance['tab_timeline'] ) : '';
		$instance['tab_messages'] = ( ! empty( $new_instance['tab_messages'] ) ) ? strip_tags( $new_instance['tab_messages'] ) : '';
		$instance['tab_events'] = ( ! empty( $new_instance['tab_events'] ) ) ? strip_tags( $new_instance['tab_events'] ) : '';
		$instance['width'] = ( ! empty( $new_instance['width'] ) ) ? strip_tags( $new_instance['width'] ) : '';
		$instance['height'] = ( ! empty( $new_instance['height'] ) ) ? strip_tags( $new_instance['height'] ) : '';
		$instance['data_small_header'] = ( ! empty( $new_instance['data_small_header'] ) ) ? strip_tags( $new_instance['data_small_header'] ) : '';
		$instance['data_show_cover_photo'] = ( ! empty( $new_instance['data_show_cover_photo'] ) ) ? strip_tags( $new_instance['data_show_cover_photo'] ) : '';
		$instance['data_adopt_container'] = ( ! empty( $new_instance['data_adopt_container'] ) ) ? strip_tags( $new_instance['data_adopt_container'] ) : '';
		$instance['data_show_friends'] = ( ! empty( $new_instance['data_show_friends'] ) ) ? strip_tags( $new_instance['data_show_friends'] ) : '';
		
		return $instance;
	}

}

function ca_facebook_feed_plus_register_widget() {
    register_widget( 'CaFacebookFeedsPlus' );
}
add_action( 'widgets_init', 'ca_facebook_feed_plus_register_widget' );