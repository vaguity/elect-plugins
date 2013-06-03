<?php
/**
 * Plugin Name: Elect — Donation Widget
 * Description: A widget that displays donation information.
 * Version: 0.1
 * Author: Sean Connolly
 * Author URI: http://sean-connolly.com/
 */

add_action( 'widgets_init', 'donation_widget' );

function donation_widget() {
	register_widget( 'Donation_Widget' );
}

class Donation_Widget extends WP_Widget {

	function Donation_Widget() {
		$widget_ops = array( 'classname' => 'donation', 'description' => __('A widget that displays donation information.', 'donation') );
		
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'donation-widget' );
		
		$this->WP_Widget( 'donation-widget', __('Elect — Donation Widget', 'donation'), $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		// Our variables from the widget settings.
		$title = apply_filters('widget_title', $instance['title'] );
		$content = $instance['content'];
		$url = $instance['url'];

		echo $before_widget;

		// Display the widget title 
		if ( $title )
			echo $before_title . $title . $after_title;

		if ( $content )
			echo nl2br( $content );

		if ( $url )
			echo '<p><a href="' . $url . '">Donate</a></p>';

		echo $after_widget;
	}

	// Update the widget 
	 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		// Strip tags from title and name to remove HTML 
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['content'] = $new_instance['content'];
		$instance['url'] = strip_tags( $new_instance['url'] );

		return $instance;
	}
	
	function form( $instance ) {

		// Set up some default widget settings.
		$defaults = array( 'title' => __('', 'donation'), 'url' => __('', 'donation'), 'content' => __('', 'donation') );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Title: Text input. -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'donation'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $instance['title']; ?>">
		</p>

		<!-- Content: Textarea input. -->
		<p>
			<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id( 'content' ); ?>" name="<?php echo $this->get_field_name( 'content' ); ?>"><?php echo $instance['content']; ?></textarea>
		</p>

		<!-- URL: Text input. -->
		<p>
			<label for="<?php echo $this->get_field_id( 'url' ); ?>"><?php _e('URL:', 'donation'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" type="text" value="<?php echo $instance['url']; ?>">
		</p>

	<?php
	}
}

?>