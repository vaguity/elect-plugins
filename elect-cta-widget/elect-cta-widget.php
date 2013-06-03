<?php
/**
 * Plugin Name: Elect — CTA Widget
 * Description: A widget that displays a generic call-to-action.
 * Version: 0.1
 * Author: Sean Connolly
 * Author URI: http://sean-connolly.com/
 */

add_action( 'widgets_init', 'cta_widget' );

function cta_widget() {
	register_widget( 'CTA_Widget' );
}

class CTA_Widget extends WP_Widget {

	function CTA_Widget() {
		$widget_ops = array( 'classname' => 'cta', 'description' => __('A widget that displays cta information.', 'cta') );
		
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'cta-widget' );
		
		$this->WP_Widget( 'cta-widget', __('Elect — CTA Widget', 'cta'), $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		// Our variables from the widget settings.
		$title = apply_filters('widget_title', $instance['title'] );
		$content = $instance['content'];

		echo $before_widget;

		// Display the widget title 
		if ( $title )
			echo $before_title . $title . $after_title;
		
		// Display the content
		if ( $content )
			echo nl2br( $content ) ;
		
		echo $after_widget;
	}

	// Update the widget 
	 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		// Strip tags from title to remove HTML 
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['content'] = $new_instance['content'];

		return $instance;
	}
	
	function form( $instance ) {

		// Set up some default widget settings.
		$defaults = array( 'title' => __('', 'cta'), 'content' => __('', 'cta') );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Title: Text input. -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'cta'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $instance['title']; ?>">
		</p>

		<!-- Content: Textarea input. -->
		<p>
			<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id( 'content' ); ?>" name="<?php echo $this->get_field_name( 'content' ); ?>"><?php echo $instance['content']; ?></textarea>
		</p>

	<?php
	}
}

?>