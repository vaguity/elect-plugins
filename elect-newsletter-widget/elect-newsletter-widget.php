<?php
/**
 * Plugin Name: Elect — Newsletter Widget
 * Description: A widget that displays a newsletter signup.
 * Version: 0.1
 * Author: Sean Connolly
 * Author URI: http://sean-connolly.com/
 */

add_action( 'widgets_init', 'newsletter_widget' );

function newsletter_widget() {
	register_widget( 'Newsletter_Widget' );
}

class Newsletter_Widget extends WP_Widget {

	function Newsletter_Widget() {
		$widget_ops = array( 'classname' => 'newsletter', 'description' => __('A widget that displays newsletter information.', 'newsletter') );
		
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'newsletter-widget' );
		
		$this->WP_Widget( 'newsletter-widget', __('Elect — Newsletter Widget', 'newsletter'), $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		// Our variables from the widget settings.
		$title = apply_filters('widget_title', $instance['title'] );
		$content = $instance['content'];
		$url = $instance['url'];
		$button = $instance['button'];

		echo '<div class="elect-newsletter-widget">' . $before_widget;

		// Display the widget title 
		if ($title)
			echo $before_title . $title . $after_title;

		if ($content)
			echo wpautop( $content, true );

		if ($url)
			if ($button) {
				echo '<p class="elect-newsletter-jump"><a href="' . $url . '">' . $button . '</a></p>';
			}
			else {
				echo '<p class="elect-newsletter-jump"><a href="' . $url . '">Subscribe</a></p>';
			}

		echo $after_widget . '</div><!-- .elect-newsletter-widget -->';
	}

	// Update the widget 
	 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		// Strip tags from title and name to remove HTML 
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['content'] = $new_instance['content'];
		$instance['button'] = strip_tags( $new_instance['button'] );
		$instance['url'] = strip_tags( $new_instance['url'] );

		return $instance;
	}
	
	function form( $instance ) {

		// Set up some default widget settings.
		$defaults = array( 'title' => __('', 'newsletter'), 'url' => __('', 'newsletter'), 'content' => __('', 'newsletter'), 'button' => __('', 'newsletter') );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Title: Text input. -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'newsletter'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $instance['title']; ?>">
		</p>

		<!-- Content: Textarea input. -->
		<p>
			<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id( 'content' ); ?>" name="<?php echo $this->get_field_name( 'content' ); ?>"><?php echo $instance['content']; ?></textarea>
		</p>

		<!-- Button title: Text input. -->
		<p>
			<label for="<?php echo $this->get_field_id( 'button' ); ?>"><?php _e('Button Title:', 'newsletter'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'button' ); ?>" name="<?php echo $this->get_field_name( 'button' ); ?>" type="text" value="<?php echo $instance['button']; ?>">
		</p>

		<!-- URL: Text input. -->
		<p>
			<label for="<?php echo $this->get_field_id( 'url' ); ?>"><?php _e('URL:', 'newsletter'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" type="text" value="<?php echo $instance['url']; ?>">
		</p>

	<?php
	}
}

?>