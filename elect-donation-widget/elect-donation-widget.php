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
		
		$this->WP_Widget( 'donation-widget', __('Donation Widget', 'donation'), $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		// Our variables from the widget settings.
		$title = apply_filters('widget_title', $instance['title'] );
		$name = $instance['name'];
		$show_info = isset( $instance['show_info'] ) ? $instance['show_info'] : false;

		echo $before_widget;

		// Display the widget title 
		if ( $title )
			echo $before_title . $title . $after_title;

		// Display the name 
		if ( $name )
			printf( '<p>' . __('Hey their Sailor! My name is %1$s.', 'donation') . '</p>', $name );

		
		if ( $show_info )
			printf( $name );

		
		echo $after_widget;
	}

	//Update the widget 
	 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		//Strip tags from title and name to remove HTML 
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['name'] = strip_tags( $new_instance['name'] );
		$instance['show_info'] = $new_instance['show_info'];

		return $instance;
	}

	
	function form( $instance ) {

		// Set up some default widget settings.
		$defaults = array( 'title' => __('Donation', 'donation'), 'name' => __('Bilal Shaheen', 'donation'), 'show_info' => true );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input. -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'donation'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<!-- Text Input. -->
		<p>
			<label for="<?php echo $this->get_field_id( 'name' ); ?>"><?php _e('Your Name:', 'donation'); ?></label>
			<input id="<?php echo $this->get_field_id( 'name' ); ?>" name="<?php echo $this->get_field_name( 'name' ); ?>" value="<?php echo $instance['name']; ?>" style="width:100%;" />
		</p>

		
		<!-- Checkbox. -->
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_info'], true ); ?> id="<?php echo $this->get_field_id( 'show_info' ); ?>" name="<?php echo $this->get_field_name( 'show_info' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'show_info' ); ?>"><?php _e('Display info publicly?', 'donation'); ?></label>
		</p>

	<?php
	}
}

?>