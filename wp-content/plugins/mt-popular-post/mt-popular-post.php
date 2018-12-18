<?php
/*
 Plugin Name: MT popular posts
 Plugin Author: Matiullah
 Description: This is my first WP Widget.
 Plugin URI: www.mtplugins.com

*/
class Mt_Popular_Posts extends WP_Widget {

	public function __construct()
	{
		parent::__construct('mt-popular-posts',__('MT Popular Posts','text_domain'));
	}

	public function widget($args,$instance)
	{
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {

			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		echo esc_html__( 'Hello, World!', 'text_domain' );
		echo $args['after_widget'];

	}

	public function form($instance)
	{
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'New title', 'text_domain' );
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php 

	}

	public function update($new_instance, $old_instance)
	{
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';

		return $instance;
	}



}

function register_my_widgets()
{
	register_widget( 'Mt_Popular_Posts' );
}
add_action( 'widgets_init','register_my_widgets', 10, 1 );

 ?>